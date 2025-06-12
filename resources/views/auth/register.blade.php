<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
        <h2 class="text-center text-2xl font-semibold mb-6">Daftar Akun Baru</h2>
        <form action="/login" method="POST">
            @csrf
            <!-- Select Role -->
            <div class="mb-4">
                <label for="role" class="block mb-2 text-sm font-medium text-gray-700">Pilih Role</label>
                <select id="role" name="role"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option selected>Pilih Role</option>
                    <option value="dosen">Dosen</option>
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="admin_lomba">Admin Lomba</option>
                </select>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email"
                    class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Phone Number -->
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                <input type="text" id="phone" name="phone"
                    class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Full Name -->
            <div class="mb-4">
                <label for="full_name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" id="full_name" name="full_name"
                    class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Student ID -->
            <div class="mb-4">
                <label for="student_id" class="block text-sm font-medium text-gray-700">Nomor Induk Mahasiswa</label>
                <input type="text" id="student_id" name="student_id"
                    class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Department -->
            <div class="mb-4">
                <label for="department" class="block mb-2 text-sm font-medium text-gray-700">Jurusan</label>
                <select id="department" name="department"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option selected>Pilih Jurusan</option>
                    <option value="d3_si">D3 Sistem Informasi</option>
                    <option value="d3_sia">D3 Sistem Informasi Akuntansi</option>
                    <option value="d3_rpl">D3 Rekayasa Perangkat Lunak</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none transition ease-in-out duration-150">
                Daftar
            </button>
        </form>
    </div>

</body>

</html>
