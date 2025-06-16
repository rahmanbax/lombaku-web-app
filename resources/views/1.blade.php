<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna - Lombaku</title>
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
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
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

            <div class="flex items-center space-x-4">
                <div class="hidden md:flex items-center space-x-2">
                    <i class="fas fa-user-circle text-blue-600 text-xl"></i>
                    <span class="font-medium">{{ $user['nama'] }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang, {{ $user['nama'] }}!</h1>
            <p class="text-gray-600 mb-8">Anda login sebagai {{ $user['role'] }} dengan email {{ $user['email'] }}</p>
            
            <!-- User Info Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Akun</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Username</h3>
                            <p class="text-lg font-medium">{{ $user['username'] }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Nama Lengkap</h3>
                            <p class="text-lg font-medium">{{ $user['nama'] }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Email</h3>
                            <p class="text-lg font-medium">{{ $user['email'] }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Role</h3>
                            <p class="text-lg font-medium capitalize">{{ $user['role'] }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">NIM/NIP</h3>
                            <p class="text-lg font-medium">{{ $user['nim_atau_nip'] ?: '-' }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Instansi</h3>
                            <p class="text-lg font-medium">{{ $user['instansi'] ?: '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <h2 class="text-xl font-bold text-gray-800 mb-4">Aksi Cepat</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <a href="#" class="card bg-white rounded-lg shadow p-6 text-center hover:shadow-md transition-shadow">
                    <div class="bg-blue-100 text-blue-600 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-trophy text-xl"></i>
                    </div>
                    <h3 class="font-medium text-gray-800">Cari Lomba</h3>
                </a>
                
                <a href="#" class="card bg-white rounded-lg shadow p-6 text-center hover:shadow-md transition-shadow">
                    <div class="bg-green-100 text-green-600 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-calendar-check text-xl"></i>
                    </div>
                    <h3 class="font-medium text-gray-800">Lomba Saya</h3>
                </a>
                
                <a href="#" class="card bg-white rounded-lg shadow p-6 text-center hover:shadow-md transition-shadow">
                    <div class="bg-yellow-100 text-yellow-600 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-user-cog text-xl"></i>
                    </div>
                    <h3 class="font-medium text-gray-800">Pengaturan Akun</h3>
                </a>
            </div>
            
            <!-- Recent Activities -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Aktivitas Terbaru</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="bg-blue-100 text-blue-600 w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-medium text-gray-800">Berhasil login ke sistem</h3>
                                <p class="text-sm text-gray-500">Baru saja</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-green-100 text-green-600 w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-medium text-gray-800">Mendaftar lomba "Desain UI/UX Nasional"</h3>
                                <p class="text-sm text-gray-500">2 hari yang lalu</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-purple-100 text-purple-600 w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-medium text-gray-800">Memenangkan lomba "Storytelling Competition"</h3>
                                <p class="text-sm text-gray-500">1 minggu yang lalu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="container mx-auto px-4 py-6">
            <div class="text-center">
                <p class="text-gray-400">&copy; lombaku@2025. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>