<!-- Header + Button -->
<header class="w-full flex justify-center bg-white border-b border-gray-200">
    <nav class="w-full flex justify-between p-4 lg:px-0 items-center lg:w-[1038px]">
        <button id="menu-button" class="w-10 h-10 flex justify-center items-center lg:hidden cursor-pointer">
            <span class="material-symbols-outlined">menu</span>
        </button>
        <ul class="hidden lg:flex gap-11 font-semibold">
            <li><a href="/dashboard/adminlomba">Dashboard</a></li>
            <li><a href="/dashboard/adminlomba/lomba">Lomba</a></li>
        </ul>
        <div class="relative">
            <div class="flex items-center gap-4">
                <!-- Tombol Inbox/Notifikasi -->
                <div class="relative">
                    <button id="inbox-button" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 cursor-pointer">
                        <span class="material-symbols-outlined text-gray-600">notifications</span>
                    </button>
                    <!-- Badge untuk notifikasi belum dibaca (disembunyikan secara default) -->
                    <span id="inbox-badge" class="absolute top-0 right-0 block h-5 min-w-5 px-1.5 text-xs font-medium text-white bg-red-500 rounded-full hidden">
                        0
                    </span>
                </div>

                <!-- Dropdown Inbox/Notifikasi -->
                <div id="inbox-menu" class="absolute top-full right-4 lg:right-auto mt-2 w-80 bg-white border border-gray-200 rounded-lg shadow-lg hidden">
                    <div class="p-3 font-semibold">Notifikasi</div>
                    <div id="inbox-list" class="max-h-80 overflow-y-auto">
                        <!-- Notifikasi akan diisi oleh JS di sini -->
                        <p class="p-4 text-center text-sm text-gray-500">Memuat notifikasi...</p>
                    </div>
                </div>
                <!-- Button Kemahasiswaan FIT -->
                <button id="profile-button" class="flex items-center bg-white p-2 rounded-lg cursor-pointer">
                    <span class="truncate font-semibold max-w-72">{{ Auth::user()->nama }}</span>
                    <span class="material-symbols-outlined">keyboard_arrow_down</span>
                </button>
            </div>

            <!-- Dropdown Modal -->
            <div id="profile-menu" class="absolute top-full right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg min-w-50 hidden">
                <!-- <a href="/edit-profile" class="block px-4 py-2 hover:bg-gray-100">Edit Profil</a> -->
                <!-- <a href="/logout" class="px-3 py-2 hover:bg-gray-100 text-red-500 flex items-center gap-2"><span class="material-symbols-outlined">logout</span>Logout</a> -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <!-- edit profil -->
                    <a href="/dashboard/adminlomba/profile" class="px-3 py-2 hover:bg-gray-100 flex items-center gap-2 w-full cursor-pointer"><span class="material-symbols-outlined text-gray-500">
                            person
                        </span>Edit Profil
                    </a>
                    <button type="submit" class="px-3 py-2 hover:bg-gray-100 text-red-500 flex items-center gap-2 w-full cursor-pointer"><span class="material-symbols-outlined">logout</span>Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>
</header>

<!-- Modal Navigasi (Mobile) -->
<div id="mobile-menu" class="fixed inset-0 bg-white z-50 flex-col items-center justify-center gap-8 font-semibold text-lg hidden lg:hidden">
    <button id="close-button" class="absolute top-4 right-4 text-gray-700 cursor-pointer">
        <span class="material-symbols-outlined">
            close
        </span>
    </button>
    <a href="/dashboard/adminlomba" class="block">Dashboard</a>
    <a href="/dashboard/adminlomba/lomba" class="block">Lomba</a>
</div>

<!-- Script -->
<script>
    
</script>