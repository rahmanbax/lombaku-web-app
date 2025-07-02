<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lomba Tersimpan - Lombaku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }

        /* ======================================= */
        /* === CSS DARI WELCOME.BLADE.PHP DITAMBAHKAN === */
        /* ======================================= */
        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-weight: 600;
            text-transform: capitalize;
        }
        /* ======================================= */
        /* === AKHIR PENAMBAHAN CSS ================ */
        /* ======================================= */

    </style>
</head>
<body class="bg-gray-100">

    <x-public-header-nav />

    <main class="container mx-auto p-4 lg:py-10 lg:px-0">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Lomba Tersimpan</h1>

        <!-- Loading Spinner -->
        <div id="loading-spinner" class="text-center py-10">
            <i class="fas fa-spinner fa-spin fa-3x text-blue-500"></i>
        </div>

        <!-- Container untuk daftar bookmark -->
        <div id="bookmark-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Kartu Lomba akan dimasukkan di sini oleh JavaScript -->
        </div>

        <!-- Pesan jika tidak ada bookmark -->
        <div id="no-bookmarks-message" class="hidden text-center py-20 bg-white rounded-lg shadow">
            <i class="far fa-folder-open fa-4x text-gray-400 mb-4"></i>
            <h2 class="text-xl font-semibold text-gray-700">Belum Ada Lomba yang Disimpan</h2>
            <p class="text-gray-500 mt-2">Mulai jelajahi dan simpan lomba yang Anda minati!</p>
            <a href="{{ route('lombaterkini') }}" class="mt-6 inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors">
                Cari Lomba Sekarang
            </a>
        </div>

    </main>

    <script>
    document.addEventListener('DOMContentLoaded', async function () {
        const listContainer = document.getElementById('bookmark-list');
        const loader = document.getElementById('loading-spinner');
        const emptyMessage = document.getElementById('no-bookmarks-message');

        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }

        /* ======================================================== */
        /* === FUNGSI getStatusBadge DIPERBARUI AGAR SAMA PERSIS === */
        /* ======================================================== */
        function getStatusBadge(status) {
            let className = '';
            let statusText = status.replace(/_/g, ' ');

            switch (status) {
                case 'disetujui':
                    className = 'bg-green-100 text-green-800';
                    statusText = "Buka Pendaftaran";
                    break;
                case 'berlangsung':
                    className = 'bg-blue-100 text-blue-800';
                    statusText = "Berlangsung";
                    break;
                case 'selesai':
                    className = 'bg-gray-200 text-gray-800';
                    statusText = "Selesai";
                    break;
                case 'ditolak':
                    className = 'bg-red-100 text-red-800';
                    statusText = "Ditolak";
                    break;
                case 'belum disetujui':
                    className = 'bg-orange-100 text-orange-800';
                    statusText = "Review";
                    break;
                default:
                    return ''; // Jangan tampilkan badge jika status tidak dikenali
            }
            return `<span class="status-badge ${className}">${statusText}</span>`;
        }
        /* ======================================================== */
        /* === AKHIR DARI PERUBAHAN FUNGSI ========================== */
        /* ======================================================== */

        function createLombaCard(lomba) {
            const placeholderImage = `https://ui-avatars.com/api/?name=${encodeURIComponent(lomba.nama_lomba)}&background=EBF4FF&color=1D4ED8&size=400`;
            const imageUrl = lomba.foto_lomba_url || placeholderImage;

            const tagsHtml = lomba.tags.slice(0, 2).map(tag =>
                `<span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full">${tag.nama_tag}</span>`
            ).join('');
            
            // Panggilan fungsi ini sekarang akan menghasilkan badge yang sama dengan halaman welcome
            const statusBadge = getStatusBadge(lomba.status);

            return `
                <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                    <a href="/lomba/${lomba.id_lomba}" class="block">
                        <div class="relative">
                            <img src="${imageUrl}" alt="Foto ${lomba.nama_lomba}" class="w-full h-48 object-cover">
                            <!-- Tempat untuk status badge -->
                            <div class="absolute top-3 right-3">
                                ${statusBadge}
                            </div>
                        </div>
                    </a>
                    
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="flex flex-wrap gap-2 mb-2">
                            ${tagsHtml}
                        </div>
                        
                        <a href="/lomba/${lomba.id_lomba}" class="block">
                            <h3 class="text-lg font-bold text-gray-900 truncate group-hover:text-blue-600 transition-colors" title="${lomba.nama_lomba}">
                                ${lomba.nama_lomba}
                            </h3>
                        </a>

                        <p class="text-sm text-gray-500 mt-1">
                            Oleh ${lomba.penyelenggara || (lomba.pembuat ? lomba.pembuat.nama : 'Penyelenggara')}
                        </p>

                        <div class="flex-grow"></div>

                        <div class="mt-4 border-t pt-4 space-y-2 text-sm">
                            <div class="flex items-center text-red-600">
                                <i class="fas fa-calendar-times fa-fw mr-3"></i>
                                <span>Batas Pendaftaran: <strong>${formatDate(lomba.tanggal_akhir_registrasi)}</strong></span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-award fa-fw mr-3"></i>
                                <span class="capitalize">Tingkat ${lomba.tingkat}</span>
                            </div>
                        </div>
                        
                        <a href="/lomba/${lomba.id_lomba}" class="mt-5 block w-full text-center bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors">
                            Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            `;
        }

        async function loadBookmarks() {
            try {
                const response = await axios.get('/api/bookmarks');
                
                if (response.data.success && response.data.data.length > 0) {
                    listContainer.innerHTML = '';
                    response.data.data.forEach(lomba => {
                        listContainer.innerHTML += createLombaCard(lomba);
                    });
                } else {
                    emptyMessage.classList.remove('hidden');
                }
            } catch (error) {
                console.error('Gagal mengambil data bookmark:', error);
                if(error.response && error.response.status === 401) {
                     listContainer.innerHTML = `<p class="text-red-500 col-span-full text-center">Anda harus login untuk melihat halaman ini.</p>`;
                } else {
                     listContainer.innerHTML = `<p class="text-red-500 col-span-full text-center">Terjadi kesalahan saat memuat data. Coba lagi nanti.</p>`;
                }
            } finally {
                loader.classList.add('hidden');
            }
        }

        loadBookmarks();
    });
    </script>
</body>
</html>