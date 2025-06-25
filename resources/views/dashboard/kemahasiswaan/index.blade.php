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
    <x-kemahasiswaan-header-nav />

    <main class=" lg:w-[1038px] mx-auto p-4 lg:py-10 lg:px-0">
        <div class="flex items-center justify-between">
            <h1 class="font-semibold">Lomba</h1>
            <a href="/dashboard/kemahasiswaan/lomba" class="flex items-center font-semibold text-blue-500">Lihat <span class="material-symbols-outlined">chevron_right</span></a>
        </div>

        <!-- lomba stats -->
        <section class="grid place-items-center grid-cols-4 lg:grid-cols-12 gap-4 mt-5">
            <div class="bg-gray-100 col-span-2 lg:col-span-3 w-full rounded-lg overflow-hidden">
                <div class="p-3">
                    <h2 class="text-sm font-medium text-black/60">Jumlah Lomba</h2>
                    <p id="lomba-stats-total" class="text-2xl font-semibold mt-1">...</p>
                </div>
            </div>
            <div class="bg-gray-100 col-span-2 lg:col-span-3 w-full rounded-lg overflow-hidden">
                <div class="p-3">
                    <h2 class="text-sm font-medium text-black/60">Butuh Persetujuan</h2>
                    <p id="lomba-stats-approval" class="text-2xl font-semibold mt-1">...</p>
                </div>
            </div>
            <div class="bg-gray-100 col-span-2 lg:col-span-3 w-full rounded-lg overflow-hidden">
                <div class="p-3">
                    <h2 class="text-sm font-medium text-black/60">Sedang Berlangsung</h2>
                    <p id="lomba-stats-berlangsung" class="text-2xl font-semibold mt-1">...</p>
                </div>
            </div>
            <div class="bg-gray-100 col-span-2 lg:col-span-3 w-full rounded-lg overflow-hidden">
                <div class="p-3">
                    <h2 class="text-sm font-medium text-black/60">Selesai</h2>
                    <p id="lomba-stats-selesai" class="text-2xl font-semibold mt-1">...</p>
                </div>
            </div>
            <!-- Canvas untuk Pie Chart tetap sama -->
            <div class="bg-gray-100 col-span-4 lg:col-span-12 w-full rounded-lg overflow-hidden flex justify-center p-5">
                <div class="w-full max-w-md">
                    <canvas id="myPieChart"></canvas>
                </div>
            </div>
        </section>

        <div class="flex items-center justify-between mt-10">
            <h1 class="font-semibold">Mahasiswa</h1>
            <a href="/dashboard/kemahasiswaan/mahasiswa" class="flex items-center font-semibold text-blue-500">Lihat <span class="material-symbols-outlined">chevron_right</span></a>
        </div>

        <!-- mahasiswa stats -->
        <section class="grid place-items-center grid-cols-4 lg:grid-cols-12 gap-4 mt-5">
            <div class="bg-gray-100 col-span-2 lg:col-span-3 w-full rounded-lg overflow-hidden p-3 h-full">
                <h2 class="text-sm font-medium text-black/60">Jumlah Terdaftar</h2>
                <p id="mahasiswa-stats-terdaftar" class="text-2xl font-semibold mt-1">...</p>
            </div>
            <div class="bg-gray-100 col-span-2 lg:col-span-3 w-full rounded-lg overflow-hidden p-3">
                <h2 class="text-sm font-medium text-black/60">Butuh Persetujuan Pembimbing</h2>
                <p id="mahasiswa-stats-persetujuan" class="text-2xl font-semibold mt-1">...</p>
            </div>
            <div class="bg-gray-100 col-span-2 lg:col-span-3 w-full rounded-lg overflow-hidden p-3">
                <h2 class="text-sm font-medium text-black/60">Sedang Berkompetisi</h2>
                <p id="mahasiswa-stats-kompetisi" class="text-2xl font-semibold mt-1">...</p>
            </div>
            <div class="bg-gray-100 col-span-2 lg:col-span-3 w-full rounded-lg overflow-hidden p-3">
                <h2 class="text-sm font-medium text-black/60">Prestasi</h2>
                <p id="mahasiswa-stats-prestasi" class="text-2xl font-semibold mt-1">...</p>
            </div>
            <!-- Canvas untuk Bar Chart tetap sama -->
            <div class="bg-gray-100 col-span-4 lg:col-span-12 w-full rounded-lg overflow-hidden flex justify-center p-5">
                <div class="w-full max-w-2xl">
                    <canvas id="myBarChart"></canvas>
                </div>
            </div>
        </section>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variabel untuk menyimpan instance chart agar bisa di-destroy dan dibuat ulang
            let barChartInstance = null;
            let pieChartInstance = null;

            // --- Fungsi untuk merender Bar Chart (Sebaran Prodi) ---
            function renderBarChart(chartData) {
                const ctx = document.getElementById('myBarChart').getContext('2d');

                // Hancurkan chart lama jika ada, untuk mencegah duplikasi
                if (barChartInstance) {
                    barChartInstance.destroy();
                }

                // Memproses data dari API
                const labels = chartData.map(item => item.nama_program_studi);
                const dataValues = chartData.map(item => item.jumlah_mahasiswa);

                barChartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Mahasiswa Pendaftar per Prodi',
                            data: dataValues,
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(75, 192, 192, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                                'rgba(153, 102, 255, 0.6)',
                                'rgba(255, 99, 132, 0.6)',
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 99, 132, 1)',
                            ],
                            borderWidth: 1,
                            borderRadius: 5,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Sebaran Mahasiswa Pendaftar Berdasarkan Program Studi'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            // --- Fungsi untuk merender Pie Chart (Sebaran Tingkat Lomba) ---
            function renderPieChart(chartData) {
                const ctx = document.getElementById('myPieChart').getContext('2d');

                if (pieChartInstance) {
                    pieChartInstance.destroy();
                }

                const labels = Object.keys(chartData).map(key => key.charAt(0).toUpperCase() + key.slice(1));
                const dataValues = Object.values(chartData);

                pieChartInstance = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Lomba',
                            data: dataValues,
                            backgroundColor: ['#60a5fa', '#34d399', '#f87171'],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            title: {
                                display: true,
                                text: 'Proporsi Lomba Berdasarkan Tingkat'
                            }
                        }
                    }
                });
            }

            // === Fungsi Utama untuk Mengambil dan Merender SEMUA Data ===
            async function loadDashboardData() {
                // Beri ID unik pada setiap elemen <p> di HTML agar mudah ditargetkan
                // Lomba Stats
                const jumlahLombaEl = document.querySelector('#lomba-stats-total');
                const butuhApprovalEl = document.querySelector('#lomba-stats-approval');
                const sedangBerlangsungEl = document.querySelector('#lomba-stats-berlangsung');
                const selesaiEl = document.querySelector('#lomba-stats-selesai');

                // Mahasiswa Stats
                const jumlahTerdaftarEl = document.querySelector('#mahasiswa-stats-terdaftar');
                const butuhPersetujuanDosenEl = document.querySelector('#mahasiswa-stats-persetujuan');
                const sedangBerkompetisiEl = document.querySelector('#mahasiswa-stats-kompetisi');
                const prestasiEl = document.querySelector('#mahasiswa-stats-prestasi');

                try {
                    // Panggil endpoint API global untuk Kemahasiswaan
                    const response = await axios.get('/api/lomba/kemahasiswaan');

                    if (response.data.success) {
                        const data = response.data.data;

                        // --- Isi Kartu Statistik Lomba ---
                        if (jumlahLombaEl) jumlahLombaEl.textContent = data.lomba_stats.total ?? 0;
                        if (butuhApprovalEl) butuhApprovalEl.textContent = data.lomba_stats.butuh_approval ?? 0;
                        if (sedangBerlangsungEl) sedangBerlangsungEl.textContent = data.lomba_stats.berlangsung ?? 0;
                        if (selesaiEl) selesaiEl.textContent = data.lomba_stats.selesai ?? 0;

                        // --- Isi Kartu Statistik Mahasiswa ---
                        if (jumlahTerdaftarEl) jumlahTerdaftarEl.textContent = data.mahasiswa_stats.jumlah_terdaftar ?? 0;
                        if (butuhPersetujuanDosenEl) butuhPersetujuanDosenEl.textContent = data.mahasiswa_stats.butuh_persetujuan_dosen ?? 0;
                        if (sedangBerkompetisiEl) sedangBerkompetisiEl.textContent = data.mahasiswa_stats.sedang_berkompetisi ?? 0;
                        if (prestasiEl) prestasiEl.textContent = data.mahasiswa_stats.prestasi ?? 0;

                        // --- Render kedua chart dengan data dari API ---
                        if (data.chart_data.sebaran_prodi) {
                            renderBarChart(data.chart_data.sebaran_prodi);
                        }
                        if (data.chart_data.sebaran_tingkat_lomba) {
                            renderPieChart(data.chart_data.sebaran_tingkat_lomba);
                        }

                    } else {
                        throw new Error(response.data.message || 'Gagal mengambil data.');
                    }
                } catch (error) {
                    console.error("Error loading dashboard data:", error);
                    // Tampilkan pesan error atau nilai default di semua elemen jika gagal
                    if (jumlahLombaEl) jumlahLombaEl.textContent = 'N/A';
                    // ... (lakukan hal yang sama untuk elemen lain)
                }
            }

            // Panggil fungsi utama saat halaman dimuat
            loadDashboardData();
        });
    </script>
</body>

</html>