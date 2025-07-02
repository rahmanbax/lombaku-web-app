<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Lomba Baru</title>

    <!-- [BARU] Tambahkan CSS untuk Choices.js agar tampilan tags lebih baik -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <x-kemahasiswaan-header-nav />

    <main class=" lg:w-[1038px] mx-auto p-4 lg:py-10 lg:px-0">
        <h1 class="text-2xl font-bold mb-4">Buat Lomba</h1>

        <!-- Container untuk menampilkan pesan sukses/error -->
        <div id="response-message" class="mb-4"></div>

        <form id="form-buat-lomba">
            <section class="grid grid-cols-4 lg:grid-cols-12 gap-4 mt-5">

                <!-- Foto Lomba -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="foto_lomba" class="text-black/60 font-semibold">Foto Lomba</label>
                    <input type="file" accept="image/*" name="foto_lomba" id="foto_lomba" required class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                </div>

                <!-- Nama Lomba -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="nama_lomba" class="text-black/60 font-semibold">Nama Lomba</label>
                    <input type="text" name="nama_lomba" id="nama_lomba" required placeholder="Masukkan Nama Lomba" class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- Deskripsi Lomba -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="deskripsi" class="text-black/60 font-semibold">Deskripsi Lomba</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" required placeholder="Masukkan Deskripsi Lomba" class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <!-- [DIPERBARUI] Input Tags dengan Choices.js -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="tags" class="text-black/60 font-semibold">Tag Lomba</label>
                    <select name="tags[]" id="tags" multiple required class="w-full bg-white rounded-lg"></select>
                </div>

                <!-- [BARU] Jenis Lomba -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="jenis_lomba" class="text-black/60 font-semibold">Jenis Lomba</label>
                    <select name="jenis_lomba" id="jenis_lomba" required class="w-full border border-gray-300 rounded-lg p-2 mt-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="individu">Individu</option>
                        <option value="kelompok">Kelompok</option>
                    </select>
                </div>

                <div class="col-span-4 lg:col-span-12 w-full">
                    <label class="text-black/60 font-semibold">Membutuhkan Dosen Pembimbing?</label>
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

                <!-- Lokasi -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="lokasi" class="text-black/60 font-semibold">Lokasi</label>
                    <select name="lokasi" id="lokasi" required class="w-full border border-gray-300 rounded-lg p-2 mt-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                    </select>
                </div>

                <!-- [BARU] Field Lokasi Offline (kondisional) -->
                <div id="lokasi-offline-container" class="col-span-4 lg:col-span-12 w-full hidden">
                    <label for="lokasi_offline" class="text-black/60 font-semibold">Alamat Lokasi Offline</label>
                    <input type="text" name="lokasi_offline" id="lokasi_offline" placeholder="Contoh: Gedung Serbaguna Lt. 3, Kampus A" class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- Penyelenggara -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="penyelenggara" class="text-black/60 font-semibold">Penyelenggara</label>
                    <input type="text" name="penyelenggara" id="penyelenggara" placeholder="Masukkan Nama Penyelenggara" class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>


                <!-- Tingkat -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="tingkat" class="text-black/60 font-semibold">Tingkat</label>
                    <select name="tingkat" id="tingkat" required class="w-full border border-gray-300 rounded-lg p-2 mt-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="nasional">Nasional</option>
                        <option value="internasional">Internasional</option>
                        <option value="internal">Internal</option>
                    </select>
                </div>

                <!-- [DIPERBARUI] Layout Tanggal menjadi 3 kolom di layar besar -->
                <div class="col-span-4 lg:col-span-4 w-full">
                    <label for="tanggal_akhir_registrasi" class="text-black/60 font-semibold">Akhir Pendaftaran</label>
                    <input type="date" name="tanggal_akhir_registrasi" id="tanggal_akhir_registrasi" required class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>
                <div class="col-span-4 lg:col-span-4 w-full">
                    <label for="tanggal_mulai_lomba" class="text-black/60 font-semibold">Mulai Kompetisi</label>
                    <input type="date" name="tanggal_mulai_lomba" id="tanggal_mulai_lomba" required class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>
                <div class="col-span-4 lg:col-span-4 w-full">
                    <label for="tanggal_selesai_lomba" class="text-black/60 font-semibold">Akhir Kompetisi</label>
                    <input type="date" name="tanggal_selesai_lomba" id="tanggal_selesai_lomba" required class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <hr class="col-span-4 lg:col-span-12 text-gray-300 my-2">

                <!-- [BARU] Deskripsi Pengumpulan -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="deskripsi_pengumpulan" class="text-black/60 font-semibold">Deskripsi Pengumpulan Lomba</label>
                    <textarea name="deskripsi_pengumpulan" id="deskripsi_pengumpulan" required placeholder="Jelaskan apa yang harus dikumpulkan oleh peserta, misal: 'Link Google Drive berisi proposal dan video demo.'" class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <!-- [BARU] Bagian untuk Tahapan Lomba Dinamis -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <div class="flex justify-between items-center">
                        <label class="text-black/60 font-semibold">Tahapan Lomba</label>
                        <button type="button" id="tambah-tahap-btn" class="bg-blue-500 text-white px-3 py-1.5 rounded-md font-semibold hover:bg-blue-600 text-sm">
                            + Tambah Tahap
                        </button>
                    </div>
                    <div id="tahap-container" class="mt-3 space-y-3">
                        <!-- Input Tahap Pertama (Default) -->
                        <div class="tahap-item flex flex-col gap-2 border border-gray-300 p-3 rounded-md">
                            <input type="text" name="tahap[0][nama]" placeholder="Nama Tahap, contoh: Babak Penyisihan" required class="w-full border bg-white border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            <textarea name="tahap[0][deskripsi]" placeholder="Deskripsi singkat untuk tahap ini" class="w-full border bg-white border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" rows="2"></textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" class="mt-4 col-span-4 lg:col-span-12 cursor-pointer rounded-lg bg-blue-500 text-white px-3 py-2 font-bold">Publikasikan Lomba</button>
            </section>
        </form>

        <!-- [BARU] Script untuk Choices.js (letakkan sebelum script utama) -->
        <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {

                const lombaForm = document.getElementById("form-buat-lomba");
                const messageDiv = document.getElementById("response-message");
                const tahapContainer = document.getElementById('tahap-container');
                const tambahTahapBtn = document.getElementById('tambah-tahap-btn');
                const lokasiSelect = document.getElementById('lokasi');
                const lokasiOfflineContainer = document.getElementById('lokasi-offline-container');
                const tagsSelect = document.getElementById("tags");

                // --- Inisialisasi Choices.js ---
                const choicesInstance = new Choices(tagsSelect, {
                    removeItemButton: true,
                    placeholder: true,
                    placeholderValue: 'Pilih atau ketik untuk mencari tag...',
                });

                // --- Fungsi untuk mengambil Tags ---
                async function fetchTags() {
                    choicesInstance.setChoices([{
                        label: 'Memuat tag...',
                        value: '',
                        disabled: true
                    }], 'value', 'label', true);
                    try {
                        const response = await axios.get("/api/tags");
                        if (response.data.success) {
                            const formattedTags = response.data.data.map(tag => ({
                                value: tag.id_tag,
                                label: tag.nama_tag
                            }));
                            choicesInstance.setChoices(formattedTags, 'value', 'label', true);
                        }
                    } catch (error) {
                        choicesInstance.setChoices([{
                            label: 'Gagal memuat tag',
                            value: '',
                            disabled: true
                        }], 'value', 'label', true);
                        console.error("Error fetching tags:", error);
                    }
                }

                // --- Fungsi untuk Logika UI ---
                function handleLokasiChange() {
                    lokasiOfflineContainer.classList.toggle('hidden', lokasiSelect.value !== 'offline');
                }

                function tambahTahap() {
                    const itemCount = tahapContainer.querySelectorAll('.tahap-item').length;
                    const tahapItem = document.createElement('div');
                    tahapItem.className = 'tahap-item flex flex-col gap-2 border border-gray-300 p-3 rounded-md relative';
                    tahapItem.innerHTML = `
                        <button type="button" class="hapus-tahap-btn absolute -top-2 -right-2 bg-red-500 text-white rounded-full flex items-center justify-center w-6 h-6 hover:bg-red-600">×</button>
                        <input type="text" name="tahap[${itemCount}][nama]" placeholder="Nama Tahap" required class="w-full border bg-white border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        <textarea name="tahap[${itemCount}][deskripsi]" placeholder="Deskripsi tahap" class="w-full border bg-white border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" rows="2"></textarea>
                    `;
                    tahapContainer.appendChild(tahapItem);
                }

                function hapusTahap(event) {
                    if (event.target.classList.contains('hapus-tahap-btn')) {
                        event.target.closest('.tahap-item').remove();
                    }
                }

                // --- Fungsi untuk Submit Form ---
                async function handleFormSubmit(event) {
                    event.preventDefault();
                    messageDiv.innerHTML = `<div class="p-4 bg-yellow-100 text-yellow-800 rounded-lg">Memproses...</div>`;
                    window.scrollTo(0, 0);

                    const formData = new FormData(lombaForm);

                    try {
                        const response = await axios.post("/api/lomba", formData);

                        if (response.data.success) {
                            messageDiv.innerHTML = `<div class="p-4 bg-green-100 text-green-800 rounded-lg">Lomba berhasil dipublikasikan!</div>`;
                            lombaForm.reset();
                            choicesInstance.clearStore();
                            fetchTags();
                            // Hapus tahap tambahan
                            const allTahap = tahapContainer.querySelectorAll('.tahap-item');
                            for (let i = 1; i < allTahap.length; i++) {
                                allTahap[i].remove();
                            }
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
                    }
                }

                // --- Panggil Fungsi dan Tambahkan Event Listeners ---
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