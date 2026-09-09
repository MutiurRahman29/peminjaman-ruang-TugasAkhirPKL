# Kontrak Backend dan Panduan Frontend

Dokumen ini menjadi acuan saat frontend Blade diperbarui. Tampilan boleh diubah, tetapi route, nama input, HTTP method, relasi data, policy, dan aturan bisnis berikut harus dipertahankan.

## Arsitektur

- Laravel server-rendered dengan Blade.
- Autentikasi session menggunakan `username` dan `password`.
- Middleware `auth` memastikan sesi aktif.
- Middleware `role` membatasi area peminjam, petugas, dan admin.
- Form Request menangani normalisasi dan validasi input.
- Service menangani jadwal, stok, approval, dan penyelesaian.
- `PeminjamanPolicy` menangani kepemilikan serta izin transisi status.
- Enum PHP menjadi sumber nilai role dan status aplikasi.

## Role dan akses

| Area | Peminjam | Petugas | Admin |
| --- | :---: | :---: | :---: |
| Dashboard | Ya | Ya | Ya |
| Katalog ruangan/fasilitas | Ya | Tidak | Tidak |
| Mengajukan dan melihat peminjaman sendiri | Ya | Tidak | Tidak |
| Antrean dan riwayat operasional | Tidak | Ya | Tidak |
| Approve, reject, complete | Tidak | Ya | Tidak |
| CRUD ruangan, fasilitas, pengguna | Tidak | Tidak | Ya |
| Laporan seluruh peminjaman | Tidak | Tidak | Ya |

Guest diarahkan ke login. Pengguna yang sudah login tetapi rolenya tidak cocok menerima HTTP 403. Peminjam yang membuka detail milik pengguna lain juga menerima HTTP 403.

## Route contract

### Autentikasi

| Method | URI | Nama route | Input |
| --- | --- | --- | --- |
| GET | `/login` | `login` | - |
| POST | `/login` | `login.store` | `username`, `password`, `remember` opsional |
| POST | `/logout` | `logout` | CSRF token |
| GET | `/dashboard` | `dashboard` | - |

Tidak ada route registrasi atau reset password. Logout wajib memakai form `POST`, bukan link GET.

### Peminjam

| Method | URI | Nama route |
| --- | --- | --- |
| GET | `/peminjam/ruangan` | `peminjam.ruangan.index` |
| GET | `/peminjam/fasilitas` | `peminjam.fasilitas.index` |
| GET | `/peminjam/peminjaman` | `peminjam.peminjaman.index` |
| GET | `/peminjam/peminjaman/create` | `peminjam.peminjaman.create` |
| POST | `/peminjam/peminjaman` | `peminjam.peminjaman.store` |
| GET | `/peminjam/peminjaman/{peminjaman}` | `peminjam.peminjaman.show` |

Input pengajuan:

```text
id_ruangan
tanggal                 format Y-m-d
jam_mulai               format H:i
jam_selesai             format H:i
keperluan
fasilitas[id_fasilitas] jumlah, opsional
```

Jumlah fasilitas kosong diabaikan. Nilai terisi harus integer minimal 1. `id_user` dan `status` tidak boleh dipercaya dari form; controller selalu memakai user yang sedang login dan status server `Menunggu`.

### Petugas

| Method | URI | Nama route |
| --- | --- | --- |
| GET | `/petugas/peminjaman` | `petugas.peminjaman.index` |
| GET | `/petugas/peminjaman/riwayat` | `petugas.peminjaman.history` |
| GET | `/petugas/peminjaman/{peminjaman}` | `petugas.peminjaman.show` |
| PATCH | `/petugas/peminjaman/{peminjaman}/approve` | `petugas.peminjaman.approve` |
| PATCH | `/petugas/peminjaman/{peminjaman}/reject` | `petugas.peminjaman.reject` |
| PATCH | `/petugas/peminjaman/{peminjaman}/complete` | `petugas.peminjaman.complete` |

Form perubahan status wajib menyertakan `@csrf` dan `@method('PATCH')`.

### Admin

Resource `admin.ruangan`, `admin.fasilitas`, dan `admin.users` menyediakan route `index`, `create`, `store`, `edit`, `update`, dan `destroy`. Update memakai `PUT` atau `PATCH`; penghapusan memakai `DELETE`.

Laporan read-only:

| Method | URI | Nama route |
| --- | --- | --- |
| GET | `/admin/peminjaman` | `admin.peminjaman.index` |
| GET | `/admin/peminjaman/{peminjaman}` | `admin.peminjaman.show` |

