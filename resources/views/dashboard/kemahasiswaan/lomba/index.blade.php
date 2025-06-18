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
            <div class="col-span-4 w-full flex flex-col gap-4">
                <h1 class="font-semibold">Lomba</h1>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Terdaftar</h2>
                    <p class="text-2xl font-semibold mt-1">10</p>
                </div>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Mahasiswa Terdaftar</h2>
                    <p class="text-2xl font-semibold mt-1">10</p>

                </div>
            </div>
            <div class="col-span-4 w-full flex flex-col gap-4">
                <h1 class="font-semibold">Status</h1>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Butuh Persetujuan</h2>
                    <p class="text-2xl font-semibold mt-1">10</p>
                </div>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Belum dimulai</h2>
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
            <div class="col-span-4 w-full flex flex-col gap-4">
                <h1 class="font-semibold">Butuh Persetujuan</h1>
                <div class="flex items-center gap-2 p-3 bg-gray-100 rounded-lg">
                    <div class="flex-1">
                        <h2 class="text-base font-medium ">Lorem Ipsum Dolor Sit Aemt Colosseum</h2>
                        <p class="text-xs text-black/50">Himpunan Mahasiswa Islam</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="py-1 px-3 text-blue-500 border border-blue-500 rounded-lg text-sm font-semibold">Lihat</button>
                        <button class="py-1 px-3 bg-blue-500 text-white rounded-lg text-sm font-semibold">Setujui</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-10">
            <h1 class="font-semibold">Daftar Lomba</h1>
            <div class="flex gap-2 mt-4">
                <!-- search -->
                <input type="text" id="search-lomba-input" placeholder="Cari Lomba" class="w-full p-2 border border-gray-200 rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
                <a href="/dashboard/kemahasiswaan/lomba/buat" class="whitespace-nowrap py-2 px-3 bg-blue-500 text-white rounded-lg">Publikasikan Lomba</a>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="lg:w-full rounded-lg overflow-hidden table-auto">
                    <thead class="bg-gray-100">
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

        </section>
    </main>

    <script src="/lombaDashboard.js"></script>
</body>

</html>