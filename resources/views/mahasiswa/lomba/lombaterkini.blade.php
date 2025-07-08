<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lomba Terkini - Lombaku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .filter-btn.active {
            background-color: #3b82f6 !important; /* blue-600 */
            color: white !important;
            border-color: #3b82f6 !important;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }
        .pagination-link {
            transition: all 0.2s ease-in-out;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">
    <x-public-header-nav />

    <!-- Hero, Search, dan Filter Section -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Temukan Peluang Juaramu</h1>
            <p class="text-blue-100 text-lg">Jelajahi berbagai kompetisi dan raih prestasimu!</p>
        </div>
    </div>
    <div class="container mx-auto px-4 py-8 -mt-8 relative z-10">
        <div class="max-w-2xl mx-auto">
            <div class="flex bg-white rounded-full shadow-xl overflow-hidden">
                <input id="search-input" type="text" class="flex-grow px-6 py-4 focus:outline-none w-full" placeholder="Cari lomba, kategori, atau penyelenggara...">
                <button id="search-button" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 transition-colors">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Bagian Filter Baru -->
    <div class="container mx-auto px-4 py-4 space-y-6">
        <!-- Filter Cepat (Single-select) -->
        <div id="quick-filters" class="flex flex-wrap justify-center gap-3">
            <button data-filter-type="all" class="filter-btn active px-4 py-2 rounded-full border border-blue-500 bg-blue-500 text-white font-medium">Semua</button>
            <button data-filter-type="tingkat" data-filter-value="nasional" class="filter-btn px-4 py-2 rounded-full border border-gray-300 bg-white text-gray-600 hover:bg-gray-50">Nasional</button>
            <button data-filter-type="tingkat" data-filter-value="internasional" class="filter-btn px-4 py-2 rounded-full border border-gray-300 bg-white text-gray-600 hover:bg-gray-50">Internasional</button>
            <button data-filter-type="lokasi" data-filter-value="online" class="filter-btn px-4 py-2 rounded-full border border-gray-300 bg-white text-gray-600 hover:bg-gray-50">Online</button>
            <button data-filter-type="lokasi" data-filter-value="offline" class="filter-btn px-4 py-2 rounded-full border border-gray-300 bg-white text-gray-600 hover:bg-gray-50">Offline</button>
        </div>
        <!-- Filter Kategori (Multi-select) -->
        <div class="border-t pt-6">
             <h3 class="text-center font-semibold text-gray-700 mb-4">Filter Berdasarkan Kategori</h3>
             <div id="category-filter-container" class="flex flex-wrap justify-center gap-3 min-h-[3rem] items-center">
                 <i id="category-loading" class="fas fa-spinner fa-spin text-blue-500"></i>
             </div>
        </div>
    </div>

    <!-- Lomba Grid -->
    <div class="container mx-auto px-4 py-8">
        <div id="lomba-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 min-h-[400px]">
            <div id="loading-state" class="col-span-full flex justify-center items-center">
                 <i class="fas fa-spinner fa-spin fa-3x text-blue-500"></i>
            </div>
        </div>
        <div id="pagination-container" class="mt-12"></div>
    </div>

    <!-- Template untuk satu kartu lomba -->
    <template id="lomba-card-template">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-1.5">
            <!-- ====================================================== -->
            <!-- ===          PERBAIKAN UTAMA ADA DI SINI         === -->
            <!-- ====================================================== -->
            <!-- Pembungkus gambar dibuat menjadi kotak (1:1) dengan aspect-square -->
            <div class="relative overflow-hidden aspect-square">
                <!-- Gambar diubah menjadi h-full untuk mengisi tinggi pembungkusnya -->
                <img class="lomba-image w-full h-full object-cover" src="" alt="Foto Lomba">
            </div>
            <!-- ====================================================== -->
            
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
    const lombaGrid = document.getElementById('lomba-grid');
    const loadingState = document.getElementById('loading-state');
    const paginationContainer = document.getElementById('pagination-container');
    const template = document.getElementById('lomba-card-template');
    const searchInput = document.getElementById('search-input');
    const searchButton = document.getElementById('search-button');
    const quickFiltersContainer = document.getElementById('quick-filters');
    const categoryFilterContainer = document.getElementById('category-filter-container');
    const categoryLoading = document.getElementById('category-loading');
    
    let currentQuickFilter = {};
    let currentSearch = '';
    let selectedTagIds = new Set();

    const formatDate = (dateString) => new Date(dateString).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

    async function fetchAndRenderCategories() {
        try {
            const response = await axios.get('/api/tags');
            categoryLoading.style.display = 'none';
            categoryFilterContainer.innerHTML = '';
            response.data.data.forEach(tag => {
                const button = document.createElement('button');
                button.className = 'filter-btn px-4 py-2 rounded-full border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 transition-colors';
                button.dataset.tagId = tag.id_tag;
                button.textContent = tag.nama_tag;
                categoryFilterContainer.appendChild(button);
            });
        } catch (error) {
            console.error('Gagal mengambil kategori:', error);
            categoryLoading.style.display = 'none';
            categoryFilterContainer.innerHTML = `<p class="text-red-500">Gagal memuat kategori.</p>`;
        }
    }

    async function fetchLombas(page = 1) {
        loadingState.style.display = 'flex';
        lombaGrid.innerHTML = '';
        lombaGrid.appendChild(loadingState);

        const params = new URLSearchParams({ page, search: currentSearch, ...currentQuickFilter });
        selectedTagIds.forEach(tagId => params.append('tags[]', tagId));

        params.append('status[]', 'disetujui');
        params.append('status[]', 'berlangsung');

        try {
            const response = await axios.get(`/api/lomba?${params.toString()}`);
            const paginationObject = response.data.data;
            renderLombas(paginationObject);
            renderPagination(paginationObject);
        } catch (error) {
            console.error('Gagal mengambil data lomba:', error);
            lombaGrid.innerHTML = `<div class="col-span-full text-center text-red-500 py-10">Gagal memuat data. Silakan coba lagi.</div>`;
        } finally {
            loadingState.style.display = 'none';
        }
    }

    function renderLombas(paginationObject) {
        lombaGrid.innerHTML = '';
        const lombas = paginationObject.data;

        if (lombas.length === 0) {
            lombaGrid.innerHTML = `<div class="col-span-full text-center text-gray-500 py-10">Tidak ada lomba yang ditemukan dengan kriteria ini.</div>`;
            return;
        }
        
        lombas.forEach(lomba => {
            const card = template.content.cloneNode(true);
            
            const imageEl = card.querySelector('.lomba-image');
            if (lomba.foto_lomba_url) {
                imageEl.src = lomba.foto_lomba_url;
            } else {
                imageEl.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(lomba.nama_lomba)}&background=EBF4FF&color=1D4ED8&size=300`;
            }
            imageEl.alt = lomba.nama_lomba;

            card.querySelector('.lomba-tingkat').textContent = lomba.tingkat;
            card.querySelector('.lomba-lokasi').textContent = lomba.lokasi;
            card.querySelector('.lomba-status').textContent = lomba.status.replace(/_/g, ' ');
            card.querySelector('.lomba-nama').textContent = lomba.nama_lomba;
            card.querySelector('.lomba-tanggal').textContent = 's/d ' + formatDate(lomba.tanggal_akhir_registrasi);
            card.querySelector('.lomba-penyelenggara').textContent = lomba.penyelenggara || 'N/A';
            card.querySelector('.lomba-link').href = `/lomba/${lomba.id_lomba}`;
            
            const tagsContainer = card.querySelector('.lomba-tags');
            tagsContainer.innerHTML = '';
            lomba.tags.slice(0, 1).forEach(tag => {
                const tagEl = document.createElement('span');
                tagEl.className = 'bg-purple-100 text-purple-800 text-xs font-semibold px-2 py-1 rounded-full';
                tagEl.textContent = tag.nama_tag;
                tagsContainer.appendChild(tagEl);
            });
            lombaGrid.appendChild(card);
        });
    }

    function renderPagination(data) {
        paginationContainer.innerHTML = '';
        if (!data.links || data.links.length <= 3) return;
        
        const nav = document.createElement('nav');
        nav.className = 'flex items-center justify-center space-x-1';
        
        data.links.forEach(link => {
            if (!link.url && (link.label.includes('...') || !link.label)) {
                const dots = document.createElement('span');
                dots.className = 'px-4 py-2 text-gray-500';
                dots.innerHTML = '...';
                nav.appendChild(dots);
                return;
            }

            const pageButton = document.createElement('a');
            pageButton.href = '#';
            pageButton.innerHTML = link.label.replace(/«/g, '<i class="fas fa-chevron-left"></i>').replace(/»/g, '<i class="fas fa-chevron-right"></i>');
            pageButton.className = 'pagination-link px-4 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 rounded-md';

            if (link.active) {
                pageButton.className = 'pagination-link px-4 py-2 border border-blue-600 bg-blue-600 text-white font-medium rounded-md z-10';
            }
            if (!link.url) {
                pageButton.className += ' cursor-not-allowed text-gray-400 bg-gray-100';
            } else {
                 pageButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    const url = new URL(link.url);
                    fetchLombas(url.searchParams.get('page'));
                });
            }
            nav.appendChild(pageButton);
        });
        paginationContainer.appendChild(nav);
    }
    
    searchButton.addEventListener('click', () => { currentSearch = searchInput.value; fetchLombas(1); });
    searchInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') { currentSearch = searchInput.value; fetchLombas(1); }});

    quickFiltersContainer.addEventListener('click', (e) => {
        if (e.target.tagName !== 'BUTTON') return;
        document.querySelectorAll('#quick-filters .filter-btn').forEach(btn => btn.classList.remove('active'));
        e.target.classList.add('active');
        const type = e.target.dataset.filterType;
        currentQuickFilter = (type === 'all') ? {} : { [type]: e.target.dataset.filterValue };
        fetchLombas(1);
    });

    categoryFilterContainer.addEventListener('click', (e) => {
        if (e.target.tagName !== 'BUTTON') return;
        const button = e.target;
        const tagId = button.dataset.tagId;
        button.classList.toggle('active');
        if (button.classList.contains('active')) selectedTagIds.add(tagId);
        else selectedTagIds.delete(tagId);
        fetchLombas(1);
    });

    // Panggilan Inisialisasi
    fetchAndRenderCategories();
    fetchLombas();
});
</script>
</body>
</html>