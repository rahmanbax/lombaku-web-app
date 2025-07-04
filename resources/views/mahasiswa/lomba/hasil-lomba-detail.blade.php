<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Hasil: {{ $registrasi->lomba->nama_lomba }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <x-public-header-nav />

    <main class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header Halaman -->
            <div class="mb-8">
                <a href="{{ route('hasil-lomba.index') }}" class="text-blue-600 hover:underline mb-4 inline-block">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Hasil Lomba
                </a>
                <h1 class="text-3xl font-bold text-gray-800">{{ $registrasi->lomba->nama_lomba }}</h1>
                <p class="text-gray-600">Detail hasil partisipasi Anda.</p>
            </div>
            
            <!-- Panel Hasil Prestasi dan Sertifikat -->
            <div class="bg-white rounded-xl shadow-md border overflow-hidden mb-8">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Hasil Prestasi</h2>
                    @if(isset($prestasi) && $prestasi)
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div>
                                <p class="font-bold text-lg text-green-800">Selamat, Anda meraih: {{ $prestasi->peringkat }}</p>
                                <p class="text-sm text-green-700 mt-1">Sertifikat Anda tersedia untuk diunduh.</p>
                            </div>
                            <a href="{{ Storage::url($prestasi->sertifikat_path) }}" 
                               download 
                               class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors whitespace-nowrap w-full sm:w-auto text-center">
                                <i class="fas fa-download mr-2"></i>Download Sertifikat
                            </a>
                        </div>
                    @else
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-md">
                            <p class="text-blue-800">Sertifikat partisipasi atau pemenang akan tersedia di sini setelah diberikan oleh penyelenggara lomba.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Kartu Rincian Penilaian -->
            <div class="bg-white rounded-xl shadow-md border overflow-hidden">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Rincian Penilaian</h2>
                    
                    @if($registrasi->penilaian->isNotEmpty())
                        <div class="space-y-8">
                            @foreach($registrasi->penilaian->groupBy('id_tahap') as $id_tahap => $penilaianDiTahap)
                                <div class="border-b pb-8 last:border-b-0 last:pb-0">
                                    <h3 class="text-xl font-bold text-blue-700 mb-4">
                                        <i class="fas fa-clipboard-list mr-2"></i>Tahap: {{ $penilaianDiTahap->first()->tahap->nama_tahap }}
                                    </h3>
                                    <div class="space-y-4">
                                        @foreach($penilaianDiTahap as $penilaian)
                                            <div class="bg-gray-50 p-4 rounded-lg border">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <p class="font-semibold text-gray-700">Penilai: {{ $penilaian->penilai->nama ?? 'Juri Anonim' }}</p>
                                                        <p class="text-sm text-gray-500 mt-2">Catatan:</p>
                                                        <blockquote class="pl-4 border-l-4 border-gray-300 italic text-gray-600 mt-1">
                                                            {{ $penilaian->catatan ?? 'Tidak ada catatan.' }}
                                                        </blockquote>
                                                    </div>
                                                    <div class="text-right ml-4">
                                                        <p class="text-sm text-gray-500">Nilai</p>
                                                        <p class="text-3xl font-bold text-blue-600">{{ $penilaian->nilai }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-info-circle fa-3x mb-4 text-gray-300"></i>
                            <h3 class="text-xl font-semibold text-gray-700">Penilaian Belum Tersedia</h3>
                            <p class="text-gray-500 mt-2">Hasil penilaian untuk lomba ini belum dipublikasikan.</p>
                        </div>
                    @endif
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
</body>
</html>