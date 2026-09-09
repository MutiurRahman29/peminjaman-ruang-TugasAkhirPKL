<?php

namespace Tests\Feature;

use App\Enums\StatusPeminjaman;
use App\Enums\StatusRuangan;
use App\Models\Peminjaman;
use App\Models\Ruangan;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PeminjamanTest extends TestCase
{
    use RefreshDatabase;

    public function test_testing_uses_the_jakarta_application_timezone(): void
    {
        $this->assertSame('Asia/Jakarta', config('app.timezone'));
        $this->assertSame('Asia/Jakarta', date_default_timezone_get());
    }

    public function test_guest_cannot_open_borrower_loan_routes(): void
    {
        $this->get(route('peminjam.peminjaman.index'))->assertRedirect(route('login'));
        $this->get(route('peminjam.peminjaman.create'))->assertRedirect(route('login'));
    }

    public function test_admin_and_staff_cannot_open_borrower_loan_routes(): void
    {
        foreach ([User::factory()->admin()->create(), User::factory()->petugas()->create()] as $user) {
            $this->actingAs($user)
                ->get(route('peminjam.peminjaman.index'))
                ->assertForbidden();
        }
    }

    public function test_borrower_can_open_the_request_form_and_only_available_rooms_are_listed(): void
    {
        $tersedia = Ruangan::factory()->create([
            'nama_ruangan' => 'Ruang Tersedia',
            'status' => StatusRuangan::Tersedia,
        ]);
        $digunakan = Ruangan::factory()->create([
            'nama_ruangan' => 'Ruang Digunakan',
            'status' => StatusRuangan::Digunakan,
        ]);

        $this->actingAs(User::factory()->peminjam()->create())
            ->get(route('peminjam.peminjaman.create'))
            ->assertOk()
            ->assertSee($tersedia->nama_ruangan)
            ->assertDontSee($digunakan->nama_ruangan);
    }

    public function test_valid_request_uses_authenticated_user_and_pending_status(): void
    {
        $user = User::factory()->peminjam()->create();
        $otherUser = User::factory()->peminjam()->create();
        $ruangan = Ruangan::factory()->create();

        $this->actingAs($user)
            ->post(route('peminjam.peminjaman.store'), $this->validPayload($ruangan) + [
                'id_user' => $otherUser->id_user,
                'status' => StatusPeminjaman::Disetujui->value,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('peminjaman', [
            'id_user' => $user->id_user,
            'id_ruangan' => $ruangan->id_ruangan,
            'status' => StatusPeminjaman::Menunggu->value,
        ]);
        $this->assertDatabaseCount('detail_peminjaman', 0);
    }

    public function test_past_dates_are_rejected(): void
    {
        $this->actingAs(User::factory()->peminjam()->create())
            ->from(route('peminjam.peminjaman.create'))
            ->post(route('peminjam.peminjaman.store'), $this->validPayload(Ruangan::factory()->create(), [
                'tanggal' => now(config('app.timezone'))->subDay()->toDateString(),
            ]))
            ->assertRedirect(route('peminjam.peminjaman.create'))
            ->assertSessionHasErrors([
                'tanggal' => 'Tanggal harus hari ini atau setelahnya.',
            ]);
    }

    public function test_today_schedule_that_has_started_is_rejected(): void
    {
        $this->travelTo(CarbonImmutable::parse('2026-09-09 10:00:00', config('app.timezone')));

        $this->actingAs(User::factory()->peminjam()->create())
            ->from(route('peminjam.peminjaman.create'))
            ->post(route('peminjam.peminjaman.store'), $this->validPayload(Ruangan::factory()->create(), [
                'tanggal' => '2026-09-09',
                'jam_mulai' => '09:00',
                'jam_selesai' => '11:00',
            ]))
            ->assertRedirect(route('peminjam.peminjaman.create'))
            ->assertSessionHasErrors([
                'jam_mulai' => 'Jam mulai harus setelah waktu saat ini.',
            ]);

        $this->assertDatabaseCount('peminjaman', 0);
    }

    public function test_end_time_must_be_later_than_start_time(): void
    {
        $user = User::factory()->peminjam()->create();
        $ruangan = Ruangan::factory()->create();

        $this->actingAs($user)
            ->from(route('peminjam.peminjaman.create'))
            ->post(route('peminjam.peminjaman.store'), $this->validPayload($ruangan, [
                'jam_mulai' => '09:00',
                'jam_selesai' => '09:00',
            ]))
            ->assertSessionHasErrors([
                'jam_selesai' => 'Jam selesai harus setelah jam mulai.',
            ]);

        $this->from(route('peminjam.peminjaman.create'))
            ->post(route('peminjam.peminjaman.store'), $this->validPayload($ruangan, [
                'jam_mulai' => '09:00',
                'jam_selesai' => '08:30',
            ]))
            ->assertSessionHasErrors('jam_selesai');
    }

    public function test_invalid_or_unavailable_rooms_are_rejected(): void
    {
        $user = User::factory()->peminjam()->create();
        $digunakan = Ruangan::factory()->create(['status' => StatusRuangan::Digunakan]);

        $this->actingAs($user)
            ->from(route('peminjam.peminjaman.create'))
            ->post(route('peminjam.peminjaman.store'), $this->validPayload($digunakan))
            ->assertSessionHasErrors([
                'id_ruangan' => 'Ruangan yang dipilih tidak valid atau tidak tersedia.',
            ]);

        $this->from(route('peminjam.peminjaman.create'))
            ->post(route('peminjam.peminjaman.store'), $this->validPayload($digunakan, [
                'id_ruangan' => 99999,
            ]))
            ->assertSessionHasErrors('id_ruangan');
    }

    public function test_overlapping_approved_loan_is_rejected(): void
    {
        $ruangan = Ruangan::factory()->create();
        $this->createExistingLoan($ruangan, StatusPeminjaman::Disetujui);

        $this->actingAs(User::factory()->peminjam()->create())
            ->from(route('peminjam.peminjaman.create'))
            ->post(route('peminjam.peminjaman.store'), $this->validPayload($ruangan, [
                'jam_mulai' => '09:30',
                'jam_selesai' => '10:30',
            ]))
            ->assertSessionHasErrors('id_ruangan');
    }

    public function test_a_request_can_start_when_an_approved_loan_ends(): void
    {
        $ruangan = Ruangan::factory()->create();
        $this->createExistingLoan($ruangan, StatusPeminjaman::Disetujui);

        $this->actingAs(User::factory()->peminjam()->create())
            ->post(route('peminjam.peminjaman.store'), $this->validPayload($ruangan, [
                'jam_mulai' => '10:00',
                'jam_selesai' => '11:00',
            ]))
            ->assertRedirect();

        $this->assertDatabaseCount('peminjaman', 2);
    }

    public function test_pending_loan_does_not_block_a_new_request(): void
    {
        $ruangan = Ruangan::factory()->create();
        $this->createExistingLoan($ruangan, StatusPeminjaman::Menunggu);

        $this->actingAs(User::factory()->peminjam()->create())
            ->post(route('peminjam.peminjaman.store'), $this->validPayload($ruangan, [
                'jam_mulai' => '09:30',
                'jam_selesai' => '10:30',
            ]))
            ->assertRedirect();

        $this->assertDatabaseCount('peminjaman', 2);
    }

    public function test_index_only_displays_loans_owned_by_the_authenticated_user(): void
    {
        $user = User::factory()->peminjam()->create();
        $own = Peminjaman::factory()->create([
            'id_user' => $user->id_user,
            'keperluan' => 'Keperluan milik saya',
        ]);
        $other = Peminjaman::factory()->create([
            'keperluan' => 'Keperluan milik pengguna lain',
        ]);

        $this->actingAs($user)
            ->get(route('peminjam.peminjaman.index'))
            ->assertOk()
            ->assertSee($own->keperluan)
            ->assertDontSee($other->keperluan);
    }

    public function test_user_can_view_their_own_loan_detail(): void
    {
        $user = User::factory()->peminjam()->create();
        $peminjaman = Peminjaman::factory()->create([
            'id_user' => $user->id_user,
            'keperluan' => 'Detail milik saya',
        ]);

        $this->actingAs($user)
            ->get(route('peminjam.peminjaman.show', $peminjaman))
            ->assertOk()
            ->assertSee('Detail milik saya');
    }

    public function test_user_cannot_view_another_users_loan_detail(): void
    {
        $peminjaman = Peminjaman::factory()->create();

        $this->actingAs(User::factory()->peminjam()->create())
            ->get(route('peminjam.peminjaman.show', $peminjaman))
            ->assertForbidden();
    }

    public function test_empty_purpose_is_rejected_by_server_validation(): void
    {
        $this->actingAs(User::factory()->peminjam()->create())
            ->from(route('peminjam.peminjaman.create'))
            ->post(route('peminjam.peminjaman.store'), $this->validPayload(Ruangan::factory()->create(), [
                'keperluan' => '',
            ]))
            ->assertSessionHasErrors([
                'keperluan' => 'Keperluan wajib diisi.',
            ]);
    }

    public function test_history_and_detail_display_times_without_seconds(): void
    {
        $user = User::factory()->peminjam()->create();
        $peminjaman = Peminjaman::factory()->create([
            'id_user' => $user->id_user,
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '10:00:00',
        ]);

        $this->actingAs($user)
            ->get(route('peminjam.peminjaman.index'))
            ->assertOk()
            ->assertSee('08:00–10:00')
            ->assertDontSee('08:00:00');

        $this->get(route('peminjam.peminjaman.show', $peminjaman))
            ->assertOk()
            ->assertSee('08:00–10:00')
            ->assertDontSee('10:00:00');
    }

    public function test_validation_error_is_only_displayed_once_in_the_form(): void
    {
        $response = $this->actingAs(User::factory()->peminjam()->create())
            ->followingRedirects()
            ->from(route('peminjam.peminjaman.create'))
            ->post(route('peminjam.peminjaman.store'), $this->validPayload(Ruangan::factory()->create(), [
                'keperluan' => '',
            ]));

        $response->assertOk();
        $this->assertSame(1, substr_count($response->getContent(), 'Keperluan wajib diisi.'));
    }

    /**
     * Get a valid loan request payload.
     *
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function validPayload(Ruangan $ruangan, array $overrides = []): array
    {
        return [
            'id_ruangan' => $ruangan->id_ruangan,
            'tanggal' => now(config('app.timezone'))->addDay()->toDateString(),
            'jam_mulai' => '08:00',
            'jam_selesai' => '09:00',
            'keperluan' => 'Rapat pengembangan aplikasi',
            ...$overrides,
        ];
    }

    /**
     * Create a loan fixture with a DATE value that mirrors the MySQL column.
     */
    private function createExistingLoan(Ruangan $ruangan, StatusPeminjaman $status): Peminjaman
    {
        $peminjaman = Peminjaman::factory()->create([
            'id_ruangan' => $ruangan->id_ruangan,
            'tanggal' => now(config('app.timezone'))->addDay()->toDateString(),
            'jam_mulai' => '09:00',
            'jam_selesai' => '10:00',
            'status' => $status,
        ]);

        DB::table('peminjaman')
            ->where('id_peminjaman', $peminjaman->id_peminjaman)
            ->update(['tanggal' => now(config('app.timezone'))->addDay()->toDateString()]);

        return $peminjaman;
    }
}
