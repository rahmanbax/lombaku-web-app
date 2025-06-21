<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Load Chart.js -->
</head>

<body>
    <x-adminlomba-header-nav />

    <main class=" lg:w-[1038px] mx-auto p-4 lg:py-10 lg:px-0">


        <!-- lomba stats -->
        <section class="grid grid-cols-4 lg:grid-cols-12 gap-4 mt-5">
            <div class="col-span-4 lg:col-span-12">
                <h2 class="text-lg font-semibold mb-3">Ringkasan Umum</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <div class="bg-gray-100 p-3 rounded-lg">
                        <h3 class="text-sm font-medium text-black/60">Lomba Aktif</h3>
                        <p id="stats-lomba-aktif" class="text-2xl font-semibold mt-1">...</p>
                    </div>
                    <div class="bg-gray-100 p-3 rounded-lg">
                        <h3 class="text-sm font-medium text-black/60">Total Pendaftar</h3>
                        <p id="stats-total-pendaftar" class="text-2xl font-semibold mt-1">...</p>
                    </div>
                    <div class="bg-gray-100 p-3 rounded-lg">
                        <h3 class="text-sm font-medium text-black/60">Disetujui</h3>
                        <p id="stats-disetujui" class="text-2xl font-semibold mt-1">...</p>
                    </div>
                    <div class="bg-gray-100 p-3 rounded-lg">
                        <h3 class="text-sm font-medium text-black/60">Berlangsung</h3>
                        <p id="stats-berlangsung" class="text-2xl font-semibold mt-1">...</p>
                    </div>
                    <div class="bg-gray-100 p-3 rounded-lg">
                        <h3 class="text-sm font-medium text-black/60">Selesai</h3>
                        <p id="stats-selesai" class="text-2xl font-semibold mt-1">...</p>
                    </div>
                </div>
            </div>

            <div class="col-span-4 lg:col-span-12 mt-8">
                <h2 class="text-lg font-semibold mb-3">Ringkasan Lomba</h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <!-- Kolom untuk Lomba Ditolak/Butuh Revisi -->
                    <div>
                        <h3 class="font-medium text-gray-800 mb-2">
                            <span class="material-symbols-outlined text-red-600 align-middle mr-1">error</span>
                            Lomba Ditolak
                        </h3>
                        <div id="revisi-container" class="bg-gray-100 p-2 rounded-lg flex flex-col gap-2">
                            <!-- Loading state -->
                            <p id="revisi-loading" class="text-gray-500 text-center p-4">Memuat data...</p>
                            <!-- Data Lomba Ditolak akan diisi oleh JS -->
                        </div>
                    </div>

                    <!-- Kolom untuk Submission Butuh Penilaian -->
                    <div>
                        <h3 class="font-medium text-gray-800 mb-2">
                            <span class="material-symbols-outlined text-blue-600 align-middle mr-1">rate_review</span>
                            Butuh Penilaian
                        </h3>
                        <div id="penilaian-container" class="bg-gray-100 p-2 rounded-lg flex flex-col gap-2">
                            <!-- Loading state -->
                            <p id="penilaian-loading" class="text-gray-500 text-center p-4">Memuat data...</p>
                            <!-- Data Submission akan diisi oleh JS -->
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="mt-10">
            <h1 class="font-semibold">Lomba Anda</h1>
            <div class="flex gap-2 mt-4">
                <!-- search -->
                <input type="text" id="search-lomba-input" placeholder="Cari Lomba" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
                <a href="/dashboard/adminlomba/lomba/buat" class="whitespace-nowrap py-2 px-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">+ Publikasikan Lomba</a>
            </div>

            <div class="mt-4">
                <nav class="flex flex-wrap gap-2 gap-y-2 text-sm font-medium" aria-label="Tabs">
                    <!-- Tombol filter, data-status digunakan oleh JS untuk mengetahui filter apa yang harus diterapkan -->
                    <button data-status="" class="filter-tab whitespace-nowrap border border-blue-500 bg-blue-100 text-blue-500 px-3 py-2 rounded-full">
                        Semua
                        <span id="count-semua" class="hidden text-xs">...</span>
                    </button>
                    <button data-status="belum disetujui" class="filter-tab whitespace-nowrap py-2 px-3 text-gray-500 border border-gray-300 hover:bg-gray-100 rounded-full">
                        Menunggu Persetujuan
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
                        <tr>
                            <th class="p-3 text-left font-medium">Nama Lomba</th>
                            <th class="p-3 text-left font-medium">Tingkat</th>
                            <th class="p-3 text-left font-medium">Status</th>
                            <th class="p-3 text-center font-medium">Pendaftar</th>
                            <th class="p-3 text-left font-medium">Tgl Akhir Daftar</th>
                            <th class="p-3 text-left font-medium">Penyelenggara</th>
                            <th class="p-3 text-center font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="lomba-table-body">
                        <tr>
                            <td colspan="6" class="text-center p-6 text-gray-500">
                                Memuat data lomba...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </section>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
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
                const statusText = status.replace(/_/g, " ").split(" ").map(capitalizeFirstLetter).join(" ");
                return `<span class="px-2 py-1 text-xs font-medium rounded-md whitespace-nowrap ${statusMap[status] || 'bg-gray-100'}">${capitalizeFirstLetter(statusText)}</span>`;
            }

            function getActionButtons(lomba) {
                let buttons = '';

                // Tombol Lihat Detail selalu ada
                buttons += `<a href="/dashboard/adminlomba/lomba/${lomba.id_lomba}" class="text-gray-600 hover:text-blue-600" title="Lihat Detail"><span class="material-symbols-outlined">visibility</span></a>`;

                // Tombol Edit hanya jika belum berlangsung/selesai
                if (!['berlangsung', 'selesai'].includes(lomba.status)) {
                    buttons += `<a href="/dashboard/adminlomba/lomba/edit/${lomba.id_lomba}" class="text-gray-600 hover:text-yellow-600" title="Edit"><span class="material-symbols-outlined">edit</span></a>`;
                }

                return `<div class="flex items-center justify-center gap-3">${buttons}</div>`;
            }

            function capitalizeFirstLetter(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }

            // === Variabel dan Elemen DOM ===
            const tableBody = document.getElementById("lomba-table-body");
            const searchInput = document.getElementById("search-lomba-input");
            const filterTabs = document.querySelectorAll(".filter-tab");
            let debounceTimer;
            let currentFilterStatus = ""; // Menyimpan status filter yang sedang aktif
            let currentSearchTerm = ""; // Menyimpan kata kunci pencarian yang sedang aktif

            // === Fungsi Utama untuk Fetch dan Render Data ===
            async function fetchAllLomba(searchTerm = "") {
                tableBody.innerHTML = `<tr><td colspan="7" class="text-center p-6 text-gray-500">Memuat...</td></tr>`;

                try {
                    const params = new URLSearchParams({
                        status: currentFilterStatus,
                        search: currentSearchTerm
                    }).toString();

                    const url = `/api/lomba/saya?${params}`;
                    const response = await axios.get(url); // Auth token di-handle oleh middleware di sisi server
                    const lombas = response.data.data;

                    tableBody.innerHTML = ""; // Kosongkan tabel

                    if (lombas.length === 0) {
                        tableBody.innerHTML = `<tr><td colspan="7" class="text-center p-6 text-gray-500">Tidak ada lomba yang ditemukan.</td></tr>`;
                        return;
                    }

                    lombas.data.forEach((lomba) => {
                        const row = document.createElement("tr");
                        row.className = "bg-gray-50 hover:bg-gray-100";

                        const penyelenggaraNama = lomba.penyelenggara || (lomba.pembuat ? lomba.pembuat.nama : "N/A");

                        // --- INI ADALAH PERUBAHAN UTAMA UNTUK KOLOM AKSI ---
                        let actionButtonsHTML = "";

                        // cek status
                        if (lomba.status === 'belum disetujui' || lomba.status === 'ditolak' || lomba.status === 'disetujui') {
                            // 3. Jika kondisi terpenuhi, tambahkan tombol Edit
                            actionButtonsHTML += `
                                <a href="/dashboard/adminlomba/lomba/edit/${lomba.id_lomba}" class="w-fit px-2 py-1 text-sm rounded-sm text-blue-500 hover:bg-blue-100 border border-blue-500">Edit</a>
                            `;
                        }

                        // Tombol lihat detail
                        actionButtonsHTML += `
                            <a href="/dashboard/adminlomba/lomba/${lomba.id_lomba}" class="w-fit px-2 py-1 text-sm rounded-sm text-white bg-blue-500 hover:bg-blue-600">Lihat</a>
                        `;

                        row.innerHTML = `
                            <td class="p-3 font-semibold">
                                <a href="/dashboard/admin-lomba/lomba/${lomba.id_lomba}" class="hover:underline">${lomba.nama_lomba}</a>
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
                        tableBody.appendChild(row);
                    });
                } catch (error) {
                    console.error("Error fetching data:", error);
                    tableBody.innerHTML = `<tr><td colspan="7" class="text-center p-6 text-red-500">Gagal memuat data.</td></tr>`;
                }
            }

            // Fungsi baru untuk mengambil dan menampilkan statistik
            async function fetchDashboardStats() {
                try {
                    // LANGSUNG panggil endpoint statistik, tanpa ID
                    const response = await axios.get('/api/lomba/stats');

                    if (response.data.success) {
                        const stats = response.data.data;

                        let totalLomba = 0;
                        for (const status in stats.status_counts) {
                            const count = stats.status_counts[status] || 0;
                            const span = document.getElementById(`count-${status.replace(' ', '_')}`);
                            if (span) {
                                span.textContent = `(${count})`;
                                span.classList.remove('hidden');
                            }
                            totalLomba += count;
                        }
                        const spanSemua = document.getElementById('count-semua');
                        spanSemua.textContent = `(${totalLomba})`;
                        spanSemua.classList.remove('hidden');
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

            async function fetchMyDashboardStats() {
                try {
                    // Panggil endpoint statistik pribadi yang baru
                    const response = await axios.get('/api/lomba/mystats');

                    if (response.data.success) {
                        const stats = response.data.data;

                        // === PENGISIAN DATA SECARA MANUAL ===

                        // Ambil setiap elemen berdasarkan ID-nya dan isi dengan data yang sesuai
                        document.getElementById('stats-lomba-aktif').textContent = stats.lomba_aktif;

                        document.getElementById('stats-total-pendaftar').textContent = stats.total_pendaftar;

                        document.getElementById('stats-disetujui').textContent = stats.disetujui;

                        document.getElementById('stats-berlangsung').textContent = stats.berlangsung;

                        document.getElementById('stats-selesai').textContent = stats.selesai;

                    } else {
                        // Jika API mengembalikan success: false, lempar error untuk ditangkap di blok catch
                        throw new Error(response.data.message || 'Gagal mengambil statistik pribadi.');
                    }
                } catch (error) {
                    console.error('Error fetching my dashboard stats:', error);

                    // Jika terjadi error, tampilkan tanda strip pada semua statistik
                    // Ini tetap menggunakan array untuk efisiensi di blok error handling
                    const ids = ['stats-lomba-aktif', 'stats-total-pendaftar', 'stats-disetujui', 'stats-berlangsung', 'stats-selesai'];
                    ids.forEach(id => {
                        const el = document.getElementById(id);
                        if (el) {
                            el.textContent = '-';
                        }
                    });
                }
            }

            // === Event Listeners ===

            // Listener untuk tab filter
            filterTabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    // 1. Loop semua tab untuk mengaturnya ke state "tidak aktif"
                    filterTabs.forEach(t => {
                        t.classList.remove('bg-blue-100', 'text-blue-500', 'border-blue-500');
                        t.classList.add('text-gray-500', 'border-gray-300', 'hover:bg-gray-100');
                    });

                    // 2. Atur tab yang diklik ke state "aktif"
                    tab.classList.remove('text-gray-500', 'border-gray-300', 'hover:bg-gray-100');
                    tab.classList.add('bg-blue-100', 'text-blue-500', 'border-blue-500');

                    // 3. Set filter status dan panggil API
                    currentFilterStatus = tab.dataset.status;
                    fetchAllLomba();
                });
            });

            // Listener untuk pencarian dengan debounce
            searchInput.addEventListener("input", (event) => {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    currentSearchTerm = event.target.value; // Memperbarui variabel global
                    fetchAllLomba(); // Memanggil fungsi (tanpa parameter)
                }, 500);
            });

            async function fetchLombaDitolak() {
                const container = document.getElementById('revisi-container');
                const loading = document.getElementById('revisi-loading');

                try {
                    // Anda perlu membuat endpoint API ini: GET /api/lomba/ditolak
                    const response = await axios.get('/api/lomba/ditolak');

                    if (response.data.success && response.data.data.length > 0) {
                        loading.remove(); // Hapus pesan loading
                        response.data.data.forEach(lomba => {
                            const item = document.createElement('div');
                            item.className = 'p-3 bg-white rounded-md flex justify-between items-center';
                            item.innerHTML = `
                        <div>
                            <p class="font-semibold">${lomba.nama_lomba}</p>
                            <p class="text-xs text-gray-500">Alasan Penolakan: ${lomba.alasan_penolakan}</p>
                        </div>
                        <a href="/dashboard/adminlomba/lomba/edit/${lomba.id_lomba}" class="text-sm text-blue-500 hover:underline font-medium">Revisi</a>
                    `;
                            container.appendChild(item);
                        });
                    } else {
                        loading.textContent = 'Tidak ada lomba yang perlu direvisi.';
                    }
                } catch (error) {
                    console.error('Error fetching lomba ditolak:', error);
                    if (error.response && error.response.status === 404) {
                        loading.textContent = 'Tidak ada lomba yang perlu direvisi.';
                    } else {
                        loading.textContent = 'Gagal memuat data.';
                    }
                }
            }

            // === Fungsi untuk mengambil dan merender SUBMISSION BUTUH PENILAIAN ===
            async function fetchButuhPenilaian() {
                const container = document.getElementById('penilaian-container');
                const loading = document.getElementById('penilaian-loading');

                try {
                    // Anda perlu membuat endpoint API ini: GET /api/submission/butuh-penilaian
                    const response = await axios.get('/api/submission/butuh-penilaian');



                    if (response.data.success && response.data.data.length > 0) {
                        loading.remove(); // Hapus pesan loading
                        response.data.data.forEach(lomba => {
                            // 2. Buat elemen card untuk setiap lomba
                            const lombaCard = document.createElement('div');
                            lombaCard.className = 'p-3 bg-white rounded-md'; // Card utama untuk satu lomba

                            // 3. Buat HTML untuk header card (nama lomba)
                            let cardHTML = `<p class="font-semibold border-b border-gray-300 pb-2 mb-2">${lomba.nama_lomba}</p>`;

                            // 4. Buat daftar (ul) untuk menampung peserta
                            const pesertaList = document.createElement('ul');
                            pesertaList.className = 'space-y-2';

                            // 5. Loop pada setiap PESERTA di dalam lomba
                            lomba.peserta.forEach(peserta => {
                                // Buat list item (li) untuk setiap peserta
                                const pesertaItem = document.createElement('li');
                                pesertaItem.className = 'flex justify-between items-center';

                                pesertaItem.innerHTML = `
                        <span class="text-sm text-gray-700">${peserta.nama_mahasiswa}</span>
                        <a href="/dashboard/adminlomba/lomba/${lomba.id_lomba}" class="text-sm text-blue-500 hover:underline font-medium">Nilai</a>
                    `;

                                pesertaList.appendChild(pesertaItem);
                            });

                            // 6. Masukkan daftar peserta ke dalam HTML card
                            lombaCard.innerHTML = cardHTML;
                            lombaCard.appendChild(pesertaList);

                            // 7. Masukkan card lomba yang sudah lengkap ke kontainer utama
                            container.appendChild(lombaCard);
                        });
                    } else {
                        loading.textContent = 'Tidak ada peserta yang perlu dinilai.';
                    }
                } catch (error) {
                    console.error('Error fetching butuh penilaian:', error);
                    if (error.response && error.response.status === 404) {
                        loading.textContent = 'Tidak ada submission yang perlu dinilai.';
                    } else {
                        loading.textContent = 'Gagal memuat data.';
                    }
                }
            }

            // Panggil fungsi utama saat halaman dimuat
            fetchAllLomba();
            fetchDashboardStats();
            fetchLombaDitolak();
            fetchButuhPenilaian();
            fetchMyDashboardStats();
        });
    </script>
</body>

</html>