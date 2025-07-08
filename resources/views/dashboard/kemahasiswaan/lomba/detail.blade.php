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
                    <button id="toggle-deskripsi" class="text-blue-700 mt-2 cursor-pointer">Lihat Selengkapnya</button>
                </div>


                <!-- Kontainer Aksi Persetujuan/Penolakan -->
                <div id="lomba-aksi" class="flex gap-2 mt-6 hidden">
                    <button class="w-full py-2 px-2 text-red-500 border border-red-500 rounded-lg font-semibold hover:bg-red-100 tolak-lomba-btn cursor-pointer">Tolak</button>
                    <button class="w-full py-2 px-2 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 setujui-lomba-btn cursor-pointer">Setujui</button>
                </div>
            </div>
        </template>

        <section class="lg:w-[1038px] mx-auto lg:px-0 mt-10">
            <h2 class="text-2xl font-bold mb-4">Daftar Peserta</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left overflow-hidden rounded-md">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nama Mahasiswa</th>
                            <th scope="col" class="px-6 py-3">NIM</th>
                            <th scope="col" class="px-6 py-3">Program Studi</th>
                            <th scope="col" class="px-6 py-3">Nama Tim</th>
                            <th scope="col" class="px-6 py-3">Pembimbing</th>
                            <th scope="col" class="px-6 py-3 text-center">Status Pendaftaran</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="peserta-table-body">
                        <!-- Loading state -->
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Memuat data peserta...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Modal untuk Konfirmasi Persetujuan -->
    <div id="setujui-lomba-modal" class="fixed inset-0 bg-black/50 overflow-y-auto h-full w-full flex items-center justify-center hidden">
        <div class="relative w-full max-w-md shadow-lg rounded-lg bg-white p-6 mx-5 lg:mx-auto">
            <h3 class="text-lg font-medium text-gray-900">Konfirmasi Persetujuan</h3>
            <form id="setujui-lomba-form">
                <input type="hidden" id="setujui-lomba-id">
                <p class="mt-2 text-gray-600">Apakah Anda yakin ingin menyetujui lomba ini? Tindakan ini akan mengubah status lomba menjadi "Disetujui".</p>
                <div class="flex justify-end gap-2 mt-4">
                    <button id="batal-setujui-btn" type="button" class="px-4 py-2 rounded-md hover:bg-gray-100 text-black border border-gray-300">Batal</button>
                    <button id="kirim-persetujuan-btn" type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 font-semibold">Ya, Setujui</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal untuk Alasan Penolakan -->
    <div id="tolak-lomba-modal" class="fixed inset-0 bg-black/50 overflow-y-auto h-full w-full flex items-center justify-center hidden">
        <div class="relative w-full max-w-md shadow-lg rounded-lg bg-white p-6 mx-5 lg:mx-auto">
            <h3 class="text-lg font-medium text-gray-900">Alasan Penolakan</h3>
            <form id="tolak-lomba-form">
                <input type="hidden" id="tolak-lomba-id">
                <label for="alasan-penolakan-textarea" class="block text-sm font-medium text-gray-700 mt-3">Alasan</label>
                <textarea id="alasan-penolakan-textarea" rows="2" class="w-full mt-1 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan alasan penolakan lomba" required></textarea>
                <div class="flex justify-end gap-2 mt-3">
                    <button id="batal-tolak-btn" type="button" class="px-4 py-2 rounded-md hover:bg-gray-100 text-black border border-gray-300">Batal</button>
                    <button id="kirim-penolakan-btn" type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 font-semibold">Tolak</button>
                </div>
            </form>
        </div>
    </div>

    <div id="team-detail-modal" class="fixed inset-0 bg-black/50 overflow-y-auto h-full w-full flex items-center justify-center hidden">
        <div class="relative w-full max-w-md shadow-lg rounded-lg bg-white p-6 mx-5 lg:mx-auto">
            <!-- Header Modal -->
            <div class="flex justify-between items-start">
                <h3 id="team-modal-title" class="text-xl font-semibold text-gray-900">Detail Tim</h3>
                <button id="close-team-modal-btn" type="button" class="text-gray-400 hover:text-gray-600 rounded-full p-1 -mt-2 -mr-2">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Konten Modal: Daftar Anggota -->
            <div id="team-member-list" class="mt-4 space-y-3 max-h-80 overflow-y-auto pr-2">
                <!-- Daftar anggota akan diisi oleh JavaScript di sini -->
                <p class="text-center text-gray-500 p-4">Memuat data anggota...</p>
            </div>
        </div>
    </div>

    <!-- [BARU] Modal untuk Detail Pengumpulan & Penilaian Peserta -->
    <div id="submission-detail-modal" class="fixed inset-0 bg-black/50 overflow-y-auto h-full w-full flex items-center justify-center hidden">
        <div class="relative w-full max-w-xl shadow-lg rounded-lg bg-white p-6 mx-5 lg:mx-auto">
            <!-- Header Modal -->
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Detail Pengumpulan</h3>
                    <p id="submission-modal-subtitle" class="text-sm text-gray-500 mt-1"></p> <!-- Nama Mahasiswa -->
                </div>
                <button id="close-submission-modal-btn" type="button" class="text-gray-400 hover:text-gray-600 rounded-full p-1 -mt-2 -mr-2">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Detail Submission -->
            <div class="mt-4">
                <p class="text-sm font-medium text-gray-700">Deskripsi Pengumpulan</p>
                <p id="submission-modal-deskripsi" class="mt-1"></p>
                <p class="mt-4 text-sm font-medium text-gray-700">Link Pengumpulan:</p>
                <a id="submission-modal-link" href="#" target="_blank" rel="noopener noreferrer" class="mt-1 text-blue-600 hover:underline break-all"></a>
            </div>

            <!-- Daftar Tahap & Penilaian -->
            <div class="mt-6">
                <h4 class="text-lg font-semibold text-gray-800">Hasil Penilaian</h4>
                <div id="tahap-penilaian-list" class="mt-3 space-y-2 max-h-60 overflow-y-auto pr-2">
                    <!-- Daftar tahap dan nilai akan diisi oleh JavaScript di sini -->
                    <p class="text-center text-gray-500 p-4">Memuat data penilaian...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Script dipanggil setelah semua HTML dimuat -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Variabel dan Elemen DOM ---
            const lombaDetailContainer = document.getElementById('lomba-detail-container');
            const pesertaTableBody = document.getElementById('peserta-table-body');

            // Modal Persetujuan
            const setujuiLombaModal = document.getElementById('setujui-lomba-modal');
            const setujuiLombaForm = document.getElementById('setujui-lomba-form');
            const setujuiLombaIdInput = document.getElementById('setujui-lomba-id');
            const batalSetujuiBtn = document.getElementById('batal-setujui-btn');

            // Modal Penolakan
            const tolakLombaModal = document.getElementById('tolak-lomba-modal');
            const tolakLombaForm = document.getElementById('tolak-lomba-form');
            const tolakLombaIdInput = document.getElementById('tolak-lomba-id');
            const alasanTextarea = document.getElementById('alasan-penolakan-textarea');
            const batalTolakBtn = document.getElementById('batal-tolak-btn');

            const teamDetailModal = document.getElementById('team-detail-modal');
            const closeTeamModalBtn = document.getElementById('close-team-modal-btn');
            const teamModalTitle = document.getElementById('team-modal-title');
            const teamMemberList = document.getElementById('team-member-list');

            // [BARU] Tambahkan variabel untuk modal detail submission
            const submissionDetailModal = document.getElementById('submission-detail-modal');
            const closeSubmissionModalBtn = document.getElementById('close-submission-modal-btn');
            const submissionModalSubtitle = document.getElementById('submission-modal-subtitle');
            const submissionModalDeskripsi = document.getElementById('submission-modal-deskripsi');
            const submissionModalLink = document.getElementById('submission-modal-link');
            const tahapPenilaianList = document.getElementById('tahap-penilaian-list');

            let allLombaStages = [];

            // --- Helper Functions ---
            function formatDate(dateString) {
                if (!dateString) return '-';
                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                return new Date(dateString).toLocaleDateString('id-ID', options);
            }

            function getStatusBadge(status) {
                status = status.toLowerCase();
                let bgColor, textColor;
                switch (status) {
                    case 'diterima': // Ganti 'disetujui' menjadi 'diterima'
                        bgColor = 'bg-green-100';
                        textColor = 'text-green-700';
                        break;
                    case 'ditolak':
                        bgColor = 'bg-red-100';
                        textColor = 'text-red-700';
                        break;
                    case 'menunggu': // Tambahkan case spesifik untuk 'menunggu'
                        bgColor = 'bg-gray-200';
                        textColor = 'text-gray-500';
                        break;
                    default: // Default case sebagai fallback jika ada status tak terduga
                        bgColor = 'bg-gray-200';
                        textColor = 'text-gray-500';
                        break;
                }
                const formattedStatus = status.replace(/_/g, ' ');
                return `<span class="px-2 py-1 text-xs font-medium rounded-md ${bgColor} ${textColor}">${formattedStatus}</span>`;
            }

            // --- Fungsi untuk merender detail lomba ---
            function renderLombaDetails(lomba) {
                const container = document.getElementById('lomba-detail-container');
                const template = document.getElementById('lomba-detail-template');
                const clone = template.content.cloneNode(true);
                const maxLength = 200; // batas karakter sebelum dipotong
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
                clone.getElementById('lomba-lokasi-offline').textContent = lomba.lokasi_offline || '-';
                clone.getElementById('lomba-status').textContent = lomba.status.replace(/_/g, ' ');
                clone.getElementById('lomba-tanggal-akhir-registrasi').textContent = formatDate(lomba.tanggal_akhir_registrasi);
                clone.getElementById('lomba-tanggal-mulai').textContent = formatDate(lomba.tanggal_mulai_lomba);
                clone.getElementById('lomba-tanggal-selesai').textContent = formatDate(lomba.tanggal_selesai_lomba);
                clone.getElementById('penyelenggara-nama').textContent = lomba.penyelenggara || (lomba.pembuat ? lomba.pembuat.nama : 'Tidak diketahui');
                if (lomba.pembuat && lomba.pembuat.foto_profile) {
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

                const aksiContainer = clone.getElementById('lomba-aksi');
                const alasanContainer = clone.getElementById('alasan-penolakan-container');

                if (lomba.status === 'belum disetujui') {
                    clone.querySelector('.setujui-lomba-btn').dataset.id = lomba.id_lomba;
                    clone.querySelector('.tolak-lomba-btn').dataset.id = lomba.id_lomba;
                    aksiContainer.classList.remove('hidden');
                } else if (lomba.status === 'ditolak') {
                    const alasanText = clone.getElementById('alasan-penolakan-text');
                    alasanText.textContent = lomba.alasan_penolakan || 'Tidak ada alasan yang diberikan.';
                    alasanContainer.classList.remove('hidden');
                }

                container.innerHTML = '';
                container.appendChild(clone);
            }

            // --- Fungsi untuk merender tabel peserta ---
            function renderPesertaTable(registrations) {
                pesertaTableBody.innerHTML = '';
                if (!registrations || registrations.length === 0) {
                    pesertaTableBody.innerHTML = `<tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada peserta yang mendaftar.</td></tr>`;
                    return;
                }
                registrations.forEach(reg => {
                    const row = document.createElement('tr');
                    row.className = 'bg-white bg-gray-50 hover:bg-gray-100';
                    const mahasiswa = reg.mahasiswa;
                    const profil = mahasiswa?.profil_mahasiswa;

                    const timHtml = reg.tim
                        // Jika ada tim, buat tombol. Simpan data tim lengkap di 'data-team'
                        ?
                        `<button class="view-team-btn text-start hover:underline " data-team='${JSON.stringify(reg.tim)}'>
                   ${reg.tim.nama_tim}
               </button>`
                        // Jika tidak, tampilkan 'Individu'
                        :
                        'Individu';

                    row.innerHTML = `
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap hover:underline"><a href="/dashboard/kemahasiswaan/mahasiswa/${profil?.nim}">${mahasiswa?.nama || '-'}</a></td>
                        <td class="px-6 py-4">${profil?.nim || '-'}</td>
                        <td class="px-6 py-4">${profil?.program_studi?.nama_program_studi || '-'}</td>
                        <td class="px-6 py-4">${timHtml}</td>
                        <td class="px-6 py-4">${reg.dosen_pembimbing?.nama || '-'}</td>
                        <td class="px-6 py-4 text-center">${getStatusBadge(reg.status_verifikasi)}</td>
                        <td class="px-6 py-4 text-center">
                            <button class="view-submission-btn px-2 py-1 rounded-md text-xs text-blue-500 border border-blue-500 hover:bg-blue-100 "
                                    data-registration='${JSON.stringify(reg)}'>
                                Detail
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
                    if (lombaResponse.data.success) {
                        const lomba = lombaResponse.data.data;
                        renderLombaDetails(lomba);
                        // [BARU] Simpan daftar tahap lomba ke variabel global
                        allLombaStages = lomba.tahaps || [];
                    }
                    if (pesertaResponse.data.success) renderPesertaTable(pesertaResponse.data.data);
                } catch (error) {
                    console.error('Gagal mengambil data:', error);
                    lombaDetailContainer.innerHTML = `<div class="col-span-12 text-center p-10"><p class="text-lg font-semibold text-red-500">Gagal memuat data lomba.</p></div>`;
                    pesertaTableBody.innerHTML = `<tr><td colspan="6" class="px-6 py-4 text-center text-red-500">Gagal memuat data peserta.</td></tr>`;
                }
            }

            // --- Fungsi Kontrol Modal Tim & API ---
            function openTeamModal(teamData) {
                teamModalTitle.textContent = `${teamData.nama_tim}`;
                teamMemberList.innerHTML = ''; // Kosongkan daftar

                // Backend Anda mengirim anggota tim di dalam 'tim.members'
                if (!teamData.members || teamData.members.length === 0) {
                    teamMemberList.innerHTML = '<p class="text-center text-gray-500">Tidak ada data anggota untuk tim ini.</p>';
                } else {
                    teamData.members.forEach(member => {
                        const nim = member.profil_mahasiswa?.nim || 'N/A';
                        const memberHtml = `
                <div class="flex items-center gap-3 p-2 rounded-md bg-gray-100">
                    <img src="${member.foto_profile ? `/storage/${member.foto_profile}` : 'https://i.pravatar.cc/40'}" alt="Foto ${member.nama}" class="w-10 h-10 rounded-full object-cover bg-gray-200">
                    <div>
                        <a href="/dashboard/kemahasiswaan/mahasiswa/${member.profil_mahasiswa?.nim}" class="font-medium text-gray-800 hover:underline">${member.nama}</a>
                        <p class="text-sm text-gray-500">${member.profil_mahasiswa?.program_studi?.nama_program_studi || 'Tidak diketahui'}</p>
                        <p class="text-xs text-gray-500">${nim}</p>
                    </div>
                </div>
            `;
                        teamMemberList.innerHTML += memberHtml;
                    });
                }

                teamDetailModal.classList.remove('hidden');
            }

            pesertaTableBody.addEventListener('click', function(event) {
                const teamButton = event.target.closest('.view-team-btn');
                if (teamButton) {
                    try {
                        // Ambil data JSON dari atribut dan parse kembali menjadi objek
                        const teamData = JSON.parse(teamButton.dataset.team);
                        openTeamModal(teamData);
                    } catch (e) {
                        console.error("Gagal mem-parsing data tim:", e);
                        alert("Gagal memuat detail tim.");
                    }
                }
            });

            // --- Fungsi Kontrol Modal Detail Submission ---
            function openSubmissionModal(registrationData) {
                // Isi info dasar peserta (tidak berubah)
                submissionModalSubtitle.textContent = `${registrationData.mahasiswa.nama}`;
                submissionModalDeskripsi.textContent = registrationData.deskripsi_pengumpulan || 'Tidak ada deskripsi.';
                const linkElement = document.getElementById('submission-modal-link');
                linkElement.textContent = registrationData.link_pengumpulan;
                linkElement.href = registrationData.link_pengumpulan.startsWith('http') ? registrationData.link_pengumpulan : `//${registrationData.link_pengumpulan}`;

                // Render daftar tahap dan penilaian (tidak berubah)
                const tahapPenilaianList = document.getElementById('tahap-penilaian-list');
                tahapPenilaianList.innerHTML = '';
                const existingScores = registrationData.penilaian || [];

                if (allLombaStages.length === 0) {
                    tahapPenilaianList.innerHTML = `<p class="text-center text-gray-500 p-4">Belum ada tahap yang dibuat untuk lomba ini.</p>`;
                } else {
                    allLombaStages.forEach(tahap => {
                        const score = existingScores.find(p => p.id_tahap === tahap.id_tahap);
                        const listItem = document.createElement('div');
                        listItem.className = 'flex justify-between items-center text-sm p-3 rounded-md bg-gray-50';
                        let scoreHtml;
                        if (score) {
                            scoreHtml = `
                    <div class="text-right">
                        <p class="font-bold text-lg text-gray-800">${score.nilai}</p>
                        <p class="text-xs text-gray-500">${score.catatan || 'Tidak ada catatan.'}</p>
                    </div>
                `;
                        } else {
                            scoreHtml = `<span class="text-gray-400">Belum Dinilai</span>`;
                        }
                        listItem.innerHTML = `
                <span class="text-gray-800 font-medium">${tahap.nama_tahap}</span>
                ${scoreHtml}
            `;
                        tahapPenilaianList.appendChild(listItem);
                    });
                }

                // ==========================================================
                // [PERUBAHAN UTAMA DI SINI] Tambahkan bagian untuk Prestasi
                // ==========================================================

                // Cari data prestasi yang relevan dari objek mahasiswa
                // Backend mengirimkan array 'prestasi' di dalam 'mahasiswa'
                const prestasiTerkait = registrationData.mahasiswa.prestasi?.find(
                    p => p.id_lomba === registrationData.id_lomba
                );

                // Buat kontainer untuk menampilkan hasil akhir (peringkat)
                const hasilAkhirContainer = document.createElement('div');
                hasilAkhirContainer.className = '';

                if (prestasiTerkait) {
                    // Jika prestasi ditemukan, tampilkan peringkat dan tombol sertifikat
                    hasilAkhirContainer.innerHTML = `
            <h4 class="text-lg font-semibold text-gray-800 mb-3">Hasil Akhir</h4>
            <div class="flex items-center justify-between bg-green-50 p-4 rounded-lg">
                <div>
                    <p class="text-sm text-green-700">Peringkat Diraih</p>
                    <p class="text-xl font-bold text-green-800">${prestasiTerkait.peringkat}</p>
                </div>
                <a href="/storage/${prestasiTerkait.sertifikat_path}" target="_blank" class="text-green-600 border border-green-500 hover:bg-green-100 py-1 px-2 text-sm rounded-md">
                    Lihat Sertifikat
                </a>
            </div>
        `;
                } else {
                    // Jika tidak ada prestasi, cek apakah semua tahap sudah dinilai
                    const semuaTahapDinilai = allLombaStages.length > 0 && existingScores.length === allLombaStages.length;
                    if (semuaTahapDinilai) {
                        // Jika semua sudah dinilai tapi belum ada prestasi, beri info
                        hasilAkhirContainer.innerHTML = `
                <div class="text-center text-sm text-gray-500 p-3 bg-gray-50 rounded-md">
                    Semua tahap telah dinilai. Menunggu Admin Lomba untuk mencatat prestasi.
                </div>
            `;
                    }
                    // Jika belum semua dinilai, jangan tampilkan apa-apa di bagian ini
                }

                // Tambahkan kontainer hasil akhir ke dalam list (setelah semua tahap)
                tahapPenilaianList.appendChild(hasilAkhirContainer);

                // Tampilkan modal
                submissionDetailModal.classList.remove('hidden');
            }

            function hideSubmissionModal() {
                submissionDetailModal.classList.add('hidden');
            }

            // [BARU] Tambahkan Event Listener untuk menutup modal tim
            closeTeamModalBtn.addEventListener('click', hideTeamModal);

            function hideTeamModal() {
                teamDetailModal.classList.add('hidden');
            }

            // --- Fungsi Kontrol Modal & API ---
            function showSetujuiModal(lombaId) {
                setujuiLombaIdInput.value = lombaId;
                setujuiLombaModal.classList.remove('hidden');
            }

            function hideSetujuiModal() {
                setujuiLombaModal.classList.add('hidden');
            }

            function showTolakModal(lombaId) {
                tolakLombaIdInput.value = lombaId;
                tolakLombaModal.classList.remove('hidden');
                alasanTextarea.focus();
            }

            function hideTolakModal() {
                tolakLombaForm.reset();
                tolakLombaModal.classList.add('hidden');
            }


            async function submitPersetujuan(lombaId, button) {
                button.disabled = true;
                button.textContent = 'Memproses...';
                try {
                    await axios.patch(`/api/lomba/${lombaId}/setujui`);
                    alert('Lomba berhasil disetujui!');
                    location.reload();
                } catch (error) {
                    const msg = error.response?.data?.message || 'Terjadi kesalahan.';
                    alert(msg);
                } finally {
                    button.disabled = false;
                    button.textContent = 'Ya, Setujui';
                }
            }

            pesertaTableBody.addEventListener('click', function(event) {
                const submissionButton = event.target.closest('.view-submission-btn');
                if (submissionButton) {
                    try {
                        const registrationData = JSON.parse(submissionButton.dataset.registration);
                        openSubmissionModal(registrationData);
                    } catch (e) {
                        console.error("Gagal mem-parsing data registrasi:", e);
                        alert("Gagal memuat detail pengumpulan.");
                    }
                }
                // event listener untuk tombol tim tetap di sini
                const teamButton = event.target.closest('.view-team-btn');
                if (teamButton) {
                    // ... (kode untuk membuka modal tim)
                }
            });

            async function submitPenolakan(lombaId, alasan, button) {
                button.disabled = true;
                button.textContent = 'Memproses...';
                try {
                    await axios.patch(`/api/lomba/${lombaId}/tolak`, {
                        alasan_penolakan: alasan
                    });
                    alert('Lomba berhasil ditolak.');
                    location.reload();
                } catch (error) {
                    const msg = error.response?.data?.message || 'Terjadi kesalahan.';
                    alert(msg);
                } finally {
                    button.disabled = false;
                    button.textContent = 'Tolak';
                }
            }

            // --- Event Listeners ---
            lombaDetailContainer.addEventListener('click', function(event) {
                const setujuiButton = event.target.closest('.setujui-lomba-btn');
                const tolakButton = event.target.closest('.tolak-lomba-btn');
                if (setujuiButton) showSetujuiModal(setujuiButton.dataset.id);
                if (tolakButton) showTolakModal(tolakButton.dataset.id);
            });

            setujuiLombaForm.addEventListener('submit', (e) => {
                e.preventDefault();
                submitPersetujuan(setujuiLombaIdInput.value, e.submitter);
            });
            batalSetujuiBtn.addEventListener('click', hideSetujuiModal);

            tolakLombaForm.addEventListener('submit', (e) => {
                e.preventDefault();
                submitPenolakan(tolakLombaIdInput.value, alasanTextarea.value.trim(), e.submitter);
            });

            batalTolakBtn.addEventListener('click', hideTolakModal);

            closeSubmissionModalBtn.addEventListener('click', hideSubmissionModal);

            // Panggil fungsi utama saat halaman dimuat
            loadPageData();
        });
    </script>
</body>

</html>