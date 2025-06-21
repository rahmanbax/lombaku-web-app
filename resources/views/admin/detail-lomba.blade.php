<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lomba - Admin Prodi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">

<div class="flex h-screen">
    <!-- Sidebar -->
    @include('admin.nav-adminprodi')

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <div id="loading-overlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="text-white text-xl">Memuat data detail lomba...</div>
        </div>

        <div class="container mx-auto px-6 py-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 id="lomba-title" class="text-3xl font-bold text-gray-800">...</h1>
                    <p id="lomba-penyelenggara" class="text-sm text-gray-500">Diselenggarakan oleh ...</p>
                </div>
                <div id="action-buttons" class="flex gap-2">
                    <!-- Tombol Aksi akan dimuat di sini -->
                </div>
            </div>

            <!-- Konten Detail -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Kolom Kiri: Gambar dan Deskripsi -->
                <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
                    <img id="lomba-image" src="https://via.placeholder.com/800x400?text=Memuat+Gambar..." alt="Foto Lomba" class="w-full h-64 object-cover rounded-md mb-4">
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">Deskripsi Lomba</h3>
                    <p id="lomba-description" class="text-gray-600">...</p>
                </div>

                <!-- Kolom Kanan: Info Penting -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4 border-b pb-2 text-gray-800">Informasi Penting</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Status Lomba</p>
                            <div id="lomba-status"></div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tingkat</p>
                            <p id="lomba-tingkat" class="font-semibold text-gray-700">...</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Lokasi</p>
                            <p id="lomba-lokasi" class="font-semibold text-gray-700">...</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Registrasi Berakhir</p>
                            <p id="lomba-tgl-registrasi" class="font-semibold text-gray-700">...</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Periode Lomba</p>
                            <p id="lomba-periode" class="font-semibold text-gray-700">...</p>
                        </div>
                        <div id="alasan-penolakan-container" class="hidden">
                            <p class="text-sm font-medium text-red-500">Alasan Penolakan</p>
                            <p id="lomba-alasan-penolakan" class="font-semibold text-red-700 bg-red-100 p-2 rounded">...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Pendaftar -->
            <div class="mt-8 bg-white rounded-lg shadow-md">
                <div class="p-6 border-b">
                    <h3 class="text-xl font-semibold text-gray-800">Daftar Peserta</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No.</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Ketua/Individu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIM</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Program Studi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tim</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody id="pendaftar-table-body" class="bg-white divide-y divide-gray-200">
                            <!-- Data pendaftar akan dimuat di sini -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    // Script JS tidak perlu diubah
    document.addEventListener('DOMContentLoaded', function() {
        const lombaId = '{{ $id }}';
        const loadingOverlay = document.getElementById('loading-overlay');
        async function fetchDetails() {
            try {
                const [lombaRes, pendaftarRes] = await Promise.all([
                    axios.get(`/api/lomba/${lombaId}`),
                    axios.get(`/api/lomba/${lombaId}/pendaftar`)
                ]);
                if (lombaRes.data.success) { populateLombaData(lombaRes.data.data); } else { showError('Gagal memuat detail lomba.'); }
                if (pendaftarRes.data.success) { populatePendaftarTable(pendaftarRes.data.data); } else {
                    const tableBody = document.getElementById('pendaftar-table-body');
                    tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-gray-500">Belum ada pendaftar.</td></tr>`;
                }
            } catch (error) {
                console.error('Error fetching data:', error);
                showError('Terjadi kesalahan saat mengambil data dari server.');
            } finally { loadingOverlay.style.display = 'none'; }
        }
        function populateLombaData(lomba) {
            document.getElementById('lomba-title').textContent = lomba.nama_lomba;
            document.getElementById('lomba-penyelenggara').textContent = `Diselenggarakan oleh ${lomba.penyelenggara}`;
            document.getElementById('lomba-image').src = `/${lomba.foto_lomba}`;
            document.getElementById('lomba-description').textContent = lomba.deskripsi;
            document.getElementById('lomba-tingkat').textContent = capitalizeFirstLetter(lomba.tingkat);
            let lokasiText = capitalizeFirstLetter(lomba.lokasi);
            if (lomba.lokasi === 'offline' && lomba.lokasi_offline) { lokasiText += ` (${lomba.lokasi_offline})`; }
            document.getElementById('lomba-lokasi').textContent = lokasiText;
            document.getElementById('lomba-tgl-registrasi').textContent = formatDate(lomba.tanggal_akhir_registrasi);
            document.getElementById('lomba-periode').textContent = `${formatDate(lomba.tanggal_mulai_lomba)} - ${formatDate(lomba.tanggal_selesai_lomba)}`;
            document.getElementById('lomba-status').innerHTML = getStatusBadge(lomba.status);
            const actionButtonsContainer = document.getElementById('action-buttons');
            actionButtonsContainer.innerHTML = '';
            if (lomba.status === 'belum disetujui') {
                const btnSetuju = document.createElement('button');
                btnSetuju.textContent = 'Setujui Lomba';
                btnSetuju.className = 'bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600';
                btnSetuju.onclick = () => handleSetujui(lomba.id_lomba);
                const btnTolak = document.createElement('button');
                btnTolak.textContent = 'Tolak Lomba';
                btnTolak.className = 'bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600';
                btnTolak.onclick = () => handleTolak(lomba.id_lomba);
                actionButtonsContainer.append(btnSetuju, btnTolak);
            }
            if (lomba.status === 'ditolak' && lomba.alasan_penolakan) {
                const alasanContainer = document.getElementById('alasan-penolakan-container');
                document.getElementById('lomba-alasan-penolakan').textContent = lomba.alasan_penolakan;
                alasanContainer.classList.remove('hidden');
            }
        }
        function populatePendaftarTable(pendaftar) {
            const tableBody = document.getElementById('pendaftar-table-body');
            tableBody.innerHTML = '';
            if (pendaftar.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-gray-500">Tidak ada pendaftar untuk lomba ini.</td></tr>`;
                return;
            }
            pendaftar.forEach((item, index) => {
                const mahasiswa = item.mahasiswa; const profil = mahasiswa.profil_mahasiswa; const prodi = profil ? profil.program_studi : null;
                const row = `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${index + 1}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${mahasiswa.nama}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${profil ? profil.nim : 'N/A'}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${prodi ? prodi.nama_program_studi : 'N/A'}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.tim ? item.tim.nama_tim : 'Individu'}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${capitalizeFirstLetter(item.status_verifikasi)}</td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', row);
            });
        }
        function getStatusBadge(status) {
            const statuses = {'disetujui': 'bg-blue-100 text-blue-800', 'berlangsung': 'bg-green-100 text-green-800', 'selesai': 'bg-gray-100 text-gray-800', 'belum disetujui': 'bg-yellow-100 text-yellow-800', 'ditolak': 'bg-red-100 text-red-800',};
            const statusText = (status || '').replace(/_/g, ' ');
            return `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statuses[status] || 'bg-gray-100 text-gray-800'}">${capitalizeFirstLetter(statusText)}</span>`;
        }
        function formatDate(dateString) { if (!dateString) return '-'; return new Date(dateString).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }); }
        function capitalizeFirstLetter(string) { return string.charAt(0).toUpperCase() + string.slice(1); }
        function showError(message) { document.body.innerHTML = `<div class="h-screen w-full flex items-center justify-center text-red-500 text-xl">${message}</div>`; }
        async function handleSetujui(id) {
            Swal.fire({ title: 'Anda yakin?', text: "Anda akan menyetujui lomba ini dan tidak bisa diubah lagi.", icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Ya, setujui!', cancelButtonText: 'Batal' }).then(async (result) => {
                if (result.isConfirmed) {
                    try { const response = await axios.patch(`/api/lomba/${id}/setujui`); if (response.data.success) { Swal.fire('Disetujui!', 'Lomba telah berhasil disetujui.', 'success').then(() => location.reload()); } } catch (error) { Swal.fire('Error!', 'Gagal menyetujui lomba.', 'error'); }
                }
            })
        }
        async function handleTolak(id) {
            const { value: alasan } = await Swal.fire({ title: 'Masukkan Alasan Penolakan', input: 'text', inputLabel: 'Alasan', inputPlaceholder: 'Contoh: Deskripsi lomba tidak lengkap', showCancelButton: true, confirmButtonText: 'Tolak Lomba', cancelButtonText: 'Batal', inputValidator: (value) => { if (!value) { return 'Anda harus memberikan alasan penolakan!' } } })
            if (alasan) {
                try { const response = await axios.patch(`/api/lomba/${id}/tolak`, { alasan_penolakan: alasan }); if (response.data.success) { Swal.fire('Ditolak!', 'Lomba telah ditolak.', 'success').then(() => location.reload()); } } catch (error) { Swal.fire('Error!', 'Gagal menolak lomba.', 'error'); }
            }
        }
        fetchDetails();
    });
</script>
</body>
</html>