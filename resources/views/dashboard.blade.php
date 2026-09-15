@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="mx-auto max-w-7xl px-6 py-8">

    {{-- Welcome --}}
    <section class="mb-10">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">

            <div>
                <p class="mb-2 text-sm font-medium text-gray-400">
                    Overview
                </p>

                <h1 class="text-3xl font-semibold tracking-tight text-white">
                    Dashboard
                </h1>

                <p class="mt-2 text-sm text-gray-400">
                    Kelola dan pantau aktivitas sistem peminjaman ruang.
                </p>
            </div>

        </div>
    </section>


    {{-- Peminjam --}}
    @if (auth()->user()?->role === \App\Enums\UserRole::Peminjam)

        {{-- Primary Action --}}
        <section class="mb-8">

            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-lg font-semibold text-white">
                        Aktivitas
                    </h2>

                    <p class="text-sm text-gray-400">
                        Akses layanan peminjaman ruang dan fasilitas.
                    </p>
                </div>
            </div>

            <div class="grid gap-4 lg:grid-cols-3">

                {{-- Main Action --}}
                <a
                    href="{{ route('peminjam.peminjaman.create') }}"
                    class="group rounded-xl border border-gray-600 bg-gray-700 p-6 transition hover:border-gray-500 hover:bg-gray-650"
                >
                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm text-gray-400">
                                Pengajuan
                            </p>

                            <h3 class="mt-2 text-xl font-semibold text-white">
                                Ajukan Peminjaman
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-400">
                                Buat pengajuan peminjaman ruang atau fasilitas baru.
                            </p>
                        </div>

                        <span class="text-xl text-gray-400 transition group-hover:translate-x-1">
                            →
                        </span>

                    </div>
                </a>


                {{-- Ruangan --}}
                <a
                    href="{{ route('peminjam.ruangan.index') }}"
                    class="rounded-xl border border-gray-700 bg-gray-750 p-6 transition hover:border-gray-500 hover:bg-gray-700"
                >
                    <p class="text-sm text-gray-400">
                        Eksplorasi
                    </p>

                    <h3 class="mt-2 text-lg font-semibold text-white">
                        Katalog Ruangan
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-400">
                        Lihat ruangan yang tersedia untuk digunakan.
                    </p>
                </a>


                {{-- Fasilitas --}}
                <a
                    href="{{ route('peminjam.fasilitas.index') }}"
                    class="rounded-xl border border-gray-700 bg-gray-750 p-6 transition hover:border-gray-500 hover:bg-gray-700"
                >
                    <p class="text-sm text-gray-400">
                        Eksplorasi
                    </p>

                    <h3 class="mt-2 text-lg font-semibold text-white">
                        Katalog Fasilitas
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-400">
                        Lihat fasilitas yang tersedia untuk peminjaman.
                    </p>
                </a>

            </div>
        </section>


        {{-- History --}}
        <section>

            <div class="mb-4">
                <h2 class="text-lg font-semibold text-white">
                    Peminjaman
                </h2>

                <p class="text-sm text-gray-400">
                    Pantau pengajuan dan aktivitas peminjaman kamu.
                </p>
            </div>

            <a
                href="{{ route('peminjam.peminjaman.index') }}"
                class="block rounded-xl border border-gray-700 bg-gray-750 p-6 transition hover:border-gray-500 hover:bg-gray-700"
            >
                <div class="flex items-center justify-between">

                    <div>
                        <h3 class="font-semibold text-white">
                            Riwayat Peminjaman
                        </h3>

                        <p class="mt-1 text-sm text-gray-400">
                            Lihat status dan riwayat seluruh pengajuan kamu.
                        </p>
                    </div>

                    <span class="text-gray-400">
                        →
                    </span>

                </div>
            </a>

        </section>

    @endif


    {{-- Petugas --}}
    @if (auth()->user()?->role === \App\Enums\UserRole::Petugas)

        <section class="mb-8">

            <div class="mb-4">
                <h2 class="text-lg font-semibold text-white">
                    Operasional
                </h2>

                <p class="text-sm text-gray-400">
                    Kelola proses pemeriksaan dan persetujuan peminjaman.
                </p>
            </div>

            <div class="grid gap-4 md:grid-cols-2">

                <a
                    href="{{ route('petugas.peminjaman.index') }}"
                    class="group rounded-xl border border-gray-700 bg-gray-750 p-6 transition hover:border-gray-500 hover:bg-gray-700"
                >
                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm text-gray-400">
                                Menunggu tindakan
                            </p>

                            <h3 class="mt-2 text-xl font-semibold text-white">
                                Antrean Peminjaman
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-400">
                                Periksa dan proses pengajuan peminjaman yang masuk.
                            </p>
                        </div>

                        <span class="text-xl text-gray-400 transition group-hover:translate-x-1">
                            →
                        </span>

                    </div>
                </a>


                <a
                    href="{{ route('petugas.peminjaman.history') }}"
                    class="group rounded-xl border border-gray-700 bg-gray-750 p-6 transition hover:border-gray-500 hover:bg-gray-700"
                >
                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm text-gray-400">
                                Arsip
                            </p>

                            <h3 class="mt-2 text-xl font-semibold text-white">
                                Riwayat Persetujuan
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-400">
                                Tinjau seluruh pengajuan yang telah diproses.
                            </p>
                        </div>

                        <span class="text-xl text-gray-400 transition group-hover:translate-x-1">
                            →
                        </span>

                    </div>
                </a>

            </div>

        </section>

    @endif


    {{-- Admin --}}
    @if (auth()->user()?->role === \App\Enums\UserRole::Admin)

        <section>

            <div class="mb-6">
                <h2 class="text-lg font-semibold text-white">
                    Administrasi Sistem
                </h2>

                <p class="text-sm text-gray-400">
                    Kelola sumber daya, pengguna, dan aktivitas peminjaman.
                </p>
            </div>


            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                <a
                    href="{{ route('admin.ruangan.index') }}"
                    class="group rounded-xl border border-gray-700 bg-gray-750 p-6 transition hover:border-gray-500 hover:bg-gray-700"
                >
                    <p class="text-sm text-gray-400">
                        Sumber daya
                    </p>

                    <h3 class="mt-2 font-semibold text-white">
                        Kelola Ruangan
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-400">
                        Kelola data dan ketersediaan ruangan.
                    </p>
                </a>


                <a
                    href="{{ route('admin.fasilitas.index') }}"
                    class="group rounded-xl border border-gray-700 bg-gray-750 p-6 transition hover:border-gray-500 hover:bg-gray-700"
                >
                    <p class="text-sm text-gray-400">
                        Sumber daya
                    </p>

                    <h3 class="mt-2 font-semibold text-white">
                        Kelola Fasilitas
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-400">
                        Kelola data fasilitas yang tersedia.
                    </p>
                </a>


                <a
                    href="{{ route('admin.users.index') }}"
                    class="group rounded-xl border border-gray-700 bg-gray-750 p-6 transition hover:border-gray-500 hover:bg-gray-700"
                >
                    <p class="text-sm text-gray-400">
                        Akses
                    </p>

                    <h3 class="mt-2 font-semibold text-white">
                        Kelola Pengguna
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-400">
                        Kelola akun dan hak akses pengguna.
                    </p>
                </a>


                <a
                    href="{{ route('admin.peminjaman.index') }}"
                    class="group rounded-xl border border-gray-700 bg-gray-750 p-6 transition hover:border-gray-500 hover:bg-gray-700"
                >
                    <p class="text-sm text-gray-400">
                        Monitoring
                    </p>

                    <h3 class="mt-2 font-semibold text-white">
                        Laporan Peminjaman
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-400">
                        Pantau seluruh aktivitas peminjaman.
                    </p>
                </a>

            </div>

        </section>

    @endif

</div>

@endsection