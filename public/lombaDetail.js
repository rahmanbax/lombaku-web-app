document.addEventListener('DOMContentLoaded', function() {
    
    // Helper function untuk memformat tanggal dari YYYY-MM-DD menjadi 'DD MMMM YYYY'
    function formatDate(dateString) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateString).toLocaleDateString('id-ID', options);
    }

    // Fungsi utama untuk mengambil dan menampilkan data lomba
    async function fetchLombaDetail() {
        // 1. Ambil ID lomba dari URL
        const pathParts = window.location.pathname.split('/');
        const lombaId = pathParts[pathParts.length - 1];

        // Validasi sederhana, pastikan ID adalah angka
        if (!lombaId || isNaN(lombaId)) {
            document.getElementById('lomba-detail-container').innerHTML = `<p class="text-red-500">ID Lomba tidak valid.</p>`;
            return;
        }

        // // 2. Ambil token dari localStorage
        // const token = localStorage.getItem('authToken');
        // if (!token) {
        //     document.getElementById('lomba-detail-container').innerHTML = `<p class="text-red-500">Anda tidak terautentikasi. Silakan login kembali.</p>`;
        //     return;
        // }

        try {
            // 3. Panggil API menggunakan Axios
            const response = await axios.get(`/api/lomba/${lombaId}`, {
                // headers: {
                //     'Authorization': `Bearer ${token}`
                // }
            });

            if (response.data.success) {
                const lomba = response.data.data;
                const container = document.getElementById('lomba-detail-container');
                const template = document.getElementById('lomba-detail-template');
                
                // 4. Kloning template dan isi dengan data
                const clone = template.content.cloneNode(true);
                
                clone.getElementById('lomba-image').src = `/${lomba.foto_lomba}`;
                clone.getElementById('lomba-nama').textContent = lomba.nama_lomba;
                clone.getElementById('lomba-tingkat').textContent = lomba.tingkat;
                clone.getElementById('lomba-lokasi').textContent = lomba.lokasi;
                clone.getElementById('lomba-status').textContent = lomba.status.replace('_', ' '); // Ganti "belum_disetujui" menjadi "belum disetujui"
                clone.getElementById('lomba-tanggal-akhir-registrasi').textContent = formatDate(lomba.tanggal_akhir_registrasi);
                clone.getElementById('lomba-tanggal-mulai').textContent = formatDate(lomba.tanggal_mulai_lomba);
                clone.getElementById('lomba-tanggal-selesai').textContent = formatDate(lomba.tanggal_selesai_lomba);
                clone.getElementById('penyelenggara-foto').src = `/${lomba.pembuat.foto_profile}`;
                clone.getElementById('penyelenggara-nama').textContent = lomba.penyelenggara || (lomba.pembuat ? lomba.pembuat.nama : 'Tidak diketahui');
                clone.getElementById('lomba-deskripsi').textContent = lomba.deskripsi;
                
                // Mengisi Tags
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

                // 5. Ganti placeholder dengan konten yang sudah diisi
                container.innerHTML = '';
                container.appendChild(clone);

            } else {
                throw new Error(response.data.message || 'Gagal mengambil data.');
            }

        } catch (error) {
            console.error('Error fetching lomba detail:', error);
            let errorMessage = 'Gagal memuat data lomba. Silakan coba lagi nanti.';
            if (error.response && error.response.status === 404) {
                errorMessage = 'Lomba yang Anda cari tidak ditemukan.';
            }
            document.getElementById('lomba-detail-container').innerHTML = `<p class="text-red-500">${errorMessage}</p>`;
        }
    }

    // Panggil fungsi saat halaman dimuat
    fetchLombaDetail();
});