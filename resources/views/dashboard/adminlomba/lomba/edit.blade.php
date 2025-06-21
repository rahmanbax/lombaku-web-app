<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lomba</title> <!-- Judul diubah -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <x-adminlomba-header-nav />


    <main class=" lg:w-[1038px] mx-auto p-4 lg:py-10 lg:px-0">
        <h1 class="text-2xl font-bold mb-4">Edit Lomba</h1>

        <!-- Pesan sukses/error -->
        <div id="response-message" class="mb-4"></div>

        <form id="form-edit-lomba">
            <!-- PENTING: Method Spoofing untuk Laravel -->
            <input type="hidden" name="_method" value="PUT">

            <section class="grid grid-cols-4 lg:grid-cols-12 gap-4 mt-5">
                <!-- Foto Lomba -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="foto_lomba" class="text-black/60 font-semibold">Foto Lomba</label>
                    <!-- Menampilkan foto saat ini -->
                    <div class="mt-2 mb-4">
                        <img id="current-foto" src="" alt="Foto Lomba Saat Ini" class="w-48 h-auto rounded-lg">
                    </div>
                    <input type="file" accept="image/*" name="foto_lomba" id="foto_lomba" class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                </div>

                <!-- Nama Lomba -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="nama_lomba" class="text-black/60 font-semibold">Nama Lomba</label>
                    <input type="text" name="nama_lomba" id="nama_lomba" required placeholder="Masukkan Nama Lomba" class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- Deskripsi Lomba -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="deskripsi" class="text-black/60 font-semibold">Deskripsi Lomba</label>
                    <textarea name="deskripsi" id="deskripsi" required placeholder="Masukkan Deskripsi Lomba" class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 h-30"></textarea>
                </div>

                <!-- Tags -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="tags" class="text-black/60 font-semibold">Tag</label>
                    <select name="tags[]" id="tags" multiple required class="w-full h-32 border border-gray-300 rounded-lg p-2 mt-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option disabled>Memuat tag...</option>
                    </select>
                </div>

                <!-- Lokasi -->
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

                <!-- Tingkat -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="tingkat" class="text-black/60 font-semibold">Tingkat</label>
                    <select name="tingkat" id="tingkat" required class="w-full border border-gray-300 rounded-lg p-2 mt-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="nasional">Nasional</option>
                        <option value="internasional">Internasional</option>
                        <option value="internal">Internal</option>
                    </select>
                </div>


                <!-- Tanggal Akhir Pendaftaran -->
                <div class="col-span-4 lg:col-span-12 w-full">
                    <label for="tanggal_akhir_registrasi" class="text-black/60 font-semibold">Tanggal Akhir Pendaftaran</label>
                    <input type="date" name="tanggal_akhir_registrasi" id="tanggal_akhir_registrasi" required class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- Tanggal Mulai Kompetisi -->
                <div class="col-span-2 lg:col-span-6 w-full">
                    <label for="tanggal_mulai_lomba" class="text-black/60 font-semibold">Tanggal Mulai Kompetisi</label>
                    <input type="date" name="tanggal_mulai_lomba" id="tanggal_mulai_lomba" required class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- Tanggal Akhir Kompetisi -->
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

                <button type="submit" class="mt-4 col-span-4 lg:col-span-12 cursor-pointer rounded-lg bg-blue-500 hover:bg-blue-600 text-white px-3 py-2">Simpan Perubahan</button>
            </section>
        </form>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // === Elemen DOM dan Variabel ===
            const lombaForm = document.getElementById("form-edit-lomba");
            const messageDiv = document.getElementById("response-message");
            const tagsSelect = document.getElementById("tags");
            const lokasiSelect = document.getElementById('lokasi');
            const lokasiOfflineContainer = document.getElementById('lokasi-offline-container');

            // Ambil ID Lomba dari URL
            const pathParts = window.location.pathname.split('/');
            const lombaId = pathParts[pathParts.length - 1];

            // --- BARU: Elemen untuk Tahap Lomba ---
            const tahapContainer = document.getElementById('tahap-container');
            const tambahTahapBtn = document.getElementById('tambah-tahap-btn');

            // === Fungsi untuk memuat dan mengisi form ===
            async function populateForm() {
                try {
                    // Gunakan Promise.all untuk mengambil semua tag dan data lomba secara bersamaan
                    const [tagsResponse, lombaResponse] = await Promise.all([
                        axios.get("/api/tags"),
                        axios.get(`/api/lomba/${lombaId}`)
                    ]);

                    // --- Isi data Lomba ---
                    const lomba = lombaResponse.data.data;
                    document.getElementById('nama_lomba').value = lomba.nama_lomba;
                    document.getElementById('deskripsi').value = lomba.deskripsi;
                    document.getElementById('lokasi').value = lomba.lokasi;
                    document.getElementById('lokasi_offline').value = lomba.lokasi_offline;
                    document.getElementById('tingkat').value = lomba.tingkat;
                    document.getElementById('tanggal_akhir_registrasi').value = lomba.tanggal_akhir_registrasi;
                    document.getElementById('tanggal_mulai_lomba').value = lomba.tanggal_mulai_lomba;
                    document.getElementById('tanggal_selesai_lomba').value = lomba.tanggal_selesai_lomba;

                    handleLokasiChange();

                    // Tampilkan foto saat ini
                    const currentFoto = document.getElementById('current-foto');
                    if (lomba.foto_lomba) {
                        currentFoto.src = `/${lomba.foto_lomba}`; // Sesuaikan path jika berbeda
                    } else {
                        currentFoto.style.display = 'none';
                    }

                    const tahaps = lomba.tahaps || []; // Asumsi relasi bernama 'tahaps'
                    tahapContainer.innerHTML = ''; // Kosongkan container
                    if (tahaps.length > 0) {
                        tahaps.forEach((tahap, index) => {
                            const tahapItem = createTahapItem(index, tahap);
                            tahapContainer.appendChild(tahapItem);
                        });
                    } else {
                        // Jika tidak ada tahap, tambahkan satu input kosong sebagai default
                        const defaultTahap = createTahapItem(0);
                        tahapContainer.appendChild(defaultTahap);
                    }


                    // --- Isi dan pilih Tags ---
                    const allTags = tagsResponse.data.data;
                    const lombaTagIds = new Set(lomba.tags.map(tag => String(tag.id_tag)));

                    tagsSelect.innerHTML = ""; // Kosongkan opsi default
                    allTags.forEach(tag => {
                        const option = document.createElement("option");
                        option.value = tag.id_tag; // Nilai option (string)
                        option.textContent = tag.nama_tag;

                        if (lombaTagIds.has(option.value)) {
                            option.selected = true; // Jika ada, tandai sebagai terpilih
                        }

                        tagsSelect.appendChild(option);
                    });

                } catch (error) {
                    messageDiv.innerHTML = `<div class="p-4 bg-red-100 text-red-800 rounded-lg">Gagal memuat data lomba untuk diedit.</div>`;
                    console.error("Error populating form:", error);
                }
            }

            function createTahapItem(index, data = {}) {
                const tahapItem = document.createElement('div');
                tahapItem.className = 'tahap-item p-3 border border-gray-300 rounded-md mt-6 relative flex flex-col gap-2';

                // Isi data nama dan deskripsi jika ada (untuk mode edit)
                const nama = data.nama_tahap || ''; // Sesuaikan dengan nama kolom di database
                const deskripsi = data.deskripsi || ''; // Sesuaikan dengan nama kolom

                // 1. Buat variabel untuk menampung HTML tombol hapus
                let deleteButtonHtml = '';

                // 2. Kondisi: Jika index BUKAN 0 (artinya bukan item pertama), tambahkan HTML tombol hapus
                if (index > 0) {
                    deleteButtonHtml = `
            <button type="button" class="hapus-tahap-btn absolute top-[-16px] right-[-16px] bg-white border border-gray-300 text-gray-500 rounded-full flex items-center justify-center w-8 h-8 hover:bg-gray-100 cursor-pointer">
                <span class="material-symbols-outlined" style="font-size: 20px;">close</span>
            </button>
        `;
                }

                // 3. Gabungkan semua HTML menjadi satu
                tahapItem.innerHTML = `
        ${deleteButtonHtml} 
        <input 
            type="text"
            name="tahap[${index}][nama]"
            placeholder="Masukkan nama tahap"
            required
            value="${nama}"
            class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
        />
        <textarea
            name="tahap[${index}][deskripsi]"
            placeholder="Deskripsi tahap"
            class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
            rows="2"
        >${deskripsi}</textarea>
    `;

                // === AKHIR PERUBAHAN ===

                return tahapItem;
            }

            // --- BARU: Fungsi untuk menambah tahap baru (dari tombol) ---
            function tambahTahap() {
                const itemCount = tahapContainer.querySelectorAll('.tahap-item').length;
                const newItem = createTahapItem(itemCount); // Buat item kosong baru
                tahapContainer.appendChild(newItem);
            }

            // --- BARU: Fungsi untuk menghapus input tahap ---
            function hapusTahap(event) {
                if (event.target.closest('.hapus-tahap-btn')) {
                    const tahapItem = event.target.closest('.tahap-item');
                    tahapItem.remove();

                    // Update index 'name' pada item yang tersisa
                    tahapContainer.querySelectorAll('.tahap-item').forEach((item, index) => {
                        item.querySelector('input').name = `tahap[${index}][nama]`;
                        item.querySelector('textarea').name = `tahap[${index}][deskripsi]`;
                    });
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

            // === Menangani submit form untuk UPDATE ===
            lombaForm.addEventListener("submit", async function(event) {
                event.preventDefault();

                const formData = new FormData(lombaForm);
                messageDiv.innerHTML = `<div class="p-4 bg-yellow-100 text-yellow-800 rounded-lg">Menyimpan perubahan...</div>`;

                try {
                    // Request dikirim sebagai POST, tapi Laravel akan menganggapnya PUT karena field _method
                    const response = await axios.post(`/api/lomba/${lombaId}`, formData);

                    if (response.data.success) {
                        messageDiv.innerHTML = `<div class="p-4 bg-green-100 text-green-800 rounded-lg">Lomba berhasil diperbarui!</div>`;
                        // Opsional: Arahkan kembali ke halaman detail atau daftar lomba setelah beberapa saat
                        setTimeout(() => {
                            window.location.href = `/dashboard/adminlomba/lomba/${lombaId}`; // Ganti dengan URL yang sesuai
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
            });

            // === INISIALISASI DAN EVENT LISTENERS ===
            lokasiSelect.addEventListener('change', handleLokasiChange);
            tambahTahapBtn.addEventListener('click', tambahTahap);
            tahapContainer.addEventListener('click', hapusTahap);
            populateForm(); // Panggil fungsi untuk mengisi form
        });
    </script>
</body>

</html>