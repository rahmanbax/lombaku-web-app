<nav class="bg-blue-600 p-4 shadow-lg">
    <div class="container mx-auto flex items-center justify-between">
        <!-- Logo Section -->
        <a href="/" class="text-white text-2xl font-semibold">Lombaku</a>

        <!-- Nav Links Section -->
        <div class="hidden md:flex space-x-6">
            <a href="/" class="text-white hover:text-blue-200">Beranda</a>
            <a href="/lomba" class="text-white hover:text-blue-200">Lomba</a>
            <a href="/about" class="text-white hover:text-blue-200">Tentang Kami</a>
            <a href="/contact" class="text-white hover:text-blue-200">Kontak</a>
        </div>

        <!-- Mobile Hamburger Menu (visible on small screens) -->
        <button id="navbar-toggle" class="text-white md:hidden">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Mobile Dropdown Menu (hidden by default) -->
    <div id="navbar-menu" class="md:hidden hidden">
        <div class="flex flex-col items-center">
            <a href="/" class="text-white py-2">Beranda</a>
            <a href="/lomba" class="text-white py-2">Lomba</a>
            <a href="/about" class="text-white py-2">Tentang Kami</a>
            <a href="/contact" class="text-white py-2">Kontak</a>
        </div>
    </div>
</nav>

<script>
    // Toggle mobile menu visibility
    const toggleButton = document.getElementById('navbar-toggle');
    const menu = document.getElementById('navbar-menu');
    
    toggleButton.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>
