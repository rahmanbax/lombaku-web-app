<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lombaku - Platform Lomba Terbaik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .dropdown-menu {
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s ease;
            transform: translateY(10px);
        }
        .dropdown.active .dropdown-menu {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }
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
    <nav class="bg-white shadow-md py-3 px-4 md:px-8 sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div class="bg-blue-600 text-white p-2 rounded-lg">
                    <i class="fas fa-trophy text-lg"></i>
                </div>
                <span class="text-xl font-bold text-gray-800">Lombaku</span>
            </div>

            <button class="md:hidden text-gray-600 focus:outline-none" id="hamburger">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <div class="nav-items md:flex md:items-center md:space-x-6" id="navItems">
                <a href="#" class="block py-2 md:py-0 text-gray-700 hover:text-blue-600 font-medium transition-colors">Beranda</a>

                <div class="dropdown relative my-2 md:my-0">
                    <button class="dropdown-toggle flex items-center space-x-1 text-gray-700 hover:text-blue-600 font-medium transition-colors">
                        <span>Kategori</span> <i class="fas fa-chevron-down text-xs dropdown-icon"></i>
                    </button>
                    <div class="dropdown-menu absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-50">
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Akademik</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Seni & Desain</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Teknologi</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Olahraga</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Bisnis</a>
                    </div>
                </div>

                <div class="dropdown relative my-2 md:my-0">
                    <button class="dropdown-toggle flex items-center space-x-1 text-gray-700 hover:text-blue-600 font-medium transition-colors">
                        <span>Kegiatan Saya</span> <i class="fas fa-chevron-down text-xs dropdown-icon"></i>
                    </button>
                    <div class="dropdown-menu absolute left-0 mt-2 w-56 bg-white rounded-md shadow-lg py-2 z-50">
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Lomba Diikuti</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Lomba Diselenggarakan</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Favorit</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Riwayat</a>
                    </div>
                </div>

                <button class="mt-2 md:mt-0 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">Masuk</button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container mx-auto px-4 py-8 md:py-16">
        <div class="max-w-3xl mx-auto text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Cari Lomba di Lombaku!</h1>
            <p class="text-gray-600 text-lg">Update terus info terkini, dari kampus sampai internasional semuanya ada disini</p>
        </div>

        <div class="max-w-2xl mx-auto mb-16">
            <div class="flex bg-white rounded-full shadow-lg border border-gray-200 overflow-hidden">
                <input 
                    type="text" 
                    class="search-input flex-grow px-6 py-4 focus:outline-none" 
                    placeholder="Cari lomba, kategori, atau penyelenggara..."
                >
                <button class="search-button bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 transition-colors">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <div class="border-b border-gray-200 my-12"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="card bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="relative">
                    <div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-48"></div>
                    <div class="absolute top-4 right-4 bg-blue-600 text-white text-sm font-medium py-1 px-3 rounded-full">
                        15 Juni 2025
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Desain Minimalis</h3>
                    <p class="text-gray-600 mb-4">Tampilan elegan dengan palet warna hitam-putih yang modern dan profesional.</p>
                    <a href="#" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        Lihat Detail
                    </a>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="card bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="relative">
                    <div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-48"></div>
                    <div class="absolute top-4 right-4 bg-blue-600 text-white text-sm font-medium py-1 px-3 rounded-full">
                        10 Juni 2025
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">UI Modern</h3>
                    <p class="text-gray-600 mb-4">Dropdown yang disederhanakan untuk pengalaman pengguna yang lebih baik.</p>
                    <a href="#" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        Lihat Detail
                    </a>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="card bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="relative">
                    <div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-48"></div>
                    <div class="absolute top-4 right-4 bg-blue-600 text-white text-sm font-medium py-1 px-3 rounded-full">
                        5 Juni 2025
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Efek Interaktif</h3>
                    <p class="text-gray-600 mb-4">Transisi halus dan efek hover yang elegan untuk interaksi yang menyenangkan.</p>
                    <a href="#" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        Lihat Detail
                    </a>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="card bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="relative">
                    <div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-48"></div>
                    <div class="absolute top-4 right-4 bg-blue-600 text-white text-sm font-medium py-1 px-3 rounded-full">
                        1 Juni 2025
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Responsive Design</h3>
                    <p class="text-gray-600 mb-4">Tampilan optimal di semua perangkat, dari desktop hingga mobile.</p>
                    <a href="#" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        Lihat Detail
                    </a>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="card bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="relative">
                    <div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-48"></div>
                    <div class="absolute top-4 right-4 bg-blue-600 text-white text-sm font-medium py-1 px-3 rounded-full">
                        25 Mei 2025
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Search Terintegrasi</h3>
                    <p class="text-gray-600 mb-4">Fitur pencarian yang terintegrasi dengan baik untuk kemudahan navigasi.</p>
                    <a href="#" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-20">
        <div class="container mx-auto px-4 py-12">
            <div class="max-w-3xl mx-auto text-center mb-8">
                <p class="text-xl md:text-2xl font-medium mb-6">Butuh mahasiswa potensial untuk mengikuti lomba anda?</p>
                <button class="admin-btn bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-3 px-8 rounded-full text-lg transition-colors">
                    Daftar sebagai Admin Lomba
                </button>
            </div>
        </div>
        <div class="bg-gray-900 py-6">
            <div class="container mx-auto px-4 text-center">
                <p class="text-gray-400">&copy; lombaku@2025. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const hamburger = document.getElementById('hamburger');
        const navItems = document.getElementById('navItems');

        hamburger.addEventListener('click', () => {
            navItems.classList.toggle('active');
        });

        // Dropdown toggle
        const dropdowns = document.querySelectorAll('.dropdown');

        dropdowns.forEach(dropdown => {
            const toggle = dropdown.querySelector('.dropdown-toggle');

            toggle.addEventListener('click', () => {
                // Close other dropdowns
                dropdowns.forEach(other => {
                    if (other !== dropdown) {
                        other.classList.remove('active');
                    }
                });
                
                // Toggle current dropdown
                dropdown.classList.toggle('active');
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
</body>
</html>