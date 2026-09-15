@extends('layouts.app')

@section('title', 'Detail Pengajuan')

@section('content')

<div class="mx-auto max-w-2xl px-6 py-8">

    <div class="mb-6">
        <p class="text-sm text-gray-400">Operasional · Antrean Peminjaman</p>
        <h1 class="mt-1 text-2xl font-semibold text-white">
            Detail Pengajuan
        </h1>
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
                            <span class="text-sm text-gray-200">{{ $detail->fasilitas->nama_fasilitas }}</span>
                            <span class="text-sm text-gray-400">{{ $detail->jumlah }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>


    {{-- Actions --}}
    @if ($peminjaman->status === \App\Enums\StatusPeminjaman::Menunggu)
        <div class="mb-6 flex items-center gap-3">

            <form method="POST" action="{{ route('petugas.peminjaman.approve', $peminjaman) }}">
                @csrf
                @method('PATCH')
                <button
                    type="submit"
                    class="rounded-md bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-200"
                >
                    Setujui
                </button>
            </form>

            <form method="POST" action="{{ route('petugas.peminjaman.reject', $peminjaman) }}">
                @csrf
                @method('PATCH')
                <button
                    type="submit"
                    class="rounded-md border border-red-900 px-4 py-2 text-sm font-medium text-red-400 transition hover:bg-red-950 hover:text-red-300"
                >
                    Tolak
                </button>
            </form>

        </div>
    @endif

    @if ($peminjaman->status === \App\Enums\StatusPeminjaman::Disetujui)
        <div class="mb-6">
            <form method="POST" action="{{ route('petugas.peminjaman.complete', $peminjaman) }}" onsubmit="return confirm('Tandai peminjaman ini selesai?');">
                @csrf
                @method('PATCH')
                <button
                    type="submit"
                    class="rounded-md border border-blue-800 px-4 py-2 text-sm font-medium text-blue-300 transition hover:bg-blue-950 hover:text-blue-200"
                >
                    Tandai Selesai
                </button>
            </form>
        </div>
    @endif


    {{-- Navigation --}}
    <div class="flex items-center gap-4">
        <a
            href="{{ route('petugas.peminjaman.index') }}"
            class="text-sm text-gray-400 transition hover:text-white"
        >
            Antrean
        </a>

        <span class="text-gray-600">·</span>

        <a
            href="{{ route('petugas.peminjaman.history') }}"
            class="text-sm text-gray-400 transition hover:text-white"
        >
            Riwayat
        </a>
    </div>

</div>

@endsection
