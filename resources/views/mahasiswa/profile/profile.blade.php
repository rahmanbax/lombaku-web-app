<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Mahasiswa - Lombaku</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
        }

        .skeleton {
            background-color: #e5e7eb;
            border-radius: 0.25rem;
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .5;
            }
        }
    </style>
</head>

<body class="bg-gray-50">
    <x-public-header-nav />
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="flex flex-col md:flex-row gap-8">
            <div class="w-full md:w-1/4 bg-white rounded-xl shadow-md p-6 h-fit">
                <div class="flex flex-col items-center mb-6 text-center">
                    <div id="profile-avatar" class="w-24 h-24 rounded-full flex items-center justify-center text-3xl font-bold mb-4 skeleton">
                    </div>
                </div>
                <div id="sidebar-nav" class="space-y-2">
                    <button class="w-full flex items-center space-x-3 p-3 bg-blue-50 text-blue-600 rounded-lg font-medium"><i class="fas fa-user w-5"></i><span>Profil Saya</span></button>
                    <a href="{{ route('status') }}" class="w-full flex items-center space-x-3 p-3 hover:bg-gray-100 rounded-lg text-gray-700"><i class="fas fa-trophy w-5"></i><span>Riwayat Kegiatan</span></a>
                    <a href="{{ route('bookmark') }}" class="w-full flex items-center space-x-3 p-3 hover:bg-gray-100 rounded-lg text-gray-700"><i class="fas fa-heart w-5"></i><span>Lomba Disimpan</span></a>
                </div>
            </div>
            <div id="main-profile-content" class="w-full md:w-3/4 bg-white rounded-xl shadow-md p-8">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold text-gray-800">Profil Mahasiswa</h1>
                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors"><i class="fas fa-edit"></i><span>Edit Profil</span></a>
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Akademik</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 mb-8">
                    <div><label class="text-gray-500 text-sm">Nama Lengkap</label>
                        <div id="profile-nama" class="font-medium text-gray-800">...</div>
                    </div>
                    <div><label class="text-gray-500 text-sm">NIM</label>
                        <div id="profile-nim" class="font-medium text-gray-800">...</div>
                    </div>
                    <div><label class="text-gray-500 text-sm">Program Studi</label>
                        <div id="profile-prodi" class="font-medium text-gray-800">...</div>
                    </div>
                    <div><label class="text-gray-500 text-sm">Email</label>
                        <div id="profile-email" class="font-medium text-gray-800">...</div>
                    </div>
                </div>
                <div class="border-t border-gray-200 my-8"></div>
                <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Personal</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <div><label class="text-gray-500 text-sm">Tanggal Lahir</label><div id="profile-tgl-lahir" class="font-medium text-gray-800">...</div></div>
                    <div><label class="text-gray-500 text-sm">Jenis Kelamin</label><div id="profile-jenis-kelamin" class="font-medium text-gray-800">...</div></div>
                    <div><label class="text-gray-500 text-sm">Nomor Telepon</label><div id="profile-notelp" class="font-medium text-gray-800">...</div></div>
                    <div class="md:col-span-2"><label class="text-gray-500 text-sm">Alamat Lengkap</label><div id="profile-alamat" class="font-medium text-gray-800">...</div></div>
                </div>
            </div>
        </div>

    </div>

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
        document.addEventListener('DOMContentLoaded', function() {
            const formatDate = (dateString) => {
                if (!dateString) return '-';
                return new Date(dateString).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            };
            async function loadAndRenderProfile() {
                try {
                    const response = await axios.get('/api/profil-mahasiswa');
                    if (response.data.success) {
                        const profileData = response.data.data;
                        const userData = profileData.user;
                        const prodiData = profileData.program_studi;
                        document.getElementById('profile-nama').textContent = userData.nama || '-';
                        document.getElementById('profile-nim').textContent = profileData.nim || '-';
                        document.getElementById('profile-email').textContent = userData.email || '-';
                        document.getElementById('profile-prodi').textContent = prodiData ? prodiData.nama_program_studi : '-';
                        document.getElementById('profile-tgl-lahir').textContent = formatDate(profileData.tanggal_lahir);
                        document.getElementById('profile-jenis-kelamin').textContent = profileData.jenis_kelamin || '-';
                        document.getElementById('profile-notelp').textContent = userData.notelp || '-';
                        document.getElementById('profile-alamat').textContent = profileData.alamat_lengkap || '-';
                        
                        const avatarContainer = document.getElementById('profile-avatar');
                        avatarContainer.classList.remove('skeleton'); // Hapus skeleton setelah data dimuat

                        // === PERBAIKAN UTAMA DI SINI ===
                        if (userData.foto_profile) {
                            avatarContainer.innerHTML = `<img src="/storage/${userData.foto_profile}" alt="Foto Profil" class="w-24 h-24 rounded-full object-cover">`;
                        } else {
                            avatarContainer.innerHTML = `<span>${userData.nama ? userData.nama.charAt(0).toUpperCase() : '?'}</span>`;
                            avatarContainer.classList.add('bg-blue-500', 'text-white');
                        }
                    } else {
                        throw new Error(response.data.message || 'Data profil tidak ditemukan.');
                    }
                } catch (error) {
                    console.error('Gagal memuat profil:', error);
                    document.getElementById('main-profile-content').innerHTML = `<p class="text-red-500 text-center">Gagal memuat data profil. Silakan coba lagi.</p>`;
                }
            }
            loadAndRenderProfile();
        });
    </script>
</body>

</html>