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
            <div class="mb-8">
                <a href="{{ route('hasil-lomba.index') }}" class="text-blue-600 hover:underline mb-4 inline-block">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Hasil Lomba
                </a>
                <h1 class="text-3xl font-bold text-gray-800">{{ $registrasi->lomba->nama_lomba }}</h1>
                <p class="text-gray-600">Detail hasil penilaian untuk partisipasi Anda.</p>
            </div>

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
</body>
</html>