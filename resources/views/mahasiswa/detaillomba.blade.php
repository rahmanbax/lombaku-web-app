<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lomba - Lombaku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        .detail-hero {
            background: linear-gradient(135deg, #3B82F6, #10B981);
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -38px;
            top: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #3B82F6;
            border: 3px solid white;
        }
        
        .timeline-item::after {
            content: '';
            position: absolute;
            left: -30px;
            top: 16px;
            width: 2px;
            height: calc(100% - 16px);
            background: #E5E7EB;
        }
        
        .timeline-item:last-child::after {
            display: none;
        }
    </style>
</head>

<body class="bg-gray-50">
   
<x-public-header-nav />
    <!-- Hero Section -->
    <div class="detail-hero text-white py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="flex flex-col md:flex-row gap-8 items-start">
                    <div class="w-full md:w-1/3 bg-white bg-opacity-20 rounded-xl p-4 backdrop-blur-sm">
                        <div class="bg-white bg-opacity-30 rounded-lg aspect-square flex items-center justify-center">
                            <i class="fas fa-trophy text-5xl text-white"></i>
                        </div>
                    </div>
                    <div class="w-full md:w-2/3">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="bg-white text-blue-600 text-xs font-semibold px-2 py-1 rounded">Teknologi</span>
                            <span class="text-white text-opacity-80 text-sm">Lomba Nasional</span>
                        </div>
                        <h1 class="text-3xl font-bold mb-4">Hackathon Nasional 2025</h1>
                        <p class="text-white text-opacity-90 mb-6">Lomba pengembangan aplikasi inovatif untuk solusi masalah sosial di Indonesia. Peserta akan bersaing untuk menciptakan solusi teknologi terbaik.</p>
                        
                        <div class="flex flex-wrap gap-4 mb-6">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-calendar-alt text-white text-opacity-70"></i>
                                <span class="text-white">15 Juni - 20 Juli 2025</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-map-marker-alt text-white text-opacity-70"></i>
                                <span class="text-white">Universitas Indonesia, Depok</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-trophy text-white text-opacity-70"></i>
                                <span class="text-white">Total Hadiah: Rp 50.000.000</span>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap gap-3">
                            <button class="bg-white text-blue-600 hover:bg-gray-100 font-medium py-2 px-6 rounded-lg transition-colors">
                                <i class="fas fa-heart mr-2"></i>Simpan
                            </button>
                            <button class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-medium py-2 px-6 rounded-lg transition-colors">
                                <i class="fas fa-edit mr-2"></i>Daftar Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Left Column -->
                <div class="md:col-span-2">
                    <!-- About Section -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Tentang Lomba</h2>
                        <div class="prose max-w-none">
                            <p>Hackathon Nasional 2025 adalah kompetisi pengembangan aplikasi berbasis solusi sosial yang diadakan oleh Kementerian Komunikasi dan Informatika bekerja sama dengan beberapa universitas terkemuka di Indonesia.</p>
                            <p class="mt-4">Tema tahun ini adalah "Teknologi untuk Kesejahteraan Sosial" dengan fokus pada pengembangan solusi untuk masalah-masalah seperti:</p>
                            <ul class="list-disc pl-5 mt-2">
                                <li>Kesehatan masyarakat</li>
                                <li>Pendidikan inklusif</li>
                                <li>Ketahanan pangan</li>
                                <li>Pengentasan kemiskinan</li>
                            </ul>
                            <p class="mt-4">Peserta akan bekerja dalam tim selama 48 jam untuk mengembangkan prototipe aplikasi yang dapat memberikan dampak sosial positif.</p>
                        </div>
                    </div>
                    
                    <!-- Requirements Section -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Persyaratan</h2>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 mt-1">
                                    <i class="fas fa-check-circle text-green-500"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Peserta</h3>
                                    <p class="text-gray-600 text-sm">Mahasiswa aktif dari perguruan tinggi di Indonesia (D3/D4/S1)</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 mt-1">
                                    <i class="fas fa-check-circle text-green-500"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Tim</h3>
                                    <p class="text-gray-600 text-sm">3-5 orang per tim (boleh dari lintas jurusan/universitas)</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 mt-1">
                                    <i class="fas fa-check-circle text-green-500"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Kemampuan</h3>
                                    <p class="text-gray-600 text-sm">Memiliki kemampuan dasar pemrograman dan desain</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 mt-1">
                                    <i class="fas fa-check-circle text-green-500"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Dokumen</h3>
                                    <p class="text-gray-600 text-sm">Scan KTM dan surat keterangan aktif kuliah</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Organizer Info -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Penyelenggara</h2>
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                                <i class="fas fa-university text-gray-500 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800">Kementerian Kominfo</h3>
                                <p class="text-gray-600 text-sm">Pemerintah Indonesia</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-user text-gray-400 w-5"></i>
                                <span class="text-gray-600">Kontak: Budi Santoso</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-envelope text-gray-400 w-5"></i>
                                <span class="text-gray-600">hackathon@kominfo.go.id</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-phone text-gray-400 w-5"></i>
                                <span class="text-gray-600">(021) 12345678</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-globe text-gray-400 w-5"></i>
                                <a href="#" class="text-blue-600 hover:underline">kominfo.go.id/hackathon</a>
                            </div>
                        </div>
                    </div>
                    
                       
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
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
        // Fungsi untuk tombol daftar
        document.querySelector('.bg-yellow-400').addEventListener('click', function() {
            alert('Anda akan diarahkan ke halaman pendaftaran');
            // Di aplikasi nyata, ini akan mengarahkan ke halaman pendaftaran
        });
        
        // Fungsi untuk tombol simpan
        document.querySelector('.bg-white').addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-check mr-2"></i>Disimpan';
            this.classList.remove('bg-white');
            this.classList.add('bg-green-100', 'text-green-800');
        });
    </script>
</body>
</html>