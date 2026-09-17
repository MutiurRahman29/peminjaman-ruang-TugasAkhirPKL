@extends('layouts.app')

@section('title', 'Detail Laporan Peminjaman')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">

        {{-- Page Header & Nav --}}
        <div class="mb-8 animate-fade-up animate-duration-[600ms] animate-ease-out">
            <nav class="mb-3 flex items-center gap-2 text-xs font-medium text-gray-400">
                <a href="{{ route('dashboard') }}" class="transition-colors hover:text-amber-400">Dashboard</a>
                <span>/</span>
                <a href="{{ route('admin.peminjaman.index') }}" class="transition-colors hover:text-amber-400">Laporan Peminjaman</a>
                <span>/</span>
                <span class="text-gray-200">Detail</span>
            </nav>

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">
                        Detail Peminjaman
                    </h1>
                    <p class="mt-1 text-sm text-gray-400">
                        Rincian informasi lengkap permohonan peminjaman ruangan.
                    </p>
                </div>

                {{-- Back Link Button --}}
                <a
                    href="{{ route('admin.peminjaman.index') }}"
                    class="inline-flex items-center gap-2 self-start rounded-xl border border-gray-800 bg-gray-900 px-4 py-2.5 text-xs font-medium text-gray-300 transition-all hover:border-gray-700 hover:bg-gray-800 hover:text-white sm:self-auto"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    <span>Kembali ke Laporan</span>
                </a>
            </div>
        </div>

        {{-- Status Header Card --}}
        @php
            $st = strtolower($peminjaman->status->value);
            $statusConfig = match (true) {
                $st === 'disetujui' => [
                    'badge' => 'border-emerald-500/30 bg-emerald-500/10 text-emerald-400',
                    'dot' => 'bg-emerald-400',
                    'icon_bg' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                ],
                $st === 'ditolak' => [
                    'badge' => 'border-rose-500/30 bg-rose-500/10 text-rose-400',
                    'dot' => 'bg-rose-400',
                    'icon_bg' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                ],
                $st === 'selesai' => [
                    'badge' => 'border-sky-500/30 bg-sky-500/10 text-sky-400',
                    'dot' => 'bg-sky-400',
                    'icon_bg' => 'bg-sky-500/10 text-sky-400 border-sky-500/20',
                ],
                default => [
                    'badge' => 'border-amber-500/30 bg-amber-500/10 text-amber-400',
                    'dot' => 'bg-amber-400 animate-pulse',
                    'icon_bg' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                ],
            };
        @endphp

        <div class="mb-6 rounded-2xl border border-gray-800 bg-gray-900 p-6 shadow-xl animate-fade-up animate-duration-[700ms] animate-delay-75 animate-ease-out">
            <div class="flex items-center justify-between border-b border-gray-800/80 pb-5">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl border {{ $statusConfig['icon_bg'] }}">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.158.79.418 1.071.228.246.526.402.858.448.283.04.57.017.842-.068.318-.098.6-.28.815-.523.25-.282.4-.653.4-1.057 0-.23-.035-.454-.1-.664M12 21a9 9 0 1 1 0-18 9 9 0 0 1 0 18Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Status Transaksi</p>
                        <p class="text-sm font-semibold text-white">ID Peminjaman #{{ $peminjaman->id ?? $peminjaman->id_peminjaman }}</p>
                    </div>
                </div>

                <span class="inline-flex items-center gap-2 rounded-full border px-3.5 py-1.5 text-xs font-semibold tracking-wide uppercase {{ $statusConfig['badge'] }}">
                    <span class="h-2 w-2 rounded-full {{ $statusConfig['dot'] }}"></span>
                    {{ $peminjaman->status->value }}
                </span>
            </div>

            {{-- Specification Grid --}}
            <div class="mt-6 grid gap-6 sm:grid-cols-2">

                {{-- Peminjam --}}
                <div class="flex items-start gap-3.5">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-gray-800 bg-gray-950/60 text-gray-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Peminjam</p>
                        <p class="mt-0.5 text-sm font-semibold text-white">{{ $peminjaman->user->nama }}</p>
                        @if (isset($peminjaman->user->username))
                            <p class="text-xs text-gray-400">@ {{ $peminjaman->user->username }}</p>
                        @endif
                    </div>
                </div>

                {{-- Ruangan --}}
                <div class="flex items-start gap-3.5">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-gray-800 bg-gray-950/60 text-gray-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.008v.008H6.75V6.75Zm0 3h.008v.008H6.75V9.75Zm0 3h.008v.008H6.75v-.008Zm0 3h.008v.008H6.75v-.008Zm6-9h.008v.008h-.008V6.75Zm0 3h.008v.008h-.008V9.75Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Ruangan</p>
                        <p class="mt-0.5 text-sm font-semibold text-white">{{ $peminjaman->ruangan->nama_ruangan }}</p>
                    </div>
                </div>

                {{-- Tanggal --}}
                <div class="flex items-start gap-3.5">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-gray-800 bg-gray-950/60 text-gray-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Tanggal Pelaksanaan</p>
                        <p class="mt-0.5 text-sm font-semibold text-white">{{ $peminjaman->tanggal->format('d F Y') }}</p>
                    </div>
                </div>

                {{-- Waktu --}}
                <div class="flex items-start gap-3.5">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-gray-800 bg-gray-950/60 text-gray-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Jam Operasional</p>
                        <div class="mt-1">
                            <span class="inline-flex items-center gap-1 font-mono text-xs font-semibold text-amber-400 rounded-lg border border-amber-500/20 bg-amber-500/10 px-2.5 py-1">
                                {{ substr($peminjaman->jam_mulai, 0, 5) }} – {{ substr($peminjaman->jam_selesai, 0, 5) }} WIB
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Keperluan Section --}}
            <div class="mt-6 border-t border-gray-800/80 pt-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Keperluan / Alasan Peminjaman</p>
                <div class="mt-2.5 rounded-xl border border-gray-800/80 bg-gray-950/50 p-4 text-sm leading-relaxed text-gray-300">
                    {{ $peminjaman->keperluan }}
                </div>
            </div>
        </div>

        {{-- Fasilitas Tambahan Card --}}
        <div class="rounded-2xl border border-gray-800 bg-gray-900 p-6 shadow-xl animate-fade-up animate-duration-[800ms] animate-delay-150 animate-ease-out">
            <div class="mb-4 flex items-center gap-2 border-b border-gray-800/80 pb-3 text-xs font-semibold uppercase tracking-wider text-amber-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                </svg>
                <span>Fasilitas Tambahan</span>
            </div>

            @if ($peminjaman->detailPeminjaman->isEmpty())
                <div class="rounded-xl border border-dashed border-gray-800 bg-gray-950/40 px-4 py-6 text-center">
                    <p class="text-xs text-gray-500">Tidak ada fasilitas tambahan yang dipesan untuk kegiatan ini.</p>
                </div>
            @else
                <div class="grid gap-3 sm:grid-cols-2">
                    @foreach ($peminjaman->detailPeminjaman as $detail)
                        <div class="flex items-center justify-between rounded-xl border border-gray-800 bg-gray-950/60 px-4 py-3 transition-colors hover:border-gray-700">
                            <span class="text-sm font-medium text-gray-200">
                                {{ $detail->fasilitas->nama_fasilitas }}
                            </span>
                            <span class="inline-flex items-center rounded-lg border border-amber-500/20 bg-amber-500/10 px-2.5 py-1 font-mono text-xs font-semibold text-amber-400">
                                {{ $detail->jumlah }} Unit
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Bottom Actions --}}
        <div class="mt-8 flex items-center justify-between animate-fade-up animate-duration-[900ms] animate-delay-200 animate-ease-out">
            <a
                href="{{ route('admin.peminjaman.index') }}"
                class="inline-flex items-center gap-2 text-xs font-medium text-gray-400 transition-colors hover:text-white"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali ke Laporan</span>
            </a>

            <button
                onclick="window.print()"
                class="inline-flex items-center gap-2 rounded-xl border border-gray-800 bg-gray-900 px-4 py-2 text-xs font-medium text-gray-300 transition-all hover:border-gray-700 hover:bg-gray-800 hover:text-white"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231a1.125 1.125 0 0 1-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-19.126 0C1.033 7.441.265 8.375.265 9.456v6.294A2.25 2.25 0 0 0 2.515 18h1.092" />
                </svg>
                <span>Cetak Rincian</span>
            </button>
        </div>

    </div>
@endsection
