@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')

<div class="mx-auto max-w-2xl px-6 py-8">

    <div class="mb-6">
        <p class="text-sm text-gray-400">Administrasi</p>
        <h1 class="mt-1 text-2xl font-semibold text-white">
            Edit Pengguna
        </h1>
    </div>

    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="nama" class="mb-1.5 block text-sm text-gray-300">
                Nama
            </label>

            <input
                id="nama"
                name="nama"
                type="text"
                value="{{ old('nama', $user->nama) }}"
                maxlength="100"
                required
                class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
            >

            @error('nama')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="username" class="mb-1.5 block text-sm text-gray-300">
                Username
            </label>

            <input
                id="username"
                name="username"
                type="text"
                value="{{ old('username', $user->username) }}"
                maxlength="50"
                required
                class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
            >

            @error('username')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <p class="text-sm text-gray-500">Password boleh dikosongkan jika tidak ingin diganti.</p>

        <div>
            <label for="password" class="mb-1.5 block text-sm text-gray-300">
                Password Baru
            </label>

            <input
                id="password"
                name="password"
                type="password"
                class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
            >

            @error('password')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="mb-1.5 block text-sm text-gray-300">
                Konfirmasi Password Baru
            </label>

            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
            >
        </div>

        <div>
            <label for="role" class="mb-1.5 block text-sm text-gray-300">
                Role
            </label>

            <select
                id="role"
                name="role"
                required
                class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
            >
                <option value="">Pilih role</option>
                @foreach ($roleOptions as $role)
                    <option value="{{ $role->value }}" @selected(old('role', $user->role->value) === $role->value)>{{ $role->value }}</option>
                @endforeach
            </select>

            @error('role')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button
                type="submit"
                class="rounded-md bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-200"
            >
                Perbarui
            </button>

            <a
                href="{{ route('admin.users.index') }}"
                class="text-sm text-gray-400 hover:text-white"
            >
                Batal
            </a>
        </div>

    </form>

</div>

@endsection
