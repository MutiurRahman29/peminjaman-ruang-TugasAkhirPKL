<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Ruangan</title>
</head>
<body>
    <main>
        <h1>Kelola Ruangan</h1>

        @if (session('success'))
            <p>{{ session('success') }}</p>
        @endif

        @if (session('error'))
            <p>{{ session('error') }}</p>
        @endif

        <p><a href="{{ route('admin.ruangan.create') }}">Tambah Ruangan</a></p>

        @if ($ruangan->isEmpty())
            <p>Belum ada ruangan.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Nama Ruangan</th>
                        <th>Kapasitas</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ruangan as $item)
                        <tr>
                            <td>{{ $item->nama_ruangan }}</td>
                            <td>{{ $item->kapasitas }}</td>
                            <td>{{ $item->lokasi }}</td>
                            <td>{{ $item->status->value }}</td>
                            <td>
                                <a href="{{ route('admin.ruangan.edit', $item) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.ruangan.destroy', $item) }}" onsubmit="return confirm('Hapus ruangan ini?');">
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
