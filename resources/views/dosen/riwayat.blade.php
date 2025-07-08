<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peserta - Dosen</title>
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
                <h1 class="text-3xl font-bold text-slate-800 mb-8">Riwayat Peserta Bimbingan</h1>
                
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-200"><h2 class="text-xl font-semibold text-slate-800">Daftar Prestasi Mahasiswa Bimbingan</h2></div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full"><thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Mahasiswa</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Lomba</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Periode</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Peringkat</th>
                            </tr>
                        </thead><tbody id="riwayat-table-body" class="bg-white divide-y divide-slate-200"></tbody></table>
                    </div>
                    <div id="pagination-links" class="p-6 border-t border-slate-200 flex justify-center"></div>
                </div>
            </div>
        </main>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const API_BASE_URL = '/api/dosen/riwayat-peserta';
        function fetchRiwayatData(url = API_BASE_URL) {
            const tableBody = document.getElementById('riwayat-table-body');
            tableBody.innerHTML = `<tr><td colspan="4" class="px-6 py-10 text-center text-sm text-slate-500">Memuat data...</td></tr>`;
            axios.get(url).then(response => {
                if (response.data.success) {
                    updateRiwayatTable(response.data.data); updatePagination(response.data.data);
                } else { throw new Error(response.data.message || 'Gagal mengambil data.'); }
            }).catch(error => {
                console.error("Error fetching riwayat data:", error);
                tableBody.innerHTML = `<tr><td colspan="4" class="px-6 py-10 text-center text-sm text-red-500">Gagal memuat data.</td></tr>`;
            });
        }
        function updateRiwayatTable(riwayatData) {
            const tableBody = document.getElementById('riwayat-table-body');
            tableBody.innerHTML = '';
            if (!riwayatData || riwayatData.data.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="4" class="px-6 py-10 text-center text-sm text-slate-500">Tidak ada riwayat prestasi.</td></tr>`;
                return;
            }
            riwayatData.data.forEach((item) => {
                const row = document.createElement('tr');
                const periodeLomba = `${formatDate(item.lomba?.tanggal_mulai_lomba)} - ${formatDate(item.lomba?.tanggal_selesai_lomba)}`;
                row.innerHTML = `<td class="px-6 py-4 whitespace-nowrap"><div class="font-medium text-slate-800">${item.mahasiswa?.nama || 'N/A'}</div></td><td class="px-6 py-4"><div class="font-medium text-slate-800">${item.lomba?.nama_lomba || item.nama_lomba_eksternal || 'N/A'}</div></td><td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">${periodeLomba}</td><td class="px-6 py-4 whitespace-nowrap">${getRankBadge(item.peringkat)}</td>`;
                tableBody.appendChild(row);
            });
        }
        function updatePagination(paginationData) {
            const paginationContainer = document.getElementById('pagination-links');
            paginationContainer.innerHTML = '';
            if (!paginationData || !paginationData.links || paginationData.links.length <= 3) return;
            const nav = document.createElement('nav');
            paginationData.links.forEach(link => {
                const linkElement = document.createElement('a');
                linkElement.href = link.url || '#';
                linkElement.innerHTML = link.label;
                let classes = 'pagination-btn px-4 py-2 mx-1 text-sm rounded-md transition ';
                if (link.active) { classes += 'bg-blue-600 text-white shadow-sm'; } else if (!link.url) { classes += 'bg-slate-100 text-slate-400 cursor-not-allowed'; } else { classes += 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'; }
                linkElement.className = classes;
                if (link.url) { linkElement.addEventListener('click', (e) => { e.preventDefault(); fetchRiwayatData(link.url); }); }
                nav.appendChild(linkElement);
            });
            paginationContainer.appendChild(nav);
        }
        function formatDate(dateString) { if (!dateString) return '-'; return new Date(dateString).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }); }
        function getRankBadge(peringkat) {
            const text = peringkat || 'Partisipan';
            let statusClass = 'bg-blue-100 text-blue-800';
            const lowerText = text.toLowerCase();
            if (lowerText.includes('juara 1') || lowerText.includes('gold')) { statusClass = 'bg-amber-100 text-amber-800'; }
            else if (lowerText.includes('juara 2') || lowerText.includes('silver')) { statusClass = 'bg-slate-200 text-slate-700'; }
            else if (lowerText.includes('juara 3') || lowerText.includes('bronze')) { statusClass = 'bg-orange-100 text-orange-800'; }
            return `<span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">${text}</span>`;
        }
        fetchRiwayatData();
    });
    </script>
</body>
</html>