<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    <x-kemahasiswaan-header-nav />

    <main class="lg:w-[1038px] mx-auto p-4 lg:py-10 lg:px-0">

        <!-- Kontainer utama yang akan diisi oleh JavaScript -->
        <section id="lomba-detail-container" class="grid grid-cols-4 lg:grid-cols-12 gap-4 mt-5">
            <!-- Placeholder/Loading state -->
            <div class="col-span-12 text-center p-10">
                <p class="text-lg font-semibold text-gray-500">Memuat data lomba...</p>
            </div>
        </section>

        <!-- Template untuk detail lomba (disembunyikan secara default) -->
        <template id="lomba-detail-template">
            <img id="lomba-image" src="" alt="Foto Lomba" class="col-span-4 lg:col-span-5 rounded-lg object-cover w-full aspect-square" />

            <div class="ml-0 lg:ml-2 col-span-4 lg:col-span-7">
                <h1 id="lomba-nama" class="text-2xl font-bold"></h1>
                <p id="lomba-tingkat" class="text-black/60 mt-1 text-lg capitalize"></p>

                <!-- Area untuk Tags -->
                <div id="lomba-tags" class="flex flex-wrap gap-2 mt-4">
                    <!-- Tag akan diisi oleh JS di sini -->
                </div>

                <table class="mt-4 w-full">
                    <tbody>
                        <tr>
                            <th class="font-normal text-start pb-2 w-1/2">Lokasi</th>
                            <td id="lomba-lokasi" class="pb-2 capitalize"></td>
                        </tr>
                        <tr>
                            <th class="font-normal text-start pb-2 w-1/2">Status</th>
                            <td id="lomba-status" class="pb-2 capitalize"></td>
                        </tr>
                        <tr>
                            <th class="font-normal text-start pb-2 w-1/2">Tanggal Akhir Daftar</th>
                            <td id="lomba-tanggal-akhir-registrasi" class="pb-2"></td>
                        </tr>
                        <tr>
                            <th class="font-normal text-start pb-2">Tanggal Mulai Lomba</th>
                            <td id="lomba-tanggal-mulai" class="pb-2"></td>
                        </tr>
                        <tr>
                            <th class="font-normal text-start pb-2">Tanggal Akhir Lomba</th>
                            <td id="lomba-tanggal-selesai" class="pb-2"></td>
                        </tr>
                    </tbody>
                </table>

                <div class="flex gap-2 mt-3 bg-gray-100 w-full p-3 rounded-lg">
                    <img id="penyelenggara-foto" src="{{ asset('images/default-profile.png') }}" alt="foto penyelenggara" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <p class="text-xs text-black/60">Penyelenggara</p>
                        <h1 id="penyelenggara-nama" class="font-semibold mt-1"></h1>
                    </div>
                </div>

                <h2 class="font-bold mt-6 text-xl">Deskripsi</h2>
                <p id="lomba-deskripsi" class="mt-2 text-gray-700 leading-relaxed"></p>
            </div>
        </template>

        <!-- Script dipanggil setelah semua HTML dimuat -->
        <script src="/lombaDetail.js"></script>
    </main>
</body>

</html>