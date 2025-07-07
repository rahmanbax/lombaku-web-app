<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Lomba - Admin Prodi</title>
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
                <h1 class="text-3xl font-bold text-slate-800 mb-2">Arsip Lomba</h1>
                <p class="text-slate-600 mb-8">Daftar semua lomba yang telah selesai.</p>

                <div class="bg-white p-6 rounded-xl shadow-sm mb-8">
                    <div>
                        <label for="search-input" class="text-sm font-medium text-slate-600">Cari Lomba</label>
                        <input type="text" id="search-input" placeholder="Ketik nama lomba atau penyelenggara..." class="mt-2 block w-full px-4 py-2 bg-white border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Lomba</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Penyelenggara</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal Selesai</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                                    <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody id="arsip-tbody" class="bg-white divide-y divide-slate-200"></tbody>
                        </table>
                    </div>
                    <div id="pagination-links" class="p-6 border-t border-slate-200 flex justify-center"></div>
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
            tbody.innerHTML = `<tr><td colspan="5" class="text-center py-10 text-slate-500">Memuat data arsip...</td></tr>`;
            try {
                const config = { params: { search: searchInput.value } };
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
                tbody.innerHTML = `<tr><td colspan="5" class="text-center py-10 text-slate-500">Tidak ada data arsip yang ditemukan.</td></tr>`;
                return;
            }
            items.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap"><div class="font-medium text-slate-800">${item.nama_lomba}</div><div class="text-sm text-slate-500">${item.tingkat}</div></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">${item.penyelenggara}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">${new Date(item.tanggal_selesai_lomba).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${getStatusBadge(item.status)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"><a href="/adminprodi/lomba/${item.id_lomba}" class="text-blue-600 hover:text-blue-800">Lihat Detail</a></td>
                `;
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
                if (link.url) { linkElement.addEventListener('click', (e) => { e.preventDefault(); fetchArchives(e.target.href); }); }
                nav.appendChild(linkElement);
            });
            paginationContainer.appendChild(nav);
        };

        const getStatusBadge = (status) => {
            return `<span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 text-slate-800">${status.charAt(0).toUpperCase() + status.slice(1)}</span>`;
        };

        searchInput.addEventListener('keyup', () => { clearTimeout(searchTimeout); searchTimeout = setTimeout(() => { fetchArchives(); }, 500); });
        document.addEventListener('click', function(e) { if (e.target.classList.contains('pagination-btn')) { e.preventDefault(); fetchArchives(e.target.href); } });

        fetchArchives();
    });
    </script>
</body>
</html>