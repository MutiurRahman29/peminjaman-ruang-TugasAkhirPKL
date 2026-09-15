@extends('layouts.app')

@section('title', 'Kelola Ruangan')

@section('content')

<div class="mx-auto max-w-7xl px-6 py-8">

    {{-- Page Header --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

        <div>
            <p class="mb-2 text-sm font-medium text-gray-400">
                Administrasi
            </p>

            <h1 class="text-3xl font-semibold tracking-tight text-white">
                Kelola Ruangan
            </h1>

            <p class="mt-2 text-sm text-gray-400">
                Kelola data, kapasitas, lokasi, dan status ruangan.
            </p>
        </div>

        <a
            href="{{ route('admin.ruangan.create') }}"
            class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-900 transition hover:bg-gray-200"
        >
            + Tambah Ruangan
        </a>

    </div>


    {{-- Flash Message --}}
    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-800 bg-green-950/40 px-4 py-3 text-sm text-green-300">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 rounded-lg border border-red-800 bg-red-950/40 px-4 py-3 text-sm text-red-300">
            {{ session('error') }}
        </div>
    @endif


    {{-- Content --}}
    <div class="overflow-hidden rounded-xl border border-gray-700 bg-gray-800">

        @if ($ruangan->isEmpty())

            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center px-6 py-20 text-center">

                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full border border-gray-600 bg-gray-700 text-gray-400">
                    —
                </div>

                <h2 class="text-lg font-semibold text-white">
                    Belum ada ruangan.
                </h2>

                <p class="mt-2 max-w-md text-sm text-gray-400">
                    Belum terdapat data ruangan di dalam sistem.
                    Tambahkan ruangan untuk mulai mengelola fasilitas.
                </p>

                <a
                    href="{{ route('admin.ruangan.create') }}"
                    class="mt-6 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 transition hover:bg-gray-200"
                >
                    Tambah Ruangan
                </a>

            </div>

        @else

            {{-- Table --}}
            <div class="overflow-x-auto">

                <table class="w-full text-left text-sm">

                    <thead class="border-b border-gray-700 bg-gray-750">
                        <tr>
                            <th class="px-6 py-4 font-medium text-gray-400">
                                Nama Ruangan
                            </th>

                            <th class="px-6 py-4 font-medium text-gray-400">
                                Kapasitas
                            </th>

                            <th class="px-6 py-4 font-medium text-gray-400">
                                Lokasi
                            </th>

                            <th class="px-6 py-4 font-medium text-gray-400">
                                Status
                            </th>

                            <th class="px-6 py-4 text-right font-medium text-gray-400">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-700">

                        @foreach ($ruangan as $item)

                            <tr class="transition hover:bg-gray-750">

                                <td class="px-6 py-4">
                                    <div class="font-medium text-white">
                                        {{ $item->nama_ruangan }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-gray-300">
                                    {{ $item->kapasitas }} orang
                                </td>

                                <td class="px-6 py-4 text-gray-300">
                                    {{ $item->lokasi }}
                                </td>

                                <td class="px-6 py-4">

                                    @php
                                        $status = $item->status->value;
                                    @endphp

                                    @if (strtolower($status) === 'tersedia')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium text-green-300">
                                            {{ $status }}
                                        </span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium text-gray-300">
                                            {{ $status }}
                                        </span>
                                    @endif

                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex items-center justify-end gap-2">

                                        <a
                                            href="{{ route('admin.ruangan.edit', $item) }}"
                                            class="rounded-md border border-gray-600 px-3 py-1.5 text-xs font-medium text-gray-300 transition hover:border-gray-500 hover:bg-gray-700 hover:text-white"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('admin.ruangan.destroy', $item) }}"
                                            onsubmit="return confirm('Hapus ruangan ini?');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-md border border-red-900 px-3 py-1.5 text-xs font-medium text-red-400 transition hover:bg-red-950 hover:text-red-300"
                                            >
                                                Hapus
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


    {{-- Back --}}
    <div class="mt-6">

        <a
            href="{{ route('dashboard') }}"
            class="text-sm text-gray-400 transition hover:text-white"
        >
            Kembali
        </a>

    </div>

</div>

@endsection
