<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/lombaku-icon.png') }}" type="image/png">
    <title>Dashboard Lomba</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Load Chart.js -->
</head>

<body>
    <x-kemahasiswaan-header-nav />

    <main class=" lg:w-[1038px] mx-auto p-4 lg:py-10 lg:px-0">


        <!-- lomba stats -->
        <section class="grid grid-cols-4 lg:grid-cols-12 gap-4 mt-5">
            <div class="col-span-4 w-full flex flex-col gap-4">
                <h1 class="font-semibold">Lomba</h1>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Terdaftar</h2>
                    <p id="stats-total-lomba" class="text-2xl font-semibold mt-1">...</p>
                </div>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Mahasiswa Terdaftar</h2>
                    <p id="stats-total-pendaftar" class="text-2xl font-semibold mt-1">...</p>
                </div>
            </div>
            <div class="col-span-4 w-full flex flex-col gap-4">
                <h1 class="font-semibold">Status</h1>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Butuh Persetujuan</h2>
                    <p id="stats-butuh-persetujuan" class="text-2xl font-semibold mt-1">...</p>
                </div>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Belum dimulai</h2>
                    <p id="stats-belum-dimulai" class="text-2xl font-semibold mt-1">...</p>
                </div>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Sedang Berlangsung</h2>
                    <p id="stats-berlangsung" class="text-2xl font-semibold mt-1">...</p>
                </div>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Selesai</h2>
                    <p id="stats-selesai" class="text-2xl font-semibold mt-1">...</p>
                </div>
            </div>
            <div id="butuh-persetujuan" class="col-span-4 w-full flex flex-col gap-4">
                <h1 class="font-semibold">Butuh Persetujuan</h1>
                <!-- Loading state -->
                <p id="butuh-persetujuan-loading-state" class="text-gray-500">Memuat lomba yang membutuhkan persetujuan...</p>
            </div>
        </section>

        <section class="mt-10">
            <h1 class="font-semibold">Daftar Lomba</h1>
            <div class="flex gap-2 mt-4">
                <!-- search -->
                <input type="text" id="search-lomba-input" placeholder="Cari Lomba" class="w-full p-2 border border-gray-200 rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
                <a href="/dashboard/kemahasiswaan/lomba/buat" class="whitespace-nowrap py-2 px-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">Publikasikan Lomba</a>
            </div>

            <div class="mt-4">
                <nav class="flex flex-wrap gap-2 gap-y-2 text-sm font-medium" aria-label="Tabs">
                    <button data-status="" class="filter-tab whitespace-nowrap border border-blue-500 bg-blue-100 text-blue-500 px-3 py-2 rounded-full">
                        Semua
                        <span id="count-semua" class="hidden text-xs">...</span>
                    </button>
                    <button data-status="belum disetujui" class="filter-tab whitespace-nowrap py-2 px-3 text-gray-500 border border-gray-300 hover:bg-gray-100 rounded-full">
                        Butuh Persetujuan
                        <span id="count-belum_disetujui" class="hidden text-xs">...</span>
                    </button>
                    <button data-status="disetujui" class="filter-tab whitespace-nowrap py-2 px-3 text-gray-500 border border-gray-300 hover:bg-gray-100 rounded-full">
                        Disetujui
                        <span id="count-disetujui" class="hidden text-xs">...</span>
                    </button>
                    <button data-status="berlangsung" class="filter-tab whitespace-nowrap py-2 px-3 text-gray-500 border border-gray-300 hover:bg-gray-100 rounded-full">
                        Berlangsung
                        <span id="count-berlangsung" class="hidden text-xs">...</span>
                    </button>
                    <button data-status="selesai" class="filter-tab whitespace-nowrap py-2 px-3 text-gray-500 border border-gray-300 hover:bg-gray-100 rounded-full">
                        Selesai
                        <span id="count-selesai" class="hidden text-xs">...</span>
                    </button>
                </nav>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="lg:w-full rounded-lg overflow-hidden table-auto">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-100">
                        <tr class="">
                            <th class="p-3 text-left font-medium">Nama Lomba</th>
                            <th class="p-3 text-left font-medium">Tingkat</th>
                            <th class="p-3 text-left font-medium">Status</th>
                            <th class="p-3 text-left font-medium">Pendaftar</th>
                            <th class="p-3 text-left font-medium">Tanggal Akhir Daftar</th>
                            <th class="p-3 text-left font-medium">Penyelenggara</th>
                            <th class="p-3 text-left font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <!-- ID ditambahkan di sini. Konten akan diisi oleh JavaScript -->
                    <tbody id="lomba-table-body">
                        <!-- Loading state -->
                        <tr>
                            <td colspan="8" class="text-center p-6 text-gray-500">
                                Memuat data lomba...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="pagination-container" class="flex justify-center mt-6"></div>

        </section>
    </main>

    <!-- Modal untuk Alasan Penolakan -->
    <div id="tolak-lomba-modal" class="fixed inset-0 bg-black/40 overflow-y-auto h-full w-full flex items-center justify-center hidden">
        <div class="relative w-full max-w-md shadow-lg rounded-md bg-white p-4 mx-5 lg:mx-auto">
            <h3 class="text-lg font-medium text-gray-900">Alasan Penolakan</h3>
            <form id="tolak-lomba-form" class="">
                <input type="hidden" id="tolak-lomba-id">
                <textarea id="alasan-penolakan-textarea" rows="2" class="mt-2 w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan alasan penolakkan lomba" required></textarea>
                <div class="items-center flex justify-end gap-2 mt-2">
                    <button id="batal-tolak-btn" type="button" class="px-4 py-2 rounded-md hover:bg-gray-100 text-black border border-gray-300">Batal</button>
                    <button id="kirim-penolakan-btn" type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Tolak</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal untuk Konfirmasi Persetujuan -->
    <div id="setujui-lomba-modal" class="fixed inset-0 bg-black/40 overflow-y-auto h-full w-full flex items-center justify-center hidden">
        <div class="relative w-full max-w-md shadow-lg rounded-md bg-white p-4 mx-5 lg:mx-auto">
            <h3 class="text-lg font-medium text-gray-900">Konfirmasi Persetujuan</h3>
            <form id="setujui-lomba-form" class="">
                <input type="hidden" id="setujui-lomba-id">
                <p class="mt-2 text-gray-600">Apakah Anda yakin ingin menyetujui lomba ini? Tindakan ini tidak dapat dibatalkan.</p>
                <div class="items-center flex justify-end gap-2 mt-4">
                    <button id="batal-setujui-btn" type="button" class="px-4 py-2 rounded-md hover:bg-gray-100 text-black border border-gray-300">Batal</button>
                    <button id="kirim-persetujuan-btn" type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Ya, Setujui</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // --- Variabel dan Elemen DOM ---
            const butuhPersetujuanSection = document.getElementById('butuh-persetujuan');
            const tableBody = document.getElementById("lomba-table-body");
            const searchInput = document.getElementById("search-lomba-input");
            let debounceTimer;
            let currentFilterStatus = ""; // Menyimpan status filter aktif
            let currentSearchTerm = ""; // Menyimpan kata kunci pencarian aktif
            const filterTabs = document.querySelectorAll(".filter-tab");
            const paginationContainer = document.getElementById("pagination-container");

            // Modal Penolakan
            const tolakLombaModal = document.getElementById('tolak-lomba-modal');
            const tolakLombaForm = document.getElementById('tolak-lomba-form');
            const tolakLombaIdInput = document.getElementById('tolak-lomba-id');
            const alasanTextarea = document.getElementById('alasan-penolakan-textarea');
            const batalTolakBtn = document.getElementById('batal-tolak-btn');

            // --- PERUBAHAN: Variabel untuk Modal Persetujuan ---
            const setujuiLombaModal = document.getElementById('setujui-lomba-modal');
            const setujuiLombaForm = document.getElementById('setujui-lomba-form');
            const setujuiLombaIdInput = document.getElementById('setujui-lomba-id');
            const batalSetujuiBtn = document.getElementById('batal-setujui-btn');

            // Helper functions (tetap sama)
            function formatDate(dateString) {
                if (!dateString) return "-";
                const options = {
                    year: "numeric",
                    month: "2-digit",
                    day: "2-digit"
                };
                return new Date(dateString).toLocaleDateString("id-ID", options);
            }

            function getStatusBadge(status) {
                const statusMap = {
                    'belum disetujui': 'bg-yellow-100 text-yellow-800',
                    'disetujui': 'bg-green-100 text-green-800',
                    'berlangsung': 'bg-blue-100 text-blue-800',
                    'selesai': 'bg-gray-100 text-gray-800',
                    'ditolak': 'bg-red-100 text-red-800'
                };
                const statusText = status.replace(/_/g, " ").split(" ").map(s => s.charAt(0).toUpperCase() + s.slice(1)).join(" ");
                return `<span class="px-2 py-1 text-xs font-medium rounded-md whitespace-nowrap ${statusMap[status] || 'bg-gray-100'}">${statusText}</span>`;
            }

            function capitalizeFirstLetter(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }

            // === Fungsi Utama untuk Fetch dan Render Data ===
            async function fetchAllLomba(url = null) {
                tableBody.innerHTML = `<tr><td colspan="7" class="text-center p-6 text-gray-500">Memuat...</td></tr>`;

                if (!url) {
                    const params = new URLSearchParams({
                        status: currentFilterStatus,
                        search: currentSearchTerm
                    }).toString();
                    url = `/api/lomba?${params}`;
                }

                try {
                    const response = await axios.get(url);
                    const paginatedData = response.data.data;

                    renderLombaTable(paginatedData.data);
                    renderPagination(paginatedData.links, paginatedData.total > 0);

                } catch (error) {
                    console.error("Error fetching data:", error);
                    tableBody.innerHTML = `<tr><td colspan="7" class="text-center p-6 text-red-500">Gagal memuat data.</td></tr>`;
                    paginationContainer.innerHTML = '';
                }
            }

            function renderLombaTable(lombas) {
                tableBody.innerHTML = "";
                if (lombas.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="7" class="text-center p-6 text-gray-500">Tidak ada lomba yang ditemukan.</td></tr>`;
                    return;
                }

                lombas.forEach((lomba) => {
                    const row = document.createElement("tr");
                    row.className = "bg-gray-50 hover:bg-gray-100";
                    const penyelenggaraNama = lomba.penyelenggara || (lomba.pembuat ? lomba.pembuat.nama : "N/A");

                    // --- PERUBAHAN UTAMA DIMULAI DI SINI ---

                    // 1. Siapkan variabel untuk menampung HTML tombol aksi
                    let actionButtonsHTML = '';

                    // 2. Cek status lomba
                    if (lomba.status === 'belum disetujui') {
                        // Jika butuh persetujuan, tambahkan tombol Tolak & Setujui
                        // Class 'tolak-lomba-btn' dan 'setujui-lomba-btn' penting agar event listener berfungsi
                        actionButtonsHTML = `
                <button class="py-1 px-2 text-red-500 border border-red-500 rounded-sm text-sm hover:bg-red-100 tolak-lomba-btn" data-id="${lomba.id_lomba}">Tolak</button>
                <button class="setujui-lomba-btn w-fit px-2 py-1 text-sm rounded-sm text-white bg-blue-500 hover:bg-blue-600 cursor-pointer" data-id="${lomba.id_lomba}">Setujui</button>
                <a href="/dashboard/kemahasiswaan/lomba/${lomba.id_lomba}" class="w-fit px-2 py-1 text-sm rounded-sm text-blue border border-blue-500 hover:bg-blue-100 text-blue-500">Lihat</a>
            `;
                    } else {
                        // Untuk status lainnya, tampilkan tombol Lihat
                        actionButtonsHTML = `
                <a href="/dashboard/kemahasiswaan/lomba/${lomba.id_lomba}" class="w-fit px-2 py-1 text-sm rounded-sm text-blue border border-blue-500 hover:bg-blue-100 text-blue-500">Lihat</a>
            `;
                    }

                    // 3. Masukkan HTML baris tabel dengan tombol aksi yang sudah disiapkan
                    row.innerHTML = `
            <td class="p-3 font-semibold">
                <a href="/dashboard/kemahasiswaan/lomba/${lomba.id_lomba}" class="hover:underline">${lomba.nama_lomba}</a>
            </td>
            <td class="p-3 capitalize">${lomba.tingkat}</td>
            <td class="p-3">${getStatusBadge(lomba.status)}</td>
            <td class="p-3 text-center">${lomba.registrasi_count}</td>
            <td class="p-3">${formatDate(lomba.tanggal_akhir_registrasi)}</td>
            <td class="p-3">${penyelenggaraNama}</td>
            <td class="p-3">
                <div class="flex gap-2 justify-end">
                    ${actionButtonsHTML}
                </div>
            </td>
        `;
                    // --- AKHIR PERUBAHAN ---

                    tableBody.appendChild(row);
                });
            }

            function renderPagination(links, hasData) {
                paginationContainer.innerHTML = '';
                if (!hasData || links.length <= 3) return;

                links.forEach(link => {
                    const button = document.createElement('button');
                    let buttonContent = link.label.includes('Previous') ? `<span class="material-symbols-outlined">chevron_left</span>` :
                        link.label.includes('Next') ? `<span class="material-symbols-outlined">chevron_right</span>` : link.label;

                    button.innerHTML = buttonContent;

                    if (!link.url) {
                        button.className = 'w-10 h-10 flex items-center justify-center text-gray-400 bg-white border border-gray-300 mx-1 cursor-not-allowed rounded-full';
                        button.disabled = true;
                    } else if (link.active) {
                        button.className = 'w-10 h-10 flex items-center justify-center text-white bg-blue-500 border border-blue-500 mx-1 rounded-full';
                        button.disabled = true;
                    } else {
                        button.className = 'w-10 h-10 flex items-center justify-center text-gray-600 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 mx-1 rounded-full cursor-pointer';
                        button.dataset.url = link.url;
                    }

                    paginationContainer.appendChild(button);
                });
            }

            // Fungsi baru untuk mengambil dan menampilkan statistik
            async function fetchDashboardStats() {
                try {
                    // LANGSUNG panggil endpoint statistik, tanpa ID
                    const response = await axios.get('/api/lomba/stats');

                    if (response.data.success) {
                        const stats = response.data.data;

                        // Isi data statistik
                        document.getElementById('stats-total-lomba').textContent = stats.total_lomba;
                        document.getElementById('stats-total-pendaftar').textContent = stats.total_pendaftar;

                        // Isi data status
                        document.getElementById('stats-butuh-persetujuan').textContent = stats.status_counts.belum_disetujui;
                        document.getElementById('stats-belum-dimulai').textContent = stats.status_counts.disetujui;
                        document.getElementById('stats-berlangsung').textContent = stats.status_counts.berlangsung;
                        document.getElementById('stats-selesai').textContent = stats.status_counts.selesai;
                    } else {
                        // Jika API mengembalikan success: false
                        throw new Error(response.data.message || 'Gagal mengambil statistik');
                    }
                } catch (error) {
                    console.error('Error fetching dashboard stats:', error);
                    // Tampilkan tanda strip jika gagal total
                    const ids = ['stats-total-lomba', 'stats-total-pendaftar', 'stats-butuh-persetujuan', 'stats-belum-dimulai', 'stats-berlangsung', 'stats-selesai'];
                    ids.forEach(id => {
                        const el = document.getElementById(id);
                        if (el) el.textContent = '-';
                    });
                }
            }

            async function fetchLombaButuhPersetujuan() {
                const loadingState = document.getElementById('butuh-persetujuan-loading-state');

                try {
                    const response = await axios.get('/api/lomba/butuh-persetujuan');

                    if (response.data.success) {
                        const lombaButuhPersetujuan = response.data.data;
                        if (loadingState) loadingState.remove();

                        lombaButuhPersetujuan.forEach((lomba) => {
                            const lombaElement = document.createElement('div');
                            lombaElement.className = 'flex items-center gap-2 p-3 bg-gray-100 rounded-lg';

                            // --- PERUBAHAN DI SINI ---
                            // Hapus onclick dan tambahkan class + atribut data-*
                            lombaElement.innerHTML = `
                        <div class="flex-1">
                            <a href="/dashboard/kemahasiswaan/lomba/${lomba.id_lomba}" class="text-base font-medium hover:underline">${lomba.nama_lomba}</a>
                            <p class="text-xs text-black/50">${lomba.penyelenggara || (lomba.pembuat ? lomba.pembuat.nama : "N/A")}</p>
                        </div>
                        <div class="flex items-center gap-1">
                            <button class="py-1 px-2 text-red-500 border border-red-500 rounded-sm text-sm hover:bg-red-100 tolak-lomba-btn" data-id="${lomba.id_lomba}">Tolak</button>
                            <button class="py-1 px-2 bg-blue-500 text-white rounded-sm text-sm hover:bg-blue-600 setujui-lomba-btn" data-id="${lomba.id_lomba}">Setujui</button>
                        </div>
                    `;
                            // --- AKHIR PERUBAHAN ---
                            butuhPersetujuanSection.appendChild(lombaElement);
                        });
                    }
                } catch (error) {
                    if (error.response && error.response.status === 404) {
                        loadingState.textContent = error.response.data.message || 'Tidak ada lomba yang butuh persetujuan.';
                    } else {
                        loadingState.textContent = 'Gagal memuat data. Silakan coba lagi.';
                    }
                }
            }

            async function submitPersetujuan(lombaId) {
                try {
                    await axios.patch(`/api/lomba/${lombaId}/setujui`);
                    alert('Lomba berhasil disetujui!');
                    location.reload();
                } catch (error) {
                    const errorMessage = error.response?.data?.message || 'Terjadi kesalahan saat menyetujui lomba.';
                    alert(errorMessage);
                }
            }

            // Fungsi baru untuk menangani penolakan lomba
            async function submitPenolakan(lombaId, alasan) {
                try {
                    await axios.patch(
                        `/api/lomba/${lombaId}/tolak`, {
                            alasan_penolakan: alasan
                        }
                    );

                    alert('Lomba berhasil ditolak.');
                    location.reload();

                } catch (error) {
                    const errorMessage = error.response?.data?.message || 'Terjadi kesalahan.';
                    alert(errorMessage);
                }
            }

            filterTabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    filterTabs.forEach(t => {
                        t.classList.remove('bg-blue-100', 'text-blue-500', 'border-blue-500');
                        t.classList.add('text-gray-500', 'border-gray-300', 'hover:bg-gray-100');
                    });
                    tab.classList.remove('text-gray-500', 'border-gray-300', 'hover:bg-gray-100');
                    tab.classList.add('bg-blue-100', 'text-blue-500', 'border-blue-500');

                    currentFilterStatus = tab.dataset.status;
                    fetchAllLomba(); // Panggil tanpa URL agar mengambil dari filter saat ini (halaman 1)
                });
            });

            // --- Fungsi Kontrol Modal ---
            function showTolakModal(lombaId) {
                tolakLombaIdInput.value = lombaId;
                tolakLombaModal.classList.remove('hidden');
            }

            function hideTolakModal() {
                tolakLombaForm.reset();
                tolakLombaModal.classList.add('hidden');
            }

            function showSetujuiModal(lombaId) {
                setujuiLombaIdInput.value = lombaId;
                setujuiLombaModal.classList.remove('hidden');
            }

            function hideSetujuiModal() {
                setujuiLombaModal.classList.add('hidden');
            }

            // === Event Listeners ===

            butuhPersetujuanSection.addEventListener('click', function(event) {
                const setujuiButton = event.target.closest('.setujui-lomba-btn');
                const tolakButton = event.target.closest('.tolak-lomba-btn');

                if (setujuiButton) {
                    const lombaId = setujuiButton.dataset.id;
                    showSetujuiModal(lombaId); // <-- PERUBAHAN: Tampilkan modal, bukan langsung API call
                } else if (tolakButton) {
                    const lombaId = tolakButton.dataset.id;
                    showTolakModal(lombaId);
                }
            });

            // Event listener untuk form penolakan
            tolakLombaForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const lombaId = tolakLombaIdInput.value;
                const alasan = alasanTextarea.value.trim();
                if (alasan) {
                    submitPenolakan(lombaId, alasan);
                } else {
                    alert('Alasan penolakan tidak boleh kosong.');
                }
            });

            setujuiLombaForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const lombaId = setujuiLombaIdInput.value;
                submitPersetujuan(lombaId);
            });
            batalSetujuiBtn.addEventListener('click', hideSetujuiModal);

            // Event listener untuk tombol batal di modal
            batalTolakBtn.addEventListener('click', hideTolakModal);

            // Listener untuk pencarian dengan debounce
            searchInput.addEventListener("input", (event) => {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    currentSearchTerm = event.target.value;
                    fetchAllLomba(); // Panggil tanpa URL
                }, 500);
            });

            paginationContainer.addEventListener('click', function(event) {
                const button = event.target.closest('button[data-url]');
                if (button) {
                    fetchAllLomba(button.dataset.url);
                }
            });

            tableBody.addEventListener('click', function(event) {
                const setujuiButton = event.target.closest('.setujui-lomba-btn');
                const tolakButton = event.target.closest('.tolak-lomba-btn');

                if (setujuiButton) {
                    const lombaId = setujuiButton.dataset.id;
                    showSetujuiModal(lombaId);
                } else if (tolakButton) {
                    const lombaId = tolakButton.dataset.id;
                    showTolakModal(lombaId);
                }
            });

            // Panggil fungsi utama saat halaman dimuat
            fetchAllLomba();
            fetchDashboardStats();
            fetchLombaButuhPersetujuan();
        });
    </script>
</body>

</html>