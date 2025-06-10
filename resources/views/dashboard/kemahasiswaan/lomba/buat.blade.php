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

    </main>
</body>

</html>