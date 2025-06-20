<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lombaku - Platform Lomba Terbaik</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .card-lomba:hover .lomba-image {
            transform: scale(1.05);
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">

    <x-public-header-nav />

    <!-- Hero Section -->
    <div class="container mx-auto px-4 py-8 md:py-16">
        <div class="max-w-3xl mx-auto text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Cari Lomba di Lombaku!</h1>
            <p class="text-gray-600 text-lg">Update terus info terkini, dari kampus sampai internasional semuanya ada disini</p>
        </div>

        <div class="max-w-2xl mx-auto mb-16">
            <div class="flex bg-white rounded-full shadow-lg border border-gray-200 overflow-hidden">
                <input
                    type="text"
                    class="flex-grow px-6 py-4 focus:outline-none w-full"
                    placeholder="Cari lomba, kategori, atau penyelenggara...">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 transition-colors">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <div class="border-b border-gray-200 my-12"></div>

        <section id="lomba-terbaru" class="container mx-auto px-4 py-8">
            <h2 class="text-3xl font-bold text-center text-dark mb-10">Lomba Terbaru Untukmu</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                @forelse ($lombas as $lomba)
                    <div class="card-lomba bg-white rounded-lg shadow-md overflow-hidden transform transition-transform duration-300 hover:-translate-y-2">
                        <div class="relative overflow-hidden">
                            <img src="{{ asset($lomba->foto_lomba) }}" alt="{{ $lomba->nama_lomba }}" class="lomba-image w-full h-48 object-cover transition-transform duration-300">
                            <div class="absolute top-2 left-2 flex flex-wrap gap-1">
                                @foreach ($lomba->tags->take(2) as $tag)
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ $tag->nama_tag }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-dark truncate" title="{{ $lomba->nama_lomba }}">
                                {{ Str::limit($lomba->nama_lomba, 45) }}
                            </h3>
                            <p class="text-sm text-gray-600 mt-1 capitalize">{{ $lomba->penyelenggara ?: 'Penyelenggara tidak diketahui' }}</p>
                            
                            <div class="flex items-center text-gray-500 text-sm mt-4">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <span>Pendaftaran s/d {{ \Carbon\Carbon::parse($lomba->tanggal_akhir_registrasi)->translatedFormat('d F Y') }}</span>
                            </div>

                            <a href="{{ route('lomba.show', ['id' => $lomba->id_lomba]) }}" class="mt-5 block w-full bg-blue-600 text-white text-center font-semibold py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12">
                        <p class="text-gray-500 text-lg">Saat ini belum ada lomba yang tersedia.</p>
                    </div>
                @endforelse

            </div>
            
            <!-- == BAGIAN BARU UNTUK LINK HALAMAN == -->
            <div class="mt-12">
                {{ $lombas->links() }}
            </div>
            <!-- ==================================== -->
        </section>
    </div>

    
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
</body>
</html>