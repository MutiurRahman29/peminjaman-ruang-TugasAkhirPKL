<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
</head>
<body>
    <main>
        <h1>Edit Pengguna</h1>

        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <p>
                <label for="nama">Nama</label>
                <input id="nama" name="nama" type="text" value="{{ old('nama', $user->nama) }}" maxlength="100" required>
                @error('nama')
                    <span>{{ $message }}</span>
                @enderror
            </p>

            <p>
                <label for="username">Username</label>
                <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}" maxlength="50" required>
                @error('username')
                    <span>{{ $message }}</span>
                @enderror
            </p>

            <p>Password boleh dikosongkan jika tidak ingin diganti.</p>

            <p>
                <label for="password">Password Baru</label>
                <input id="password" name="password" type="password">
                @error('password')
                    <span>{{ $message }}</span>
                @enderror
            </p>

            <p>
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input id="password_confirmation" name="password_confirmation" type="password">
            </p>

            <p>
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="">Pilih role</option>
                    @foreach ($roleOptions as $role)
                        <option value="{{ $role->value }}" @selected(old('role', $user->role->value) === $role->value)>{{ $role->value }}</option>
                    @endforeach
                </select>
                @error('role')
                    <span>{{ $message }}</span>
                @enderror
            </p>

            <button type="submit">Perbarui</button>
        </form>

        <p><a href="{{ route('admin.users.index') }}">Kembali ke daftar pengguna</a></p>
    </main>
</body>
</html>
