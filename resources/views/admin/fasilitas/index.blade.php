<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Fasilitas</title>
</head>
<body>
    <main>
        <h1>Kelola Fasilitas</h1>

        @if (session('success'))
            <p>{{ session('success') }}</p>
        @endif

        @if (session('error'))
            <p>{{ session('error') }}</p>
        @endif

        <p><a href="{{ route('admin.fasilitas.create') }}">Tambah Fasilitas</a></p>

        @if ($fasilitas->isEmpty())
            <p>Belum ada fasilitas.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Nama Fasilitas</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fasilitas as $item)
                        <tr>
                            <td>{{ $item->nama_fasilitas }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->kondisi->value }}</td>
                            <td>{{ $item->keterangan ?: '-' }}</td>
                            <td>
                                <a href="{{ route('admin.fasilitas.edit', $item) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.fasilitas.destroy', $item) }}" onsubmit="return confirm('Hapus fasilitas ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <p><a href="{{ route('dashboard') }}">Kembali ke dashboard</a></p>
    </main>
</body>
</html>
