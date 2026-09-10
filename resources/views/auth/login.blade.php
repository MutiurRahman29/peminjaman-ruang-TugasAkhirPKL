<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk – Sistem Peminjaman Ruang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-800 text-white flex items-center justify-center px-4">

    <div class="w-full max-w-sm">

        {{-- Brand --}}
        <div class="mb-8 text-center">
            <h1 class="text-2xl font-semibold tracking-tight text-white">
                Sistem Peminjaman Ruang
            </h1>
            <p class="mt-2 text-sm text-gray-400">Masuk untuk melanjutkan</p>
        </div>


        {{-- Card --}}
        <div class="rounded-xl border border-gray-700 bg-gray-800 px-6 py-8">

            <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="username" class="mb-1.5 block text-sm text-gray-300">
                        Username
                    </label>

                    <input
                        id="username"
                        name="username"
                        type="text"
                        value="{{ old('username') }}"
                        required
                        autofocus
                        autocomplete="username"
                        class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400 @error('username') border-red-700 @enderror"
                    >

                    @error('username')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-1.5 block text-sm text-gray-300">
                        Password
                    </label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        class="w-full rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-sm text-white outline-none focus:border-gray-400 @error('password') border-red-700 @enderror"
                    >

                    @error('password')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-2">
                    <input
                        id="remember"
                        name="remember"
                        type="checkbox"
                        value="1"
                        @checked(old('remember'))
                        class="h-4 w-4 rounded border-gray-600 bg-gray-700 accent-white"
                    >
                    <label for="remember" class="text-sm text-gray-300">Ingat saya</label>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-md bg-white py-2 text-sm font-semibold text-gray-900 transition hover:bg-gray-200"
                >
                    Masuk
                </button>

            </form>

        </div>

    </div>

</body>

</html>
