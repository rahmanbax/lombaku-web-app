<div class="w-64 bg-gray-800 text-white h-screen fixed">
    <div class="p-4 flex items-center space-x-2">
        <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
        </svg>
        <span class="text-xl font-bold">Lombaku</span>
    </div>
    <nav class="mt-6">
        <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
            Dashboard
        </a>
        <a href="{{ route('admin.lomba.index') }}" class="block py-2 px-4 hover:bg-gray-700 {{ request()->routeIs('admin.lomba.*') ? 'bg-gray-700' : '' }}">
            Daftar Lomba
        </a>
        <a href="{{ route('admin.document.index') }}" class="block py-2 px-4 hover:bg-gray-700 {{ request()->routeIs('admin.document.*') ? 'bg-gray-700' : '' }}">
            Verifikasi Dokumen
        </a>
        <a href="{{ route('admin.history.index') }}" class="block py-2 px-4 hover:bg-gray-700 {{ request()->routeIs('admin.history.*') ? 'bg-gray-700' : '' }}">
            Riwayat Pendaftaran
        </a>
        <a href="{{ route('admin.archive.index') }}" class="block py-2 px-4 hover:bg-gray-700 {{ request()->routeIs('admin.archive.*') ? 'bg-gray-700' : '' }}">
            Arsip Lomba
        </a>
    </nav>
</div>