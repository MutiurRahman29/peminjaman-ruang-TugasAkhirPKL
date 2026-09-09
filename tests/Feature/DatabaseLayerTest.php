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
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DatabaseLayerTest extends TestCase
{
    use RefreshDatabase;

    public function test_testing_database_is_isolated_from_the_primary_database(): void
    {
        $driver = app('db')->connection()->getDriverName();
        $database = app('db')->connection()->getDatabaseName();

        $this->assertContains($driver, ['sqlite', 'mysql']);

        if ($driver === 'sqlite') {
            $this->assertSame(':memory:', $database);

            return;
        }

        $this->assertSame('peminjaman_ruang_testing', $database);
        $this->assertNotSame('peminjaman_ruang', $database);
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

    public function test_database_rejects_duplicate_room_names(): void
    {
        Ruangan::factory()->create(['nama_ruangan' => 'Ruang Unik']);

        $this->expectException(QueryException::class);

        Ruangan::factory()->create(['nama_ruangan' => 'Ruang Unik']);
    }

    public function test_database_rejects_duplicate_facility_names(): void
    {
        Fasilitas::factory()->create(['nama_fasilitas' => 'Fasilitas Unik']);

        $this->expectException(QueryException::class);

        Fasilitas::factory()->create(['nama_fasilitas' => 'Fasilitas Unik']);
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

    public function test_development_seeder_is_idempotent_in_testing(): void
    {
        $this->seed(DatabaseSeeder::class);

        User::query()
            ->where('username', 'admin')
            ->firstOrFail()
            ->update(['nama' => 'Admin Diubah']);

        Ruangan::query()
            ->where('nama_ruangan', 'Laboratorium Komputer')
            ->firstOrFail()
            ->update(['status' => StatusRuangan::Digunakan]);

        Fasilitas::query()
            ->where('nama_fasilitas', 'Proyektor')
            ->firstOrFail()
            ->update([
                'jumlah' => 99,
                'kondisi' => KondisiFasilitas::Rusak,
            ]);

        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('users', 3);
        $this->assertDatabaseCount('ruangan', 3);
        $this->assertDatabaseCount('fasilitas', 4);
        $this->assertDatabaseCount('peminjaman', 0);
        $this->assertDatabaseCount('detail_peminjaman', 0);

        foreach (['admin', 'petugas', 'peminjam'] as $username) {
            $this->assertDatabaseHas('users', ['username' => $username]);
        }

        $this->assertDatabaseHas('users', [
            'username' => 'admin',
            'nama' => 'Admin Diubah',
        ]);

        $this->assertDatabaseHas('ruangan', [
            'nama_ruangan' => 'Laboratorium Komputer',
            'status' => StatusRuangan::Digunakan->value,
        ]);

        $this->assertDatabaseHas('fasilitas', [
            'nama_fasilitas' => 'Proyektor',
            'jumlah' => 99,
            'kondisi' => KondisiFasilitas::Rusak->value,
        ]);

        foreach (['Proyektor', 'Laptop', 'Sound System', 'Microphone'] as $namaFasilitas) {
            $this->assertDatabaseHas('fasilitas', ['nama_fasilitas' => $namaFasilitas]);
        }
    }
}
