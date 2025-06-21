<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Admin Prodi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('admin.nav-adminprodi')

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <div class="container mx-auto px-4 py-8">

                <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Admin Program Studi</h1>

                <!-- Bagian Statistik / KPI -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Card Lomba Aktif -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-center">
                            <div class="bg-blue-500 text-white p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Lomba Aktif</p>
                                <p id="kpi-lomba-aktif" class="text-2xl font-bold text-gray-900">...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card Total Peserta -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-center">
                            <div class="bg-green-500 text-white p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Peserta</p>
                                <p id="kpi-total-peserta" class="text-2xl font-bold text-gray-900">...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card Dokumen Tertunda -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-center">
                            <div class="bg-yellow-500 text-white p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Dokumen Tertunda</p>
                                <p id="kpi-dokumen-tertunda" class="text-2xl font-bold text-gray-900">...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bagian Tabel Daftar Lomba -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800">Daftar Lomba Terbaru</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lomba</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Berakhir</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody id="lomba-table-body" class="bg-white divide-y divide-gray-200">
                                <tr><td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Memuat data...</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="pagination-links" class="p-4 border-t"></div>
                </div>
            </div>
        </main>
    </div>

    <!-- Script tetap sama -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // Script JS tidak perlu diubah
        document.addEventListener('DOMContentLoaded', function () {
            const API_URL = '/dashboard/admin-prodi-data';
            async function fetchDashboardData(url = API_URL) {
                const tableBody = document.getElementById('lomba-table-body');
                tableBody.innerHTML = `<tr><td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Memuat data...</td></tr>`;
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
                    let errorMessage = "Terjadi kesalahan saat memuat data. Periksa koneksi atau URL API.";
                    if (error.response && (error.response.status === 401 || error.response.status === 403)) {
                        errorMessage = "Otentikasi Gagal. Anda tidak memiliki izin untuk mengakses data ini.";
                    }
                    tableBody.innerHTML = `<tr><td colspan="4" class="px-6 py-4 text-center text-sm text-red-500">${errorMessage}</td></tr>`;
                }
            }
            function updateKpiCards(stats) {
                document.getElementById('kpi-lomba-aktif').textContent = stats.lomba_aktif;
                document.getElementById('kpi-total-peserta').textContent = stats.total_peserta;
                document.getElementById('kpi-dokumen-tertunda').textContent = stats.dokumen_tertunda;
            }
            function updateLombaTable(lombaData) {
                const tableBody = document.getElementById('lomba-table-body');
                tableBody.innerHTML = '';
                if (!lombaData || lombaData.data.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data lomba untuk ditampilkan.</td></tr>`;
                    return;
                }
                lombaData.data.forEach((lomba, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${lombaData.from + index}</td><td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${lomba.nama_lomba}</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${formatDate(lomba.tanggal_selesai_lomba)}</td><td class="px-6 py-4 whitespace-nowrap text-sm">${getStatusBadge(lomba.status)}</td>`;
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
                    let classes = 'px-3 py-1 mx-1 border rounded text-sm cursor-pointer ';
                    if (link.active) { classes += 'bg-blue-500 text-white';
                    } else if (!link.url) { classes += 'bg-gray-100 text-gray-400 cursor-not-allowed';
                    } else { classes += 'bg-white text-gray-700 hover:bg-gray-100'; }
                    linkElement.className = classes;
                    if (link.url) {
                        linkElement.addEventListener('click', function (e) {
                            e.preventDefault();
                            fetchDashboardData(link.url);
                        });
                    }
                    paginationContainer.appendChild(linkElement);
                });
            }
            function formatDate(dateString) { if (!dateString) return '-'; const options = { day: 'numeric', month: 'long', year: 'numeric' }; return new Date(dateString).toLocaleDateString('id-ID', options); }
            function getStatusBadge(status) {
                const statuses = { 'disetujui': 'bg-blue-100 text-blue-800', 'berlangsung': 'bg-green-100 text-green-800', 'selesai': 'bg-gray-100 text-gray-800', 'belum disetujui': 'bg-yellow-100 text-yellow-800' };
                const statusText = (status || 'belum disetujui').replace(/_/g, ' ');
                const statusClass = statuses[statusText] || statuses['belum disetujui'];
                return `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">${statusText.charAt(0).toUpperCase() + statusText.slice(1)}</span>`;
            }
            fetchDashboardData();
        });
    </script>
</body>
</html>