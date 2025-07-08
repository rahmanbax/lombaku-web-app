<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Admin Prodi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Perubahan: Menambahkan Google Font 'Poppins' agar sesuai tema -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Perubahan: Menerapkan font Poppins ke seluruh halaman */
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<!-- Perubahan: Menggunakan warna latar yang lebih terang (slate-50) -->
<body class="bg-slate-50">

    <div class="flex h-screen">
        <!-- Sidebar: Tetap menggunakan komponen yang sudah ada -->
        @include('admin.nav-adminprodi')

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Perubahan: Menambah padding agar lebih lega -->
            <div class="p-6 md:p-10">

                <h1 class="text-3xl font-bold text-slate-800 mb-8">Dashboard Admin Program Studi</h1>

                <!-- Bagian Statistik / KPI (Desain Ulang) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                    
                    <!-- Card Lomba Aktif -->
                    <div class="bg-white p-6 rounded-xl shadow-sm flex items-start gap-4">
                        <div class="flex-shrink-0 text-blue-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-500">Lomba Aktif</p>
                            <p id="kpi-lomba-aktif" class="text-3xl font-bold text-slate-700 mt-1">...</p>
                        </div>
                    </div>

                    <!-- Card Total Peserta -->
                    <div class="bg-white p-6 rounded-xl shadow-sm flex items-start gap-4">
                        <div class="flex-shrink-0 text-green-500">
                             <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-500">Total Peserta</p>
                            <p id="kpi-total-peserta" class="text-2xl font-bold text-slate-700 mt-1">...</p>
                        </div>
                    </div>

                    <!-- Card Dokumen Tertunda -->
                    <div class="bg-white p-6 rounded-xl shadow-sm flex items-start gap-4">
                        <div class="flex-shrink-0 text-amber-500">
                             <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-500">Dokumen Tertunda</p>
                            <p id="kpi-dokumen-tertunda" class="text-2xl font-bold text-slate-700 mt-1">...</p>
                        </div>
                    </div>
                </div>

                <!-- Bagian Tabel Daftar Lomba (Desain Ulang) -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-200">
                        <h2 class="text-xl font-semibold text-slate-800">Lomba Terbaru yang Perlu Diproses</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Lomba</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody id="lomba-table-body" class="bg-white divide-y divide-slate-200">
                                <!-- Data akan dimuat oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                    <div id="pagination-links" class="p-4 border-t border-slate-200"></div>
                </div>
            </div>
        </main>
    </div>

    <!-- Script Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <!-- Perubahan: Script JavaScript disesuaikan dengan desain baru -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const API_URL = '/dashboard/admin-prodi-data';

            async function fetchDashboardData(url = API_URL) {
                const tableBody = document.getElementById('lomba-table-body');
                tableBody.innerHTML = `<tr><td colspan="3" class="px-6 py-10 text-center text-sm text-slate-500">Memuat data lomba...</td></tr>`;
                try {
                    const response = await axios.get(url, { withCredentials: true });
                    if (response.data.success) {
                        const data = response.data.data;
                        updateKpiCards(data.stats);
                        updateLombaTable(data.daftar_lomba);
                        updatePagination(data.daftar_lomba);
                    } else {
                        throw new Error(response.data.message || 'Gagal mengambil data.');
                    }
                } catch (error) {
                    console.error("Error fetching dashboard data:", error);
                    let errorMessage = "Terjadi kesalahan saat memuat data.";
                    if (error.response?.status === 401 || error.response?.status === 403) {
                        errorMessage = "Otentikasi Gagal. Silakan login kembali.";
                    }
                    tableBody.innerHTML = `<tr><td colspan="3" class="px-6 py-10 text-center text-sm text-red-500">${errorMessage}</td></tr>`;
                }
            }

            function updateKpiCards(stats) {
                document.getElementById('kpi-lomba-aktif').textContent = stats.lomba_aktif || '0';
                document.getElementById('kpi-total-peserta').textContent = stats.total_peserta || '0';
                document.getElementById('kpi-dokumen-tertunda').textContent = stats.dokumen_tertunda || '0';
            }

            function updateLombaTable(lombaData) {
                const tableBody = document.getElementById('lomba-table-body');
                tableBody.innerHTML = '';
                if (!lombaData || lombaData.data.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="3" class="px-6 py-10 text-center text-sm text-slate-500">Tidak ada lomba terbaru.</td></tr>`;
                    return;
                }
                lombaData.data.forEach((lomba) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-slate-800">${lomba.nama_lomba}</div>
                            <div class="text-sm text-slate-500">Batas Akhir: ${formatDate(lomba.tanggal_selesai_lomba)}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">${getStatusBadge(lomba.status)}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="/adminprodi/lomba/${lomba.id_lomba}" class="text-blue-600 hover:text-blue-800">Lihat Detail</a>
                        </td>
                    `;
                    tableBody.appendChild(row);
});
            }

            function updatePagination(paginationData) {
                const paginationContainer = document.getElementById('pagination-links');
                paginationContainer.innerHTML = '';
                if (!paginationData || !paginationData.links || paginationData.links.length <= 3) return;
                paginationData.links.forEach(link => {
                    const linkElement = document.createElement('a');
                    linkElement.href = link.url || '#';
                    linkElement.innerHTML = link.label;
                    let classes = 'px-4 py-2 mx-1 text-sm rounded-md transition ';
                    if (link.active) {
                        classes += 'bg-blue-600 text-white shadow-sm';
                    } else if (!link.url) {
                        classes += 'bg-slate-100 text-slate-400 cursor-not-allowed';
                    } else {
                        classes += 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200';
                    }
                    linkElement.className = classes;
                    if (link.url) {
                        linkElement.addEventListener('click', function(e) {
                            e.preventDefault();
                            fetchDashboardData(link.url);
                        });
                    }
                    paginationContainer.appendChild(linkElement);
                });
            }

            function formatDate(dateString) {
                if (!dateString) return '-';
                const options = { day: 'numeric', month: 'long', year: 'numeric' };
                return new Date(dateString).toLocaleDateString('id-ID', options);
            }

            function getStatusBadge(status) {
                const statuses = {
                    'disetujui': 'bg-blue-100 text-blue-800',
                    'berlangsung': 'bg-green-100 text-green-800',
                    'selesai': 'bg-slate-100 text-slate-800',
                    'ditolak': 'bg-red-100 text-red-800',
                    'belum disetujui': 'bg-amber-100 text-amber-800'
                };
                const statusText = (status || 'belum disetujui').replace(/_/g, ' ');
                return `<span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${statuses[status] || statuses['belum disetujui']}">${statusText.charAt(0).toUpperCase() + statusText.slice(1)}</span>`;
            }
            
            fetchDashboardData();
        });
    </script>
</body>
</html>