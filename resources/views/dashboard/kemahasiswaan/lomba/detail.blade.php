<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tambahkan CSRF Token untuk request POST/DELETE -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Lomba - Lombaku</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        #loading-overlay { display: flex; }
        /* Style untuk tombol bookmark aktif */
        .bookmarked {
            background-color: #3b82f6 !important; /* blue-500 */
            color: white !important;
            border-color: #3b82f6 !important;
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- Pastikan Anda punya komponen blade untuk header -->
    @include('layouts.navbar') <!-- Ganti dengan path include header Anda -->

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-white bg-opacity-75 z-50 justify-center items-center">
        <i class="fas fa-spinner fa-spin fa-3x text-blue-500"></i>
    </div>

    <!-- Kontainer utama, awalnya disembunyikan -->
    <main id="main-content" class="container mx-auto p-4 lg:py-10 lg:px-0 opacity-0 transition-opacity duration-500">
        
        <!-- Kontainer untuk detail lomba -->
        <section id="lomba-detail-container" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Kolom Kiri: Gambar dan Tombol Aksi -->
            <div class="lg:col-span-4">
                <img id="lomba-image" src="" alt="Foto Lomba" class="rounded-lg object-cover w-full aspect-[4/3] shadow-lg bg-gray-200">
                <div class="mt-6 space-y-3">
                    
                    <button id="daftar-btn" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition-all disabled:bg-gray-400 disabled:cursor-not-allowed">
                        <i class="fas fa-edit mr-2"></i> Daftar Lomba
                    </button>
                    
                    <button id="bookmark-btn" class="w-full bg-white border border-gray-300 text-gray-700 font-bold py-3 px-6 rounded-lg hover:bg-gray-50 transition-all">
                        <i class="far fa-bookmark mr-2"></i> <span>Simpan Lomba</span>
                    </button>

                </div>
            </div>

            <!-- Kolom Kanan: Informasi Detail -->
            <div class="lg:col-span-8">
                <div id="lomba-tags" class="flex flex-wrap gap-2 mb-2"></div>
                <h1 id="lomba-nama" class="text-3xl font-bold text-gray-800">Memuat nama lomba...</h1>
                <p id="penyelenggara-nama" class="text-gray-500 mt-1 text-md"></p>
                
                <div class="border-t my-6"></div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-x-6 gap-y-4 text-md">
                    <div class="flex items-start">
                        <i class="fas fa-award fa-lg text-blue-500 mt-1 mr-4"></i>
                        <div>
                            <p class="font-semibold text-gray-800">Tingkat</p>
                            <p id="lomba-tingkat" class="text-gray-600 capitalize">-</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt fa-lg text-blue-500 mt-1 mr-4"></i>
                        <div>
                            <p class="font-semibold text-gray-800">Lokasi</p>
                            <p id="lomba-lokasi" class="text-gray-600 capitalize">-</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-flag-checkered fa-lg text-blue-500 mt-1 mr-4"></i>
                        <div>
                            <p class="font-semibold text-gray-800">Status</p>
                            <p id="lomba-status" class="text-gray-600 capitalize">-</p>
                        </div>
                    </div>
                     <div class="flex items-start col-span-2 sm:col-span-1">
                        <i class="fas fa-calendar-times fa-lg text-red-500 mt-1 mr-4"></i>
                        <div>
                            <p class="font-semibold text-gray-800">Batas Registrasi</p>
                            <p id="lomba-tanggal-akhir-registrasi" class="text-gray-600">-</p>
                        </div>
                    </div>
                </div>

                <h2 class="font-bold mt-6 text-xl">Deskripsi</h2>
                <p id="lomba-deskripsi" class="mt-2 text-gray-700 leading-relaxed"></p>
            </div>
        </template>

        <section class="lg:w-[1038px] mx-auto p-4 lg:px-0 mt-10">
            <h2 class="text-2xl font-bold mb-4">Daftar Peserta</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nama Mahasiswa</th>
                            <th scope="col" class="px-6 py-3">NIM</th>
                            <th scope="col" class="px-6 py-3">Program Studi</th>
                            <th scope="col" class="px-6 py-3">Nama Tim</th>
                            <th scope="col" class="px-6 py-3">Pembimbing</th>
                            <th scope="col" class="px-6 py-3">Status Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody id="peserta-table-body">
                        <!-- Loading state -->
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Memuat data peserta...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

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
                <p class="text-gray-400">© lombaku@2025. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadingOverlay = document.getElementById('loading-overlay');
        const mainContent = document.getElementById('main-content');
        const bookmarkBtn = document.getElementById('bookmark-btn');
        const daftarBtn = document.getElementById('daftar-btn');

        // Mengambil ID Lomba dari URL
        const pathParts = window.location.pathname.split('/');
        const lombaId = pathParts[pathParts.length - 1];

        // Helper untuk format tanggal
        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
        }

        // --- FUNGSI UTAMA UNTUK MENGAMBIL DATA ---
        async function loadLombaData() {
            if (!lombaId || isNaN(lombaId)) {
                showError('ID Lomba tidak valid.');
                return;
            }

            try {
                // Panggil API untuk mendapatkan detail lomba.
                // Jika user login, token akan otomatis disertakan oleh Sanctum jika setup benar.
                const response = await axios.get(`/api/lomba/${lombaId}`);
                
                if (response.data.success) {
                    renderPage(response.data.data);
                } else {
                    showError(response.data.message || 'Lomba tidak ditemukan.');
                }
            } catch (error) {
                console.error('Error fetching lomba data:', error);
                showError('Gagal memuat data lomba. Coba muat ulang halaman.');
            } finally {
                loadingOverlay.style.display = 'none';
                mainContent.classList.remove('opacity-0');
            }

            // --- Fungsi untuk merender tabel peserta ---
            function renderPesertaTable(registrations) {
                const tableBody = document.getElementById('peserta-table-body');
                tableBody.innerHTML = ''; // Hapus loading state

                if (!registrations || registrations.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada peserta yang mendaftar.</td></tr>`;
                    return;
                }

                registrations.forEach(reg => {
                    const row = document.createElement('tr');
                    row.className = 'bg-gray-50';

                    const mahasiswa = reg.mahasiswa;
                    const profil = mahasiswa.profil_mahasiswa;
                    const prodi = profil ? profil.program_studi : null;

                    const namaMahasiswa = mahasiswa ? mahasiswa.nama : 'Data tidak lengkap';
                    const nim = profil ? profil.nim : '-';
                    const namaProdi = prodi ? prodi.nama_program_studi : '-';
                    const namaTim = reg.tim ? reg.tim.nama_tim : 'Individu';
                    const namaPembimbing = reg.dosen_pembimbing ? reg.dosen_pembimbing.nama : 'Tidak ada pembimbing';
                    const statusVerifikasi = capitalize(reg.status_verifikasi);

                    row.innerHTML = `
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">${namaMahasiswa}</th>
                    <td class="px-6 py-4">${nim}</td>
                    <td class="px-6 py-4">${namaProdi}</td>
                    <td class="px-6 py-4">${namaTim}</td>
                    <td class="px-6 py-4">${namaPembimbing}</td>
                    <td class="px-6 py-4">${statusVerifikasi}</td>
                `;
                    tableBody.appendChild(row);
                });
            }

            // --- Fungsi utama untuk mengambil semua data halaman ---
            async function loadPageData() {
                const pathParts = window.location.pathname.split('/');
                const lombaId = pathParts[pathParts.length - 1];

                if (!lombaId || isNaN(lombaId)) {
                    document.getElementById('lomba-detail-container').innerHTML = `<p class="text-red-500">ID Lomba tidak valid.</p>`;
                    return;
                }

                try {
                    // Panggil kedua API secara bersamaan
                    const [lombaResponse, pesertaResponse] = await Promise.all([
                        axios.get(`/api/lomba/${lombaId}`),
                        axios.get(`/api/lomba/${lombaId}/pendaftar`)
                    ]);

                    // Render setiap bagian dengan datanya masing-masing
                    if (lombaResponse.data.success) {
                        renderLombaDetails(lombaResponse.data.data);
                    }
                    if (pesertaResponse.data.success) {
                        renderPesertaTable(pesertaResponse.data.data);
                    }

                } catch (error) {
                    console.error('Error fetching page data:', error);
                    document.getElementById('lomba-detail-container').innerHTML = `<p class="text-red-500">Gagal memuat data halaman. Silakan coba lagi.</p>`;
                    document.getElementById('peserta-table-body').innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-red-500">Gagal memuat data peserta.</td></tr>`;
                }
            }

        // Panggil fungsi utama saat halaman dimuat
        loadLombaData();
    });
    </script>
</body>
</html>