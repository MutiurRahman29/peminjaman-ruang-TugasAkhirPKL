<?php

namespace Tests\Feature;

use App\Enums\StatusPeminjaman;
use App\Models\Fasilitas;
use App\Models\Peminjaman;
use App\Models\Ruangan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminPeminjamanReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_admin_report_routes(): void
    {
        $peminjaman = $this->createLoan();

        $this->get(route('admin.peminjaman.index'))->assertRedirect(route('login'));
        $this->get(route('admin.peminjaman.show', $peminjaman))->assertRedirect(route('login'));
    }

    public function test_staff_and_borrower_are_forbidden_from_admin_report_routes(): void
    {
        $peminjaman = $this->createLoan();

        foreach ([User::factory()->petugas()->create(), User::factory()->peminjam()->create()] as $user) {
            $this->actingAs($user)
                ->get(route('admin.peminjaman.index'))
                ->assertForbidden();

            $this->get(route('admin.peminjaman.show', $peminjaman))
                ->assertForbidden();
        }
    }

    public function test_admin_can_view_ordered_report_and_read_only_detail_with_or_without_facilities(): void
    {
        $fasilitas = Fasilitas::factory()->create(['nama_fasilitas' => 'Proyektor']);
        $lama = $this->createLoan(
            tanggal: '2026-01-10',
            jamMulai: '08:00',
            keperluan: 'Peminjaman Lama',
        );
        $terbaru = $this->createLoan(
            tanggal: '2026-01-11',
            jamMulai: '09:00',
            keperluan: 'Peminjaman Terbaru',
            fasilitas: [$fasilitas->id_fasilitas => 2],
        );
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.peminjaman.index'))
            ->assertOk()
            ->assertSeeInOrder([$terbaru->keperluan, $lama->keperluan])
            ->assertDontSee('Setujui')
            ->assertDontSee('Tolak')
            ->assertDontSee('Tandai Selesai');

        $this->get(route('admin.peminjaman.show', $terbaru))
            ->assertOk()
            ->assertSee('Proyektor: 2')
            ->assertDontSee('Setujui')
            ->assertDontSee('Tolak')
            ->assertDontSee('Tandai Selesai');

        $this->get(route('admin.peminjaman.show', $lama))
            ->assertOk()
            ->assertSee('Tidak ada fasilitas tambahan.');
    }

    public function test_each_filter_and_a_combined_filter_limit_the_report(): void
    {
        $userA = User::factory()->peminjam()->create(['nama' => 'Peminjam A']);
        $userB = User::factory()->peminjam()->create(['nama' => 'Peminjam B']);
        $ruanganA = Ruangan::factory()->create(['nama_ruangan' => 'Ruang A']);
        $ruanganB = Ruangan::factory()->create(['nama_ruangan' => 'Ruang B']);
        $menunggu = $this->createLoan($userA, $ruanganA, StatusPeminjaman::Menunggu, '2026-01-10', 'Menunggu A');
        $disetujui = $this->createLoan($userB, $ruanganB, StatusPeminjaman::Disetujui, '2026-01-11', 'Disetujui B');
        $gabungan = $this->createLoan($userA, $ruanganA, StatusPeminjaman::Disetujui, '2026-01-12', 'Disetujui A');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.peminjaman.index', ['status' => StatusPeminjaman::Menunggu->value]))
            ->assertSee($menunggu->keperluan)
            ->assertDontSee($disetujui->keperluan);

        $this->get(route('admin.peminjaman.index', ['id_ruangan' => $ruanganB->id_ruangan]))
            ->assertSee($disetujui->keperluan)
            ->assertDontSee($gabungan->keperluan);

        $this->get(route('admin.peminjaman.index', ['id_user' => $userA->id_user]))
            ->assertSee($menunggu->keperluan)
            ->assertSee($gabungan->keperluan)
            ->assertDontSee($disetujui->keperluan);

        $this->get(route('admin.peminjaman.index', [
            'tanggal_mulai' => '2026-01-10',
            'tanggal_selesai' => '2026-01-11',
        ]))
            ->assertSee($menunggu->keperluan)
            ->assertSee($disetujui->keperluan)
            ->assertDontSee($gabungan->keperluan);

        $this->get(route('admin.peminjaman.index', [
            'status' => StatusPeminjaman::Disetujui->value,
            'id_ruangan' => $ruanganA->id_ruangan,
            'id_user' => $userA->id_user,
            'tanggal_mulai' => '2026-01-12',
            'tanggal_selesai' => '2026-01-12',
        ]))
            ->assertSee($gabungan->keperluan)
            ->assertDontSee($menunggu->keperluan)
            ->assertDontSee($disetujui->keperluan);
    }

    public function test_date_range_is_inclusive_and_invalid_filters_are_rejected(): void
    {
        $admin = User::factory()->admin()->create();
        $included = $this->createLoan(tanggal: '2026-01-10', keperluan: 'Batas tanggal');
        $excluded = $this->createLoan(tanggal: '2026-01-11', keperluan: 'Di luar batas');

        $this->actingAs($admin)
            ->get(route('admin.peminjaman.index', [
                'tanggal_mulai' => '2026-01-10',
                'tanggal_selesai' => '2026-01-10',
            ]))
            ->assertSee($included->keperluan)
            ->assertDontSee($excluded->keperluan);

        $this->from(route('admin.peminjaman.index'))
            ->get(route('admin.peminjaman.index', [
                'tanggal_mulai' => '2026-01-11',
                'tanggal_selesai' => '2026-01-10',
            ]))
            ->assertSessionHasErrors([
                'tanggal_selesai' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            ]);

        foreach ([
            ['status' => 'Tidak Ada'],
            ['id_ruangan' => 99999],
            ['id_user' => 99999],
            ['tanggal_mulai' => 'tanggal-salah'],
        ] as $filter) {
            $this->from(route('admin.peminjaman.index'))
                ->get(route('admin.peminjaman.index', $filter))
                ->assertSessionHasErrors();
        }
    }

    public function test_pagination_keeps_validated_filter_query_parameters(): void
    {
        $user = User::factory()->peminjam()->create();
        $ruangan = Ruangan::factory()->create();

        for ($number = 1; $number <= 16; $number++) {
            $this->createLoan(
                $user,
                $ruangan,
                StatusPeminjaman::Menunggu,
                '2026-01-10',
                'Peminjaman '.$number,
            );
        }

        $response = $this->actingAs(User::factory()->admin()->create())
            ->get(route('admin.peminjaman.index', [
                'status' => StatusPeminjaman::Menunggu->value,
                'page' => 2,
            ]));

        $response
            ->assertOk()
            ->assertViewHas('peminjaman', fn ($peminjaman): bool => $peminjaman->currentPage() === 2 && $peminjaman->perPage() === 15)
            ->assertSee('status=Menunggu', false);
    }

    public function test_global_summary_includes_every_status_and_zero_counts(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.peminjaman.index'))
            ->assertSee('Menunggu: 0')
            ->assertSee('Disetujui: 0')
            ->assertSee('Ditolak: 0')
            ->assertSee('Selesai: 0');

        $this->createLoan(status: StatusPeminjaman::Menunggu);
        $this->createLoan(status: StatusPeminjaman::Menunggu);
        $this->createLoan(status: StatusPeminjaman::Disetujui);
        $this->createLoan(status: StatusPeminjaman::Ditolak);
        $this->createLoan(status: StatusPeminjaman::Selesai);

        $this->get(route('admin.peminjaman.index'))
            ->assertSee('Menunggu: 2')
            ->assertSee('Disetujui: 1')
            ->assertSee('Ditolak: 1')
            ->assertSee('Selesai: 1');
    }

    public function test_report_does_not_change_loan_data_or_grant_admin_transition_access(): void
    {
        $peminjaman = $this->createLoan(status: StatusPeminjaman::Menunggu);
        $admin = User::factory()->admin()->create();
        $before = Peminjaman::query()->findOrFail($peminjaman->id_peminjaman)->getAttributes();

        $this->actingAs($admin)
            ->get(route('admin.peminjaman.index'))
            ->assertOk();

        $this->get(route('admin.peminjaman.show', $peminjaman))
            ->assertOk();

        $after = Peminjaman::query()->findOrFail($peminjaman->id_peminjaman)->getAttributes();
        $this->assertSame($before, $after);

        $this->patch(route('petugas.peminjaman.approve', $peminjaman))->assertForbidden();
        $this->patch(route('petugas.peminjaman.reject', $peminjaman))->assertForbidden();
        $this->patch(route('petugas.peminjaman.complete', $peminjaman))->assertForbidden();
    }

    public function test_policy_expansion_does_not_allow_borrower_to_view_another_loan(): void
    {
        $peminjaman = $this->createLoan();

        $this->actingAs(User::factory()->peminjam()->create())
            ->get(route('peminjam.peminjaman.show', $peminjaman))
            ->assertForbidden();
    }

    public function test_dashboard_shows_report_link_only_to_admin(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->get(route('dashboard'))
            ->assertSee('Laporan Peminjaman');

        foreach ([User::factory()->petugas()->create(), User::factory()->peminjam()->create()] as $user) {
            $this->actingAs($user)
                ->get(route('dashboard'))
                ->assertDontSee('Laporan Peminjaman');
        }
    }

    /**
     * Create a loan fixture with a DATE value that mirrors the MySQL column.
     *
     * @param  array<int, int>  $fasilitas
     */
    private function createLoan(
        ?User $user = null,
        ?Ruangan $ruangan = null,
        StatusPeminjaman $status = StatusPeminjaman::Menunggu,
        string $tanggal = '2026-01-10',
        string $keperluan = 'Peminjaman untuk laporan',
        array $fasilitas = [],
        string $jamMulai = '08:00',
        string $jamSelesai = '09:00',
    ): Peminjaman {
        $peminjaman = Peminjaman::factory()->create([
            'id_user' => ($user ?? User::factory()->peminjam()->create())->id_user,
            'id_ruangan' => ($ruangan ?? Ruangan::factory()->create())->id_ruangan,
            'tanggal' => $tanggal,
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai,
            'keperluan' => $keperluan,
            'status' => $status,
        ]);

        DB::table('peminjaman')
            ->where('id_peminjaman', $peminjaman->id_peminjaman)
            ->update(['tanggal' => $tanggal]);

        foreach ($fasilitas as $idFasilitas => $jumlah) {
            $peminjaman->detailPeminjaman()->create([
                'id_fasilitas' => $idFasilitas,
                'jumlah' => $jumlah,
            ]);
        }

        return $peminjaman;
    }
}
