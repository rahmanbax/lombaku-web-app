<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lomba - Lombaku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        #loading-overlay {
            display: flex;
        }

        .bookmarked {
            background-color: #3b82f6 !important;
            color: white !important;
            border-color: #3b82f6 !important;
        }
    </style>
</head>

<body class="bg-gray-100">

    <x-public-header-nav />

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-white bg-opacity-75 z-50 justify-center items-center">
        <i class="fas fa-spinner fa-spin fa-3x text-blue-500"></i>
    </div>

    <!-- Kontainer utama -->
    <main id="main-content" class="container mx-auto p-4 lg:py-10 lg:px-0 opacity-0 transition-opacity duration-500">

        <!-- Kontainer detail lomba -->
        <section id="lomba-detail-container" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Kolom Kiri: Gambar dan Tombol Aksi -->
            <div class="lg:col-span-4">
                <img id="lomba-image" src="" alt="Foto Lomba" class="rounded-lg object-cover w-full aspect-[4/3] shadow-lg bg-gray-200">
                <div class="mt-6 space-y-3">

                    <!-- Tombol Daftar Lomba -->
                    <button id="daftar-btn" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition-all disabled:bg-gray-400 disabled:cursor-not-allowed">
                        <i class="fas fa-edit mr-2"></i> Daftar Lomba
                    </button>

                    <!-- Tombol Bookmark -->
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
        {{-- Konten Footer --}}
    </footer>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // ... (kode Anda yang lain untuk mengambil elemen DOM)
        const loadingOverlay = document.getElementById('loading-overlay');
        const mainContent = document.getElementById('main-content');
        const bookmarkBtn = document.getElementById('bookmark-btn');
        const daftarBtn = document.getElementById('daftar-btn');
        const pathParts = window.location.pathname.split('/');
        const lombaId = pathParts[pathParts.length - 1];

        // ... (fungsi formatDate() Anda)
        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        // ... (fungsi loadLombaData() Anda)
        // Fungsi ini sudah benar karena mengambil status is_bookmarked dari API LombaController@show
        async function loadLombaData() {
            if (!lombaId || isNaN(lombaId)) {
                showError('ID Lomba tidak valid.');
                return;
            }
            try {
                // Panggilan API ini akan mengembalikan data lomba termasuk 'is_bookmarked'
                const response = await axios.get(`/api/lomba/${lombaId}`);
                if (response.data.success) {
                    renderPage(response.data.data);
                } else {
                    showError(response.data.message || 'Lomba tidak ditemukan.');
                }
            } catch (error) {
                console.error('Error fetching lomba data:', error);
                if (error.response && error.response.status === 401) {
                     showError('Sesi Anda telah berakhir. Silakan <a href="/login" class="text-blue-600 hover:underline">login kembali</a> untuk melihat detail lomba.');
                } else {
                     showError('Gagal memuat data lomba. Coba muat ulang halaman.');
                }
            } finally {
                loadingOverlay.style.display = 'none';
                mainContent.classList.remove('opacity-0');
            }
        }

        // ... (fungsi renderPage() Anda)
        // Fungsi ini sudah benar, terutama pada baris updateBookmarkButton(lomba.is_bookmarked);
        function renderPage(lomba) {
            document.title = `${lomba.nama_lomba} - Lombaku`;

            const imageEl = document.getElementById('lomba-image');
            if (lomba.foto_lomba_url) {
                imageEl.src = lomba.foto_lomba_url;
            } else {
                imageEl.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(lomba.nama_lomba)}&background=EBF4FF&color=1D4ED8&size=400`;
            }

            document.getElementById('lomba-nama').textContent = lomba.nama_lomba;
            document.getElementById('penyelenggara-nama').textContent = `Diselenggarakan oleh ${lomba.penyelenggara || (lomba.pembuat ? lomba.pembuat.nama : 'Tidak diketahui')}`;
            document.getElementById('lomba-tingkat').textContent = lomba.tingkat;
            document.getElementById('lomba-lokasi').textContent = lomba.lokasi;
            document.getElementById('lomba-status').textContent = lomba.status.replace(/_/g, ' ');
            document.getElementById('lomba-tanggal-akhir-registrasi').textContent = formatDate(lomba.tanggal_akhir_registrasi);
            document.getElementById('lomba-deskripsi').textContent = lomba.deskripsi;

            const tagsContainer = document.getElementById('lomba-tags');
            tagsContainer.innerHTML = '';
            lomba.tags.forEach(tag => {
                const tagEl = document.createElement('span');
                tagEl.className = 'bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full';
                tagEl.textContent = tag.nama_tag;
                tagsContainer.appendChild(tagEl);
            });

            // Bagian penting: Mengatur status awal tombol bookmark
            updateBookmarkButton(lomba.is_bookmarked);

            const today = new Date();
            const registrationEndDate = new Date(lomba.tanggal_akhir_registrasi);
            today.setHours(0, 0, 0, 0);

            daftarBtn.addEventListener('click', function() {
                window.location.href = `/lomba/${lombaId}/registrasi`;
            });

            if (lomba.status !== 'disetujui' && lomba.status !== 'berlangsung' || registrationEndDate < today) {
                daftarBtn.disabled = true;
                daftarBtn.textContent = 'Pendaftaran Ditutup';
            } else {
                daftarBtn.disabled = false;
            }
        }
        
        // ... (fungsi updateBookmarkButton() Anda, ini sudah benar)
        function updateBookmarkButton(isBookmarked) {
            const icon = bookmarkBtn.querySelector('i');
            const text = bookmarkBtn.querySelector('span');

            if (isBookmarked) {
                bookmarkBtn.classList.add('bookmarked', 'bg-blue-500', 'text-white', 'border-blue-500');
                bookmarkBtn.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
                icon.className = 'fas fa-bookmark mr-2';
                text.textContent = 'Tersimpan';
            } else {
                bookmarkBtn.classList.remove('bookmarked', 'bg-blue-500', 'text-white', 'border-blue-500');
                bookmarkBtn.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
                icon.className = 'far fa-bookmark mr-2';
                text.textContent = 'Simpan Lomba';
            }
            bookmarkBtn.dataset.bookmarked = isBookmarked;
        }

        // Ini adalah fungsi inti yang sudah Anda buat, dan ini sudah benar!
        async function toggleBookmark() {
            const isCurrentlyBookmarked = bookmarkBtn.dataset.bookmarked === 'true';
            
            // Optimistic UI Update: Langsung ubah tampilan tombol tanpa menunggu response API
            updateBookmarkButton(!isCurrentlyBookmarked); 
            bookmarkBtn.disabled = true;

            try {
                let response;
                if (isCurrentlyBookmarked) {
                    // Jika sudah di-bookmark, kirim request DELETE untuk menghapus
                    response = await axios.delete(`/api/bookmarks/${lombaId}`);
                } else {
                    // Jika belum, kirim request POST untuk menambahkan
                    response = await axios.post('/api/bookmarks', { id_lomba: lombaId });
                }
                
                // Tampilkan pesan sukses dari API
                if (response.data && response.data.message) {
                    // Anda bisa menggunakan library notifikasi yang lebih canggih (seperti Toastify)
                    // tapi alert sudah cukup untuk fungsionalitas dasar.
                    // alert(response.data.message); 
                    // Kita tidak perlu alert agar user experience lebih mulus
                }

            } catch (error) {
                console.error('Error toggling bookmark:', error);
                
                // Rollback UI: Kembalikan tampilan tombol ke state semula jika API gagal
                updateBookmarkButton(isCurrentlyBookmarked); 

                if (error.response && error.response.status === 401) {
                    alert('Anda harus login untuk menyimpan lomba.');
                    window.location.href = '/login';
                } else {
                    alert('Gagal mengubah status bookmark. Silakan coba lagi.');
                }
            } finally {
                bookmarkBtn.disabled = false;
            }
        }
        
        bookmarkBtn.addEventListener('click', toggleBookmark);

        function showError(message) {
            const container = document.getElementById('lomba-detail-container');
            // Menggunakan innerHTML agar bisa merender tag <a> pada pesan error
            container.innerHTML = `<div class="text-center py-20 col-span-full"><p class="text-red-500 text-lg">${message}</p></div>`;
        }
        
        loadLombaData();
    });
</script>
</body>

</html>