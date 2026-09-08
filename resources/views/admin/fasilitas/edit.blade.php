<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Fasilitas</title>
</head>
<body>
    <main>
        <h1>Edit Fasilitas</h1>

        <form method="POST" action="{{ route('admin.fasilitas.update', $fasilitas) }}">
            @csrf
            @method('PUT')

            <p>
                <label for="nama_fasilitas">Nama Fasilitas</label>
                <input id="nama_fasilitas" name="nama_fasilitas" type="text" value="{{ old('nama_fasilitas', $fasilitas->nama_fasilitas) }}" maxlength="100" required>
                @error('nama_fasilitas')
                    <span>{{ $message }}</span>
                @enderror
            </p>

            <p>
                <label for="jumlah">Jumlah</label>
                <input id="jumlah" name="jumlah" type="number" value="{{ old('jumlah', $fasilitas->jumlah) }}" min="0" required>
                @error('jumlah')
                    <span>{{ $message }}</span>
                @enderror
            </p>

            <p>
                <label for="kondisi">Kondisi</label>
                <select id="kondisi" name="kondisi" required>
                    <option value="">Pilih kondisi</option>
                    @foreach ($kondisiOptions as $kondisi)
                        <option value="{{ $kondisi->value }}" @selected(old('kondisi', $fasilitas->kondisi->value) === $kondisi->value)>{{ $kondisi->value }}</option>
                    @endforeach
                </select>
                @error('kondisi')
                    <span>{{ $message }}</span>
                @enderror
            </p>

            <p>
                <label for="keterangan">Keterangan</label>
                <textarea id="keterangan" name="keterangan" maxlength="1000">{{ old('keterangan', $fasilitas->keterangan) }}</textarea>
                @error('keterangan')
                    <span>{{ $message }}</span>
                @enderror
            </p>

            <button type="submit">Perbarui</button>
        </form>

        <p><a href="{{ route('admin.fasilitas.index') }}">Kembali ke daftar fasilitas</a></p>
    </main>
</body>
</html>
