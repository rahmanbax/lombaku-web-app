<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Rekognisi - Lombaku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background-color: #f9fafb; }
        .table-auto { width: 100%; border-collapse: collapse; }
        .table-auto th, .table-auto td { padding: 0.75rem; border: 1px solid #e5e7eb; }
        .table-auto th { background-color: #f3f4f6; text-align: left; font-weight: 600; color: #4b5563; }
        .table-auto tbody tr:nth-child(odd) { background-color: #ffffff; }
        .table-auto tbody tr:nth-child(even) { background-color: #f9fafb; }
    </style>
</head>
<body class="bg-gray-50 font-sans">

    <x-public-header-nav />

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Hasil Rekognisi Prestasi Anda</h1>
            <p class="text-gray-600 mb-6">Berikut adalah daftar prestasi Anda yang telah direkognisi oleh pihak universitas.</p>

            <div class="mb-8 p-4 border border-gray-200 rounded-lg bg-gray-50">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Informasi Mahasiswa</h2>
                <p class="text-lg text-gray-700">Nama: <strong>{{ Auth::user()->nama }}</strong></p>
                <p class="text-md text-gray-600">Email: {{ Auth::user()->email }}</p>
                @if(Auth::user()->profilMahasiswa)
                    <p class="text-md text-gray-600">NIM: {{ Auth::user()->profilMahasiswa->nim }}</p>
                @else
                    <p class="text-md text-gray-600">NIM: - (Profil Mahasiswa tidak ditemukan)</p>
                @endif
            </div>

            <div class="overflow-x-auto rounded-lg shadow-sm">
                <table class="table-auto min-w-full">
                    <thead>
                        <tr>
                            <th class="py-3 px-4">Nama Lomba / Kegiatan</th>
                            <th class="py-3 px-4">Peringkat</th>
                            <th class="py-3 px-4">Tanggal Diraih</th>
                            <th class="py-3 px-4">Bobot Rekognisi</th>
                            <th class="py-3 px-4">Mata Kuliah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ini adalah contoh data dummy. Nantinya Anda akan mengambil data ini dari database -->
                        <tr>
                            <td class="py-3 px-4 text-gray-800">Lomba Desain Grafis Tingkat Nasional</td>
                            <td class="py-3 px-4 text-gray-600">Juara 1</td>
                            <td class="py-3 px-4 text-gray-600">2024-06-15</td>
                            <td class="py-3 px-4 text-green-600 font-semibold">Penuh (100%)</td>
                            <td class="py-3 px-4 text-gray-600">Desain Grafis Terapan</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4 text-gray-800">Hackathon Inovasi Startup ITB</td>
                            <td class="py-3 px-4 text-gray-600">Finalis Top 5</td>
                            <td class="py-3 px-4 text-gray-600">2024-05-20</td>
                            <td class="py-3 px-4 text-yellow-600 font-semibold">Setengah (50%)</td>
                            <td class="py-3 px-4 text-gray-600">Pengembangan Aplikasi Web</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4 text-gray-800">Kompetisi Esai Nasional BUMN</td>
                            <td class="py-3 px-4 text-gray-600">Peringkat 3</td>
                            <td class="py-3 px-4 text-gray-600">2023-11-01</td>
                            <td class="py-3 px-4 text-orange-600 font-semibold">Sebagian (25%)</td>
                            <td class="py-3 px-4 text-gray-600">Bahasa Indonesia</td>
                        </tr>
                        <!-- Tambahkan baris lain sesuai kebutuhan -->
                    </tbody>
                </table>
            </div>

            <div class="mt-8 p-4 bg-blue-50 border border-blue-200 text-blue-800 rounded-lg">
                <p class="font-semibold"><i class="fas fa-info-circle mr-2"></i>Catatan:</p>
                <p class="text-sm">Data bobot rekognisi dan mata kuliah di atas adalah contoh. Logika untuk menentukan bobot dan mata kuliah akan diimplementasikan pada tahap selanjutnya setelah verifikasi prestasi disetujui oleh pihak berwenang.</p>
            </div>
        </div>
    </div>

    <x-footer />

</body>
</html>