<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Load Chart.js -->
</head>

<body>
    <x-kemahasiswaan-header-nav />

    <main class=" lg:w-[1038px] mx-auto p-4 lg:py-10 lg:px-0">


        <!-- lomba stats -->
        <section class="grid grid-cols-4 lg:grid-cols-12 gap-4 mt-5">
            <div class="col-span-4 w-full flex flex-col gap-4">
                <h1 class="font-semibold">Lomba</h1>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Terdaftar</h2>
                    <p id="stats-total-lomba" class="text-2xl font-semibold mt-1">...</p>
                </div>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Mahasiswa Terdaftar</h2>
                    <p id="stats-total-pendaftar" class="text-2xl font-semibold mt-1">...</p>
                </div>
            </div>
            <div class="col-span-4 w-full flex flex-col gap-4">
                <h1 class="font-semibold">Status</h1>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Butuh Persetujuan</h2>
                    <p id="stats-butuh-persetujuan" class="text-2xl font-semibold mt-1">...</p>
                </div>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Belum dimulai</h2>
                    <p id="stats-belum-dimulai" class="text-2xl font-semibold mt-1">...</p>
                </div>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Sedang Berlangsung</h2>
                    <p id="stats-berlangsung" class="text-2xl font-semibold mt-1">...</p>
                </div>
                <div class="bg-gray-100 w-full rounded-lg overflow-hidden p-3">
                    <h2 class="text-sm font-medium text-black/60">Selesai</h2>
                    <p id="stats-selesai" class="text-2xl font-semibold mt-1">...</p>
                </div>
            </div>
            <div class="col-span-4 w-full flex flex-col gap-4">
                <h1 class="font-semibold">Butuh Persetujuan</h1>
                <div class="flex items-center gap-2 p-3 bg-gray-100 rounded-lg">
                    <div class="flex-1">
                        <h2 class="text-base font-medium ">Lorem Ipsum Dolor Sit Aemt Colosseum</h2>
                        <p class="text-xs text-black/50">Himpunan Mahasiswa Islam</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="py-1 px-3 text-blue-500 border border-blue-500 rounded-lg text-sm font-semibold hover:bg-blue-100">Lihat</button>
                        <button class="py-1 px-3 bg-blue-500 text-white rounded-lg text-sm font-semibold hover:bg-blue-600">Setujui</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-10">
            <h1 class="font-semibold">Daftar Lomba</h1>
            <div class="flex gap-2 mt-4">
                <!-- search -->
                <input type="text" id="search-lomba-input" placeholder="Cari Lomba" class="w-full p-2 border border-gray-200 rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
                <a href="/dashboard/kemahasiswaan/lomba/buat" class="whitespace-nowrap py-2 px-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">Publikasikan Lomba</a>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="lg:w-full rounded-lg overflow-hidden table-auto">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-100">
                        <tr class="">
                            <th class="p-3 text-left font-medium">Nama Lomba</th>
                            <th class="p-3 text-left font-medium">Tingkat</th>
                            <th class="p-3 text-left font-medium">Status</th>
                            <th class="p-3 text-left font-medium">Pendaftar</th>
                            <th class="p-3 text-left font-medium">Tanggal Akhir Daftar</th>
                            <th class="p-3 text-left font-medium">Penyelenggara</th>
                            <th class="p-3 text-left font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <!-- ID ditambahkan di sini. Konten akan diisi oleh JavaScript -->
                    <tbody id="lomba-table-body">
                        <!-- Loading state -->
                        <tr>
                            <td colspan="8" class="text-center p-6 text-gray-500">
                                Memuat data lomba...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </section>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Helper functions (tetap sama)
            function formatDate(dateString) {
                if (!dateString) return "-";
                const options = {
                    year: "numeric",
                    month: "2-digit",
                    day: "2-digit"
                };
                return new Date(dateString).toLocaleDateString("id-ID", options);
            }

            function capitalizeFirstLetter(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }

            // === Variabel dan Elemen DOM ===
            const tableBody = document.getElementById("lomba-table-body");
            const searchInput = document.getElementById("search-lomba-input");
            let debounceTimer;

            // === Fungsi Utama untuk Fetch dan Render Data ===
            async function fetchAllLomba(searchTerm = "") {
                tableBody.innerHTML = `<tr><td colspan="7" class="text-center p-6 text-gray-500">Mencari...</td></tr>`;

                try {
                    const url = searchTerm ? `/api/lomba?search=${searchTerm}` : "/api/lomba";
                    const response = await axios.get(url); // Auth token di-handle oleh middleware di sisi server
                    const lombas = response.data.data;

                    tableBody.innerHTML = ""; // Kosongkan tabel

                    if (lombas.length === 0) {
                        tableBody.innerHTML = `<tr><td colspan="7" class="text-center p-6 text-gray-500">Tidak ada lomba yang ditemukan.</td></tr>`;
                        return;
                    }

                    lombas.data.forEach((lomba) => {
                        const row = document.createElement("tr");
                        row.className = "bg-gray-50 hover:bg-gray-100";

                        const penyelenggaraNama = lomba.penyelenggara || (lomba.pembuat ? lomba.pembuat.nama : "N/A");
                        const statusText = lomba.status.replace(/_/g, " ").split(" ").map(capitalizeFirstLetter).join(" ");

                        // --- INI ADALAH PERUBAHAN UTAMA UNTUK KOLOM AKSI ---
                        row.innerHTML = `
                    <td class="p-3 font-semibold">
                        <a href="/dashboard/kemahasiswaan/lomba/${lomba.id_lomba}" class="hover:underline">${lomba.nama_lomba}</a>
                    </td>
                    <td class="p-3 capitalize">${lomba.tingkat}</td>
                    <td class="p-3">${statusText}</td>
                    <td class="p-3 text-center">${lomba.registrasi_count}</td>
                    <td class="p-3">${formatDate(lomba.tanggal_akhir_registrasi)}</td>
                    <td class="p-3">${penyelenggaraNama}</td>
                    <td class="p-3">
                        <div class="flex gap-2 justify-end">
                            <a href="/dashboard/kemahasiswaan/lomba/${lomba.id_lomba}" class="w-fit px-2 py-1 text-sm rounded-sm text-white bg-blue-500 hover:bg-blue-600">Lihat</a>
                            <a href="/dashboard/kemahasiswaan/lomba/edit/${lomba.id_lomba}" class="w-fit px-2 py-1 text-sm rounded-sm text-blue-500 hover:bg-blue-100 border border-blue-500">Edit</a>
                            ${lomba.status === 'belum disetujui' ? `
                                <button data-id="${lomba.id_lomba}" class="delete-btn w-fit px-2 py-1 text-sm rounded-sm text-red-500 hover:bg-red-100 border border-red-500 cursor-pointer">Hapus</button>
                            ` : ''}
                        </div>
                    </td>
                `;
                        tableBody.appendChild(row);
                    });
                } catch (error) {
                    console.error("Error fetching data:", error);
                    tableBody.innerHTML = `<tr><td colspan="7" class="text-center p-6 text-red-500">Gagal memuat data.</td></tr>`;
                }
            }

            // Fungsi baru untuk mengambil dan menampilkan statistik
            async function fetchDashboardStats() {
                try {
                    // LANGSUNG panggil endpoint statistik, tanpa ID
                    const response = await axios.get('/api/lomba/stats');

                    if (response.data.success) {
                        const stats = response.data.data;

                        // Isi data statistik
                        document.getElementById('stats-total-lomba').textContent = stats.total_lomba;
                        document.getElementById('stats-total-pendaftar').textContent = stats.total_pendaftar;

                        // Isi data status
                        document.getElementById('stats-butuh-persetujuan').textContent = stats.status_counts.belum_disetujui;
                        document.getElementById('stats-belum-dimulai').textContent = stats.status_counts.disetujui;
                        document.getElementById('stats-berlangsung').textContent = stats.status_counts.berlangsung;
                        document.getElementById('stats-selesai').textContent = stats.status_counts.selesai;
                    } else {
                        // Jika API mengembalikan success: false
                        throw new Error(response.data.message || 'Gagal mengambil statistik');
                    }
                } catch (error) {
                    console.error('Error fetching dashboard stats:', error);
                    // Tampilkan tanda strip jika gagal total
                    const ids = ['stats-total-lomba', 'stats-total-pendaftar', 'stats-butuh-persetujuan', 'stats-belum-dimulai', 'stats-berlangsung', 'stats-selesai'];
                    ids.forEach(id => {
                        const el = document.getElementById(id);
                        if (el) el.textContent = '-';
                    });
                }
            }

            // === Event Listeners ===

            // Listener untuk pencarian dengan debounce
            searchInput.addEventListener("input", (event) => {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    fetchAllLomba(event.target.value);
                }, 500);
            });

            // Listener untuk tombol aksi dropdown (menggunakan event delegation)
            tableBody.addEventListener('click', (event) => {
                const actionButton = event.target.closest('.action-button');
                if (actionButton) {
                    const dropdown = actionButton.nextElementSibling;

                    // Tutup semua dropdown lain sebelum membuka yang ini
                    document.querySelectorAll('.dropdown-menu').forEach(menu => {
                        if (menu !== dropdown) {
                            menu.classList.add('hidden');
                        }
                    });

                    // Toggle dropdown yang diklik
                    dropdown.classList.toggle('hidden');
                }

                // Listener untuk tombol hapus
                if (event.target.classList.contains('delete-btn')) {
                    const lombaId = event.target.dataset.id;
                    if (confirm(`Apakah Anda yakin ingin menghapus lomba ini (ID: ${lombaId})?`)) {
                        // Panggil fungsi untuk menghapus (didefinisikan di bawah)
                        deleteLomba(lombaId);
                    }
                }
            });

            // Listener untuk menutup dropdown jika klik di luar
            window.addEventListener('click', (event) => {
                if (!event.target.closest('.action-button')) {
                    document.querySelectorAll('.dropdown-menu').forEach(menu => {
                        menu.classList.add('hidden');
                    });
                }
            });

            // === Fungsi Tambahan (Contoh: Delete) ===
            async function deleteLomba(id) {
                try {
                    await axios.delete(`/api/lomba/${id}`);
                    alert('Lomba berhasil dihapus!');
                    fetchAllLomba(searchInput.value); // Muat ulang tabel
                } catch (error) {
                    console.error('Error deleting lomba:', error);
                    alert('Gagal menghapus lomba.');
                }
            }

            // Panggil fungsi utama saat halaman dimuat
            fetchAllLomba();
            fetchDashboardStats();
        });
    </script>
</body>

</html>