<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lomba - Admin Prodi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-slate-50">

<div class="flex h-screen">
    @include('admin.nav-adminprodi')

    <main class="flex-1 overflow-y-auto">
        <div id="loading-overlay" class="fixed inset-0 bg-white bg-opacity-75 flex items-center justify-center z-50">
            <div class="text-slate-600 text-lg font-medium">Memuat data detail lomba...</div>
        </div>

        <div class="p-6 md:p-10">
            <div class="flex flex-col md:flex-row justify-between md:items-center mb-8 gap-4">
                <div>
                    <h1 id="lomba-title" class="text-3xl font-bold text-slate-800">...</h1>
                    <p id="lomba-penyelenggara" class="text-slate-500">Diselenggarakan oleh ...</p>
                </div>
                <div id="action-buttons" class="flex gap-3"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-white p-8 rounded-xl shadow-sm">
                    <img id="lomba-image" src="https://via.placeholder.com/800x400?text=Memuat+Gambar..." alt="Foto Lomba" class="w-full h-auto max-h-96 object-cover rounded-lg mb-6">
                    <h3 class="text-xl font-semibold mb-3 text-slate-800 border-b border-slate-200 pb-3">Deskripsi Lomba</h3>
                    <p id="lomba-description" class="text-slate-600 leading-relaxed">...</p>
                </div>

                <div class="space-y-8">
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <h3 class="text-lg font-semibold mb-4 border-b border-slate-200 pb-3 text-slate-800">Informasi Penting</h3>
                        <div class="space-y-4 text-sm">
                            <div><p class="text-slate-500">Status Lomba</p><div id="lomba-status"></div></div>
                            <div><p class="text-slate-500">Tingkat</p><p id="lomba-tingkat" class="font-semibold text-slate-700">...</p></div>
                            <div><p class="text-slate-500">Lokasi</p><p id="lomba-lokasi" class="font-semibold text-slate-700">...</p></div>
                            <div><p class="text-slate-500">Registrasi Berakhir</p><p id="lomba-tgl-registrasi" class="font-semibold text-slate-700">...</p></div>
                            <div><p class="text-slate-500">Periode Lomba</p><p id="lomba-periode" class="font-semibold text-slate-700">...</p></div>
                            <div id="alasan-penolakan-container" class="hidden"><p class="text-red-600 font-medium">Alasan Penolakan</p><p id="lomba-alasan-penolakan" class="font-semibold text-red-700 bg-red-100 p-3 rounded-lg">...</p></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-200"><h3 class="text-xl font-semibold text-slate-800">Daftar Peserta</h3></div>
                <div class="overflow-x-auto"><table class="min-w-full"><thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No.</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Ketua/Individu</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">NIM</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Program Studi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tim</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status Verifikasi</th>
                    </tr>
                </thead><tbody id="pendaftar-table-body" class="bg-white divide-y divide-slate-200"></tbody></table></div>
            </div>
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lombaId = '{{ $id }}';
        const loadingOverlay = document.getElementById('loading-overlay');
        
        async function fetchDetails() {
            try {
                const [lombaRes, pendaftarRes] = await Promise.all([ axios.get(`/api/lomba/${lombaId}`), axios.get(`/api/lomba/${lombaId}/pendaftar`) ]);
                if (lombaRes.data.success) { populateLombaData(lombaRes.data.data); } else { showError('Gagal memuat detail lomba.'); }
                if (pendaftarRes.data.success) { populatePendaftarTable(pendaftarRes.data.data); } else {
                    document.getElementById('pendaftar-table-body').innerHTML = `<tr><td colspan="6" class="text-center py-10 text-slate-500">Belum ada pendaftar.</td></tr>`;
                }
            } catch (error) { console.error('Error fetching data:', error); showError('Terjadi kesalahan saat mengambil data.'); } finally { loadingOverlay.style.display = 'none'; }
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
                const btnTolak = document.createElement('button');
                btnTolak.textContent = 'Tolak';
                btnTolak.className = 'px-5 py-2.5 text-sm font-semibold bg-white border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition';
                btnTolak.onclick = () => handleTolak(lomba.id_lomba);
                const btnSetuju = document.createElement('button');
                btnSetuju.textContent = 'Setujui Lomba';
                btnSetuju.className = 'px-5 py-2.5 text-sm font-semibold bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm';
                btnSetuju.onclick = () => handleSetujui(lomba.id_lomba);
                actionButtonsContainer.append(btnTolak, btnSetuju);
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
            if (pendaftar.length === 0) { tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-10 text-slate-500">Tidak ada pendaftar untuk lomba ini.</td></tr>`; return; }
            pendaftar.forEach((item, index) => {
                const mahasiswa = item.mahasiswa; const profil = mahasiswa.profil_mahasiswa; const prodi = profil ? profil.program_studi : null;
                const nimDisplay = profil ? profil.nim : '<span class="text-red-500">Profil Hilang</span>';
                const prodiDisplay = prodi ? prodi.nama_program_studi : 'N/A';
                const row = `<tr><td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">${index + 1}</td><td class="px-6 py-4 whitespace-nowrap"><div class="font-medium text-slate-800">${mahasiswa.nama}</div></td><td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">${nimDisplay}</td><td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">${prodiDisplay}</td><td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">${item.tim ? item.tim.nama_tim : 'Individu'}</td><td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">${capitalizeFirstLetter(item.status_verifikasi)}</td></tr>`;
                tableBody.insertAdjacentHTML('beforeend', row);
            });
        }
        function getStatusBadge(status) {
            const statuses = {'disetujui': 'bg-blue-100 text-blue-800', 'berlangsung': 'bg-green-100 text-green-800', 'selesai': 'bg-slate-100 text-slate-800', 'ditolak': 'bg-red-100 text-red-800', 'belum disetujui': 'bg-amber-100 text-amber-800'};
            const statusText = (status || '').replace(/_/g, ' ');
            return `<span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${statuses[status] || 'bg-slate-100 text-slate-800'}">${capitalizeFirstLetter(statusText)}</span>`;
        }
        function formatDate(dateString) { if (!dateString) return '-'; return new Date(dateString).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }); }
        function capitalizeFirstLetter(string) { return string.charAt(0).toUpperCase() + string.slice(1); }
        function showError(message) { document.body.innerHTML = `<div class="h-screen w-full flex items-center justify-center text-red-600 text-xl font-semibold">${message}</div>`; }
        async function handleSetujui(id) {
            Swal.fire({ title: 'Anda yakin?', text: "Anda akan menyetujui lomba ini.", icon: 'warning', showCancelButton: true, confirmButtonColor: '#2563eb', cancelButtonColor: '#64748b', confirmButtonText: 'Ya, setujui!', cancelButtonText: 'Batal' }).then(async (result) => {
                if (result.isConfirmed) { try { await axios.patch(`/api/lomba/${id}/setujui`); Swal.fire('Disetujui!', 'Lomba telah berhasil disetujui.', 'success').then(() => location.reload()); } catch (error) { Swal.fire('Error!', 'Gagal menyetujui lomba.', 'error'); } }
            })
        }
        async function handleTolak(id) {
            const { value: alasan } = await Swal.fire({ title: 'Masukkan Alasan Penolakan', input: 'text', inputPlaceholder: 'Contoh: Deskripsi lomba tidak lengkap', showCancelButton: true, confirmButtonText: 'Tolak Lomba', cancelButtonText: 'Batal', confirmButtonColor: '#dc2626', inputValidator: (value) => !value && 'Anda harus memberikan alasan penolakan!' })
            if (alasan) { try { await axios.patch(`/api/lomba/${id}/tolak`, { alasan_penolakan: alasan }); Swal.fire('Ditolak!', 'Lomba telah ditolak.', 'success').then(() => location.reload()); } catch (error) { Swal.fire('Error!', 'Gagal menolak lomba.', 'error'); } }
        }
        fetchDetails();
    });
</script>
</body>
</html>