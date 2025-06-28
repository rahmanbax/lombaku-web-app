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
        <!-- lomba stats -->
        <section class="grid grid-cols-4 lg:grid-cols-12 gap-4 mt-5">
            <div class="col-span-4 lg:col-span-6 w-full flex flex-col gap-4">
                <h1 class="font-semibold">Mahasiswa</h1>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Total</h2>
                    <p id="total-mahasiswa" class="text-2xl font-semibold mt-1">-</p>
                </div>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Jumlah Prestasi</h2>
                    <p id="total-prestasi" class="text-2xl font-semibold mt-1">-</p>
                </div>
            </div>
            <div class="col-span-4 lg:col-span-6 w-full flex flex-col gap-4">
                <h1 class="font-semibold">Status</h1>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Tahap Pendaftaran</h2>
                    <p id="status-pendaftaran" class="text-2xl font-semibold mt-1">-</p>
                </div>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Butuh Persetujuan Pembimbing</h2>
                    <p id="status-bimbingan" class="text-2xl font-semibold mt-1">-</p>
                </div>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Sedang Berlangsung</h2>
                    <p id="status-berlangsung" class="text-2xl font-semibold mt-1">-</p>
                </div>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Selesai</h2>
                    <p id="status-selesai" class="text-2xl font-semibold mt-1">-</p>
                </div>
            </div>
        </section>

        <section class="mt-10">
            <h1 class="font-semibold">Semua Mahasiswa</h1>
            <div class="flex gap-2 mt-4">
                <input type="text" placeholder="Cari Mahasiswa" class="w-full p-2 border border-gray-200 rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
                <a href="{{ route('kemahasiswaan.mahasiswa.export') }}" class="whitespace-nowrap py-2 px-3 bg-blue-500 text-white rounded-lg">Download .xlsx</a>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="lg:w-full rounded-lg overflow-hidden table-auto">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-100">
                        <tr class="bg-gray-100">
                            <th class="p-3 text-left">Nama Mahasiswa</th>
                            <th class="p-3 text-left">NIM</th>
                            <th class="p-3 text-left">Jurusan</th>
                            <th class="p-3 text-center">Lomba Diikuti</th>
                            <th class="p-3 text-center">Jumlah Prestasi</th>
                            <th class="p-3 text-center">Butuh Persetujuan</th>
                            <th class="p-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="mahasiswa-table-body">
                        <!-- Data akan diisi oleh JavaScript di sini -->
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk mengambil dan menampilkan data
            async function fetchDashboardData() {
                try {
                    // Memanggil endpoint API yang sudah kita buat
                    const response = await axios.get('/api/mahasiswa/stats');
                    const responseData = response.data.data; // <- Ambil object 'data' dari response

                    // Update kartu statistik
                    updateStats(responseData.stats);

                    // Update tabel mahasiswa
                    renderMahasiswaTable(responseData.mahasiswa);

                } catch (error) {
                    console.error('Gagal mengambil data dashboard:', error);
                    const tableBody = document.getElementById('mahasiswa-table-body');
                    tableBody.innerHTML = `<tr><td colspan="6" class="p-4 text-center text-red-500">Gagal memuat data. Silakan coba lagi.</td></tr>`;
                }
            }

            // Fungsi untuk mengupdate kartu statistik
            function updateStats(stats) {
                document.getElementById('total-mahasiswa').textContent = stats.total_mahasiswa;
                document.getElementById('total-prestasi').textContent = stats.total_prestasi;
                document.getElementById('status-pendaftaran').textContent = stats.tahap_pendaftaran;
                document.getElementById('status-bimbingan').textContent = stats.butuh_persetujuan_pembimbing;
                document.getElementById('status-berlangsung').textContent = stats.sedang_berlangsung;
                document.getElementById('status-selesai').textContent = stats.selesai;
            }

            // Fungsi untuk me-render tabel mahasiswa
            function renderMahasiswaTable(mahasiswaList) {
                const tableBody = document.getElementById('mahasiswa-table-body');
                tableBody.innerHTML = ''; // Kosongkan isi tabel

                if (mahasiswaList.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="6" class="p-4 text-center text-gray-500">Tidak ada data mahasiswa.</td></tr>`;
                    return;
                }

                mahasiswaList.forEach(mahasiswa => {
                    const nim = mahasiswa.profil_mahasiswa?.nim || 'N/A';
                    const jurusan = mahasiswa.profil_mahasiswa?.program_studi?.nama_program_studi || 'N/A';
                    const row = `
                    <tr class="bg-gray-50 hover:bg-gray-100">
                        <td class="p-3">${mahasiswa.nama}</td>
                        <td class="p-3">${nim}</td>
                        <td class="p-3">${jurusan}</td>
                        <td class="p-3 text-center">${mahasiswa.total_lomba_diikuti}</td>
                        <td class="p-3 text-center">${mahasiswa.prestasi_count}</td>
                        <td class="p-3 text-center">${mahasiswa.menunggu_persetujuan_count}</td>
                        <td class="p-3">
                            <a href="/dashboard/kemahasiswaan/mahasiswa/${nim}" class="w-fit px-2 py-1 text-sm rounded-sm text-blue border border-blue-500 hover:bg-blue-100 text-blue-500">Lihat</a>
                        </td>
                    </tr>
                `;
                    tableBody.innerHTML += row;
                });
            }

            // Panggil fungsi utama saat halaman dimuat
            fetchDashboardData();
        });
    </script>
</body>

</html>