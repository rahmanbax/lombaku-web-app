<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Lomba - Admin Prodi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <!-- Menambahkan Google Font 'Poppins' -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-50">

    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('admin.nav-adminprodi')

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <div class="p-6 md:p-10">
                <h1 class="text-3xl font-bold text-slate-800 mb-8">Manajemen Data Lomba</h1>

                <!-- Filter dan Pencarian (Desain Ulang) -->
                <div class="bg-white p-6 rounded-xl shadow-sm mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="search-input" class="text-sm font-medium text-slate-600">Cari Lomba</label>
                            <input type="text" id="search-input" placeholder="Nama lomba atau penyelenggara..." class="mt-2 block w-full px-4 py-2 bg-white border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="status-filter" class="text-sm font-medium text-slate-600">Status</label>
                            <select id="status-filter" class="mt-2 block w-full px-3 py-2 bg-white border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Semua Status</option>
                                <option value="belum disetujui">Belum Disetujui</option>
                                <option value="ditolak">Ditolak</option>
                                <option value="disetujui">Disetujui</option>
                                <option value="berlangsung">Berlangsung</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                         <div>
                            <label for="reset" class="text-sm font-medium text-slate-700 invisible">Aksi</label>
                            <button id="reset-filter-btn" class="mt-2 w-full bg-slate-200 text-slate-700 font-semibold py-2 px-4 rounded-lg hover:bg-slate-300 transition">Reset Filter</button>
                        </div>
                    </div>
                </div>

                <!-- Tabel Daftar Lomba (Desain Ulang) -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Lomba</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Penyelenggara</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Periode</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                                    <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody id="lomba-table-body" class="bg-white divide-y divide-slate-200">
                                <!-- Data akan dimuat oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                    <div id="pagination-links" class="p-6 border-t border-slate-200 flex justify-center">
                        <!-- Paginasi akan dimuat oleh JavaScript -->
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const API_URL = '/api/admin-prodi/lombas'; 
            const tableBody = document.getElementById('lomba-table-body');
            const paginationContainer = document.getElementById('pagination-links');
            const searchInput = document.getElementById('search-input');
            const statusFilter = document.getElementById('status-filter');
            const resetBtn = document.getElementById('reset-filter-btn');
            let searchTimeout;

            async function fetchLombas(url = API_URL) {
                tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-10 text-center text-sm text-slate-500">Memuat data lomba...</td></tr>`;
                try {
                    const config = {
                        params: {
                            search: searchInput.value,
                            status: statusFilter.value
                        }
                    };
                    const pageUrl = new URL(url, window.location.origin);
                    if (pageUrl.searchParams.has('page')) {
                        config.params.page = pageUrl.searchParams.get('page');
                    }
                    const response = await axios.get(API_URL, config);
                    renderTable(response.data.data);
                    renderPagination(response.data);
                } catch (error) {
                    console.error('Gagal mengambil data lomba:', error);
                    tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-10 text-center text-sm text-red-500">Gagal memuat data. Silakan coba lagi.</td></tr>`;
                }
            }
            
            function renderTable(lombas) {
                tableBody.innerHTML = '';
                if (!lombas || lombas.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-10 text-center text-sm text-slate-500">Tidak ada data lomba yang ditemukan.</td></tr>`;
                    return;
                }
                lombas.forEach(lomba => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-slate-800">${lomba.nama_lomba}</div>
                            <div class="text-sm text-slate-500">${lomba.tingkat.charAt(0).toUpperCase() + lomba.tingkat.slice(1)}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">${lomba.penyelenggara || '-'}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                            ${formatDate(lomba.tanggal_mulai_lomba)} - ${formatDate(lomba.tanggal_selesai_lomba)}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">${getStatusBadge(lomba.status)}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="/adminprodi/lomba/${lomba.id_lomba}" class="text-blue-600 hover:text-blue-800">Detail</a>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            }

            function renderPagination(paginationData) {
                paginationContainer.innerHTML = '';
                if (!paginationData || !paginationData.links || paginationData.links.length <= 3) return;
                paginationData.links.forEach(link => {
                    const linkElement = document.createElement('a');
                    linkElement.href = link.url || '#';
                    linkElement.innerHTML = link.label;
                    let classes = 'pagination-btn px-4 py-2 mx-1 text-sm rounded-md transition ';
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
                            fetchLombas(link.url);
                        });
                    }
                    paginationContainer.appendChild(linkElement);
                });
            }

            function getStatusBadge(status) {
                const statuses = {
                    'disetujui': 'bg-blue-100 text-blue-800',
                    'berlangsung': 'bg-green-100 text-green-800',
                    'selesai': 'bg-slate-100 text-slate-800',
                    'ditolak': 'bg-red-100 text-red-800',
                    'belum disetujui': 'bg-amber-100 text-amber-800'
                };
                const statusText = (status || '').replace(/_/g, ' ');
                return `<span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${statuses[status] || 'bg-slate-100 text-slate-800'}">${statusText.charAt(0).toUpperCase() + statusText.slice(1)}</span>`;
            }

            function formatDate(dateString) { 
                if (!dateString) return '-'; 
                return new Date(dateString).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }); 
            }
            
            searchInput.addEventListener('keyup', () => { clearTimeout(searchTimeout); searchTimeout = setTimeout(() => fetchLombas(), 500); });
            statusFilter.addEventListener('change', () => fetchLombas());
            resetBtn.addEventListener('click', () => { searchInput.value = ''; statusFilter.value = ''; fetchLombas(); });
            
            fetchLombas();
        });
    </script>
</body>
</html>