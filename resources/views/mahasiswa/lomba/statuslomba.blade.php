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
        .filter-btn { padding: 0.5rem 1.25rem; border-radius: 9999px; font-weight: 600; cursor: pointer; transition: all 0.2s ease-in-out; border: 1px solid transparent; }
        .filter-btn.active { background-color: #3b82f6; color: white; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1); }
        .pagination-link { padding: 0.5rem 1rem; border: 1px solid #ddd; color: #333; text-decoration: none; }
    </style>
</head>
<body class="bg-gray-50">

<x-public-header-nav />
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Riwayat Kegiatan Saya</h1>
            <p class="text-gray-600">Daftar partisipasi lomba dan prestasi yang telah Anda raih.</p>
        </div>
        <div id="filter-container" class="mb-6 flex justify-center md:justify-start items-center space-x-2 bg-white p-2 rounded-full shadow-sm max-w-max">
            <button class="filter-btn active" data-filter="all"><i class="fas fa-list-ul mr-2"></i>Semua</button>
            <button class="filter-btn" data-filter="lomba"><i class="fas fa-flag-checkered mr-2"></i>Partisipasi Lomba</button>
            <button class="filter-btn" data-filter="prestasi"><i class="fas fa-medal mr-2"></i>Prestasi</button>
        </div>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="hidden md:grid grid-cols-12 bg-gray-50 px-6 py-3 border-b text-sm">
                <div class="col-span-5 font-semibold text-gray-600">Nama Kegiatan</div>
                <div class="col-span-2 font-semibold text-gray-600">Tanggal</div>
                <div class="col-span-2 font-semibold text-gray-600">Status</div>
                <div class="col-span-3 font-semibold text-gray-600">Aksi</div>
            </div>
            <div id="history-list-container">
                <div id="loading-state" class="p-10 text-center"><i class="fas fa-spinner fa-spin fa-2x text-blue-500"></i><p class="mt-2 text-gray-500">Memuat riwayat...</p></div>
            </div>
        </div>
        <div id="pagination-container" class="mt-8 flex justify-center"></div>
    </div>
</div>

<template id="history-item-template">
    <div class="history-card grid grid-cols-1 md:grid-cols-12 gap-4 p-6 border-b hover:bg-gray-50/50">
        <div class="md:col-span-5 flex items-start space-x-4">
            <div class="item-icon w-16 h-16 rounded-lg flex items-center justify-center text-xl shrink-0"></div>
            <div class="flex-grow">
                <p class="item-type text-xs font-semibold uppercase tracking-wider"></p>
                <h3 class="item-name font-bold text-gray-800"></h3>
                <p class="item-kategori text-gray-500 text-sm mt-1"></p>
            </div>
        </div>
        <div class="md:col-span-2 flex flex-col justify-center"><span class="md:hidden text-gray-600 text-sm">Tanggal</span><span class="item-tanggal text-gray-800"></span></div>
        <div class="md:col-span-2 flex flex-col justify-center"><span class="md:hidden text-gray-600 text-sm">Status</span><span class="item-status-badge status-badge"></span></div>
        <div class="item-actions md:col-span-3 flex items-center space-x-4"></div>
    </div>
</template>

<x-footer/>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('history-list-container');
    const loadingState = document.getElementById('loading-state');
    const paginationContainer = document.getElementById('pagination-container');
    const template = document.getElementById('history-item-template');
    let currentFilter = 'all'; 
    const filterContainer = document.getElementById('filter-container');

    const formatDate = (dateString) => dateString ? new Date(dateString).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) : 'N/A';
    
    const fetchRiwayat = async (url = '/api/riwayat') => {
        loadingState.style.display = 'block'; container.innerHTML = ''; container.appendChild(loadingState);
        try {
            const response = await axios.get(url, { params: { filter: currentFilter === 'all' ? null : currentFilter }});
            renderItems(response.data.data);
            renderPagination(response.data);
        } catch (error) {
            console.error('Gagal mengambil riwayat:', error);
            container.innerHTML = `<div class="p-6 text-center text-red-500">Gagal memuat data.</div>`;
        } finally {
            loadingState.style.display = 'none';
        }
    };

    const renderItems = (items) => {
        container.innerHTML = '';
        if (items.length === 0) {
            let message = "Anda belum memiliki riwayat kegiatan.";
            if(currentFilter === 'lomba') message = "Anda belum pernah berpartisipasi dalam lomba.";
            else if (currentFilter === 'prestasi') message = "Anda belum memiliki riwayat prestasi.";
            container.innerHTML = `<div class="p-12 text-center text-gray-500"><i class="fas fa-box-open fa-3x mb-4 text-gray-300"></i><h3 class="text-xl font-semibold">Belum Ada Riwayat</h3><p>${message}</p></div>`;
            return;
        }

        items.forEach(item => {
            const card = template.content.cloneNode(true);
            const itemIcon = card.querySelector('.item-icon');
            const actionsContainer = card.querySelector('.item-actions');
            
            card.querySelector('.item-name').textContent = item.nama;
            card.querySelector('.item-type').textContent = item.type;
            card.querySelector('.item-kategori').textContent = `Kategori: ${item.kategori}`;
            card.querySelector('.item-tanggal').textContent = formatDate(item.tanggal);
            const statusBadge = card.querySelector('.item-status-badge');
            statusBadge.textContent = item.status_text;
            if (item.status_class) statusBadge.classList.add(item.status_class);

            actionsContainer.innerHTML = '';

            // [PERBAIKAN LOGIKA UTAMA]
            // Prioritas 1: Tampilkan link "Lihat Sertifikat"
            if (item.sertifikat_path) {
                itemIcon.innerHTML = `<i class="fas fa-medal text-yellow-500"></i>`;
                itemIcon.className += ' bg-yellow-100';
                const sertifikatLink = document.createElement('a');
                sertifikatLink.href = `/storage/${item.sertifikat_path}`;
                sertifikatLink.target = '_blank';
                sertifikatLink.className = 'text-blue-600 hover:text-blue-800 text-sm font-medium';
                sertifikatLink.innerHTML = `<i class="fas fa-certificate mr-1"></i> Lihat Sertifikat`;
                actionsContainer.appendChild(sertifikatLink);
            }

            // Prioritas 2 (Tambahan): Tampilkan tombol "Ajukan Rekognisi" JIKA URL-nya ada
            if (item.rekognisi_url) {
                const rekognisiBtn = document.createElement('a'); // Ini adalah link
                rekognisiBtn.href = item.rekognisi_url; // Gunakan URL dari backend
                rekognisiBtn.className = 'bg-orange-100 text-orange-800 hover:bg-orange-200 text-sm font-semibold py-1 px-3 rounded-full';
                rekognisiBtn.innerHTML = `<i class="fas fa-file-import mr-1"></i> Ajukan Rekognisi`;
                actionsContainer.appendChild(rekognisiBtn);
            }
            
            // Fallback jika tidak ada aksi sama sekali
            if (actionsContainer.innerHTML.trim() === '') {
                itemIcon.innerHTML = `<i class="fas fa-flag-checkered text-indigo-500"></i>`;
                itemIcon.className += ' bg-indigo-100';
                actionsContainer.innerHTML = `<span class="text-gray-400 text-sm">Tidak ada aksi</span>`;
            }

            container.appendChild(card);
        });
    };
    
    const renderPagination = (data) => {
        paginationContainer.innerHTML = ''; if (data.last_page <= 1) return;
        const nav = document.createElement('nav'); nav.className = 'flex items-center space-x-2';
        data.links.forEach(link => {
            if (!link.url) return;
            const a = document.createElement('a'); a.href = '#'; a.innerHTML = link.label; a.className = 'pagination-link';
            if (link.url === null) a.classList.add('disabled'); else a.addEventListener('click', (e) => { e.preventDefault(); fetchRiwayat(link.url); });
            if (link.active) a.classList.add('active');
            nav.appendChild(a);
        });
        paginationContainer.appendChild(nav);
    };
    filterContainer.addEventListener('click', (e) => {
        const targetButton = e.target.closest('.filter-btn');
        if (!targetButton || targetButton.classList.contains('active')) return;
        filterContainer.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
        targetButton.classList.add('active');
        currentFilter = targetButton.dataset.filter;
        fetchRiwayat();
    });
    
    fetchRiwayat();
});
</script>
</body>
</html>