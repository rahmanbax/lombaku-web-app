<aside class="w-64 bg-blue-600 text-white flex flex-col">
    <!-- Header Sidebar -->
    <div class="h-20 flex items-center justify-center border-b border-blue-700">
        <h1 class="text-2xl font-bold text-white">Dosen Area</h1>
    </div>

    <!-- Navigasi Sidebar -->
    <nav class="flex-1 px-4 py-4 space-y-2">
        <a href="{{ route('dosen.dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg transition @if(request()->routeIs('dosen.dashboard')) text-white bg-blue-700 @else text-blue-100 hover:bg-blue-700 hover:text-white @endif">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="ml-3 font-medium">Dashboard</span>
        </a>
        <a href="{{ route('dosen.riwayat') }}" class="flex items-center px-4 py-2.5 rounded-lg transition @if(request()->routeIs('dosen.riwayat')) text-white bg-blue-700 @else text-blue-100 hover:bg-blue-700 hover:text-white @endif">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-5.747-8.247l-1.06 1.06A8.003 8.003 0 004 19.5a8 8 0 0013.494-4.186l-1.06-1.06M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span class="ml-3 font-medium">Riwayat Peserta</span>
        </a>
        <a href="{{ route('dosen.persetujuan') }}" class="flex items-center px-4 py-2.5 rounded-lg transition @if(request()->routeIs('dosen.persetujuan')) text-white bg-blue-700 @else text-blue-100 hover:bg-blue-700 hover:text-white @endif">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="ml-3 font-medium">Persetujuan Lomba</span>
        </a>
    </nav>

    <!-- Info User & Logout -->
    <div class="mt-auto p-4 border-t border-blue-700">
        @auth
            <div class="flex items-center">
                <img class="h-10 w-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama) }}&background=60a5fa&color=fff&font-size=0.5" alt="Avatar">
                <div class="ml-3 flex-1">
                    <p class="text-sm font-semibold text-white">{{ Auth::user()->nama }}</p>
                    <p class="text-xs text-blue-200 capitalize">{{ str_replace('_', ' ', Auth::user()->role) }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Logout" class="ml-2 p-2 rounded-lg text-blue-200 hover:bg-blue-700 hover:text-white focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        @endauth
    </div>
</aside>