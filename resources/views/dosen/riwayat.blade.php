<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Riwayat Peserta - Dosen</title>
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
                <h2 class="text-xl text-gray-700 font-semibold">Riwayat Peserta Bimbingan</h2>
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="text-right">
                            <p class="font-semibold text-gray-800">{{ Auth::user()->nama }}</p>
                            <p class="text-sm text-gray-500 capitalize">{{ str_replace('_', ' ', Auth::user()->role) }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="p-2 bg-red-100 text-red-600 hover:bg-red-200 rounded-full transition duration-200" title="Logout">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            </button>
                        </form>
                    @endauth
                </div>
            </header>

            <!-- Konten Utama -->
            <main class="flex-1 overflow-y-auto">
                <div class="container mx-auto px-4 py-8">
                    <!-- Tabel Riwayat Prestasi -->
                    <div class="bg-white rounded-lg shadow-md">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-800">Daftar Prestasi Mahasiswa Bimbingan</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Mahasiswa</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lomba</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode Lomba</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peringkat</th>
                                    </tr>
                                </thead>
                                <tbody id="riwayat-table-body" class="bg-white divide-y divide-gray-200">
                                    <tr><td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Memuat data...</td></tr>
                                </tbody>
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
            // API endpoint untuk riwayat
            const API_BASE_URL = '/api/dosen/riwayat-peserta';

            async function fetchRiwayatData(url = API_BASE_URL) {
                const tableBody = document.getElementById('riwayat-table-body');
                tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Memuat data...</td></tr>`;

                try {
                    const response = await axios.get(url, {
                        headers: { 'Authorization': `Bearer ${localStorage.getItem('authToken')}` }
                    });

                    if (response.data.success) {
                        const riwayatData = response.data.data;
                        updateRiwayatTable(riwayatData);
                        updatePagination(riwayatData); // Fungsi paginasi bisa dipakai ulang
                    } else {
                        throw new Error(response.data.message || 'Gagal mengambil data.');
                    }
                } catch (error) {
                    console.error("Error fetching riwayat data:", error);
                    let errorMessage = "Terjadi kesalahan saat memuat data.";
                    if (error.response && (error.response.status === 401 || error.response.status === 403)) {
                        errorMessage = "Otentikasi Gagal. Anda tidak memiliki izin untuk mengakses data ini.";
                    }
                    tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-sm text-red-500">${errorMessage}</td></tr>`;
                }
            }

            function updateRiwayatTable(riwayatData) {
                const tableBody = document.getElementById('riwayat-table-body');
                tableBody.innerHTML = '';

                if (!riwayatData || riwayatData.data.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada riwayat prestasi untuk ditampilkan.</td></tr>`;
                    return;
                }

                riwayatData.data.forEach((item, index) => {
                    const row = document.createElement('tr');
                    const periodeLomba = `${formatDate(item.lomba?.tanggal_mulai_lomba)} - ${formatDate(item.lomba?.tanggal_selesai_lomba)}`;
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${riwayatData.from + index}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${item.mahasiswa?.nama || 'N/A'}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${item.lomba?.nama_lomba || item.nama_lomba_eksternal || 'N/A'}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${periodeLomba}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">${getStatusBadge(item.peringkat)}</td>
                    `;
                    tableBody.appendChild(row);
                });
            }

            // Fungsi ini sama seperti di dashboard, bisa dipakai ulang
            function updatePagination(paginationData) {
                const paginationContainer = document.getElementById('pagination-links');
                paginationContainer.innerHTML = '';
                if (!paginationData || !paginationData.links || paginationData.links.length <= 3) return;
                paginationData.links.forEach(link => {
                    const linkElement = document.createElement('button');
                    linkElement.innerHTML = link.label.replace('«', '«').replace('»', '»');
                    let classes = 'px-3 py-1 mx-1 border rounded text-sm disabled:opacity-50 ';
                    if (link.active) { classes += 'bg-blue-500 text-white cursor-default'; } 
                    else if (!link.url) { classes += 'bg-gray-100 text-gray-400 cursor-not-allowed'; linkElement.disabled = true; } 
                    else { classes += 'bg-white text-gray-700 hover:bg-gray-100'; }
                    linkElement.className = classes;
                    if (link.url) {
                        linkElement.addEventListener('click', (e) => {
                            e.preventDefault();
                            fetchRiwayatData(link.url);
                        });
                    }
                    paginationContainer.appendChild(linkElement);
                });
            }

            // Fungsi ini sama, bisa dipakai ulang
            function formatDate(dateString) {
                if (!dateString) return '-';
                const options = { day: 'numeric', month: 'short', year: 'numeric' };
                return new Date(dateString).toLocaleDateString('id-ID', options);
            }

            // Fungsi ini diubah sedikit untuk menampilkan peringkat dengan lebih baik
            function getStatusBadge(peringkat) {
                const text = peringkat || 'Partisipan';
                let statusClass = 'bg-blue-100 text-blue-800'; // Default untuk partisipan
                const lowerText = text.toLowerCase();

                if (lowerText.includes('juara 1') || lowerText.includes('gold')) {
                    statusClass = 'bg-yellow-200 text-yellow-800';
                } else if (lowerText.includes('juara 2') || lowerText.includes('silver')) {
                    statusClass = 'bg-gray-300 text-gray-800';
                } else if (lowerText.includes('juara 3') || lowerText.includes('bronze')) {
                    statusClass = 'bg-orange-200 text-orange-800';
                }
                
                return `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">${text}</span>`;
            }

            // Memuat data saat halaman dibuka
            fetchRiwayatData();
        });
    </script>
</body>
</html>