<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lomba Tersimpan - Lombaku</title>
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

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .saved-header {
            background: linear-gradient(135deg, #3B82F6 0%, #10B981 100%);
        }
        
        .empty-state {
            background-color: rgba(249, 250, 251, 0.8);
            backdrop-filter: blur(5px);
        }
        
        .badge {
            top: 1rem;
            right: 1rem;
        }
    </style>
</head>
<body class="bg-gray-50">
<x-public-header-nav />
    <!-- Header -->
    <div class="saved-header pt-24 pb-12 px-4">
        <div class="container mx-auto">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Lomba Tersimpan</h1>
                <p class="text-blue-100 text-lg">Semua lomba yang Anda simpan untuk referensi masa depan</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Saved Competitions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            <!-- Card 1 -->
            <div class="card bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 relative">
                <div class="absolute top-4 right-4 z-10">
                    <button class="unsave-btn bg-white text-blue-600 p-2 rounded-full shadow-md hover:bg-blue-50 transition-colors">
                        <i class="fas fa-bookmark"></i>
                    </button>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-r from-blue-400 to-blue-600 w-full h-48 flex items-center justify-center">
                        <i class="fas fa-paint-brush text-white text-6xl opacity-70"></i>
                    </div>
                    <div class="absolute top-4 left-4 bg-white text-blue-600 text-sm font-medium py-1 px-3 rounded-full">
                        15 Juni 2025
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Desain</span>
                        <span class="mx-2 text-gray-300">•</span>
                        <span class="text-sm text-gray-500">Gratis</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Lomba Desain Poster Lingkungan</h3>
                    <p class="text-gray-600 mb-4">Kompetisi desain poster bertema pelestarian lingkungan untuk pelajar dan mahasiswa.</p>
                    <div class="flex justify-between items-center">
                        <a href="#" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            Lihat Detail
                        </a>
                        <span class="text-sm text-gray-500">3 hari lagi</span>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="card bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 relative">
                <div class="absolute top-4 right-4 z-10">
                    <button class="unsave-btn bg-white text-blue-600 p-2 rounded-full shadow-md hover:bg-blue-50 transition-colors">
                        <i class="fas fa-bookmark"></i>
                    </button>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-r from-green-400 to-green-600 w-full h-48 flex items-center justify-center">
                        <i class="fas fa-laptop-code text-white text-6xl opacity-70"></i>
                    </div>
                    <div class="absolute top-4 left-4 bg-white text-green-600 text-sm font-medium py-1 px-3 rounded-full">
                        20 Juni 2025
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Teknologi</span>
                        <span class="mx-2 text-gray-300">•</span>
                        <span class="text-sm text-gray-500">Rp 50.000</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Hackathon Fintech Nasional</h3>
                    <p class="text-gray-600 mb-4">Kompetisi pengembangan solusi fintech untuk meningkatkan inklusi keuangan di Indonesia.</p>
                    <div class="flex justify-between items-center">
                        <a href="#" class="inline-block bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            Lihat Detail
                        </a>
                        <span class="text-sm text-gray-500">8 hari lagi</span>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="card bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 relative">
                <div class="absolute top-4 right-4 z-10">
                    <button class="unsave-btn bg-white text-blue-600 p-2 rounded-full shadow-md hover:bg-blue-50 transition-colors">
                        <i class="fas fa-bookmark"></i>
                    </button>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-r from-purple-400 to-purple-600 w-full h-48 flex items-center justify-center">
                        <i class="fas fa-microphone-alt text-white text-6xl opacity-70"></i>
                    </div>
                    <div class="absolute top-4 left-4 bg-white text-purple-600 text-sm font-medium py-1 px-3 rounded-full">
                        25 Juni 2025
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded">Debat</span>
                        <span class="mx-2 text-gray-300">•</span>
                        <span class="text-sm text-gray-500">Rp 75.000</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Debat Bahasa Inggris Nasional</h3>
                    <p class="text-gray-600 mb-4">Kompetisi debat bahasa Inggris dengan tema "Pemuda dan Teknologi Masa Depan".</p>
                    <div class="flex justify-between items-center">
                        <a href="#" class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            Lihat Detail
                        </a>
                        <span class="text-sm text-gray-500">13 hari lagi</span>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="card bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 relative">
                <div class="absolute top-4 right-4 z-10">
                    <button class="unsave-btn bg-white text-blue-600 p-2 rounded-full shadow-md hover:bg-blue-50 transition-colors">
                        <i class="fas fa-bookmark"></i>
                    </button>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 w-full h-48 flex items-center justify-center">
                        <i class="fas fa-robot text-white text-6xl opacity-70"></i>
                    </div>
                    <div class="absolute top-4 left-4 bg-white text-yellow-600 text-sm font-medium py-1 px-3 rounded-full">
                        5 Juli 2025
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Robotik</span>
                        <span class="mx-2 text-gray-300">•</span>
                        <span class="text-sm text-gray-500">Rp 100.000</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Kompetisi Robot Pemadam Api</h3>
                    <p class="text-gray-600 mb-4">Lomba merancang robot yang mampu mendeteksi dan memadamkan api secara mandiri.</p>
                    <div class="flex justify-between items-center">
                        <a href="#" class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            Lihat Detail
                        </a>
                        <span class="text-sm text-gray-500">23 hari lagi</span>
                    </div>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="card bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 relative">
                <div class="absolute top-4 right-4 z-10">
                    <button class="unsave-btn bg-white text-blue-600 p-2 rounded-full shadow-md hover:bg-blue-50 transition-colors">
                        <i class="fas fa-bookmark"></i>
                    </button>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-r from-red-400 to-red-600 w-full h-48 flex items-center justify-center">
                        <i class="fas fa-film text-white text-6xl opacity-70"></i>
                    </div>
                    <div class="absolute top-4 left-4 bg-white text-red-600 text-sm font-medium py-1 px-3 rounded-full">
                        12 Juli 2025
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Film Pendek</span>
                        <span class="mx-2 text-gray-300">•</span>
                        <span class="text-sm text-gray-500">Gratis</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Festival Film Pendek Mahasiswa</h3>
                    <p class="text-gray-600 mb-4">Kompetisi film pendek dengan durasi maksimal 15 menit bertema "Pendidikan Indonesia".</p>
                    <div class="flex justify-between items-center">
                        <a href="#" class="inline-block bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            Lihat Detail
                        </a>
                        <span class="text-sm text-gray-500">30 hari lagi</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="hidden max-w-2xl mx-auto bg-white rounded-xl shadow-sm p-8 text-center mb-16 empty-state">
            <div class="w-24 h-24 mx-auto bg-blue-50 rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-bookmark text-blue-500 text-4xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Lomba Tersimpan</h3>
            <p class="text-gray-600 mb-6">Anda belum menyimpan lomba apapun. Mulai jelajahi dan simpan lomba yang menarik untuk diikuti nanti.</p>
            <a href="#" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                Jelajahi Lomba
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-10">
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

            toggle.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdowns.forEach(other => {
                    if (other !== dropdown) {
                        other.classList.remove('active');
                    }
                });
                dropdown.classList.toggle('active');
            });
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.dropdown')) {
                dropdowns.forEach(dropdown => {
                    dropdown.classList.remove('active');
                });
            }
        });

        // Unsave functionality
        const unsaveButtons = document.querySelectorAll('.unsave-btn');
        const cards = document.querySelectorAll('.card');
        const emptyState = document.getElementById('emptyState');
        
        unsaveButtons.forEach((button, index) => {
            button.addEventListener('click', function() {
                // Remove card with animation
                cards[index].classList.add('opacity-0', 'transform', '-translate-x-8');
                setTimeout(() => {
                    cards[index].remove();
                    
                    // Show empty state if no cards left
                    if (document.querySelectorAll('.card').length === 0) {
                        emptyState.classList.remove('hidden');
                    }
                }, 300);
            });
        });

        // Admin button functionality
        const adminButton = document.querySelector('.admin-btn');
        adminButton.addEventListener('click', function() {
            alert('Fitur pendaftaran admin lomba akan segera tersedia!');
        });
    </script>
</body>
</html>