<aside class="w-64 bg-gray-800 text-white flex flex-col">
    <!-- Header Sidebar -->
    <div class="h-16 flex items-center justify-center border-b border-gray-700">
        <h1 class="text-xl font-bold">Admin Prodi</h1>
    </div>

    <!-- Navigasi Sidebar -->
    <nav class="flex-1 px-2 py-4 space-y-2">
        {{-- Tautan Dashboard --}}
        <a href="{{ route('dashboard.admin_prodi.view') }}"
            class="flex items-center px-4 py-2 rounded-md
            {{ request()->routeIs('dashboard.admin_prodi.view') ? 'text-white bg-gray-900' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="ml-3">Dashboard</span>
        </a>

        {{-- Tautan Daftar Lomba --}}
        {{-- Menggunakan wildcard (*) agar aktif di halaman index dan detail --}}
        <a href="{{ route('admin_prodi.lomba.index') }}"
            class="flex items-center px-4 py-2 mt-2 rounded-md
            {{ request()->routeIs('admin_prodi.lomba.*') ? 'text-white bg-gray-900' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <span class="ml-3">Daftar Lomba</span>
        </a>

        {{-- Tautan Verifikasi Dokumen --}}
        <a href="{{ route('admin_prodi.prestasi.verifikasi') }}"
            class="flex items-center px-4 py-2 mt-2 rounded-md
            {{ request()->routeIs('admin_prodi.prestasi.verifikasi') ? 'text-white bg-gray-900' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m0 0A10.004 10.004 0 003 21m12 0v-1a6 6 0 00-9-5.197"></path>
            </svg>
            <span class="ml-3">Verifikasi Dokumen</span>
        </a>

        {{-- Tautan Riwayat Pendaftaran --}}
        {{-- Ganti '#' dengan route yang benar jika sudah ada, contoh: route('admin_prodi.riwayat.index') --}}
        <a href="{{ route('admin_prodi.riwayat.index') }}"
            class="flex items-center px-4 py-2 mt-2 rounded-md
            {{ request()->routeIs('admin_prodi.riwayat.index') ? 'text-white bg-gray-900' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span class="ml-3">Riwayat Pendaftaran</span>
        </a>

        {{-- Tautan Arsip Lomba --}}
        {{-- Ganti '#' dengan route yang benar jika sudah ada, contoh: route('admin_prodi.arsip.index') --}}
        <a href="#"
            class="flex items-center px-4 py-2 mt-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span class="ml-3">Arsip Lomba</span>
        </a>
    </nav>
</aside>