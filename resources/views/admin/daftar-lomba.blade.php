<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Lomba - Admin Prodi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100">

    <div class="flex h-screen">
      <!-- Sidebar -->
      @include('admin.nav-adminprodi')

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <div class="container mx-auto px-6 py-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">Manajemen Data Lomba</h1>

                <!-- Filter dan Pencarian -->
                <div class="bg-white p-4 rounded-lg shadow-md mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="search" class="text-sm font-medium text-gray-700">Cari Lomba</label>
                            <input type="text" id="search-input" placeholder="Nama lomba atau penyelenggara..." class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="status-filter" class="text-sm font-medium text-gray-700">Status</label>
                            <select id="status-filter" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Semua Status</option>
                                <option value="belum disetujui">Belum Disetujui</option>
                                <option value="ditolak">Ditolak</option>
                                <option value="disetujui">Disetujui</option>
                                <option value="berlangsung">Berlangsung</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                         <div>
                            <label for="reset" class="text-sm font-medium text-gray-700 invisible">Reset</label>
                            <button id="reset-filter-btn" class="mt-1 w-full bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">Reset Filter</button>
                        </div>
                    </div>
                </div>

                <!-- Tabel Daftar Lomba -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Lomba</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penyelenggara</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="lomba-table-body" class="bg-white divide-y divide-gray-200">
                                <!-- Data akan dimuat oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                    <div id="pagination-links" class="p-4 border-t">
                        <!-- Paginasi akan dimuat oleh JavaScript -->
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Script JS tidak perlu diubah
        document.addEventListener('DOMContentLoaded', function() {
            const API_URL = '/api/admin-prodi/lombas'; 
            const tableBody = document.getElementById('lomba-table-body');
            const paginationContainer = document.getElementById('pagination-links');
            const searchInput = document.getElementById('search-input');
            const statusFilter = document.getElementById('status-filter');
            const resetBtn = document.getElementById('reset-filter-btn');
            let searchTimeout;

            async function fetchLombas(url = API_URL) {
                tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Memuat data...</td></tr>`;
                try {
                    const params = new URLSearchParams();
                    const search = searchInput.value;
                    const status = statusFilter.value;
                    if (search) params.append('search', search);
                    if (status) params.append('status', status);
                    const finalUrl = `${url}?${params.toString()}`;
                    const response = await axios.get(finalUrl);
                    renderTable(response.data.data);
                    renderPagination(response.data);
                } catch (error) {
                    console.error('Gagal mengambil data lomba:', error);
                    tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-red-500">Gagal memuat data. Silakan coba lagi.</td></tr>`;
                }
            }
            
            function renderTable(lombas) {
                tableBody.innerHTML = '';
                if (!lombas || lombas.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data yang ditemukan.</td></tr>`;
                    return;
                }
                lombas.forEach(lomba => {
                    const row = `
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">${lomba.nama_lomba}</div>
                                <div class="text-sm text-gray-500">${lomba.tingkat}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${lomba.penyelenggara}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                Mulai: ${formatDate(lomba.tanggal_mulai_lomba)} <br>
                                Selesai: ${formatDate(lomba.tanggal_selesai_lomba)}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">${getStatusBadge(lomba.status)}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="/adminprodi/lomba/${lomba.id_lomba}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                            </td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });
            }
            function renderPagination(paginationData) {
                paginationContainer.innerHTML = '';
                if (!paginationData || !paginationData.links || paginationData.links.length <= 3) return;
                paginationData.links.forEach(link => {
                    const url = new URL(link.url || window.location.href);
                    const search = searchInput.value;
                    const status = statusFilter.value;
                    if (search) url.searchParams.set('search', search);
                    if (status) url.searchParams.set('status', status);
                    const linkElement = document.createElement('button');
                    linkElement.innerHTML = link.label;
                    linkElement.disabled = !link.url;
                    linkElement.className = `px-3 py-1 mx-1 border rounded text-sm ${link.active ? 'bg-blue-500 text-white' : 'bg-white text-gray-700'} ${!link.url ? 'cursor-not-allowed text-gray-400' : 'hover:bg-gray-100'}`;
                    if (link.url) {
                        linkElement.addEventListener('click', (e) => {
                            e.preventDefault();
                            fetchLombas(url.href);
                        });
                    }
                    paginationContainer.appendChild(linkElement);
                });
            }
            function getStatusBadge(status) {
                const statuses = {
                    'disetujui': 'bg-blue-100 text-blue-800', 'berlangsung': 'bg-green-100 text-green-800',
                    'selesai': 'bg-gray-100 text-gray-800', 'belum disetujui': 'bg-yellow-100 text-yellow-800',
                    'ditolak': 'bg-red-100 text-red-800',
                };
                const statusText = (status || '').replace(/_/g, ' ');
                return `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statuses[status] || 'bg-gray-100 text-gray-800'}">${capitalizeFirstLetter(statusText)}</span>`;
            }
            function formatDate(dateString) { if (!dateString) return '-'; return new Date(dateString).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }); }
            function capitalizeFirstLetter(string) { return string.charAt(0).toUpperCase() + string.slice(1); }
            searchInput.addEventListener('keyup', () => { clearTimeout(searchTimeout); searchTimeout = setTimeout(() => fetchLombas(), 500); });
            statusFilter.addEventListener('change', () => fetchLombas());
            resetBtn.addEventListener('click', () => { searchInput.value = ''; statusFilter.value = ''; fetchLombas(); });
            fetchLombas();
        });
    </script>
</body>
</html>