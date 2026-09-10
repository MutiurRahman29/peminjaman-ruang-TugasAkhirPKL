@extends('layouts.app')

@section('title', 'Katalog Fasilitas')

@section('content')
<h1>Katalog Fasilitas</h1>

@if ($fasilitas->isEmpty())
    <p>Tidak ada fasilitas tersedia.</p>
@else
    <table>
        <thead>
            <tr>
                <th>Nama Fasilitas</th>
                <th>Jumlah</th>
                <th>Kondisi</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fasilitas as $item)
                <tr>
                    <td>{{ $item->nama_fasilitas }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->kondisi->value }}</td>
                    <td>{{ $item->keterangan ?: '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<p><a href="{{ route('dashboard') }}">Kembali ke dashboard</a></p>
@endsection
