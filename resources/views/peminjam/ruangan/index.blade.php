@extends('layouts.app')

@section('title', 'Katalog Ruangan')

@section('content')

<div class="mx-auto max-w-7xl px-6 py-8">

    {{-- Page Header --}}
    <div class="mb-8">
        <p class="mb-2 text-sm font-medium text-gray-400">
            Eksplorasi
        </p>

        <h1 class="text-3xl font-semibold tracking-tight text-white">
            Katalog Ruangan
        </h1>

        <p class="mt-2 text-sm text-gray-400">
            Lihat ruangan yang tersedia untuk digunakan.
        </p>
    </div>


    {{-- Content --}}
    <div class="overflow-hidden rounded-xl border border-gray-700 bg-gray-800">

        @if ($ruangan->isEmpty())

            <div class="flex flex-col items-center justify-center px-6 py-20 text-center">

                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full border border-gray-600 bg-gray-700 text-gray-400">
                    —
                </div>

                <h2 class="text-lg font-semibold text-white">
                    Belum ada ruangan
                </h2>

                <p class="mt-2 text-sm text-gray-400">
                    Tidak ada ruangan tersedia.
                </p>

            </div>

        @else

            <div class="overflow-x-auto">

                <table class="w-full text-left text-sm">

                    <thead class="border-b border-gray-700 bg-gray-750">
                        <tr>
                            <th class="px-6 py-4 font-medium text-gray-400">Nama Ruangan</th>
                            <th class="px-6 py-4 font-medium text-gray-400">Kapasitas</th>
                            <th class="px-6 py-4 font-medium text-gray-400">Lokasi</th>
                            <th class="px-6 py-4 font-medium text-gray-400">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-700">

                        @foreach ($ruangan as $item)

                            <tr class="transition hover:bg-gray-750">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-white">{{ $item->nama_ruangan }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-300">{{ $item->kapasitas }} orang</td>
                                <td class="px-6 py-4 text-gray-300">{{ $item->lokasi }}</td>
                                <td class="px-6 py-4">
                                    @if (strtolower($item->status->value) === 'tersedia')
                                        <span class="text-xs font-medium text-green-300">{{ $item->status->value }}</span>
                                    @else
                                        <span class="text-xs font-medium text-gray-400">{{ $item->status->value }}</span>
                                    @endif
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
