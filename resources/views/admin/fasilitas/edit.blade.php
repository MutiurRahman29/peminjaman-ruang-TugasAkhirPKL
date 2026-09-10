@extends('layouts.app')

@section('title', 'Edit Fasilitas')

@section('content')

<div class="mx-auto max-w-2xl px-6 py-8">

    <div class="mb-6">
        <p class="text-sm text-gray-400">Administrasi</p>
        <h1 class="mt-1 text-2xl font-semibold text-white">
            Edit Fasilitas
        </h1>
    </div>

    <form method="POST" action="{{ route('admin.fasilitas.update', $fasilitas) }}" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="nama_fasilitas" class="mb-1.5 block text-sm text-gray-300">
                Nama Fasilitas
            </label>

            <input
                id="nama_fasilitas"
                name="nama_fasilitas"
                type="text"
                value="{{ old('nama_fasilitas', $fasilitas->nama_fasilitas) }}"
                maxlength="100"
                required
                class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
            >

            @error('nama_fasilitas')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jumlah" class="mb-1.5 block text-sm text-gray-300">
                Jumlah
            </label>

            <input
                id="jumlah"
                name="jumlah"
                type="number"
                value="{{ old('jumlah', $fasilitas->jumlah) }}"
                min="0"
                required
                class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
            >

            @error('jumlah')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="kondisi" class="mb-1.5 block text-sm text-gray-300">
                Kondisi
            </label>

            <select
                id="kondisi"
                name="kondisi"
                required
                class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
            >
                <option value="">Pilih kondisi</option>
                @foreach ($kondisiOptions as $kondisi)
                    <option value="{{ $kondisi->value }}" @selected(old('kondisi', $fasilitas->kondisi->value) === $kondisi->value)>{{ $kondisi->value }}</option>
                @endforeach
            </select>

            @error('kondisi')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="keterangan" class="mb-1.5 block text-sm text-gray-300">
                Keterangan
            </label>

            <textarea
                id="keterangan"
                name="keterangan"
                maxlength="1000"
                rows="3"
                class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
            >{{ old('keterangan', $fasilitas->keterangan) }}</textarea>

            @error('keterangan')
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
                href="{{ route('admin.fasilitas.index') }}"
                class="text-sm text-gray-400 hover:text-white"
            >
                Batal
            </a>
        </div>

    </form>

</div>

@endsection
