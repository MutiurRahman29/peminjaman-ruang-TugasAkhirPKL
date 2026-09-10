@extends('layouts.app')

@section('title', 'Laporan Peminjaman')

@section('content')
<h1>Laporan Peminjaman</h1>

<p>Ringkasan berikut adalah total keseluruhan, bukan hanya hasil filter.</p>
<ul>
    @foreach ($ringkasan as $status => $total)
        <li>{{ $status }}: {{ $total }}</li>
    @endforeach
</ul>

<form method="GET" action="{{ route('admin.peminjaman.index') }}">
    <p>
        <label for="status">Status</label>
        <select id="status" name="status">
            <option value="">Semua status</option>
            @foreach (\App\Enums\StatusPeminjaman::cases() as $status)
                <option value="{{ $status->value }}" @selected(($filters['status'] ?? '') === $status->value)>{{ $status->value }}</option>
            @endforeach
        </select>
        @error('status')
            <span>{{ $message }}</span>
        @enderror
    </p>

    <p>
        <label for="id_ruangan">Ruangan</label>
        <select id="id_ruangan" name="id_ruangan">
            <option value="">Semua ruangan</option>
            @foreach ($ruangan as $item)
                <option value="{{ $item->id_ruangan }}" @selected((string) ($filters['id_ruangan'] ?? '') === (string) $item->id_ruangan)>{{ $item->nama_ruangan }}</option>
            @endforeach
        </select>
        @error('id_ruangan')
            <span>{{ $message }}</span>
        @enderror
    </p>

    <p>
        <label for="id_user">Peminjam</label>
        <select id="id_user" name="id_user">
            <option value="">Semua peminjam</option>
            @foreach ($users as $item)
                <option value="{{ $item->id_user }}" @selected((string) ($filters['id_user'] ?? '') === (string) $item->id_user)>{{ $item->nama }} ({{ $item->username }})</option>
            @endforeach
        </select>
        @error('id_user')
            <span>{{ $message }}</span>
        @enderror
    </p>

    <p>
        <label for="tanggal_mulai">Tanggal Mulai</label>
        <input id="tanggal_mulai" name="tanggal_mulai" type="date" value="{{ $filters['tanggal_mulai'] ?? '' }}">
        @error('tanggal_mulai')
            <span>{{ $message }}</span>
        @enderror
    </p>

    <p>
        <label for="tanggal_selesai">Tanggal Selesai</label>
        <input id="tanggal_selesai" name="tanggal_selesai" type="date" value="{{ $filters['tanggal_selesai'] ?? '' }}">
        @error('tanggal_selesai')
            <span>{{ $message }}</span>
        @enderror
    </p>

    <button type="submit">Terapkan Filter</button>
    <a href="{{ route('admin.peminjaman.index') }}">Reset Filter</a>
</form>

@if ($peminjaman->isEmpty())
    <p>Tidak ada data peminjaman.</p>
@else
    <table>
        <thead>
            <tr>
                <th>Peminjam</th>
                <th>Ruangan</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Keperluan</th>
                <th>Fasilitas</th>
                <th>Status</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peminjaman as $item)
                <tr>
                    <td>{{ $item->user->nama }}</td>
                    <td>{{ $item->ruangan->nama_ruangan }}</td>
                    <td>{{ $item->tanggal->toDateString() }}</td>
                    <td>{{ substr($item->jam_mulai, 0, 5) }}–{{ substr($item->jam_selesai, 0, 5) }}</td>
                    <td>{{ $item->keperluan }}</td>
                    <td>{{ $item->detailPeminjaman->count() }} jenis fasilitas</td>
                    <td>{{ $item->status->value }}</td>
                    <td><a href="{{ route('admin.peminjaman.show', $item) }}">Lihat</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $peminjaman->links() }}
@endif

<p><a href="{{ route('dashboard') }}">Kembali ke dashboard</a></p>
@endsection
