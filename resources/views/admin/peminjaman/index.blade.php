@extends('layouts.app')

@section('title', 'Laporan Peminjaman')

@section('content')

<div class="mx-auto max-w-7xl px-6 py-8">

    {{-- Page Header --}}
    <div class="mb-8">
        <p class="mb-2 text-sm font-medium text-gray-400">
            Administrasi
        </p>

        <h1 class="text-3xl font-semibold tracking-tight text-white">
            Laporan Peminjaman
        </h1>

        <p class="mt-2 text-sm text-gray-400">
            Pantau seluruh aktivitas peminjaman ruang.
        </p>
    </div>


    {{-- Summary --}}
    <div class="mb-8 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($ringkasan as $status => $total)
            <div class="rounded-xl border border-gray-700 bg-gray-800 px-5 py-4">
                <p class="text-2xl font-semibold text-white">{{ $status }}: {{ $total }}</p>
            </div>
        @endforeach
    </div>


    {{-- Filter --}}
    <div class="mb-6 rounded-xl border border-gray-700 bg-gray-800 px-6 py-5">

        <p class="mb-4 text-sm font-medium text-gray-300">Filter</p>

        <form method="GET" action="{{ route('admin.peminjaman.index') }}" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

            <div>
                <label for="status" class="mb-1.5 block text-xs text-gray-400">Status</label>
                <select
                    id="status"
                    name="status"
                    class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
                >
                    <option value="">Semua status</option>
                    @foreach (\App\Enums\StatusPeminjaman::cases() as $status)
                        <option value="{{ $status->value }}" @selected(($filters['status'] ?? '') === $status->value)>{{ $status->value }}</option>
                    @endforeach
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="id_ruangan" class="mb-1.5 block text-xs text-gray-400">Ruangan</label>
                <select
                    id="id_ruangan"
                    name="id_ruangan"
                    class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
                >
                    <option value="">Semua ruangan</option>
                    @foreach ($ruangan as $item)
                        <option value="{{ $item->id_ruangan }}" @selected((string) ($filters['id_ruangan'] ?? '') === (string) $item->id_ruangan)>{{ $item->nama_ruangan }}</option>
                    @endforeach
                </select>
                @error('id_ruangan')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="id_user" class="mb-1.5 block text-xs text-gray-400">Peminjam</label>
                <select
                    id="id_user"
                    name="id_user"
                    class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
                >
                    <option value="">Semua peminjam</option>
                    @foreach ($users as $item)
                        <option value="{{ $item->id_user }}" @selected((string) ($filters['id_user'] ?? '') === (string) $item->id_user)>{{ $item->nama }} ({{ $item->username }})</option>
                    @endforeach
                </select>
                @error('id_user')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tanggal_mulai" class="mb-1.5 block text-xs text-gray-400">Tanggal Mulai</label>
                <input
                    id="tanggal_mulai"
                    name="tanggal_mulai"
                    type="date"
                    value="{{ $filters['tanggal_mulai'] ?? '' }}"
                    class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
                >
                @error('tanggal_mulai')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tanggal_selesai" class="mb-1.5 block text-xs text-gray-400">Tanggal Selesai</label>
                <input
                    id="tanggal_selesai"
                    name="tanggal_selesai"
                    type="date"
                    value="{{ $filters['tanggal_selesai'] ?? '' }}"
                    class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400"
                >
                @error('tanggal_selesai')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-end gap-2">
                <button
                    type="submit"
                    class="rounded-md bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-200"
                >
                    Terapkan
                </button>

                <a
                    href="{{ route('admin.peminjaman.index') }}"
                    class="rounded-md border border-gray-600 px-4 py-2 text-sm text-gray-300 transition hover:border-gray-500 hover:text-white"
                >
                    Reset
                </a>
            </div>

        </form>

    </div>


    {{-- Content --}}
    <div class="overflow-hidden rounded-xl border border-gray-700 bg-gray-800">

        @if ($peminjaman->isEmpty())

            <div class="flex flex-col items-center justify-center px-6 py-20 text-center">

                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full border border-gray-600 bg-gray-700 text-gray-400">
                    —
                </div>

                <h2 class="text-lg font-semibold text-white">
                    Tidak ada data peminjaman
                </h2>

                <p class="mt-2 text-sm text-gray-400">
                    Tidak ada data yang cocok dengan filter yang diterapkan.
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
                                    @php $st = $item->status->value; @endphp
                                    @if (strtolower($st) === 'disetujui')
                                        <span class="text-xs font-medium text-green-300">{{ $st }}</span>
                                    @elseif (strtolower($st) === 'ditolak')
                                        <span class="text-xs font-medium text-red-400">{{ $st }}</span>
                                    @elseif (strtolower($st) === 'selesai')
                                        <span class="text-xs font-medium text-blue-300">{{ $st }}</span>
                                    @else
                                        <span class="text-xs font-medium text-yellow-300">{{ $st }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a
                                        href="{{ route('admin.peminjaman.show', $item) }}"
                                        class="rounded-md border border-gray-600 px-3 py-1.5 text-xs font-medium text-gray-300 transition hover:border-gray-500 hover:bg-gray-700 hover:text-white"
                                    >
                                        Lihat
                                    </a>
                                </td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <div class="border-t border-gray-700 px-6 py-4">
                {{ $peminjaman->links() }}
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
