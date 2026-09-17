@extends('layouts.app')

@section('title', 'Edit Ruangan')

@section('content')
    <div class="mx-auto max-w-2xl px-4 py-10 sm:px-6 lg:px-8">

        {{-- Top Navigation & Header --}}
        <div class="mb-8 animate-fade-up animate-duration-[600ms] animate-ease-out">
            <nav class="mb-3 flex items-center gap-2 text-xs font-medium text-gray-400">
                <a href="{{ route('admin.ruangan.index') }}" class="transition-colors hover:text-amber-400">Dashboard / Ruangan</a>
                <span>/</span>
                <span class="text-gray-200">Edit Ruangan</span>
            </nav>

            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">
                        Edit Data Ruangan
                    </h1>
                    <p class="mt-1 text-sm text-gray-400">
                        Perbarui rincian informasi dan status operasional ruangan.
                    </p>
                </div>


            </div>
        </div>

        {{-- Form Card --}}
        <div class="overflow-hidden rounded-2xl border border-gray-800 bg-gray-900 p-6 shadow-xl sm:p-8 animate-fade-up animate-duration-[800ms] animate-delay-100 animate-ease-out">
            <form method="POST" action="{{ route('admin.ruangan.update', $ruangan) }}" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Nama Ruangan --}}
                <div>
                    <label for="nama_ruangan" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-300">
                        Nama Ruangan <span class="text-rose-400">*</span>
                    </label>
                    <input
                        id="nama_ruangan"
                        name="nama_ruangan"
                        type="text"
                        value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}"
                        maxlength="100"
                        required
                        placeholder="Contoh: Aula Utama, Lab Komputer 1"
                        class="w-full rounded-xl border border-gray-800 bg-gray-950/60 px-4 py-3 text-sm text-white placeholder-gray-500 transition focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500"
                    >
                    @error('nama_ruangan')
                        <p class="mt-1.5 flex items-center gap-1 text-xs text-rose-400">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                {{-- Kapasitas --}}
                <div>
                    <label for="kapasitas" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-300">
                        Kapasitas Orang <span class="text-rose-400">*</span>
                    </label>
                    <input
                        id="kapasitas"
                        name="kapasitas"
                        type="number"
                        value="{{ old('kapasitas', $ruangan->kapasitas) }}"
                        min="1"
                        required
                        placeholder="Contoh: 50"
                        class="w-full rounded-xl border border-gray-800 bg-gray-950/60 px-4 py-3 text-sm text-white placeholder-gray-500 transition focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500"
                    >
                    @error('kapasitas')
                        <p class="mt-1.5 flex items-center gap-1 text-xs text-rose-400">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                {{-- Lokasi --}}
                <div>
                    <label for="lokasi" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-300">
                        Lokasi / Gedung <span class="text-rose-400">*</span>
                    </label>
                    <input
                        id="lokasi"
                        name="lokasi"
                        type="text"
                        value="{{ old('lokasi', $ruangan->lokasi) }}"
                        maxlength="150"
                        required
                        placeholder="Contoh: Gedung A Lantai 2"
                        class="w-full rounded-xl border border-gray-800 bg-gray-950/60 px-4 py-3 text-sm text-white placeholder-gray-500 transition focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500"
                    >
                    @error('lokasi')
                        <p class="mt-1.5 flex items-center gap-1 text-xs text-rose-400">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label for="status" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-300">
                        Status Operational <span class="text-rose-400">*</span>
                    </label>
                    <select
                        id="status"
                        name="status"
                        required
                        class="w-full rounded-xl border border-gray-800 bg-gray-950/60 px-4 py-3 text-sm text-white transition focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500"
                    >
                        <option value="" disabled class="bg-gray-900 text-gray-500">Pilih status ruangan</option>

                        @foreach ($statusOptions as $status)
                            <option
                                value="{{ $status->value }}"
                                class="bg-gray-900 text-white"
                                @selected(old('status', $ruangan->status->value) === $status->value)
                            >
                                {{ $status->value }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="mt-1.5 flex items-center gap-1 text-xs text-rose-400">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-800">
                    <a href="{{ route('admin.ruangan.index') }}"
                        class="rounded-xl border border-gray-800 bg-gray-800/50 px-5 py-2.5 text-sm font-semibold text-gray-300 transition-all hover:bg-gray-800 hover:text-white">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-amber-500 px-5 py-2.5 text-sm font-semibold text-gray-950 shadow-md transition-all hover:bg-amber-400 hover:scale-[0.98] active:scale-95">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        <span>Perbarui Ruangan</span>
                    </button>
                </div>

            </form>
        </div>

    </div>
@endsection
