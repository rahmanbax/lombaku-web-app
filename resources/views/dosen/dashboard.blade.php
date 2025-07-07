<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dosen Pembina</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-slate-50">
    <div class="flex h-screen">
        @include('dosen.nav-dosen')

        <main class="flex-1 overflow-y-auto">
            <div class="p-6 md:p-10">
                <h1 class="text-3xl font-bold text-slate-800 mb-8">Dashboard Dosen Pembina</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                    <div class="bg-white p-6 rounded-xl shadow-sm flex items-start gap-4">
                        <div class="flex-shrink-0 text-blue-500"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                        <div><p class="text-sm font-medium text-slate-500">Mahasiswa Bimbingan</p><p id="kpi-mahasiswa-aktif" class="text-3xl font-bold text-slate-700 mt-1">...</p></div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm flex items-start gap-4">
                        <div class="flex-shrink-0 text-green-500"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></div>
                        <div><p class="text-sm font-medium text-slate-500">Total Lomba Diikuti</p><p id="kpi-lomba-diikuti" class="text-3xl font-bold text-slate-700 mt-1">...</p></div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm flex items-start gap-4">
                        <div class="flex-shrink-0 text-amber-500"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                        <div><p class="text-sm font-medium text-slate-500">Menunggu Persetujuan</p><p id="kpi-menunggu-persetujuan" class="text-3xl font-bold text-slate-700 mt-1">...</p></div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-200"><h2 class="text-xl font-semibold text-slate-800">Daftar Bimbingan Lomba Terbaru</h2></div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full"><thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Mahasiswa</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Lomba</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tgl Pengajuan</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead><tbody id="bimbingan-table-body" class="bg-white divide-y divide-slate-200"></tbody></table>
                    </div>
                    <div id="pagination-links" class="p-6 border-t border-slate-200 flex justify-center"></div>
                </div>
            </div>
        </main>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const API_BASE_URL = '/api/dosen/dashboard';
        async function fetchDashboardData(url = API_BASE_URL) {
            const tableBody = document.getElementById('bimbingan-table-body');
            tableBody.innerHTML = `<tr><td colspan="4" class="px-6 py-10 text-center text-sm text-slate-500">Memuat data...</td></tr>`;
            try {
                const response = await axios.get(url);
                if (response.data.success) {
                    const data = response.data.data;
                    updateKpiCards(data.stats); updateBimbinganTable(data.daftar_bimbingan); updatePagination(data.daftar_bimbingan);
                } else { throw new Error(response.data.message || 'Gagal mengambil data.'); }
            } catch (error) {
                console.error("Error fetching dashboard data:", error);
                tableBody.innerHTML = `<tr><td colspan="4" class="px-6 py-10 text-center text-sm text-red-500">Gagal memuat data.</td></tr>`;
            }
        }
        function updateKpiCards(stats) {
            document.getElementById('kpi-mahasiswa-aktif').textContent = stats.mahasiswa_aktif || '0';
            document.getElementById('kpi-lomba-diikuti').textContent = stats.lomba_diikuti || '0';
            document.getElementById('kpi-menunggu-persetujuan').textContent = stats.menunggu_persetujuan || '0';
        }
        function updateBimbinganTable(bimbinganData) {
            const tableBody = document.getElementById('bimbingan-table-body');
            tableBody.innerHTML = '';
            if (!bimbinganData || bimbinganData.data.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="4" class="px-6 py-10 text-center text-sm text-slate-500">Tidak ada data bimbingan.</td></tr>`;
                return;
            }
            bimbinganData.data.forEach((item) => {
                const row = document.createElement('tr');
                row.innerHTML = `<td class="px-6 py-4 whitespace-nowrap"><div class="font-medium text-slate-800">${item.mahasiswa?.nama || 'N/A'}</div></td><td class="px-6 py-4"><div class="font-medium text-slate-800">${item.lomba?.nama_lomba || 'Lomba Dihapus'}</div></td><td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">${formatDate(item.created_at)}</td><td class="px-6 py-4 whitespace-nowrap">${getStatusBadge(item.status_verifikasi)}</td>`;
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
                let classes = 'pagination-btn px-4 py-2 mx-1 text-sm rounded-md transition ';
                if (link.active) { classes += 'bg-blue-600 text-white shadow-sm'; } else if (!link.url) { classes += 'bg-slate-100 text-slate-400 cursor-not-allowed'; } else { classes += 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'; }
                linkElement.className = classes;
                if (link.url) { linkElement.addEventListener('click', function(e) { e.preventDefault(); fetchDashboardData(link.url); }); }
                paginationContainer.appendChild(linkElement);
            });
        }
        function formatDate(dateString) { if (!dateString) return '-'; return new Date(dateString).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }); }
        function getStatusBadge(status) {
            const statuses = {'diterima': 'bg-green-100 text-green-800', 'menunggu': 'bg-amber-100 text-amber-800', 'ditolak': 'bg-red-100 text-red-800'};
            const statusText = (status || 'N/A').replace(/_/g, ' ');
            return `<span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${statuses[status] || 'bg-slate-100 text-slate-800'}">${statusText.charAt(0).toUpperCase() + statusText.slice(1)}</span>`;
        }
        fetchDashboardData();
    });
    </script>
</body>
</html>