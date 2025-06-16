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
</head>
<body class="bg-gray-50 font-sans">
    <!-- Navbar -->
    <nav class="sticky top-0 z-40 bg-white shadow-sm">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <!-- Logo Section -->
            <div class="flex items-center space-x-2">
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
            <div id="navItems" class="hidden md:flex items-center space-x-6">
                <a href="#" class="text-gray-700 hover:text-primary font-medium transition-colors">Beranda</a>

                <!-- Dropdown Kategori -->
                <div class="relative group">
                    <button class="flex items-center text-gray-700 hover:text-primary font-medium transition-colors">
                        Kategori <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>
                    <div class="absolute hidden group-hover:block bg-white shadow-lg rounded-lg mt-2 py-2 w-48 z-10">
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-gray-700">Akademik</a>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-gray-700">Seni & Desain</a>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-gray-700">Teknologi</a>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-gray-700">Olahraga</a>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-gray-700">Bisnis</a>
                    </div>
                </div>

                <!-- Dropdown Kegiatan Saya -->
                <div class="relative group">
                    <button class="flex items-center text-gray-700 hover:text-primary font-medium transition-colors">
                        Kegiatan Saya <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>
                    <div class="absolute hidden group-hover:block bg-white shadow-lg rounded-lg mt-2 py-2 w-48 z-10">
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-gray-700">Lomba Diikuti</a>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-gray-700">Lomba Diselenggarakan</a>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-gray-700">Favorit</a>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-gray-700">Riwayat</a>
                    </div>
                </div>
                
                <!-- Login/User Section -->
                @if (Auth::check())
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Welcome, {{ Auth::user()->nama }} ({{ Auth::user()->role }})</span>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition-colors">
                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                        </button>
                    </form>
                </div>
                @else
                <a class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-md transition-colors" href="{{ route('login') }}">
                    <i class="fas fa-sign-in-alt mr-1"></i>Login
                </a>
                @endif
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
                    <h2 class="text-xl font-bold text-gray-800">John Smith</h2>
                    <p class="text-gray-500">Mahasiswa</p>
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
                        <div class="font-medium text-gray-800">John Smith</div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-gray-500 text-sm">NIM</label>
                        <div class="font-medium text-gray-800">2023110001</div>
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
        // Toggle mobile menu
        document.getElementById('hamburger').addEventListener('click', function() {
            const navItems = document.getElementById('navItems');
            navItems.classList.toggle('hidden');
            navItems.classList.toggle('flex');
            navItems.classList.toggle('flex-col');
            navItems.classList.toggle('absolute');
            navItems.classList.toggle('bg-white');
            navItems.classList.toggle('w-full');
            navItems.classList.toggle('left-0');
            navItems.classList.toggle('top-16');
            navItems.classList.toggle('p-4');
            navItems.classList.toggle('space-y-4');
            navItems.classList.toggle('shadow-lg');
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