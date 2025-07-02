<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mahasiswa - Andi Hermawan</title>
    <!-- Pastikan Anda mengimpor Tailwind CSS dan Google Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="">
    <!-- Asumsi Anda memiliki komponen header ini -->
    <x-kemahasiswaan-header-nav />

    <main class="lg:w-[1038px] mx-auto p-4 lg:py-10 lg:px-0">

        <!-- BAGIAN 1: HEADER PROFIL MAHASISWA -->
        <section class="border border-gray-200 p-6 rounded-lg">
            <div class="flex flex-col md:flex-row items-start gap-6">
                <!-- Foto Profil -->
                <img id="mahasiswa-foto" src="" alt="Foto Profil" class="w-28 h-28 rounded-full object-cover bg-gray-200">

                <!-- Info Utama -->
                <div class="flex-grow">
                    <h1 id="mahasiswa-nama" class="text-3xl font-bold text-gray-900">Memuat data...</h1>
                    <p id="mahasiswa-nim" class="text-md text-gray-600 mt-1">-</p>
                    <p id="mahasiswa-prodi" class="text-md text-gray-600">-</p>

                    <div class="mt-4 flex flex-col md:flex-row gap-x-6 gap-y-2 text-sm text-gray-700">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-gray-500" style="font-size: 20px;">mail</span>
                            <span id="mahasiswa-email">-</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-gray-500" style="font-size: 20px;">call</span>
                            <span id="mahasiswa-notelp">-</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- BAGIAN 2: KARTU STATISTIK PERSONAL -->
        <section class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="border border-gray-200 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-500">Total Lomba Diikuti</h3>
                <p id="stats-total-lomba" class="text-3xl font-bold text-gray-900 mt-1">-</p>
            </div>
            <div class="border border-gray-200 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-500">Jumlah Prestasi</h3>
                <p id="stats-prestasi" class="text-3xl font-bold text-gray-900 mt-1">-</p>
            </div>
            <div class="p-4 rounded-lg border border-gray-200">
                <h3 class="text-sm font-medium text-gray-500">Menunggu Persetujuan</h3>
                <p id="stats-menunggu" class="text-3xl font-bold  mt-1">-</p>
            </div>
            <div class="border border-gray-200 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-500">Lomba Berlangsung</h3>
                <p id="stats-berlangsung" class="text-3xl font-bold text-gray-900 mt-1">-</p>
            </div>
        </section>


        <!-- BAGIAN 3: DAFTAR RIWAYAT LOMBA -->
        <section class="mt-10">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Riwayat Lomba</h2>
            <div class="bg-white rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-100">
                            <tr>
                                <th class="p-3 text-left font-semibold">Nama Lomba</th>
                                <th class="p-3 text-left font-semibold">Tingkat</th>
                                <th class="p-3 text-left font-semibold">Tim</th>
                                <th class="p-3 text-left font-semibold">Dosen Pembimbing</th>
                                <th class="p-3 text-left font-semibold">Status</th>
                                <th class="p-3 text-left font-semibold">Detail</th>
                            </tr>
                        </thead>
                        <tbody id="riwayat-lomba-tbody">
                            <!-- Data akan diisi oleh JavaScript -->
                            <tr>
                                <td colspan="6" class="p-4 text-center text-gray-500">Memuat data riwayat lomba...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- BAGIAN 4: DAFTAR PRESTASI TERVERIFIKASI -->
        <section class="mt-10">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Daftar Prestasi</h2>
            <div class="bg-white rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-100">
                            <tr>
                                <th class="p-3 text-left font-semibold">Nama Lomba / Kegiatan</th>
                                <th class="p-3 text-left font-semibold">Peringkat</th>
                                <th class="p-3 text-left font-semibold">Tanggal Diraih</th>
                                <th class="p-3 text-left font-semibold">Sertifikat</th>
                            </tr>
                        </thead>
                        <tbody id="prestasi-tbody">
                            <!-- Data akan diisi oleh JavaScript -->
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-500">Memuat data prestasi...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </main>

    <!-- Modal untuk Detail Tim -->
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

    <script>
        // Pastikan axios sudah diimpor, biasanya melalui resources/js/bootstrap.js
        document.addEventListener('DOMContentLoaded', async function() {
            // 1. Dapatkan ID Mahasiswa dari URL browser
            const pathSegments = window.location.pathname.split('/');
            const mahasiswaNim = pathSegments[pathSegments.length - 1];

            if (!mahasiswaNim || isNaN(parseInt(mahasiswaNim))) {
                document.querySelector('main').innerHTML = '<p class="text-center text-red-500 p-10">NIM Mahasiswa tidak valid di URL.</p>';
                return;
            }

            // 2. Ambil data dari API menggunakan NIM
            try {
                const response = await axios.get(`/api/mahasiswa/${mahasiswaNim}/detail`);
                const mahasiswa = response.data.data;

                // 3. Panggil semua fungsi render untuk mengisi halaman
                renderProfilHeader(mahasiswa);
                renderStatCards(mahasiswa.stats);
                renderRiwayatLomba(mahasiswa.registrasi_lomba, mahasiswa.prestasi); // Kirim juga data prestasi untuk pengecekan
                renderPrestasi(mahasiswa.prestasi);

            } catch (error) {
                console.error('Gagal memuat data detail mahasiswa:', error);
                const errorMessage = error.response?.data?.message || 'Mahasiswa tidak ditemukan atau terjadi kesalahan server.';
                document.querySelector('main').innerHTML = `<div class="text-center p-10"><h1 class="text-2xl font-bold">Gagal Memuat Data</h1><p class="text-red-500 mt-2">${errorMessage}</p></div>`;
            }
        });

        const teamDetailModal = document.getElementById('team-detail-modal');
        const closeTeamModalBtn = document.getElementById('close-team-modal-btn');
        const teamModalTitle = document.getElementById('team-modal-title');
        const teamMemberList = document.getElementById('team-member-list');

        // --- Fungsi-fungsi untuk Render Tampilan ---

        function renderProfilHeader(mahasiswa) {
            document.getElementById('mahasiswa-foto').src = mahasiswa?.foto_profile ? `/storage/${mahasiswa.foto_profile}` : '' + mahasiswa.nim;
            document.getElementById('mahasiswa-foto').alt = `Foto Profil ${mahasiswa.nama}`;
            document.getElementById('mahasiswa-nama').textContent = mahasiswa.nama;
            document.getElementById('mahasiswa-nim').textContent = mahasiswa.profil_mahasiswa?.nim || 'NIM tidak tersedia';
            document.getElementById('mahasiswa-prodi').textContent = mahasiswa.profil_mahasiswa?.program_studi?.nama_program_studi || 'Prodi tidak tersedia';
            document.getElementById('mahasiswa-email').textContent = mahasiswa.email;
            document.getElementById('mahasiswa-notelp').textContent = mahasiswa.notelp || '-';
            document.title = `Detail Mahasiswa - ${mahasiswa.nama}`;
        }

        function renderStatCards(stats) {
            document.getElementById('stats-total-lomba').textContent = stats.total_lomba_diikuti;
            document.getElementById('stats-prestasi').textContent = stats.prestasi_terverifikasi;
            document.getElementById('stats-menunggu').textContent = stats.menunggu_persetujuan;
            document.getElementById('stats-berlangsung').textContent = stats.lomba_berlangsung;
        }

        function renderRiwayatLomba(registrasiList, prestasiList) {
            const tbody = document.getElementById('riwayat-lomba-tbody');
            tbody.innerHTML = '';

            if (registrasiList.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="p-4 text-center text-gray-500">Mahasiswa ini belum pernah mendaftar lomba.</td></tr>';
                return;
            }

            registrasiList.forEach(reg => {
                let statusHtml, detailHtml, rowClass = 'bg-gray-50 hover:bg-gray-100';

                // Logika untuk menentukan Tampilan Status dan Detail
                switch (reg.status_verifikasi) {
                    case 'menunggu':
                        statusHtml = `<span class="px-2 py-1 text-xs font-semibold rounded-md text-gray-600 bg-gray-200">Menunggu</span>`;
                        detailHtml = `Menunggu Persetujuan Pembimbing`;
                        break;
                    case 'diterima':
                        if (reg.lomba.status === 'selesai') {
                            statusHtml = `<span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-200">Selesai</span>`;
                            const hasPrestasi = prestasiList.some(p => p.id_lomba === reg.id_lomba);
                            detailHtml = hasPrestasi ? 'Prestasi Telah Dicatat' : 'Menunggu Pemberian Prestasi';
                        } else {
                            statusHtml = `<span class="px-2 py-1 rounded-md text-xs font-semibold text-blue-800 bg-blue-200">Berlangsung</span>`;
                            detailHtml = `Tahap Penilaian`;
                        }
                        break;
                    case 'ditolak':
                        statusHtml = `<span class="px-2 py-1 rounded-md text-xs font-semibold text-red-800 bg-red-200">Ditolak</span>`;
                        detailHtml = reg.catatan_penolakan || 'Pendaftaran ditolak';
                        break;
                    default:
                        statusHtml = '<span>-</span>';
                        detailHtml = '<span>-</span>';
                }

                const timHtml = reg.tim ?
                    `<button class="view-team-btn hover:underline" data-team='${JSON.stringify(reg.tim)}'>
                   ${reg.tim.nama_tim}
               </button>` :
                    'Individu';

                const row = `
                <tr class="${rowClass}">
                    <td class="p-3 font-medium"><a class="hover:underline" href="/dashboard/kemahasiswaan/lomba/${reg.id_lomba}">${reg.lomba.nama_lomba}</a></td>
                    <td class="p-3">${reg.lomba.tingkat}</td>
                    <td class="p-3">${timHtml}</td>
                    <td class="p-3">${reg.dosen_pembimbing?.nama || 'Tidak ada'}</td>
                    <td class="p-3">${statusHtml}</td>
                    <td class="p-3 text-gray-500 text-xs">${detailHtml}</td>
                </tr>
            `;
                tbody.innerHTML += row;
            });
        }

        function renderPrestasi(prestasiList) {
            const tbody = document.getElementById('prestasi-tbody');
            tbody.innerHTML = '';

            if (prestasiList.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" class="p-4 text-center text-gray-500">Belum ada prestasi.</td></tr>';
                return;
            }

            prestasiList.forEach(pres => {
                const row = `
                <tr class="bg-gray-50 hover:bg-gray-100">
                    <td class="p-3 font-medium">${pres.lomba?.nama_lomba || pres.nama_lomba_eksternal}</td>
                    <td class="p-3">${pres.peringkat}</td>
                    <td class="p-3">${new Date(pres.tanggal_diraih).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' })}</td>
                    <td class="p-3">
                        <a href="/${pres.sertifikat_path}" target="_blank" class="px-3 py-1 border border-blue-500 text-blue-600 rounded-md text-xs hover:bg-blue-50 flex items-center gap-1 w-fit">
                            <span class="material-symbols-outlined" style="font-size: 16px;">visibility</span> Lihat
                        </a>
                    </td>
                </tr>
            `;
                tbody.innerHTML += row;
            });
        }

        function openTeamModal(teamData) {
            teamModalTitle.textContent = `${teamData.nama_tim}`;
            teamMemberList.innerHTML = ''; // Kosongkan daftar sebelumnya

            if (!teamData.members || teamData.members.length === 0) {
                teamMemberList.innerHTML = '<p class="text-center text-gray-500">Tidak ada data anggota untuk tim ini.</p>';
            } else {
                // [PERBAIKAN] Ganti 'member_tim' menjadi 'members'
                teamData.members.forEach(member => {
                    // Ambil NIM dari profil_mahasiswa jika ada
                    const nim = member.profil_mahasiswa?.nim || 'NIM tidak ada';

                    const memberHtml = `
                <div class="flex items-center gap-3 p-3 rounded-md bg-gray-100">
                    <img src="${member.foto_profile ? `/storage/${member.foto_profile}` : 'https://i.pravatar.cc/40'}" alt="Foto ${member.nama}" class="w-10 h-10 rounded-full object-cover bg-gray-200">
                    <div>
                        <p class="font-medium text-gray-800">${member.nama}</p>
                        <p class="text-xs text-gray-500">${nim}</p>
                    </div>
                </div>
            `;
                    teamMemberList.innerHTML += memberHtml;
                });
            }

            teamDetailModal.classList.remove('hidden');
        }

        function closeTeamModal() {
            teamDetailModal.classList.add('hidden');
        }

        document.getElementById('riwayat-lomba-tbody').addEventListener('click', function(event) {
            const teamButton = event.target.closest('.view-team-btn');
            if (teamButton) {
                // Ambil data JSON dari atribut dan parse kembali menjadi objek
                const teamData = JSON.parse(teamButton.dataset.team);
                openTeamModal(teamData);
            }
        });

        closeTeamModalBtn.addEventListener('click', closeTeamModal);
    </script>

</body>

</html>