Filter laporan memakai query string:

```text
status
id_ruangan
id_user
tanggal_mulai           format Y-m-d
tanggal_selesai         format Y-m-d
```

Daftar laporan menggunakan pagination 15 item dan mempertahankan query string filter.

## Input CRUD admin

### Ruangan

```text
nama_ruangan            wajib, unik, maksimal 100 karakter
kapasitas               integer minimal 1
lokasi                  wajib, maksimal 150 karakter
status                  Tersedia | Digunakan
```

### Fasilitas

```text
nama_fasilitas          wajib, unik, maksimal 100 karakter
jumlah                  integer minimal 0
kondisi                 Baik | Rusak
keterangan              opsional, maksimal 1000 karakter
```

Keterangan kosong dinormalisasi menjadi `null`.

### Pengguna

```text
nama                    wajib, maksimal 100 karakter
username                wajib, unik, maksimal 50 karakter
password                minimal 8 karakter dan confirmed
role                    admin | petugas | peminjam
```

Username di-trim dan diubah ke lowercase sebelum validasi. Pada update, password kosong mempertahankan password lama. Akun admin yang sedang digunakan tidak dapat dihapus atau diubah menjadi role lain.

## State machine peminjaman

```text
Menunggu ──approve──> Disetujui ──complete──> Selesai
    └──────reject───> Ditolak
```

- Hanya `Menunggu` yang dapat disetujui atau ditolak.
- Hanya `Disetujui` yang dapat diselesaikan.
- Peminjaman hanya dapat diselesaikan ketika waktu selesai sudah tercapai.
- Pengajuan tidak dapat dibuat atau disetujui jika waktu mulainya sudah tercapai.
- Status yang sudah diproses tidak dapat diproses ulang.

## Aturan ketersediaan

Bentrok menggunakan interval setengah-terbuka:

```text
existing_start < requested_end
AND existing_end > requested_start
```

Jadwal yang dimulai tepat ketika jadwal sebelumnya selesai diperbolehkan. Hanya status `Disetujui` yang memblokir ruang atau mengurangi stok fasilitas.

Stok fasilitas dihitung lintas ruangan pada tanggal dan rentang waktu yang sama:

```text
stok tersedia = max(0, stok master - total pemakaian yang disetujui dan overlap)
```

Stok master tidak dikurangi saat approval. Detail peminjaman menyimpan jumlah yang dialokasikan pada jadwal tersebut.

Approval memakai transaksi dan urutan lock konsisten:

1. peminjaman;
2. ruangan;
3. fasilitas berdasarkan `id_fasilitas`.

Konflik terbaru mempertahankan peminjaman dalam status `Menunggu`.

## Data yang tersedia untuk view

- Katalog ruangan: koleksi `$ruangan`.
- Katalog fasilitas: koleksi `$fasilitas`.
- Daftar/detail peminjam: `$peminjaman` dengan `ruangan` dan `detailPeminjaman.fasilitas`.
- Antrean/riwayat/detail petugas: `$peminjaman` dengan `user`, `ruangan`, dan fasilitas.
- CRUD admin: `$ruangan`, `$fasilitas`, atau `$users` sesuai halaman.
- Laporan admin: `$peminjaman`, `$filters`, `$ringkasan`, `$ruangan`, dan `$users`.
- Form enum: `statusOptions`, `kondisiOptions`, atau `roleOptions`.

Frontend harus tetap menampilkan pesan validasi dari `$errors`, flash `success`, dan flash `error`. Jangan mengganti form mutasi menjadi link GET atau menghapus CSRF token.

## Aturan penghapusan

- User atau ruangan yang mempunyai riwayat peminjaman tidak dapat dihapus.
- Fasilitas yang mempunyai detail peminjaman tidak dapat dihapus.
- Detail ikut terhapus bila peminjaman induknya dihapus pada level database.
- Riwayat bisnis tidak boleh hilang akibat penghapusan data master.

## Checklist frontend

- Gunakan helper `route()` dengan nama route di atas.
- Pertahankan method form dan `@csrf`/`@method`.
- Pertahankan nama input agar Form Request tetap bekerja.
- Jangan mengirim atau mengizinkan pengguna memilih `id_user` dan `status` saat membuat pengajuan.
- Jangan menghitung ulang stok atau konflik hanya di JavaScript; server tetap sumber kebenaran.
- Tampilkan HTTP 403/404 secara wajar tanpa mencoba melewati policy.
- Jalankan seluruh test backend setelah mengubah Blade atau JavaScript.
