<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman</title>
</head>
<body>
    <main>
        <h1>Riwayat Peminjaman</h1>

        <p><a href="{{ route('peminjam.peminjaman.create') }}">Ajukan Peminjaman</a></p>

        @if ($peminjaman->isEmpty())
            <p>Belum ada pengajuan peminjaman.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Ruangan</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Keperluan</th>
                        <th>Status</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peminjaman as $item)
                        <tr>
                            <td>{{ $item->ruangan->nama_ruangan }}</td>
                            <td>{{ $item->tanggal->toDateString() }}</td>
                            <td>{{ substr($item->jam_mulai, 0, 5) }}–{{ substr($item->jam_selesai, 0, 5) }}</td>
                            <td>{{ $item->keperluan }}</td>
                            <td>{{ $item->status->value }}</td>
                            <td><a href="{{ route('peminjam.peminjaman.show', $item) }}">Lihat</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <p><a href="{{ route('dashboard') }}">Kembali ke dashboard</a></p>
    </main>
</body>
</html>
