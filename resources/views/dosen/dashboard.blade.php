<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dosen Pembina</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white p-4">
            <h2 class="text-xl font-bold mb-4">Dosen Area</h2>
            <nav>
                <a href="{{ route('dosen.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('dosen.dashboard') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">Dashboard</a>
                <a href="{{ route('dosen.riwayat') }}" class="block py-2.5 px-4 rounded transition duration-200 mt-2 {{ request()->routeIs('dosen.riwayat') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">Riwayat Peserta</a>
                <a href="{{ route('dosen.persetujuan') }}" class="block py-2.5 px-4 rounded transition duration-200 mt-2 {{ request()->routeIs('dosen.persetujuan') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">Persetujuan Lomba</a>
            </nav>
        </div>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            <header class="bg-white shadow-md p-4 flex justify-between items-center border-b">
                <h2 class="text-xl text-gray-700 font-semibold">Dashboard</h2>
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="text-right">
                            <p class="font-semibold text-gray-800">{{ Auth::user()->nama }}</p>
                            <p class="text-sm text-gray-500 capitalize">{{ str_replace('_', ' ', Auth::user()->role) }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="p-2 bg-red-100 text-red-600 hover:bg-red-200 rounded-full transition duration-200" title="Logout">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            </button>
                        </form>
                    @endauth
                </div>
            </header>

            <!-- Konten Utama -->
            <main class="flex-1 overflow-y-auto">
                <div class="container mx-auto px-4 py-8">
                    <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Dosen Pembina</h1>
                    <!-- Bagian Statistik -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        <div class="bg-white p-6 rounded-lg shadow-md"><div class="flex items-center"><div class="bg-blue-500 text-white p-3 rounded-full"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div><div class="ml-4"><p class="text-sm font-medium text-gray-500">Mahasiswa Bimbingan</p><p id="kpi-mahasiswa-aktif" class="text-2xl font-bold text-gray-900">...</p></div></div></div>
                        <div class="bg-white p-6 rounded-lg shadow-md"><div class="flex items-center"><div class="bg-green-500 text-white p-3 rounded-full"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></div><div class="ml-4"><p class="text-sm font-medium text-gray-500">Total Lomba Diikuti</p><p id="kpi-lomba-diikuti" class="text-2xl font-bold text-gray-900">...</p></div></div></div>
                        <div class="bg-white p-6 rounded-lg shadow-md"><div class="flex items-center"><div class="bg-yellow-500 text-white p-3 rounded-full"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div><div class="ml-4"><p class="text-sm font-medium text-gray-500">Menunggu Persetujuan</p><p id="kpi-menunggu-persetujuan" class="text-2xl font-bold text-gray-900">...</p></div></div></div>
                    </div>
                    <!-- Tabel Daftar Bimbingan -->
                    <div class="bg-white rounded-lg shadow-md">
                        <div class="p-6 border-b"><h2 class="text-xl font-semibold text-gray-800">Daftar Bimbingan Lomba Terbaru</h2></div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Mahasiswa</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Lomba</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Pengajuan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="bimbingan-table-body" class="bg-white divide-y"></tbody>
                            </table>
                        </div>
                        <div id="pagination-links" class="p-4 border-t flex justify-center"></div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const API_BASE_URL = '/api/dosen/dashboard';
        
        async function fetchDashboardData(url = API_BASE_URL) {
            const tableBody = document.getElementById('bimbingan-table-body');
            tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Memuat data...</td></tr>`;
            
            try {
                const response = await axios.get(url);
                if (response.data.success) {
                    const data = response.data.data;
                    updateKpiCards(data.stats);
                    updateBimbinganTable(data.daftar_bimbingan);
                    updatePagination(data.daftar_bimbingan);
                } else { 
                    throw new Error(response.data.message || 'Gagal mengambil data.'); 
                }
            } catch (error) {
                console.error("Error fetching dashboard data:", error);
                let errorMessage = "Gagal memuat data.";
                if (error.response && (error.response.status === 401 || error.response.status === 403)) {
                    errorMessage = "Otentikasi Gagal. Silakan login kembali.";
                }
                tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-sm text-red-500">${errorMessage}</td></tr>`;
            }
        }
        
        function updateKpiCards(stats) {
            document.getElementById('kpi-mahasiswa-aktif').textContent = stats.mahasiswa_aktif || 0;
            document.getElementById('kpi-lomba-diikuti').textContent = stats.lomba_diikuti || 0;
            document.getElementById('kpi-menunggu-persetujuan').textContent = stats.menunggu_persetujuan || 0;
        }

        function updateBimbinganTable(bimbinganData) {
            const tableBody = document.getElementById('bimbingan-table-body');
            tableBody.innerHTML = '';
            if (!bimbinganData || bimbinganData.data.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data bimbingan untuk ditampilkan.</td></tr>`;
                return;
            }
            bimbinganData.data.forEach((item, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${bimbinganData.from + index}</td><td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${item.mahasiswa?.nama || 'N/A'}</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${item.lomba?.nama_lomba || 'Lomba Dihapus'}</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${formatDate(item.created_at)}</td><td class="px-6 py-4 whitespace-nowrap text-sm">${getStatusBadge(item.status_verifikasi)}</td>`;
                tableBody.appendChild(row);
            });
        }

        function updatePagination(paginationData) {
            const paginationContainer = document.getElementById('pagination-links');
            paginationContainer.innerHTML = '';
            if (!paginationData || !paginationData.links || paginationData.links.length <= 3) return;
            paginationData.links.forEach(link => {
                const linkElement = document.createElement('button');
                linkElement.innerHTML = link.label.replace('«', '«').replace('»', '»');
                let classes = 'px-3 py-1 mx-1 border rounded text-sm disabled:opacity-50 ';
                if (link.active) { classes += 'bg-blue-500 text-white cursor-default'; } else if (!link.url) { classes += 'bg-gray-100 text-gray-400 cursor-not-allowed'; linkElement.disabled = true; } else { classes += 'bg-white text-gray-700 hover:bg-gray-100'; }
                linkElement.className = classes;
                if (link.url) { linkElement.addEventListener('click', (e) => { e.preventDefault(); fetchDashboardData(link.url); }); }
                paginationContainer.appendChild(linkElement);
            });
        }

        function formatDate(dateString) { if (!dateString) return '-'; const options = { day: 'numeric', month: 'short', year: 'numeric' }; return new Date(dateString).toLocaleDateString('id-ID', options); }
        
        function getStatusBadge(status) {
            const statusText = (status || 'N/A').replace(/_/g, ' ');
            let statusClass = '';
            switch (status) {
                case 'diterima': statusClass = 'bg-green-100 text-green-800'; break;
                case 'menunggu': statusClass = 'bg-yellow-100 text-yellow-800'; break;
                case 'ditolak': statusClass = 'bg-red-100 text-red-800'; break;
                default: statusClass = 'bg-gray-100 text-gray-800';
            }
            return `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">${statusText.charAt(0).toUpperCase() + statusText.slice(1)}</span>`;
        }

        fetchDashboardData();
    });
    </script>
</body>
</html>