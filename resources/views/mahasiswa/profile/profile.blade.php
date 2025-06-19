<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Mahasiswa - Lombaku</title>
    <!-- CSRF Token untuk keamanan request AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
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

    <!-- Profile Content -->
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Sidebar -->
            <div class="w-full md:w-1/4 bg-white rounded-xl shadow-md p-6 h-fit">
                <div class="flex flex-col items-center mb-6">
                    <div id="profile-avatar" class="bg-blue-500 text-white w-20 h-20 rounded-full flex items-center justify-center text-2xl font-bold mb-4">
                        <!-- Avatar diisi oleh JS -->
                    </div>
                    <h2 id="profile-username" class="text-xl font-bold text-gray-800">{{ Auth::user()->username }}</h2>

                    <p id="profile-headline" class="text-center text-sm text-gray-600 mt-2">...</p>
                </div>

                <div id="sidebar-nav" class="space-y-2">
                    <!-- Navigasi sidebar -->
                    <button class="w-full flex items-center space-x-3 p-3 bg-blue-50 text-blue-600 rounded-lg font-medium">
                        <i class="fas fa-user w-5"></i>
                        <span>Profil Saya</span>
                    </button>
                    <a href="#" class="w-full flex items-center space-x-3 p-3 hover:bg-gray-100 rounded-lg text-gray-700">
                        <i class="fas fa-trophy w-5"></i>
                        <span>Lomba Diikuti</span>
                    </a>
                    <a href="{{ route('simpanlomba') }}" class="w-full flex items-center space-x-3 p-3 hover:bg-gray-100 rounded-lg text-gray-700">
                        <i class="fas fa-heart w-5"></i>
                        <span>Lomba Disimpan</span>
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div id="main-profile-content" class="w-full md:w-3/4 bg-white rounded-xl shadow-md p-8">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold text-gray-800">Profil Mahasiswa</h1>
                    <button class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <a href="{{ route('profile.edit') }}" class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-edit"></i>
                            <span>Edit Profil</span>
                        </a>
                    </button>
                </div>

                <!-- Informasi Akademik -->
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
                    <div><label class="text-gray-500 text-sm">Tanggal Lahir</label>
                        <div id="profile-tgl-lahir" class="font-medium text-gray-800">...</div>
                    </div>
                    <div><label class="text-gray-500 text-sm">Jenis Kelamin</label>
                        <div id="profile-jenis-kelamin" class="font-medium text-gray-800">...</div>
                    </div>
                    <div><label class="text-gray-500 text-sm">Nomor Telepon</label>
                        <div id="profile-notelp" class="font-medium text-gray-800">...</div>
                    </div>
                    <div><label class="text-gray-500 text-sm">Domisili</label>
                        <div id="profile-domisili" class="font-medium text-gray-800">...</div>
                    </div>
                    <div class="md:col-span-2"><label class="text-gray-500 text-sm">Alamat Lengkap</label>
                        <div id="profile-alamat" class="font-medium text-gray-800">...</div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-gray-500 text-sm">Sosial Media</label>
                        <div id="profile-sosmed" class="flex items-center space-x-4 mt-2">
                            <!-- Sosial Media diisi oleh JS -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-gray-800 text-white py-12 mt-12">
        <!-- Konten footer Anda -->
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Helper untuk memformat tanggal
            const formatDate = (dateString) => {
                if (!dateString) return '-';
                return new Date(dateString).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            };

            // Fungsi untuk membuat placeholder skeleton
            const setSkeleton = (id) => {
                document.getElementById(id).innerHTML = `<div class="skeleton h-5 w-3/4"></div>`;
            };

            // Fungsi utama untuk memuat dan merender data
            async function loadAndRenderProfile() {
                // Tampilkan skeleton loading
                ['profile-nama', 'profile-nim', 'profile-prodi', 'profile-email', 'profile-tgl-lahir', 'profile-jenis-kelamin', 'profile-notelp', 'profile-domisili', 'profile-alamat'].forEach(setSkeleton);

                try {
                    const response = await axios.get('/api/profil-mahasiswa');
                    if (response.data.success) {
                        const profileData = response.data.data;
                        const userData = profileData.user;
                        const prodiData = profileData.program_studi;

                        // Render data ke elemen HTML
                        document.getElementById('profile-nama').textContent = userData.nama || '-';
                        document.getElementById('profile-nim').textContent = profileData.nim || '-';
                        document.getElementById('profile-email').textContent = userData.email || '-';
                        document.getElementById('profile-prodi').textContent = prodiData ? prodiData.nama_program_studi : '-';
                        document.getElementById('profile-headline').textContent = profileData.headline || 'Mahasiswa';

                        // Data Personal
                        document.getElementById('profile-tgl-lahir').textContent = formatDate(profileData.tanggal_lahir);
                        document.getElementById('profile-jenis-kelamin').textContent = profileData.jenis_kelamin || '-';
                        document.getElementById('profile-notelp').textContent = userData.notelp || '-';

                        const domisili = [profileData.domisili_kabupaten, profileData.domisili_provinsi, profileData.kode_pos].filter(Boolean).join(', ');
                        document.getElementById('profile-domisili').textContent = domisili || '-';
                        document.getElementById('profile-alamat').textContent = profileData.alamat_lengkap || '-';

                        // Render Avatar
                        const avatarContainer = document.getElementById('profile-avatar');
                        if (userData.foto_profile) {
                            avatarContainer.innerHTML = `<img src="{{ asset('') }}${userData.foto_profile}" class="w-20 h-20 rounded-full object-cover">`;
                        } else {
                            avatarContainer.textContent = userData.nama ? userData.nama.charAt(0).toUpperCase() : '?';
                        }

                        // Render Sosial Media
                        const sosmedContainer = document.getElementById('profile-sosmed');
                        sosmedContainer.innerHTML = ''; // Kosongkan dulu
                        if (profileData.sosial_media && Object.keys(profileData.sosial_media).length > 0) {
                            for (const [platform, url] of Object.entries(profileData.sosial_media)) {
                                if (url) {
                                    let iconClass = 'fas fa-link'; // default icon
                                    if (platform === 'linkedin') iconClass = 'fab fa-linkedin';
                                    if (platform === 'github') iconClass = 'fab fa-github';
                                    if (platform === 'instagram') iconClass = 'fab fa-instagram';

                                    const linkEl = document.createElement('a');
                                    linkEl.href = url;
                                    linkEl.target = '_blank';
                                    linkEl.className = 'text-gray-500 hover:text-blue-600 transition-colors';
                                    linkEl.innerHTML = `<i class="${iconClass} fa-2x"></i>`;
                                    sosmedContainer.appendChild(linkEl);
                                }
                            }
                        } else {
                            sosmedContainer.innerHTML = `<p class="text-sm text-gray-400">Belum ada sosial media ditambahkan.</p>`;
                        }
                    }
                } catch (error) {
                    console.error('Gagal memuat profil:', error);
                    document.getElementById('main-profile-content').innerHTML = `<p class="text-red-500 text-center">Gagal memuat data profil. Silakan coba lagi.</p>`;
                }
            }

            // Panggil fungsi utama saat halaman dimuat
            loadAndRenderProfile();
        });
    </script>
</body>

</html>