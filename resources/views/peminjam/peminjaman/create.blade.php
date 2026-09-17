@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')

@section('content')

<div class="mx-auto max-w-2xl px-4 py-10 sm:px-6 lg:px-8 selection:bg-indigo-500/30">

    {{-- Page Header & Back Link --}}
    <div class="mb-8 animate-fade-up animate-duration-[600ms] animate-ease-out">
        <a href="{{ route('dashboard') }}" class="group mb-4 inline-flex items-center text-sm font-medium text-zinc-400 transition-colors hover:text-white">
            <svg class="mr-2 h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Dashboard
        </a>

        <h1 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
            Ajukan Peminjaman
        </h1>
        <p class="mt-2 text-sm text-zinc-400">
            Isi formulir di bawah ini untuk mengajukan peminjaman ruangan dan fasilitas.
        </p>
    </div>

    {{-- Error Summary Alert (Refined & High Contrast) --}}
    @if ($errors->any())
        <div class="mb-6 flex items-start gap-3 rounded-2xl border border-rose-500/20 bg-rose-500/10 p-4 text-sm text-rose-300 animate-shake animate-duration-300">
            <svg class="h-5 w-5 flex-shrink-0 text-rose-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
            </svg>
            <div>
                <p class="font-semibold text-rose-200">Pengajuan belum dapat dikirim</p>
                <p class="mt-0.5 text-xs text-rose-300/80">Silakan periksa kembali beberapa isian formulir di bawah yang belum sesuai.</p>
            </div>
        </div>
    @endif

    {{-- Empty State jika Ruangan Kosong --}}
    @if ($ruangan->isEmpty())
        <div class="flex flex-col items-center justify-center rounded-3xl border border-zinc-800/80 bg-[#111113] p-12 text-center animate-fade-up animate-duration-[800ms]">
            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-zinc-800 ring-1 ring-zinc-700/50">
                <svg class="h-6 w-6 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
            </div>
            <h2 class="text-base font-semibold text-zinc-200">Tidak ada ruangan tersedia</h2>
            <p class="mt-1 text-sm text-zinc-500 max-w-sm">
                Saat ini belum ada ruangan berstatus siap pinjam. Silakan coba lagi beberapa saat lagi.
            </p>
        </div>

    @else

        {{-- Form Container Card --}}
        <div class="rounded-3xl border border-zinc-800/80 bg-[#111113] p-6 sm:p-8 shadow-2xl animate-fade-up animate-duration-[800ms] animate-delay-100 animate-ease-out">
            <form method="POST" action="{{ route('peminjam.peminjaman.store') }}" class="space-y-6">
                @csrf

                {{-- Select Ruangan --}}
                <div>
                    <label for="id_ruangan" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-zinc-400">
                        Ruangan Pilihan <span class="text-rose-400">*</span>
                    </label>

                    <div class="relative">
                        <select
                            id="id_ruangan"
                            name="id_ruangan"
                            required
                            class="w-full appearance-none rounded-xl border border-zinc-800 bg-zinc-900/80 px-4 py-3 text-sm text-zinc-100 transition-all focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500 @error('id_ruangan') border-rose-500/50 focus:border-rose-500 focus:ring-rose-500 @enderror"
                        >
                            <option value="" disabled selected class="text-zinc-500">-- Pilih Ruangan --</option>
                            @foreach ($ruangan as $item)
                                <option value="{{ $item->id_ruangan }}" @selected(old('id_ruangan') == $item->id_ruangan)>
                                    {{ $item->nama_ruangan }} (Kapasitas: {{ $item->kapasitas }} orang)
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-zinc-500">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>

                    @error('id_ruangan')
                        <p class="mt-2 flex items-center gap-1 text-xs text-rose-400">
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                {{-- Tanggal Peminjaman --}}
                <div>
                    <label for="tanggal" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-zinc-400">
                        Tanggal Pelaksanaan <span class="text-rose-400">*</span>
                    </label>

                    <input
                        id="tanggal"
                        name="tanggal"
                        type="date"
                        value="{{ old('tanggal') }}"
                        min="{{ now()->toDateString() }}"
                        required
                        class="w-full rounded-xl border border-zinc-800 bg-zinc-900/80 px-4 py-3 text-sm text-zinc-100 transition-all focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500 [color-scheme:dark] @error('tanggal') border-rose-500/50 focus:border-rose-500 focus:ring-rose-500 @enderror"
                    >

                    @error('tanggal')
                        <p class="mt-2 flex items-center gap-1 text-xs text-rose-400">
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                {{-- Jam Mulai & Jam Selesai --}}
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="jam_mulai" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-zinc-400">
                            Jam Mulai <span class="text-rose-400">*</span>
                        </label>

                        <input
                            id="jam_mulai"
                            name="jam_mulai"
                            type="time"
                            value="{{ old('jam_mulai') }}"
                            required
                            class="w-full rounded-xl border border-zinc-800 bg-zinc-900/80 px-4 py-3 text-sm text-zinc-100 transition-all focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500 [color-scheme:dark] @error('jam_mulai') border-rose-500/50 focus:border-rose-500 focus:ring-rose-500 @enderror"
                        >

                        @error('jam_mulai')
                            <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jam_selesai" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-zinc-400">
                            Jam Selesai <span class="text-rose-400">*</span>
                        </label>

                        <input
                            id="jam_selesai"
                            name="jam_selesai"
                            type="time"
                            value="{{ old('jam_selesai') }}"
                            required
                            class="w-full rounded-xl border border-zinc-800 bg-zinc-900/80 px-4 py-3 text-sm text-zinc-100 transition-all focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500 [color-scheme:dark] @error('jam_selesai') border-rose-500/50 focus:border-rose-500 focus:ring-rose-500 @enderror"
                        >

                        @error('jam_selesai')
                            <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Keperluan --}}
                <div>
                    <label for="keperluan" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-zinc-400">
                        Maksud & Keperluan <span class="text-rose-400">*</span>
                    </label>

                    <textarea
                        id="keperluan"
                        name="keperluan"
                        maxlength="1000"
                        rows="3"
                        required
                        placeholder="Jelaskan secara singkat agenda atau kegiatan yang akan dilaksanakan..."
                        class="w-full rounded-xl border border-zinc-800 bg-zinc-900/80 px-4 py-3 text-sm text-zinc-100 placeholder-zinc-600 transition-all focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500 @error('keperluan') border-rose-500/50 focus:border-rose-500 focus:ring-rose-500 @enderror"
                    >{{ old('keperluan') }}</textarea>

                    @error('keperluan')
                        <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="my-6 border-t border-zinc-800/80"></div>

                {{-- Fasilitas Tambahan Section --}}
                <div>
                    <div class="mb-3 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Fasilitas Tambahan</p>
                            <p class="text-xs text-zinc-500 mt-0.5">Opsional, masukkan kuantitas barang jika dibutuhkan</p>
                        </div>
                    </div>

                    @error('fasilitas')
                        <p class="mb-3 text-xs text-rose-400">{{ $message }}</p>
                    @enderror

                    <div class="space-y-3">
                        @forelse ($fasilitas as $item)
                            <div class="flex items-center justify-between gap-4 rounded-xl border border-zinc-800/80 bg-zinc-900/40 p-4 transition-colors hover:border-zinc-700/60">
                                <div class="min-w-0 flex-1">
                                    <label for="fasilitas_{{ $item->id_fasilitas }}" class="block text-sm font-medium text-zinc-200 cursor-pointer">
                                        {{ $item->nama_fasilitas }}
                                    </label>
                                    <p class="text-xs text-zinc-500 mt-0.5">Stok tersedia: <span class="text-zinc-400 font-medium">{{ $item->jumlah }} unit</span></p>
                                </div>

                                <div class="flex flex-col items-end">
                                    <input
                                        id="fasilitas_{{ $item->id_fasilitas }}"
                                        name="fasilitas[{{ $item->id_fasilitas }}]"
                                        type="number"
                                        min="1"
                                        max="{{ $item->jumlah }}"
                                        value="{{ old('fasilitas.'.$item->id_fasilitas) }}"
                                        placeholder="0"
                                        class="w-20 text-center rounded-lg border border-zinc-800 bg-zinc-950 px-3 py-1.5 text-sm text-zinc-100 placeholder-zinc-600 transition-all focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500"
                                    >

                                    @error('fasilitas.'.$item->id_fasilitas)
                                        <p class="mt-1 text-[11px] text-rose-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @empty
                            <div class="rounded-xl border border-dashed border-zinc-800 p-4 text-center">
                                <p class="text-xs text-zinc-500">Tidak ada fasilitas tambahan yang tersedia saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-3 pt-4">
                    <a
                        href="{{ route('peminjam.peminjaman.index') }}"
                        class="rounded-xl px-5 py-2.5 text-sm font-medium text-zinc-400 transition-colors hover:bg-zinc-800 hover:text-white"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-6 py-2.5 text-sm font-semibold text-zinc-950 shadow-[inset_0_1px_0_rgba(255,255,255,0.5)] transition-all hover:bg-zinc-200 hover:scale-[0.98] active:scale-95"
                    >
                        <span>Kirim Pengajuan</span>
                        <svg class="h-4 w-4 text-zinc-900" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                    </button>
                </div>

            </form>
        </div>

    @endif

</div>

@endsection
