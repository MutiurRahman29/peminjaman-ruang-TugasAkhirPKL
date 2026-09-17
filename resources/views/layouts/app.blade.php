<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Peminjaman Ruang')</title>

    {{-- Google Fonts: Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

{{-- Tambahkan font-sans di sini agar Plus Jakarta Sans diterapkan ke seluruh halaman --}}

<body class="flex min-h-screen flex-col bg-[#0B1120] font-sans text-gray-300 antialiased selection:bg-indigo-500/30">

    {{-- Header --}}
    <header class="fixed inset-x-0 top-0 z-50 border-b border-white/5 bg-[#0B1120]/80 backdrop-blur-md">
        @include('partials.header')
    </header>

    {{-- Flash Messages --}}
    @if (session('success') || session('error'))
        <div class="fixed right-4 top-20 z-50 flex flex-col gap-3">
            @if (session('success'))
                <div
                    class="flex items-center gap-3 rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-emerald-400 shadow-lg backdrop-blur-md">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div
                    class="flex items-center gap-3 rounded-xl border border-red-500/20 bg-red-500/10 px-4 py-3 text-red-400 shadow-lg backdrop-blur-md">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
            @endif
        </div>
    @endif

    {{-- Main Content --}}
    <main class="mt-16 flex-1 py-8">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="mt-auto border-t border-white/5 bg-[#0B1120] py-6 text-center text-sm text-gray-500">
        @include('partials.footer')
    </footer>

    @stack('scripts')
</body>

</html>
