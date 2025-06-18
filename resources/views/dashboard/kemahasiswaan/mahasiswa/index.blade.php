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


        <!-- lomba stats -->
        <section class="grid grid-cols-4 lg:grid-cols-12 gap-4 mt-5">
            <div class="col-span-4 lg:col-span-6 w-full flex flex-col gap-4">
                <h1 class="font-semibold">Mahasiswa</h1>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Total</h2>
                    <p class="text-2xl font-semibold mt-1">40</p>
                </div>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Jumlah Prestasi</h2>
                    <p class="text-2xl font-semibold mt-1">42</p>

                </div>
            </div>
            <div class="col-span-4 lg:col-span-6 w-full flex flex-col gap-4">
                <h1 class="font-semibold">Status</h1>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Tahap Pendaftaran</h2>
                    <p class="text-2xl font-semibold mt-1">2</p>
                </div>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Butuh Persetujuan Pembimbing</h2>
                    <p class="text-2xl font-semibold mt-1">10</p>
                </div>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Sedang Berlangsung</h2>
                    <p class="text-2xl font-semibold mt-1">10</p>
                </div>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Selesai</h2>
                    <p class="text-2xl font-semibold mt-1">10</p>
                </div>
            </div>
        </section>

        <section class="mt-10">
            <h1 class="font-semibold">Semua Mahasiswa</h1>
            <div class="flex gap-2 mt-4">
                <!-- search -->
                <input type="text" placeholder="Cari Mahasiswa" class="w-full p-2 border border-gray-200 rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
                <a href="/" class="whitespace-nowrap py-2 px-3 bg-blue-500 text-white rounded-lg">Download .xlsx</a>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="lg:w-full rounded-lg overflow-hidden table-auto">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3 text-left">Nama Mahasiswa</th>
                            <th class="p-3 text-left">NIM</th>
                            <th class="p-3 text-left">Jurusan</th>
                            <th class="p-3 text-left">Dosen Wali</th>
                            <th class="p-3 text-left">Lomba Diikuti</th>
                            <th class="p-3 text-left">Jumlah Prestasi</th>
                            <th class="p-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example Row -->
                        <tr class="bg-gray-50">
                            <td class="p-3">Abdurrahman Baasyir</td>
                            <td class="p-3">6701220067</td>
                            <td class="p-3">D3 Sistem Informasi</td>
                            <td class="p-3">Bayu Rima Aditya</td>
                            <td class="p-3">6</td>
                            <td class="p-3">1</td>
                            <td class="p-3"><button class="w-8 h-8 flex items-center"><span class="material-symbols-outlined h-fit">more_vert</span></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </section>
    </main>
</body>

</html>