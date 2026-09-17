@extends('layouts.app')

@section('title', 'Riwayat Persetujuan Peminjaman')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

        {{-- Page Header --}}
        <div class="mb-8 animate-fade-up animate-duration-[600ms] animate-ease-out">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-indigo-400">
                        Operasional & Log
                    </span>
                    <h1 class="mt-1 text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Riwayat Persetujuan
                    </h1>
                    <p class="mt-2 text-sm text-gray-400">
                        Tinjau seluruh pengajuan peminjaman yang telah diproses sebelumnya.
                    </p>
                </div>

                <div>
                    <a href="{{ route('petugas.peminjaman.index') }}"
                        class="inline-flex items-center gap-2 rounded-xl border border-gray-700/80 bg-gray-800/60 px-4 py-2.5 text-sm font-semibold text-gray-300 shadow-sm transition-all hover:border-gray-600 hover:bg-gray-700 hover:text-white hover:scale-[0.98] active:scale-95">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.008v.008H3.75V6.75zm0 5.25h.008v.008H3.75V12zm0 5.25h.008v.008H3.75v-.008z" />
                        </svg>
                        <span>Antrean Peminjaman</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Content Table --}}
        <div class="overflow-hidden rounded-2xl border border-gray-800 bg-gray-900 shadow-xl animate-fade-up animate-duration-[800ms] animate-delay-100 animate-ease-out">

            @if ($peminjaman->isEmpty())
                {{-- Modern Empty History State --}}
                <div class="flex flex-col items-center justify-center px-6 py-24 text-center">
                    <div class="mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-800 ring-1 ring-gray-700/50">
                        <svg class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-white">Belum ada riwayat</h2>
                    <p class="mt-2 text-sm max-w-md text-gray-400">
                        Belum ada data peminjaman yang disetujui, ditolak, maupun diselesaikan.
                    </p>
                </div>
            @else
                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm whitespace-nowrap">
                        <thead class="border-b border-gray-800 bg-gray-800/50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">Peminjam</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">Ruangan</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">Tanggal</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">Waktu</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">Keperluan</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">Fasilitas</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">Status</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-400">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-800">
                            @foreach ($peminjaman as $item)
                                <tr class="transition-colors duration-200 hover:bg-gray-800/40">
                                    {{-- User Info --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <p class="font-medium text-white">{{ $item->user->nama }}</p>
                                        </div>
                                    </td>

                                    {{-- Ruangan --}}
                                    <td class="px-6 py-4 font-medium text-gray-200">
                                        {{ $item->ruangan->nama_ruangan }}
                                    </td>

                                    {{-- Tanggal --}}
                                    <td class="px-6 py-4 text-gray-400">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                                        </div>
                                    </td>

                                    {{-- Waktu --}}
                                    <td class="px-6 py-4 text-gray-400">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ substr($item->jam_mulai, 0, 5) }} – {{ substr($item->jam_selesai, 0, 5) }}
                                        </div>
                                    </td>

                                    {{-- Keperluan --}}
                                    <td class="px-6 py-4 max-w-xs truncate text-gray-300" title="{{ $item->keperluan }}">
                                        {{ $item->keperluan }}
                                    </td>

                                    {{-- Fasilitas --}}
                                    <td class="px-6 py-4 text-gray-400">
                                        @if($item->detailPeminjaman->count() > 0)
                                            <span class="inline-flex items-center gap-1 rounded-md bg-gray-800 px-2.5 py-1 text-xs font-medium text-gray-300 ring-1 ring-inset ring-gray-700/60">
                                                {{ $item->detailPeminjaman->count() }} jenis
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-600 italic">Tanpa fasilitas</span>
                                        @endif
                                    </td>

                                    {{-- Dynamic Status Pill --}}
                                    <td class="px-6 py-4">
                                        @php $st = strtolower($item->status->value); @endphp

                                        @if ($st === 'disetujui')
                                            <span class="inline-flex items-center gap-1.5 rounded-md bg-emerald-500/10 px-2.5 py-1 text-xs font-medium text-emerald-400 ring-1 ring-inset ring-emerald-500/20">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>
                                                {{ $item->status->value }}
                                            </span>
                                        @elseif ($st === 'ditolak')
                                            <span class="inline-flex items-center gap-1.5 rounded-md bg-rose-500/10 px-2.5 py-1 text-xs font-medium text-rose-400 ring-1 ring-inset ring-rose-500/20">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                {{ $item->status->value }}
                                            </span>
                                        @elseif ($st === 'selesai')
                                            <span class="inline-flex items-center gap-1.5 rounded-md bg-sky-500/10 px-2.5 py-1 text-xs font-medium text-sky-400 ring-1 ring-inset ring-sky-500/20">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $item->status->value }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-md bg-amber-500/10 px-2.5 py-1 text-xs font-medium text-amber-400 ring-1 ring-inset ring-amber-500/20">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                                                {{ $item->status->value }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Action --}}
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('petugas.peminjaman.show', $item) }}"
                                            class="inline-flex items-center gap-1 rounded-xl border border-gray-700/80 bg-gray-800 px-3 py-1.5 text-xs font-medium text-gray-300 transition-all hover:border-gray-600 hover:bg-gray-700 hover:text-white hover:scale-[0.98] active:scale-95">
                                            <span>Lihat Detail</span>
                                            <svg class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
