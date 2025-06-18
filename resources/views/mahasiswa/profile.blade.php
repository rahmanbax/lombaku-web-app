<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Mahasiswa - Lombaku</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#1E40AF',
                        accent: '#10B981',
                        dark: '#1F2937',
                        light: '#F9FAFB'
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
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="navbar sticky top-0 z-40">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <!-- Logo Section -->
            <div class="flex items-center space-x-2 logo-container">
                <div class="bg-blue-100 p-2 rounded-lg">
                    <i class="fas fa-trophy text-blue-600 text-xl"></i>
                </div>
                <span class="text-xl font-bold text-gray-800">Lombaku</span>
            </div>

            <!-- Hamburger Menu (Mobile) -->
            <button id="hamburger" class="md:hidden text-gray-600 focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>

            <!-- Navigation Items -->
            <div id="navItems" class="nav-items md:flex md:items-center md:space-x-6">
                <a href="#" class="block py-2 md:py-0 text-gray-700 hover:text-primary font-medium transition-colors">Beranda</a>

                <!-- Dropdown Kategori -->
                <div class="dropdown relative my-2 md:my-0">
                    <button class="dropdown-toggle flex items-center space-x-1 text-gray-700 hover:text-primary font-medium transition-colors group">
                        <span>Kategori</span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    <div class="dropdown-menu absolute left-0 mt-2 w-48 bg-white rounded-md shadow-xl py-2 z-50 border border-gray-100">
                        <a href="#" class="dropdown-item block px-4 py-2 text-gray-700">Akademik</a>
                        <a href="#" class="dropdown-item block px-4 py-2 text-gray-700">Seni & Desain</a>
                        <a href="#" class="dropdown-item block px-4 py-2 text-gray-700">Teknologi</a>
                        <a href="#" class="dropdown-item block px-4 py-2 text-gray-700">Olahraga</a>
                        <a href="#" class="dropdown-item block px-4 py-2 text-gray-700">Bisnis</a>
                    </div>
                </div>

                <!-- Dropdown Kegiatan Saya -->
                <div class="dropdown relative my-2 md:my-0">
                    <button class="dropdown-toggle flex items-center space-x-1 text-gray-700 hover:text-primary font-medium transition-colors group">
                        <span>Kegiatan Saya</span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    <div class="dropdown-menu absolute left-0 mt-2 w-56 bg-white rounded-md shadow-xl py-2 z-50 border border-gray-100">
                        <a href="#" class="dropdown-item block px-4 py-2 text-gray-700">Lomba Diikuti</a>
                        <a href="#" class="dropdown-item block px-4 py-2 text-gray-700">Lomba Diselenggarakan</a>
                        <a href="#" class="dropdown-item block px-4 py-2 text-gray-700">Favorit</a>
                        <a href="#" class="dropdown-item block px-4 py-2 text-gray-700">Riwayat</a>
                    </div>
                </div>

                <!-- Bagian login/logout -->
                @auth
                <div class="dropdown relative my-2 md:my-0">
                    <button class="dropdown-toggle flex items-center space-x-2 text-gray-700 hover:text-primary font-medium transition-colors group">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                            {{ substr(Auth::user()->nama, 0, 1) }}
                        </div>
                        <span>{{ Auth::user()->nama }}</span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    <div class="dropdown-menu absolute right-0 mt-2 w-56 bg-white rounded-md shadow-xl py-2 z-50 border border-gray-100">
                        <a href="{{ route('profile') }}" class="dropdown-item block px-4 py-2 text-gray-700">Profile</a>
                        <form action="{{ route('logout') }}" method="POST" id="logout-form">
                            @csrf
                            <button type="button" onclick="if(confirm('Apakah Anda yakin ingin keluar?')){this.form.submit()}" class="dropdown-item block w-full text-left px-4 py-2 text-gray-700">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="mt-2 md:mt-0 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors shadow-md hover:shadow-lg">
                    Masuk
                </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Profile Content -->
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Sidebar -->
            <div class="w-full md:w-1/4 bg-white rounded-xl shadow-md p-6 h-fit">
                <div class="flex flex-col items-center mb-6">
                    <div class="bg-blue-500 text-white w-20 h-20 rounded-full flex items-center justify-center text-2xl font-bold mb-4">
                        JS
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">{{ Auth::user()->username }}</h2>
                    <p class="text-gray-500">{{ Auth::user()->role }}</p>
                </div>
                
                <div class="space-y-2">
                    <button class="w-full flex items-center space-x-3 p-3 bg-blue-50 text-blue-600 rounded-lg font-medium">
                        <i class="fas fa-user w-5"></i>
                        <span>Profil Saya</span>
                    </button>
                    <button class="w-full flex items-center space-x-3 p-3 hover:bg-gray-100 rounded-lg text-gray-700">
                        <i class="fas fa-trophy w-5"></i>
                        <span>Lomba Diikuti</span>
                    </button>
                    <button class="w-full flex items-center space-x-3 p-3 hover:bg-gray-100 rounded-lg text-gray-700">
                        <i class="fas fa-heart w-5"></i>
                        <span>Lomba Disimpan</span>
                    </button>
                    <button class="w-full flex items-center space-x-3 p-3 hover:bg-gray-100 rounded-lg text-gray-700">
                        <i class="fas fa-history w-5"></i>
                        <span>Riwayat Lomba</span>
                    </button>
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-full md:w-3/4 bg-white rounded-xl shadow-md p-8">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold text-gray-800">Profil Mahasiswa</h1>
                    <button class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-edit"></i>
                        <span>Edit Profil</span>
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="space-y-1">
                        <label class="text-gray-500 text-sm">Nama Lengkap</label>
                        <div class="font-medium text-gray-800">{{ Auth::user()->nama }}</div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-gray-500 text-sm">NIM</label>
                        <div class="font-medium text-gray-800">{{ Auth::user()->nim_atau_nip }}</div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-gray-500 text-sm">Email</label>
                        <div class="font-medium text-gray-800">john.smith@university.edu</div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-gray-500 text-sm">Jurusan</label>
                        <div class="font-medium text-gray-800">Teknik Informatika</div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-gray-500 text-sm">Fakultas</label>
                        <div class="font-medium text-gray-800">Ilmu Komputer</div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-gray-500 text-sm">Angkatan</label>
                        <div class="font-medium text-gray-800">2023</div>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 my-6"></div>
                
                <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Tambahan</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-gray-500 text-sm">Nomor Telepon</label>
                        <div class="font-medium text-gray-800">+62 812 3456 7890</div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-gray-500 text-sm">Alamat</label>
                        <div class="font-medium text-gray-800">Jl. Pendidikan No. 123, Jakarta</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12 mt-12">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <p class="text-xl mb-4">Siap menjadi bagian dari penyelenggara lomba?</p>
                <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-full transition-colors">
                    Daftar Sebagai Admin Lomba
                </button>
            </div>
            <div class="border-t border-gray-700 pt-8 text-center">
                <p class="text-gray-400">© 2023 Lombaku. Hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
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

        // Admin button functionality
        document.querySelector('.bg-green-500').addEventListener('click', function() {
            alert('Fitur pendaftaran admin lomba akan segera tersedia!');
        });

        // Edit profile button
        document.querySelector('.bg-blue-600').addEventListener('click', function() {
            alert('Fitur edit profil akan segera tersedia!');
        });

        // Action buttons in sidebar
        const actionButtons = document.querySelectorAll('.w-full.flex.items-center');
        actionButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                actionButtons.forEach(btn => {
                    btn.classList.remove('bg-blue-50', 'text-blue-600');
                    btn.classList.add('hover:bg-gray-100', 'text-gray-700');
                });
                
                // Add active class to clicked button
                this.classList.add('bg-blue-50', 'text-blue-600');
                this.classList.remove('hover:bg-gray-100', 'text-gray-700');
            });
        });
    </script>
</body>
</html>