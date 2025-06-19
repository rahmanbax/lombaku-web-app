 <script>
     tailwind.config = {
         theme: {
             extend: {
                 colors: {
                     primary: '#3B82F6',
                     secondary: '#10B981',
                     accent: '#F59E0B',
                     dark: '#1F2937',
                 }
             }
         }
     }
 </script>
 <style>
     @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

     body {
         font-family: 'Poppins', sans-serif;
         background-color: #f9fafb;
     }

     /* Navbar Styles */
     .navbar {
         backdrop-filter: blur(10px);
         background-color: rgba(255, 255, 255, 0.95);
         box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
         border-bottom: 1px solid rgba(0, 0, 0, 0.05);
     }

     .logo-container {
         transition: transform 0.3s ease;
     }

     .logo-container:hover {
         transform: scale(1.05);
     }

     /* Dropdown Styles */
     .dropdown-menu {
         opacity: 0;
         visibility: hidden;
         transform: translateY(10px);
         transition: all 0.3s ease;
         display: block;
         /* Always show but control with opacity/visibility */
     }

     .dropdown.active .dropdown-menu {
         opacity: 1;
         visibility: visible;
         transform: translateY(0);
     }

     .dropdown-item {
         transition: all 0.2s ease;
     }

     .dropdown-item:hover {
         background-color: #f8fafc;
         padding-left: 1.25rem;
     }

     /* Mobile Menu */
     .nav-items {
         max-height: 0;
         overflow: hidden;
         transition: max-height 0.5s ease;
     }

     .nav-items.active {
         max-height: 500px;
     }

     @media (min-width: 768px) {
         .nav-items {
             max-height: none;
             overflow: visible;
         }
     }

     /* Card Styles */
     .card {
         transition: transform 0.3s ease, box-shadow 0.3s ease;
     }

     .card:hover {
         transform: translateY(-5px);
         box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
     }
 </style>
 </head>

 <body class="bg-gray-50">
     <!-- Navbar -->
   <!-- Navbar -->
    <nav class="navbar py-3 px-4 md:px-8 sticky top-0 z-50 transition-all duration-300">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center space-x-2 logo-container">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-2 rounded-lg shadow-md">
                    <i class="fas fa-trophy text-lg"></i>
                </div>
                <span class="text-xl font-bold text-gray-800">Lombaku</span>
            </a>

            <button class="md:hidden text-gray-600 focus:outline-none" id="hamburger">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <div class="nav-items md:flex md:items-center md:space-x-8" id="navItems">
                <a href="{{ route('home') }}" class="block py-2 md:py-0 text-gray-700 hover:text-blue-600 font-medium transition-colors border-b-2 border-transparent hover:border-blue-600">
                    Beranda
                </a>
                <a href="{{ route('lombaterkini') }}" class="block py-2 md:py-0 text-gray-700 hover:text-blue-600 font-medium transition-colors border-b-2 border-transparent hover:border-blue-600">
                    Lomba Terkini
                </a>
                <div class="dropdown relative my-2 md:my-0">
                    <button class="dropdown-toggle flex items-center space-x-1 text-gray-700 hover:text-blue-600 font-medium transition-colors group">
                        <span>Kategori</span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    <div class="dropdown-menu absolute left-0 mt-2 w-48 bg-white rounded-md shadow-xl py-2 z-50 border border-gray-100">
                        {{-- Loop melalui variabel $categories yang dikirim oleh View Composer --}}
                        @forelse ($categories as $category)
                            {{-- Arahkan link ke halaman lombaterkini dengan parameter query tag --}}
                            <a href="{{ route('lombaterkini') }}?tag={{ urlencode($category->nama_tag) }}" class="dropdown-item block px-4 py-2 text-gray-700">
                                {{ $category->nama_tag }}
                            </a>
                        @empty
                            {{-- Tampilkan ini jika tidak ada tag di database --}}
                            <span class="dropdown-item block px-4 py-2 text-gray-400">Tidak ada kategori</span>
                        @endforelse
                    </div>
                </div>
               
                @auth
                <!-- Dropdown Kegiatan Saya -->
                <div class="dropdown relative my-2 md:my-0">
                    <button class="dropdown-toggle flex items-center space-x-1 text-gray-700 hover:text-blue-600 font-medium transition-colors group">
                        <span>Kegiatan Saya</span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    <div class="dropdown-menu absolute left-0 mt-2 w-56 bg-white rounded-md shadow-xl py-2 z-50 border border-gray-100">
                        <a href="{{ route('status')}}" class="dropdown-item block px-4 py-2 text-gray-700">Riwayat Kegiatan</a>
                        <a href="{{ route('simpanlomba') }}" class="dropdown-item block px-4 py-2 text-gray-700">Lomba Disimpan</a>
                        <a href="{{ route('rekognisi.create') }}" class="dropdown-item block px-4 py-2 text-gray-700">Ajukan Rekognisi Prestasi</a>
                    </div>
                </div>

                <!-- Dropdown User Profile -->
                <div class="dropdown relative my-2 md:my-0">
                    <button class="dropdown-toggle flex items-center space-x-2 text-gray-700 hover:text-blue-600 font-medium transition-colors group">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                            {{ substr(Auth::user()->nama, 0, 1) }}
                        </div>
                        <span class="hidden lg:block">{{ Str::limit(Auth::user()->nama, 10) }}</span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    <div class="dropdown-menu absolute right-0 mt-2 w-56 bg-white rounded-md shadow-xl py-2 z-50 border border-gray-100">
                        <div class="px-4 py-2 border-b">
                            <p class="font-semibold text-gray-800">{{ Auth::user()->nama }}</p>
                            <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                        <a href="{{ route('profile') }}" class="dropdown-item block px-4 py-2 text-gray-700 mt-1">Profil Saya</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item block w-full text-left px-4 py-2 text-red-600">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="mt-2 md:mt-0 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-all shadow-md hover:shadow-lg">
                    Masuk
                </a>
                @endauth
            </div>
        </div>
    </nav>

     <script>
         // Mobile menu toggle
         const hamburger = document.getElementById('hamburger');
         const navItems = document.getElementById('navItems');

         hamburger.addEventListener('click', () => {
             navItems.classList.toggle('active');
         });

         // Dropdown toggle - Improved version
         const dropdowns = document.querySelectorAll('.dropdown');

         dropdowns.forEach(dropdown => {
             const toggle = dropdown.querySelector('.dropdown-toggle');

             // Click handler
             toggle.addEventListener('click', (e) => {
                 e.stopPropagation();

                 // Close all other dropdowns first
                 dropdowns.forEach(other => {
                     if (other !== dropdown) {
                         other.classList.remove('active');
                     }
                 });

                 // Toggle current dropdown
                 dropdown.classList.toggle('active');
             });

             // Keyboard accessibility
             toggle.addEventListener('keydown', (e) => {
                 if (e.key === 'Enter' || e.key === ' ') {
                     e.preventDefault();
                     dropdown.classList.toggle('active');
                 } else if (e.key === 'Escape' && dropdown.classList.contains('active')) {
                     dropdown.classList.remove('active');
                 }
             });
         });

         // Close dropdowns when clicking outside
         document.addEventListener('click', (e) => {
             if (!e.target.closest('.dropdown')) {
                 dropdowns.forEach(dropdown => {
                     dropdown.classList.remove('active');
                 });
             }
         });

         // Close dropdowns on ESC key
         document.addEventListener('keydown', (e) => {
             if (e.key === 'Escape') {
                 dropdowns.forEach(dropdown => {
                     dropdown.classList.remove('active');
                 });
             }
         });

         // Search functionality
         const searchButton = document.querySelector('.search-button');
         const searchInput = document.querySelector('.search-input');

         searchButton.addEventListener('click', function() {
             if (searchInput.value.trim() !== '') {
                 alert(`Anda mencari: "${searchInput.value}"`);
                 // Di aplikasi nyata, ini akan mengirimkan permintaan pencarian
             } else {
                 searchInput.focus();
             }
         });

         searchInput.addEventListener('keypress', function(e) {
             if (e.key === 'Enter') {
                 if (searchInput.value.trim() !== '') {
                     alert(`Anda mencari: "${searchInput.value}"`);
                 } else {
                     searchInput.focus();
                 }
             }
         });

         // Admin button functionality
         const adminButton = document.querySelector('.admin-btn');
         adminButton.addEventListener('click', function() {
             alert('Fitur pendaftaran admin lomba akan segera tersedia!');
             // Di aplikasi nyata, ini akan mengarahkan ke halaman pendaftaran admin
         });
     </script>