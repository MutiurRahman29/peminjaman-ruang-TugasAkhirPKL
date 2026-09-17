@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

        {{-- Top Back Link & Page Header --}}
        <div class="mb-8 animate-fade-up animate-duration-[600ms] animate-ease-out">
            <a href="{{ route('dashboard') }}"
                class="group mb-4 inline-flex items-center text-sm font-medium text-gray-400 transition-colors hover:text-white">
                <svg class="mr-2 h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Kembali ke Dashboard
            </a>

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Riwayat Peminjaman
                    </h1>
                    <p class="mt-2 text-sm text-gray-400">
                        Pantau pengajuan dan status peminjaman ruangan serta fasilitas Anda.
                    </p>
                </div>

                <a href="{{ route('peminjam.peminjaman.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-gray-950 shadow-sm transition-all hover:bg-gray-200 hover:scale-[0.98] active:scale-95">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Ajukan Peminjaman</span>
                </a>
            </div>
        </div>

        {{-- Content / Table Wrapper --}}
        <div
            class="overflow-hidden rounded-2xl border border-gray-800 bg-gray-900 shadow-sm animate-fade-up animate-duration-[800ms] animate-delay-100 animate-ease-out">

            @if ($peminjaman->isEmpty())
                {{-- Modern Empty State --}}
                <div class="flex flex-col items-center justify-center px-6 py-24 text-center">
                    <div
                        class="mb-5 flex h-14 w-14 items-center justify-center rounded-full bg-gray-800 ring-1 ring-gray-700">
                        <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-white">Belum ada pengajuan</h2>
                    <p class="mt-2 text-sm max-w-sm text-gray-400">
                        Kamu belum pernah mengajukan peminjaman. Mulai dengan membuat pengajuan baru.
                    </p>
                    <a href="{{ route('peminjam.peminjaman.create') }}"
                        class="mt-6 inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-gray-950 shadow-sm transition-all hover:bg-gray-200 hover:scale-[0.98] active:scale-95">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Ajukan Peminjaman</span>
                    </a>
                </div>
            @else
                {{-- Modern Table Data --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm whitespace-nowrap">
                        <thead class="border-b border-gray-800 bg-gray-800/50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">
                                    Ruangan</th>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">
                                    Tanggal</th>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">
                                    Waktu</th>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">
                                    Keperluan</th>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">
                                    Fasilitas</th>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-400">
                                    Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-800">
                            @foreach ($peminjaman as $item)
                                <tr class="transition-colors duration-200 hover:bg-gray-800/40">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-100">{{ $item->ruangan->nama_ruangan }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-400">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-400">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ substr($item->jam_mulai, 0, 5) }} – {{ substr($item->jam_selesai, 0, 5) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 max-w-xs truncate text-gray-300" title="{{ $item->keperluan }}">
                                        {{ $item->keperluan }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-400">
                                        @if ($item->detailPeminjaman->count() > 0)
                                            <span
                                                class="inline-flex items-center gap-1 rounded-md bg-gray-800 px-2.5 py-1 text-xs font-medium text-gray-300 ring-1 ring-inset ring-gray-700/60">
                                                {{ $item->detailPeminjaman->count() }} jenis
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-600 italic">Tanpa fasilitas</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @php $st = strtolower($item->status->value ?? ''); @endphp
                                        @if ($st === 'disetujui')
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-md bg-green-500/10 px-2.5 py-1 text-xs font-medium text-green-400 ring-1 ring-inset ring-green-500/20">
                                                <svg class="h-1.5 w-1.5 fill-green-400" viewBox="0 0 6 6">
                                                    <circle cx="3" cy="3" r="3" />
                                                </svg>
                                                Disetujui
                                            </span>
                                        @elseif ($st === 'ditolak')
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-md bg-rose-500/10 px-2.5 py-1 text-xs font-medium text-rose-400 ring-1 ring-inset ring-rose-500/20">
                                                <svg class="h-1.5 w-1.5 fill-rose-400" viewBox="0 0 6 6">
                                                    <circle cx="3" cy="3" r="3" />
                                                </svg>
                                                Ditolak
                                            </span>
                                        @elseif ($st === 'selesai')
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-md bg-indigo-500/10 px-2.5 py-1 text-xs font-medium text-indigo-400 ring-1 ring-inset ring-indigo-500/20">
                                                <svg class="h-1.5 w-1.5 fill-indigo-400" viewBox="0 0 6 6">
                                                    <circle cx="3" cy="3" r="3" />
                                                </svg>
                                                Selesai
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-md bg-amber-500/10 px-2.5 py-1 text-xs font-medium text-amber-400 ring-1 ring-inset ring-amber-500/20">
                                                <svg class="h-1.5 w-1.5 fill-amber-400" viewBox="0 0 6 6">
                                                    <circle cx="3" cy="3" r="3" />
                                                </svg>
                                                {{ $item->status->value }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('peminjam.peminjaman.show', $item) }}"
                                            class="inline-flex items-center gap-1 rounded-lg border border-gray-700/80 bg-gray-800/60 px-3 py-1.5 text-xs font-medium text-gray-300 transition-all hover:border-gray-600 hover:bg-gray-700 hover:text-white">
                                            <span>Detail</span>
                                            <svg class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8.25 4.5l7.5 7.5-7.5 7.5" />
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
