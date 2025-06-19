<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lomba Terkini - Lombaku</title>
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
</head>

<body class="bg-gray-50 font-sans">

    <!-- Hero Section dengan gradient -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Lomba Terkini di Lombaku</h1>
                <p class="text-blue-100 text-lg">Temukan lomba terbaru yang bisa Anda ikuti. Mulai dari lomba nasional hingga internasional, semua ada disini!</p>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="container mx-auto px-4 py-8 -mt-8 relative z-10">
        <div class="max-w-2xl mx-auto">
            <div class="flex bg-white rounded-full shadow-xl border border-blue-100 overflow-hidden ring-2 ring-blue-200 ring-opacity-50">
                <input
                    type="text"
                    class="flex-grow px-6 py-4 focus:outline-none w-full rounded-l-full"
                    placeholder="Cari lomba, kategori, atau penyelenggara...">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 transition-colors rounded-r-full">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="container mx-auto px-4 py-4">
        <div class="flex flex-wrap justify-center gap-3">
            <button class="px-4 py-2 rounded-full border border-blue-300 bg-white text-blue-600 font-medium hover:bg-blue-50 transition-colors focus:ring-2 focus:ring-blue-300">
                Semua Kategori
            </button>
            <button class="px-4 py-2 rounded-full border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 transition-colors focus:ring-2 focus:ring-gray-300">
                Nasional
            </button>
            <button class="px-4 py-2 rounded-full border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 transition-colors focus:ring-2 focus:ring-gray-300">
                Internasional
            </button>
            <button class="px-4 py-2 rounded-full border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 transition-colors focus:ring-2 focus:ring-gray-300">
                Online
            </button>
            <button class="px-4 py-2 rounded-full border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 transition-colors focus:ring-2 focus:ring-gray-300">
                Offline
            </button>
        </div>
    </div>

    <!-- Lomba Grid -->
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($lombas as $lomba)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-1.5">
                <!-- Badge baru untuk lomba terbaru -->
                @if($loop->first)
                <div class="absolute top-4 right-4 bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-bold z-10">
                    BARU!
                </div>
                @endif
                
                <!-- Image container with gradient overlay -->
                <div class="relative">
                    <img class="w-full h-48 object-cover" src="{{ asset($lomba->foto_lomba) }}" alt="Foto Lomba">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-60"></div>
                </div>
                
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                                {{ $lomba->tingkat }}
                            </span>
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                {{ $lomba->lokasi }}
                            </span>
                        </div>
                        <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">
                            {{ $lomba->status }}
                        </span>
                    </div>
                    
                    <h2 class="text-xl font-bold text-gray-900 mb-3">{{ $lomba->nama_lomba }}</h2>
                    
                    <p class="text-gray-600 mb-4 line-clamp-2">
                        {{ $lomba->deskripsi }}
                    </p>
                    
                    <div class="grid grid-cols-2 gap-3 mb-5">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="far fa-calendar-alt mr-2 text-blue-500"></i>
                            <span class="font-medium">Akhir: {{ $lomba->tanggal_akhir_registrasi }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-building mr-2 text-blue-500"></i>
                            <span class="font-medium">{{ $lomba->penyelenggara }}</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center border-t border-gray-100 pt-4">
                        <div class="flex items-center">
                            <i class="fas fa-users text-gray-400 mr-2"></i>
                            <span class="text-sm text-gray-500">24 peserta terdaftar</span>
                        </div>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium flex items-center group">
                            Lihat Detail 
                            <i class="fas fa-arrow-right ml-2 text-sm group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            <nav class="flex items-center space-x-1">
                <a href="#" class="px-4 py-2 rounded-l-lg border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <a href="#" class="px-4 py-2 border border-gray-300 bg-blue-600 text-white font-medium">1</a>
                <a href="#" class="px-4 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">2</a>
                <a href="#" class="px-4 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">3</a>
                <a href="#" class="px-4 py-2 rounded-r-lg border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </nav>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 py-16 mt-12">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Tidak menemukan lomba yang sesuai?</h2>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto mb-8">Daftarkan diri Anda untuk mendapatkan notifikasi ketika ada lomba baru yang sesuai dengan minat Anda</p>
            <div class="max-w-xl mx-auto flex flex-col sm:flex-row gap-4">
                <input 
                    type="email" 
                    placeholder="Email Anda" 
                    class="px-6 py-3 rounded-full focus:outline-none flex-grow">
                <button class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold px-6 py-3 rounded-full transition-colors">
                    Daftar Notifikasi
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="bg-blue-600 w-8 h-8 rounded-full"></div>
                        <span class="text-xl font-bold">Lombaku</span>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Platform terbaik untuk menemukan dan berpartisipasi dalam berbagai lomba dan kompetisi.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Navigasi</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Beranda</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Lomba Terkini</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Kategori Lomba</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Kontak</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Kategori Populer</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Teknologi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Desain</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Bisnis</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Pendidikan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Seni</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Kontak Kami</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3"></i>
                            <span>Jl. Teknologi No. 123, Jakarta</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-3"></i>
                            <span>+62 21 1234 5678</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3"></i>
                            <span>info@lombaku.id</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-12 pt-6 text-center text-gray-400">
                <p>&copy; 2025 Lombaku. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const hamburger = document.getElementById('hamburger');
        const navItems = document.getElementById('navItems');

        hamburger.addEventListener('click', () => {
            navItems.classList.toggle('hidden');
            navItems.classList.toggle('flex');
            navItems.classList.toggle('flex-col');
            navItems.classList.toggle('absolute');
            navItems.classList.toggle('top-16');
            navItems.classList.toggle('left-0');
            navItems.classList.toggle('w-full');
            navItems.classList.toggle('bg-white');
            navItems.classList.toggle('p-4');
            navItems.classList.toggle('space-y-4');
            navItems.classList.toggle('shadow-md');
        });

        // Search functionality
        const searchButton = document.querySelector('.search-button');
        const searchInput = document.querySelector('.search-input');

        searchButton.addEventListener('click', function() {
            if (searchInput.value.trim() !== '') {
                alert(`Anda mencari: "${searchInput.value}"`);
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
    </script>
</body>
</html>