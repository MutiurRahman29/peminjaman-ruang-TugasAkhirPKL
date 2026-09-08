<?php

namespace Database\Seeders;

use App\Enums\KondisiFasilitas;
use App\Models\Fasilitas;
use App\Models\Ruangan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (app()->environment('production')) {
            return;
        }

        User::factory()->admin()->create([
            'nama' => 'Admin Pengembangan',
            'username' => 'admin',
        ]);

        User::factory()->petugas()->create([
            'nama' => 'Petugas Pengembangan',
            'username' => 'petugas',
        ]);

        User::factory()->peminjam()->create([
            'nama' => 'Peminjam Pengembangan',
            'username' => 'peminjam',
        ]);

        Ruangan::factory()->count(3)->create();

        Fasilitas::factory()->create([
            'nama_fasilitas' => 'Proyektor',
            'jumlah' => 3,
            'kondisi' => KondisiFasilitas::Baik,
        ]);

        Fasilitas::factory()->create([
            'nama_fasilitas' => 'Laptop',
            'jumlah' => 5,
            'kondisi' => KondisiFasilitas::Baik,
        ]);

        Fasilitas::factory()->create([
            'nama_fasilitas' => 'Sound System',
            'jumlah' => 2,
            'kondisi' => KondisiFasilitas::Baik,
        ]);

        Fasilitas::factory()->create([
            'nama_fasilitas' => 'Microphone',
            'jumlah' => 6,
            'kondisi' => KondisiFasilitas::Baik,
        ]);
    }
}
