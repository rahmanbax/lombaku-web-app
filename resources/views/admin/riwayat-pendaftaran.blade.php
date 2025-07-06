<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pendaftaran - Admin Prodi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-slate-50">
    <div class="flex h-screen">
        @include('admin.nav-adminprodi')

        <main class="flex-1 overflow-y-auto">
            <div class="p-6 md:p-10">
                <h1 class="text-3xl font-bold text-slate-800 mb-8">Riwayat Pendaftaran Lomba</h1>

                <div class="bg-white p-6 rounded-xl shadow-sm mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="search-input" class="text-sm font-medium text-slate-600">Cari (Nama, NIM, Lomba)</label>
                            <input type="text" id="search-input" placeholder="Ketik untuk mencari..." class="mt-2 block w-full px-4 py-2 bg-white border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="status-filter" class="text-sm font-medium text-slate-600">Filter Status Verifikasi</label>
                            <select id="status-filter" class="mt-2 block w-full px-3 py-2 bg-white border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Semua Status</option>
                                <option value="menunggu">Menunggu</option>
                                <option value="diterima">Diterima</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Mahasiswa</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Lomba</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tgl Daftar</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody id="history-tbody" class="bg-white divide-y divide-slate-200"></tbody>
                        </table>
                    </div>
                    <div id="pagination-links" class="p-6 border-t border-slate-200 flex justify-center"></div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tbody = document.getElementById('history-tbody');
            const searchInput = document.getElementById('search-input');
            const statusFilter = document.getElementById('status-filter');
            const paginationContainer = document.getElementById('pagination-links');
            const API_URL = '/api/admin-prodi/registration-history';
            let searchTimeout;

            const fetchHistory = async (url = API_URL) => {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center py-10 text-slate-500">Memuat data...</td></tr>`;
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
                    tbody.innerHTML = `<tr><td colspan="4" class="text-center py-10 text-slate-500">Tidak ada data yang cocok.</td></tr>`;
                    return;
                }
                items.forEach(item => {
                    const lombaName = item.lomba ? item.lomba.nama_lomba : '<span class="text-red-500">Lomba Dihapus</span>';
                    const mahasiswa = item.mahasiswa; const profil = mahasiswa.profil_mahasiswa;
                    const nimDisplay = profil ? profil.nim : '<span class="text-red-500">Profil Hilang</span>';
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap"><div class="font-medium text-slate-800">${mahasiswa.nama}</div><div class="text-sm text-slate-500">${nimDisplay}</div></td>
                        <td class="px-6 py-4"><div class="font-medium text-slate-800">${lombaName}</div></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">${new Date(item.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${getStatusBadge(item.status_verifikasi)}</td>`;
                    tbody.appendChild(row);
                });
            };
            const renderPagination = (data) => {
                paginationContainer.innerHTML = '';
                if (!data || !data.links || data.last_page <= 1) return;
                const nav = document.createElement('nav');
                data.links.forEach(link => {
                    const linkElement = document.createElement('a');
                    linkElement.href = link.url || '#';
                    linkElement.innerHTML = link.label;
                    let classes = 'pagination-btn px-4 py-2 mx-1 text-sm rounded-md transition ';
                    if (link.active) { classes += 'bg-blue-600 text-white shadow-sm'; }
                    else if (!link.url) { classes += 'bg-slate-100 text-slate-400 cursor-not-allowed'; }
                    else { classes += 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'; }
                    linkElement.className = classes;
                    if (link.url) { linkElement.addEventListener('click', (e) => { e.preventDefault(); fetchHistory(link.url); }); }
                    nav.appendChild(linkElement);
                });
                paginationContainer.appendChild(nav);
            };
            const getStatusBadge = (status) => {
                const statuses = { 'menunggu': 'bg-amber-100 text-amber-800', 'diterima': 'bg-green-100 text-green-800', 'ditolak': 'bg-red-100 text-red-800' };
                const text = status.charAt(0).toUpperCase() + status.slice(1);
                return `<span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${statuses[status] || ''}">${text}</span>`;
            };
            searchInput.addEventListener('keyup', () => { clearTimeout(searchTimeout); searchTimeout = setTimeout(() => { fetchHistory(); }, 500); });
            statusFilter.addEventListener('change', () => fetchHistory());
            document.addEventListener('click', function(e) { if (e.target.classList.contains('pagination-btn')) { e.preventDefault(); fetchHistory(e.target.href); } });
            fetchHistory();
        });
    </script>
</body>
</html>