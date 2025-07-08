<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/lombaku-icon.png') }}" type="image/png">
    <title>Akses Ditolak</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-gray-800">403</h1>
        <p class="text-2xl font-light text-gray-600 mt-2">Akses Ditolak</p>
        <p class="mt-4 text-gray-500">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ url()->previous() }}" class="mt-6 inline-block bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600">
            Kembali ke Dashboard
        </a>
    </div>
</body>

</html>