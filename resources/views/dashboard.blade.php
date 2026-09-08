<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <main>
        <h1>Dashboard</h1>
        <p>Nama: {{ auth()->user()->nama }}</p>
        <p>Role: {{ auth()->user()->role->value }}</p>

        @if (auth()->user()->role === \App\Enums\UserRole::Peminjam)
            <nav>
                <a href="{{ route('peminjam.ruangan.index') }}">Katalog Ruangan</a>
                <a href="{{ route('peminjam.fasilitas.index') }}">Katalog Fasilitas</a>
                <a href="{{ route('peminjam.peminjaman.index') }}">Riwayat Peminjaman</a>
                <a href="{{ route('peminjam.peminjaman.create') }}">Ajukan Peminjaman</a>
            </nav>
        @endif

        @if (auth()->user()->role === \App\Enums\UserRole::Petugas)
            <nav>
                <a href="{{ route('petugas.peminjaman.index') }}">Antrean Peminjaman</a>
            </nav>
        @endif

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Keluar</button>
        </form>
    </main>
</body>
</html>
