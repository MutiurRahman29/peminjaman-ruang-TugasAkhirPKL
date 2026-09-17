@extends('layouts.app')

@section('title', 'Tambah Fasilitas')

@section('content')
    <div class="mx-auto max-w-2xl px-4 py-10 sm:px-6 lg:px-8">

        {{-- Top Navigation & Header --}}
        <div class="mb-8 animate-fade-up animate-duration-[600ms] animate-ease-out">
            <nav class="mb-3 flex items-center gap-2 text-xs font-medium text-gray-400">
                <a href="{{ route('dashboard') }}" class="transition-colors hover:text-amber-400">Dashboard</a>
                <span>/</span>
                <a href="{{ route('admin.fasilitas.index') }}" class="transition-colors hover:text-amber-400">Kelola Fasilitas</a>
                <span>/</span>
                <span class="text-gray-200">Tambah Fasilitas</span>
            </nav>

            <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">
                Tambah Fasilitas
            </h1>
            <p class="mt-1 text-sm text-gray-400">
                Tambahkan data fasilitas atau inventaris baru yang tersedia untuk peminjaman.
            </p>
        </div>

        {{-- Form Container Card --}}
        <div class="rounded-2xl border border-gray-800 bg-gray-900 p-6 shadow-xl sm:p-8 animate-fade-up animate-duration-[800ms] animate-delay-100 animate-ease-out">
            <form method="POST" action="{{ route('admin.fasilitas.store') }}" class="space-y-6">
                @csrf

                {{-- Nama Fasilitas --}}
                <div>
                    <label for="nama_fasilitas" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-300">
                        Nama Fasilitas <span class="text-amber-500">*</span>
                    </label>

                    <div class="relative rounded-xl shadow-sm">
                        <input
                            id="nama_fasilitas"
                            name="nama_fasilitas"
                            type="text"
                            value="{{ old('nama_fasilitas') }}"
                            maxlength="100"
                            required
                            placeholder="Contoh: Proyektor Epson EB-X400"
                            class="w-full rounded-xl border border-gray-800 bg-gray-950/60 px-4 py-3 text-sm text-white placeholder-gray-600 transition-all focus:border-amber-500 focus:bg-gray-950 focus:outline-none focus:ring-2 focus:ring-amber-500/20 @error('nama_fasilitas') border-rose-500/80 focus:border-rose-500 focus:ring-rose-500/20 @enderror"
                        >
                    </div>

                    @error('nama_fasilitas')
                        <div class="mt-2 flex items-center gap-1.5 text-xs text-rose-400">
                            <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                {{-- Jumlah --}}
                <div>
                    <label for="jumlah" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-300">
                        Jumlah Unit <span class="text-amber-500">*</span>
                    </label>

                    <div class="relative rounded-xl shadow-sm">
                        <input
                            id="jumlah"
                            name="jumlah"
                            type="number"
                            value="{{ old('jumlah') }}"
                            min="0"
                            required
                            placeholder="0"
                            class="w-full rounded-xl border border-gray-800 bg-gray-950/60 px-4 py-3 text-sm text-white placeholder-gray-600 transition-all focus:border-amber-500 focus:bg-gray-950 focus:outline-none focus:ring-2 focus:ring-amber-500/20 @error('jumlah') border-rose-500/80 focus:border-rose-500 focus:ring-rose-500/20 @enderror"
                        >
                    </div>

                    @error('jumlah')
                        <div class="mt-2 flex items-center gap-1.5 text-xs text-rose-400">
                            <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                {{-- Kondisi --}}
                <div>
                    <label for="kondisi" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-300">
                        Kondisi <span class="text-amber-500">*</span>
                    </label>

                    <div class="relative rounded-xl shadow-sm">
                        <select
                            id="kondisi"
                            name="kondisi"
                            required
                            class="w-full appearance-none rounded-xl border border-gray-800 bg-gray-950/60 px-4 py-3 pr-10 text-sm text-white transition-all focus:border-amber-500 focus:bg-gray-950 focus:outline-none focus:ring-2 focus:ring-amber-500/20 @error('kondisi') border-rose-500/80 focus:border-rose-500 focus:ring-rose-500/20 @enderror"
                        >
                            <option value="" disabled @selected(!old('kondisi')) class="bg-gray-900 text-gray-500">Pilih kondisi fasilitas</option>
                            @foreach ($kondisiOptions as $kondisi)
                                <option value="{{ $kondisi->value }}" class="bg-gray-900 text-white" @selected(old('kondisi') === $kondisi->value)>
                                    {{ $kondisi->value }}
                                </option>
                            @endforeach
                        </select>

                        {{-- Custom Select Arrow Icon --}}
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>

                    @error('kondisi')
                        <div class="mt-2 flex items-center gap-1.5 text-xs text-rose-400">
                            <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                {{-- Keterangan --}}
                <div>
                    <label for="keterangan" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-300">
                        Keterangan <span class="text-xs font-normal text-gray-500">(Opsional)</span>
                    </label>

                    <textarea
                        id="keterangan"
                        name="keterangan"
                        maxlength="1000"
                        rows="3"
                        placeholder="Tambahkan catatan atau spesifikasi tambahan tentang fasilitas ini..."
                        class="w-full rounded-xl border border-gray-800 bg-gray-950/60 p-4 text-sm text-white placeholder-gray-600 transition-all focus:border-amber-500 focus:bg-gray-950 focus:outline-none focus:ring-2 focus:ring-amber-500/20 @error('keterangan') border-rose-500/80 focus:border-rose-500 focus:ring-rose-500/20 @enderror"
                    >{{ old('keterangan') }}</textarea>

                    @error('keterangan')
                        <div class="mt-2 flex items-center gap-1.5 text-xs text-rose-400">
                            <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                {{-- Form Actions --}}
                <div class="flex items-center gap-3 pt-4 border-t border-gray-800/80">
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-5 py-2.5 text-sm font-semibold text-gray-950 shadow-md transition-all hover:bg-amber-400 hover:scale-[0.98] active:scale-95"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Simpan Fasilitas</span>
                    </button>

                    <a
                        href="{{ route('admin.fasilitas.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-700 bg-gray-800/80 px-5 py-2.5 text-sm font-medium text-gray-300 transition-all hover:bg-gray-700 hover:text-white hover:scale-[0.98] active:scale-95"
                    >
                        Batal
                    </a>
                </div>

            </form>
        </div>

    </div>
@endsection
