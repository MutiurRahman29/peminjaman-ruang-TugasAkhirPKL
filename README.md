# Aplikasi Peminjaman Ruang & Fasilitas

Aplikasi internal sekolah untuk mengelola katalog ruangan dan fasilitas, pengajuan peminjaman, persetujuan petugas, penyelesaian peminjaman, serta laporan admin. Proyek ini menggunakan Laravel, autentikasi session berbasis username, dan MySQL Laragon.

## Fitur backend

- Autentikasi username tanpa registrasi publik.
- Role `peminjam`, `petugas`, dan `admin` dengan pembatasan route.
- Pengajuan ruang dengan fasilitas opsional.
- Validasi jadwal ruang dan stok fasilitas.
- Approval, penolakan, dan penyelesaian peminjaman oleh petugas.
- CRUD ruangan, fasilitas, dan pengguna oleh admin.
- Laporan peminjaman dengan filter dan pagination.
- Transaksi, row locking, foreign key, dan unique index untuk integritas data.
- Test otomatis menggunakan SQLite in-memory dan MySQL testing terpisah.

Dokumentasi lanjutan:

- [Kontrak backend dan panduan frontend](docs/BACKEND_HANDOFF.md)
- [Struktur database dan ERD](docs/DATABASE.md)

## Catatan penting untuk pengembang frontend

- Pertahankan nama route, URI, dan HTTP method yang tercantum di `docs/BACKEND_HANDOFF.md`.
- Semua form mutasi wajib memakai `@csrf`; form `PATCH`, `PUT`, dan `DELETE` juga wajib memakai `@method(...)`.
- Pertahankan nama input agar Form Request backend tetap dapat memvalidasi data.
- Form pengajuan tidak boleh mengirim atau memberi pengguna kontrol atas `id_user` dan `status`.
- Tampilkan validation errors, flash `success`, dan flash `error` yang diberikan backend.
- Jangan menjadikan perhitungan JavaScript sebagai sumber kebenaran untuk bentrok jadwal atau stok fasilitas; backend tetap melakukan validasi final.
- Jangan mengubah controller, service, policy, model, migration, atau aturan role hanya untuk menyesuaikan tampilan.
- Jalankan seluruh test backend setelah mengubah Blade atau JavaScript.

## Persyaratan lokal

- PHP 8.3 atau lebih baru.
- Composer 2.
- MySQL 8 atau MariaDB yang kompatibel.
- Laragon direkomendasikan untuk Windows.
- Node.js hanya diperlukan ketika frontend mulai dikembangkan.

## Instalasi

1. Pasang dependency PHP.

   ```bash
   composer install
   ```

2. Salin konfigurasi environment.

   Windows PowerShell:

   ```powershell
   Copy-Item .env.example .env
   ```

   Linux/macOS:

   ```bash
   cp .env.example .env
   ```

3. Buat application key.

   ```bash
   php artisan key:generate
   ```

4. Buat database kosong bernama `peminjaman_ruang`, lalu sesuaikan kredensial MySQL pada `.env` bila konfigurasi Laragon berbeda.

5. Bersihkan cache konfigurasi dan buat struktur database.

   ```bash
   php artisan config:clear
   php artisan migrate
   php artisan db:seed
   ```

6. Buka aplikasi melalui virtual host Laragon:

   ```text
   http://peminjaman-ruang.test/login
   ```

   Alternatif tanpa virtual host:

   ```bash
   php artisan serve
   ```

7. Project ini menggunakan Alpine.js untuk kebutuhan interaksi dan animasi ringan pada tampilan.

Install Alpine.js menggunakan pnpm:

```bash
pnpm add alpinejs
```

## Akun pengembangan

Seeder menyediakan akun berikut hanya untuk environment non-production:

| Role | Username | Password |
| --- | --- | --- |
| Admin | `admin` | `password` |
| Petugas | `petugas` | `password` |
| Peminjam | `peminjam` | `password` |

Ganti password jika proyek digunakan di luar demonstrasi lokal. Seeder memakai `firstOrCreate`, sehingga dijalankan ulang tidak menimpa perubahan akun atau data master yang sudah ada.

## Pengujian

Suite standar memakai SQLite in-memory dan tidak menyentuh MySQL:

```bash
php artisan test --do-not-cache-result
```

Pemeriksaan format:

```bash
vendor/bin/pint --test
```

### MySQL testing

Konfigurasi `phpunit.mysql.xml` selalu menunjuk ke database disposable `peminjaman_ruang_testing`. Jangan menyimpan data penting di database tersebut karena test dapat menghapus seluruh isinya.

Buat database testing satu kali:

```sql
CREATE DATABASE peminjaman_ruang_testing
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
```

Kemudian jalankan:

```bash
php artisan test --configuration phpunit.mysql.xml --do-not-cache-result
```

Konfigurasi bawaan mengasumsikan MySQL Laragon pada `127.0.0.1:3306`, username `root`, dan password kosong. Ubah hanya kredensial pada `phpunit.mysql.xml` jika mesin pengembang menggunakan konfigurasi berbeda. Nama database harus tetap `peminjaman_ruang_testing`.

## Batas proyek

Proyek PKL ini ditujukan untuk penggunaan dan demonstrasi lokal. Hosting, domain publik, email, OAuth, registrasi mandiri, dan reset password tidak termasuk scope.
