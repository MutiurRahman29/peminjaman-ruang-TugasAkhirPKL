@extends('layouts.app')

@section('title', 'Detail Pengajuan')

@section('content')
    <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">

        {{-- Top Navigation & Header --}}
        <div class="mb-8 animate-fade-up animate-duration-[600ms] animate-ease-out">
            <nav class="mb-3 flex items-center gap-2 text-xs font-medium text-gray-400">
                <a href="{{ route('petugas.peminjaman.index') }}" class="transition-colors hover:text-amber-400">Antrean Peminjaman</a>
                <span>/</span>
                <span class="text-gray-200">Detail Pengajuan</span>
            </nav>

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">
                        Detail Pengajuan Peminjaman
                    </h1>
                    <p class="mt-1 text-sm text-gray-400">
                        Periksa kelengkapan informasi peminjaman sebelum mengambil tindakan persetujuan.
                    </p>
                </div>

                {{-- Quick Back Button --}}
                <a href="{{ route('petugas.peminjaman.index') }}"
                    class="inline-flex items-center gap-2 text-xs font-semibold text-gray-400 transition-colors hover:text-white">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    <span>Kembali ke Antrean</span>
                </a>
            </div>
        </div>

        {{-- Flash Alerts --}}
        @if (session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm text-emerald-300 animate-fade-up">
                <svg class="h-5 w-5 flex-shrink-0 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 flex items-center gap-3 rounded-2xl border border-rose-500/20 bg-rose-500/10 p-4 text-sm text-rose-300 animate-fade-up">
                <svg class="h-5 w-5 flex-shrink-0 text-rose-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="space-y-6 animate-fade-up animate-duration-[800ms] animate-delay-100 animate-ease-out">

            {{-- Main Info Card --}}
            <div class="overflow-hidden rounded-2xl border border-gray-800 bg-gray-900 shadow-xl">
                <div class="border-b border-gray-800 bg-gray-800/40 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-300">Informasi Utama</h2>

                    {{-- Status Badge --}}
                    @php $st = strtolower($peminjaman->status->value); @endphp
                    @if ($st === 'disetujui')
                        <span class="inline-flex items-center gap-1.5 rounded-md bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-400 ring-1 ring-inset ring-emerald-500/20">
                            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                            {{ $peminjaman->status->value }}
                        </span>
                    @elseif ($st === 'ditolak')
                        <span class="inline-flex items-center gap-1.5 rounded-md bg-rose-500/10 px-3 py-1 text-xs font-semibold text-rose-400 ring-1 ring-inset ring-rose-500/20">
                            <span class="h-2 w-2 rounded-full bg-rose-400"></span>
                            {{ $peminjaman->status->value }}
                        </span>
                    @elseif ($st === 'selesai')
                        <span class="inline-flex items-center gap-1.5 rounded-md bg-sky-500/10 px-3 py-1 text-xs font-semibold text-sky-400 ring-1 ring-inset ring-sky-500/20">
                            <span class="h-2 w-2 rounded-full bg-sky-400"></span>
                            {{ $peminjaman->status->value }}
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-md bg-amber-500/10 px-3 py-1 text-xs font-semibold text-amber-400 ring-1 ring-inset ring-amber-500/20">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                            </span>
                            {{ $peminjaman->status->value }}
                        </span>
                    @endif
                </div>

                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">

                        {{-- Peminjam --}}
                        <div class="sm:col-span-1">
                            <dt class="text-xs font-medium uppercase tracking-wider text-gray-400">Peminjam</dt>
                            <dd class="mt-2 flex items-center gap-3">
                                <div>
                                    <div class="text-base font-semibold text-white">{{ $peminjaman->user->nama }}</div>
                                </div>
                            </dd>
                        </div>

                        {{-- Ruangan --}}
                        <div class="sm:col-span-1">
                            <dt class="text-xs font-medium uppercase tracking-wider text-gray-400">Ruangan</dt>
                            <dd class="mt-2 text-base font-semibold text-white">
                                {{ $peminjaman->ruangan->nama_ruangan }}
                            </dd>
                        </div>

                        {{-- Tanggal --}}
                        <div class="sm:col-span-1">
                            <dt class="text-xs font-medium uppercase tracking-wider text-gray-400">Tanggal Pelaksanaan</dt>
                            <dd class="mt-2 flex items-center gap-2 text-sm text-gray-200">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($peminjaman->tanggal)->translatedFormat('l, d F Y') }}</span>
                            </dd>
                        </div>

                        {{-- Waktu --}}
                        <div class="sm:col-span-1">
                            <dt class="text-xs font-medium uppercase tracking-wider text-gray-400">Jam Operasional</dt>
                            <dd class="mt-2 flex items-center gap-2 text-sm text-gray-200">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ substr($peminjaman->jam_mulai, 0, 5) }} – {{ substr($peminjaman->jam_selesai, 0, 5) }} WIB</span>
                            </dd>
                        </div>

                        {{-- Keperluan --}}
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-medium uppercase tracking-wider text-gray-400">Keperluan / Alasan</dt>
                            <dd class="mt-2 rounded-xl bg-gray-800/60 p-4 text-sm leading-relaxed text-gray-300 ring-1 ring-gray-800">
                                {{ $peminjaman->keperluan }}
                            </dd>
                        </div>

                    </dl>
                </div>
            </div>

            {{-- Fasilitas Tambahan Card --}}
            <div class="overflow-hidden rounded-2xl border border-gray-800 bg-gray-900 shadow-xl">
                <div class="border-b border-gray-800 bg-gray-800/40 px-6 py-4">
                    <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-300">Fasilitas Tambahan</h2>
                </div>

                <div class="p-6">
                    @if ($peminjaman->detailPeminjaman->isEmpty())
                        <p class="text-sm text-gray-500 italic">Tidak ada fasilitas tambahan yang diajukan.</p>
                    @else
                        <ul class="divide-y divide-gray-800 rounded-xl border border-gray-800 bg-gray-800/30">
                            @foreach ($peminjaman->detailPeminjaman as $detail)
                                <li class="flex items-center justify-between px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-800 text-gray-400 ring-1 ring-gray-700/60">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-200">{{ $detail->fasilitas->nama_fasilitas }}</span>
                                    </div>
                                    <span class="rounded-md bg-gray-800 px-3 py-1 text-xs font-semibold text-amber-400 ring-1 ring-inset ring-gray-700/80">
                                        {{ $detail->jumlah }} Unit
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            {{-- Action Controls Area --}}
            @if ($peminjaman->status === \App\Enums\StatusPeminjaman::Menunggu)
                <div class="rounded-2xl border border-amber-500/20 bg-amber-500/5 p-6 ring-1 ring-amber-500/10">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-base font-semibold text-white">Keputusan Approval</h3>
                            <p class="text-xs text-gray-400">Pilih salah satu tindakan untuk menindaklanjuti pengajuan ini.</p>
                        </div>

                        <div class="flex items-center gap-3">
                            {{-- Reject Action (Langsung Submit tanpa alert JS) --}}
                            <form method="POST" action="{{ route('petugas.peminjaman.reject', $peminjaman) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-xl border border-rose-500/30 bg-rose-500/10 px-5 py-2.5 text-sm font-semibold text-rose-400 transition-all hover:bg-rose-500/20 hover:border-rose-500/50 hover:scale-[0.98] active:scale-95">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <span>Tolak</span>
                                </button>
                            </form>

                            {{-- Approve Action --}}
                            <form method="POST" action="{{ route('petugas.peminjaman.approve', $peminjaman) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-xl bg-emerald-500 px-5 py-2.5 text-sm font-semibold text-gray-950 shadow-md transition-all hover:bg-emerald-400 hover:scale-[0.98] active:scale-95">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                    <span>Setujui Pengajuan</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            @if ($peminjaman->status === \App\Enums\StatusPeminjaman::Disetujui)
                <div class="rounded-2xl border border-sky-500/20 bg-sky-500/5 p-6 ring-1 ring-sky-500/10">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-base font-semibold text-white">Penyelesaian Peminjaman</h3>
                            <p class="text-xs text-gray-400">Tandai bahwa kegiatan telah usai dan fasilitas/ruangan telah dikembalikan.</p>
                        </div>

                        {{-- Complete Action (Langsung Submit tanpa alert JS) --}}
                        <form method="POST" action="{{ route('petugas.peminjaman.complete', $peminjaman) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="inline-flex items-center gap-2 rounded-xl bg-sky-500 px-5 py-2.5 text-sm font-semibold text-gray-950 shadow-md transition-all hover:bg-sky-400 hover:scale-[0.98] active:scale-95">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Tandai Selesai</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            {{-- Navigation Links Footer --}}
            <div class="flex items-center justify-center gap-4 pt-4 text-xs font-medium text-gray-400">
                <a href="{{ route('petugas.peminjaman.index') }}" class="transition-colors hover:text-white">Antrean Peminjaman</a>
                <span class="text-gray-700">•</span>
                <a href="{{ route('petugas.peminjaman.history') }}" class="transition-colors hover:text-white">Riwayat Persetujuan</a>
            </div>

        </div>
    </div>
@endsection
