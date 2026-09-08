<?php

namespace Database\Seeders;

use App\Enums\KondisiFasilitas;
use App\Enums\StatusRuangan;
use App\Enums\UserRole;
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

        foreach ([
            ['username' => 'admin', 'nama' => 'Admin Pengembangan', 'role' => UserRole::Admin],
            ['username' => 'petugas', 'nama' => 'Petugas Pengembangan', 'role' => UserRole::Petugas],
            ['username' => 'peminjam', 'nama' => 'Peminjam Pengembangan', 'role' => UserRole::Peminjam],
        ] as $user) {
            User::firstOrCreate(
                ['username' => $user['username']],
                [...$user, 'password' => 'password'],
            );
        }

        foreach ([
            ['nama_ruangan' => 'Laboratorium Komputer', 'kapasitas' => 40, 'lokasi' => 'Gedung A Lantai 1'],
            ['nama_ruangan' => 'Aula Sekolah', 'kapasitas' => 200, 'lokasi' => 'Gedung Utama'],
            ['nama_ruangan' => 'Ruang Kelas 1', 'kapasitas' => 32, 'lokasi' => 'Gedung B Lantai 1'],
        ] as $ruangan) {
            Ruangan::firstOrCreate(
                ['nama_ruangan' => $ruangan['nama_ruangan']],
                [...$ruangan, 'status' => StatusRuangan::Tersedia],
            );
        }

        foreach ([
            ['nama_fasilitas' => 'Proyektor', 'jumlah' => 3],
            ['nama_fasilitas' => 'Laptop', 'jumlah' => 5],
            ['nama_fasilitas' => 'Sound System', 'jumlah' => 2],
            ['nama_fasilitas' => 'Microphone', 'jumlah' => 6],
        ] as $fasilitas) {
            Fasilitas::firstOrCreate(
                ['nama_fasilitas' => $fasilitas['nama_fasilitas']],
                [...$fasilitas, 'kondisi' => KondisiFasilitas::Baik],
            );
        }
    }
}
