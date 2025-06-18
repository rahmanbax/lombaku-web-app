<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Lomba - Lombaku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
        }
        
        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
        }
        
        .status-selesai {
            background-color: #DCFCE7;
            color: #166534;
        }
        
        .status-proses {
            background-color: #FEF9C3;
            color: #854D0E;
        }
        
        .status-gagal {
            background-color: #FEE2E2;
            color: #991B1B;
        }
        
        .history-card {
            transition: all 0.3s ease;
        }
        
        .history-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50">

<x-public-header-nav />
    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Riwayat Lomba</h1>
                    <p class="text-gray-600">Daftar lomba yang pernah Anda ikuti</p>
                </div>
                
                <div class="mt-4 md:mt-0 flex space-x-2">
                    <div class="relative">
                        <select class="appearance-none bg-white border border-gray-300 rounded-lg pl-3 pr-8 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Semua Status</option>
                            <option>Selesai</option>
                            <option>Proses Seleksi</option>
                            <option>Tidak Lolos</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <select class="appearance-none bg-white border border-gray-300 rounded-lg pl-3 pr-8 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Urutkan Terbaru</option>
                            <option>Urutkan Terlama</option>
                            <option>Nama Lomba (A-Z)</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- History List -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <!-- Table Header -->
                <div class="hidden md:grid grid-cols-12 bg-gray-50 px-6 py-3 border-b border-gray-200">
                    <div class="col-span-5 font-medium text-gray-700">Nama Lomba</div>
                    <div class="col-span-2 font-medium text-gray-700">Tanggal</div>
                    <div class="col-span-2 font-medium text-gray-700">Status</div>
                    <div class="col-span-3 font-medium text-gray-700">Aksi</div>
                </div>
                
                <!-- History Item 1 -->
                <div class="history-card grid grid-cols-1 md:grid-cols-12 gap-4 p-6 border-b border-gray-200 hover:bg-gray-50">
                    <div class="md:col-span-5 flex items-start space-x-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
                            <i class="fas fa-laptop-code text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">Hackathon Nasional 2024</h3>
                            <p class="text-gray-600 text-sm mt-1">Kategori: Teknologi</p>
                        </div>
                    </div>
                    
                    <div class="md:col-span-2 flex flex-col">
                        <span class="text-gray-600 text-sm md:hidden">Tanggal</span>
                        <span class="text-gray-800">15 - 17 Juni 2024</span>
                    </div>
                    
                    <div class="md:col-span-2 flex flex-col">
                        <span class="text-gray-600 text-sm md:hidden">Status</span>
                        <span class="status-badge status-selesai">
                            <i class="fas fa-check-circle mr-1"></i> Juara 2
                        </span>
                    </div>
                    
                    <div class="md:col-span-3 flex items-center space-x-3">
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            <i class="fas fa-eye mr-1"></i> Detail
                        </a>
                        <a href="#" class="text-gray-600 hover:text-gray-800 text-sm font-medium">
                            <i class="fas fa-certificate mr-1"></i> Sertifikat
                        </a>
                        <a href="#" class="text-gray-600 hover:text-gray-800 text-sm font-medium">
                            <i class="fas fa-share-alt mr-1"></i> Bagikan
                        </a>
                    </div>
                </div>
                
                <!-- History Item 2 -->
                <div class="history-card grid grid-cols-1 md:grid-cols-12 gap-4 p-6 border-b border-gray-200 hover:bg-gray-50">
                    <div class="md:col-span-5 flex items-start space-x-4">
                        <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                            <i class="fas fa-paint-brush text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">Lomba Desain UI/UX 2024</h3>
                            <p class="text-gray-600 text-sm mt-1">Kategori: Seni & Desain</p>
                        </div>
                    </div>
                    
                    <div class="md:col-span-2 flex flex-col">
                        <span class="text-gray-600 text-sm md:hidden">Tanggal</span>
                        <span class="text-gray-800">1 - 30 Mei 2024</span>
                    </div>
                    
                    <div class="md:col-span-2 flex flex-col">
                        <span class="text-gray-600 text-sm md:hidden">Status</span>
                        <span class="status-badge status-selesai">
                            <i class="fas fa-check-circle mr-1"></i> Finalis
                        </span>
                    </div>
                    
                    <div class="md:col-span-3 flex items-center space-x-3">
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            <i class="fas fa-eye mr-1"></i> Detail
                        </a>
                        <a href="#" class="text-gray-600 hover:text-gray-800 text-sm font-medium">
                            <i class="fas fa-certificate mr-1"></i> Sertifikat
                        </a>
                        <a href="#" class="text-gray-600 hover:text-gray-800 text-sm font-medium">
                            <i class="fas fa-share-alt mr-1"></i> Bagikan
                        </a>
                    </div>
                </div>
                
                <!-- History Item 3 -->
                <div class="history-card grid grid-cols-1 md:grid-cols-12 gap-4 p-6 border-b border-gray-200 hover:bg-gray-50">
                    <div class="md:col-span-5 flex items-start space-x-4">
                        <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600">
                            <i class="fas fa-robot text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">Kompetisi AI Nasional</h3>
                            <p class="text-gray-600 text-sm mt-1">Kategori: Teknologi</p>
                        </div>
                    </div>
                    
                    <div class="md:col-span-2 flex flex-col">
                        <span class="text-gray-600 text-sm md:hidden">Tanggal</span>
                        <span class="text-gray-800">10 April 2024</span>
                    </div>
                    
                    <div class="md:col-span-2 flex flex-col">
                        <span class="text-gray-600 text-sm md:hidden">Status</span>
                        <span class="status-badge status-proses">
                            <i class="fas fa-spinner mr-1"></i> Proses Seleksi
                        </span>
                    </div>
                    
                    <div class="md:col-span-3 flex items-center space-x-3">
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            <i class="fas fa-eye mr-1"></i> Detail
                        </a>
                        <button class="text-gray-400 text-sm font-medium cursor-not-allowed" disabled>
                            <i class="fas fa-certificate mr-1"></i> Sertifikat
                        </button>
                    </div>
                </div>
                
                <!-- History Item 4 -->
                <div class="history-card grid grid-cols-1 md:grid-cols-12 gap-4 p-6 border-b border-gray-200 hover:bg-gray-50">
                    <div class="md:col-span-5 flex items-start space-x-4">
                        <div class="w-16 h-16 bg-red-100 rounded-lg flex items-center justify-center text-red-600">
                            <i class="fas fa-business-time text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">Business Plan Competition</h3>
                            <p class="text-gray-600 text-sm mt-1">Kategori: Bisnis</p>
                        </div>
                    </div>
                    
                    <div class="md:col-span-2 flex flex-col">
                        <span class="text-gray-600 text-sm md:hidden">Tanggal</span>
                        <span class="text-gray-800">1 - 15 Maret 2024</span>
                    </div>
                    
                    <div class="md:col-span-2 flex flex-col">
                        <span class="text-gray-600 text-sm md:hidden">Status</span>
                        <span class="status-badge status-gagal">
                            <i class="fas fa-times-circle mr-1"></i> Tidak Lolos
                        </span>
                    </div>
                    
                    <div class="md:col-span-3 flex items-center space-x-3">
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            <i class="fas fa-eye mr-1"></i> Detail
                        </a>
                        <a href="#" class="text-gray-600 hover:text-gray-800 text-sm font-medium">
                            <i class="fas fa-certificate mr-1"></i> Sertifikat
                        </a>
                    </div>
                </div>
                
                <!-- History Item 5 -->
                <div class="history-card grid grid-cols-1 md:grid-cols-12 gap-4 p-6 hover:bg-gray-50">
                    <div class="md:col-span-5 flex items-start space-x-4">
                        <div class="w-16 h-16 bg-yellow-100 rounded-lg flex items-center justify-center text-yellow-600">
                            <i class="fas fa-book text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">Olimpiade Matematika</h3>
                            <p class="text-gray-600 text-sm mt-1">Kategori: Akademik</p>
                        </div>
                    </div>
                    
                    <div class="md:col-span-2 flex flex-col">
                        <span class="text-gray-600 text-sm md:hidden">Tanggal</span>
                        <span class="text-gray-800">20 Februari 2024</span>
                    </div>
                    
                    <div class="md:col-span-2 flex flex-col">
                        <span class="text-gray-600 text-sm md:hidden">Status</span>
                        <span class="status-badge status-selesai">
                            <i class="fas fa-check-circle mr-1"></i> Peserta
                        </span>
                    </div>
                    
                    <div class="md:col-span-3 flex items-center space-x-3">
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            <i class="fas fa-eye mr-1"></i> Detail
                        </a>
                        <a href="#" class="text-gray-600 hover:text-gray-800 text-sm font-medium">
                            <i class="fas fa-certificate mr-1"></i> Sertifikat
                        </a>
                        <a href="#" class="text-gray-600 hover:text-gray-800 text-sm font-medium">
                            <i class="fas fa-share-alt mr-1"></i> Bagikan
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="flex justify-between items-center mt-8">
                <div class="text-sm text-gray-600">
                    Menampilkan 1-5 dari 12 lomba
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50" disabled>
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="px-3 py-1 border border-blue-500 rounded-md text-white bg-blue-500">
                        1
                    </button>
                    <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        2
                    </button>
                    <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        3
                    </button>
                    <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-chevron-right"></i>
                    </button>
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
                <p class="text-gray-400">© 2025 Lombaku. Hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    <script>
        // Fungsi untuk filter status
        document.querySelectorAll('select').forEach(select => {
            select.addEventListener('change', function() {
                // Di aplikasi nyata, ini akan memfilter data yang ditampilkan
                console.log('Filter diubah:', this.value);
            });
        });
        
        // Fungsi untuk pagination
        document.querySelectorAll('.pagination button').forEach(button => {
            button.addEventListener('click', function() {
                if (!this.disabled) {
                    // Di aplikasi nyata, ini akan mengubah halaman yang ditampilkan
                    console.log('Pindah ke halaman:', this.textContent.trim());
                }
            });
        });
    </script>
</body>
</html>