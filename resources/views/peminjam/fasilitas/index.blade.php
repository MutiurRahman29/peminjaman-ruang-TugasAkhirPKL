@extends('layouts.app')

@section('title', 'Katalog Fasilitas')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

        {{-- Page Header & Breadcrumb/Back --}}
        <div class="mb-8 md:flex md:items-center md:justify-between animate-fade-up animate-duration-[600ms] animate-ease-out">
            <div class="min-w-0 flex-1">
                {{-- Back Link dipindah ke atas agar alurnya lebih natural --}}
                <a href="{{ route('dashboard') }}"
                    class="group mb-4 inline-flex items-center text-sm font-medium text-gray-400 transition-colors hover:text-white">
                    <svg class="mr-2 h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Kembali ke Dashboard
                </a>

                <h1 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    Katalog Fasilitas
                </h1>
                <p class="mt-2 text-sm text-gray-400">
                    Eksplorasi dan lihat fasilitas yang tersedia untuk mendukung peminjaman Anda.
                </p>
            </div>
        </div>

        {{-- Content Wrapper --}}
        <div class="overflow-hidden rounded-2xl border border-gray-800 bg-gray-900 shadow-sm animate-fade-up animate-duration-[800ms] animate-delay-100 animate-ease-out">

            @if ($fasilitas->isEmpty())
                {{-- Modern Empty State --}}
                <div class="flex flex-col items-center justify-center px-6 py-24 text-center">
                    <div
                        class="mb-5 flex h-14 w-14 items-center justify-center rounded-full bg-gray-800 ring-1 ring-gray-700">
                        <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-white">Belum ada fasilitas</h2>
                    <p class="mt-2 text-sm max-w-sm text-gray-400">
                        Saat ini tidak ada data fasilitas yang tersedia di dalam sistem.
                    </p>
                </div>
            @else
                {{-- Modern Table Data --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm whitespace-nowrap">
                        <thead class="border-b border-gray-800 bg-gray-800/50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">Nama
                                    Fasilitas</th>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">Jumlah
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">Kondisi
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">
                                    Keterangan
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-800">
                            @foreach ($fasilitas as $item)
                                <tr class="transition-colors duration-200 hover:bg-gray-800/40">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-100">{{ $item->nama_fasilitas }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-400">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                            {{ $item->jumlah }} <span class="text-gray-500">unit</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if (strtolower($item->kondisi->value) === 'baik')
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-md bg-green-500/10 px-2.5 py-1 text-xs font-medium text-green-400 ring-1 ring-inset ring-green-500/20">
                                                <svg class="h-1.5 w-1.5 fill-green-400" viewBox="0 0 6 6">
                                                    <circle cx="3" cy="3" r="3" />
                                                </svg>
                                                {{ $item->kondisi->value }}
                                            </span>
                                        @elseif (strtolower($item->kondisi->value) === 'rusak ringan' || strtolower($item->kondisi->value) === 'perbaikan')
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-md bg-amber-500/10 px-2.5 py-1 text-xs font-medium text-amber-400 ring-1 ring-inset ring-amber-500/20">
                                                <svg class="h-1.5 w-1.5 fill-amber-400" viewBox="0 0 6 6">
                                                    <circle cx="3" cy="3" r="3" />
                                                </svg>
                                                {{ $item->kondisi->value }}
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-md bg-rose-500/10 px-2.5 py-1 text-xs font-medium text-rose-400 ring-1 ring-inset ring-rose-500/20">
                                                <svg class="h-1.5 w-1.5 fill-rose-400" viewBox="0 0 6 6">
                                                    <circle cx="3" cy="3" r="3" />
                                                </svg>
                                                {{ $item->kondisi->value }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-400">
                                        @if($item->keterangan)
                                            <span class="text-gray-300">{{ $item->keterangan }}</span>
                                        @else
                                            <span class="text-gray-600 italic">Tidak ada keterangan</span>
                                        @endif
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
