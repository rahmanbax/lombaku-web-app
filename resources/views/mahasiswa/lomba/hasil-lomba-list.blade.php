<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Lomba - Lombaku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <x-public-header-nav />

    <main class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Hasil Lomba</h1>
                <p class="text-gray-600">Lihat hasil penilaian dari lomba yang telah Anda ikuti.</p>
            </div>

            <div class="space-y-6">
                @forelse ($lombaSelesai as $registrasi)
                    <div class="bg-white rounded-xl shadow-sm border p-6 transition-all hover:shadow-md">
                        <div class="flex flex-col md:flex-row md:items-center justify-between">
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">{{ $registrasi->lomba->nama_lomba }}</h2>
                                <p class="text-sm text-gray-500">Diselenggarakan oleh {{ $registrasi->lomba->penyelenggara }}</p>
                                <span class="mt-2 inline-block bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Lomba Selesai</span>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <a href="{{ route('hasil-lomba.show', $registrasi->id_registrasi_lomba) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-all shadow-md hover:shadow-lg">
                                    <i class="fas fa-eye mr-2"></i>Lihat Hasil
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center bg-white p-12 rounded-xl shadow-sm border">
                        <i class="fas fa-box-open fa-3x mb-4 text-gray-300"></i>
                        <h3 class="text-xl font-semibold text-gray-700">Belum Ada Hasil Lomba</h3>
                        <p class="text-gray-500 mt-2">Anda belum memiliki riwayat lomba yang telah selesai dinilai.</p>
                    </div>
                @endforelse
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
                <p class="text-gray-400">&copy; lombaku@2025. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>