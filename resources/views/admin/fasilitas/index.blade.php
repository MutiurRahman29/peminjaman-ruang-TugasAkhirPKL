@extends('layouts.app')

@section('title', 'Kelola Fasilitas')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

        {{-- Top Navigation & Header --}}
        <div class="mb-8 animate-fade-up animate-duration-[600ms] animate-ease-out">
            <nav class="mb-3 flex items-center gap-2 text-xs font-medium text-gray-400">
                <a href="{{ route('dashboard') }}" class="transition-colors hover:text-amber-400">Dashboard</a>
                <span>/</span>
                <span class="text-gray-200">Kelola Fasilitas</span>
            </nav>

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">
                        Kelola Fasilitas
                    </h1>
                    <p class="mt-1 text-sm text-gray-400">
                        Kelola data fasilitas dan inventaris yang tersedia untuk peminjaman.
                    </p>
                </div>

                {{-- Add Button --}}
                <a href="{{ route('admin.fasilitas.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-4 py-2.5 text-sm font-semibold text-gray-950 shadow-md transition-all hover:bg-amber-400 hover:scale-[0.98] active:scale-95">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Tambah Fasilitas</span>
                </a>
            </div>
        </div>

        {{-- Flash Alerts --}}
        @if (session('success'))
            <div
                class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm text-emerald-300 animate-fade-up">
                <svg class="h-5 w-5 flex-shrink-0 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div
                class="mb-6 flex items-center gap-3 rounded-2xl border border-rose-500/20 bg-rose-500/10 p-4 text-sm text-rose-300 animate-fade-up">
                <svg class="h-5 w-5 flex-shrink-0 text-rose-400" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Main Container Card --}}
        <div
            class="overflow-hidden rounded-2xl border border-gray-800 bg-gray-900 shadow-xl animate-fade-up animate-duration-[800ms] animate-delay-100 animate-ease-out">
            @if ($fasilitas->isEmpty())
                {{-- Empty State --}}
                <div class="flex flex-col items-center justify-center px-6 py-20 text-center">
                    <div
                        class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-800 text-gray-500 ring-1 ring-gray-700/60">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-white">Belum Ada Fasilitas</h2>
                    <p class="mt-1 max-w-sm text-sm text-gray-400">
                        Belum terdapat data fasilitas di dalam sistem. Tambahkan fasilitas baru untuk mulai mengelola
                        inventaris.
                    </p>
                    <a href="{{ route('admin.fasilitas.create') }}"
                        class="mt-6 inline-flex items-center gap-2 rounded-xl bg-amber-500 px-4 py-2.5 text-sm font-semibold text-gray-950 shadow-md transition-all hover:bg-amber-400 hover:scale-[0.98] active:scale-95">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Tambah Fasilitas Baru</span>
                    </a>
                </div>
            @else
                {{-- Data Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-300">
                        <thead
                            class="border-b border-gray-800 bg-gray-800/40 text-xs font-semibold uppercase tracking-wider text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-4">Nama Fasilitas</th>
                                <th scope="col" class="px-6 py-4">Jumlah</th>
                                <th scope="col" class="px-6 py-4">Kondisi</th>
                                <th scope="col" class="px-6 py-4">Keterangan</th>
                                <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach ($fasilitas as $item)
                                <tr class="transition-colors hover:bg-gray-800/40">
                                    {{-- Nama Fasilitas --}}
                                    <td class="px-6 py-4 font-semibold text-white">
                                        {{ $item->nama_fasilitas }}
                                    </td>

                                    {{-- Jumlah --}}
                                    <td class="px-6 py-4 text-gray-300">
                                        <span class="inline-flex items-center gap-1.5 font-medium">
                                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                            </svg>
                                            {{ $item->jumlah }} unit
                                        </span>
                                    </td>

                                    {{-- Kondisi Badge --}}
                                    <td class="px-6 py-4">
                                        @php $kondisi = $item->kondisi->value; @endphp
                                        @if (strtolower($kondisi) === 'baik')
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-md bg-emerald-500/10 px-2.5 py-1 text-xs font-semibold text-emerald-400 ring-1 ring-inset ring-emerald-500/20">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                                {{ $kondisi }}
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-md bg-amber-500/10 px-2.5 py-1 text-xs font-semibold text-amber-400 ring-1 ring-inset ring-amber-500/20">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                                                {{ $kondisi }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Keterangan --}}
                                    <td class="px-6 py-4 text-gray-400">
                                        {{ $item->keterangan ?: '-' }}
                                    </td>

                                    {{-- Action Buttons --}}
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.fasilitas.edit', $item) }}"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-gray-700 bg-gray-800/80 px-3 py-1.5 text-xs font-medium text-gray-200 transition-all hover:bg-gray-700 hover:text-white hover:scale-[0.98] active:scale-95">
                                                <svg class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                                <span>Edit</span>
                                            </a>

                                            <form method="POST" action="{{ route('admin.fasilitas.destroy', $item) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1.5 rounded-lg border border-rose-500/30 bg-rose-500/10 px-3 py-1.5 text-xs font-medium text-rose-400 transition-all hover:bg-rose-500/20 hover:border-rose-500/50 hover:scale-[0.98] active:scale-95">
                                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                    <span>Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Footer Back Link --}}
        <div class="mt-8 flex items-center text-xs font-medium text-gray-400">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 transition-colors hover:text-white">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>

    </div>
@endsection
