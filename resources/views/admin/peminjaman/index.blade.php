@extends('layouts.app')

@section('title', 'Laporan Peminjaman')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

        {{-- Page Header --}}
        <div class="mb-8 animate-fade-up animate-duration-[600ms] animate-ease-out">
            <nav class="mb-3 flex items-center gap-2 text-xs font-medium text-gray-400">
                <a href="{{ route('dashboard') }}" class="transition-colors hover:text-amber-400">Dashboard</a>
                <span>/</span>
                <span class="text-gray-200">Laporan Peminjaman</span>
            </nav>

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">
                        Laporan Peminjaman
                    </h1>
                    <p class="mt-1 text-sm text-gray-400">
                        Pantau dan analisis seluruh aktivitas peminjaman ruangan dalam sistem.
                    </p>
                </div>

                {{-- Back Link --}}
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-2 self-start rounded-xl border border-gray-800 bg-gray-900 px-4 py-2 text-xs font-medium text-gray-300 transition-all hover:border-gray-700 hover:bg-gray-800 hover:text-white sm:self-auto">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        </div>

        {{-- Summary Cards Grid --}}
        <div
            class="mb-8 grid grid-cols-2 gap-4 lg:grid-cols-4 animate-fade-up animate-duration-[700ms] animate-delay-75 animate-ease-out">
            @foreach ($ringkasan as $status => $total)
                @php
                    $statusLower = strtolower($status);
                    $dotColor = match (true) {
                        str_contains($statusLower, 'setuju') || str_contains($statusLower, 'disetujui')
                            => 'bg-emerald-400 shadow-emerald-500/50',
                        str_contains($statusLower, 'tolak') || str_contains($statusLower, 'ditolak')
                            => 'bg-rose-400 shadow-rose-500/50',
                        str_contains($statusLower, 'selesai') => 'bg-sky-400 shadow-sky-500/50',
                        default => 'bg-amber-400 shadow-amber-500/50',
                    };
                    $badgeStyle = match (true) {
                        str_contains($statusLower, 'setuju') || str_contains($statusLower, 'disetujui')
                            => 'text-emerald-400 border-emerald-500/20 bg-emerald-500/10',
                        str_contains($statusLower, 'tolak') || str_contains($statusLower, 'ditolak')
                            => 'text-rose-400 border-rose-500/20 bg-rose-500/10',
                        str_contains($statusLower, 'selesai') => 'text-sky-400 border-sky-500/20 bg-sky-500/10',
                        default => 'text-amber-400 border-amber-500/20 bg-amber-500/10',
                    };
                @endphp
                <div
                    class="rounded-2xl border border-gray-800 bg-gray-900 p-5 shadow-lg transition-all hover:border-gray-700">
                    <div class="flex items-center justify-between">
                        <span
                            class="inline-flex items-center gap-2 rounded-lg border px-2.5 py-1 text-xs font-semibold tracking-wider uppercase {{ $badgeStyle }}">
                            <span class="h-2 w-2 rounded-full {{ $dotColor }} shadow-sm"></span>
                            {{ $status }}
                        </span>
                    </div>
                    <div class="mt-4">
                        <p class="text-3xl font-bold tracking-tight text-white">{{ number_format($total) }}</p>
                        <p class="mt-1 text-xs text-gray-500">Total Transaksi</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Filter Card --}}
        <div
            class="mb-8 rounded-2xl border border-gray-800 bg-gray-900 p-6 shadow-xl animate-fade-up animate-duration-[800ms] animate-delay-100 animate-ease-out">
            <div
                class="mb-5 flex items-center gap-2 border-b border-gray-800/80 pb-3 text-xs font-semibold uppercase tracking-wider text-amber-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                </svg>
                <span>Filter Laporan</span>
            </div>

            <form method="GET" action="{{ route('admin.peminjaman.index') }}"
                class="grid gap-4 sm:grid-cols-2 lg:grid-cols-6 items-end">

                {{-- Status --}}
                <div class="lg:col-span-1">
                    <label for="status"
                        class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-400">Status</label>
                    <div class="relative">
                        <select id="status" name="status"
                            class="w-full appearance-none rounded-xl border border-gray-800 bg-gray-950/60 px-3.5 py-2.5 pr-8 text-sm text-white transition-all focus:border-amber-500 focus:bg-gray-950 focus:outline-none focus:ring-2 focus:ring-amber-500/20">
                            <option value="" class="bg-gray-900 text-gray-400">Semua status</option>
                            @foreach (\App\Enums\StatusPeminjaman::cases() as $status)
                                <option value="{{ $status->value }}" class="bg-gray-900 text-white"
                                    @selected(($filters['status'] ?? '') === $status->value)>
                                    {{ $status->value }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-gray-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>
                    @error('status')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Ruangan --}}
                <div class="lg:col-span-1">
                    <label for="id_ruangan"
                        class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-400">Ruangan</label>
                    <div class="relative">
                        <select id="id_ruangan" name="id_ruangan"
                            class="w-full appearance-none rounded-xl border border-gray-800 bg-gray-950/60 px-3.5 py-2.5 pr-8 text-sm text-white transition-all focus:border-amber-500 focus:bg-gray-950 focus:outline-none focus:ring-2 focus:ring-amber-500/20">
                            <option value="" class="bg-gray-900 text-gray-400">Semua ruangan</option>
                            @foreach ($ruangan as $item)
                                <option value="{{ $item->id_ruangan }}" class="bg-gray-900 text-white"
                                    @selected((string) ($filters['id_ruangan'] ?? '') === (string) $item->id_ruangan)>
                                    {{ $item->nama_ruangan }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-gray-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>
                    @error('id_ruangan')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Peminjam --}}
                <div class="lg:col-span-1">
                    <label for="id_user"
                        class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-400">Peminjam</label>
                    <div class="relative">
                        <select id="id_user" name="id_user"
                            class="w-full appearance-none rounded-xl border border-gray-800 bg-gray-950/60 px-3.5 py-2.5 pr-8 text-sm text-white transition-all focus:border-amber-500 focus:bg-gray-950 focus:outline-none focus:ring-2 focus:ring-amber-500/20">
                            <option value="" class="bg-gray-900 text-gray-400">Semua peminjam</option>
                            @foreach ($users as $item)
                                <option value="{{ $item->id_user }}" class="bg-gray-900 text-white"
                                    @selected((string) ($filters['id_user'] ?? '') === (string) $item->id_user)>
                                    {{ $item->nama }} ({{ $item->username }})
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-gray-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>
                    @error('id_user')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Mulai --}}
                <div class="lg:col-span-1">
                    <label for="tanggal_mulai"
                        class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-400">Tgl Mulai</label>
                    <input id="tanggal_mulai" name="tanggal_mulai" type="date"
                        value="{{ $filters['tanggal_mulai'] ?? '' }}"
                        class="w-full rounded-xl border border-gray-800 bg-gray-950/60 px-3.5 py-2.5 text-sm text-white transition-all [color-scheme:dark] focus:border-amber-500 focus:bg-gray-950 focus:outline-none focus:ring-2 focus:ring-amber-500/20">
                    @error('tanggal_mulai')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Selesai --}}
                <div class="lg:col-span-1">
                    <label for="tanggal_selesai"
                        class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-400">Tgl Selesai</label>
                    <input id="tanggal_selesai" name="tanggal_selesai" type="date"
                        value="{{ $filters['tanggal_selesai'] ?? '' }}"
                        class="w-full rounded-xl border border-gray-800 bg-gray-950/60 px-3.5 py-2.5 text-sm text-white transition-all [color-scheme:dark] focus:border-amber-500 focus:bg-gray-950 focus:outline-none focus:ring-2 focus:ring-amber-500/20">
                    @error('tanggal_selesai')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-2 sm:col-span-2 lg:col-span-1">
                    <button type="submit"
                        class="inline-flex w-full items-center justify-center gap-1.5 rounded-xl bg-amber-500 px-4 py-2.5 text-sm font-semibold text-gray-950 shadow-md transition-all hover:bg-amber-400 hover:scale-[0.98] active:scale-95">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <span>Filter</span>
                    </button>

                    <a href="{{ route('admin.peminjaman.index') }}" title="Reset Filter"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-800 bg-gray-950/60 px-3.5 py-2.5 text-sm font-medium text-gray-400 transition-all hover:border-gray-700 hover:bg-gray-800 hover:text-white hover:scale-[0.98] active:scale-95">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </a>
                </div>

            </form>
        </div>

        {{-- Main Table Container --}}
        <div
            class="overflow-hidden rounded-2xl border border-gray-800 bg-gray-900 shadow-xl animate-fade-up animate-duration-[900ms] animate-delay-200 animate-ease-out">

            @if ($peminjaman->isEmpty())

                {{-- Empty State --}}
                <div class="flex flex-col items-center justify-center px-6 py-20 text-center">
                    <div
                        class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl border border-gray-800 bg-gray-950/60 text-gray-500 shadow-inner">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.25 11.25h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm-3-6h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm-3-6h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                        </svg>
                    </div>

                    <h3 class="text-base font-semibold text-white">
                        Tidak Ada Data Peminjaman
                    </h3>

                    <p class="mt-1 max-w-sm text-xs text-gray-400">
                        Tidak ditemukan data transaksi yang sesuai dengan kriteria filter yang Anda terapkan.
                    </p>

                    @if (!empty(filter_var_array($filters)))
                        <a href="{{ route('admin.peminjaman.index') }}"
                            class="mt-4 inline-flex items-center gap-1.5 rounded-xl border border-gray-700 bg-gray-800 px-4 py-2 text-xs font-medium text-gray-200 transition hover:bg-gray-700 hover:text-white">
                            Reset Filter Search
                        </a>
                    @endif
                </div>
            @else
                {{-- Table Data --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead
                            class="border-b border-gray-800 bg-gray-950/80 text-xs font-semibold uppercase tracking-wider text-gray-400">
                            <tr>
                                <th class="px-6 py-4">Peminjam</th>
                                <th class="px-6 py-4">Ruangan</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Waktu</th>
                                <th class="px-6 py-4">Keperluan</th>
                                <th class="px-6 py-4">Fasilitas</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-800/80">
                            @foreach ($peminjaman as $item)
                                <tr class="transition-colors hover:bg-gray-800/50">
                                    {{-- Peminjam --}}
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-white">{{ $item->user->nama }}</div>
                                        <div class="text-xs text-gray-500"> {{ $item->user->username }}</div>
                                    </td>

                                    {{-- Ruangan --}}
                                    <td class="px-6 py-4">
                                        <span class="font-medium text-gray-200">{{ $item->ruangan->nama_ruangan }}</span>
                                    </td>

                                    {{-- Tanggal --}}
                                    <td class="px-6 py-4 text-gray-300 whitespace-nowrap">
                                        {{ $item->tanggal->format('d M Y') }}
                                    </td>

                                    {{-- Waktu --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center gap-1 font-mono text-xs text-gray-300 rounded-lg border border-gray-800 bg-gray-950/60 px-2.5 py-1">
                                            {{ substr($item->jam_mulai, 0, 5) }} – {{ substr($item->jam_selesai, 0, 5) }}
                                        </span>
                                    </td>

                                    {{-- Keperluan --}}
                                    <td class="px-6 py-4 max-w-xs truncate text-gray-400" title="{{ $item->keperluan }}">
                                        {{ $item->keperluan }}
                                    </td>

                                    {{-- Fasilitas --}}
                                    <td class="px-6 py-4 text-gray-300 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center rounded-md bg-gray-800 px-2 py-1 text-xs font-medium text-gray-300">
                                            {{ $item->detailPeminjaman->count() }} Jenis
                                        </span>
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php $st = strtolower($item->status->value); @endphp
                                        @if ($st === 'disetujui')
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full border border-emerald-500/30 bg-emerald-500/10 px-3 py-1 text-xs font-medium text-emerald-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                                {{ $item->status->value }}
                                            </span>
                                        @elseif ($st === 'ditolak')
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full border border-rose-500/30 bg-rose-500/10 px-3 py-1 text-xs font-medium text-rose-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-rose-400"></span>
                                                {{ $item->status->value }}
                                            </span>
                                        @elseif ($st === 'selesai')
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full border border-sky-500/30 bg-sky-500/10 px-3 py-1 text-xs font-medium text-sky-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                                                {{ $item->status->value }}
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full border border-amber-500/30 bg-amber-500/10 px-3 py-1 text-xs font-medium text-amber-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                                {{ $item->status->value }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Detail Link --}}
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <a href="{{ route('admin.peminjaman.show', $item) }}"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-gray-700 bg-gray-800/80 px-3.5 py-1.5 text-xs font-medium text-gray-300 transition-all hover:border-amber-500/50 hover:bg-gray-700 hover:text-white hover:scale-[0.98] active:scale-95">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                            <span>Detail</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="border-t border-gray-800 bg-gray-950/40 px-6 py-4">
                    {{ $peminjaman->links() }}
                </div>

            @endif

        </div>

    </div>
@endsection
