<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
        <h2 class="text-center text-2xl font-semibold mb-6">Login</h2>
        <form action="/login" method="POST">
            @csrf
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <button type="submit" class="w-full py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none">Login</button>
        </form>

        <!-- Links for registration and password recovery -->
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">
                Belum punya akun? <a href="/register" class="text-blue-500 hover:underline">Daftar</a>
            </p>
            <p class="text-sm text-gray-600">
                Lupa akun? <a href="/forgot-password" class="text-blue-500 hover:underline">Lupa Password</a>
            </p>
        </div>
    </div>

</body>
</html>
