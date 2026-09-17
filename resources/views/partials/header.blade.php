<div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

    {{-- Logo & Title --}}
    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 transition-opacity hover:opacity-80">
        <span class="text-base font-bold tracking-tight text-white sm:text-xl">Peminjaman Ruang</span>
    </a>

    {{-- Navigation / User --}}
    <nav class="flex items-center">
        @auth
            <div class="flex items-center gap-4">

                {{-- User Profile --}}
                <div class="hidden items-center gap-3 sm:flex">
                    <p class="text-sm font-medium text-gray-300">{{ auth()->user()?->nama }}</p>
                </div>

                <div class="hidden h-5 w-px bg-white/10 sm:block"></div>

                {{-- Logout Form --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="group flex items-center gap-2 rounded-lg px-3 py-1.5 text-sm font-medium text-gray-400 transition-colors hover:bg-red-500/10 hover:text-red-400">
                        <svg class="h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        @else
            <a href="{{ route('login') }}"
                class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-indigo-500">
                Masuk
            </a>
        @endauth
    </nav>
</div>
