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
                        <tr id="detail-lokasi-container">
                            <th class="font-normal text-start pb-2 w-1/2">Detail Lokasi</th>
                            <td id="lomba-lokasi-offline" class="pb-2 capitalize"></td>
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

                <div id="alasan-penolakan-container" class="mt-4 hidden">
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md" role="alert">
                        <p class="font-bold">Lomba Ditolak</p>
                        <p id="alasan-penolakan-text"></p>
                    </div>
                </div>

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

        <section class="lg:w-[1038px] mx-auto p-4 lg:px-0 mt-10">
            <h2 class="text-2xl font-bold mb-4">Daftar Peserta</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nama Mahasiswa</th>
                            <th scope="col" class="px-6 py-3">NIM</th>
                            <th scope="col" class="px-6 py-3">Program Studi</th>
                            <th scope="col" class="px-6 py-3 text-center">Nilai</th>
                        </tr>
                    </thead>
                    <tbody id="peserta-table-body">
                        <!-- Loading state -->
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Memuat data peserta...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Modal 1: Untuk Detail Peserta & Daftar Tahap -->
    <div id="detail-peserta-modal" class="fixed inset-0 bg-black/50 overflow-y-auto h-full w-full flex items-center justify-center hidden">
        <div class="relative w-full max-w-xl shadow-lg rounded-lg bg-white p-6 mx-5 lg:mx-auto">
            <!-- Header Modal -->
            <div class="flex justify-between items-start pb-3">
                <div>
                    <h3 id="detail-modal-title" class="text-xl font-semibold text-gray-900">Detail Penilaian</h3>
                    <p id="detail-modal-subtitle" class="text-sm text-gray-500 mt-1"></p>
                </div>
                <button id="close-detail-modal-btn" type="button" class="text-gray-400 hover:text-gray-600 rounded-full p-1 -mt-2 -mr-2">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Konten Modal: Daftar Tahap -->
            <div id="tahap-penilaian-list" class="mt-4 space-y-2 max-h-80 overflow-y-auto">
                <!-- Daftar tahap dan nilai/tombol akan diisi oleh JS di sini -->
                <p class="text-center text-gray-500 p-4">Memuat data tahap...</p>
            </div>
        </div>
    </div>

    <!-- Modal 2: Untuk Form Penilaian Spesifik -->
    <div id="form-penilaian-modal" class="fixed inset-0 bg-black/50 overflow-y-auto h-full w-full flex items-center justify-center hidden">
        <div class="relative w-full max-w-md shadow-lg rounded-lg bg-white p-6 mx-5 lg:mx-auto">
            <h3 id="form-penilaian-title" class="text-lg font-medium text-gray-900">Beri Nilai</h3>
            <form id="penilaian-form" class="mt-4 space-y-4">
                <input type="hidden" id="penilaian-registrasi-id">
                <input type="hidden" id="penilaian-tahap-id">

                <div>
                    <label for="penilaian-nilai-input" class="block text-sm font-medium text-gray-700">Nilai (0-100)</label>
                    <input type="number" id="penilaian-nilai-input" min="0" max="100" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 sm:text-sm">
                </div>

                <div>
                    <label for="penilaian-catatan-textarea" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                    <textarea id="penilaian-catatan-textarea" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 sm:text-sm" placeholder="Berikan feedback untuk peserta..."></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button id="batal-penilaian-btn" type="button" class="px-4 py-2 rounded-md hover:bg-gray-100 text-black border border-gray-300">Batal</button>
                    <button id="kirim-penilaian-btn" type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script dipanggil setelah semua HTML dimuat -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Variabel dan Elemen DOM ---
            const pesertaTableBody = document.getElementById('peserta-table-body');

            // Modal 1: Detail Peserta
            const detailModal = document.getElementById('detail-peserta-modal');
            const detailModalTitle = document.getElementById('detail-modal-title');
            const detailModalSubtitle = document.getElementById('detail-modal-subtitle');
            const tahapPenilaianList = document.getElementById('tahap-penilaian-list');
            const closeDetailModalBtn = document.getElementById('close-detail-modal-btn');

            // Modal 2: Form Penilaian
            const penilaianModal = document.getElementById('form-penilaian-modal');
            const penilaianForm = document.getElementById('penilaian-form');
            const formPenilaianTitle = document.getElementById('form-penilaian-title');
            const penilaianRegistrasiIdInput = document.getElementById('penilaian-registrasi-id');
            const penilaianTahapIdInput = document.getElementById('penilaian-tahap-id');
            const penilaianNilaiInput = document.getElementById('penilaian-nilai-input');
            const penilaianCatatanTextarea = document.getElementById('penilaian-catatan-textarea');
            const batalPenilaianBtn = document.getElementById('batal-penilaian-btn');
            const kirimPenilaianBtn = document.getElementById('kirim-penilaian-btn');

            let allRegistrations = []; // Variabel global untuk simpan data peserta

            // --- Helper Functions ---
            function formatDate(dateString) {
                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                return new Date(dateString).toLocaleDateString('id-ID', options);
            }

            function capitalize(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }

            function renderLombaDetails(lomba) {
                const container = document.getElementById('lomba-detail-container');
                const template = document.getElementById('lomba-detail-template');
                const clone = template.content.cloneNode(true);

                clone.getElementById('lomba-image').src = `/${lomba.foto_lomba}`;
                clone.getElementById('lomba-nama').textContent = lomba.nama_lomba;
                clone.getElementById('lomba-tingkat').textContent = lomba.tingkat;
                clone.getElementById('lomba-lokasi').textContent = lomba.lokasi;
                clone.getElementById('lomba-lokasi-offline').textContent = lomba.lokasi_offline;
                clone.getElementById('lomba-status').textContent = lomba.status.replace(/_/g, ' ');
                clone.getElementById('lomba-tanggal-akhir-registrasi').textContent = formatDate(lomba.tanggal_akhir_registrasi);
                clone.getElementById('lomba-tanggal-mulai').textContent = formatDate(lomba.tanggal_mulai_lomba);
                clone.getElementById('lomba-tanggal-selesai').textContent = formatDate(lomba.tanggal_selesai_lomba);
                clone.getElementById('penyelenggara-nama').textContent = lomba.penyelenggara || (lomba.pembuat ? lomba.pembuat.nama : 'Tidak diketahui');
                if (lomba.pembuat.foto_profile) {
                    clone.getElementById('penyelenggara-foto').src = `/${lomba.pembuat.foto_profile}`;
                }
                clone.getElementById('lomba-deskripsi').textContent = lomba.deskripsi;

                if (lomba.lokasi === 'online') {
                    clone.getElementById('detail-lokasi-container').remove();
                }

                const tagsContainer = clone.getElementById('lomba-tags');
                if (lomba.tags && lomba.tags.length > 0) {
                    lomba.tags.forEach(tag => {
                        const tagElement = document.createElement('span');
                        tagElement.className = 'bg-blue-100 text-blue-500 py-1 px-2 rounded-md font-semibold text-sm';
                        tagElement.textContent = tag.nama_tag;
                        tagsContainer.appendChild(tagElement);
                    });
                } else {
                    tagsContainer.innerHTML = '<p class="text-sm text-gray-500">Tidak ada tag.</p>';
                }

                const alasanContainer = clone.getElementById('alasan-penolakan-container');

                if (lomba.status === 'belum disetujui') {
                    alasanContainer.style.display = 'none'; // Pastikan alasan disembunyikan
                } else if (lomba.status === 'ditolak') {
                    // Tampilkan alasan penolakan jika ditolak
                    const alasanText = clone.getElementById('alasan-penolakan-text');
                    alasanText.textContent = lomba.alasan_penolakan || 'Tidak ada alasan yang diberikan.';
                    alasanContainer.classList.remove('hidden'); // Tampilkan kontainer alasan
                } else {
                    alasanContainer.style.display = 'none';
                }

                container.innerHTML = '';
                container.appendChild(clone);
            }

            // --- Fungsi untuk merender tabel peserta ---
            function renderPesertaTable(registrations) {
                allRegistrations = registrations;
                pesertaTableBody.innerHTML = '';
                if (!registrations || registrations.length === 0) {
                    pesertaTableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada peserta yang mendaftar.</td></tr>`;
                    return;
                }

                registrations.forEach((reg, index) => {
                    const row = document.createElement('tr');
                    row.className = 'bg-white bg-gray-50 hover:bg-gray-100';
                    const mahasiswa = reg.mahasiswa;
                    const profil = mahasiswa.profil_mahasiswa;

                    row.innerHTML = `
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">${mahasiswa.nama}</th>
                <td class="px-6 py-4">${profil ? profil.nim : '-'}</td>
                <td class="px-6 py-4">${profil?.program_studi?.nama_program_studi || '-'}</td>
                <td class="px-6 py-4 text-center">
                    <button class="detail-btn py-1 px-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 font-semibold" data-index="${index}">
                        Detail
                    </button>
                </td>
            `;
                    pesertaTableBody.appendChild(row);
                });
            }

            // --- Fungsi utama untuk mengambil semua data halaman ---
            async function loadPageData() {
                // ... (kode tidak berubah, tetap memanggil renderLombaDetails dan renderPesertaTable)
                const lombaId = window.location.pathname.split('/').pop();
                try {
                    const [lombaResponse, pesertaResponse] = await Promise.all([
                        axios.get(`/api/lomba/${lombaId}`),
                        axios.get(`/api/lomba/${lombaId}/pendaftar`)
                    ]);
                    if (lombaResponse.data.success) renderLombaDetails(lombaResponse.data.data);
                    if (pesertaResponse.data.success) renderPesertaTable(pesertaResponse.data.data);
                } catch (error) {
                    console.error(error); /* ... penanganan error ... */
                }
            }

            // --- Fungsi untuk membuka Modal 1 (Detail Peserta) ---
            async function showDetailModal(registration) {
                detailModalTitle.textContent = `Detail Penilaian`;
                detailModalSubtitle.textContent = `${registration.mahasiswa.nama}`;
                tahapPenilaianList.innerHTML = `<p class="text-center text-gray-500 p-4">Memuat data tahap...</p>`;
                detailModal.classList.remove('hidden');

                try {
                    const lombaId = window.location.pathname.split('/').pop();
                    const tahapResponse = await axios.get(`/api/lomba/${lombaId}/tahap`);
                    const allTahap = tahapResponse.data.data;
                    const existingScores = registration.penilaian || [];

                    tahapPenilaianList.innerHTML = '';
                    if (allTahap.length === 0) {
                        tahapPenilaianList.innerHTML = `<p class="text-center text-gray-500 p-4">Belum ada tahap lomba yang dibuat.</p>`;
                        return;
                    }

                    allTahap.forEach(tahap => {
                        const score = existingScores.find(p => p.id_tahap === tahap.id_tahap);
                        const listItem = document.createElement('div');
                        listItem.className = 'flex justify-between items-center text-sm p-3 rounded-md bg-gray-100';

                        let scoreOrButton;
                        if (score) {
                            scoreOrButton = `
                            <div class="flex flex-col justify-end">
                                <h2 class="font-bold text-end text-lg">${score.nilai}</h2>
                                <p class="text-gray-500 text-xs">${score.catatan}</p>
                            </div>
                            `;
                        } else {
                            scoreOrButton = `
                        <button class="beri-nilai-spesifik-btn bg-blue-500 text-white px-3 py-1 rounded-md text-xs font-semibold hover:bg-blue-600"
                                data-registrasi-id="${registration.id_registrasi_lomba}"
                                data-tahap-id="${tahap.id_tahap}"
                                data-tahap-nama="${tahap.nama_tahap}">
                            + Beri Nilai
                        </button>
                    `;
                        }

                        listItem.innerHTML = `
                    <span class="text-gray-800 font-medium">${tahap.nama_tahap}</span>
                    ${scoreOrButton}
                `;
                        tahapPenilaianList.appendChild(listItem);
                    });
                } catch (error) {
                    console.error('Gagal memuat tahap lomba:', error);
                    tahapPenilaianList.innerHTML = `<p class="text-center text-red-500 p-4">Gagal memuat data tahap.</p>`;
                }
            }

            function hideDetailModal() {
                detailModal.classList.add('hidden');
            }

            // --- Fungsi untuk membuka Modal 2 (Form Penilaian) ---
            function showPenilaianModal(registrasiId, tahapId, tahapNama) {
                formPenilaianTitle.textContent = `Beri Nilai untuk Tahap "${tahapNama}"`;
                penilaianForm.reset();
                penilaianRegistrasiIdInput.value = registrasiId;
                penilaianTahapIdInput.value = tahapId;
                penilaianModal.classList.remove('hidden');
                penilaianNilaiInput.focus();
            }

            function hidePenilaianModal() {
                penilaianModal.classList.add('hidden');
            }

            // --- Fungsi untuk mengirim data penilaian ---
            async function submitPenilaian() {
                kirimPenilaianBtn.disabled = true;
                kirimPenilaianBtn.textContent = 'Menyimpan...';

                const data = {
                    id_registrasi_lomba: penilaianRegistrasiIdInput.value,
                    id_tahap: penilaianTahapIdInput.value,
                    nilai: penilaianNilaiInput.value,
                    catatan: penilaianCatatanTextarea.value
                };

                try {
                    await axios.post('/api/penilaian', data);
                    hidePenilaianModal(); // Tutup modal form
                    hideDetailModal(); // Tutup modal detail juga
                    await loadPageData(); // Muat ulang seluruh data halaman
                } catch (error) {
                    const msg = error.response?.data?.message || 'Gagal menyimpan penilaian.';
                    alert(msg);
                } finally {
                    kirimPenilaianBtn.disabled = false;
                    kirimPenilaianBtn.textContent = 'Simpan';
                }
            }

            // --- Event Listeners ---
            pesertaTableBody.addEventListener('click', function(event) {
                const detailButton = event.target.closest('.detail-btn');
                if (detailButton) {
                    const index = detailButton.dataset.index;
                    const registration = allRegistrations[index];
                    if (registration) showDetailModal(registration);
                }
            });

            tahapPenilaianList.addEventListener('click', function(event) {
                const beriNilaiButton = event.target.closest('.beri-nilai-spesifik-btn');
                if (beriNilaiButton) {
                    const {
                        registrasiId,
                        tahapId,
                        tahapNama
                    } = beriNilaiButton.dataset;
                    showPenilaianModal(registrasiId, tahapId, tahapNama);
                }
            });

            penilaianForm.addEventListener('submit', function(e) {
                e.preventDefault();
                submitPenilaian();
            });

            closeDetailModalBtn.addEventListener('click', hideDetailModal);
            batalPenilaianBtn.addEventListener('click', hidePenilaianModal);

            // Panggil fungsi utama saat halaman dimuat
            loadPageData();
        });
    </script>
</body>

</html>