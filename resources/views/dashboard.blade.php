@extends('layouts.app')

@section('title', 'Dashboard')

{{-- Pastikan Alpine.js di-load di layout utama Anda. Jika belum, tambahkan script CDN ini atau via Vite --}}
@push('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@section('content')

    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-12 md:py-20 selection:bg-indigo-500/30">

        {{-- Hero Section: Clean, Minimalist, High-Contrast --}}
        <section class="text-center mb-16 relative z-10 animate-fade-up animate-duration-[800ms] animate-ease-out">

            {{-- Status Badge (Refined) --}}
            <div
                class="inline-flex items-center gap-2 px-3 py-1.5 mb-8 text-xs font-medium text-zinc-300 rounded-full bg-zinc-800/50 border border-zinc-700/50 backdrop-blur-md transition-all hover:bg-zinc-800 hover:border-zinc-600 cursor-default">
                <span class="relative flex h-2 w-2">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                Sistem Aktif & Siap Digunakan
            </div>

            {{-- Typography: Crisp, no overused slop gradients --}}
            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-white mb-6 leading-tight">
                Pinjam Ruangan & Fasilitas <br class="hidden md:block">
                <span class="text-zinc-400">Lebih Mudah.</span>
            </h1>

            <p class="mt-4 text-base md:text-lg text-zinc-500 max-w-2xl mx-auto font-light leading-relaxed">
                Selamat datang, <strong
                    class="text-zinc-200 font-medium">{{ auth()->user()?->nama ?? 'Pengguna' }}</strong>. Kelola jadwal,
                pantau ketersediaan, dan ajukan peminjaman dalam satu tempat.
            </p>
        </section>

        {{-- DOCK: PEMINJAM --}}
        @if (auth()->user()?->role === \App\Enums\UserRole::Peminjam)
            <section
                class="relative z-20 max-w-4xl mx-auto animate-fade-up animate-duration-[800ms] animate-delay-200 animate-ease-out">

                {{-- Main Interactive Dock --}}
                <div
                    class="bg-[#111113] border border-zinc-800/80 rounded-3xl p-3 shadow-2xl flex flex-col md:flex-row items-stretch gap-3 transition-all">

                    <div class="flex-1 w-full grid grid-cols-2 gap-3">
                        {{-- Ruangan Card --}}
                        <a href="{{ route('peminjam.ruangan.index') }}" x-data="{ hovered: false }" @mouseenter="hovered = true"
                            @mouseleave="hovered = false"
                            class="relative group flex items-start gap-4 p-5 rounded-2xl bg-zinc-900/50 border border-zinc-800 transition-all duration-300 hover:bg-zinc-800 overflow-hidden">
                            <div class="text-zinc-400 group-hover:text-indigo-400 transition-colors duration-300 z-10">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div class="z-10">
                                <p class="text-[11px] text-zinc-500 font-medium uppercase tracking-wider mb-1">Eksplorasi
                                </p>
                                <p class="text-sm font-semibold text-zinc-200 group-hover:text-white transition-colors">
                                    Katalog Ruangan</p>
                            </div>
                            {{-- Subtle background interaction instead of glowing slop --}}
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                        </a>

                        {{-- Fasilitas Card --}}
                        <a href="{{ route('peminjam.fasilitas.index') }}" x-data="{ hovered: false }"
                            @mouseenter="hovered = true" @mouseleave="hovered = false"
                            class="relative group flex items-start gap-4 p-5 rounded-2xl bg-zinc-900/50 border border-zinc-800 transition-all duration-300 hover:bg-zinc-800 overflow-hidden">
                            <div class="text-zinc-400 group-hover:text-indigo-400 transition-colors duration-300 z-10">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <div class="z-10">
                                <p class="text-[11px] text-zinc-500 font-medium uppercase tracking-wider mb-1">Eksplorasi
                                </p>
                                <p class="text-sm font-semibold text-zinc-200 group-hover:text-white transition-colors">
                                    Fasilitas</p>
                            </div>
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                        </a>
                    </div>

                    {{-- Primary Action Button (Tactile & Premium) --}}
                    <a href="{{ route('peminjam.peminjaman.create') }}"
                        class="w-full md:w-auto flex-shrink-0 bg-white text-zinc-950 hover:bg-zinc-200 rounded-2xl px-8 py-5 transition-all duration-300 hover:scale-[0.98] active:scale-95 flex items-center justify-center gap-3 font-semibold text-base shadow-[inset_0_1px_0_rgba(255,255,255,0.5)] border border-transparent">
                        <span>Ajukan Peminjaman</span>
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                {{-- Secondary Dock --}}
                <div class="mt-6 flex justify-center animate-fade-up animate-duration-[800ms] animate-delay-300">
                    <a href="{{ route('peminjam.peminjaman.index') }}"
                        class="group inline-flex items-center gap-2 px-6 py-2.5 rounded-full text-sm font-medium text-zinc-500 hover:text-zinc-300 hover:bg-zinc-800/50 transition-all">
                        <svg class="w-4 h-4 text-zinc-600 group-hover:text-zinc-400 transition-colors" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Lihat Riwayat Peminjaman Saya
                        <span
                            class="opacity-0 -ml-2 group-hover:opacity-100 group-hover:ml-0 transition-all duration-300 text-zinc-400">→</span>
                    </a>
                </div>
            </section>
        @endif

        {{-- DOCK: PETUGAS --}}
        @if (auth()->user()?->role === \App\Enums\UserRole::Petugas)
            <section class="relative z-20 max-w-3xl mx-auto animate-fade-up animate-duration-[800ms] animate-delay-200">
                <div class="bg-[#111113] border border-zinc-800/80 rounded-3xl p-3 shadow-2xl flex flex-col md:flex-row">

                    <a href="{{ route('petugas.peminjaman.index') }}"
                        class="group relative flex-1 flex items-center justify-between p-6 rounded-2xl transition-all duration-300 hover:bg-zinc-800/50 overflow-hidden">
                        <div class="flex items-center gap-5 z-10">
                            <div
                                class="p-3.5 rounded-xl bg-amber-500/10 text-amber-500 border border-amber-500/20 group-hover:bg-amber-500 group-hover:text-white transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-zinc-100">Antrean Peminjaman</h3>
                                <p class="text-sm text-zinc-500 mt-0.5">Periksa pengajuan baru</p>
                            </div>
                        </div>
                        <div
                            class="w-8 h-8 rounded-full bg-zinc-800 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 group-hover:translate-x-1 z-10">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>

                    <div class="hidden md:block w-px bg-zinc-800 my-4 mx-2"></div>
                    <div class="md:hidden h-px bg-zinc-800 mx-4 my-2"></div>

                    <a href="{{ route('petugas.peminjaman.history') }}"
                        class="group relative flex-1 flex items-center justify-between p-6 rounded-2xl transition-all duration-300 hover:bg-zinc-800/50 overflow-hidden">
                        <div class="flex items-center gap-5 z-10">
                            <div
                                class="p-3.5 rounded-xl bg-zinc-800 text-zinc-400 border border-zinc-700/50 group-hover:bg-white group-hover:text-black transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-zinc-100">Riwayat Persetujuan</h3>
                                <p class="text-sm text-zinc-500 mt-0.5">Arsip peminjaman selesai</p>
                            </div>
                        </div>
                        <div
                            class="w-8 h-8 rounded-full bg-zinc-800 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 group-hover:translate-x-1 z-10">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>

                </div>
            </section>
        @endif

        {{-- DOCK: ADMIN --}}
        @if (auth()->user()?->role === \App\Enums\UserRole::Admin)
            <section class="relative z-20 max-w-5xl mx-auto animate-fade-up animate-duration-[800ms] animate-delay-200">
                <div class="bg-[#111113] border border-zinc-800/80 rounded-3xl p-4 shadow-2xl">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">

                        @php
                            $adminMenu = [
                                [
                                    'url' => route('admin.ruangan.index'),
                                    'title' => 'Ruangan',
                                    'desc' => 'Master Data',
                                    'icon' =>
                                        'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                                    'hover' => 'group-hover:bg-blue-500 group-hover:text-white',
                                    'delay' => 'animate-delay-[200ms]',
                                ],
                                [
                                    'url' => route('admin.fasilitas.index'),
                                    'title' => 'Fasilitas',
                                    'desc' => 'Inventaris',
                                    'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                                    'hover' => 'group-hover:bg-emerald-500 group-hover:text-white',
                                    'delay' => 'animate-delay-[300ms]',
                                ],
                                [
                                    'url' => route('admin.users.index'),
                                    'title' => 'Pengguna',
                                    'desc' => 'Hak Akses',
                                    'icon' =>
                                        'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
                                    'hover' => 'group-hover:bg-purple-500 group-hover:text-white',
                                    'delay' => 'animate-delay-[400ms]',
                                ],
                                [
                                    'url' => route('admin.peminjaman.index'),
                                    'title' => 'Laporan',
                                    'desc' => 'Aktivitas',
                                    'icon' =>
                                        'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                                    'hover' => 'group-hover:bg-rose-500 group-hover:text-white',
                                    'delay' => 'animate-delay-[500ms]',
                                ],
                            ];
                        @endphp

                        @foreach ($adminMenu as $menu)
                            <a href="{{ $menu['url'] }}"
                                class="group flex flex-col items-center text-center p-6 rounded-2xl bg-zinc-900/40 border border-zinc-800/50 transition-all duration-300 hover:bg-zinc-800 hover:-translate-y-1 animate-fade-up {{ $menu['delay'] }} hover:shadow-xl hover:shadow-black/50">
                                <div
                                    class="mb-4 p-3.5 rounded-xl bg-zinc-800 text-zinc-400 border border-zinc-700/50 transition-all duration-300 {{ $menu['hover'] }} group-hover:scale-110">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="{{ $menu['icon'] }}" />
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-zinc-200 group-hover:text-white transition-colors">
                                    {{ $menu['title'] }}</h3>
                                <p class="text-[11px] text-zinc-500 mt-1 uppercase tracking-wider">{{ $menu['desc'] }}</p>
                            </a>
                        @endforeach

                    </div>
                </div>
            </section>
        @endif

    </div>

@endsection
