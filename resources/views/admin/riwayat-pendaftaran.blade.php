<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pendaftaran - Admin Prodi</title>
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
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Riwayat Pendaftaran Lomba</h1>

                <!-- Filter & Search Section -->
                <div class="bg-white p-4 rounded-lg shadow-md mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="search-input" class="text-sm font-medium text-gray-700">Cari (Nama, NIM, Lomba)</label>
                            <input type="text" id="search-input" placeholder="Ketik untuk mencari..." class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="status-filter" class="text-sm font-medium text-gray-700">Filter Status Verifikasi</label>
                            <select id="status-filter" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Semua Status</option>
                                <option value="menunggu">Menunggu</option>
                                <option value="diterima">Diterima</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mahasiswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lomba</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Daftar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody id="history-tbody" class="bg-white divide-y divide-gray-200">
                                <!-- Data akan dirender di sini -->
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination Container -->
                    <div id="pagination-links" class="p-4 border-t"></div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Script JS tidak perlu diubah
        document.addEventListener('DOMContentLoaded', function() {
            const tbody = document.getElementById('history-tbody');
            const searchInput = document.getElementById('search-input');
            const statusFilter = document.getElementById('status-filter');
            const paginationContainer = document.getElementById('pagination-links');
            const API_URL = '/api/admin-prodi/registration-history';
            let searchTimeout;

            const fetchHistory = async (url = API_URL) => {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center py-10 text-gray-500">Memuat data...</td></tr>`;
                try {
                    const config = { params: { status: statusFilter.value, search: searchInput.value } };
                    const response = await axios.get(url, config);
                    renderTable(response.data.data);
                    renderPagination(response.data);
                } catch (error) {
                    console.error("Gagal mengambil data:", error);
                    tbody.innerHTML = `<tr><td colspan="4" class="text-center py-10 text-red-500">Gagal memuat data.</td></tr>`;
                }
            };
            const renderTable = (items) => {
                tbody.innerHTML = '';
                if (items.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="4" class="text-center py-10 text-gray-500">Tidak ada data yang cocok.</td></tr>`;
                    return;
                }
                items.forEach(item => {
                    const lombaName = item.lomba ? item.lomba.nama_lomba : '<span class="text-red-500">Lomba Dihapus</span>';
                    const mahasiswa = item.mahasiswa; const profil = mahasiswa.profil_mahasiswa;
                    const row = document.createElement('tr');
                    row.innerHTML = `<td class="px-6 py-4 whitespace-nowrap"><div class="text-sm font-medium text-gray-900">${mahasiswa.nama}</div><div class="text-sm text-gray-500">${profil ? profil.nim : 'N/A'}</div></td><td class="px-6 py-4"><div class="text-sm font-medium text-gray-900">${lombaName}</div></td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${new Date(item.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}</td><td class="px-6 py-4 whitespace-nowrap">${getStatusBadge(item.status_verifikasi)}</td>`;
                    tbody.appendChild(row);
                });
            };
            const renderPagination = (data) => {
                paginationContainer.innerHTML = '';
                if (!data || !data.links || data.last_page <= 1) return;
                const nav = document.createElement('nav');
                const linksHtml = data.links.map(link => {
                    if (!link.url) { return `<span class="px-3 py-1 mx-1 border rounded text-sm text-gray-400 cursor-not-allowed">${link.label}</span>`; }
                    return `<a href="${link.url}" class="pagination-btn px-3 py-1 mx-1 border rounded text-sm bg-white text-gray-700 hover:bg-gray-100 ${link.active ? 'bg-blue-500 text-white border-blue-500' : ''}">${link.label}</a>`;
                }).join('');
                nav.innerHTML = `<div class="flex items-center justify-center">${linksHtml}</div>`;
                paginationContainer.appendChild(nav);
            };
            const getStatusBadge = (status) => {
                const statuses = { 'menunggu': 'bg-yellow-100 text-yellow-800', 'diterima': 'bg-green-100 text-green-800', 'ditolak': 'bg-red-100 text-red-800' };
                const text = status.charAt(0).toUpperCase() + status.slice(1);
                return `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statuses[status] || ''}">${text}</span>`;
            };
            searchInput.addEventListener('keyup', () => { clearTimeout(searchTimeout); searchTimeout = setTimeout(() => { fetchHistory(); }, 500); });
            statusFilter.addEventListener('change', () => fetchHistory());
            document.addEventListener('click', function(e) { if (e.target.classList.contains('pagination-btn')) { e.preventDefault(); fetchHistory(e.target.href); } });
            fetchHistory();
        });
    </script>
</body>
</html>