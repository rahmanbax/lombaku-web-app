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


        <!-- buat lomba form -->
        <form action="">
            <section class="grid  grid-cols-4 lg:grid-cols-12 gap-4 mt-5">
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="foto_lomba" class="text-black/60 font-semibold">Foto Lomba</label>
                    <input
                        type="file"
                        accept="image/*"
                        name="foto_lomba"
                        id="foto_lomba"
                        class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500
           file:mr-4 file:py-2 file:px-4
           file:rounded-md file:border-0
           file:text-sm file:font-semibold
           file:bg-blue-50 file:text-blue-700
           hover:file:bg-blue-100" />
                </div>
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="nama_lomba" class="text-black/60 font-semibold">Nama Lomba</label>
                    <input type="text"
                        name="nama_lomba"
                        id="nama_lomba"
                        placeholder="Masukkan Nama Lomba"
                        class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="deskripsi" class="text-black/60 font-semibold">Deskripsi Lomba</label>
                    <textarea name="deskripsi" id="deskripsi" placeholder="Masukkan Deskripsi Lomba" class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 h-30" id=""></textarea>
                </div>
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="kategori" class="text-black/60 font-semibold">Kategori</label>
                    <select name="kategori" id="kategori"
                        class="w-full border border-gray-300 rounded-lg p-2 mt-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="lomba">Lomba</option>
                        <option value="seminar">Seminar</option>
                    </select>
                </div>
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="tingkatan" class="text-black/60 font-semibold">Tingkatan</label>
                    <select name="tingkatan" id="tingkatan"
                        class="w-full border border-gray-300 rounded-lg p-2 mt-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="nasional">Nasional</option>
                        <option value="internasional">Internasional</option>
                    </select>
                </div>
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="lokasi" class="text-black/60 font-semibold">Lokasi</label>
                    <select name="lokasi" id="lokasi"
                        class="w-full border border-gray-300 rounded-lg p-2 mt-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                    </select>
                </div>
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="tanggal_akhir_pendaftaran" class="text-black/60 font-semibold">Tanggal Akhir Pendaftaran</label>
                    <input type="date"
                        name="tanggal_akhir_pendaftaran"
                        id="tanggal_akhir_pendaftaran"
                        placeholder="Masukkan Nama Lomba"
                        class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>
                <div class="col-span-2 lg:col-span-6 w-full">
                    <label for="tanggal_mulai_seleksi" class="text-black/60 font-semibold">Tanggal Mulai Kompetisi</label>
                    <input type="date"
                        name="tanggal_mulai_seleksi"
                        id="tanggal_mulai_seleksi"
                        placeholder="Masukkan Nama Lomba"
                        class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>
                <div class="col-span-2 lg:col-span-6 w-full">
                    <label for="tanggal_akhir_seleksi" class="text-black/60 font-semibold">Tanggal Akhir Kompetisi</label>
                    <input type="date"
                        name="tanggal_akhir_seleksi"
                        id="tanggal_akhir_seleksi"
                        placeholder="Masukkan Nama Lomba"
                        class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="tanggal_pengumuman" class="text-black/60 font-semibold">Tanggal Pengumuman</label>
                    <input type="date"
                        name="tanggal_pengumuman"
                        id="tanggal_pengumuman"
                        placeholder="Masukkan Nama Lomba"
                        class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>
                <button type="submit" class="mt-4 col-span-4 lg:col-span-12 rounded-lg bg-blue-500 text-white px-3 py-2">Publikasikan lomba</button>
            </section>
        </form>

    </main>
</body>

</html>