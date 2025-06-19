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
</head>

<body class="bg-gray-50 font-sans">
   
 <x-public-header-nav />
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
                    class="flex-grow px-6 py-4 focus:outline-none w-full"
                    placeholder="Cari lomba, kategori, atau penyelenggara...">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 transition-colors">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <div class="border-b border-gray-200 my-12"></div>

        <!-- Lomba Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($lombas as $lomba)
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-xl">
                <img class="w-full h-48 object-cover" src="{{ asset($lomba->foto_lomba) }}" alt="Foto Lomba">
                
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                                {{ $lomba->tingkat }}
                            </span>
                            <span class="inline-block ml-2 px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                {{ $lomba->lokasi }}
                            </span>
                        </div>
                        <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">
                            {{ $lomba->status }}
                        </span>
                    </div>
                    
                    <h2 class="mt-4 text-xl font-bold text-gray-900">{{ $lomba->nama_lomba }}</h2>
                    
                    <p class="mt-2 text-gray-600 line-clamp-2">
                        {{ $lomba->deskripsi }}
                    </p>
                    
                    <div class="mt-4 grid grid-cols-2 gap-2">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="far fa-calendar-alt mr-2"></i>
                            <span>Akhir: {{ $lomba->tanggal_akhir_registrasi }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>{{ $lomba->penyelenggara }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-between items-center">               
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                            Lihat Detail <i class="fas fa-arrow-right ml-1 text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-20">
        <div class="container mx-auto px-4 py-12">
            <div class="max-w-3xl mx-auto text-center mb-8">
                <p class="text-xl md:text-2xl font-medium mb-6">Butuh mahasiswa potensial untuk mengikuti lomba anda?</p>
                <button class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-3 px-8 rounded-full text-lg transition-colors">
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

        // Dropdown toggle
        document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
            toggle.addEventListener('click', (e) => {
                e.stopPropagation();
                const dropdown = toggle.closest('.dropdown');
                const menu = dropdown.querySelector('.dropdown-menu');
                
                menu.classList.toggle('opacity-0');
                menu.classList.toggle('invisible');
                menu.classList.toggle('translate-y-2');
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if (!menu.classList.contains('opacity-0')) {
                    menu.classList.add('opacity-0', 'invisible', 'translate-y-2');
                }
            });
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

        // Admin button functionality
        const adminButton = document.querySelector('.admin-btn');
        if (adminButton) {
            adminButton.addEventListener('click', function() {
                alert('Fitur pendaftaran admin lomba akan segera tersedia!');
            });
        }
    </script>
</body>

</html>