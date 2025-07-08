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
                
                <!-- =============================================== -->
                <!-- === PERBAIKAN UTAMA: Mengubah Rasio Aspek Gambar === -->
                <!-- =============================================== -->
                <img id="lomba-image" src="" alt="Foto Lomba" class="rounded-lg object-cover w-full aspect-square shadow-lg bg-gray-200">
                
                <div id="action-button-container" class="mt-6 space-y-3">
                    {{-- Tombol akan dibuat oleh JavaScript --}}
                </div>
                <button id="bookmark-btn" class="mt-3 w-full bg-white border border-gray-300 text-gray-700 font-bold py-3 px-6 rounded-lg hover:bg-gray-50 transition-all">
                    <i class="far fa-bookmark mr-2"></i> <span>Simpan Lomba</span>
                </button>
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
                        <div><p class="font-semibold text-gray-800">Tingkat</p><p id="lomba-tingkat" class="text-gray-600 capitalize">-</p></div>
                    </div>
                    <div class="flex items-start">
                        <i id="lomba-jenis-icon" class="fas fa-lg text-blue-500 mt-1 mr-4"></i>
                        <div><p class="font-semibold text-gray-800">Jenis Lomba</p><p id="lomba-jenis-text" class="text-gray-600 capitalize">-</p></div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt fa-lg text-blue-500 mt-1 mr-4"></i>
                        <div><p class="font-semibold text-gray-800">Lokasi</p><p id="lomba-lokasi" class="text-gray-600 capitalize">-</p></div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-flag-checkered fa-lg text-blue-500 mt-1 mr-4"></i>
                        <div><p class="font-semibold text-gray-800">Status</p><p id="lomba-status" class="text-gray-600 capitalize">-</p></div>
                    </div>
                    <div class="flex items-start col-span-2 sm:col-span-1">
                        <i class="fas fa-calendar-times fa-lg text-red-500 mt-1 mr-4"></i>
                        <div><p class="font-semibold text-gray-800">Batas Registrasi</p><p id="lomba-tanggal-akhir-registrasi" class="text-gray-600">-</p></div>
                    </div>
                </div>
                <div class="border-t my-6"></div>
                <h2 class="font-bold text-xl text-gray-800">Deskripsi</h2>
                <div id="lomba-deskripsi" class="mt-4 p-5 bg-gray-50/75 rounded-lg border text-gray-700 leading-relaxed prose max-w-none">
                    <p>Memuat deskripsi...</p>
                </div>
            </div>
        </section>
    </main>

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
    // JavaScript tidak perlu diubah karena hanya kelas CSS yang diganti.
    // Seluruh kode JavaScript Anda tetap sama.
    document.addEventListener('DOMContentLoaded', function() {
        const loadingOverlay = document.getElementById('loading-overlay');
        const mainContent = document.getElementById('main-content');
        const bookmarkBtn = document.getElementById('bookmark-btn');
        const actionButtonContainer = document.getElementById('action-button-container');
        const pathParts = window.location.pathname.split('/');
        const lombaId = pathParts[pathParts.length - 1];

        function formatDate(dateString) {
            if (!dateString) return '-';
            return new Date(dateString).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
        }

        async function loadLombaData() {
            if (!lombaId || isNaN(lombaId)) {
                showError('ID Lomba tidak valid.');
                return;
            }
            try {
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
            
            const jenisIconEl = document.getElementById('lomba-jenis-icon');
            const jenisTextEl = document.getElementById('lomba-jenis-text');
            jenisIconEl.className = 'fas fa-lg text-blue-500 mt-1 mr-4'; // Reset
            if (lomba.jenis_lomba === 'individu') {
                jenisIconEl.classList.add('fa-user');
                jenisTextEl.textContent = 'Individu';
            } else if (lomba.jenis_lomba === 'kelompok') {
                jenisIconEl.classList.add('fa-users');
                jenisTextEl.textContent = 'Kelompok';
            } else {
                jenisIconEl.classList.add('fa-question-circle');
                jenisTextEl.textContent = 'Tidak Ditentukan';
            }

            document.getElementById('lomba-lokasi').textContent = lomba.lokasi;
            document.getElementById('lomba-status').textContent = lomba.status.replace(/_/g, ' ');
            document.getElementById('lomba-tanggal-akhir-registrasi').textContent = formatDate(lomba.tanggal_akhir_registrasi);
            document.getElementById('lomba-deskripsi').innerHTML = lomba.deskripsi;

            const tagsContainer = document.getElementById('lomba-tags');
            tagsContainer.innerHTML = '';
            lomba.tags.forEach(tag => {
                const tagEl = document.createElement('span');
                tagEl.className = 'bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full';
                tagEl.textContent = tag.nama_tag;
                tagsContainer.appendChild(tagEl);
            });

            updateBookmarkButton(lomba.is_bookmarked);
            renderActionButtons(lomba);
        }
        
        function renderActionButtons(lomba) {
            actionButtonContainer.innerHTML = '';
            const today = new Date().toISOString().split('T')[0];
            if (lomba.status === 'selesai') {
                const ajukanBtn = document.createElement('a');
                ajukanBtn.href = `/lomba/${lomba.id_lomba}/ajukan-prestasi`;
                ajukanBtn.className = 'block text-center w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-all';
                ajukanBtn.innerHTML = '<i class="fas fa-award mr-2"></i> Ajukan Prestasi';
                actionButtonContainer.appendChild(ajukanBtn);
            } else if (lomba.status === 'disetujui' || lomba.status === 'berlangsung') {
                const registrationEndDate = new Date(lomba.tanggal_akhir_registrasi);
                const todayDate = new Date(today);
                
                if (registrationEndDate >= todayDate) {
                    const daftarBtn = document.createElement('a');
                    daftarBtn.href = `/lomba/${lomba.id_lomba}/registrasi`;
                    daftarBtn.className = 'block text-center w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition-all';
                    daftarBtn.innerHTML = '<i class="fas fa-edit mr-2"></i> Daftar Lomba Sekarang';
                    actionButtonContainer.appendChild(daftarBtn);
                } else {
                    const disabledBtn = document.createElement('button');
                    disabledBtn.disabled = true;
                    disabledBtn.className = 'w-full bg-gray-400 text-white font-bold py-3 px-6 rounded-lg cursor-not-allowed';
                    disabledBtn.textContent = 'Pendaftaran Telah Ditutup';
                    actionButtonContainer.appendChild(disabledBtn);
                }
            } else {
                 const disabledBtn = document.createElement('button');
                 disabledBtn.disabled = true;
                 disabledBtn.className = 'w-full bg-gray-400 text-white font-bold py-3 px-6 rounded-lg cursor-not-allowed';
                 disabledBtn.textContent = 'Lomba Belum Dibuka';
                 actionButtonContainer.appendChild(disabledBtn);
            }
        }
        
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

        async function toggleBookmark() {
            const isCurrentlyBookmarked = bookmarkBtn.dataset.bookmarked === 'true';
            updateBookmarkButton(!isCurrentlyBookmarked); 
            bookmarkBtn.disabled = true;

            try {
                if (isCurrentlyBookmarked) {
                    await axios.delete(`/api/bookmarks/${lombaId}`);
                } else {
                    await axios.post('/api/bookmarks', { id_lomba: lombaId });
                }
            } catch (error) {
                console.error('Error toggling bookmark:', error);
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
            container.innerHTML = `<div class="text-center py-20 col-span-full"><p class="text-red-500 text-lg">${message}</p></div>`;
        }
        
        loadLombaData();
    });
</script>
</body>
</html>