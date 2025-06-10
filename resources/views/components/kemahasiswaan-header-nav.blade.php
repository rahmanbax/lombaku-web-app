<!-- Header + Button -->
<header class="w-full flex justify-center bg-white border-b border-gray-200">
    <nav class="w-full flex justify-between p-4 lg:px-0 items-center lg:w-[1038px]">
        <button id="menu-button" class="w-10 h-10 flex justify-center items-center lg:hidden cursor-pointer">
            <span class="material-symbols-outlined">menu</span>
        </button>
        <ul class="hidden lg:flex gap-11 font-semibold">
            <li><a href="/dashboard/kemahasiswaan">Dashboard</a></li>
            <li><a href="/dashboard/kemahasiswaan/lomba">Lomba</a></li>
            <li><a href="/dashboard/kemahasiswaan/mahasiswa">Mahasiswa</a></li>
        </ul>
        <button class="flex items-center bg-gray-100 p-2 rounded-lg"><span class="truncate font-semibold max-w-[150px]">Kemahasiswaan FIT </span><span class="material-symbols-outlined">keyboard_arrow_down</span></span></button>
    </nav>
</header>

<!-- Modal Navigasi (Mobile) -->
<div id="mobile-menu" class="fixed inset-0 bg-white z-50 flex-col items-center justify-center gap-8 font-semibold text-lg hidden lg:hidden">
    <button id="close-button" class="absolute top-4 right-4 text-gray-700 cursor-pointer">
        <span class="material-symbols-outlined">
            close
        </span>
    </button>
    <a href="/" class="block">Dashboard</a>
    <a href="/" class="block">Lomba</a>
    <a href="/" class="block">Mahasiswa</a>
</div>

<!-- Script -->
<script>
    const menuBtn = document.getElementById('menu-button');
    const closeBtn = document.getElementById('close-button');
    const mobileMenu = document.getElementById('mobile-menu');

    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.remove('hidden');
        mobileMenu.classList.add('flex');
    });

    closeBtn.addEventListener('click', () => {
        mobileMenu.classList.remove('flex');
        mobileMenu.classList.add('hidden');
    });
</script>