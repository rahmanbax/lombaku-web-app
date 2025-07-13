<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
    }

    /* Navbar Styles */
    .navbar {
        backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.95);
    }

    /* Dropdown Styles */
    .dropdown-menu {
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.3s ease;
        display: block;
    }

    .dropdown.active .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-item { transition: all 0.2s ease; }
    .dropdown-item:hover { background-color: #f8fafc; padding-left: 1.25rem; }
    
    @media (max-width: 767px) {
        .nav-items {
            display: none;
            flex-direction: column;
            width: 100%;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: white;
            padding: 1rem;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            border-top: 1px solid #e5e7eb;
        }

        .nav-items.active {
            display: flex;
        }
        
        .dropdown-menu {
            position: static;
            opacity: 1;
            visibility: visible;
            transform: none;
            box-shadow: none;
            border: none;
            padding-left: 1rem;
            display: none;
        }
        
        .dropdown.active .dropdown-menu {
            display: block;
        }
    }
</style>

<nav class="navbar py-3 px-4 md:px-8 sticky top-0 z-50 transition-all duration-300">
    <div class="container mx-auto flex justify-between items-center relative">
        <a href="{{ route('home') }}" class="flex items-center space-x-2">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-2 rounded-lg shadow-md">
                <i class="fas fa-trophy text-lg"></i>
            </div>
            <span class="text-xl font-bold text-gray-800">Lombaku</span>
        </a>

        <!-- Tombol Hamburger -->
        <button class="md:hidden text-gray-600 focus:outline-none" id="hamburger">
            <i class="fas fa-bars text-xl"></i>
        </button>

        <!-- Nav Items Container -->
        <div class="nav-items hidden md:flex md:items-center md:space-x-6 lg:space-x-8" id="navItems">
            <a href="{{ route('home') }}" class="block py-2 md:py-0 text-gray-700 hover:text-blue-600 font-medium transition-colors">Beranda</a>
            <a href="{{ route('lombaterkini') }}" class="block py-2 md:py-0 text-gray-700 hover:text-blue-600 font-medium transition-colors">Lomba Terkini</a>

            @auth
            <!-- Dropdown Kegiatan Saya -->
            <div class="dropdown relative py-2 md:py-0">
                <button class="dropdown-toggle flex items-center space-x-1 text-gray-700 hover:text-blue-600 font-medium transition-colors group w-full text-left md:w-auto">
                    <span>Kegiatan Saya</span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-200 group-hover:rotate-180"></i>
                </button>
                <div class="dropdown-menu mt-2 w-56 bg-white rounded-md shadow-xl z-50 border border-gray-100 md:absolute md:left-0">
                    <a href="{{ route('status')}}" class="dropdown-item block px-4 py-2 text-gray-700">Riwayat Kegiatan</a>
                    <a href="{{ route('bookmark') }}" class="dropdown-item block px-4 py-2 text-gray-700">Lomba Disimpan</a>
                    <a href="{{ route('rekognisi.create') }}" class="dropdown-item block px-4 py-2 text-gray-700">Ajukan Rekognisi Prestasi</a>
                    <a href="{{ route('hasil-rekognisi') }}" class="dropdown-item block px-4 py-2 text-gray-700">Hasil Rekognisi</a>
                    {{-- === INILAH PERBAIKANNYA === --}}
                    @if(in_array(Auth::user()->role, ['dosen', 'admin_lomba', 'kemahasiswaan']))
                        <div class="border-t my-1"></div>
                        <a href="#" class="dropdown-item block px-4 py-2 text-gray-700">Penilaian Juri</a>
                    @else
                        <div class="border-t my-1"></div>
                        <a href="{{ route('hasil-lomba.index') }}" class="dropdown-item block px-4 py-2 text-gray-700">Hasil Lomba</a>
                    @endif
                    {{-- ======================== --}}
                </div>
            </div>

            <!-- Dropdown User Profile -->
            <div class="dropdown relative py-2 md:py-0">
                <button class="dropdown-toggle flex items-center space-x-2 text-gray-700 hover:text-blue-600 font-medium transition-colors group w-full text-left md:w-auto">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold text-sm shrink-0">
                        {{ substr(Auth::user()->nama, 0, 1) }}
                    </div>
                    <span class="truncate">{{ Auth::user()->nama }}</span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-200 group-hover:rotate-180"></i>
                </button>
                <div class="dropdown-menu mt-2 min-w-64 bg-white rounded-md shadow-xl z-50 border border-gray-100 md:absolute md:right-0">
                    <div class="px-4 py-2 border-b">
                        <p class="font-semibold text-gray-800 truncate">{{ Auth::user()->nama }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                    <a href="{{ route('profile') }}" class="dropdown-item block px-4 py-2 text-gray-700 mt-1 whitespace-nowrap">Profil Saya</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item block w-full text-left px-4 py-2 text-red-600 whitespace-nowrap">Logout</button>
                    </form>
                </div>
            </div>
            @else
            <a href="{{ route('login') }}" class="mt-2 md:mt-0 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-all shadow-md hover:shadow-lg">Masuk</a>
            @endauth
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.getElementById('hamburger');
    const navItems = document.getElementById('navItems');
    if (hamburger && navItems) {
        hamburger.addEventListener('click', () => {
            navItems.classList.toggle('active');
        });
    }

    document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
        toggle.addEventListener('click', (e) => {
            const dropdown = toggle.closest('.dropdown');
            e.stopPropagation(); 
            
            document.querySelectorAll('.dropdown.active').forEach(activeDropdown => {
                if (activeDropdown !== dropdown) {
                    activeDropdown.classList.remove('active');
                }
            });
            
            dropdown.classList.toggle('active');
        });
    });

    document.addEventListener('click', () => {
        document.querySelectorAll('.dropdown.active').forEach(dropdown => {
            dropdown.classList.remove('active');
        });
    });
});
</script>