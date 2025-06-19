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
        <section class="grid grid-cols-4 lg:grid-cols-12 gap-x-4 gap-y-6 mt-5">
            <h1 class="col-span-4 lg:col-span-12 font-bold text-xl">Detail Mahasiswa</h1>
            <div class="col-span-4 lg:col-span-6">
                <h1 class="text-sm font-semibold text-black/60">Nama Mahasiswa</h1>
                <p class="text-lg font-semibold mt-1">Abdurrahman Baasyir</p>
            </div>
            <div class="col-span-4 lg:col-span-6">
                <h1 class="text-sm font-semibold text-black/60">NIM</h1>
                <p class="text-lg font-semibold mt-1">6701220067</p>
            </div>
            <div class="col-span-4 lg:col-span-6">
                <h1 class="text-sm font-semibold text-black/60">Jurusan</h1>
                <p class="text-lg font-semibold mt-1">D3 Sistem Informasi</p>
            </div>
            <div class="col-span-4 lg:col-span-6">
                <h1 class="text-sm font-semibold text-black/60">No. Telepon</h1>
                <p class="text-lg font-semibold mt-1">6701220067</p>
            </div>
            <div class="col-span-4 lg:col-span-6 bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                <h1 class="text-sm font-semibold text-black/60">Total Lomba diikuti</h1>
                <p class="text-lg font-semibold mt-1">10</p>
            </div>
            <div class="col-span-4 lg:col-span-6 bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                <h1 class="text-sm font-semibold text-black/60">Jumlah Prestasi</h1>
                <p class="text-lg font-semibold mt-1">0</p>
            </div>
        </section>

        <section class="mt-10">
            <h1 class="font-semibold">Lomba di ikuti</h1>

            <div class="mt-4 overflow-x-auto">
                <table class="lg:w-full rounded-lg overflow-hidden table-auto">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3 text-left">Nama Lomba</th>
                            <th class="p-3 text-left">Tingkat</th>
                            <th class="p-3 text-left">Penyelenggara</th>
                            <th class="p-3 text-left">Peringkat</th>
                            <th class="p-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example Row -->
                        <tr class="bg-gray-50">
                            <td class="p-3">Lomba mewarnai gambar tk</td>
                            <td class="p-3">Nasional</td>
                            <td class="p-3">TKIT MUTIARA HATI</td>
                            <td class="p-3">Peserta</td>
                            <td class="p-3"><button class="w-8 h-8 flex items-center"><span class="material-symbols-outlined h-fit">more_vert</span></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </section>
    </main>
</body>

</html>