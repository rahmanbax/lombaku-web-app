<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Lombaku</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background-color: #f9fafb; }
        .form-input { background-color: #f9fafb; border-color: #d1d5db; transition: all 0.2s ease; }
        .form-input:focus { border-color: #3B82F6; box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5); background-color: white; }
        .form-label { display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; }
        .error-message { color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; min-height: 1rem; }
    </style>
</head>
<body class="bg-gray-50">
    <x-public-header-nav />
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <form id="edit-profile-form" novalidate enctype="multipart/form-data">
            <div class="bg-white rounded-xl shadow-md p-8">
                <h1 class="text-2xl font-bold text-gray-800 mb-8">Edit Profil Mahasiswa</h1>

                <!-- FOTO PROFIL -->
                <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">Foto Profil</h2>
                <div class="flex items-center gap-6 mb-6">
                    <img id="foto-preview" src="https://ui-avatars.com/api/?name=?&background=E0E7FF&color=3730A3" alt="Preview Foto Profil" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                    <div>
                        <input type="file" name="foto_profile" id="foto_profile" class="hidden" accept="image/*">
                        <label for="foto_profile" class="cursor-pointer bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-300 rounded-lg shadow-sm">
                            Ubah Foto
                        </label>
                        <p class="text-xs text-gray-500 mt-2">JPG, PNG, atau GIF. Maksimal 2MB.</p>
                        <p id="error-foto_profile" class="error-message"></p>
                    </div>
                </div>

                <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2 mt-8">Informasi Akademik & Kontak</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div><label for="nama" class="form-label">Nama Lengkap</label><input type="text" id="nama" name="nama" class="w-full p-2 border rounded-md form-input"><p id="error-nama" class="error-message"></p></div>
                    <div><label for="nim" class="form-label">NIM</label><input type="text" id="nim" name="nim" class="w-full p-2 border rounded-md form-input"><p id="error-nim" class="error-message"></p></div>
                    <div><label for="id_program_studi" class="form-label">Program Studi</label><select id="id_program_studi" name="id_program_studi" class="w-full p-2 border rounded-md form-input"><option value="">Memuat...</option></select><p id="error-id_program_studi" class="error-message"></p></div>
                    <div><label for="email" class="form-label">Email</label><input type="email" id="email" name="email" class="w-full p-2 border rounded-md form-input"><p id="error-email" class="error-message"></p></div>
                    
                    <!-- PERBAIKAN PENTING PADA INPUT NOMOR TELEPON -->
                    <div>
                        <label for="notelp" class="form-label">Nomor Telepon</label>
                        <input 
                            type="tel" 
                            id="notelp" 
                            name="notelp" 
                            class="w-full p-2 border rounded-md form-input"
                            pattern="[0-9]*"       {{-- Memastikan hanya digit --}}
                            inputmode="numeric"    {{-- Membantu keyboard numerik di mobile --}}
                        >
                        <p id="error-notelp" class="error-message"></p>
                    </div>
                    <!-- AKHIR PERBAIKAN -->
                </div>

                <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2 mt-8">Informasi Personal</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div><label for="tanggal_lahir" class="form-label">Tanggal Lahir</label><input type="date" id="tanggal_lahir" name="tanggal_lahir" class="w-full p-2 border rounded-md form-input"><p id="error-tanggal_lahir" class="error-message"></p></div>
                    <div><label for="jenis_kelamin" class="form-label">Jenis Kelamin</label><select id="jenis_kelamin" name="jenis_kelamin" class="w-full p-2 border rounded-md form-input"><option value="">Pilih Jenis Kelamin</option><option value="Laki-laki">Laki-laki</option><option value="Perempuan">Perempuan</option></select><p id="error-jenis_kelamin" class="error-message"></p></div>
                </div>
                
                <div class="border-t border-gray-200 mt-8 pt-6 flex justify-end items-center gap-4">
                    <a href="{{ route('profile') }}" class="text-gray-600 hover:bg-gray-100 px-4 py-2 rounded-md">Batal</a>
                    <button type="submit" id="submit-button" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2 rounded-md transition-colors">Simpan Perubahan</button>
                </div>
                <div id="success-message" class="text-green-600 mt-4 text-center" style="display: none;"></div>
            </div>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', async () => {
        const form = document.getElementById('edit-profile-form');
        const submitButton = document.getElementById('submit-button');
        const successMessage = document.getElementById('success-message');
        const fotoInput = document.getElementById('foto_profile');
        const fotoPreview = document.getElementById('foto-preview');
        // Pastikan token CSRF diatur untuk Axios
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const populateForm = (data) => {
            const profile = data.data;
            document.getElementById('nama').value = profile.user.nama || '';
            document.getElementById('email').value = profile.user.email || '';
            document.getElementById('notelp').value = profile.user.notelp || '';
            document.getElementById('nim').value = profile.nim || '';
            document.getElementById('tanggal_lahir').value = profile.tanggal_lahir ? profile.tanggal_lahir.split('T')[0] : '';
            document.getElementById('jenis_kelamin').value = profile.jenis_kelamin || '';

            if (profile.user.foto_profile) {
                fotoPreview.src = `/storage/${profile.user.foto_profile}`;
            } else {
                fotoPreview.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(profile.user.nama)}&background=E0E7FF&color=3730A3`;
            }
        };

        const populateProdi = (prodiList, selectedId) => {
            const select = document.getElementById('id_program_studi');
            select.innerHTML = '<option value="">Pilih Program Studi</option>';
            prodiList.forEach(prodi => {
                const option = new Option(prodi.nama_program_studi, prodi.id_program_studi);
                if (prodi.id_program_studi == selectedId) { option.selected = true; }
                select.appendChild(option);
            });
        };

        const displayErrors = (errors) => {
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            for (const field in errors) {
                const errorEl = document.getElementById(`error-${field}`);
                if (errorEl) {
                    errorEl.textContent = errors[field][0];
                }
            }
        };
        
        try {
            const [profileRes, prodiRes] = await Promise.all([ axios.get('/api/profil-mahasiswa'), axios.get('/api/program-studi') ]);
            if (profileRes.data.success) {
                populateForm(profileRes.data);
                if(prodiRes.data.data) {
                    populateProdi(prodiRes.data.data, profileRes.data.data.id_program_studi);
                }
            }
        } catch (error) {
            console.error('Gagal mengambil data awal:', error);
            alert('Gagal memuat data profil. Silakan coba lagi.');
        }

        // Event listener untuk preview foto
        fotoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    fotoPreview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        // PERBAIKAN PENTING PADA VALIDASI REAL-TIME NOMOR TELEPON
        const notelpInput = document.getElementById('notelp');
        if (notelpInput) {
            notelpInput.addEventListener('input', function(e) {
                // Hapus karakter non-digit dari nilai input secara real-time
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        }
        // AKHIR PERBAIKAN

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            submitButton.disabled = true;
            submitButton.textContent = 'Menyimpan...';
            successMessage.style.display = 'none';
            displayErrors({});
            
            const formData = new FormData(form);
            // Laravel akan mengenali _method sebagai PATCH/PUT
            formData.append('_method', 'POST'); // Atau 'PATCH' jika route Anda POST tapi method PATCH

            try {
                // Endpoint POST /api/profil-mahasiswa dengan _method PATCH
                const response = await axios.post('/api/profil-mahasiswa', formData);
                successMessage.textContent = response.data.message;
                successMessage.style.display = 'block';
                setTimeout(() => { window.location.href = "{{ route('profile') }}"; }, 1500);
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    displayErrors(error.response.data.errors);
                } else {
                    console.error('Gagal menyimpan profil:', error);
                    alert('Terjadi kesalahan saat menyimpan. Silakan coba lagi.');
                }
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = 'Simpan Perubahan';
            }
        });
    });
    </script>
</body>
</html>