document.addEventListener("DOMContentLoaded", function () {
    // Helper functions (tetap sama)
    function formatDate(dateString) {
        if (!dateString) return "-";
        const options = { year: "numeric", month: "2-digit", day: "2-digit" };
        return new Date(dateString).toLocaleDateString("id-ID", options);
    }

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    // === MODIFIKASI DIMULAI DI SINI ===

    const tableBody = document.getElementById("lomba-table-body");
    const searchInput = document.getElementById("search-lomba-input");
    // const token = localStorage.getItem('authToken');
    let debounceTimer;

    /**
     * Fungsi utama untuk mengambil data lomba.
     * Sekarang menerima parameter searchTerm.
     * @param {string} searchTerm - Kata kunci untuk mencari lomba.
     */
    async function fetchAllLomba(searchTerm = "") {
        // Tampilkan loading state setiap kali fungsi ini dipanggil
        tableBody.innerHTML = `<tr><td colspan="8" class="text-center p-6 text-gray-500">Mencari...</td></tr>`;

        // if (!token) {
        //     tableBody.innerHTML = `<tr><td colspan="8" class="text-center p-6 text-red-500">Autentikasi gagal. Silakan login kembali.</td></tr>`;
        //     return;
        // }

        try {
            // Bangun URL dengan parameter pencarian jika ada
            const url = searchTerm
                ? `/api/lomba?search=${searchTerm}`
                : "/api/lomba";

            const response = await axios.get(url, {
                //     headers: { 'Authorization': `Bearer ${token}` }
            });

            const lombas = response.data.data;
            tableBody.innerHTML = ""; // Kosongkan tabel

            if (lombas.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="8" class="text-center p-6 text-gray-500">Tidak ada lomba yang ditemukan.</td></tr>`;
                return;
            }

            lombas.forEach((lomba, index) => {
                const row = document.createElement("tr");
                row.className = "bg-gray-50 hover:bg-gray-100";

                const penyelenggaraNama =
                    lomba.penyelenggara ||
                    (lomba.pembuat ? lomba.pembuat.nama : "N/A");
                const statusText = lomba.status
                    .replace(/_/g, " ")
                    .split(" ")
                    .map(capitalizeFirstLetter)
                    .join(" ");

                row.innerHTML = `
                    <td class="p-3 font-semibold">
                        <a href="/dashboard/kemahasiswaan/lomba/${
                            lomba.id_lomba
                        }" class="hover:underline">${lomba.nama_lomba}</a>
                    </td>
                    <td class="p-3 capitalize">${lomba.tingkat}</td>
                    <td class="p-3">${statusText}</td>
                    <td class="p-3 text-center">${lomba.registrasi_count}</td>
                    <td class="p-3">${formatDate(
                        lomba.tanggal_akhir_registrasi
                    )}</td>
                    <td class="p-3">${penyelenggaraNama}</td>
                    <td class="p-3">
                        <a href="/lomba/edit/${
                            lomba.id_lomba
                        }" class="text-blue-500 hover:text-blue-700">Edit</a>
                        <button data-id="${
                            lomba.id_lomba
                        }" class="ml-2 text-red-500 hover:text-red-700 delete-btn">Hapus</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        } catch (error) {
            console.error("Error fetching data:", error);
            tableBody.innerHTML = `<tr><td colspan="8" class="text-center p-6 text-red-500">Gagal memuat data.</td></tr>`;
        }
    }

    // Tambahkan event listener untuk input pencarian dengan debounce
    searchInput.addEventListener("input", (event) => {
        clearTimeout(debounceTimer); // Hapus timer sebelumnya

        // Atur timer baru. Fungsi fetchAllLomba akan dijalankan setelah 500ms pengguna berhenti mengetik
        debounceTimer = setTimeout(() => {
            fetchAllLomba(event.target.value);
        }, 500); // Waktu tunda 500 milidetik
    });

    // Panggil fungsi saat halaman pertama kali dimuat untuk menampilkan semua lomba
    fetchAllLomba();
});
