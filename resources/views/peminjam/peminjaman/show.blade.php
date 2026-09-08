<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peminjaman</title>
</head>
<body>
    <main>
        <h1>Detail Peminjaman</h1>

        @if (session('success'))
            <p>{{ session('success') }}</p>
        @endif

        <dl>
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

        <p><a href="{{ route('peminjam.peminjaman.index') }}">Kembali ke riwayat peminjaman</a></p>
    </main>
</body>
</html>
