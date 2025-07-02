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

            <div id="pagination-container" class="flex justify-center mt-6"></div>

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
            const paginationContainer = document.getElementById("pagination-container");
            let debounceTimer;
            let currentFilterStatus = ""; // Menyimpan status filter yang sedang aktif
            let currentSearchTerm = ""; // Menyimpan kata kunci pencarian yang sedang aktif

            // === Fungsi Utama untuk Fetch dan Render Data ===
            async function fetchAllLomba(url = null) {
                tableBody.innerHTML = `<tr><td colspan="7" class="text-center p-6 text-gray-500">Memuat...</td></tr>`;

                // Jika URL tidak diberikan, buat dari filter saat ini.
                if (!url) {
                    const params = new URLSearchParams({
                        status: currentFilterStatus,
                        search: currentSearchTerm
                    }).toString();
                    url = `/api/lomba/saya?${params}`;
                }

                try {
                    const response = await axios.get(url);
                    const paginatedData = response.data.data; // Objek paginasi dari Laravel

                    // --- Render Tabel dan Paginasi ---
                    renderLombaTable(paginatedData.data); // 'data' berisi array lomba
                    renderPagination(paginatedData.links, paginatedData.total > 0); // 'links' berisi info tombol

                } catch (error) {
                    console.error("Error fetching data:", error);
                    tableBody.innerHTML = `<tr><td colspan="7" class="text-center p-6 text-red-500">Gagal memuat data.</td></tr>`;
                    paginationContainer.innerHTML = ''; // Kosongkan paginasi jika error
                }
            }

            function renderLombaTable(lombas) {
                tableBody.innerHTML = ""; // Kosongkan tabel
                if (lombas.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="7" class="text-center p-6 text-gray-500">Tidak ada lomba yang ditemukan.</td></tr>`;
                    return;
                }

                lombas.forEach((lomba) => {
                    const row = document.createElement("tr");
                    row.className = "bg-gray-50 hover:bg-gray-100";
                    const penyelenggaraNama = lomba.penyelenggara || (lomba.pembuat ? lomba.pembuat.nama : "N/A");
                    let actionButtonsHTML = "";

                    if (lomba.status === 'ditolak') {
                        actionButtonsHTML += `<button data-id="${lomba.id_lomba}" class="hapus-btn w-fit px-2 py-1 text-sm rounded-sm text-red-500 hover:bg-red-100 border border-red-500">Hapus</button>`;
                    }
                    if (['belum disetujui', 'ditolak', 'disetujui'].includes(lomba.status)) {
                        actionButtonsHTML += `<a href="/dashboard/adminlomba/lomba/edit/${lomba.id_lomba}" class="w-fit px-2 py-1 text-sm rounded-sm text-blue-500 hover:bg-blue-100 border border-blue-500">Edit</a>`;
                    }
                    actionButtonsHTML += `<a href="/dashboard/adminlomba/lomba/${lomba.id_lomba}" class="w-fit px-2 py-1 text-sm rounded-sm text-white bg-blue-500 hover:bg-blue-600">Lihat</a>`;

                    row.innerHTML = `
                    <td class="p-3 font-semibold"><a href="/dashboard/adminlomba/lomba/${lomba.id_lomba}" class="hover:underline">${lomba.nama_lomba}</a></td>
                    <td class="p-3 capitalize">${lomba.tingkat}</td>
                    <td class="p-3">${getStatusBadge(lomba.status)}</td>
                    <td class="p-3 text-center">${lomba.pendaftar_diterima}</td>
                    <td class="p-3">${formatDate(lomba.tanggal_akhir_registrasi)}</td>
                    <td class="p-3"><div class="flex gap-2 justify-end">${actionButtonsHTML}</div></td>
                `;
                    tableBody.appendChild(row);
                });
            }

            function renderPagination(links, hasData) {
                paginationContainer.innerHTML = '';
                if (!hasData || links.length <= 3) return; // Jangan render jika tidak ada data atau hanya 1 halaman

                links.forEach(link => {
                    const button = document.createElement('button');

                    // --- [PERUBAHAN UTAMA DI SINI] ---
                    let buttonContent = '';
                    let buttonTitle = ''; // Untuk aksesibilitas (tooltip)

                    if (link.label.includes('Previous')) {
                        // Jika label adalah "Previous", gunakan ikon chevron_left
                        buttonContent = `<span class="material-symbols-outlined">chevron_left</span>`;
                        buttonTitle = 'Halaman Sebelumnya';
                    } else if (link.label.includes('Next')) {
                        // Jika label adalah "Next", gunakan ikon chevron_right
                        buttonContent = `<span class="material-symbols-outlined">chevron_right</span>`;
                        buttonTitle = 'Halaman Berikutnya';
                    } else {
                        // Jika bukan keduanya (ini adalah nomor halaman), gunakan label asli
                        buttonContent = link.label;
                        buttonTitle = `Pergi ke halaman ${link.label}`;
                    }

                    button.innerHTML = buttonContent;
                    button.title = buttonTitle; // Menambahkan tooltip
                    // ------------------------------------

                    // Styling dan logika lainnya tetap sama, dengan tambahan flex untuk alignment
                    if (!link.url) { // Tombol Previous/Next yang disabled
                        button.className = 'w-10 h-10 flex items-center justify-center text-gray-400 bg-white border border-gray-300 mx-1 cursor-not-allowed rounded-full';
                        button.disabled = true;
                    } else if (link.active) { // Tombol halaman saat ini
                        button.className = 'w-10 h-10 flex items-center justify-center text-white bg-blue-500 border border-blue-500 mx-1 rounded-full';
                        button.disabled = true;
                    } else { // Tombol halaman lain yang bisa diklik
                        button.className = 'w-10 h-10 flex items-center justify-center text-gray-600 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 mx-1 rounded-full cursor-pointer';
                        button.dataset.url = link.url; // Simpan URL untuk diklik
                    }

                    paginationContainer.appendChild(button);
                });
            }

            async function renderDashboardUI() {
                try {
                    const response = await axios.get('/api/lomba/mystats');

                    if (response.data.success) {
                        const stats = response.data.data;

                        // --- 1. Isi Bagian "Ringkasan Umum" (Kartu Atas) ---
                        // ID untuk bagian ini sudah cocok.
                        document.getElementById('stats-lomba-aktif').textContent = stats.lomba_aktif ?? 0;
                        document.getElementById('stats-total-pendaftar').textContent = stats.total_pendaftar ?? 0;
                        document.getElementById('stats-disetujui').textContent = stats.disetujui ?? 0;
                        document.getElementById('stats-berlangsung').textContent = stats.berlangsung ?? 0;
                        document.getElementById('stats-selesai').textContent = stats.selesai ?? 0;

                        // --- 2. Isi Bagian "Lomba Anda" (Tombol Filter) ---
                        // [PERBAIKAN] ID untuk "Menunggu Persetujuan" disesuaikan menjadi 'count-belum_disetujui'
                        // dan kelas 'hidden' akan dihapus agar angka terlihat.

                        // Objek untuk memetakan kunci JSON ke ID elemen
                        const filterMap = {
                            'semua': stats.total_lomba,
                            'belum_disetujui': stats.menunggu_persetujuan, // Kunci JSON adalah 'menunggu_persetujuan'
                            'disetujui': stats.disetujui,
                            'berlangsung': stats.berlangsung,
                            'selesai': stats.selesai
                        };

                        // Loop melalui map untuk mengisi setiap span
                        for (const key in filterMap) {
                            const span = document.getElementById(`count-${key}`);
                            if (span) {
                                const count = filterMap[key] ?? 0;
                                span.textContent = `(${count})`;
                                span.classList.remove('hidden'); // Tampilkan angka
                            }
                        }

                    } else {
                        throw new Error(response.data.message || 'Gagal mengambil data dashboard.');
                    }
                } catch (error) {
                    console.error('Error rendering dashboard UI:', error);

                    // Blok error handling juga disesuaikan dengan ID yang benar
                    const cardStatIds = ['stats-lomba-aktif', 'stats-total-pendaftar', 'stats-disetujui', 'stats-berlangsung', 'stats-selesai'];
                    const filterStatIds = ['count-semua', 'count-belum_disetujui', 'count-disetujui', 'count-berlangsung', 'count-selesai'];

                    cardStatIds.forEach(id => {
                        const el = document.getElementById(id);
                        if (el) el.textContent = '0';
                    });

                    filterStatIds.forEach(id => {
                        const el = document.getElementById(id);
                        if (el) {
                            el.textContent = '(0)';
                            el.classList.remove('hidden'); // Pastikan angka (0) tetap terlihat saat error
                        }
                    });
                }
            }

            // === Event Listeners ===

            tableBody.addEventListener('click', async function(event) {
                const hapusButton = event.target.closest('.hapus-btn');
                if (!hapusButton) return;

                const lombaId = hapusButton.dataset.id;
                const lombaRow = hapusButton.closest('tr'); // Cari baris tabel terdekat
                const lombaNama = lombaRow.querySelector('td:first-child a').textContent.trim();

                // Tampilkan konfirmasi kepada pengguna
                if (confirm(`Apakah Anda yakin ingin menghapus lomba ${lombaNama} secara permanen? Aksi ini tidak bisa dibatalkan.`)) {
                    try {
                        // Kirim request DELETE ke API
                        const response = await axios.delete(`/api/lomba/${lombaId}`);

                        if (response.data.success) {
                            alert(response.data.message);
                            // Refresh daftar lomba untuk menampilkan perubahan
                            fetchAllLomba();
                        } else {
                            throw new Error(response.data.message);
                        }
                    } catch (error) {
                        console.error('Gagal menghapus lomba:', error);
                        alert('Gagal menghapus lomba. Silakan coba lagi.');
                    }
                }
            });

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

            paginationContainer.addEventListener('click', function(event) {
                const button = event.target.closest('button[data-url]');
                if (button) {
                    fetchAllLomba(button.dataset.url);
                }
            });

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

            searchInput.addEventListener("input", (event) => {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    currentSearchTerm = event.target.value;
                    fetchAllLomba(); // Panggil tanpa URL agar mengambil dari filter saat ini (halaman 1)
                }, 500);
            });

            // Panggil fungsi utama saat halaman dimuat
            fetchAllLomba();
            renderDashboardUI();
            // fetchDashboardStats();
            fetchLombaDitolak();
            fetchButuhPenilaian();
            // fetchMyDashboardStats();
        });
    </script>
</body>

</html>