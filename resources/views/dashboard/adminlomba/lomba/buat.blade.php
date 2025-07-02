<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- BARU: Tambahkan CSS untuk Choices.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    <x-adminlomba-header-nav />

    <main class=" lg:w-[1038px] mx-auto p-4 lg:py-10 lg:px-0">
        <h1 class="text-2xl font-bold mb-4">Buat Lomba</h1>

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
                    <textarea name="deskripsi" rows="3" id="deskripsi" required placeholder="Masukkan Deskripsi Lomba" class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <!-- DIUBAH: Input untuk Tags dengan fitur pencarian -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <!-- Label disederhanakan -->
                    <label for="tags" class="text-black/60 font-semibold">Tag Lomba</label>
                    <!-- Elemen select ini akan di-transform oleh Choices.js -->
                    <select name="tags[]" id="tags" multiple required class="w-full bg-white rounded-lg">
                        <!-- Opsi akan diisi oleh JavaScript -->
                    </select>
                </div>

                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="jenis_lomba" class="text-black/60 font-semibold">Jenis Lomba</label>
                    <select name="jenis_lomba" id="jenis_lomba" required class="w-full border border-gray-300 rounded-lg p-2 mt-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="individu">Individu</option>
                        <option value="kelompok">Kelompok</option>
                    </select>
                </div>

                <div class="col-span-4 lg:col-span-12 w-full">
                    <label class="text-black/60 font-semibold">Dosen Pembimbing</label>
                    <div class="flex items-center gap-6 mt-2">
                        <!-- Opsi 'Tidak' (default) -->
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="butuh_pembimbing" value="0" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" checked>
                            <span>Tidak</span>
                        </label>
                        <!-- Opsi 'Ya' -->
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="butuh_pembimbing" value="1" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                            <span>Ya, Wajib</span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Jika 'Ya', maka mahasiswa wajib memilih dosen pembimbing saat mendaftar.</p>
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

                <!-- DIUBAH: name dari 'tanggal_akhir_pendaftaran' menjadi 'tanggal_akhir_registrasi' -->
                <div class="col-span-4 lg:col-span-4 w-full">
                    <label for="tanggal_akhir_registrasi" class="text-black/60 font-semibold">Tanggal Akhir Pendaftaran</label>
                    <input type="date" name="tanggal_akhir_registrasi" id="tanggal_akhir_registrasi" required class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- DIUBAH: name dari 'tanggal_mulai_seleksi' menjadi 'tanggal_mulai_lomba' -->
                <div class="col-span-2 lg:col-span-4 w-full">
                    <label for="tanggal_mulai_lomba" class="text-black/60 font-semibold">Tanggal Mulai Kompetisi</label>
                    <input type="date" name="tanggal_mulai_lomba" id="tanggal_mulai_lomba" required class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- DIUBAH: name dari 'tanggal_akhir_seleksi' menjadi 'tanggal_selesai_lomba' -->
                <div class="col-span-2 lg:col-span-4 w-full">
                    <label for="tanggal_selesai_lomba" class="text-black/60 font-semibold">Tanggal Akhir Kompetisi</label>
                    <input type="date" name="tanggal_selesai_lomba" id="tanggal_selesai_lomba" required class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <hr class="col-span-4 lg:col-span-12 text-gray-300 my-2">

                <!-- deskripsi pengumpulan lomba -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="deskripsi_pengumpulan" class="text-black/60 font-semibold">Deskripsi Pengumpulan Lomba</label>
                    <textarea name="deskripsi_pengumpulan" id="deskripsi_pengumpulan" required placeholder="Masukkan Deskripsi Pengumpulan Lomba" class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

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
                                name="tahap[0][nama]"
                                placeholder="Masukkan nama tahap"
                                required
                                class="w-full border bg-white border-gray-300 col-span-4 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            <textarea
                                name="tahap[0][deskripsi]"
                                placeholder="Deskripsi tahap"
                                class="w-full border bg-white border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                rows="2"></textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" class="mt-4 col-span-4 lg:col-span-12 cursor-pointer rounded-lg bg-blue-500 text-white px-3 py-2">Publikasikan lomba</button>
            </section>
        </form>

        <!-- BARU: Tambahkan JS untuk Choices.js (letakkan sebelum script utama Anda) -->
        <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

        <script>
            // Buat lomba
            // Pastikan script dijalankan setelah semua elemen halaman dimuat
            document.addEventListener("DOMContentLoaded", function() {

                // --- Variabel dan Elemen DOM ---
                const lombaForm = document.getElementById("form-buat-lomba");
                const messageDiv = document.getElementById("response-message");

                const tahapContainer = document.getElementById('tahap-container');
                const tambahTahapBtn = document.getElementById('tambah-tahap-btn');

                if (!lombaForm) {
                    return;
                }

                // Variabel elemen form lainnya
                const lokasiSelect = document.getElementById('lokasi');
                const lokasiOfflineContainer = document.getElementById('lokasi-offline-container');

                // --- DIUBAH: Inisialisasi Choices.js untuk Tags ---
                const tagsSelect = document.getElementById("tags");
                const choicesInstance = new Choices(tagsSelect, {
                    removeItemButton: true, // Menampilkan tombol (x) untuk menghapus tag
                    placeholder: true,
                    placeholderValue: 'Pilih atau ketik untuk mencari tag...',
                    searchPlaceholderValue: 'Ketik untuk mencari...',
                    // itemSelectText: 'Tekan untuk memilih', // Teks kustom jika diperlukan
                });

                // ==========================================================
                // --- FUNGSI-FUNGSI ---
                // ==========================================================

                // --- DIUBAH: Fungsi untuk mengambil data tags dan mengisi ke Choices.js ---
                async function fetchTags() {
                    // Tampilkan status loading di dalam Choices.js
                    choicesInstance.setChoices([{
                        label: 'Memuat tag...',
                        value: '',
                        disabled: true
                    }], 'value', 'label', true);

                    try {
                        const response = await axios.get("/api/tags");
                        if (response.data.success) {
                            // Format data dari API agar sesuai dengan format yang dibutuhkan Choices.js
                            // yaitu: [{ value: '1', label: 'Teknologi' }, { value: '2', label: 'Seni' }]
                            const formattedTags = response.data.data.map(tag => ({
                                value: tag.id_tag,
                                label: tag.nama_tag
                            }));

                            // Atur pilihan menggunakan API dari Choices.js
                            choicesInstance.setChoices(formattedTags, 'value', 'label', true);
                        }
                    } catch (error) {
                        // Tampilkan pesan error di dalam Choices.js
                        choicesInstance.setChoices([{
                            label: 'Gagal memuat tag',
                            value: '',
                            disabled: true
                        }], 'value', 'label', true);
                        console.error("Error fetching tags:", error);
                    }
                }

                // Fungsi untuk menampilkan/menyembunyikan field lokasi offline
                function handleLokasiChange() {
                    if (lokasiSelect.value === 'offline') {
                        lokasiOfflineContainer.classList.remove('hidden');
                    } else {
                        lokasiOfflineContainer.classList.add('hidden');
                    }
                }

                // Fungsi untuk menambahkan input tahap baru
                function tambahTahap() {
                    // Dapatkan semua item tahap untuk menentukan indeks array berikutnya
                    const tahapItems = tahapContainer.querySelectorAll('.tahap-item');
                    const itemCount = tahapItems.length;

                    const tahapItem = document.createElement('div');
                    tahapItem.className = 'tahap-item p-3 border border-gray-300 rounded-md mt-6 relative flex flex-col gap-2';

                    tahapItem.innerHTML = `
                        <button type="button" class="hapus-tahap-btn absolute top-[-16px] right-[-16px] bg-white border border-gray-300 text-gray-500 rounded-full flex items-center justify-center w-8 h-8 hover:bg-gray-100 cursor-pointer transition-colors duration-200">
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

                // Fungsi untuk menghapus input tahap
                function hapusTahap(event) {
                    const hapusBtn = event.target.closest('.hapus-tahap-btn');
                    if (hapusBtn) {
                        const tahapItem = hapusBtn.closest('.tahap-item');
                        tahapItem.remove();
                        // Optional: re-index a
                    }
                }

                // Fungsi untuk menangani submit form
                async function handleFormSubmit(event) {
                    event.preventDefault();
                    messageDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });

                    const formData = new FormData(lombaForm);
                    messageDiv.innerHTML = `<div class="p-4 bg-yellow-100 text-yellow-800 rounded-lg">Memproses...</div>`;

                    try {
                        const token = localStorage.getItem('authToken');
                        const response = await axios.post("/api/lomba", formData);

                        if (response.data.success) {
                            messageDiv.innerHTML = `<div class="p-4 bg-green-100 text-green-800 rounded-lg">Lomba berhasil dipublikasikan!</div>`;

                            lombaForm.reset();

                            choicesInstance.clearStore();

                            lokasiOfflineContainer.classList.add('hidden');

                            // Kosongkan container tahap kecuali yang pertama
                            const allTahap = tahapContainer.querySelectorAll('.tahap-item');
                            for (let i = 1; i < allTahap.length; i++) {
                                allTahap[i].remove();
                            }
                            // Opsional: Arahkan kembali ke halaman detail atau daftar lomba setelah beberapa saat
                            setTimeout(() => {
                                window.location.href = '/dashboard/adminlomba/lomba';
                            }, 1500);
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

                fetchTags();
                lokasiSelect.addEventListener('change', handleLokasiChange);
                tambahTahapBtn.addEventListener('click', tambahTahap);
                tahapContainer.addEventListener('click', hapusTahap);
                lombaForm.addEventListener("submit", handleFormSubmit);

            });
        </script>
    </main>
</body>

</html>