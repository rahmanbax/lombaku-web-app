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
        .error-message { color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: none; }
    </style>
</head>
<body class="bg-gray-50">

<x-public-header-nav />

<div class="container mx-auto px-4 py-8 max-w-4xl">
    <form id="edit-profile-form" novalidate>
        <div class="bg-white rounded-xl shadow-md p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-8">Edit Profil Mahasiswa</h1>

            <!-- Data Diri & Akademik -->
            <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">Informasi Akademik & Kontak</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="w-full p-2 border rounded-md form-input">
                    <p id="error-nama" class="error-message"></p>
                </div>
                 <div>
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" id="nim" name="nim" class="w-full p-2 border rounded-md form-input">
                    <p id="error-nim" class="error-message"></p>
                </div>
                <div>
                    <label for="id_program_studi" class="form-label">Program Studi</label>
                    <select id="id_program_studi" name="id_program_studi" class="w-full p-2 border rounded-md form-input">
                        <option value="">Memuat...</option>
                    </select>
                    <p id="error-id_program_studi" class="error-message"></p>
                </div>
                <div>
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="w-full p-2 border rounded-md form-input">
                    <p id="error-email" class="error-message"></p>
                </div>
                <div>
                    <label for="notelp" class="form-label">Nomor Telepon</label>
                    <input type="tel" id="notelp" name="notelp" class="w-full p-2 border rounded-md form-input">
                    <p id="error-notelp" class="error-message"></p>
                </div>
            </div>

            <!-- Informasi Personal -->
            <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2 mt-8">Informasi Personal</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="w-full p-2 border rounded-md form-input">
                    <p id="error-tanggal_lahir" class="error-message"></p>
                </div>
                <div>
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="w-full p-2 border rounded-md form-input">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    <p id="error-jenis_kelamin" class="error-message"></p>
                </div>
                <div class="md:col-span-2">
                    <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
                    <textarea id="alamat_lengkap" name="alamat_lengkap" rows="3" class="w-full p-2 border rounded-md form-input"></textarea>
                </div>
            </div>
            
            <!-- Tombol Aksi -->
            <div class="border-t border-gray-200 mt-8 pt-6 flex justify-end items-center gap-4">
                <a href="{{ route('profile') }}" class="text-gray-600 hover:bg-gray-100 px-4 py-2 rounded-md">Batal</a>
                <button type="submit" id="submit-button" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2 rounded-md transition-colors">
                    Simpan Perubahan
                </button>
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
    
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.withCredentials = true;

    const populateForm = (data) => {
        const profile = data.data;
        document.getElementById('nama').value = profile.user.nama || '';
        document.getElementById('email').value = profile.user.email || '';
        document.getElementById('notelp').value = profile.user.notelp || '';
        document.getElementById('nim').value = profile.nim || '';
        document.getElementById('tanggal_lahir').value = profile.tanggal_lahir ? profile.tanggal_lahir.split('T')[0] : '';
        document.getElementById('jenis_kelamin').value = profile.jenis_kelamin || '';
        document.getElementById('alamat_lengkap').value = profile.alamat_lengkap || '';
    };

    const populateProdi = (prodiList, selectedId) => {
        const select = document.getElementById('id_program_studi');
        select.innerHTML = '<option value="">Pilih Program Studi</option>';
        prodiList.forEach(prodi => {
            const option = document.createElement('option');
            option.value = prodi.id_program_studi;
            option.textContent = prodi.nama_program_studi;
            if (prodi.id_program_studi == selectedId) { option.selected = true; }
            select.appendChild(option);
        });
    };

    const displayErrors = (errors) => {
        document.querySelectorAll('.error-message').forEach(el => { el.textContent = ''; el.style.display = 'none'; });
        for (const field in errors) {
            const errorEl = document.getElementById(`error-${field.replace(/\./g, '_')}`);
            if (errorEl) {
                errorEl.textContent = errors[field][0];
                errorEl.style.display = 'block';
            }
        }
    };
    
    try {
        const [profileRes, prodiRes] = await Promise.all([
            axios.get('/api/profil-mahasiswa'),
            axios.get('/api/program-studi')
        ]);
        if (profileRes.data.success) {
            populateForm(profileRes.data);
            if(prodiRes.data.success) {
                populateProdi(prodiRes.data.data, profileRes.data.data.id_program_studi);
            }
        }
    } catch (error) {
        console.error('Gagal mengambil data awal:', error);
        alert('Gagal memuat data profil. Halaman akan dimuat ulang.');
        window.location.reload();
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        submitButton.disabled = true;
        submitButton.textContent = 'Menyimpan...';
        successMessage.style.display = 'none';
        displayErrors({});

        const formData = new FormData(form);

        try {
            const response = await axios.post('/api/profil-mahasiswa', formData);
            
            successMessage.textContent = response.data.message;
            successMessage.style.display = 'block';
            
            setTimeout(() => {
                window.location.href = "{{ route('profile') }}";
            }, 1500);

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