<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Prestasi - Admin Prodi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('admin.nav-adminprodi')

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <div class="container mx-auto px-6 py-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Manajemen Verifikasi Prestasi</h1>

                <!-- Filter Section -->
                <div class="bg-white p-4 rounded-lg shadow-md mb-6">
                    <div class="flex items-center space-x-4">
                        <label for="status-filter" class="text-sm font-medium text-gray-700">Filter Status:</label>
                        <select id="status-filter" class="w-full md:w-auto mt-1 block px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Semua</option>
                            <option value="menunggu" selected>Menunggu</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mahasiswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Detail Prestasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="verifikasi-tbody" class="bg-white divide-y divide-gray-200">
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
            const tbody = document.getElementById('verifikasi-tbody');
            const statusFilter = document.getElementById('status-filter');
            const paginationContainer = document.getElementById('pagination-links');
            const API_URL = '/api/admin-prodi/prestasi-verifikasi';

            const fetchVerifications = async (url = API_URL) => {
                tbody.innerHTML = `<tr><td colspan="5" class="text-center py-10 text-gray-500">Memuat data...</td></tr>`;
                try {
                    const params = new URLSearchParams();
                    params.append('status', statusFilter.value);
                    const response = await axios.get(`${url}?${params.toString()}`);
                    renderTable(response.data.data);
                    renderPagination(response.data);
                } catch (error) {
                    console.error("Gagal mengambil data:", error);
                    tbody.innerHTML = `<tr><td colspan="5" class="text-center py-10 text-red-500">Gagal memuat data.</td></tr>`;
                }
            };
            const renderTable = (items) => {
                tbody.innerHTML = '';
                if (items.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="5" class="text-center py-10 text-gray-500">Tidak ada data yang cocok.</td></tr>`;
                    return;
                }
                items.forEach(item => {
                    const row = document.createElement('tr');
                    let actionButtons = '';
                    if (item.status_verifikasi === 'menunggu') {
                        actionButtons = `<button onclick="handleApprove(${item.id_prestasi})" class="text-green-600 hover:text-green-900 text-sm">Setujui</button><button onclick="handleReject(${item.id_prestasi})" class="text-red-600 hover:text-red-900 ml-2 text-sm">Tolak</button>`;
                    }
                    row.innerHTML = `<td class="px-6 py-4 whitespace-nowrap"><div class="text-sm font-medium text-gray-900">${item.mahasiswa.nama}</div><div class="text-sm text-gray-500">${item.mahasiswa.profil_mahasiswa.nim}</div></td><td class="px-6 py-4 whitespace-nowrap"><div class="text-sm font-medium text-gray-900">${item.nama_lomba_eksternal}</div><div class="text-sm text-gray-500">${item.peringkat} - ${item.penyelenggara_eksternal}</div></td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${new Date(item.tanggal_diraih).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}</td><td class="px-6 py-4 whitespace-nowrap">${getStatusBadge(item.status_verifikasi)}</td><td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium"><a href="/storage/${item.sertifikat_path}" target="_blank" class="text-blue-600 hover:text-blue-900">Lihat Sertifikat</a>${actionButtons}</td>`;
                    tbody.appendChild(row);
                });
            };
            const renderPagination = (data) => {
                paginationContainer.innerHTML = '';
                if (data.last_page <= 1) return;
                const nav = document.createElement('nav');
                nav.className = 'flex items-center justify-between';
                const linksHtml = data.links.map(link => {
                    if (!link.url) { return `<span class="px-3 py-1 mx-1 border rounded text-sm text-gray-400 cursor-not-allowed">${link.label}</span>`; }
                    return `<a href="${link.url}" class="pagination-btn px-3 py-1 mx-1 border rounded text-sm bg-white text-gray-700 hover:bg-gray-100 ${link.active ? 'bg-blue-500 text-white border-blue-500' : ''}">${link.label}</a>`;
                }).join('');
                nav.innerHTML = `<div class="flex-1 flex justify-center">${linksHtml}</div>`;
                paginationContainer.appendChild(nav);
            };
            const getStatusBadge = (status) => {
                const statuses = { 'menunggu': 'bg-yellow-100 text-yellow-800', 'disetujui': 'bg-green-100 text-green-800', 'ditolak': 'bg-red-100 text-red-800' };
                const text = status.charAt(0).toUpperCase() + status.slice(1);
                return `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statuses[status] || ''}">${text}</span>`;
            };
            window.handleApprove = (id) => { Swal.fire({ title: 'Setujui Pengajuan?', icon: 'question', showCancelButton: true, confirmButtonColor: '#16a34a', confirmButtonText: 'Ya, Setujui!' }).then(async (result) => { if (result.isConfirmed) { try { await axios.patch(`/api/prestasi/${id}/verifikasi/setujui`); Swal.fire('Berhasil!', 'Prestasi telah disetujui.', 'success'); fetchVerifications(); } catch (error) { Swal.fire('Error!', 'Gagal menyetujui prestasi.', 'error'); } } }); };
            window.handleReject = (id) => { Swal.fire({ title: 'Tolak Pengajuan?', input: 'textarea', inputLabel: 'Alasan Penolakan', inputPlaceholder: 'Tuliskan alasan penolakan di sini...', icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc2626', confirmButtonText: 'Ya, Tolak!', inputValidator: (value) => !value && 'Anda harus menuliskan alasan penolakan!' }).then(async (result) => { if (result.isConfirmed) { try { await axios.patch(`/api/prestasi/${id}/verifikasi/tolak`, { catatan_verifikasi: result.value }); Swal.fire('Berhasil!', 'Prestasi telah ditolak.', 'success'); fetchVerifications(); } catch (error) { Swal.fire('Error!', 'Gagal menolak prestasi.', 'error'); } } }); };
            statusFilter.addEventListener('change', () => fetchVerifications());
            document.addEventListener('click', function(e) { if (e.target.classList.contains('pagination-btn')) { e.preventDefault(); fetchVerifications(e.target.href); } });
            fetchVerifications();
        });
    </script>
</body>
</html>