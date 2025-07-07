<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persetujuan Lomba - Dosen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <h1 class="text-3xl font-bold text-slate-800 mb-8">Persetujuan Bimbingan Lomba</h1>
                
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-200"><h2 class="text-xl font-semibold text-slate-800">Daftar Pengajuan Bimbingan</h2></div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full"><thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Mahasiswa</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Lomba</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tim</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead><tbody id="persetujuan-table-body" class="bg-white divide-y divide-slate-200"></tbody></table>
                    </div>
                    <div id="pagination-links" class="p-6 border-t border-slate-200 flex justify-center"></div>
                </div>
            </div>
        </main>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const API_URL = '/api/dosen/persetujuan';
        function fetchPersetujuanData(url = API_URL) {
            const tableBody = document.getElementById('persetujuan-table-body');
            tableBody.innerHTML = `<tr><td colspan="4" class="px-6 py-10 text-center text-sm text-slate-500">Memuat data...</td></tr>`;
            axios.get(url).then(response => {
                if (response.data.success) { updateTable(response.data.data); updatePagination(response.data.data); }
                else { throw new Error(response.data.message || 'Gagal mengambil data.'); }
            }).catch(error => {
                console.error("Gagal mengambil data persetujuan:", error);
                tableBody.innerHTML = `<tr><td colspan="4" class="px-6 py-10 text-center text-red-500">Gagal memuat data.</td></tr>`;
            });
        }
        function updateTable(data) {
            const tableBody = document.getElementById('persetujuan-table-body');
            tableBody.innerHTML = '';
            if (data.data.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="4" class="px-6 py-10 text-center text-sm text-slate-500">Tidak ada pengajuan yang menunggu.</td></tr>`;
                return;
            }
            data.data.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `<td class="px-6 py-4 whitespace-nowrap"><div class="font-medium text-slate-800">${item.mahasiswa?.nama || 'N/A'}</div></td><td class="px-6 py-4"><div class="font-medium text-slate-800">${item.lomba?.nama_lomba || 'Lomba Dihapus'}</div></td><td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">${item.tim?.nama_tim || 'Individu'}</td><td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-3"><button class="reject-btn text-slate-600 hover:text-red-600 font-semibold" data-id="${item.id_registrasi_lomba}">Tolak</button><button class="approve-btn text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg" data-id="${item.id_registrasi_lomba}">Setujui</button></td>`;
                tableBody.appendChild(row);
            });
        }
        document.getElementById('persetujuan-table-body').addEventListener('click', function(event) {
            const target = event.target.closest('button'); if (!target) return;
            const id = target.dataset.id; if (!id) return;
            if (target.classList.contains('approve-btn')) { handleAction('setujui', id); }
            else if (target.classList.contains('reject-btn')) { handleAction('tolak', id); }
        });
        function handleAction(action, id) {
            const isApprove = action === 'setujui';
            Swal.fire({
                title: 'Konfirmasi Aksi', text: `Anda yakin ingin ${action} pendaftaran ini?`, icon: 'warning', showCancelButton: true,
                confirmButtonColor: isApprove ? '#2563eb' : '#dc2626', cancelButtonColor: '#64748b', confirmButtonText: `Ya, ${action}!`, cancelButtonText: 'Batal'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await axios.patch(`/api/dosen/pendaftaran/${id}/${action}`, {});
                        if (response.data.success) { Swal.fire('Berhasil!', response.data.message, 'success'); fetchPersetujuanData(); }
                        else { throw new Error(response.data.message || 'Terjadi kesalahan.'); }
                    } catch (error) {
                        const errorMessage = error.response?.data?.message || `Gagal ${action} pendaftaran.`;
                        Swal.fire('Gagal!', errorMessage, 'error');
                    }
                }
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
                if (link.url) { linkElement.addEventListener('click', (e) => { e.preventDefault(); fetchPersetujuanData(link.url); }); }
                nav.appendChild(linkElement);
            });
            paginationContainer.appendChild(nav);
        }
        fetchPersetujuanData();
    });
    </script>
</body>
</html>