<!DOCTYPE html>
<html lang="id" class="bg-gray-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil & Pengaturan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <x-adminlomba-header-nav />

    <main class="lg:w-[1038px] mx-auto p-4 lg:py-10 lg:px-0">

        <!-- Header Halaman -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Profil & Pengaturan</h1>
            <p class="text-gray-500 mt-1">Perbarui foto dan detail personal Anda di sini.</p>
        </div>

        <!-- Container untuk Notifikasi -->
        <div id="message-container" class="mb-6"></div>

        <!-- Card Form Utama -->
        <div class="bg-white rounded-lg border border-gray-200">
            <form id="profile-form">
                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                        <!-- Kolom Kiri: Foto & Instruksi -->
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium text-gray-900">Foto Profil</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Ini akan ditampilkan secara publik di profil Anda.
                            </p>
                        </div>

                        <!-- Kolom Kanan: Area Upload Foto -->
                        <div class="md:col-span-2">
                            <div class="flex items-center gap-6">
                                <img id="profile-image-preview" src="https://ui-avatars.com/api/?name=?&background=EBF4FF&color=76A9EA&size=96"
                                    alt="Foto Profil"
                                    class="h-24 w-24 rounded-full object-cover bg-gray-100">
                                <div>
                                    <label for="foto_profile" class="cursor-pointer rounded-md border border-gray-300 bg-white py-1 px-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        Ubah
                                    </label>
                                    <input type="file" id="foto_profile" name="foto_profile" class="hidden">
                                    <p class="mt-2 text-xs text-gray-500">JPG, WEBP atau PNG. Maks 2MB.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pembatas -->
                <div class="border-t border-gray-200"></div>

                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Kolom Kiri: Info Personal -->
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium text-gray-900">Informasi Personal</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Detail ini akan digunakan untuk keperluan komunikasi dan identifikasi.
                            </p>
                        </div>

                        <!-- Kolom Kanan: Form Input -->
                        <div class="md:col-span-2 space-y-6">
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Organisasi</label>
                                <input type="text" id="nama" name="nama" placeholder="Masukkan nama organisasi" class="w-full mt-2 p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                                <input type="email" id="email" name="email" placeholder="Masukkan alamat email" class="w-full mt-2 p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            </div>

                            <div>
                                <label for="notelp" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                <input type="text" id="notelp" name="notelp" placeholder="Masukkan nomor telepon" class="w-full mt-2 p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            </div>

                            <div>
                                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                                <textarea id="alamat" name="alamat" placeholder="Masukkan alamat lengkap" rows="3" class="w-full mt-2 p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"></textarea>
                            </div>

                            <div>
                                <label for="jenis_organisasi" class="block text-sm font-medium text-gray-700">Jenis Organisasi</label>
                                <select id="jenis_organisasi" name="jenis_organisasi" class="w-full mt-2 p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
                                    <option value="Perusahaan">Perusahaan</option>
                                    <option value="Mahasiswa">Mahasiswa</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Form: Tombol Aksi -->
                <div class="flex items-center justify-end gap-x-6 bg-gray-50 px-6 py-4 rounded-b-lg">
                    <button type="submit" id="submit-button" class="inline-flex justify-center items-center gap-2 rounded-md bg-blue-600 py-2 px-4 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:opacity-50 disabled:cursor-wait">
                        <span id="button-text">Simpan Perubahan</span>
                        <!-- Spinner untuk loading state -->
                        <svg id="button-spinner" class="animate-spin h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Axios via CDN, atau muat via app.js jika menggunakan build tool -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        // Konfigurasi dasar
        axios.defaults.baseURL = 'http://localhost:8000'; // Ganti dengan URL aplikasi Laravel Anda
        axios.defaults.withCredentials = true;

        // Referensi elemen DOM
        const form = document.getElementById('profile-form');
        const messageContainer = document.getElementById('message-container');
        const submitButton = document.getElementById('submit-button');
        const buttonText = document.getElementById('button-text');
        const buttonSpinner = document.getElementById('button-spinner');
        const imagePreview = document.getElementById('profile-image-preview');
        const fileInput = document.getElementById('foto_profile');

        const setLoading = (isLoading) => {
            submitButton.disabled = isLoading;
            buttonText.classList.toggle('hidden', isLoading);
            buttonSpinner.classList.toggle('hidden', !isLoading);
        };

        const showMessage = (message, type = 'success') => {
            const colors = {
                success: 'bg-green-100 border-green-500 text-green-800',
                danger: 'bg-red-100 border-red-500 text-red-800'
            };
            const alert = document.createElement('div');
            alert.className = `border-l-4 p-4 ${colors[type]} alert-enter-from`;
            alert.setAttribute('role', 'alert');
            alert.innerHTML = `<p class="font-bold">${type === 'success' ? 'Berhasil' : 'Error'}</p><p>${message}</p>`;

            messageContainer.innerHTML = '';
            messageContainer.appendChild(alert);

            // Trigger transisi
            requestAnimationFrame(() => {
                alert.classList.add('alert-enter-active');
            });

            setTimeout(() => {
                alert.classList.remove('alert-enter-active');
                alert.classList.add('alert-leave-active');
                alert.addEventListener('transitionend', () => alert.remove());
            }, 5000);
        };

        const populateForm = (user) => {
            const profil = user.profil_admin_lomba;
            form.nama.value = user.nama || '';
            form.email.value = user.email || '';
            form.notelp.value = user.notelp || '';

            if (user.foto_profile) {
                imagePreview.src = `/storage/${user.foto_profile}`;
            } else {
                imagePreview.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(user.nama)}&background=EBF4FF&color=76A9EA&size=96`;
            }

            if (profil) {
                form.alamat.value = profil.alamat || '';
                form.jenis_organisasi.value = profil.jenis_organisasi || 'Perusahaan';
            }
        };

        fileInput.addEventListener('change', (e) => {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = (event) => imagePreview.src = event.target.result;
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            setLoading(true);
            axios.get('/sanctum/csrf-cookie').then(() => {
                axios.get('/api/profil')
                    .then(response => populateForm(response.data))
                    .catch(error => {
                        console.error('Gagal mengambil data:', error);
                        showMessage('Gagal memuat profil. Pastikan Anda sudah login.', 'danger');
                    })
                    .finally(() => setLoading(false));
            });
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            setLoading(true);

            const formData = new FormData(form);

            axios.post('/api/profil', formData)
                .then(response => {
                    showMessage(response.data.message, 'success');
                    populateForm(response.data.user);
                })
                .catch(error => {
                    let errorMessage = 'Terjadi kesalahan saat menyimpan data.';
                    if (error.response && error.response.status === 422) {
                        const errors = Object.values(error.response.data.errors).flat();
                        errorMessage = `<ul>${errors.map(e => `<li>${e}</li>`).join('')}</ul>`;
                    }
                    showMessage(errorMessage, 'danger');
                })
                .finally(() => setLoading(false));
        });
    </script>
</body>

</html>