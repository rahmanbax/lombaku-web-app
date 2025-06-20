<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lomba Disimpan - Lombaku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap'); body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-100">

<x-public-header-nav />

<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Lomba yang Anda Simpan</h1>
            <p class="text-gray-600">Daftar semua lomba yang telah Anda tandai sebagai favorit.</p>
        </div>
        
        <div id="lomba-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 min-h-[300px]">
            <div id="loading-state" class="col-span-full flex justify-center items-center p-10">
                 <i class="fas fa-spinner fa-spin fa-3x text-blue-500"></i>
            </div>
        </div>
    </div>
</div>

<template id="lomba-card-template">
    <div class="bg-white rounded-lg shadow-md overflow-hidden transform transition-transform duration-300 hover:-translate-y-1">
        <img class="lomba-image w-full h-48 object-cover" src="" alt="">
        <div class="p-5">
            <h3 class="lomba-nama text-lg font-bold text-gray-900 truncate"></h3>
            <p class="lomba-penyelenggara text-sm text-gray-600 mt-1"></p>
            <div class="flex items-center text-gray-500 text-sm mt-4">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span class="lomba-tanggal"></span>
            </div>
            <a class="lomba-link mt-5 block w-full bg-blue-600 text-white text-center font-semibold py-2 rounded-lg hover:bg-blue-700">Lihat Detail</a>
        </div>
    </div>
</template>
<!-- Footer -->
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
                <p class="text-gray-400">&copy; lombaku@2025. All rights reserved.</p>
            </div>
        </div>
    </footer>
<script>
document.addEventListener('DOMContentLoaded', async () => {
    const lombaGrid = document.getElementById('lomba-grid');
    const loadingState = document.getElementById('loading-state');
    const template = document.getElementById('lomba-card-template');

    try {
        const response = await axios.get('/api/bookmarks');
        loadingState.style.display = 'none';

        if (response.data.success && response.data.data.length > 0) {
            response.data.data.forEach(lomba => {
                const card = template.content.cloneNode(true);
                card.querySelector('.lomba-image').src = `{{ asset('') }}${lomba.foto_lomba}`;
                card.querySelector('.lomba-image').alt = lomba.nama_lomba;
                card.querySelector('.lomba-nama').textContent = lomba.nama_lomba;
                card.querySelector('.lomba-penyelenggara').textContent = lomba.penyelenggara || 'N/A';
                card.querySelector('.lomba-tanggal').textContent = 's/d ' + new Date(lomba.tanggal_akhir_registrasi).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                card.querySelector('.lomba-link').href = `{{ url('/lomba') }}/${lomba.id_lomba}`;
                lombaGrid.appendChild(card);
            });
        } else {
            lombaGrid.innerHTML = `<div class="col-span-full text-center text-gray-500 py-10">Anda belum menyimpan lomba apapun.</div>`;
        }
    } catch (error) {
        console.error('Gagal mengambil bookmark:', error);
        loadingState.style.display = 'none';
        lombaGrid.innerHTML = `<div class="col-span-full text-center text-red-500 py-10">Gagal memuat data.</div>`;
    }
});
</script>

</body>
</html>