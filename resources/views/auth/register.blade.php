<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e6f7ff 100%);
        }

        .form-container {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border-radius: 16px;
            overflow: hidden;
        }

        /* .role-section dikelola oleh JS */
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <div class="form-container bg-white w-full max-w-md">
        <div class="h-2 bg-gradient-to-r from-blue-500 to-blue-700"></div>

        <div class="p-8">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Daftar Akun Baru</h2>
                <p class="text-gray-600 mt-2">Silakan isi form berikut untuk membuat akun baru</p>
            </div>

            @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <strong class="font-medium">Validasi gagal!</strong>
                <ul class="mt-1 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST">
                @csrf

                <!-- Select Role -->
                <div class="mb-6">
                    <label for="role" class="block mb-2 text-sm font-medium text-gray-700">Pilih Role</label>
                    <select id="role" name="role"
                        class="input-field w-full p-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
                        <option value="" disabled selected>Pilih Role Anda</option>
                        <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                        <option value="admin_lomba" {{ old('role') == 'admin_lomba' ? 'selected' : '' }}>Admin Lomba</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="input-field w-full p-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="Nama lengkap Anda" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="input-field w-full p-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="email@contoh.com" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>

                    <!-- [PERUBAIKAN] Satu div pembungkus dengan class="relative" -->
                    <div class="relative">

                        <!-- Ikon gembok, diletakkan di dalam dan diposisikan secara absolut -->
                        <div class="absolute inset-y-0 left-0 flex items-center -mt-1 ml-3.5 pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>

                        <!-- Input field dengan padding kiri untuk memberi ruang bagi ikon -->
                        <input type="password" id="password" name="password"
                            class="input-field w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                            placeholder="Minimal 6 karakter" required>

                        <!-- Tombol mata, juga diposisikan secara absolut di dalam div yang sama -->
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" id="togglePassword">
                            <i class="far fa-eye text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                        </button>

                    </div>
                </div>
                <div class="mb-4">
                    <label for="notelp" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                    <input type="text" id="notelp" name="notelp" value="{{ old('notelp') }}" class="input-field w-full p-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="081234567890">
                </div>

                <!-- Mahasiswa Fields -->
                <div id="mahasiswa-fields" class="role-section space-y-4">
                    <div>
                        <label for="nim" class="block text-sm font-medium text-gray-700 mb-2">NIM</label>
                        <!-- PERBAIKAN: name diubah dari "nim_atau_nip" menjadi "nim" -->
                        <input type="text" id="nim" name="nim" value="{{ old('nim') }}"
                            class="input-field w-full p-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="Nomor Induk Mahasiswa">
                    </div>
                    <div>
                        <label for="id_program_studi_mhs" class="block text-sm font-medium text-gray-700 mb-2">Program Studi</label>
                        {{-- PERUBAHAN DIMULAI DI SINI --}}
                        <select id="id_program_studi_mhs" name="id_program_studi"
                            class="input-field w-full p-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="" disabled selected>Pilih Program Studi</option>
                            {{-- Loop melalui variabel $programStudis yang dikirim dari controller/route --}}
                            @foreach($programStudis as $prodi)
                            <option
                                value="{{ $prodi->id_program_studi }}"
                                {{ old('id_program_studi') == $prodi->id_program_studi ? 'selected' : '' }}>
                                {{ $prodi->nama_program_studi }}
                            </option>
                            @endforeach
                        </select>
                        {{-- PERUBAHAN SELESAI DI SINI --}}
                    </div>
                </div>

                <!-- Dosen Fields (Silakan sesuaikan jika diperlukan) -->
                <div id="dosen-fields" class="role-section">
                    <!-- ... field untuk Dosen ... -->
                </div>

                <!-- Admin Lomba Fields (Silakan sesuaikan jika diperlukan) -->
                <!-- Admin Lomba Fields -->
                <div id="admin_lomba-fields" class="role-section space-y-4">
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat Organisasi</label>
                        <!-- PERBAIKAN: name diubah dari "alamat" menjadi "alamat" -->
                        <!-- PERBAIKAN: placeholder disesuaikan -->
                        <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}"
                            class="w-full p-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="Contoh: Jl. Merdeka No. 10, Jakarta">
                    </div>
                    <div>
                        <label for="jenis_organisasi" class="block text-sm font-medium text-gray-700 mb-2">Jenis Organisasi</label>
                        <!-- PERBAIKAN: name pada select sudah benar, tetapi value pada option diubah -->
                        <select id="jenis_organisasi" name="jenis_organisasi"
                            class="w-full p-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="" disabled selected>Pilih Jenis Organisasi</option>
                            <!-- PERBAIKAN: value diubah dari angka menjadi string yang sesuai dengan validasi -->
                            <option value="perusahaan" {{ old('jenis_organisasi') == 'perusahaan' ? 'selected' : '' }}>Perusahaan</option>
                            <option value="mahasiswa" {{ old('jenis_organisasi') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="lainnya" {{ old('jenis_organisasi') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="mt-4 w-full py-3 bg-gradient-to-r from-blue-500 to-blue-700 text-white rounded-md">
                    Daftar Sekarang
                </button>

                <div class="mt-4 text-center">
                    <p class="text-gray-600 text-sm">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:underline">Masuk di sini</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            if (togglePassword) {
                togglePassword.addEventListener('click', function() {
                    const passwordInput = document.getElementById('password');
                    const icon = this.querySelector('i');
                    const isPassword = passwordInput.type === 'password';
                    passwordInput.type = isPassword ? 'text' : 'password';
                    icon.classList.toggle('fa-eye', !isPassword);
                    icon.classList.toggle('fa-eye-slash', isPassword);
                });
            }

            const namaLabel = document.querySelector('label[for="nama"]');
            const namaInput = document.getElementById('nama');

            // PERBAIKAN TOTAL PADA LOGIKA JAVASCRIPT
            const roleSelect = document.getElementById('role');
            const roleSections = {
                mahasiswa: document.getElementById('mahasiswa-fields'),
                dosen: document.getElementById('dosen-fields'),
                admin_lomba: document.getElementById('admin_lomba-fields')
            };

            function showRelevantFields() {
                const selectedRole = roleSelect.value;

                if (selectedRole === 'admin_lomba') {
                    namaLabel.textContent = 'Nama Organisasi';
                    namaInput.placeholder = 'Masukkan nama organisasi anda';
                } else {
                    namaLabel.textContent = 'Nama Lengkap';
                    namaInput.placeholder = 'Nama lengkap Anda';
                }

                // Loop melalui semua section
                for (const role in roleSections) {
                    const section = roleSections[role];
                    if (section) {
                        const inputs = section.querySelectorAll('input, select, textarea');

                        // Jika section ini adalah yang terpilih
                        if (role === selectedRole) {
                            section.style.display = 'block'; // Tampilkan section
                            inputs.forEach(input => {
                                input.disabled = false; // Aktifkan input agar dikirim
                                input.required = true; // Tambahkan validasi browser
                            });
                        } else {
                            // Jika section ini bukan yang terpilih
                            section.style.display = 'none'; // Sembunyikan section
                            inputs.forEach(input => {
                                input.disabled = true; // Non-aktifkan input agar TIDAK dikirim
                                input.required = false; // Hapus validasi browser
                            });
                        }
                    }
                }
            }

            // Panggil fungsi saat halaman dimuat (untuk handle old value)
            showRelevantFields();

            // Panggil fungsi setiap kali role diubah
            roleSelect.addEventListener('change', showRelevantFields);
        });
    </script>
</body>

</html>