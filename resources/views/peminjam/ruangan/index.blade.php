@extends('layouts.app')

@section('title', 'Katalog Ruangan')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

        {{-- Page Header & Breadcrumb/Back --}}
        <div class="mb-8 md:flex md:items-center md:justify-between">
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
                    Katalog Ruangan
                </h1>
                <p class="mt-2 text-sm text-gray-400">
                    Eksplorasi dan lihat ketersediaan ruangan untuk kebutuhan Anda.
                </p>
            </div>
        </div>

        {{-- Content Wrapper --}}
        <div class="overflow-hidden rounded-2xl border border-gray-800 bg-gray-900 shadow-sm">

            @if ($ruangan->isEmpty())
                {{-- Modern Empty State --}}
                <div class="flex flex-col items-center justify-center px-6 py-24 text-center">
                    <div
                        class="mb-5 flex h-14 w-14 items-center justify-center rounded-full bg-gray-800 ring-1 ring-gray-700">
                        <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-white">Belum ada ruangan</h2>
                    <p class="mt-2 text-sm max-w-sm text-gray-400">
                        Saat ini tidak ada data ruangan yang tersedia di dalam sistem.
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
                                    Ruangan</th>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">Kapasitas
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">Lokasi
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">Status
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-800">
                            @foreach ($ruangan as $item)
                                <tr class="transition-colors duration-200 hover:bg-gray-800/40">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-100">{{ $item->nama_ruangan }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-400">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                            </svg>
                                            {{ $item->kapasitas }} <span class="text-gray-500">orang</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-400">
                                        {{ $item->lokasi }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if (strtolower($item->status->value) === 'tersedia')
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-md bg-green-500/10 px-2 py-1 text-xs font-medium text-green-400 ring-1 ring-inset ring-green-500/20">
                                                <svg class="h-1.5 w-1.5 fill-green-400" viewBox="0 0 6 6">
                                                    <circle cx="3" cy="3" r="3" />
                                                </svg>
                                                {{ $item->status->value }}
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-md bg-gray-500/10 px-2 py-1 text-xs font-medium text-gray-400 ring-1 ring-inset ring-gray-500/20">
                                                <svg class="h-1.5 w-1.5 fill-gray-400" viewBox="0 0 6 6">
                                                    <circle cx="3" cy="3" r="3" />
                                                </svg>
                                                {{ $item->status->value }}
                                            </span>
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
