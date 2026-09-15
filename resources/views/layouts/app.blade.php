<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Peminjaman Ruang')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="flex min-h-screen flex-col bg-gray-800 text-white">
    <header class="w-full shadow-md bg-slate-900 fixed">
        @include('partials.header')
    </header>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p>{{ session('error') }}</p>
    @endif

    <main class="flex-1 py-24">
        @yield('content')
    </main>

    <footer class="flex w-full shrink-0 justify-center bg-gray-600 shadow-md">
        @include('partials.footer')
    </footer>

    @stack('scripts')
</body>

</html>
