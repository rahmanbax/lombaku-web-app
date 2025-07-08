<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/lombaku-icon.png') }}" type="image/png">
    <title>Detail Lomba</title>
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
                            <th class="font-normal text-start pb-2 w-1/2">Jenis Lomba</th>
                            <td id="jenis-lomba" class="pb-2 capitalize"></td>
                        </tr>
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
                    <img id="penyelenggara-foto" alt="foto penyelenggara" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <p class="text-xs text-black/60">Penyelenggara</p>
                        <h1 id="penyelenggara-nama" class="font-semibold mt-1"></h1>
                    </div>
                </div>

                <h2 class="font-bold mt-6 text-xl">Deskripsi</h2>
                <div id="lomba-deskripsi-container">
                    <p id="lomba-deskripsi"></p>
                    <button id="toggle-deskripsi" class="text-blue-700 cursor-pointer mt-2">Lihat Selengkapnya</button>
                </div>
            </div>
        </template>

        <section class="lg:w-[1038px] mx-auto lg:px-0 mt-10">
            <h2 class="text-2xl font-bold mb-4">Daftar Peserta</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nama Peserta</th>
                            <th scope="col" class="px-6 py-3">NIM</th>
                            <th scope="col" class="px-6 py-3">Tim</th>
                            <th scope="col" class="px-6 py-3 text-center">Skor Rata-rata</th>
                            <th scope="col" class="px-6 py-3 text-center">Status</th>
                            <th scope="col" class="px-6 py-3 text-center">Detail</th>
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
                    <h3 class="text-xl font-semibold text-gray-900">Detail Pengumpulan</h3>
                    <p id="detail-modal-subtitle" class="text-sm text-gray-500 mt-1"></p>
                    <p id="detail-modal-deskripsi-pengumpulan" class=" mt-2"></p>
                    <p class="mt-2 text-sm text-black/60">Link Pengumpulan</p>
                    <a id="detail-modal-link-pengumpulan" class="text-sm text-blue-500 hover:underline"></a>
                </div>
                <button id="close-detail-modal-btn" type="button" class="text-gray-400 hover:text-gray-600 rounded-full p-1 -mt-2 -mr-2">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Konten Modal: Daftar Tahap -->
            <h3 class="text-xl font-semibold text-gray-900">Detail Penilaian</h3>
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
            <form id="penilaian-form" class="mt-4">
                <input type="hidden" id="penilaian-registrasi-id">
                <input type="hidden" id="penilaian-tahap-id">

                <div>
                    <label for="penilaian-nilai-input" class="block text-sm font-medium text-gray-700">Nilai (0-100)</label>
                    <input type="number" id="penilaian-nilai-input" placeholder="Masukkan nilai" min="0" max="100" required class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="penilaian-catatan-textarea" class="block text-sm font-medium text-gray-700 mt-3">Catatan (Opsional)</label>
                    <textarea id="penilaian-catatan-textarea" rows="3" class="w-full mt-2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan catatan"></textarea>
                </div>

                <div class="flex justify-end gap-2 mt-3">
                    <button id="batal-penilaian-btn" type="button" class="px-3 py-2 rounded-md hover:bg-gray-100 text-black border border-gray-300">Batal</button>
                    <button id="kirim-penilaian-btn" type="submit" class="px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 font-semibold">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 3: Untuk Form Pemberian Prestasi -->
    <div id="prestasi-modal" class="fixed inset-0 bg-black/50 overflow-y-auto h-full w-full hidden flex items-center justify-center">
        <div class="relative w-full max-w-lg shadow-lg rounded-lg bg-white p-6 mx-5 lg:mx-auto">
            <!-- Header Modal -->
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Kirim Sertifikat</h3>
                    <p id="prestasi-modal-subtitle" class="text-sm text-gray-500 mt-1">
                        <!-- Nama mahasiswa akan diisi oleh JS -->
                    </p>
                </div>
                <button id="close-prestasi-modal-btn" type="button" class="text-gray-400 hover:text-gray-600 rounded-full p-1 -mt-2 -mr-2">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Form Prestasi -->
            <form id="prestasi-form" class="mt-4 space-y-4">
                <!-- Hidden input untuk menyimpan data yang tidak perlu diisi user -->
                <input type="hidden" id="prestasi-registrasi-id">

                <!-- Field Peringkat -->
                <div>
                    <label for="prestasi-peringkat-input" class="block text-sm font-medium text-gray-700">Peringkat / Pencapaian</label>
                    <input type="text" name="peringkat" id="prestasi-peringkat-input" placeholder="Contoh: Juara 1, Finalis, Medali Emas" required class="w-full mt-1 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Field Tipe Prestasi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipe Prestasi </label>
                    <div class="flex items-center gap-6 mt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="tipe_prestasi" value="pemenang" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" checked>
                            <span>Pemenang</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="tipe_prestasi" value="peserta" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                            <span>Peserta</span>
                        </label>
                    </div>
                </div>

                <!-- Field Tanggal Diraih (disembunyikan dengan benar) -->
                <input type="hidden" name="tanggal_diraih" id="prestasi-tanggal-input" value="{{ date('Y-m-d') }}" required>

                <!-- Field Upload Sertifikat -->
                <div>
                    <label for="prestasi-sertifikat-file" class="block text-sm font-medium text-gray-700">Upload Sertifikat (PDF, JPG, PNG) </label>
                    <input type="file" id="prestasi-sertifikat-file" required accept=".pdf,.jpg,.jpeg,.png" class="w-full mt-1 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="mt-1 text-xs text-gray-500">Ukuran file maksimal 2MB.</p>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end gap-2">
                    <button id="batal-prestasi-btn" type="button" class="px-4 py-2 rounded-md hover:bg-gray-100 text-black border border-gray-300 font-semibold">Batal</button>
                    <button id="kirim-prestasi-btn" type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 font-bold flex items-center gap-2">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 4: Untuk Detail Tim -->
    <div id="tim-detail-modal" class="fixed inset-0 bg-black/50 overflow-y-auto h-full w-full flex items-center justify-center hidden">
        <div class="relative w-full max-w-lg shadow-lg rounded-lg bg-white p-6 mx-5 lg:mx-auto">
            <!-- Header Modal -->
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Detail Tim</h3>
                    <p id="tim-modal-nama" class="text-lg mt-4 font-medium"></p>
                </div>
                <button id="close-tim-modal-btn" type="button" class="text-gray-400 hover:text-gray-600 rounded-full p-1 -mt-2 -mr-2">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Konten Modal: Daftar Anggota Tim -->
            <div id="tim-modal-member-list" class="mt-2 space-y-2">
                <!-- Daftar anggota akan diisi oleh JS di sini -->
                <p class="text-center text-gray-500 p-4">Memuat data anggota...</p>
            </div>
        </div>
    </div>

    <!-- Script dipanggil setelah semua HTML dimuat -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Variabel dan Elemen DOM ---
            const pesertaTableBody = document.getElementById('peserta-table-body');

            // Modal 1: Detail Peserta
            const detailModal = document.getElementById('detail-peserta-modal');
            const detailModalSubtitle = document.getElementById('detail-modal-subtitle');
            const detailModalDeskripsi = document.getElementById('detail-modal-deskripsi-pengumpulan');
            const detailModalLink = document.getElementById('detail-modal-link-pengumpulan');
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

            // --- BARU: Modal 3: Form Prestasi ---
            const prestasiModal = document.getElementById('prestasi-modal');
            const prestasiForm = document.getElementById('prestasi-form');
            const prestasiModalSubtitle = document.getElementById('prestasi-modal-subtitle');
            const prestasiRegistrasiIdInput = document.getElementById('prestasi-registrasi-id');
            const closePrestasiModalBtn = document.getElementById('close-prestasi-modal-btn');
            const batalPrestasiBtn = document.getElementById('batal-prestasi-btn');
            const kirimPrestasiBtn = document.getElementById('kirim-prestasi-btn');

            // [BARU] Elemen untuk Modal Detail Tim
            const timDetailModal = document.getElementById('tim-detail-modal');
            const timModalNama = document.getElementById('tim-modal-nama');
            const timModalMemberList = document.getElementById('tim-modal-member-list');
            const closeTimModalBtn = document.getElementById('close-tim-modal-btn');

            let allRegistrations = []; // Variabel global untuk simpan data peserta
            let totalTahapLomba = 0;

            // --- Helper Functions ---
            function formatDate(dateString) {
                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                return new Date(dateString).toLocaleDateString('id-ID', options);
            }

            function renderLombaDetails(lomba) {
                const container = document.getElementById('lomba-detail-container');
                const template = document.getElementById('lomba-detail-template');
                const clone = template.content.cloneNode(true);
                const maxLength = 250; // batas karakter sebelum dipotong
                const deskripsiPenuh = lomba.deskripsi;
                const deskripsiPendek = deskripsiPenuh.length > maxLength ?
                    deskripsiPenuh.substring(0, maxLength) + '...' :
                    deskripsiPenuh;

                const deskripsiEl = clone.getElementById('lomba-deskripsi');
                const tombolToggle = clone.getElementById('toggle-deskripsi');

                // Default: tampilkan deskripsi pendek
                deskripsiEl.innerHTML = deskripsiPendek.replace(/\n/g, '<br>');
                tombolToggle.style.display = deskripsiPenuh.length > maxLength ? 'inline' : 'none';

                let expanded = false;

                tombolToggle.addEventListener('click', () => {
                    expanded = !expanded;
                    deskripsiEl.innerHTML = (expanded ? deskripsiPenuh : deskripsiPendek).replace(/\n/g, '<br>');
                    tombolToggle.textContent = expanded ? 'Sembunyikan' : 'Lihat Selengkapnya';
                });

                clone.getElementById('lomba-image').src = `/storage/${lomba.foto_lomba}`;
                clone.getElementById('lomba-nama').textContent = lomba.nama_lomba;
                clone.getElementById('lomba-tingkat').textContent = lomba.tingkat;
                clone.getElementById('jenis-lomba').textContent = lomba.jenis_lomba;
                clone.getElementById('lomba-lokasi').textContent = lomba.lokasi;
                clone.getElementById('lomba-lokasi-offline').textContent = lomba.lokasi_offline;
                clone.getElementById('lomba-status').textContent = lomba.status.replace(/_/g, ' ');
                clone.getElementById('lomba-tanggal-akhir-registrasi').textContent = formatDate(lomba.tanggal_akhir_registrasi);
                clone.getElementById('lomba-tanggal-mulai').textContent = formatDate(lomba.tanggal_mulai_lomba);
                clone.getElementById('lomba-tanggal-selesai').textContent = formatDate(lomba.tanggal_selesai_lomba);
                clone.getElementById('penyelenggara-nama').textContent = lomba.penyelenggara || (lomba.pembuat ? lomba.pembuat.nama : 'Tidak diketahui');
                if (lomba.pembuat.foto_profile) {
                    clone.getElementById('penyelenggara-foto').src = `/storage/${lomba.pembuat.foto_profile}`;
                }

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

                // Perbarui colspan menjadi 6 sesuai jumlah kolom baru
                if (!registrations || registrations.length === 0) {
                    pesertaTableBody.innerHTML = `<tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada peserta yang mendaftar.</td></tr>`;
                    return;
                }

                registrations.forEach((reg, index) => {
                    const row = document.createElement('tr');
                    row.className = 'bg-white hover:bg-gray-50'; // Gaya baris diubah sedikit untuk konsistensi
                    const mahasiswa = reg.mahasiswa;

                    // --- Persiapan Variabel untuk Kolom yang Membutuhkan Logika ---
                    // Variabel ini disiapkan di sini agar innerHTML tetap rapi.

                    // 1. Variabel untuk Skor Rata-rata
                    let skorRataRataHtml = 'Belum dinilai';
                    if (reg.penilaian && reg.penilaian.length > 0) {
                        const totalSkor = reg.penilaian.reduce((sum, item) => sum + item.nilai, 0);
                        const avg = totalSkor / reg.penilaian.length;
                        skorRataRataHtml = avg;
                    }

                    // 2. Variabel untuk Status
                    const existingPrestasi = mahasiswa.prestasi.find(p => p.id_lomba == reg.id_lomba);
                    const statusHtml = existingPrestasi ?
                        `<span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 text-nowrap rounded-full">Selesai Dinilai</span>` :
                        `<span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 text-nowrap rounded-full">Butuh Penilaian</span>`;

                    let timHtml;
                    if (reg.tim) {
                        // Jika objek 'reg.tim' ada (tidak null atau undefined), maka ini adalah lomba tim.
                        // Buat tombol yang bisa diklik untuk membuka modal.
                        timHtml = `<button class="tim-detail-btn hover:underline cursor-pointer" data-reg-index="${index}">${reg.tim.nama_tim}</button>`;
                    } else {
                        // Jika objek 'reg.tim' tidak ada, maka ini adalah pendaftar individu.
                        // Tampilkan teks "Individu" dengan warna abu-abu agar tidak terlalu menonjol.
                        timHtml = `<span class="">Individu</span>`;
                    }


                    // --- [BAGIAN UTAMA YANG DIUBAH] ---
                    // innerHTML diubah untuk mencocokkan 6 kolom yang Anda minta.
                    // Data simpel diambil langsung, data yang butuh logika menggunakan variabel di atas.
                    row.innerHTML = `
            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">${mahasiswa.nama}</td>
            <td class="px-6 py-4">${mahasiswa.profil_mahasiswa?.nim || '-'}</td>
            <td class="px-6 py-4">${timHtml}</td>
            <td class="px-6 py-4 text-center">${skorRataRataHtml}</td>
            <td class="px-6 py-4 text-center">${statusHtml}</td>
            <td class="px-6 py-4 text-center">
                <button class="detail-btn py-1 px-3 bg-blue-500 text-white rounded-md text-xs hover:bg-blue-600 font-semibold" data-index="${index}">
                    Nilai
                </button>
            </td>
        `;

                    pesertaTableBody.appendChild(row);
                });
            }

            // --- Fungsi utama untuk mengambil semua data halaman ---
            async function loadPageData() {
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

            function showTimDetailModal(tim) {
                timDetailModal.classList.remove('hidden');
                timModalNama.textContent = tim.nama_tim;
                timModalMemberList.innerHTML = '';

                // Data anggota sekarang langsung diambil dari 'tim.members'
                if (tim.members && tim.members.length > 0) {
                    tim.members.forEach(member => {
                        const memberDiv = document.createElement('div');
                        memberDiv.className = 'p-3 bg-gray-100 rounded-lg';

                        const nama = member.nama;
                        const nim = member.profil_mahasiswa?.nim || 'N/A';
                        const prodi = member.profil_mahasiswa?.program_studi?.nama_program_studi || 'N/A';

                        memberDiv.innerHTML = `
                <p class="font-semibold text-gray-800">${nama}</p>
                <p class="text-sm text-gray-500">${nim} - ${prodi}</p>
            `;
                        timModalMemberList.appendChild(memberDiv);
                    });
                } else {
                    timModalMemberList.innerHTML = `<p class="text-center text-gray-500 p-4">Tidak ada anggota ditemukan.</p>`;
                }
            }


            // --- Fungsi untuk membuka Modal 1 (Detail Peserta) ---
            async function showDetailModal(registration) {
                detailModalSubtitle.textContent = `${registration.mahasiswa.nama}`;
                detailModalDeskripsi.textContent = `${registration.deskripsi_pengumpulan}`;
                detailModalLink.textContent = `${registration.link_pengumpulan}`;
                detailModalLink.href = `${registration.link_pengumpulan}`;
                tahapPenilaianList.innerHTML = `<p class="text-center text-gray-500 p-4">Memuat data tahap...</p>`;
                detailModal.classList.remove('hidden');

                try {
                    const lombaId = window.location.pathname.split('/').pop();
                    const tahapResponse = await axios.get(`/api/lomba/${lombaId}/tahap`);

                    const allTahap = tahapResponse.data.data;
                    const totalTahapLomba = allTahap.length;
                    const existingScores = registration.penilaian || [];

                    // --- [PERUBAHAN 1] ---
                    // Cek status prestasi SEKALI di awal untuk efisiensi.
                    const existingPrestasi = registration.mahasiswa.prestasi.find(p => p.id_lomba == registration.id_lomba);
                    const isPrestasiDiberikan = !!existingPrestasi; // Akan bernilai true jika prestasi ada, false jika tidak.

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
                            // --- [PERUBAHAN 2] ---
                            // Tambahkan pengecekan apakah prestasi sudah diberikan.
                            if (isPrestasiDiberikan) {
                                // Jika sudah, tampilkan nilai saja TANPA tombol edit.
                                scoreOrButton = `
                    <div class="flex flex-col items-end justify-end">
                        <h2 class="font-bold text-end text-lg">${score.nilai}</h2>
                        <p class="text-gray-500 text-end text-xs">${score.catatan || ''}</p>
                    </div>
                    `;
                            } else {
                                // Jika belum, tampilkan nilai DENGAN tombol edit.
                                scoreOrButton = `
                    <div class="flex flex-col items-end justify-end">
                        <h2 class="font-bold text-end text-lg">${score.nilai}</h2>
                        <p class="text-gray-500 text-end text-xs">${score.catatan || ''}</p>
                        <button class="mt-2 w-fit edit-nilai-btn text-blue-500 hover:bg-blue-100 border border-blue-500 px-3 py-1 flex items-center justify-center rounded-md hover:bg-blue-100 flex gap-1 text-xs"
                            title="Edit Nilai"
                            data-penilaian-id="${score.id_penilaian}" 
                            data-nilai-lama="${score.nilai}"
                            data-catatan-lama="${score.catatan || ''}"
                            data-tahap-nama="${tahap.nama_tahap}">
                            <span class="material-symbols-outlined" style="font-size: 10px;">edit</span>Edit
                        </button>
                    </div>
                    `;
                            }
                        } else {
                            // Jika belum ada nilai sama sekali, tampilkan tombol "Beri Nilai".
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

                    // Logika untuk menampilkan tombol "Berikan Prestasi" atau pesan status tetap sama
                    if (existingScores.length === totalTahapLomba && totalTahapLomba > 0) {
                        const actionContainer = document.createElement('div');

                        if (existingPrestasi) {
                            // SUDAH ADA PRESTASI: Tampilkan pesan status.
                            actionContainer.innerHTML = `
                <div class="w-full border border-green-500 rounded-md p-2 bg-green-50 text-center flex flex-col items-center">
                    <p class="text-xs text-green-800">Prestasi Telah Diberikan</p>
                    <p class="text-green-700 mt-1">Peringkat: <span class="font-bold">${existingPrestasi.peringkat}</span></p>
                    <a href="/${existingPrestasi.sertifikat_path}" target="_blank" class="mt-2 px-3 py-1 border border-green-500 text-green-600 rounded-md text-xs hover:bg-green-100 flex items-center gap-1 w-fit"><span class="material-symbols-outlined" style="font-size: 16px;">visibility</span> Lihat Sertifikat
                        </a>
                </div>
                `;
                        } else {
                            // BELUM ADA PRESTASI: Tampilkan tombol untuk memberikan.
                            actionContainer.innerHTML = `
                <div class="w-full border border-blue-500 rounded-md p-2 bg-blue-50 mb-2">
                    <p class="text-xs text-center text-blue-700">Semua tahap telah dinilai. Silakan berikan prestasi dan sertifikat.</p>
                </div>
                <button id="beri-prestasi-btn" 
                        data-registrasi-id="${registration.id_registrasi_lomba}"
                        class="w-full bg-blue-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-blue-700 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined" style="font-size: 16px;">military_tech</span>
                    Berikan Prestasi
                </button>
                `;
                        }
                        tahapPenilaianList.appendChild(actionContainer);
                    }
                } catch (error) {
                    console.error('Gagal memuat tahap lomba:', error);
                    tahapPenilaianList.innerHTML = `<p class="text-center text-red-500 p-4">Gagal memuat data tahap.</p>`;
                }
            }

            // Gantikan fungsi openPrestasiModal yang lama dengan yang baru ini:
            function openPrestasiModal(options) {
                prestasiForm.reset();

                if (options.mode === 'edit') {
                    // --- MODE EDIT ---
                    const {
                        prestasi
                    } = options;
                    prestasiForm.dataset.mode = 'edit';
                    prestasiForm.dataset.prestasiId = prestasi.id_prestasi; // Simpan ID prestasi untuk URL update

                    document.getElementById('prestasi-modal').querySelector('h3').textContent = "Edit Prestasi / Sertifikat";
                    prestasiModalSubtitle.textContent = `Untuk: ${options.mahasiswaNama}`;

                    document.getElementById('prestasi-peringkat-input').value = prestasi.peringkat;
                    document.getElementById('prestasi-tanggal-input').value = prestasi.tanggal_diraih;
                    document.querySelector(`input[name="tipe_prestasi"][value="${prestasi.tipe_prestasi}"]`).checked = true;

                    // Buat field sertifikat tidak wajib saat edit
                    document.getElementById('prestasi-sertifikat-file').required = false;

                } else {
                    // --- MODE CREATE ---
                    const {
                        registration
                    } = options;
                    prestasiForm.dataset.mode = 'create';

                    document.getElementById('prestasi-modal').querySelector('h3').textContent = "Kirim Sertifikat";
                    prestasiModalSubtitle.textContent = `Untuk: ${registration.mahasiswa.nama}`;

                    prestasiForm.dataset.userId = registration.mahasiswa.id_user;
                    prestasiForm.dataset.lombaId = registration.id_lomba;

                    // Buat field sertifikat wajib saat create
                    document.getElementById('prestasi-sertifikat-file').required = true;
                }

                prestasiModal.classList.remove('hidden');
            }

            function hidePrestasiModal() {
                prestasiModal.classList.add('hidden');
            }

            function hideDetailModal() {
                detailModal.classList.add('hidden');
            }

            function hidePenilaianModal() {
                penilaianModal.classList.add('hidden');
            }

            function hideTimDetailModal() {
                timDetailModal.classList.add('hidden');
            }

            async function refreshDataAfterSubmit() {
                hidePenilaianModal(); // Tutup modal form penilaian
                hideDetailModal(); // Tutup juga modal detail peserta

                // Panggil kembali fungsi yang memuat semua data dari awal
                await loadPageData();

                // Beri sedikit jeda agar pengguna melihat perubahan di tabel
                // sebelum mungkin membuka modal lagi
            }

            function openPenilaianModal(options) {
                penilaianForm.reset();

                if (options.mode === 'edit') {
                    // Mode EDIT
                    formPenilaianTitle.textContent = `Edit Nilai untuk Tahap: ${options.tahapNama}`;
                    penilaianForm.dataset.mode = 'edit';
                    penilaianForm.dataset.penilaianId = options.penilaianId; // ID untuk URL PUT
                    penilaianNilaiInput.value = options.nilaiLama;
                    penilaianCatatanTextarea.value = options.catatanLama;
                } else {
                    // Mode CREATE (Default)
                    formPenilaianTitle.textContent = `Beri Nilai untuk Tahap: ${options.tahapNama}`;
                    penilaianForm.dataset.mode = 'create';
                    penilaianForm.dataset.registrasiId = options.registrasiId; // ID untuk data POST
                    penilaianForm.dataset.tahapId = options.tahapId; // ID untuk data POST
                }

                penilaianModal.classList.remove('hidden');
                penilaianNilaiInput.focus();
            }

            // --- Event Listeners ---
            pesertaTableBody.addEventListener('click', function(event) {
                const detailButton = event.target.closest('.detail-btn');
                const timDetailButton = event.target.closest('.tim-detail-btn');
                if (detailButton) {
                    const index = detailButton.dataset.index;
                    const registration = allRegistrations[index];
                    if (registration) showDetailModal(registration);
                }
                if (timDetailButton) {
                    // Ambil index registrasi dari tombol
                    const regIndex = timDetailButton.dataset.regIndex;
                    // Dapatkan objek registrasi lengkap dari array
                    const registration = allRegistrations[regIndex];
                    // Panggil fungsi dengan objek 'tim' dari registrasi tersebut
                    if (registration && registration.tim) {
                        showTimDetailModal(registration.tim);
                    }
                }
            });

            // Gantikan event listener tahapPenilaianList yang lama dengan yang baru ini:
            tahapPenilaianList.addEventListener('click', function(event) {
                const beriNilaiButton = event.target.closest('.beri-nilai-spesifik-btn');
                const editNilaiButton = event.target.closest('.edit-nilai-btn');
                const beriPrestasiButton = event.target.closest('#beri-prestasi-btn');
                const editPrestasiButton = event.target.closest('#edit-prestasi-btn'); // <-- BARU

                if (beriNilaiButton) {
                    // ... (kode ini tetap sama)
                    const {
                        registrasiId,
                        tahapId,
                        tahapNama
                    } = beriNilaiButton.dataset;
                    openPenilaianModal({
                        mode: 'create',
                        registrasiId,
                        tahapId,
                        tahapNama
                    });
                } else if (editNilaiButton) {
                    // ... (kode ini tetap sama)
                    const {
                        penilaianId,
                        nilaiLama,
                        catatanLama,
                        tahapNama
                    } = editNilaiButton.dataset;
                    openPenilaianModal({
                        mode: 'edit',
                        penilaianId,
                        nilaiLama,
                        catatanLama,
                        tahapNama
                    });
                } else if (beriPrestasiButton) {
                    // --- MODE CREATE ---
                    const registrasiId = beriPrestasiButton.dataset.registrasiId;
                    const registration = allRegistrations.find(reg => reg.id_registrasi_lomba == registrasiId);
                    if (registration) {
                        openPrestasiModal({
                            mode: 'create',
                            registration: registration
                        });
                    }
                } else if (editPrestasiButton) {
                    // --- BARU: MODE EDIT ---
                    const prestasiId = editPrestasiButton.dataset.prestasiId;
                    // Cari data registrasi yang relevan, lalu cari prestasi di dalamnya
                    const registration = allRegistrations.find(reg => reg.mahasiswa.prestasi.some(p => p.id_prestasi == prestasiId));
                    if (registration) {
                        const prestasi = registration.mahasiswa.prestasi.find(p => p.id_prestasi == prestasiId);
                        openPrestasiModal({
                            mode: 'edit',
                            prestasi: prestasi,
                            mahasiswaNama: registration.mahasiswa.nama
                        });
                    }
                }
            });

            penilaianForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                kirimPenilaianBtn.disabled = true;

                const mode = penilaianForm.dataset.mode;
                const data = {
                    nilai: penilaianNilaiInput.value,
                    catatan: penilaianCatatanTextarea.value,
                };

                try {
                    if (mode === 'edit') {
                        const penilaianId = penilaianForm.dataset.penilaianId;
                        await axios.put(`/api/penilaian/${penilaianId}`, data);
                        alert('Penilaian berhasil diperbarui!');
                    } else { // mode 'create'
                        data.id_registrasi_lomba = penilaianForm.dataset.registrasiId;
                        data.id_tahap = penilaianForm.dataset.tahapId;
                        await axios.post('/api/penilaian', data);
                        alert('Penilaian berhasil disimpan!');
                    }
                    await refreshDataAfterSubmit();
                } catch (error) {
                    const msg = error.response?.data?.message || 'Gagal menyimpan penilaian.';
                    alert(msg);
                } finally {
                    kirimPenilaianBtn.disabled = false;
                    kirimPenilaianBtn.textContent = 'Simpan';
                }
            });

            // Gantikan event listener prestasiForm yang lama dengan yang baru ini:
            prestasiForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                kirimPrestasiBtn.disabled = true;
                kirimPrestasiBtn.innerHTML = 'Mengirim...';

                const mode = prestasiForm.dataset.mode;
                const formData = new FormData(); // FormData lebih fleksibel untuk kedua mode

                // Ambil data umum dari form
                formData.append('peringkat', document.getElementById('prestasi-peringkat-input').value);
                formData.append('tipe_prestasi', document.querySelector('input[name="tipe_prestasi"]:checked').value);
                formData.append('peringkat', document.getElementById('prestasi-peringkat-input').value);
                formData.append('tipe_prestasi', document.querySelector('input[name="tipe_prestasi"]:checked').value);

                // 2. [FIX] Ambil dan tambahkan tanggal dari hidden input
                formData.append('tanggal_diraih', document.getElementById('prestasi-tanggal-input').value);

                // 3. [FIX] Ambil file dan tambahkan ke FormData JIKA ADA.
                //    Kunci 'sertifikat_path' harus sesuai dengan yang diharapkan oleh validasi backend Anda.
                const sertifikatFile = document.getElementById('prestasi-sertifikat-file').files[0];
                if (sertifikatFile) {
                    formData.append('sertifikat', sertifikatFile);
                }

                try {
                    if (mode === 'edit') {
                        // --- LOGIKA UPDATE ---
                        const prestasiId = prestasiForm.dataset.prestasiId;
                        formData.append('_method', 'PUT');
                        await axios.post(`/api/prestasi/${prestasiId}`, formData);
                        alert('Prestasi berhasil diperbarui!');
                        location.reload();
                    } else {
                        // --- LOGIKA CREATE ---
                        formData.append('id_user', prestasiForm.dataset.userId);
                        formData.append('id_lomba', prestasiForm.dataset.lombaId);
                        await axios.post('/api/prestasi/berikan', formData);
                        alert('Prestasi berhasil disimpan dan sertifikat terkirim!');
                        location.reload();
                    }

                    hidePrestasiModal();
                    await loadPageData(); // Refresh data halaman

                } catch (error) {
                    const msg = error.response?.data?.message || 'Gagal menyimpan prestasi.';
                    const errors = error.response?.data?.errors;
                    let errorDetails = '';
                    if (errors) {
                        errorDetails = Object.values(errors).map(err => `\n- ${err[0]}`).join('');
                    }
                    alert(msg + errorDetails);
                } finally {
                    kirimPrestasiBtn.disabled = false;
                    kirimPrestasiBtn.innerHTML = 'Kirim';
                }
            });

            closeDetailModalBtn.addEventListener('click', hideDetailModal);
            batalPenilaianBtn.addEventListener('click', hidePenilaianModal);
            closePrestasiModalBtn.addEventListener('click', hidePrestasiModal);
            batalPrestasiBtn.addEventListener('click', hidePrestasiModal);
            closeTimModalBtn.addEventListener('click', hideTimDetailModal);


            // Panggil fungsi utama saat halaman dimuat
            loadPageData();
        });
    </script>
</body>

</html>