@extends('layouts.app')

@section('title', 'Detail Pengajuan')

@section('content')
<h1>Detail Pengajuan</h1>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

@if (session('error'))
    <p>{{ session('error') }}</p>
@endif

<dl>
    <dt>Peminjam</dt>
    <dd>{{ $peminjaman->user->nama }}</dd>
    <dt>Ruangan</dt>
    <dd>{{ $peminjaman->ruangan->nama_ruangan }}</dd>
    <dt>Tanggal</dt>
    <dd>{{ $peminjaman->tanggal->toDateString() }}</dd>
    <dt>Waktu</dt>
    <dd>{{ substr($peminjaman->jam_mulai, 0, 5) }}–{{ substr($peminjaman->jam_selesai, 0, 5) }}</dd>
    <dt>Keperluan</dt>
    <dd>{{ $peminjaman->keperluan }}</dd>
    <dt>Status</dt>
    <dd>{{ $peminjaman->status->value }}</dd>
</dl>

<h2>Fasilitas</h2>
@if ($peminjaman->detailPeminjaman->isEmpty())
    <p>Tidak ada fasilitas tambahan.</p>
@else
    <ul>
        @foreach ($peminjaman->detailPeminjaman as $detail)
            <li>{{ $detail->fasilitas->nama_fasilitas }}: {{ $detail->jumlah }}</li>
        @endforeach
    </ul>
@endif

@if ($peminjaman->status === \App\Enums\StatusPeminjaman::Menunggu)
    <form method="POST" action="{{ route('petugas.peminjaman.approve', $peminjaman) }}">
        @csrf
        @method('PATCH')
        <button type="submit">Setujui</button>
    </form>

    <form method="POST" action="{{ route('petugas.peminjaman.reject', $peminjaman) }}">
        @csrf
        @method('PATCH')
        <button type="submit">Tolak</button>
    </form>
@endif

@if ($peminjaman->status === \App\Enums\StatusPeminjaman::Disetujui)
    <form method="POST" action="{{ route('petugas.peminjaman.complete', $peminjaman) }}" onsubmit="return confirm('Tandai peminjaman ini selesai?');">
        @csrf
        @method('PATCH')
        <button type="submit">Tandai Selesai</button>
    </form>
@endif

<nav>
    <a href="{{ route('petugas.peminjaman.index') }}">Antrean Peminjaman</a>
    <a href="{{ route('petugas.peminjaman.history') }}">Riwayat Peminjaman</a>
    <a href="{{ route('dashboard') }}">Dashboard</a>
</nav>
@endsection
