<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/lombaku-icon.png') }}" type="image/png">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Load Chart.js -->
</head>

<body>
    <x-adminlomba-header-nav />

    <main class="lg:w-[1038px] mx-auto p-4 lg:py-10 lg:px-0 space-y-12">

        <!-- ========================================================== -->
        <!-- BAGIAN 1: RINGKASAN LOMBA SAYA (My Contests Overview) -->
        <!-- ========================================================== -->
        <section>
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
                <a href="/dashboard/adminlomba/lomba/buat" class="whitespace-nowrap py-2 px-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg flex items-center gap-2">
                    <span class="material-symbols-outlined">add</span>
                    Buat Lomba Baru
                </a>
            </div>

            <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Card Total Lomba Saya -->
                <div class="p-4 bg-gray-100 rounded-lg">
                    <p class="text-sm font-medium text-gray-600">Total Lomba Saya</p>
                    <p id="stats-total-lomba-saya" class="text-3xl font-bold text-gray-800 mt-2">...</p>
                </div>
                <!-- Card Total Pendaftar di Lomba Saya -->
                <div class="p-4 bg-gray-100 rounded-lg">
                    <p class="text-sm font-medium text-gray-600">Total Pendaftar</p>
                    <p id="stats-total-pendaftar-saya" class="text-3xl font-bold text-gray-800 mt-2">...</p>
                </div>
                <!-- Card Lomba Aktif Saya -->
                <div class="p-4 bg-gray-100 rounded-lg">
                    <p class="text-sm font-medium text-gray-600">Lomba Aktif</p>
                    <p id="stats-lomba-aktif-saya" class="text-3xl font-bold mt-2">...</p>
                </div>
                <!-- Card Lomba Selesai Saya -->
                <div class="p-4 bg-gray-100 rounded-lg">
                    <p class="text-sm font-medium text-gray-600">Lomba Selesai</p>
                    <p id="stats-selesai-saya" class="text-3xl font-bold mt-2">...</p>
                </div>
            </div>
        </section>

        <section class="col-span-4 lg:col-span-12 mt-8">
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
        </section>

        <!-- ========================================================== -->
        <!-- BAGIAN 2: PERFORMA LOMBA SAYA (My Contests Performance) -->
        <!-- ========================================================== -->
        <section>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Grafik Pendaftar per Lomba -->
                <div class="lg:col-span-8 bg-gray-100 p-4 rounded-lg ">
                    <h2 class="font-semibold text-gray-700">Jumlah Pendaftar per Lomba</h2>
                    <div class="mt-4 h-72">
                        <canvas id="pendaftarPerLombaChart"></canvas> <!-- Menggunakan Bar Chart -->
                    </div>
                </div>
                <!-- Daftar Lomba yang Sedang Berlangsung -->
                <div class="lg:col-span-4 bg-gray-100 p-4 rounded-lg">
                    <h2 class="font-semibold text-gray-700 mb-4">Sedang Berlangsung</h2>
                    <div id="berlangsung-container" class="space-y-3 max-h-72 overflow-y-auto">
                        <!-- Loading state -->
                        <p class="text-center text-gray-400 p-4">Memuat data...</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // ===============================================
            // === FUNGSI-FUNGSI UTAMA UNTUK FETCH DATA ===
            // ===============================================

            /**
             * 1. Mengambil statistik ringkas dan mengisi kartu-kartu di atas.
             */
            async function fetchMyDashboardStats() {
                try {
                    // Panggil endpoint statistik Anda
                    const response = await axios.get('/api/lomba/mystats');
                    if (!response.data.success) return;

                    const stats = response.data.data;
                    const setValue = (id, value) => {
                        const el = document.getElementById(id);
                        if (el) el.textContent = value || 0;
                    };

                    // Isi data ke setiap kartu statistik
                    // Asumsi ID di HTML sudah ada: 'stats-total-lomba-saya', 'stats-total-pendaftar-saya', dll.
                    setValue('stats-total-lomba-saya', stats.total_lomba);
                    setValue('stats-total-pendaftar-saya', stats.total_pendaftar);
                    setValue('stats-lomba-aktif-saya', stats.lomba_aktif);
                    setValue('stats-selesai-saya', stats.selesai);

                } catch (error) {
                    console.error('Error fetching dashboard stats:', error);
                    // Gagal, tampilkan tanda strip
                    ['stats-total-lomba-saya', 'stats-total-pendaftar-saya', 'stats-lomba-aktif-saya', 'stats-selesai-saya'].forEach(id => {
                        const el = document.getElementById(id);
                        if (el) el.textContent = '-';
                    });
                }
            }

            /**
             * 2. Mengambil data untuk grafik dan merendernya dengan Chart.js.
             */
            async function renderPendaftarChart() {
                const ctx = document.getElementById('pendaftarPerLombaChart');
                if (!ctx) return; // Hentikan jika elemen canvas tidak ada

                try {
                    const response = await axios.get('/api/lomba/distribusi-pendaftar');
                    if (!response.data.success) throw new Error("Data tidak valid");

                    const chartData = response.data.data;

                    // Konfigurasi Chart.js
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: chartData.labels,
                            datasets: [{
                                label: 'Jumlah Pendaftar',
                                data: chartData.data,
                                backgroundColor: 'rgba(59, 130, 246, 0.7)', // Warna biru
                                borderColor: 'rgba(59, 130, 246, 1)',
                                borderWidth: 1,
                                borderRadius: 5
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false // Sembunyikan legenda karena sudah jelas dari judul
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        // Pastikan ticks adalah integer
                                        precision: 0
                                    }
                                }
                            }
                        }
                    });

                } catch (error) {
                    console.error('Error rendering chart:', error);
                    // Tampilkan pesan error di dalam canvas
                    const container = ctx.parentElement;
                    container.innerHTML = `<p class="text-center text-red-500 p-4">Gagal memuat data grafik.</p>`;
                }
            }

            /**
             * 3. Mengambil dan menampilkan daftar lomba yang sedang berlangsung.
             */
            async function fetchLombaBerlangsung() {
                const container = document.getElementById('berlangsung-container');
                if (!container) return;

                try {
                    const response = await axios.get('/api/lomba/berlangsung');
                    container.innerHTML = ''; // Kosongkan loading state

                    if (response.data.success && response.data.data.length > 0) {
                        response.data.data.forEach(lomba => {
                            const item = document.createElement('div');
                            item.className = 'p-3 bg-white rounded-md';
                            item.innerHTML = `
                            <a href="/dashboard/adminlomba/lomba/${lomba.id_lomba}" class="font-semibold text-gray-800 hover:underline">${lomba.nama_lomba}</a>
                        `;
                            container.appendChild(item);
                        });
                    } else {
                        // Jika success: true tapi data kosong
                        container.innerHTML = `<p class="text-center text-gray-500 p-4">Tidak ada lomba yang sedang berlangsung.</p>`;
                    }

                } catch (error) {
                    // Menangkap error 404 dari controller
                    if (error.response && error.response.status === 404) {
                        container.innerHTML = `<p class="text-center text-gray-500 p-4">${error.response.data.message}</p>`;
                    } else {
                        console.error('Error fetching lomba berlangsung:', error);
                        container.innerHTML = `<p class="text-center text-red-500 p-4">Gagal memuat data.</p>`;
                    }
                }
            }

            /**
             * 4. (BONUS) Mengambil dan menampilkan 5 lomba terbaru di tabel bawah.
             */
            async function fetchRecentLombas() {
                const tableBody = document.getElementById('my-lomba-table'); // Pastikan ID tabel ini ada di HTML Anda
                if (!tableBody) return;

                try {
                    const response = await axios.get('/api/lomba/terbaru');
                    tableBody.innerHTML = ''; // Kosongkan loading state

                    if (response.data.success && response.data.data.length > 0) {
                        response.data.data.forEach(lomba => {
                            const row = document.createElement('tr');
                            row.className = 'bg-white border-b hover:bg-gray-50';

                            // Fungsi helper untuk status badge (bisa Anda buat sendiri)
                            const getStatusBadge = (status) => {
                                const statusMap = {
                                    'belum disetujui': 'bg-yellow-100 text-yellow-800',
                                    'disetujui': 'bg-green-100 text-green-800',
                                    'berlangsung': 'bg-blue-100 text-blue-800',
                                    'selesai': 'bg-gray-100 text-gray-800',
                                    'ditolak': 'bg-red-100 text-red-800'
                                };
                                return `<span class="px-2 py-1 text-xs font-medium rounded-full ${statusMap[status] || 'bg-gray-100'}">${status.replace('_', ' ')}</span>`;
                            };

                            row.innerHTML = `
                            <td class="px-6 py-4 font-semibold text-gray-800">${lomba.nama_lomba}</td>
                            <td class="px-6 py-4 capitalize text-gray-600">${lomba.tingkat}</td>
                            <td class="px-6 py-4">${getStatusBadge(lomba.status)}</td>
                            <td class="px-6 py-4 text-center text-gray-600">${lomba.registrasi_count || 0}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="/dashboard/adminlomba/lomba/${lomba.id_lomba}" class="font-medium text-blue-600 hover:underline">Detail</a>
                            </td>
                        `;
                            tableBody.appendChild(row);
                        });
                    } else {
                        tableBody.innerHTML = `<tr><td colspan="5" class="text-center p-6 text-gray-500">Anda belum membuat lomba.</td></tr>`;
                    }
                } catch (error) {
                    console.error('Error fetching recent lombas:', error);
                    tableBody.innerHTML = `<tr><td colspan="5" class="text-center p-6 text-red-500">Gagal memuat data.</td></tr>`;
                }
            }

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

            // ===============================================
            // === INISIALISASI HALAMAN ===
            // ===============================================

            // Panggil semua fungsi untuk memuat data saat halaman dibuka
            fetchLombaDitolak();
            fetchButuhPenilaian();
            fetchMyDashboardStats();
            renderPendaftarChart();
            fetchLombaBerlangsung();
            fetchRecentLombas(); // Memanggil fungsi untuk tabel bawah

        });
    </script>
</body>

</html>