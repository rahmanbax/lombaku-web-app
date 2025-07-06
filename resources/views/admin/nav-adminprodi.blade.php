<aside class="w-64 bg-blue-600 text-white flex flex-col">
    <!-- Header Sidebar -->
    <div class="h-20 flex items-center justify-center border-b border-blue-700">
        <h1 class="text-2xl font-bold text-white">Admin Prodi</h1>
    </div>

    <!-- Navigasi Sidebar -->
    <nav class="flex-1 px-4 py-4 space-y-2">
        
        {{-- Link Dashboard --}}
        <a href="{{ route('dashboard.admin_prodi.view') }}"
           class="flex items-center px-4 py-2.5 rounded-lg transition 
                  {{-- Perubahan: Kelas untuk state aktif/tidak aktif disesuaikan --}}
                  @if(request()->routeIs('dashboard.admin_prodi.view')) 
                      text-white bg-blue-700 
                  @else 
                      text-blue-100 hover:bg-blue-700 hover:text-white 
                  @endif">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="ml-3 font-medium">Dashboard</span>
        </a>
        
        {{-- Link Daftar Lomba --}}
        <a href="{{ route('admin_prodi.lomba.index') }}"
           class="flex items-center px-4 py-2.5 rounded-lg transition 
                  @if(request()->routeIs('admin_prodi.lomba.*')) 
                      text-white bg-blue-700 
                  @else 
                      text-blue-100 hover:bg-blue-700 hover:text-white 
                  @endif">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            <span class="ml-3 font-medium">Daftar Lomba</span>
        </a>
        
        {{-- Link Verifikasi Dokumen --}}
        <a href="{{ route('admin_prodi.prestasi.verifikasi') }}"
           class="flex items-center px-4 py-2.5 rounded-lg transition 
                  @if(request()->routeIs('admin_prodi.prestasi.verifikasi')) 
                      text-white bg-blue-700 
                  @else 
                      text-blue-100 hover:bg-blue-700 hover:text-white 
                  @endif">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="ml-3 font-medium">Verifikasi Dokumen</span>
        </a>
        
        {{-- Link Riwayat Pendaftaran --}}
        <a href="{{ route('admin_prodi.registrasi.history') }}"
           class="flex items-center px-4 py-2.5 rounded-lg transition 
                  @if(request()->routeIs('admin_prodi.registrasi.history')) 
                      text-white bg-blue-700 
                  @else 
                      text-blue-100 hover:bg-blue-700 hover:text-white 
                  @endif">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span class="ml-3 font-medium">Riwayat Pendaftaran</span>
        </a>
        
        {{-- Link Arsip Lomba --}}
        <a href="{{ route('admin_prodi.lomba.arsip') }}"
           class="flex items-center px-4 py-2.5 rounded-lg transition 
                  @if(request()->routeIs('admin_prodi.lomba.arsip')) 
                      text-white bg-blue-700 
                  @else 
                      text-blue-100 hover:bg-blue-700 hover:text-white 
                  @endif">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
            <span class="ml-3 font-medium">Arsip Lomba</span>
        </a>
    </nav>

    <!-- Info User & Logout -->
    <div class="mt-auto p-4 border-t border-blue-700">
        @auth
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama) }}&background=60a5fa&color=fff&font-size=0.5" alt="Avatar">
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-semibold text-white">{{ Auth::user()->nama }}</p>
                    <p class="text-xs text-blue-200 capitalize">{{ ucwords(str_replace('_', ' ', Auth::user()->role)) }}</p>
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