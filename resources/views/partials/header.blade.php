<div class=" mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
    <h1 class="text-2xl p-3 font-bold"><a href="{{ route('dashboard') }}" >Sistem Peminjaman Ruang</a></h1>
    <nav>

        @auth
            <div class="flex gap-2 items-center">
                <span>Halo, {{ auth()->user()?->nama }}!</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-600 rounded px-4 py-1 text-sm">Keluar</button>
                </form>
            </div>
        @else
            <a href="{{ route('login') }}">Masuk</a>
        @endauth
    </nav>
</div>
