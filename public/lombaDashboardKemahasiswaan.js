// Buat lomba
// Pastikan script dijalankan setelah semua elemen halaman dimuat
document.addEventListener("DOMContentLoaded", function () {
    // --- Bagian 1: Mengambil dan mengisi dropdown Tags dari API ---
    const tagsSelect = document.getElementById("tags");

    // Ambil Bearer Token dari localStorage (diasumsikan sudah disimpan setelah login)
    // const token = localStorage.getItem("authToken");

    // Fungsi untuk mengambil data tags
    async function fetchTags() {
        try {
            const response = await axios.get("/api/tags", {
                // Kita akan membuat endpoint ini nanti
                // headers: {
                //     Authorization: `Bearer ${token}`,
                // },
            });

            if (response.data.success) {
                tagsSelect.innerHTML = ""; // Kosongkan opsi default
                response.data.data.forEach((tag) => {
                    const option = document.createElement("option");
                    option.value = tag.id_tag;
                    option.textContent = tag.nama_tag;
                    tagsSelect.appendChild(option);
                });
            }
        } catch (error) {
            tagsSelect.innerHTML = "<option disabled>Gagal memuat tag</option>";
            console.error("Error fetching tags:", error);
        }
    }

    // Panggil fungsi untuk mengisi dropdown saat halaman dimuat
    fetchTags();

    // --- Bagian 2: Menangani submit form ---
    const lombaForm = document.getElementById("form-buat-lomba");
    const messageDiv = document.getElementById("response-message");

    lombaForm.addEventListener("submit", async function (event) {
        event.preventDefault(); // Mencegah form submit secara default

        // Menggunakan FormData untuk mengumpulkan data form, termasuk file
        const formData = new FormData(lombaForm);

        // Tampilkan pesan loading
        messageDiv.innerHTML = `<div class="p-4 bg-yellow-100 text-yellow-800 rounded-lg">Memproses...</div>`;

        try {
            const response = await axios.post("/api/lomba", formData, {
                // headers: {
                //     // 'Content-Type': 'multipart/form-data' akan diatur otomatis oleh Axios saat menggunakan FormData
                //     Authorization: `Bearer ${token}`,
                // },
            });

            if (response.data.success) {
                // Tampilkan pesan sukses
                messageDiv.innerHTML = `<div class="p-4 bg-green-100 text-green-800 rounded-lg">Lomba berhasil dipublikasikan!</div>`;
                lombaForm.reset(); // Kosongkan form setelah berhasil
                fetchTags(); // Muat ulang tags jika diperlukan
            }
        } catch (error) {
            let errorMessages = "Terjadi kesalahan. Silakan coba lagi.";

            // Cek jika ada error validasi dari server (status 422)
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                errorMessages = "<ul>";
                for (const key in errors) {
                    errorMessages += `<li class="list-disc ml-4">${errors[key][0]}</li>`;
                }
                errorMessages += "</ul>";
            }

            messageDiv.innerHTML = `<div class="p-4 bg-red-100 text-red-800 rounded-lg">${errorMessages}</div>`;
            console.error("Error submitting form:", error.response);
        }
    });
});
