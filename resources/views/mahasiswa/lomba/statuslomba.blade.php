<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Kegiatan - Lombaku</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background-color: #f9fafb; }
        .status-badge { font-size: 0.75rem; padding: 0.25rem 0.75rem; border-radius: 9999px; font-weight: 500;}
        .status-prestasi { background-color: #DCFCE7; color: #166534; border: 1px solid #A7F3D0;}
        .status-menunggu { background-color: #FEF9C3; color: #854D0E; border: 1px solid #FDE68A;}
        .status-diterima { background-color: #E0E7FF; color: #3730A3; border: 1px solid #C7D2FE;}
        .status-ditolak { background-color: #FEE2E2; color: #991B1B; border: 1px solid #FECACA;}
    </style>
</head>
<body class="bg-gray-50">

<x-public-header-nav />

<!-- Main Content -->
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Riwayat Kegiatan Saya</h1>
            <p class="text-gray-600">Daftar partisipasi lomba dan prestasi yang telah Anda raih.</p>
        </div>
        
        <!-- History List Container -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Table Header -->
            <div class="hidden md:grid grid-cols-12 bg-gray-50 px-6 py-3 border-b border-gray-200 text-sm">
                <div class="col-span-5 font-semibold text-gray-600">Nama Kegiatan</div>
                <div class="col-span-2 font-semibold text-gray-600">Tanggal</div>
                <div class="col-span-2 font-semibold text-gray-600">Status</div>
                <div class="col-span-3 font-semibold text-gray-600">Aksi</div>
            </div>
            
            <!-- Cangkang untuk diisi JavaScript -->
            <div id="history-list-container">
                <!-- Loading State -->
                <div id="loading-state" class="p-10 text-center">
                    <i class="fas fa-spinner fa-spin fa-2x text-blue-500"></i>
                    <p class="mt-2 text-gray-500">Memuat riwayat...</p>
                </div>
            </div>
        </div>
        
        <!-- Pagination Container -->
        <div id="pagination-container" class="mt-8"></div>
    </div>
</div>

<!-- Template untuk setiap item riwayat -->
<template id="history-item-template">
    <div class="history-card grid grid-cols-1 md:grid-cols-12 gap-4 p-6 border-b border-gray-200 hover:bg-gray-50/50 transition-colors duration-200">
        <div class="md:col-span-5 flex items-start space-x-4">
            <div class="item-icon w-16 h-16 rounded-lg flex items-center justify-center text-xl"></div>
            <div>
                <p class="item-type text-xs font-semibold uppercase tracking-wider"></p>
                <h3 class="item-name font-bold text-gray-800"></h3>
                <p class="item-kategori text-gray-500 text-sm mt-1"></p>
            </div>
        </div>
        <div class="md:col-span-2 flex flex-col justify-center">
            <span class="text-gray-600 text-sm md:hidden">Tanggal</span>
            <span class="item-tanggal text-gray-800"></span>
        </div>
        <div class="md:col-span-2 flex flex-col justify-center">
            <span class="text-gray-600 text-sm md:hidden">Status</span>
            <span class="item-status-badge status-badge"></span>
        </div>
        <div class="item-actions md:col-span-3 flex items-center space-x-4"></div>
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
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('history-list-container');
    const loadingState = document.getElementById('loading-state');
    const paginationContainer = document.getElementById('pagination-container');
    const template = document.getElementById('history-item-template');

    const formatDate = (dateString) => {
        if (!dateString) return 'N/A';
        return new Date(dateString).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
    };

    const fetchRiwayat = async (url = '/api/riwayat') => {
        loadingState.style.display = 'block';
        container.innerHTML = ''; 
        container.appendChild(loadingState);

        try {
            const response = await axios.get(url, { headers: { 'Accept': 'application/json' } });
            renderItems(response.data.data);
            renderPagination(response.data);
        } catch (error) {
            console.error('Gagal mengambil riwayat:', error);
            container.innerHTML = `<div class="p-6 text-center text-red-500">Gagal memuat data. Silakan coba lagi.</div>`;
        } finally {
            loadingState.style.display = 'none';
        }
    };

    const renderItems = (items) => {
        container.innerHTML = '';
        if (items.length === 0) {
            container.innerHTML = `<div class="p-6 text-center text-gray-500">Anda belum memiliki riwayat kegiatan.</div>`;
            return;
        }

        items.forEach(item => {
            const card = template.content.cloneNode(true);
            
            card.querySelector('.item-name').textContent = item.nama;
            card.querySelector('.item-type').textContent = item.type;
            card.querySelector('.item-kategori').textContent = `Kategori: ${item.kategori}`;
            card.querySelector('.item-tanggal').textContent = formatDate(item.tanggal);
            
            const statusBadge = card.querySelector('.item-status-badge');
            statusBadge.textContent = item.status_text;

            const itemIcon = card.querySelector('.item-icon');
            const actionsContainer = card.querySelector('.item-actions');

            // --- PERBAIKAN: Logika rendering yang lebih jelas ---
            if (item.type.includes('Prestasi')) {
                itemIcon.innerHTML = `<i class="fas fa-medal text-yellow-500"></i>`;
                itemIcon.className += ' bg-yellow-100';
                
                if (item.status_raw === 'disetujui') statusBadge.classList.add('status-prestasi');
                else if (item.status_raw === 'menunggu') statusBadge.classList.add('status-menunggu');
                else if (item.status_raw === 'ditolak') statusBadge.classList.add('status-ditolak');

                if (item.sertifikat_path) {
                    actionsContainer.innerHTML = `<a href="{{ asset('storage') }}/${item.sertifikat_path}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm font-medium"><i class="fas fa-certificate mr-1"></i> Lihat Sertifikat</a>`;
                }
            } else { // Partisipasi Lomba
                itemIcon.innerHTML = `<i class="fas fa-flag-checkered text-indigo-500"></i>`;
                itemIcon.className += ' bg-indigo-100';
                
                if (item.status_raw === 'menunggu') statusBadge.classList.add('status-menunggu');
                else if (item.status_raw === 'diterima') statusBadge.classList.add('status-diterima');
                else if (item.status_raw === 'ditolak') statusBadge.classList.add('status-ditolak');

                if (item.lomba_id) {
                     actionsContainer.innerHTML = `<a href="{{ url('/lomba') }}/${item.lomba_id}" class="text-blue-600 hover:text-blue-800 text-sm font-medium"><i class="fas fa-eye mr-1"></i> Detail Lomba</a>`;
                } else {
                    actionsContainer.innerHTML = `<span class="text-gray-400 text-sm">Lomba tidak tersedia</span>`;
                }
            }

            container.appendChild(card);
        });
    };

    const renderPagination = (data) => {
        paginationContainer.innerHTML = '';
        if (data.total <= data.per_page) return;

        const linksHtml = data.links.map(link => {
            const isActive = link.active;
            const isDisabled = !link.url;
            let classes = 'px-4 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 text-sm rounded-md';
            if (isActive) classes = 'px-4 py-2 border border-blue-500 bg-blue-500 text-white text-sm rounded-md';
            if (isDisabled) classes += ' opacity-50 cursor-not-allowed';
            
            return `<button data-url="${link.url}" class="${classes}" ${isDisabled ? 'disabled' : ''}>${link.label.replace('« Previous', '<i class="fas fa-chevron-left"></i>').replace('Next »', '<i class="fas fa-chevron-right"></i>')}</button>`;
        }).join('');

        paginationContainer.innerHTML = `
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-600">Menampilkan ${data.from} - ${data.to} dari ${data.total} hasil</div>
                <div class="flex space-x-1">${linksHtml}</div>
            </div>
        `;
        
        paginationContainer.querySelectorAll('button[data-url]').forEach(button => {
            if (button.dataset.url !== 'null') {
                button.addEventListener('click', () => fetchRiwayat(button.dataset.url));
            }
        });
    };
    
    // Initial fetch
    fetchRiwayat();
});
</script>

</body>
</html>