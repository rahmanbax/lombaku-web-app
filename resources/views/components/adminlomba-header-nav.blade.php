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
            <!-- Button Kemahasiswaan FIT -->
            <button id="profile-button" class="flex items-center bg-white p-2 rounded-lg cursor-pointer">
                <span class="truncate font-semibold max-w-48">{{ Auth::user()->nama }}</span>
                <span class="material-symbols-outlined">keyboard_arrow_down</span>
            </button>

            <!-- Dropdown Modal -->
            <div id="profile-menu" class="absolute top-full right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg min-w-50 hidden">
                <!-- <a href="/edit-profile" class="block px-4 py-2 hover:bg-gray-100">Edit Profil</a> -->
                <!-- <a href="/logout" class="px-3 py-2 hover:bg-gray-100 text-red-500 flex items-center gap-2"><span class="material-symbols-outlined">logout</span>Logout</a> -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
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
    const menuBtn = document.getElementById('menu-button');
    const closeBtn = document.getElementById('close-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const profileButton = document.getElementById('profile-button');
    const profileMenu = document.getElementById('profile-menu');

    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.remove('hidden');
        mobileMenu.classList.add('flex');
    });

    closeBtn.addEventListener('click', () => {
        mobileMenu.classList.remove('flex');
        mobileMenu.classList.add('hidden');
    });

    // Toggle dropdown saat tombol diklik
    profileButton.addEventListener('click', () => {
        profileMenu.classList.toggle('hidden');
    });

    // Tutup dropdown saat klik di luar modal
    document.addEventListener('click', (event) => {
        if (!profileButton.contains(event.target) && !profileMenu.contains(event.target)) {
            profileMenu.classList.add('hidden');
        }
    });
</script>