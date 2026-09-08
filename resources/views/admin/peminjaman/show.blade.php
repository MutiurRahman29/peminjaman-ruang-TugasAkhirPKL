<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan Peminjaman</title>
</head>
<body>
    <main>
        <h1>Detail Laporan Peminjaman</h1>

        <dl>
            <dt>Peminjam</dt>
            <dd>{{ $peminjaman->user->nama }}</dd>
            <dt>Ruangan</dt>
            <dd>{{ $peminjaman->ruangan->nama_ruangan }}</dd>
            <dt>Tanggal</dt>
            <dd>{{ $peminjaman->tanggal->toDateString() }}</dd>
            <dt>Waktu</dt>
            <dd>{{ substr($peminjaman->jam_mulai, 0, 5) }}–{{ substr($peminjaman->jam_selesai, 0, 5) }}</dd>
            <dt>Keperluan</dt>
            <dd>{{ $peminjaman->keperluan }}</dd>
            <dt>Status</dt>
            <dd>{{ $peminjaman->status->value }}</dd>
        </dl>

        <h2>Fasilitas</h2>
        @if ($peminjaman->detailPeminjaman->isEmpty())
            <p>Tidak ada fasilitas tambahan.</p>
        @else
            <ul>
                @foreach ($peminjaman->detailPeminjaman as $detail)
                    <li>{{ $detail->fasilitas->nama_fasilitas }}: {{ $detail->jumlah }}</li>
                @endforeach
            </ul>
        @endif

        <nav>
            <a href="{{ route('admin.peminjaman.index') }}">Kembali ke laporan</a>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </nav>
    </main>
</body>
</html>
