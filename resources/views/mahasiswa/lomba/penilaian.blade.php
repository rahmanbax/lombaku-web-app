<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Penilaian: {{ $registrasiLomba->lomba->nama_lomba }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">
    <x-public-header-nav />
    <main class="container mx-auto p-4 md:p-8">
        <div class="mb-6">
             <a href="{{ route('status') }}" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Riwayat
            </a>
        </div>
       
        <div id="result-container" class="max-w-4xl mx-auto" data-registrasi-id="{{ $registrasiLomba->id_registrasi_lomba }}">
            <!-- Header -->
            <div class="text-center mb-8">
                <p class="text-gray-500">Hasil Penilaian Anda untuk</p>
                <h1 class="text-4xl font-bold text-gray-800">{{ $registrasiLomba->lomba->nama_lomba }}</h1>
                <p id="nama-peserta" class="text-lg text-gray-700 mt-2">
                    <span class="bg-gray-200 h-6 w-48 inline-block rounded-md animate-pulse"></span>
                </p>
            </div>

            <!-- Summary Card -->
            <div class="bg-white p-6 rounded-lg shadow-lg text-center mb-8">
                <p class="text-gray-500 uppercase text-sm tracking-wider">Total Skor Akhir</p>
                <p id="total-skor" class="text-5xl font-bold text-blue-600 my-2">
                    <span class="bg-gray-200 h-12 w-32 inline-block rounded-md animate-pulse"></span>
                </p>
            </div>

            <!-- Detail Penilaian per Tahap -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Rincian Penilaian</h2>
                <div id="detail-penilaian-container" class="space-y-6">
                    <!-- Loading state -->
                    <div class="text-center py-8">
                        <i class="fas fa-spinner fa-spin fa-2x text-blue-500"></i>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="bg-gray-800 text-white mt-20">
        <div class="container mx-auto px-4 py-12">
            <div class="max-w-3xl mx-auto text-center mb-8">
                <p class="text-xl md:text-2xl font-medium mb-6">Butuh mahasiswa potensial untuk mengikuti lomba anda?</p>
                <button class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-3 px-8 rounded-full text-lg transition-colors">
                    Daftar sebagai Admin Lomba
                </button>
            </div>
        </div>
        <div class="bg-gray-900 py-6">
            <div class="container mx-auto px-4 text-center">
                <p class="text-gray-400">© lombaku@2025. All rights reserved.</p>
            </div>
        </div>
    </footer>
<script>
document.addEventListener('DOMContentLoaded', async () => {
    const container = document.getElementById('result-container');
    const registrasiId = container.dataset.registrasiId;

    const namaPesertaEl = document.getElementById('nama-peserta');
    const totalSkorEl = document.getElementById('total-skor');
    const detailContainer = document.getElementById('detail-penilaian-container');

    if (!registrasiId) {
        console.error('ID Registrasi tidak ditemukan');
        detailContainer.innerHTML = `<p class="text-center text-red-500">Error: ID Registrasi tidak valid.</p>`;
        return;
    }

    try {
        const response = await axios.get(`/api/kegiatan/hasil/${registrasiId}`);
        const result = response.data.data;

        // Isi data summary
        namaPesertaEl.innerHTML = `Peserta: <strong>${result.peserta}</strong>`;
        totalSkorEl.textContent = parseFloat(result.total_nilai).toFixed(2);
        
        // Kosongkan container detail dan render rincian nilai
        detailContainer.innerHTML = '';
        if (result.detail_nilai.length === 0) {
            detailContainer.innerHTML = `<p class="text-center text-gray-500 py-4">Belum ada rincian penilaian yang tersedia untuk Anda.</p>`;
        } else {
            result.detail_nilai.forEach(penilaian => {
                let catatanHtml = '';
                if (penilaian.catatan) {
                    catatanHtml = `
                        <div class="mt-3 border-t pt-3">
                            <p class="text-sm text-gray-500 mb-1">Catatan dari Juri:</p>
                            <blockquote class="border-l-4 border-gray-200 pl-4 text-gray-600 italic">
                                ${penilaian.catatan}
                            </blockquote>
                        </div>
                    `;
                }

                const detailCard = `
                    <div class="border rounded-lg p-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-gray-700">
                                ${penilaian.tahap_lomba?.nama_tahap || 'Tahap tidak diketahui'}
                            </h3>
                            <p class="text-xl font-bold text-gray-800">${parseFloat(penilaian.nilai).toFixed(2)} <span class="text-sm font-normal text-gray-500">/ 100</span></p>
                        </div>
                        ${catatanHtml}
                    </div>
                `;
                detailContainer.innerHTML += detailCard;
            });
        }

    } catch (error) {
        console.error('Gagal mengambil data hasil:', error);
        container.innerHTML = `<div class="bg-white p-8 rounded-lg shadow text-center"><p class="text-red-500">Gagal memuat data hasil penilaian.</p></div>`;
    }
});
</script>
</body>
</html>