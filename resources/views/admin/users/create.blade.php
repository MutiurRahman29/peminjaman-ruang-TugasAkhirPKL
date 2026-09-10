@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<h1>Tambah Pengguna</h1>

<form method="POST" action="{{ route('admin.users.store') }}">
    @csrf

    <p>
        <label for="nama">Nama</label>
        <input id="nama" name="nama" type="text" value="{{ old('nama') }}" maxlength="100" required>
        @error('nama')
            <span>{{ $message }}</span>
        @enderror
    </p>

    <p>
        <label for="username">Username</label>
        <input id="username" name="username" type="text" value="{{ old('username') }}" maxlength="50" required>
        @error('username')
            <span>{{ $message }}</span>
        @enderror
    </p>

    <p>
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>
        @error('password')
            <span>{{ $message }}</span>
        @enderror
    </p>

    <p>
        <label for="password_confirmation">Konfirmasi Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" required>
    </p>

    <p>
        <label for="role">Role</label>
        <select id="role" name="role" required>
            <option value="">Pilih role</option>
            @foreach ($roleOptions as $role)
                <option value="{{ $role->value }}" @selected(old('role') === $role->value)>{{ $role->value }}</option>
            @endforeach
        </select>
        @error('role')
            <span>{{ $message }}</span>
        @enderror
    </p>

    <button type="submit">Simpan</button>
</form>

<p><a href="{{ route('admin.users.index') }}">Kembali ke daftar pengguna</a></p>
@endsection
