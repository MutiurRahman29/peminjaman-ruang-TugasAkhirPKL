<?php

namespace Tests\Feature;

use App\Enums\KondisiFasilitas;
use App\Enums\StatusPeminjaman;
use App\Enums\StatusRuangan;
use App\Enums\UserRole;
use App\Models\DetailPeminjaman;
use App\Models\Fasilitas;
use App\Models\Peminjaman;
use App\Models\Ruangan;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DatabaseLayerTest extends TestCase
{
    use RefreshDatabase;

    public function test_testing_database_uses_sqlite_in_memory(): void
    {
        $this->assertSame('sqlite', config('database.default'));
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
        $this->assertSame('sqlite', app('db')->connection()->getDriverName());
    }

    public function test_custom_user_key_password_and_role_cast_work(): void
    {
        $user = User::factory()->admin()->create();

        $this->assertSame('id_user', $user->getKeyName());
        $this->assertNotNull($user->id_user);
        $this->assertTrue(Hash::check('password', $user->password));
        $this->assertInstanceOf(UserRole::class, $user->role);
        $this->assertSame(UserRole::Admin, $user->role);
    }

    public function test_room_and_facility_statuses_are_cast_to_enums(): void
    {
        $ruangan = Ruangan::factory()->create(['status' => StatusRuangan::Digunakan]);
        $fasilitas = Fasilitas::factory()->create(['kondisi' => KondisiFasilitas::Rusak]);

        $this->assertSame(StatusRuangan::Digunakan, $ruangan->status);
        $this->assertSame(KondisiFasilitas::Rusak, $fasilitas->kondisi);
    }

    public function test_user_and_room_have_many_loans_and_loan_belongs_to_them(): void
    {
        $user = User::factory()->create();
        $ruangan = Ruangan::factory()->create();
        $peminjaman = Peminjaman::factory()->create([
            'id_user' => $user->id_user,
            'id_ruangan' => $ruangan->id_ruangan,
            'status' => StatusPeminjaman::Disetujui,
        ]);

        $this->assertCount(1, $user->peminjaman);
        $this->assertCount(1, $ruangan->peminjaman);
        $this->assertTrue($peminjaman->user->is($user));
        $this->assertTrue($peminjaman->ruangan->is($ruangan));
        $this->assertSame(StatusPeminjaman::Disetujui, $peminjaman->status);
    }

    public function test_loan_has_many_details_and_details_belong_to_facility(): void
    {
        $peminjaman = Peminjaman::factory()->create();
        $fasilitas = Fasilitas::factory()->create(['jumlah' => 2]);
        $detail = DetailPeminjaman::factory()->create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'id_fasilitas' => $fasilitas->id_fasilitas,
            'jumlah' => 1,
        ]);

        $this->assertCount(1, $peminjaman->detailPeminjaman);
        $this->assertTrue($detail->peminjaman->is($peminjaman));
        $this->assertTrue($detail->fasilitas->is($fasilitas));
    }

    public function test_development_seeder_runs_in_testing(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('users', 3);
        $this->assertDatabaseCount('ruangan', 3);
        $this->assertDatabaseCount('fasilitas', 4);
        $this->assertDatabaseCount('peminjaman', 0);
        $this->assertDatabaseHas('fasilitas', ['nama_fasilitas' => 'Proyektor']);
    }
}
