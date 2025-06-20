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

                <div class="flex gap-2 mt-3 bg-gray-100 w-full p-3 rounded-lg">
                    <img id="penyelenggara-foto" src="{{ asset('images/default-profile.png') }}" alt="foto penyelenggara" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <p class="text-xs text-black/60">Penyelenggara</p>
                        <h1 id="penyelenggara-nama" class="font-semibold mt-1"></h1>
                    </div>
                </div>

                <h2 class="font-bold mt-6 text-xl">Deskripsi</h2>
                <p id="lomba-deskripsi" class="mt-2 text-gray-700 leading-relaxed"></p>

                <div id="lomba-aksi" class="flex gap-2 mt-6">
                    <button class="w-full py-2 px-2 text-red-500 border border-red-500 rounded-lg font-semibold hover:bg-red-100 tolak-lomba-btn cursor-pointer">Tolak</button>
                    <button class="w-full py-2 px-2 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 setujui-lomba-btn cursor-pointer">Setujui</button>
                </div>
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
                            <th scope="col" class="px-6 py-3">Nama Tim</th>
                            <th scope="col" class="px-6 py-3">Pembimbing</th>
                            <th scope="col" class="px-6 py-3">Status Verifikasi</th>
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

    <!-- Modal untuk Konfirmasi Persetujuan -->
    <div id="setujui-lomba-modal" class="fixed inset-0 bg-black/40 overflow-y-auto h-full w-full flex items-center justify-center hidden">
        <div class="relative w-full max-w-md shadow-lg rounded-md bg-white p-4 mx-5 lg:mx-auto">
            <h3 class="text-lg font-medium text-gray-900">Konfirmasi Persetujuan</h3>
            <form id="setujui-lomba-form" class="">
                <input type="hidden" id="setujui-lomba-id">
                <p class="mt-2 text-gray-600">Apakah Anda yakin ingin menyetujui lomba ini? Tindakan ini akan mengubah status lomba menjadi "Disetujui".</p>
                <div class="items-center flex justify-end gap-2 mt-4">
                    <button id="batal-setujui-btn" type="button" class="px-4 py-2 rounded-md hover:bg-gray-100 text-black border border-gray-300">Batal</button>
                    <button id="kirim-persetujuan-btn" type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Ya, Setujui</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal untuk Alasan Penolakan -->
    <div id="tolak-lomba-modal" class="fixed inset-0 bg-black/40 overflow-y-auto h-full w-full flex items-center justify-center hidden">
        <div class="relative w-full max-w-md shadow-lg rounded-md bg-white p-4 mx-5 lg:mx-auto">
            <h3 class="text-lg font-medium text-gray-900">Alasan Penolakan</h3>
            <form id="tolak-lomba-form" class="">
                <input type="hidden" id="tolak-lomba-id">
                <textarea id="alasan-penolakan-textarea" class="mt-2 w-full p-2 h-20 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan alasan penolakkan lomba" required></textarea>
                <div class="items-center flex justify-end gap-2 mt-2">
                    <button id="batal-tolak-btn" type="button" class="px-4 py-2 rounded-md hover:bg-gray-100 text-black border border-gray-300">Batal</button>
                    <button id="kirim-penolakan-btn" type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Tolak</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script dipanggil setelah semua HTML dimuat -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Variabel dan Elemen DOM ---
            const lombaDetailContainer = document.getElementById('lomba-detail-container');

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

            // Helper function untuk memformat tanggal
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

            // --- Fungsi untuk merender detail lomba ---
            function renderLombaDetails(lomba) {
                const container = document.getElementById('lomba-detail-container');
                const template = document.getElementById('lomba-detail-template');
                const clone = template.content.cloneNode(true);

                clone.getElementById('lomba-image').src = `/${lomba.foto_lomba}`;
                clone.getElementById('lomba-nama').textContent = lomba.nama_lomba;
                clone.getElementById('lomba-tingkat').textContent = lomba.tingkat;
                clone.getElementById('lomba-lokasi').textContent = lomba.lokasi;
                clone.getElementById('lomba-status').textContent = lomba.status.replace(/_/g, ' ');
                clone.getElementById('lomba-tanggal-akhir-registrasi').textContent = formatDate(lomba.tanggal_akhir_registrasi);
                clone.getElementById('lomba-tanggal-mulai').textContent = formatDate(lomba.tanggal_mulai_lomba);
                clone.getElementById('lomba-tanggal-selesai').textContent = formatDate(lomba.tanggal_selesai_lomba);
                clone.getElementById('penyelenggara-nama').textContent = lomba.penyelenggara || (lomba.pembuat ? lomba.pembuat.nama : 'Tidak diketahui');
                if (lomba.pembuat.foto_profile) {
                    clone.getElementById('penyelenggara-foto').src = `/${lomba.pembuat.foto_profile}`;
                }
                clone.getElementById('lomba-deskripsi').textContent = lomba.deskripsi;

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
                if (lomba.status === 'belum disetujui') {
                    // Beri atribut data-id pada tombol agar bisa diambil oleh event listener
                    clone.querySelector('.setujui-lomba-btn').dataset.id = lomba.id_lomba;
                    clone.querySelector('.tolak-lomba-btn').dataset.id = lomba.id_lomba;
                    aksiContainer.style.display = 'flex'; // Tampilkan tombol
                } else {
                    aksiContainer.style.display = 'none'; // Sembunyikan tombol jika status bukan 'belum disetujui'
                }

                container.innerHTML = '';
                container.appendChild(clone);
            }

            // --- Fungsi API Call ---
            async function submitPersetujuan(lombaId) {
                try {
                    await axios.patch(`/api/lomba/${lombaId}/setujui`);
                    alert('Lomba berhasil disetujui!');
                    location.reload();
                } catch (error) {
                    const msg = error.response?.data?.message || 'Terjadi kesalahan.';
                    alert(msg);
                }
            }

            async function submitPenolakan(lombaId, alasan) {
                try {
                    await axios.patch(`/api/lomba/${lombaId}/tolak`, {
                        alasan_penolakan: alasan
                    });
                    alert('Lomba berhasil ditolak.');
                    location.reload();
                } catch (error) {
                    const msg = error.response?.data?.message || 'Terjadi kesalahan.';
                    alert(msg);
                }
            }

            // --- Fungsi Kontrol Modal ---
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
            }

            function hideTolakModal() {
                tolakLombaForm.reset();
                tolakLombaModal.classList.add('hidden');
            }

            // --- Fungsi untuk merender tabel peserta ---
            function renderPesertaTable(registrations) {
                const tableBody = document.getElementById('peserta-table-body');
                tableBody.innerHTML = ''; // Hapus loading state

                if (!registrations || registrations.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada peserta yang mendaftar.</td></tr>`;
                    return;
                }

                registrations.forEach(reg => {
                    const row = document.createElement('tr');
                    row.className = 'bg-gray-50';

                    const mahasiswa = reg.mahasiswa;
                    const profil = mahasiswa.profil_mahasiswa;
                    const prodi = profil ? profil.program_studi : null;

                    const namaMahasiswa = mahasiswa ? mahasiswa.nama : 'Data tidak lengkap';
                    const nim = profil ? profil.nim : '-';
                    const namaProdi = prodi ? prodi.nama_program_studi : '-';
                    const namaTim = reg.tim ? reg.tim.nama_tim : 'Individu';
                    const namaPembimbing = reg.dosen_pembimbing ? reg.dosen_pembimbing.nama : 'Tidak ada pembimbing';
                    const statusVerifikasi = capitalize(reg.status_verifikasi);

                    row.innerHTML = `
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">${namaMahasiswa}</th>
                    <td class="px-6 py-4">${nim}</td>
                    <td class="px-6 py-4">${namaProdi}</td>
                    <td class="px-6 py-4">${namaTim}</td>
                    <td class="px-6 py-4">${namaPembimbing}</td>
                    <td class="px-6 py-4">${statusVerifikasi}</td>
                `;
                    tableBody.appendChild(row);
                });
            }

            // --- Fungsi utama untuk mengambil semua data halaman ---
            async function loadPageData() {
                const pathParts = window.location.pathname.split('/');
                const lombaId = pathParts[pathParts.length - 1];

                if (!lombaId || isNaN(lombaId)) {
                    document.getElementById('lomba-detail-container').innerHTML = `<p class="text-red-500">ID Lomba tidak valid.</p>`;
                    return;
                }

                try {
                    // Panggil kedua API secara bersamaan
                    const [lombaResponse, pesertaResponse] = await Promise.all([
                        axios.get(`/api/lomba/${lombaId}`),
                        axios.get(`/api/lomba/${lombaId}/pendaftar`)
                    ]);

                    // Render setiap bagian dengan datanya masing-masing
                    if (lombaResponse.data.success) {
                        renderLombaDetails(lombaResponse.data.data);
                    }
                    if (pesertaResponse.data.success) {
                        renderPesertaTable(pesertaResponse.data.data);
                    }

                } catch (error) {
                    console.error('Error fetching page data:', error);
                    document.getElementById('lomba-detail-container').innerHTML = `<p class="text-red-500">Gagal memuat data halaman. Silakan coba lagi.</p>`;
                    document.getElementById('peserta-table-body').innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-red-500">Gagal memuat data peserta.</td></tr>`;
                }
            }

            // --- Event Listeners ---
            // Event Delegation pada kontainer utama untuk tombol aksi
            lombaDetailContainer.addEventListener('click', function(event) {
                const setujuiButton = event.target.closest('.setujui-lomba-btn');
                const tolakButton = event.target.closest('.tolak-lomba-btn');

                if (setujuiButton) {
                    showSetujuiModal(setujuiButton.dataset.id);
                } else if (tolakButton) {
                    showTolakModal(tolakButton.dataset.id);
                }
            });

            // Listeners untuk modal
            setujuiLombaForm.addEventListener('submit', (e) => {
                e.preventDefault();
                submitPersetujuan(setujuiLombaIdInput.value);
            });
            batalSetujuiBtn.addEventListener('click', hideSetujuiModal);

            tolakLombaForm.addEventListener('submit', (e) => {
                e.preventDefault();
                submitPenolakan(tolakLombaIdInput.value, alasanTextarea.value.trim());
            });
            batalTolakBtn.addEventListener('click', hideTolakModal);

            // Panggil fungsi utama saat halaman dimuat
            loadPageData();
        });
    </script>
</body>

</html>