<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrean Peminjaman</title>
</head>
<body>
    <main>
        <h1>Antrean Peminjaman</h1>

        @if (session('success'))
            <p>{{ session('success') }}</p>
        @endif

        @if (session('error'))
            <p>{{ session('error') }}</p>
        @endif

        @if ($peminjaman->isEmpty())
            <p>Tidak ada pengajuan yang menunggu persetujuan.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Peminjam</th>
                        <th>Ruangan</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Keperluan</th>
                        <th>Fasilitas</th>
                        <th>Status</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peminjaman as $item)
                        <tr>
                            <td>{{ $item->user->nama }}</td>
                            <td>{{ $item->ruangan->nama_ruangan }}</td>
                            <td>{{ $item->tanggal->toDateString() }}</td>
                            <td>{{ substr($item->jam_mulai, 0, 5) }}–{{ substr($item->jam_selesai, 0, 5) }}</td>
                            <td>{{ $item->keperluan }}</td>
                            <td>{{ $item->detailPeminjaman->count() }} jenis fasilitas</td>
                            <td>{{ $item->status->value }}</td>
                            <td><a href="{{ route('petugas.peminjaman.show', $item) }}">Lihat</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <p><a href="{{ route('dashboard') }}">Kembali ke dashboard</a></p>
    </main>
</body>
</html>
