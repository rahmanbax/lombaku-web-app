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

            <div id="pagination-container" class="mt-6 flex justify-center">
                <!-- Tombol paginasi akan diisi oleh JavaScript -->
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Variabel dan Elemen DOM ---
            const searchInput = document.querySelector('input[placeholder="Cari Mahasiswa"]');
            const tableBody = document.getElementById('mahasiswa-table-body');
            const paginationContainer = document.getElementById("pagination-container");

            let debounceTimer;
            let currentSearchTerm = "";

            async function fetchDashboardData(url = null) {
                // Tampilkan loading state
                tableBody.innerHTML = `<tr><td colspan="7" class="p-4 text-center text-gray-500">Memuat data...</td></tr>`;
                paginationContainer.innerHTML = '';

                // Jika URL tidak diberikan, buat URL default untuk halaman 1
                if (!url) {
                    const params = new URLSearchParams({
                        search: currentSearchTerm
                    }).toString();
                    url = `/api/mahasiswa/stats?${params}`;
                }

                try {
                    const response = await axios.get(url);
                    const responseData = response.data.data;

                    // [PERBAIKAN] Update kartu statistik (hanya saat memuat pertama kali atau search)
                    // Kita bisa asumsikan jika URL tidak mengandung '?page', ini adalah request awal.
                    if (!url.includes('?page=') || currentSearchTerm) {
                        updateStats(responseData.stats);
                    }

                    // [PERBAIKAN] Ambil objek paginator dari responseData.mahasiswa
                    const paginator = responseData.mahasiswa;

                    // [PERBAIKAN] Render tabel menggunakan data dari paginator.data
                    renderMahasiswaTable(paginator.data);

                    // [PERBAIKAN] Render tombol paginasi menggunakan objek paginator lengkap
                    renderPagination(paginator);

                } catch (error) {
                    console.error('Gagal mengambil data dashboard:', error);
                    tableBody.innerHTML = `<tr><td colspan="7" class="p-4 text-center text-red-500">Gagal memuat data. Silakan coba lagi.</td></tr>`;
                }
            }

            /**
             * Fungsi untuk mengupdate kartu statistik (tidak berubah)
             */
            function updateStats(stats) {
                document.getElementById('total-mahasiswa').textContent = stats.total_mahasiswa;
                document.getElementById('total-prestasi').textContent = stats.total_prestasi;
                document.getElementById('status-pendaftaran').textContent = stats.tahap_pendaftaran;
                document.getElementById('status-bimbingan').textContent = stats.butuh_persetujuan_pembimbing;
                document.getElementById('status-berlangsung').textContent = stats.sedang_berlangsung;
                document.getElementById('status-selesai').textContent = stats.selesai;
            }

            /**
             * Fungsi untuk me-render tabel mahasiswa (tidak berubah)
             */
            function renderMahasiswaTable(mahasiswaList) {
                tableBody.innerHTML = '';

                if (mahasiswaList.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="7" class="p-4 text-center text-gray-500">Tidak ada data mahasiswa ditemukan.</td></tr>`;
                    return;
                }

                mahasiswaList.forEach(mahasiswa => {
                    const nim = mahasiswa.profil_mahasiswa?.nim || 'N/A';
                    const jurusan = mahasiswa.profil_mahasiswa?.program_studi?.nama_program_studi || 'N/A';

                    // URL untuk halaman detail mahasiswa, menggunakan NIM
                    const detailUrl = `/dashboard/kemahasiswaan/mahasiswa/${nim}`;

                    // Tambahkan highlight jika ada yang menunggu persetujuan
                    const waitingHighlightClass = mahasiswa.menunggu_persetujuan_count > 0 ? 'bg-yellow-50 font-semibold' : 'bg-gray-50';

                    const row = `
                    <tr class="bg-gray-50 hover:bg-gray-100"> 
                        <td class="p-3">${mahasiswa.nama}</td>
                        <td class="p-3">${nim}</td>
                        <td class="p-3">${jurusan}</td>
                        <td class="p-3 text-center">${mahasiswa.total_lomba_diikuti}</td>
                        <td class="p-3 text-center">${mahasiswa.prestasi_count}</td>
                        <td class="p-3 text-center">${mahasiswa.menunggu_persetujuan_count}</td>
                        <td class="p-3">
                            <a href="${detailUrl}" class="w-fit px-2 py-1 text-sm rounded-md border border-blue-500 text-blue-500 hover:bg-blue-100">
                                Detail
                            </a>
                        </td>
                    </tr>
                `;
                    tableBody.innerHTML += row;
                });
            }

            function renderPagination(paginator) {
                paginationContainer.innerHTML = ''; // Kosongkan
                const links = paginator.links; // Ambil array 'links'

                if (!links || links.length <= 3) return; // Jangan render jika hanya 1 halaman

                links.forEach(link => {
                    const button = document.createElement('button');
                    let buttonContent = link.label.includes('Previous') ? `<span class="material-symbols-outlined">chevron_left</span>` :
                        link.label.includes('Next') ? `<span class="material-symbols-outlined">chevron_right</span>` : link.label;

                    button.innerHTML = buttonContent;

                    // Tambahkan aria-label untuk aksesibilitas pada tombol ikon
                    if (link.label.includes('Previous')) button.setAttribute('aria-label', 'Halaman Sebelumnya');
                    if (link.label.includes('Next')) button.setAttribute('aria-label', 'Halaman Berikutnya');

                    if (!link.url) {
                        button.className = 'w-10 h-10 flex items-center justify-center text-gray-400 bg-white border border-gray-300 mx-1 cursor-not-allowed rounded-full';
                        button.disabled = true;
                    } else if (link.active) {
                        button.className = 'w-10 h-10 flex items-center justify-center text-white bg-blue-500 border border-blue-500 mx-1 rounded-full';
                        button.disabled = true;
                    } else {
                        button.className = 'w-10 h-10 flex items-center justify-center text-gray-600 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 mx-1 rounded-full cursor-pointer';
                        button.dataset.url = link.url;
                    }

                    paginationContainer.appendChild(button);
                });
            }

            // --- Event Listeners ---

            // Listener untuk pagination
            paginationContainer.addEventListener('click', function(event) {
                // Cari elemen <button> yang paling dekat dengan target klik
                const button = event.target.closest('button');

                // Jika yang diklik bukan tombol, atau tombolnya non-aktif, abaikan
                if (!button || button.disabled) {
                    return;
                }

                // Ambil URL dari atribut data-url dan panggil fungsi fetch
                const url = button.dataset.url;
                if (url) {
                    fetchDashboardData(url);
                    // Opsional: Scroll ke atas halaman setelah berpindah halaman
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            });

            // Listener untuk pencarian dengan debounce
            searchInput.addEventListener("input", (event) => {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    currentSearchTerm = event.target.value;
                    // Panggil fetch data untuk halaman pertama dengan filter pencarian baru
                    fetchDashboardData();
                }, 500); // Tunggu 500ms setelah user berhenti mengetik
            });

            // Panggil fungsi utama saat halaman pertama kali dimuat
            fetchDashboardData('/api/mahasiswa/stats');
        });
    </script>
</body>

</html>