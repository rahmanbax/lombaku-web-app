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

                <div class="border-t my-6"></div>

                <h2 class="font-bold text-xl text-gray-800">Deskripsi</h2>
                <p id="lomba-deskripsi" class="mt-2 text-gray-700 leading-relaxed whitespace-pre-wrap">Memuat deskripsi...</p>
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
        }

        // --- FUNGSI UNTUK MERENDER KONTEN KE HALAMAN ---
        function renderPage(lomba) {
            document.title = `${lomba.nama_lomba} - Lombaku`;
            // Gunakan URL absolut dari root domain
            document.getElementById('lomba-image').src = `{{ url('/') }}/${lomba.foto_lomba}`;
            document.getElementById('lomba-nama').textContent = lomba.nama_lomba;
            document.getElementById('penyelenggara-nama').textContent = `Diselenggarakan oleh ${lomba.penyelenggara || (lomba.pembuat ? lomba.pembuat.nama : 'Tidak diketahui')}`;
            document.getElementById('lomba-tingkat').textContent = lomba.tingkat;
            document.getElementById('lomba-lokasi').textContent = lomba.lokasi;
            document.getElementById('lomba-status').textContent = lomba.status.replace(/_/g, ' ');
            document.getElementById('lomba-tanggal-akhir-registrasi').textContent = formatDate(lomba.tanggal_akhir_registrasi);
            document.getElementById('lomba-deskripsi').textContent = lomba.deskripsi;
            
            // Render tags
            const tagsContainer = document.getElementById('lomba-tags');
            tagsContainer.innerHTML = ''; // Kosongkan dulu
            lomba.tags.forEach(tag => {
                const tagEl = document.createElement('span');
                tagEl.className = 'bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full';
                tagEl.textContent = tag.nama_tag;
                tagsContainer.appendChild(tagEl);
            });

            // Update status tombol bookmark
            updateBookmarkButton(lomba.is_bookmarked);

            // Cek apakah tombol daftar harus aktif
            const today = new Date();
            const registrationEndDate = new Date(lomba.tanggal_akhir_registrasi);
            today.setHours(0, 0, 0, 0); // Reset waktu untuk perbandingan tanggal saja

            if (lomba.status !== 'disetujui' && lomba.status !== 'berlangsung' || registrationEndDate < today) {
                daftarBtn.disabled = true;
                daftarBtn.textContent = 'Pendaftaran Ditutup';
            } else {
                daftarBtn.disabled = false;
            }
        }

        // --- FUNGSI UNTUK MENGELOLA TOMBOL BOOKMARK ---
        function updateBookmarkButton(isBookmarked) {
            const icon = bookmarkBtn.querySelector('i');
            const text = bookmarkBtn.querySelector('span');

            if (isBookmarked) {
                bookmarkBtn.classList.add('bookmarked');
                icon.className = 'fas fa-bookmark mr-2'; // Ikon terisi
                text.textContent = 'Tersimpan';
            } else {
                bookmarkBtn.classList.remove('bookmarked');
                icon.className = 'far fa-bookmark mr-2'; // Ikon outline
                text.textContent = 'Simpan Lomba';
            }
            // Simpan status saat ini di tombol
            bookmarkBtn.dataset.bookmarked = isBookmarked;
        }

        async function toggleBookmark() {
            const isCurrentlyBookmarked = bookmarkBtn.dataset.bookmarked === 'true';
            
            // Optimistic UI update: langsung ubah tampilan tombol
            updateBookmarkButton(!isCurrentlyBookmarked);

            try {
                if (isCurrentlyBookmarked) {
                    // Hapus bookmark
                    await axios.delete(`/api/bookmarks/${lombaId}`);
                } else {
                    // Tambah bookmark
                    await axios.post('/api/bookmarks', { id_lomba: lombaId });
                }
            } catch (error) {
                console.error('Error toggling bookmark:', error);
                // Jika gagal, kembalikan ke state semula
                updateBookmarkButton(isCurrentlyBookmarked); 
                if (error.response && error.response.status === 401) {
                    alert('Anda harus login untuk menyimpan lomba.');
                    // Opsional: redirect ke halaman login
                    // window.location.href = '/login';
                } else {
                    alert('Gagal mengubah status bookmark.');
                }
            }
        }
        
        // Tambahkan event listener ke tombol bookmark
        bookmarkBtn.addEventListener('click', toggleBookmark);

        function showError(message) {
            const container = document.getElementById('lomba-detail-container');
            container.innerHTML = `<div class="text-center py-20 col-span-full"><p class="text-red-500 text-lg">${message}</p></div>`;
        }

        // --- KONFIGURASI AXIOS UNTUK OTENTIKASI ---
        // Axios perlu mengirim header X-CSRF-TOKEN untuk request POST/DELETE
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        if (token) {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
        }

        // Panggil fungsi utama saat halaman dimuat
        loadLombaData();
    });
    </script>
</body>
</html>