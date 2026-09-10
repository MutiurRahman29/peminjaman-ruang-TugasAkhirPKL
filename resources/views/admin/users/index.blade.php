@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<h1>Kelola Pengguna</h1>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

@if (session('error'))
    <p>{{ session('error') }}</p>
@endif

<p><a href="{{ route('admin.users.create') }}">Tambah Pengguna</a></p>

@if ($users->isEmpty())
    <p>Belum ada pengguna.</p>
@else
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->role->value }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $item) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.users.destroy', $item) }}" onsubmit="return confirm('Hapus pengguna ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<p><a href="{{ route('dashboard') }}">Kembali ke dashboard</a></p>
@endsection
