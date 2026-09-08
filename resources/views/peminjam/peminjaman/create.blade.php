<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Peminjaman</title>
</head>
<body>
    <main>
        <h1>Ajukan Peminjaman Ruangan</h1>

        @if ($errors->any())
            <div>
                <p>Pengajuan belum dapat dikirim.</p>
            </div>
        @endif

        @if ($ruangan->isEmpty())
            <p>Tidak ada ruangan berstatus tersedia saat ini.</p>
            <button type="button" disabled>Ajukan Peminjaman</button>
        @else
            <form method="POST" action="{{ route('peminjam.peminjaman.store') }}">
                @csrf

                <div>
                    <label for="id_ruangan">Ruangan</label>
                    <select id="id_ruangan" name="id_ruangan" required>
                        <option value="">Pilih ruangan</option>
                        @foreach ($ruangan as $item)
                            <option value="{{ $item->id_ruangan }}" @selected(old('id_ruangan') == $item->id_ruangan)>
                                {{ $item->nama_ruangan }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_ruangan')
                        <p>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal">Tanggal</label>
                    <input id="tanggal" name="tanggal" type="date" value="{{ old('tanggal') }}" min="{{ now()->toDateString() }}" required>
                    @error('tanggal')
                        <p>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jam_mulai">Jam mulai</label>
                    <input id="jam_mulai" name="jam_mulai" type="time" value="{{ old('jam_mulai') }}" required>
                    @error('jam_mulai')
                        <p>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jam_selesai">Jam selesai</label>
                    <input id="jam_selesai" name="jam_selesai" type="time" value="{{ old('jam_selesai') }}" required>
                    @error('jam_selesai')
                        <p>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="keperluan">Keperluan</label>
                    <textarea id="keperluan" name="keperluan" maxlength="1000" required>{{ old('keperluan') }}</textarea>
                    @error('keperluan')
                        <p>{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit">Kirim Pengajuan</button>
            </form>
        @endif

        <p><a href="{{ route('peminjam.peminjaman.index') }}">Kembali ke riwayat peminjaman</a></p>
    </main>
</body>
</html>
