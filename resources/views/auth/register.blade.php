<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

        .input-field {
            transition: all 0.3s ease;
        }

        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .role-section {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
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
                        class="input-field w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" required>
                        <option value="" disabled selected>Pilih Role Anda</option>
                        <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                        <option value="admin_lomba" {{ old('role') == 'admin_lomba' ? 'selected' : '' }}>Admin Lomba</option>
                    </select>
                </div>

                <!-- Common Fields for All Roles -->
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" id="username" name="username" value="{{ old('username') }}"
                            class="input-field w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                            placeholder="Username unik Anda" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-id-card text-gray-400"></i>
                        </div>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                            class="input-field w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                            placeholder="Nama lengkap Anda" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="input-field w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                            placeholder="email@contoh.com" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="password" name="password"
                            class="input-field w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                            placeholder="Minimal 6 karakter" required>
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" id="togglePassword">
                            <i class="far fa-eye text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="notelp" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <input type="text" id="notelp" name="notelp" value="{{ old('notelp') }}"
                            class="input-field w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                            placeholder="081234567890" required>
                    </div>
                </div>

                <!-- Mahasiswa Fields -->
                <div id="mahasiswa-fields" class="role-section">
                    <div class="mb-4">
                        <label for="nim_atau_nip" class="block text-sm font-medium text-gray-700">NIM</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-id-badge text-gray-400"></i>
                            </div>
                            <input type="text" id="nim_atau_nip" name="nim_atau_nip" value="{{ old('nim_atau_nip') }}"
                                class="input-field w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                placeholder="Nomor Induk Mahasiswa" required>
                        </div>
                    </div>
                </div>


                <div class="mb-6">
                    <label for="program_studi" class="block mb-2 text-sm font-medium text-gray-700">Program Studi</label>
                    <select id="program_studi" name="program_studi"
                        class="input-field w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" required>
                        <option value="" disabled selected>Pilih Program Studi</option>
                        <option value="1">D3 Sistem Informasi</option>
                        <option value="2">D3 Sistem Informasi Akuntansi</option>
                        <option value="3">D3 Rekayasa Perangkat Lunak</option>
                        <!-- Tambahkan opsi lain sesuai kebutuhan -->
                    </select>
                </div>
        </div>

        <!-- Dosen Fields -->
        <div id="dosen-fields" class="role-section">
            <div class="mb-6">
                <label for="nim_atau_nip" class="block text-sm font-medium text-gray-700">NIP</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-id-badge text-gray-400"></i>
                    </div>
                    <input type="text" id="nim_atau_nip" name="nim_atau_nip" value="{{ old('nim_atau_nip') }}"
                        class="input-field w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        placeholder="Nomor Induk Pegawai" required>
                </div>
            </div>
        </div>

        <!-- Admin Lomba Fields -->
        <div id="admin_lomba-fields" class="role-section">
            <div class="mb-4">
                <label for="instansi" class="block text-sm font-medium text-gray-700">Nama Organisasi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-building text-gray-400"></i>
                    </div>
                    <input type="text" id="instansi" name="instansi" value="{{ old('instansi') }}"
                        class="input-field w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        placeholder="Nama organisasi" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="" class="block text-sm font-medium text-gray-700">Jenis Organisasi</label>
                <select id="" name=""
                    class="input-field w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" required>
                    <option value="" disabled selected>Pilih Jenis Organisasi</option>
                    <option value="perusahaan">Perusahaan</option>
                    <option value="komunitas">Komunitas</option>
                    <option value="institusi_pendidikan">Institusi Pendidikan</option>
                    <option value="pemerintah">Pemerintah</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>

            <div class="mb-6">
                <label for="" class="block text-sm font-medium text-gray-700">Alamat Organisasi</label>
                <textarea id="" name="" rows="3"
                    class="input-field w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                    placeholder="Alamat lengkap organisasi" required></textarea>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full py-3 bg-gradient-to-r from-blue-500 to-blue-700 text-white font-medium rounded-lg hover:from-blue-600 hover:to-blue-800 focus:outline-none transition-all duration-300 transform hover:scale-[1.02]">
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
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });

        // Show/hide fields based on role selection
        const roleSelect = document.getElementById('role');
        const roleSections = document.querySelectorAll('.role-section');

        function showRelevantFields() {
            const selectedRole = roleSelect.value;

            // Hide all role-specific sections first
            roleSections.forEach(section => {
                section.style.display = 'none';
                // Make all fields not required when hidden
                section.querySelectorAll('input, select, textarea').forEach(field => {
                    field.removeAttribute('required');
                });
            });

            // Show only the selected role's section
            if (selectedRole) {
                const activeSection = document.getElementById(`${selectedRole}-fields`);
                if (activeSection) {
                    activeSection.style.display = 'block';
                    // Make fields required when shown
                    activeSection.querySelectorAll('input, select, textarea').forEach(field => {
                        field.setAttribute('required', 'required');
                    });
                }
            }
        }

        // Initial call to set correct fields on page load
        showRelevantFields();

        // Add event listener for role changes
        roleSelect.addEventListener('change', showRelevantFields);
    </script>
</body>

</html>