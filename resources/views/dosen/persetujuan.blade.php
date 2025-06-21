<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persetujuan Lomba - Dosen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <h2 class="text-xl text-gray-700 font-semibold">Persetujuan Bimbingan Lomba</h2>
                @auth
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="font-semibold text-gray-800">{{ Auth::user()->nama }}</p>
                        <p class="text-sm text-gray-500 capitalize">{{ str_replace('_', ' ', Auth::user()->role) }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="p-2 bg-red-100 text-red-600 hover:bg-red-200 rounded-full transition" title="Logout">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
                @endauth
            </header>

            <!-- Konten Utama -->
            <main class="flex-1 overflow-y-auto">
                <div class="container mx-auto px-4 py-8">
                    <div class="bg-white rounded-lg shadow-md">
                        <div class="p-6 border-b">
                            <h2 class="text-xl font-semibold text-gray-800">Daftar Pengajuan Bimbingan</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Mahasiswa</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Lomba</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tim</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="persetujuan-table-body" class="bg-white divide-y divide-gray-200">
                                    <!-- Data akan dimuat oleh JavaScript -->
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
        const API_URL = '/api/dosen/persetujuan';

        async function fetchPersetujuanData(url = API_URL) {
            const tableBody = document.getElementById('persetujuan-table-body');
            tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Memuat data...</td></tr>`;

            try {
                // ==========================================================
                // === PERUBAHAN DI SINI: Hapus 'headers' authorization ===
                // ==========================================================
                const response = await axios.get(url);
                
                if (response.data.success) {
                    updateTable(response.data.data);
                    updatePagination(response.data.data);
                } else {
                    // Tangani jika API mengembalikan { success: false }
                    throw new Error(response.data.message || 'Gagal mengambil data.');
                }
            } catch (error) {
                console.error("Gagal mengambil data persetujuan:", error);
                let message = "Gagal memuat data.";
                // Periksa jika error karena otentikasi
                if (error.response && error.response.status === 401) {
                    message = "Otentikasi gagal. Silakan login kembali.";
                }
                tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-red-500">${message}</td></tr>`;
            }
        }

        function updateTable(data) {
            const tableBody = document.getElementById('persetujuan-table-body');
            tableBody.innerHTML = '';
            if (data.data.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada pengajuan yang menunggu persetujuan.</td></tr>`;
                return;
            }
            data.data.forEach((item, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${data.from + index}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${item.mahasiswa?.nama || 'N/A'}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${item.lomba?.nama_lomba || 'N/A'}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.tim?.nama_tim || 'Individu'}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                        <button class="approve-btn text-white bg-green-500 hover:bg-green-600 px-3 py-1 rounded-md" data-id="${item.id_registrasi_lomba}">Setujui</button>
                        <button class="reject-btn text-white bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md" data-id="${item.id_registrasi_lomba}">Tolak</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }
        
        document.getElementById('persetujuan-table-body').addEventListener('click', function(event) {
            const target = event.target;
            const id = target.dataset.id;
            if (!id) return;

            if (target.classList.contains('approve-btn')) {
                handleAction('setujui', id);
            } else if (target.classList.contains('reject-btn')) {
                handleAction('tolak', id);
            }
        });

        async function handleAction(action, id) {
            const url = `/api/dosen/pendaftaran/${id}/${action}`;
            const confirmationText = action === 'setujui' ? 'Anda yakin ingin menyetujui pendaftaran ini?' : 'Anda yakin ingin menolak pendaftaran ini?';

            Swal.fire({
                title: 'Konfirmasi Aksi',
                text: confirmationText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, lanjutkan!',
                cancelButtonText: 'Batal'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        // ==========================================================
                        // === PERUBAHAN DI SINI: Hapus 'headers' authorization ===
                        // ==========================================================
                        const response = await axios.patch(url, {});

                        if (response.data.success) {
                            Swal.fire('Berhasil!', response.data.message, 'success');
                            fetchPersetujuanData(); // Muat ulang data
                        } else {
                            // Tangani jika API mengembalikan { success: false }
                            throw new Error(response.data.message || 'Terjadi kesalahan.');
                        }
                    } catch (error) {
                        const errorMessage = error.response?.data?.message || 'Terjadi kesalahan saat memproses permintaan.';
                        Swal.fire('Gagal!', errorMessage, 'error');
                        console.error(`Gagal ${action} pendaftaran:`, error);
                    }
                }
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
                    if (link.active) { classes += 'bg-blue-500 text-white cursor-default'; } 
                    else if (!link.url) { classes += 'bg-gray-100 text-gray-400 cursor-not-allowed'; linkElement.disabled = true; } 
                    else { classes += 'bg-white text-gray-700 hover:bg-gray-100'; }
                    linkElement.className = classes;
                    if (link.url) {
                        linkElement.addEventListener('click', (e) => {
                            e.preventDefault();
                            fetchPersetujuanData(link.url);
                        });
                    }
                    paginationContainer.appendChild(linkElement);
                });
        }

        fetchPersetujuanData();
    });
    </script>
</body>
</html>