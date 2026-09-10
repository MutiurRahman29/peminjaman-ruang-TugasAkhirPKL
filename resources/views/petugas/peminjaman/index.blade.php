@extends('layouts.app')

@section('title', 'Antrean Peminjaman')

@section('content')

<div class="mx-auto max-w-7xl px-6 py-8">

    {{-- Page Header --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

        <div>
            <p class="mb-2 text-sm font-medium text-gray-400">
                Operasional
            </p>

            <h1 class="text-3xl font-semibold tracking-tight text-white">
                Antrean Peminjaman
            </h1>

            <p class="mt-2 text-sm text-gray-400">
                Periksa dan proses pengajuan peminjaman yang masuk.
            </p>
        </div>

        <a
            href="{{ route('petugas.peminjaman.history') }}"
            class="inline-flex items-center justify-center rounded-lg border border-gray-600 px-4 py-2.5 text-sm font-medium text-gray-300 transition hover:border-gray-500 hover:bg-gray-700 hover:text-white"
        >
            Riwayat Persetujuan
        </a>

    </div>


    {{-- Flash --}}
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

        @if ($peminjaman->isEmpty())

            <div class="flex flex-col items-center justify-center px-6 py-20 text-center">

                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full border border-gray-600 bg-gray-700 text-gray-400">
                    —
                </div>

                <h2 class="text-lg font-semibold text-white">
                    Tidak ada antrean
                </h2>

                <p class="mt-2 text-sm text-gray-400">
                    Tidak ada pengajuan yang menunggu persetujuan saat ini.
                </p>

            </div>

        @else

            <div class="overflow-x-auto">

                <table class="w-full text-left text-sm">

                    <thead class="border-b border-gray-700 bg-gray-750">
                        <tr>
                            <th class="px-6 py-4 font-medium text-gray-400">Peminjam</th>
                            <th class="px-6 py-4 font-medium text-gray-400">Ruangan</th>
                            <th class="px-6 py-4 font-medium text-gray-400">Tanggal</th>
                            <th class="px-6 py-4 font-medium text-gray-400">Waktu</th>
                            <th class="px-6 py-4 font-medium text-gray-400">Keperluan</th>
                            <th class="px-6 py-4 font-medium text-gray-400">Fasilitas</th>
                            <th class="px-6 py-4 font-medium text-gray-400">Status</th>
                            <th class="px-6 py-4 text-right font-medium text-gray-400">Detail</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-700">

                        @foreach ($peminjaman as $item)

                            <tr class="transition hover:bg-gray-750">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-white">{{ $item->user->nama }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-300">{{ $item->ruangan->nama_ruangan }}</td>
                                <td class="px-6 py-4 text-gray-300">{{ $item->tanggal->toDateString() }}</td>
                                <td class="px-6 py-4 text-gray-300">{{ substr($item->jam_mulai, 0, 5) }}–{{ substr($item->jam_selesai, 0, 5) }}</td>
                                <td class="px-6 py-4 max-w-xs truncate text-gray-300">{{ $item->keperluan }}</td>
                                <td class="px-6 py-4 text-gray-300">{{ $item->detailPeminjaman->count() }} jenis</td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-medium text-yellow-300">{{ $item->status->value }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a
                                        href="{{ route('petugas.peminjaman.show', $item) }}"
                                        class="rounded-md border border-gray-600 px-3 py-1.5 text-xs font-medium text-gray-300 transition hover:border-gray-500 hover:bg-gray-700 hover:text-white"
                                    >
                                        Proses
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
