@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
    <div class="mx-auto max-w-2xl px-4 py-10 sm:px-6 lg:px-8">

        {{-- Top Navigation & Header --}}
        <div class="mb-8 animate-fade-up animate-duration-[600ms] animate-ease-out">
            <nav class="mb-3 flex items-center gap-2 text-xs font-medium text-gray-400">
                <a href="{{ route('dashboard') }}" class="transition-colors hover:text-amber-400">Dashboard</a>
                <span>/</span>
                <a href="{{ route('admin.users.index') }}" class="transition-colors hover:text-amber-400">Kelola Pengguna</a>
                <span>/</span>
                <span class="text-gray-200">Tambah Pengguna</span>
            </nav>

            <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">
                Tambah Pengguna
            </h1>
            <p class="mt-1 text-sm text-gray-400">
                Buat akun pengguna baru dan tentukan hak akses ke dalam sistem.
            </p>
        </div>

        {{-- Form Container Card --}}
        <div class="rounded-2xl border border-gray-800 bg-gray-900 p-6 shadow-xl sm:p-8 animate-fade-up animate-duration-[800ms] animate-delay-100 animate-ease-out">
            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                @csrf

                {{-- Nama --}}
                <div>
                    <label for="nama" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-300">
                        Nama Lengkap <span class="text-amber-500">*</span>
                    </label>

                    <div class="relative rounded-xl shadow-sm">
                        <input
                            id="nama"
                            name="nama"
                            type="text"
                            value="{{ old('nama') }}"
                            maxlength="100"
                            required
                            placeholder="Contoh: Ahmad Subagja"
                            class="w-full rounded-xl border border-gray-800 bg-gray-950/60 px-4 py-3 text-sm text-white placeholder-gray-600 transition-all focus:border-amber-500 focus:bg-gray-950 focus:outline-none focus:ring-2 focus:ring-amber-500/20 @error('nama') border-rose-500/80 focus:border-rose-500 focus:ring-rose-500/20 @enderror"
                        >
                    </div>

                    @error('nama')
                        <div class="mt-2 flex items-center gap-1.5 text-xs text-rose-400">
                            <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                {{-- Username --}}
                <div>
                    <label for="username" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-300">
                        Username <span class="text-amber-500">*</span>
                    </label>

                    <div class="relative rounded-xl shadow-sm">
                        <input
                            id="username"
                            name="username"
                            type="text"
                            value="{{ old('username') }}"
                            maxlength="50"
                            required
                            placeholder="ahmad_subagja"
                            class="w-full rounded-xl border border-gray-800 bg-gray-950/60 px-4 py-3 text-sm text-white placeholder-gray-600 transition-all focus:border-amber-500 focus:bg-gray-950 focus:outline-none focus:ring-2 focus:ring-amber-500/20 @error('username') border-rose-500/80 focus:border-rose-500 focus:ring-rose-500/20 @enderror"
                        >
                    </div>

                    @error('username')
                        <div class="mt-2 flex items-center gap-1.5 text-xs text-rose-400">
                            <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                {{-- Grid 2 Kolom untuk Password & Konfirmasi --}}
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    {{-- Password --}}
                    <div>
                        <label for="password" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-300">
                            Password <span class="text-amber-500">*</span>
                        </label>

                        <div class="relative rounded-xl shadow-sm">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                placeholder="••••••••"
                                class="w-full rounded-xl border border-gray-800 bg-gray-950/60 px-4 py-3 text-sm text-white placeholder-gray-600 transition-all focus:border-amber-500 focus:bg-gray-950 focus:outline-none focus:ring-2 focus:ring-amber-500/20 @error('password') border-rose-500/80 focus:border-rose-500 focus:ring-rose-500/20 @enderror"
                            >
                        </div>

                        @error('password')
                            <div class="mt-2 flex items-center gap-1.5 text-xs text-rose-400">
                                <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-300">
                            Konfirmasi Password <span class="text-amber-500">*</span>
                        </label>

                        <div class="relative rounded-xl shadow-sm">
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                required
                                placeholder="••••••••"
                                class="w-full rounded-xl border border-gray-800 bg-gray-950/60 px-4 py-3 text-sm text-white placeholder-gray-600 transition-all focus:border-amber-500 focus:bg-gray-950 focus:outline-none focus:ring-2 focus:ring-amber-500/20"
                            >
                        </div>
                    </div>
                </div>

                {{-- Role --}}
                <div>
                    <label for="role" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-300">
                        Role / Hak Akses <span class="text-amber-500">*</span>
                    </label>

                    <div class="relative rounded-xl shadow-sm">
                        <select
                            id="role"
                            name="role"
                            required
                            class="w-full appearance-none rounded-xl border border-gray-800 bg-gray-950/60 px-4 py-3 pr-10 text-sm text-white transition-all focus:border-amber-500 focus:bg-gray-950 focus:outline-none focus:ring-2 focus:ring-amber-500/20 @error('role') border-rose-500/80 focus:border-rose-500 focus:ring-rose-500/20 @enderror"
                        >
                            <option value="" disabled @selected(!old('role')) class="bg-gray-900 text-gray-500">Pilih role pengguna</option>
                            @foreach ($roleOptions as $role)
                                <option value="{{ $role->value }}" class="bg-gray-900 text-white" @selected(old('role') === $role->value)>
                                    {{ $role->value }}
                                </option>
                            @endforeach
                        </select>

                        {{-- Custom Select Arrow Icon --}}
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>

                    @error('role')
                        <div class="mt-2 flex items-center gap-1.5 text-xs text-rose-400">
                            <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                {{-- Form Actions --}}
                <div class="flex items-center gap-3 pt-4 border-t border-gray-800/80">
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-5 py-2.5 text-sm font-semibold text-gray-950 shadow-md transition-all hover:bg-amber-400 hover:scale-[0.98] active:scale-95"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                        </svg>
                        <span>Simpan Pengguna</span>
                    </button>

                    <a
                        href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-700 bg-gray-800/80 px-5 py-2.5 text-sm font-medium text-gray-300 transition-all hover:bg-gray-700 hover:text-white hover:scale-[0.98] active:scale-95"
                    >
                        Batal
                    </a>
                </div>

            </form>
        </div>

    </div>
@endsection
