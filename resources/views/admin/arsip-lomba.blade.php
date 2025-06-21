<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Lomba - Admin Prodi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        
        @include('admin.nav-adminprodi')

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <div class="container mx-auto px-6 py-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Arsip Lomba</h1>
                <p class="text-gray-600 mb-6">Daftar semua lomba yang telah selesai.</p>

                <!-- Search Section -->
                <div class="bg-white p-4 rounded-lg shadow-md mb-6">
                    <div>
                        <label for="search-input" class="text-sm font-medium text-gray-700">Cari Lomba</label>
                        <input type="text" id="search-input" placeholder="Ketik nama lomba atau penyelenggara..." class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>

                <!-- Table Section -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Lomba</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penyelenggara</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Selesai</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="arsip-tbody" class="bg-white divide-y divide-gray-200">
                                <!-- Data arsip akan dirender di sini -->
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
    document.addEventListener('DOMContentLoaded', function() {
        const tbody = document.getElementById('arsip-tbody');
        const searchInput = document.getElementById('search-input');
        const paginationContainer = document.getElementById('pagination-links');
        const API_URL = '/api/admin-prodi/arsip-lomba';
        let searchTimeout;

        const fetchArchives = async (url = API_URL) => {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center py-10 text-gray-500">Memuat data...</td></tr>`;
            
            try {
                const config = {
                    params: { search: searchInput.value }
                };
                
                const response = await axios.get(url, config);
                
                renderTable(response.data.data);
                renderPagination(response.data);
            } catch (error) {
                console.error("Gagal mengambil data arsip:", error);
                tbody.innerHTML = `<tr><td colspan="5" class="text-center py-10 text-red-500">Gagal memuat data arsip.</td></tr>`;
            }
        };

        const renderTable = (items) => {
            tbody.innerHTML = '';
            if (items.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" class="text-center py-10 text-gray-500">Tidak ada data arsip yang ditemukan.</td></tr>`;
                return;
            }

            items.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${item.nama_lomba}</div>
                        <div class="text-sm text-gray-500">${item.tingkat}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${item.penyelenggara}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${new Date(item.tanggal_selesai_lomba).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${getStatusBadge(item.status)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                        <a href="/adminprodi/lomba/${item.id_lomba}" class="text-indigo-600 hover:text-indigo-900">Lihat Detail</a>
                    </td>
                `;
                tbody.appendChild(row);
            });
        };
        
        const renderPagination = (data) => {
            paginationContainer.innerHTML = '';
            if (!data || !data.links || data.last_page <= 1) return;
            
            const nav = document.createElement('nav');
            const linksHtml = data.links.map(link => {
                if (!link.url) {
                    return `<span class="px-3 py-1 mx-1 border rounded text-sm text-gray-400 cursor-not-allowed">${link.label}</span>`;
                }
                return `<a href="${link.url}" class="pagination-btn px-3 py-1 mx-1 border rounded text-sm bg-white text-gray-700 hover:bg-gray-100 ${link.active ? 'bg-blue-500 text-white border-blue-500' : ''}">${link.label}</a>`;
            }).join('');
            nav.innerHTML = `<div class="flex items-center justify-center">${linksHtml}</div>`;
            paginationContainer.appendChild(nav);
        };

        const getStatusBadge = (status) => {
            return `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">${status.charAt(0).toUpperCase() + status.slice(1)}</span>`;
        };

        searchInput.addEventListener('keyup', () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                fetchArchives();
            }, 500);
        });
        
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('pagination-btn')) {
                e.preventDefault();
                fetchArchives(e.target.href);
            }
        });

        // Initial fetch
        fetchArchives();
    });
    </script>
</body>
</html>