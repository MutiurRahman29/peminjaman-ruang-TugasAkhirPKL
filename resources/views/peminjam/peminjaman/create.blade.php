@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')

@section('content')

<div class="mx-auto max-w-2xl px-6 py-8">

    <div class="mb-6">
        <p class="text-sm text-gray-400">Peminjaman</p>
        <h1 class="mt-1 text-2xl font-semibold text-white">
            Ajukan Peminjaman
        </h1>
    </div>


    {{-- Error Summary --}}
    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-800 bg-red-950/40 px-4 py-3 text-sm text-red-300">
            Pengajuan belum dapat dikirim. Periksa kembali isian di bawah.
        </div>
    @endif


    @if ($ruangan->isEmpty())

        <div class="rounded-xl border border-gray-700 bg-gray-800 px-6 py-12 text-center">
            <p class="text-sm text-gray-400">Tidak ada ruangan berstatus tersedia saat ini.</p>
        </div>

    @else

        <form method="POST" action="{{ route('peminjam.peminjaman.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="id_ruangan" class="mb-1.5 block text-sm text-gray-300">
                    Ruangan
                </label>

                <select
                    id="id_ruangan"
                    name="id_ruangan"
                    required
                    class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
                >
                    <option value="">Pilih ruangan</option>
                    @foreach ($ruangan as $item)
                        <option value="{{ $item->id_ruangan }}" @selected(old('id_ruangan') == $item->id_ruangan)>
                            {{ $item->nama_ruangan }}
                        </option>
                    @endforeach
                </select>

                @error('id_ruangan')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tanggal" class="mb-1.5 block text-sm text-gray-300">
                    Tanggal
                </label>

                <input
                    id="tanggal"
                    name="tanggal"
                    type="date"
                    value="{{ old('tanggal') }}"
                    min="{{ now()->toDateString() }}"
                    required
                    class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
                >

                @error('tanggal')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-4 sm:grid-cols-2">

                <div>
                    <label for="jam_mulai" class="mb-1.5 block text-sm text-gray-300">
                        Jam Mulai
                    </label>

                    <input
                        id="jam_mulai"
                        name="jam_mulai"
                        type="time"
                        value="{{ old('jam_mulai') }}"
                        required
                        class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
                    >

                    @error('jam_mulai')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jam_selesai" class="mb-1.5 block text-sm text-gray-300">
                        Jam Selesai
                    </label>

                    <input
                        id="jam_selesai"
                        name="jam_selesai"
                        type="time"
                        value="{{ old('jam_selesai') }}"
                        required
                        class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
                    >

                    @error('jam_selesai')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div>
                <label for="keperluan" class="mb-1.5 block text-sm text-gray-300">
                    Keperluan
                </label>

                <textarea
                    id="keperluan"
                    name="keperluan"
                    maxlength="1000"
                    rows="3"
                    required
                    class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
                >{{ old('keperluan') }}</textarea>

                @error('keperluan')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>


            {{-- Fasilitas Tambahan --}}
            <div>
                <p class="mb-3 text-sm font-medium text-gray-300">Fasilitas Tambahan</p>

                @error('fasilitas')
                    <p class="mb-2 text-sm text-red-400">{{ $message }}</p>
                @enderror

                @forelse ($fasilitas as $item)
                    <div class="mb-3 flex items-center gap-4 rounded-md border border-gray-700 bg-gray-750 px-4 py-3">

                        <div class="flex-1">
                            <label for="fasilitas_{{ $item->id_fasilitas }}" class="text-sm text-gray-300">
                                {{ $item->nama_fasilitas }}
                            </label>
                            <p class="text-xs text-gray-500">Stok tersedia: {{ $item->jumlah }}</p>
                        </div>

                        <input
                            id="fasilitas_{{ $item->id_fasilitas }}"
                            name="fasilitas[{{ $item->id_fasilitas }}]"
                            type="number"
                            min="1"
                            value="{{ old('fasilitas.'.$item->id_fasilitas) }}"
                            placeholder="0"
                            class="w-20 rounded-md border border-gray-600 bg-gray-700 px-3 py-1.5 text-sm text-white outline-none focus:border-gray-400"
                        >

                        @error('fasilitas.'.$item->id_fasilitas)
                            <p class="text-xs text-red-400">{{ $message }}</p>
                        @enderror

                    </div>
                @empty
                    <p class="text-sm text-gray-500">Tidak ada fasilitas tersedia saat ini.</p>
                @endforelse
            </div>


            <div class="flex items-center gap-3 pt-2">
                <button
                    type="submit"
                    class="rounded-md bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-200"
                >
                    Kirim Pengajuan
                </button>

                <a
                    href="{{ route('peminjam.peminjaman.index') }}"
                    class="text-sm text-gray-400 hover:text-white"
                >
                    Batal
                </a>
            </div>

        </form>

    @endif

</div>

@endsection
