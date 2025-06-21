<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    <x-adminlomba-header-nav />

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

                <!-- Field Lokasi Offline (disembunyikan secara default) -->
                <div id="lokasi-offline-container" class="col-span-4 lg:col-span-12 w-full hidden">
                    <label for="lokasi_offline" class="text-black/60 font-semibold">Alamat Lokasi Offline</label>
                    <input type="text"
                        name="lokasi_offline"
                        id="lokasi_offline"
                        placeholder="Contoh: Gedung Serbaguna Lt. 3, Kampus A"
                        class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
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

                <hr class="col-span-4 lg:col-span-12 text-gray-300 my-2">

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

                <hr class="col-span-4 lg:col-span-12 text-gray-300 my-2">

                <!-- Bagian untuk Tahapan Lomba -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <div class="flex justify-between items-center">
                        <label class="text-black/60 font-semibold">Tahapan Lomba</label>
                        <button type="button" id="tambah-tahap-btn" class="bg-blue-500 text-white px-2 py-1 rounded-md font-semibold hover:bg-blue-600 cursor-pointer">
                            + Tambah Tahap
                        </button>
                    </div>

                    <!-- Kontainer untuk input tahap dinamis -->
                    <div id="tahap-container" class="mt-3">
                        <!-- Input Tahap Pertama (Default) -->
                        <div class="flex flex-col items-center gap-2 tahap-item border border-gray-300 p-3 rounded-md">
                            <input
                                type="text"
                                name="tahap[][nama]"
                                placeholder="Masukkan nama tahap"
                                required
                                class="w-full border bg-white border-gray-300 col-span-4 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            <!-- Tombol hapus tidak ada untuk input pertama -->
                            <textarea
                                name="tahap[0][deskripsi]"
                                placeholder="Deskripsi tahap"
                                class="w-full border bg-white border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                rows="2"></textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" class="mt-4 col-span-4 lg:col-span-12 cursor-pointer rounded-lg bg-blue-500 text-white px-3 py-2">Publikasikan lomba</button>
            </section>
        </form>

        <script>
            // Buat lomba
            // Pastikan script dijalankan setelah semua elemen halaman dimuat
            document.addEventListener("DOMContentLoaded", function() {

                // --- Variabel dan Elemen DOM ---
                const lombaForm = document.getElementById("form-buat-lomba");
                const messageDiv = document.getElementById("response-message");

                // --- BARU: Elemen untuk Tahap Lomba ---
                const tahapContainer = document.getElementById('tahap-container');
                const tambahTahapBtn = document.getElementById('tambah-tahap-btn');

                // Pastikan kita berada di halaman yang memiliki form ini sebelum melanjutkan
                if (!lombaForm) {
                    // Jika form tidak ditemukan, hentikan eksekusi script ini
                    return;
                }

                // Variabel elemen form lainnya
                const tagsSelect = document.getElementById("tags");
                const lokasiSelect = document.getElementById('lokasi');
                const lokasiOfflineContainer = document.getElementById('lokasi-offline-container');

                // ==========================================================
                // --- FUNGSI-FUNGSI ---
                // ==========================================================

                // Fungsi untuk mengambil data tags dan mengisi dropdown
                async function fetchTags() {
                    try {
                        const response = await axios.get("/api/tags");
                        if (response.data.success) {
                            tagsSelect.innerHTML = ""; // Kosongkan opsi
                            response.data.data.forEach((tag) => {
                                const option = document.createElement("option");
                                option.value = tag.id_tag;
                                option.textContent = tag.nama_tag;
                                tagsSelect.appendChild(option);
                            });
                        }
                    } catch (error) {
                        tagsSelect.innerHTML = "<option disabled>Gagal memuat tag</option>";
                        console.error("Error fetching tags:", error);
                    }
                }

                // Fungsi untuk menampilkan/menyembunyikan field lokasi offline
                function handleLokasiChange() {
                    const selectedValue = lokasiSelect.value;
                    if (selectedValue === 'offline') {
                        lokasiOfflineContainer.classList.remove('hidden');
                    } else {
                        lokasiOfflineContainer.classList.add('hidden');
                    }
                }

                // --- BARU: Fungsi untuk menambahkan input tahap baru ---
                function tambahTahap() {
                    const itemCount = tahapContainer.querySelectorAll('.tahap-item').length;
                    const tahapItem = document.createElement('div');
                    tahapItem.className = 'tahap-item p-3 border border-gray-300 rounded-md mt-6 relative flex flex-col gap-2'; // Tambahkan 'relative' untuk positioning tombol hapus

                    tahapItem.innerHTML = `
        <button type="button" class="hapus-tahap-btn absolute top-[-16px] right-[-16px] bg-white border border-gray-300 text-gray-500 rounded-full flex items-center justify-center w-8 h-8 hover:bg-gray-100 cursor-pointer">
            <span class="material-symbols-outlined" style="font-size: 20px;">close</span>
        </button>
        <input 
            type="text"
            name="tahap[${itemCount}][nama]"
            placeholder="Masukkan nama tahap"
            required
            class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
        />
        <textarea
            name="tahap[${itemCount}][deskripsi]"
            placeholder="Deskripsi tahap"
            class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
            rows="2"
        ></textarea>
    `;
                    tahapContainer.appendChild(tahapItem);
                }

                // --- BARU: Fungsi untuk menghapus input tahap ---
                function hapusTahap(event) {
                    if (event.target.closest('.hapus-tahap-btn')) {
                        const tahapItem = event.target.closest('.tahap-item');
                        tahapItem.remove();
                    }
                }

                // Fungsi untuk menangani submit form
                async function handleFormSubmit(event) {
                    event.preventDefault(); // Mencegah form submit secara default

                    const formData = new FormData(lombaForm);
                    messageDiv.innerHTML = `<div class="p-4 bg-yellow-100 text-yellow-800 rounded-lg">Memproses...</div>`;

                    try {
                        const token = localStorage.getItem('authToken'); // Ambil token untuk endpoint yang dilindungi
                        const response = await axios.post("/api/lomba", formData);

                        if (response.data.success) {
                            messageDiv.innerHTML = `<div class="p-4 bg-green-100 text-green-800 rounded-lg">Lomba berhasil dipublikasikan!</div>`;
                            lombaForm.reset();
                            lokasiOfflineContainer.classList.add('hidden'); // Sembunyikan lagi field offline setelah reset
                            fetchTags(); // Muat ulang tags
                        }
                    } catch (error) {
                        let errorMessages = "Terjadi kesalahan. Silakan coba lagi.";
                        if (error.response && error.response.status === 422) {
                            const errors = error.response.data.errors;
                            errorMessages = "<ul>";
                            for (const key in errors) {
                                errorMessages += `<li class="list-disc ml-4">${errors[key][0]}</li>`;
                            }
                            errorMessages += "</ul>";
                        }
                        messageDiv.innerHTML = `<div class="p-4 bg-red-100 text-red-800 rounded-lg">${errorMessages}</div>`;
                        console.error("Error submitting form:", error.response);
                    }
                }

                // ==========================================================
                // --- INISIALISASI DAN EVENT LISTENERS ---
                // ==========================================================

                // 1. Panggil fungsi untuk mengisi dropdown saat halaman dimuat
                fetchTags();

                // 2. Pasang event listener untuk dropdown lokasi
                lokasiSelect.addEventListener('change', handleLokasiChange);

                tambahTahapBtn.addEventListener('click', tambahTahap);
                tahapContainer.addEventListener('click', hapusTahap);

                // 3. Pasang event listener untuk submit form
                lombaForm.addEventListener("submit", handleFormSubmit);

            }); // <-- Ini adalah penutup dari document.addEventListener
        </script>
    </main>
</body>

</html>