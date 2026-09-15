@extends('layouts.app')

@section('title', 'Detail Laporan Peminjaman')

@section('content')

<div class="mx-auto max-w-2xl px-6 py-8">

    <div class="mb-6">
        <p class="text-sm text-gray-400">Administrasi · Laporan Peminjaman</p>
        <h1 class="mt-1 text-2xl font-semibold text-white">
            Detail Peminjaman
        </h1>
    </div>


    {{-- Detail Card --}}
    <div class="mb-6 overflow-hidden rounded-xl border border-gray-700 bg-gray-800">

        <dl class="divide-y divide-gray-700">
            <div class="flex items-start gap-4 px-6 py-4">
                <dt class="w-28 shrink-0 text-sm text-gray-400">Peminjam</dt>
                <dd class="text-sm font-medium text-white">{{ $peminjaman->user->nama }}</dd>
            </div>
            <div class="flex items-start gap-4 px-6 py-4">
                <dt class="w-28 shrink-0 text-sm text-gray-400">Ruangan</dt>
                <dd class="text-sm text-gray-200">{{ $peminjaman->ruangan->nama_ruangan }}</dd>
            </div>
            <div class="flex items-start gap-4 px-6 py-4">
                <dt class="w-28 shrink-0 text-sm text-gray-400">Tanggal</dt>
                <dd class="text-sm text-gray-200">{{ $peminjaman->tanggal->toDateString() }}</dd>
            </div>
            <div class="flex items-start gap-4 px-6 py-4">
                <dt class="w-28 shrink-0 text-sm text-gray-400">Waktu</dt>
                <dd class="text-sm text-gray-200">{{ substr($peminjaman->jam_mulai, 0, 5) }}–{{ substr($peminjaman->jam_selesai, 0, 5) }}</dd>
            </div>
            <div class="flex items-start gap-4 px-6 py-4">
                <dt class="w-28 shrink-0 text-sm text-gray-400">Keperluan</dt>
                <dd class="text-sm leading-6 text-gray-200">{{ $peminjaman->keperluan }}</dd>
            </div>
            <div class="flex items-start gap-4 px-6 py-4">
                <dt class="w-28 shrink-0 text-sm text-gray-400">Status</dt>
                <dd>
                    @php $st = $peminjaman->status->value; @endphp
                    @if (strtolower($st) === 'disetujui')
                        <span class="text-sm font-medium text-green-300">{{ $st }}</span>
                    @elseif (strtolower($st) === 'ditolak')
                        <span class="text-sm font-medium text-red-400">{{ $st }}</span>
                    @elseif (strtolower($st) === 'selesai')
                        <span class="text-sm font-medium text-blue-300">{{ $st }}</span>
                    @else
                        <span class="text-sm font-medium text-yellow-300">{{ $st }}</span>
                    @endif
                </dd>
            </div>
        </dl>

    </div>


    {{-- Fasilitas --}}
    <div class="mb-6">
        <h2 class="mb-3 text-sm font-medium text-gray-400">Fasilitas Tambahan</h2>

        @if ($peminjaman->detailPeminjaman->isEmpty())
            <p class="text-sm text-gray-500">Tidak ada fasilitas tambahan.</p>
        @else
            <div class="overflow-hidden rounded-xl border border-gray-700 bg-gray-800">
                <ul class="divide-y divide-gray-700">
                    @foreach ($peminjaman->detailPeminjaman as $detail)
                        <li class="flex items-center justify-between px-6 py-3">
                            <span class="text-sm text-gray-200">{{ $detail->fasilitas->nama_fasilitas }}: {{ $detail->jumlah }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>


    {{-- Navigation --}}
    <div class="flex items-center gap-4">
        <a
            href="{{ route('admin.peminjaman.index') }}"
            class="text-sm text-gray-400 transition hover:text-white"
        >
            Kembali ke laporan
        </a>
    </div>

</div>

@endsection
