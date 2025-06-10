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
                    <p class="text-2xl font-semibold mt-1">10</p>
                </div>
            </div>
            <div class="bg-gray-100 col-span-2 lg:col-span-3 w-full rounded-lg overflow-hidden">
                <div class="p-3">
                    <h2 class="text-sm font-medium text-black/60">Butuh Approval</h2>
                    <p class="text-2xl font-semibold mt-1">10</p>
                </div>
            </div>
            <div class="bg-gray-100 col-span-2 lg:col-span-3 w-full rounded-lg overflow-hidden">
                <div class="p-3">
                    <h2 class="text-sm font-medium text-black/60">Sedang Berlangsung</h2>
                    <p class="text-2xl font-semibold mt-1">10</p>
                </div>
            </div>
            <div class="bg-gray-100 col-span-2 lg:col-span-3 w-full rounded-lg overflow-hidden">
                <div class="p-3">
                    <h2 class="text-sm font-medium text-black/60">Selesai</h2>
                    <p class="text-2xl font-semibold mt-1">10</p>
                </div>
            </div>
            <div class="bg-gray-100 col-span-4 lg:col-span-12 w-full rounded-lg overflow-hidden flex justify-center p-5">
                <div class="max-w-100">
                    <canvas id="myBarChart" width="400"></canvas>
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
                <p class="text-2xl font-semibold mt-1">10</p>
            </div>
            <div class="bg-gray-100 col-span-2 lg:col-span-3 w-full rounded-lg overflow-hidden p-3">
                <h2 class="text-sm font-medium text-black/60">Butuh Persetujuan Pembimbing</h2>
                <p class="text-2xl font-semibold mt-1">10</p>
            </div>
            <div class="bg-gray-100 col-span-2 lg:col-span-3 w-full rounded-lg overflow-hidden p-3">
                <h2 class="text-sm font-medium text-black/60">Sedang Berkompetisi</h2>
                <p class="text-2xl font-semibold mt-1">10</p>
            </div>
            <div class="bg-gray-100 col-span-2 lg:col-span-3 w-full rounded-lg overflow-hidden p-3">
                <h2 class="text-sm font-medium text-black/60">Prestasi</h2>
                <p class="text-2xl font-semibold mt-1">10</p>
            </div>
            <div class="bg-gray-100 col-span-4 lg:col-span-12 w-full rounded-lg overflow-hidden flex justify-center p-5">
                <div class="max-w-100">
                    <canvas id="myPieChart"></canvas>
                </div>
            </div>
        </section>

    </main>

    <script>
        // Data Custom
        const barData = {
            labels: ['Internasional', 'Nasional', 'Internal'], // Label Bar
            datasets: [{
                label: 'Jumlah Peserta',
                data: [45, 25, 60], // Nilai Bar
                backgroundColor: ['#34d399', '#60a5fa', '#f87171'], // Warna Bar
                borderRadius: 5 // Membuat bar sedikit melengkung
            }]
        };

        // Konfigurasi Chart
        const barConfig = {
            type: 'bar',
            data: barData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Peserta Per Lomba'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true // Y axis mulai dari 0
                    }
                }
            }
        };

        // Render Chart
        new Chart(
            document.getElementById('myBarChart'),
            barConfig
        );

        // Pie Chart Configuration
        // Data dari kamu, bisa diubah sesuai kebutuhan
        const dataPieChart = {
            labels: ['Lomba A', 'Lomba B', 'Lomba C'],
            datasets: [{
                data: [30, 50, 20], // Ini jumlah persentase atau nilai masing-masing kategori
                backgroundColor: ['#34d399', '#60a5fa', '#f87171'], // Warna slice
            }]
        };

        const configPieChart = {
            type: 'pie',
            data: dataPieChart,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        };

        // Render Chart
        new Chart(
            document.getElementById('myPieChart'),
            configPieChart
        );
    </script>
</body>

</html>