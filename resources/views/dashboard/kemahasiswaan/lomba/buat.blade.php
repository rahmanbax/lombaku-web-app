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

    <main class=" lg:w-[1038px] mx-auto p-4 lg:py-10 lg:px-0">


        <!-- buat lomba form -->
        <!-- Letakkan ini di atas form untuk menampilkan pesan sukses/error -->
        <div id="response-message" class="mb-4"></div>

        <!-- ID form ditambahkan untuk memudahkan penargetan di JavaScript -->
        <form id="form-buat-lomba">
            <section class="grid grid-cols-4 lg:grid-cols-12 gap-4 mt-5">

                <!-- Nama field disesuaikan dengan API: foto_lomba -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="foto_lomba" class="text-black/60 font-semibold">Foto Lomba</label>
                    <input type="file" accept="image/*" name="foto_lomba" id="foto_lomba" required class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                </div>

                <!-- Nama field disesuaikan dengan API: nama_lomba -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="nama_lomba" class="text-black/60 font-semibold">Nama Lomba</label>
                    <input type="text" name="nama_lomba" id="nama_lomba" required placeholder="Masukkan Nama Lomba" class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- Nama field disesuaikan dengan API: deskripsi -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="deskripsi" class="text-black/60 font-semibold">Deskripsi Lomba</label>
                    <textarea name="deskripsi" id="deskripsi" required placeholder="Masukkan Deskripsi Lomba" class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 h-30"></textarea>
                </div>

                <!-- DIUBAH: Menjadi multi-select untuk Tags -->
                <!-- name="tags[]" penting untuk mengirim sebagai array -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="tags" class="text-black/60 font-semibold">Tag (bisa pilih lebih dari satu dengan Ctrl/Cmd + Klik)</label>
                    <select name="tags[]" id="tags" multiple required class="w-full h-32 border border-gray-300 rounded-lg p-2 mt-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <!-- Opsi tag akan diisi oleh JavaScript dari API -->
                        <option disabled>Memuat tag...</option>
                    </select>
                </div>

                <!-- lokasi -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="lokasi" class="text-black/60 font-semibold">Lokasi</label>
                    <select name="lokasi" id="lokasi" required class="w-full border border-gray-300 rounded-lg p-2 mt-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                    </select>
                </div>

                <!-- DIUBAH: name dari 'tingkatan' menjadi 'tingkat' -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="tingkat" class="text-black/60 font-semibold">Tingkat</label>
                    <select name="tingkat" id="tingkat" required class="w-full border border-gray-300 rounded-lg p-2 mt-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="nasional">Nasional</option>
                        <option value="internasional">Internasional</option>
                        <option value="internal">Internal</option> <!-- Opsi ditambahkan -->
                    </select>
                </div>

                <!-- Field ini tidak ada di migrasi/API, jika diperlukan tambahkan ke migrasi Anda -->
                <!-- <div class="col-span-4 lg:col-span-12 w-full">
            <label for="penyelenggara" class="text-black/60 font-semibold">Penyelenggara</label>
            <input type="text" name="penyelenggara" id="penyelenggara" placeholder="Masukkan Nama Penyelenggara" class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div> -->

                <!-- DIUBAH: name dari 'tanggal_akhir_pendaftaran' menjadi 'tanggal_akhir_registrasi' -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="tanggal_akhir_registrasi" class="text-black/60 font-semibold">Tanggal Akhir Pendaftaran</label>
                    <input type="date" name="tanggal_akhir_registrasi" id="tanggal_akhir_registrasi" required class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- DIUBAH: name dari 'tanggal_mulai_seleksi' menjadi 'tanggal_mulai_lomba' -->
                <div class="col-span-2 lg:col-span-6 w-full">
                    <label for="tanggal_mulai_lomba" class="text-black/60 font-semibold">Tanggal Mulai Kompetisi</label>
                    <input type="date" name="tanggal_mulai_lomba" id="tanggal_mulai_lomba" required class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- DIUBAH: name dari 'tanggal_akhir_seleksi' menjadi 'tanggal_selesai_lomba' -->
                <div class="col-span-2 lg:col-span-6 w-full">
                    <label for="tanggal_selesai_lomba" class="text-black/60 font-semibold">Tanggal Akhir Kompetisi</label>
                    <input type="date" name="tanggal_selesai_lomba" id="tanggal_selesai_lomba" required class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- DIHAPUS: Field 'lokasi' dan 'tanggal_pengumuman' tidak ada di tabel 'lomba' Anda -->

                <button type="submit" class="mt-4 col-span-4 lg:col-span-12 cursor-pointer rounded-lg bg-blue-500 text-white px-3 py-2">Publikasikan lomba</button>
            </section>
        </form>

        <script src="/lombaDashboardKemahasiswaan.js"></script>
    </main>
</body>

</html>