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
                <h3 class="text-sm font-medium text-gray-500">Prestasi Terverifikasi</h3>
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
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Lemari Prestasi (Terverifikasi)</h2>
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

        // --- Fungsi-fungsi untuk Render Tampilan ---

        function renderProfilHeader(mahasiswa) {
            document.getElementById('mahasiswa-foto').src = mahasiswa.profil_mahasiswa?.foto_profil ? `/${mahasiswa.profil_mahasiswa.foto_profil}` : '' + mahasiswa.nim;
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
                        detailHtml = reg.alasan_penolakan || 'Pendaftaran ditolak';
                        break;
                    default:
                        statusHtml = '<span>-</span>';
                        detailHtml = '<span>-</span>';
                }

                const row = `
                <tr class="${rowClass}">
                    <td class="p-3 font-medium"><a class="hover:underline" href="/dashboard/kemahasiswaan/lomba/${reg.id_lomba}">${reg.lomba.nama_lomba}</a></td>
                    <td class="p-3">${reg.lomba.tingkat}</td>
                    <td class="p-3">${reg.tim ? reg.tim.nama_tim : 'Individu'}</td>
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
                tbody.innerHTML = '<tr><td colspan="4" class="p-4 text-center text-gray-500">Belum ada prestasi terverifikasi.</td></tr>';
                return;
            }

            prestasiList.forEach(pres => {
                const row = `
                <tr class="bg-gray-50">
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
    </script>

</body>

</html>