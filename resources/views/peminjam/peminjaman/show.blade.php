@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')

    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8 selection:bg-indigo-500/30">

        {{-- Top Back Link & Header --}}
        <div class="mb-8 animate-fade-up animate-duration-[600ms] animate-ease-out">
            <a href="{{ route('peminjam.peminjaman.index') }}"
                class="group mb-4 inline-flex items-center text-sm font-medium text-zinc-400 transition-colors hover:text-white">
                <svg class="mr-2 h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Kembali ke Riwayat Peminjaman
            </a>

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Detail Peminjaman
                    </h1>
                    <p class="mt-2 text-sm text-zinc-400">
                        Informasi lengkap mengenai status dan perincian pengajuan peminjaman Anda.
                    </p>
                </div>
            </div>
        </div>

        {{-- Flash Success Alert --}}
        @if (session('success'))
            <div
                class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm text-emerald-300 animate-fade-up animate-duration-[400ms]">
                <svg class="h-5 w-5 flex-shrink-0 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Main Container --}}
        <div class="space-y-6 animate-fade-up animate-duration-[800ms] animate-delay-100 animate-ease-out">

            {{-- Detail Card --}}
            <div class="overflow-hidden rounded-3xl border border-zinc-800/80 bg-[#111113] p-6 sm:p-8 shadow-2xl">

                {{-- Status Header Bar inside Card --}}
                <div class="mb-6 flex flex-wrap items-center justify-between gap-4 border-b border-zinc-800/80 pb-6">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-zinc-500">Status Pengajuan</span>
                        <div class="mt-2">
                            @php $st = strtolower($peminjaman->status->value ?? ''); @endphp
                            @if ($st === 'disetujui')
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-green-500/10 px-3 py-1.5 text-xs font-semibold text-green-400 ring-1 ring-inset ring-green-500/20">
                                    <svg class="h-2 w-2 fill-green-400" viewBox="0 0 6 6">
                                        <circle cx="3" cy="3" r="3" />
                                    </svg>
                                    Disetujui
                                </span>
                            @elseif ($st === 'ditolak')
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-rose-500/10 px-3 py-1.5 text-xs font-semibold text-rose-400 ring-1 ring-inset ring-rose-500/20">
                                    <svg class="h-2 w-2 fill-rose-400" viewBox="0 0 6 6">
                                        <circle cx="3" cy="3" r="3" />
                                    </svg>
                                    Ditolak
                                </span>
                            @elseif ($st === 'selesai')
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-500/10 px-3 py-1.5 text-xs font-semibold text-indigo-400 ring-1 ring-inset ring-indigo-500/20">
                                    <svg class="h-2 w-2 fill-indigo-400" viewBox="0 0 6 6">
                                        <circle cx="3" cy="3" r="3" />
                                    </svg>
                                    Selesai
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-amber-500/10 px-3 py-1.5 text-xs font-semibold text-amber-400 ring-1 ring-inset ring-amber-500/20">
                                    <svg class="h-2 w-2 fill-amber-400" viewBox="0 0 6 6">
                                        <circle cx="3" cy="3" r="3" />
                                    </svg>
                                    {{ $peminjaman->status->value }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Detail Info Grid --}}
                <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    {{-- Ruangan --}}
                    <div
                        class="sm:col-span-2 rounded-2xl border border-zinc-800/60 bg-zinc-900/40 p-4 transition-colors hover:border-zinc-700/60">
                        <dt class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-zinc-400">
                            <svg class="h-4 w-4 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.008v.008H6.75V6.75zm0 3h.008v.008H6.75V9.75zm0 3h.008v.008H6.75v-.008zm0 3h.008v.008H6.75v-.008zm0 3h.008v.008H6.75v-.008zm3.75-12h.008v.008h-.008V6.75zm0 3h.008v.008h-.008V9.75zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                            </svg>
                            Ruangan yang Dipinjam
                        </dt>
                        <dd class="mt-2 text-base font-semibold text-white">
                            {{ $peminjaman->ruangan->nama_ruangan }}
                        </dd>
                    </div>

                    {{-- Tanggal --}}
                    <div
                        class="rounded-2xl border border-zinc-800/60 bg-zinc-900/40 p-4 transition-colors hover:border-zinc-700/60">
                        <dt class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-zinc-400">
                            <svg class="h-4 w-4 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                            Tanggal Pelaksanaan
                        </dt>
                        <dd class="mt-2 text-sm font-medium text-zinc-200">
                            {{ \Carbon\Carbon::parse($peminjaman->tanggal)->translatedFormat('l, d F Y') }}
                        </dd>
                    </div>

                    {{-- Waktu --}}
                    <div
                        class="rounded-2xl border border-zinc-800/60 bg-zinc-900/40 p-4 transition-colors hover:border-zinc-700/60">
                        <dt class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-zinc-400">
                            <svg class="h-4 w-4 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Waktu Peminjaman
                        </dt>
                        <dd class="mt-2 text-sm font-medium text-zinc-200">
                            {{ substr($peminjaman->jam_mulai, 0, 5) }} – {{ substr($peminjaman->jam_selesai, 0, 5) }} WIB
                        </dd>
                    </div>

                    {{-- Keperluan --}}
                    <div
                        class="sm:col-span-2 rounded-2xl border border-zinc-800/60 bg-zinc-900/40 p-4 transition-colors hover:border-zinc-700/60">
                        <dt class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-zinc-400">
                            <svg class="h-4 w-4 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                            </svg>
                            Maksud & Keperluan
                        </dt>
                        <dd class="mt-2 text-sm leading-relaxed text-zinc-200 whitespace-pre-line">
                            {{ $peminjaman->keperluan }}
                        </dd>
                    </div>

                </dl>
            </div>

            {{-- Fasilitas Tambahan Card --}}
            <div class="rounded-3xl border border-zinc-800/80 bg-[#111113] p-6 sm:p-8 shadow-2xl">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-white">Fasilitas Tambahan</h2>
                        <p class="text-xs text-zinc-500 mt-0.5">Daftar peralatan tambahan yang dipinjam</p>
                    </div>

                    <span
                        class="rounded-full bg-zinc-800/80 px-3 py-1 text-xs font-medium text-zinc-400 border border-zinc-700/50">
                        {{ $peminjaman->detailPeminjaman->count() }} item
                    </span>
                </div>

                @if ($peminjaman->detailPeminjaman->isEmpty())
                    <div class="rounded-2xl border border-dashed border-zinc-800/80 p-6 text-center">
                        <p class="text-xs text-zinc-500">Tidak ada fasilitas tambahan yang diajukan untuk peminjaman ini.
                        </p>
                    </div>
                @else
                    <div class="divide-y divide-zinc-800/60 rounded-2xl border border-zinc-800/60 bg-zinc-900/40">
                        @foreach ($peminjaman->detailPeminjaman as $detail)
                            <div class="flex items-center justify-between p-4 transition-colors hover:bg-zinc-800/30">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-9 w-9 items-center justify-center rounded-xl bg-zinc-800 text-zinc-400 ring-1 ring-zinc-700/50">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-zinc-200">
                                        {{ $detail->fasilitas->nama_fasilitas }}
                                    </span>
                                </div>

                                <span
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-zinc-800/80 px-3 py-1 text-xs font-semibold text-zinc-300 ring-1 ring-inset ring-zinc-700/60">
                                    {{ $detail->jumlah }} <span class="text-zinc-500 font-normal">unit</span>
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Footer Action --}}
            <div class="flex items-center justify-between pt-2">
                <a href="{{ route('peminjam.peminjaman.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-zinc-800 bg-zinc-900/80 px-4 py-2.5 text-sm font-medium text-zinc-300 transition-all hover:bg-zinc-800 hover:text-white active:scale-95">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    <span>Kembali ke Riwayat</span>
                </a>
            </div>

        </div>

    </div>

@endsection
