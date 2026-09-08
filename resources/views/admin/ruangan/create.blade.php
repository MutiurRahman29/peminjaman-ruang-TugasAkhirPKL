<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Ruangan</title>
</head>
<body>
    <main>
        <h1>Tambah Ruangan</h1>

        <form method="POST" action="{{ route('admin.ruangan.store') }}">
            @csrf

            <p>
                <label for="nama_ruangan">Nama Ruangan</label>
                <input id="nama_ruangan" name="nama_ruangan" type="text" value="{{ old('nama_ruangan') }}" maxlength="100" required>
                @error('nama_ruangan')
                    <span>{{ $message }}</span>
                @enderror
            </p>

            <p>
                <label for="kapasitas">Kapasitas</label>
                <input id="kapasitas" name="kapasitas" type="number" value="{{ old('kapasitas') }}" min="1" required>
                @error('kapasitas')
                    <span>{{ $message }}</span>
                @enderror
            </p>

            <p>
                <label for="lokasi">Lokasi</label>
                <input id="lokasi" name="lokasi" type="text" value="{{ old('lokasi') }}" maxlength="150" required>
                @error('lokasi')
                    <span>{{ $message }}</span>
                @enderror
            </p>

            <p>
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="">Pilih status</option>
                    @foreach ($statusOptions as $status)
                        <option value="{{ $status->value }}" @selected(old('status') === $status->value)>{{ $status->value }}</option>
                    @endforeach
                </select>
                @error('status')
                    <span>{{ $message }}</span>
                @enderror
            </p>

            <button type="submit">Simpan</button>
        </form>

        <p><a href="{{ route('admin.ruangan.index') }}">Kembali ke daftar ruangan</a></p>
    </main>
</body>
</html>
