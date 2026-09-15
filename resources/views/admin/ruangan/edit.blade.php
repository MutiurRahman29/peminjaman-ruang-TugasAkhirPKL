@extends('layouts.app')

@section('title', 'Edit Ruangan')

@section('content')

<div class="mx-auto max-w-2xl px-6 py-8">

<div class="mb-6">
    <p class="text-sm text-gray-400">Administrasi</p>
    <h1 class="mt-1 text-2xl font-semibold text-white">
        Edit Ruangan
    </h1>
</div>

<form method="POST" action="{{ route('admin.ruangan.update', $ruangan) }}" class="space-y-5">
    @csrf
    @method('PUT')

    <div>
        <label for="nama_ruangan" class="mb-1.5 block text-sm text-gray-300">
            Nama Ruangan
        </label>

        <input
            id="nama_ruangan"
            name="nama_ruangan"
            type="text"
            value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}"
            maxlength="100"
            required
            class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
        >

        @error('nama_ruangan')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="kapasitas" class="mb-1.5 block text-sm text-gray-300">
            Kapasitas
        </label>

        <input
            id="kapasitas"
            name="kapasitas"
            type="number"
            value="{{ old('kapasitas', $ruangan->kapasitas) }}"
            min="1"
            required
            class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
        >

        @error('kapasitas')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="lokasi" class="mb-1.5 block text-sm text-gray-300">
            Lokasi
        </label>

        <input
            id="lokasi"
            name="lokasi"
            type="text"
            value="{{ old('lokasi', $ruangan->lokasi) }}"
            maxlength="150"
            required
            class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
        >

        @error('lokasi')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="status" class="mb-1.5 block text-sm text-gray-300">
            Status
        </label>

        <select
            id="status"
            name="status"
            required
            class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
        >
            <option value="">Pilih status</option>

            @foreach ($statusOptions as $status)
                <option
                    value="{{ $status->value }}"
                    @selected(old('status', $ruangan->status->value) === $status->value)
                >
                    {{ $status->value }}
                </option>
            @endforeach
        </select>

        @error('status')
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
            href="{{ route('admin.ruangan.index') }}"
            class="text-sm text-gray-400 hover:text-white"
        >
            Batal
        </a>
    </div>

</form>
</div>

@endsection
