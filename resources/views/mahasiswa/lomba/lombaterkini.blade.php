<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lomba Terkini - Lombaku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 font-sans">
    <x-public-header-nav />

    <!-- Hero, Search, dan Filter Section (tidak berubah) -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Lomba Terkini di Lombaku</h1>
            <p class="text-blue-100 text-lg">Temukan lomba terbaru yang bisa Anda ikuti!</p>
        </div>
    </div>
    <div class="container mx-auto px-4 py-8 -mt-8 relative z-10">
        <div class="max-w-2xl mx-auto">
            <div class="flex bg-white rounded-full shadow-xl overflow-hidden">
                <input id="search-input" type="text" class="flex-grow px-6 py-4 focus:outline-none w-full" placeholder="Cari lomba, kategori, atau penyelenggara...">
                <button id="search-button" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-4">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-4 py-4">
        <div id="filter-buttons" class="flex flex-wrap justify-center gap-3">
            <button data-filter-type="all" class="filter-btn active px-4 py-2 rounded-full border border-blue-500 bg-blue-500 text-white font-medium">Semua</button>
            <button data-filter-type="tingkat" data-filter-value="nasional" class="filter-btn px-4 py-2 rounded-full border border-gray-300 bg-white text-gray-600 hover:bg-gray-50">Nasional</button>
            <button data-filter-type="tingkat" data-filter-value="internasional" class="filter-btn px-4 py-2 rounded-full border border-gray-300 bg-white text-gray-600 hover:bg-gray-50">Internasional</button>
            <button data-filter-type="lokasi" data-filter-value="online" class="filter-btn px-4 py-2 rounded-full border border-gray-300 bg-white text-gray-600 hover:bg-gray-50">Online</button>
            <button data-filter-type="lokasi" data-filter-value="offline" class="filter-btn px-4 py-2 rounded-full border border-gray-300 bg-white text-gray-600 hover:bg-gray-50">Offline</button>
        </div>
    </div>

    <!-- Lomba Grid -->
    <div class="container mx-auto px-4 py-8">
        <!-- Cangkang untuk diisi oleh JavaScript -->
        <div id="lomba-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 min-h-[400px]">
            <!-- Loading state -->
            <div id="loading-state" class="col-span-full flex justify-center items-center">
                 <i class="fas fa-spinner fa-spin fa-3x text-blue-500"></i>
            </div>
        </div>
        <!-- Kontainer untuk link Paginasi -->
        <div id="pagination-links" class="mt-12 flex justify-center"></div>
    </div>

    <!-- Template untuk satu kartu lomba -->
    <template id="lomba-card-template">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-1.5">
            <div class="relative">
                <img class="lomba-image w-full h-48 object-cover" src="" alt="Foto Lomba">
                <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-60"></div>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex flex-wrap gap-2">
                        <span class="lomba-tingkat px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full capitalize"></span>
                        <span class="lomba-lokasi px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full capitalize"></span>
                    </div>
                    <span class="lomba-status px-3 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full capitalize"></span>
                </div>
                <h2 class="lomba-nama text-xl font-bold text-gray-900 mb-3 line-clamp-2"></h2>
                <div class="grid grid-cols-2 gap-3 mb-5">
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="far fa-calendar-alt mr-2 text-blue-500"></i>
                        <span class="lomba-tanggal font-medium"></span>
                    </div>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-building mr-2 text-blue-500"></i>
                        <span class="lomba-penyelenggara font-medium line-clamp-1"></span>
                    </div>
                </div>
                <div class="flex justify-between items-center border-t border-gray-100 pt-4">
                     <div class="flex items-center text-sm text-gray-500 lomba-tags"></div>
                    <a class="lomba-link text-blue-600 hover:text-blue-800 font-medium flex items-center group" href="#">
                        Lihat Detail 
                        <i class="fas fa-arrow-right ml-2 text-sm group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
    </template>

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
                <p class="text-gray-400">&copy; lombaku@2025. All rights reserved.</p>
            </div>
        </div>
    </footer>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const lombaGrid = document.getElementById('lomba-grid');
    const loadingState = document.getElementById('loading-state');
    const paginationLinks = document.getElementById('pagination-links');
    const template = document.getElementById('lomba-card-template');

    const searchInput = document.getElementById('search-input');
    const searchButton = document.getElementById('search-button');
    const filterButtonsContainer = document.getElementById('filter-buttons');

    let currentFilters = {};
    let currentSearch = '';

    const formatDate = (dateString) => new Date(dateString).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

    async function fetchLombas(page = 1) {
        loadingState.style.display = 'flex';
        lombaGrid.innerHTML = ''; // Kosongkan grid sebelum fetch
        lombaGrid.appendChild(loadingState);

        const params = new URLSearchParams({
            page,
            search: currentSearch,
            ...currentFilters
        });

        try {
            const response = await axios.get(`/api/lomba?${params.toString()}`);
            renderLombas(response.data.data);
            renderPagination(response.data);
        } catch (error) {
            console.error('Gagal mengambil data lomba:', error);
            lombaGrid.innerHTML = `<div class="col-span-full text-center text-red-500">Gagal memuat data. Silakan coba lagi.</div>`;
        } finally {
            loadingState.style.display = 'none';
        }
    }

    function renderLombas(lombas) {
        lombaGrid.innerHTML = ''; // Kosongkan total
        if (lombas.length === 0) {
            lombaGrid.innerHTML = `<div class="col-span-full text-center text-gray-500">Tidak ada lomba yang ditemukan dengan kriteria ini.</div>`;
            return;
        }

        lombas.data.forEach(lomba => {
            const card = template.content.cloneNode(true);
            card.querySelector('.lomba-image').src = `{{ asset('') }}${lomba.foto_lomba}`;
            card.querySelector('.lomba-image').alt = lomba.nama_lomba;
            card.querySelector('.lomba-tingkat').textContent = lomba.tingkat;
            card.querySelector('.lomba-lokasi').textContent = lomba.lokasi;
            card.querySelector('.lomba-status').textContent = lomba.status.replace('_', ' ');
            card.querySelector('.lomba-nama').textContent = lomba.nama_lomba;
            card.querySelector('.lomba-tanggal').textContent = 's/d ' + formatDate(lomba.tanggal_akhir_registrasi);
            card.querySelector('.lomba-penyelenggara').textContent = lomba.penyelenggara || 'N/A';
            card.querySelector('.lomba-link').href = `{{ url('/lomba') }}/${lomba.id_lomba}`;
            
            const tagsContainer = card.querySelector('.lomba-tags');
            lomba.tags.slice(0, 1).forEach(tag => { // Tampilkan maks 1 tag
                const tagEl = document.createElement('span');
                tagEl.className = 'bg-purple-100 text-purple-800 text-xs font-semibold px-2 py-1 rounded-full';
                tagEl.textContent = tag.nama_tag;
                tagsContainer.appendChild(tagEl);
            });

            lombaGrid.appendChild(card);
        });
    }

    function renderPagination(data) {
        paginationLinks.innerHTML = '';
        if (!data.links || data.links.length <= 3) return; // Sembunyikan jika hanya ada prev/next
        
        data.links.forEach(link => {
            const pageButton = document.createElement('a');
            pageButton.href = '#'; // Cegah navigasi
            pageButton.innerHTML = link.label;
            pageButton.className = 'px-4 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50';

            if (link.active) {
                pageButton.className = 'px-4 py-2 border border-blue-600 bg-blue-600 text-white font-medium';
            }
            if (!link.url) {
                pageButton.className += ' cursor-not-allowed text-gray-400';
            } else {
                 pageButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    const url = new URL(link.url);
                    fetchLombas(url.searchParams.get('page'));
                });
            }
            paginationLinks.appendChild(pageButton);
        });
    }
    
    // Event Listeners
    searchButton.addEventListener('click', () => {
        currentSearch = searchInput.value;
        fetchLombas(1);
    });

    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            currentSearch = searchInput.value;
            fetchLombas(1);
        }
    });

    filterButtonsContainer.addEventListener('click', (e) => {
        if (e.target.tagName !== 'BUTTON') return;
        
        document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active', 'bg-blue-500', 'text-white', 'border-blue-500'));
        e.target.classList.add('active', 'bg-blue-500', 'text-white', 'border-blue-500');

        const type = e.target.dataset.filterType;
        const value = e.target.dataset.filterValue;

        if (type === 'all') {
            currentFilters = {};
        } else {
            currentFilters = { [type]: value };
        }
        fetchLombas(1);
    });

    // Initial Load
    fetchLombas();
});
</script>

</body>
</html>