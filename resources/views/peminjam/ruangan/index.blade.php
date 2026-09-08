<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Ruangan</title>
</head>
<body>
    <main>
        <h1>Katalog Ruangan</h1>

        @if ($ruangan->isEmpty())
            <p>Tidak ada ruangan tersedia.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Nama Ruangan</th>
                        <th>Kapasitas</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ruangan as $item)
                        <tr>
                            <td>{{ $item->nama_ruangan }}</td>
                            <td>{{ $item->kapasitas }}</td>
                            <td>{{ $item->lokasi }}</td>
                            <td>{{ $item->status->value }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <p><a href="{{ route('dashboard') }}">Kembali ke dashboard</a></p>
    </main>
</body>
</html>
