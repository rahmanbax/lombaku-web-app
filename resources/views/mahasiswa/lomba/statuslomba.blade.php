<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Kegiatan - Lombaku</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background-color: #f9fafb; }
        .status-badge { display: inline-block; font-size: 0.75rem; padding: 0.25rem 0.75rem; border-radius: 9999px; font-weight: 500;}
        .status-prestasi { background-color: #DCFCE7; color: #166534; border: 1px solid #A7F3D0;}
        .status-menunggu { background-color: #FEF9C3; color: #854D0E; border: 1px solid #FDE68A;}
        .status-diterima { background-color: #E0E7FF; color: #3730A3; border: 1px solid #C7D2FE;}
        .status-ditolak { background-color: #FEE2E2; color: #991B1B; border: 1px solid #FECACA;}
        .status-netral { background-color: #F3F4F6; color: #374151; border: 1px solid #E5E7EB;}
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
                <div class="col-span-4 font-semibold text-gray-600">Nama Kegiatan</div>
                <div class="col-span-2 font-semibold text-gray-600">Tanggal</div>
                <div class="col-span-2 font-semibold text-gray-600">Status</div>
                <div class="col-span-2 font-semibold text-gray-600">Status Rekognisi</div>
                <div class="col-span-2 font-semibold text-gray-600">Aksi</div>
            </div>
            <div id="history-list-container">
                <div id="loading-state" class="p-10 text-center"><i class="fas fa-spinner fa-spin fa-2x text-blue-500"></i><p class="mt-2 text-gray-500">Memuat riwayat...</p></div>
            </div>
        </div>
        <div id="pagination-container" class="mt-8 flex justify-center"></div>
    </div>
</div>

<template id="history-item-template">
    <div class="history-card grid grid-cols-1 md:grid-cols-12 gap-4 p-6 border-b hover:bg-gray-50/50 items-center">
        <div class="md:col-span-4 flex items-start space-x-4">
            <div class="item-icon w-16 h-16 rounded-lg flex items-center justify-center text-xl shrink-0"></div>
            <div class="flex-grow">
                <p class="item-type text-xs font-semibold uppercase tracking-wider"></p>
                <h3 class="item-name font-bold text-gray-800"></h3>
                <p class="item-tingkat text-gray-500 text-sm mt-1"></p>
                <p class="item-team-name font-semibold text-gray-700 text-sm mt-1 hidden"></p>
                <p class="item-team-members text-gray-500 text-xs mt-1 hidden"></p>
            </div>
        </div>
        <div class="md:col-span-2 flex flex-col justify-center"><span class="md:hidden text-gray-600 text-sm">Tanggal</span><span class="item-tanggal text-gray-800"></span></div>
        <div class="md:col-span-2 flex flex-col justify-center"><span class="md:hidden text-gray-600 text-sm">Status</span><span class="item-status-badge status-badge"></span></div>
        <div class="md:col-span-2 flex flex-col justify-center">
            <span class="md:hidden text-gray-600 text-sm">Status Rekognisi</span>
            <span class="item-rekognisi-badge"></span>
        </div>
        <div class="item-actions md:col-span-2 flex items-center space-x-4"></div>
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
document.addEventListener('DOMContentLoaded', () => {
    // Memperbaiki header CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';
    const axiosInstance = axios.create({
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        }
    });

    const container = document.getElementById('history-list-container');
    const loadingState = document.getElementById('loading-state');
    const paginationContainer = document.getElementById('pagination-container');
    const template = document.getElementById('history-item-template');
    let currentFilter = 'all';
    const filterContainer = document.getElementById('filter-container');

    const formatDate = (dateString) => dateString ? new Date(dateString).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) : 'N/A';
    
    // Fungsi untuk mengubah URL file menjadi objek File
    async function urlToFile(url, filename, mimeType){
        try {
            const res = await fetch(url);
            const buf = await res.arrayBuffer();
            return new File([buf], filename, {type:mimeType});
        } catch (error) {
            console.error('Error fetching file from URL:', error);
            throw new Error('Gagal mengambil file sertifikat untuk rekognisi.');
        }
    }

    const ajukanRekognisi = async (rekognisiData, buttonElement, cardElement) => {
        buttonElement.disabled = true;
        buttonElement.innerHTML = `<i class="fas fa-spinner fa-spin mr-1"></i> Mengajukan...`;

        try {
            const formData = new FormData();
            
            // --- [PERBAIKAN UTAMA DI SINI] ---
            // Tambahkan semua data dari rekognisiData ke formData
            // Kecuali 'existing_sertifikat_url' karena akan diubah jadi objek File 'sertifikat'
            for (const key in rekognisiData) {
                if (key !== 'existing_sertifikat_url' && rekognisiData[key] !== null) { 
                    if (Array.isArray(rekognisiData[key])) {
                        // Untuk array seperti member_ids, tambahkan setiap elemen secara terpisah
                        rekognisiData[key].forEach(val => formData.append(`${key}[]`, val));
                    } else {
                        formData.append(key, rekognisiData[key]);
                    }
                }
            }

            // Mengambil sertifikat dari URL dan mengubahnya menjadi objek File
            // Kemudian menambahkannya ke FormData dengan nama 'sertifikat'
            if (rekognisiData.existing_sertifikat_url) {
                const sertifikatUrl = rekognisiData.existing_sertifikat_url;
                // Ambil nama file dari URL
                const fileName = sertifikatUrl.substring(sertifikatUrl.lastIndexOf('/') + 1);
                // Coba tebak MIME type, atau buat lebih robust jika perlu
                const mimeType = fileName.endsWith('.pdf') ? 'application/pdf' : 'image/jpeg'; 
                const sertifikatFile = await urlToFile(sertifikatUrl, fileName, mimeType);
                formData.append('sertifikat', sertifikatFile);
            } else {
                // Jika tidak ada existing_sertifikat_url, controller akan menganggap 'sertifikat' tidak ada
                // Ini akan memicu validasi "required" jika tidak ada sertifikat baru yang diupload
                // Pastikan PrestasiController memiliki validasi 'sertifikat' => 'required|file'
                // dan tidak lagi bergantung pada 'required_without:existing_sertifikat_path'
            }
            // --- AKHIR PERBAIKAN ---

            // POST data sebagai multipart/form-data
            const response = await axiosInstance.post('/api/prestasi', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: response.data.message || 'Pengajuan rekognisi berhasil dikirim.', timer: 2000, showConfirmButton: false });
            
            const rekognisiBadge = cardElement.querySelector('.item-rekognisi-badge');
            rekognisiBadge.textContent = 'Menunggu Rekognisi';
            rekognisiBadge.className = 'item-rekognisi-badge status-badge status-menunggu';
            buttonElement.remove();

        } catch (error) {
            console.error('Gagal mengajukan rekognisi:', error);
            const errorMessage = error.response?.data?.message || 'Terjadi kesalahan. Silakan coba lagi.';
            Swal.fire({ icon: 'error', title: 'Oops...', text: errorMessage });
        } finally {
            buttonElement.disabled = false;
            buttonElement.innerHTML = `<i class="fas fa-file-import mr-1"></i> Ajukan`;
        }
    };
    
    const fetchRiwayat = async (url = '/api/riwayat') => {
        loadingState.style.display = 'block'; container.innerHTML = ''; container.appendChild(loadingState);
        try {
            const response = await axiosInstance.get(url, { params: { filter: currentFilter === 'all' ? null : currentFilter }});
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
            const cardClone = template.content.cloneNode(true);
            const card = cardClone.querySelector('.history-card');
            const itemIcon = card.querySelector('.item-icon');
            const actionsContainer = card.querySelector('.item-actions');
            
            card.querySelector('.item-name').textContent = item.nama;
            card.querySelector('.item-type').textContent = item.type;
            card.querySelector('.item-tingkat').textContent = `Tingkat: ${item.tingkat}`;
            card.querySelector('.item-tanggal').textContent = formatDate(item.tanggal);
            
            const statusBadge = card.querySelector('.item-status-badge');
            statusBadge.textContent = item.status_text;
            if (item.status_class) statusBadge.classList.add(item.status_class);

            const rekognisiBadge = card.querySelector('.item-rekognisi-badge');
            if (item.status_rekognisi) {
                rekognisiBadge.textContent = item.status_rekognisi;
                rekognisiBadge.className = 'item-rekognisi-badge';
                if (item.status_rekognisi_class) {
                    rekognisiBadge.classList.add('status-badge', item.status_rekognisi_class);
                }
            } else {
                rekognisiBadge.innerHTML = `<span class="text-gray-400">-</span>`;
            }

            const itemTeamName = card.querySelector('.item-team-name');
            const itemTeamMembers = card.querySelector('.item-team-members');

            if (item.team_info) {
                itemTeamName.textContent = `Tim: ${item.team_info.nama_tim}`;
                itemTeamMembers.textContent = `Anggota: ${item.team_info.members}`;
                itemTeamName.classList.remove('hidden');
                itemTeamMembers.classList.remove('hidden');
            } else {
                itemTeamName.classList.add('hidden');
                itemTeamMembers.classList.add('hidden');
            }

            actionsContainer.innerHTML = '';

            if (item.sertifikat_path) {
                itemIcon.innerHTML = `<i class="fas fa-medal text-yellow-500"></i>`;
                itemIcon.className += ' bg-yellow-100';
                const sertifikatLink = document.createElement('a');
                // URL ini harus cocok dengan cara file diakses di server Anda
                sertifikatLink.href = `/storage/${item.sertifikat_path}`; 
                sertifikatLink.target = '_blank';
                sertifikatLink.className = 'text-blue-600 hover:text-blue-800 text-sm font-medium';
                sertifikatLink.innerHTML = `<i class="fas fa-certificate mr-1"></i> Lihat`;
                actionsContainer.appendChild(sertifikatLink);
            }

            if (item.rekognisi_data) {
                const rekognisiBtn = document.createElement('button');
                rekognisiBtn.type = 'button';
                rekognisiBtn.className = 'bg-orange-100 text-orange-800 hover:bg-orange-200 text-sm font-semibold py-1 px-3 rounded-full transition-colors';
                rekognisiBtn.innerHTML = `<i class="fas fa-file-import mr-1"></i> Ajukan`;
                
                rekognisiBtn.dataset.rekognisiData = JSON.stringify(item.rekognisi_data);
                
                rekognisiBtn.addEventListener('click', () => {
                    const data = JSON.parse(rekognisiBtn.dataset.rekognisiData);
                    ajukanRekognisi(data, rekognisiBtn, card);
                });
                actionsContainer.appendChild(rekognisiBtn);
            }
            
            if (actionsContainer.innerHTML.trim() === '') {
                if(!item.sertifikat_path) { 
                    itemIcon.innerHTML = `<i class="fas fa-flag-checkered text-indigo-500"></i>`;
                    itemIcon.className += ' bg-indigo-100';
                }
                actionsContainer.innerHTML = `<span class="text-gray-400 text-sm italic">-</span>`;
            }
            container.appendChild(cardClone);
        });
    };
    
    const renderPagination = (data) => {
        paginationContainer.innerHTML = ''; 
        if (data.last_page <= 1) return;
        const nav = document.createElement('nav'); nav.className = 'flex items-center space-x-2';
        data.links.forEach(link => {
            if (!link.url) return;
            const a = document.createElement('a'); a.href = '#'; a.innerHTML = link.label; a.className = 'pagination-link';
            if (link.url === null) a.classList.add('disabled'); 
            else a.addEventListener('click', (e) => { e.preventDefault(); fetchRiwayat(link.url); });
            if (link.active) a.classList.add('active', 'bg-blue-500', 'text-white', 'border-blue-500');
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