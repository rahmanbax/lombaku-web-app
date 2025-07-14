<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Rekognisi Prestasi - Lombaku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- TomSelect CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
        }

        .form-input:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .file-drop-area {
            border: 2px dashed #d1d5db;
            transition: all 0.2s ease;
        }

        .file-drop-area.highlight {
            border-color: #3B82F6;
            background-color: #eff6ff;
        }

        /* Style untuk TomSelect */
        .ts-control {
            padding: 0.60rem 0.75rem !important;
            border-radius: 0.5rem !important;
            border-color: #d1d5db !important;
        }

        .ts-control:focus {
            border-color: #3B82F6 !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5) !important;
        }
    </style>
</head>

<body class="bg-gray-50">

    <x-public-header-nav />

    <div class="container mx-auto px-4 py-12 max-w-3xl">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-800">Formulir Pengajuan Prestasi</h1>
                <p class="text-lg text-gray-600 mt-2">Gunakan formulir ini untuk mengajukan rekognisi prestasi individu atau tim Anda.</p>
            </div>

            <div id="success-alert" class="hidden bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md"></div>

            <form id="rekognisi-form" novalidate>
                <!-- Informasi Tim -->
                <fieldset class="border-t pt-6">
                    <legend class="text-lg font-semibold text-gray-800 px-2 -mx-2">Informasi Tim</legend>
                    <div class="space-y-6 mt-4">
                        <div>
                            <label for="is_tim" class="font-medium text-gray-700">Jenis Pengajuan</label>
                            <select id="is_tim" name="is_tim" class="mt-1 w-full p-3 border rounded-lg form-input bg-white">
                                <option value="0" selected>Perorangan</option>
                                <option value="1">Tim / Kelompok</option>
                            </select>
                        </div>

                        <div id="tim-fields" class="hidden space-y-6">
                            <div>
                                <label for="nama_tim" class="font-medium text-gray-700">Nama Tim</label>
                                <input type="text" id="nama_tim" name="nama_tim" class="mt-1 w-full p-3 border rounded-lg form-input" placeholder="Masukkan nama tim Anda">
                                <p class="error-message"></p>
                            </div>
                            <div>
                                <label for="member_ids" class="font-medium text-gray-700">Anggota Tim</label>
                                <p class="text-sm text-gray-500 mb-2">Cari anggota berdasarkan nama atau NIM. Ketua tim (Anda) akan otomatis ditambahkan.</p>
                                <select id="member_ids" name="member_ids[]" multiple placeholder="Ketik untuk mencari mahasiswa..."></select>
                                <p class="error-message"></p>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <!-- Detail Prestasi -->
                <fieldset class="border-t pt-6 mt-8">
                    <legend class="text-lg font-semibold text-gray-800 px-2 -mx-2">Detail Prestasi</legend>
                    <div class="space-y-6 mt-4">
                        <div>
                            <label for="nama_lomba_eksternal" class="font-medium text-gray-700">Nama Lomba / Kompetisi</label>
                            <input type="text" id="nama_lomba_eksternal" name="nama_lomba_eksternal" class="mt-1 w-full p-3 border rounded-lg form-input" required>
                            <p class="error-message"></p>
                        </div>
                        <div>
                            <label for="penyelenggara_eksternal" class="font-medium text-gray-700">Penyelenggara Lomba</label>
                            <input type="text" id="penyelenggara_eksternal" name="penyelenggara_eksternal" class="mt-1 w-full p-3 border rounded-lg form-input" required>
                            <p class="error-message"></p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="tingkat" class="font-medium text-gray-700">Tingkat Lomba</label>
                                <select id="tingkat" name="tingkat" class="mt-1 w-full p-3 border rounded-lg form-input bg-white" required>
                                    <option value="">Pilih Tingkat</option>
                                    <option value="internal">Internal Kampus</option>
                                    <option value="nasional">Nasional</option>
                                    <option value="internasional">Internasional</option>
                                </select>
                                <p class="error-message"></p>
                            </div>
                            <div>
                                <label for="peringkat" class="font-medium text-gray-700">Peringkat / Juara</label>
                                <!-- Elemen SELECT ini akan diubah oleh TomSelect. HTML-nya tetap sama. -->
                                <select id="peringkat" name="peringkat" class="mt-1 w-full p-3 border rounded-lg form-input bg-white" required>
                                    <option value="">Pilih atau ketik peringkat...</option>
                                    <option value="Juara 1">Juara 1</option>
                                    <option value="Juara 2">Juara 2</option>
                                    <option value="Juara 3">Juara 3</option>
                                    <option value="Juara Harapan 1">Juara Harapan 1</option>
                                    <option value="Juara Harapan 2">Juara Harapan 2</option>
                                    <option value="Pendanaan">Didanai / Pendanaan</option>
                                    <option value="Peserta">Peserta / Partisipan</option>
                                </select>
                                <p class="error-message"></p>
                            </div>
                        </div>
                        <div>
                            <label for="tanggal_diraih" class="font-medium text-gray-700">Tanggal Prestasi Diraih</label>
                            <input type="date" id="tanggal_diraih" name="tanggal_diraih" class="mt-1 w-full p-3 border rounded-lg form-input" required>
                            <p class="error-message"></p>
                        </div>
                        <div>
                            <label class="font-medium text-gray-700">Bukti Sertifikat (PDF, JPG, PNG)</label>
                            <div class="mt-2 file-drop-area p-6 text-center rounded-lg">
                                <input type="file" name="sertifikat" class="hidden" accept=".pdf,.jpg,.jpeg,.png" required>
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                <p class="file-info text-gray-500">Seret & lepas atau <span class="text-blue-600 font-semibold">pilih file</span>.</p>
                            </div>
                            <p class="error-message"></p>
                        </div>
                    </div>
                </fieldset>

                <div class="mt-8">
                    <button type="submit" id="submit-button" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold text-lg py-3 px-6 rounded-lg transition-colors">
                        Ajukan Rekognisi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <x-footer />
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('rekognisi-form');
            const submitButton = document.getElementById('submit-button');
            const successAlert = document.getElementById('success-alert');

            // --- File Input UI Logic ---
            const dropArea = form.querySelector('.file-drop-area');
            const fileInput = dropArea.querySelector('input[type="file"]');
            const fileInfo = dropArea.querySelector('.file-info');
            dropArea.addEventListener('click', () => fileInput.click());
            dropArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropArea.classList.add('highlight');
            });
            dropArea.addEventListener('dragleave', () => dropArea.classList.remove('highlight'));
            dropArea.addEventListener('drop', (e) => {
                e.preventDefault();
                dropArea.classList.remove('highlight');
                if (e.dataTransfer.files.length > 0) {
                    fileInput.files = e.dataTransfer.files;
                    fileInfo.textContent = fileInput.files[0].name;
                }
            });
            fileInput.addEventListener('change', () => {
                if (fileInput.files.length > 0) fileInfo.textContent = fileInput.files[0].name;
            });

            // --- Form Submission Handler ---
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                submitButton.disabled = true;
                submitButton.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i> Mengirim...`;
                clearErrors();

                const formData = new FormData(form);
                try {
                    const response = await axios.post('/api/prestasi', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    });
                    form.reset();
                    memberSelect.clear();
                    // Reset TomSelect untuk peringkat juga
                    peringkatSelect.clear(); 
                    fileInfo.innerHTML = 'Seret & lepas atau <span class="text-blue-600 font-semibold">pilih file</span>.';
                    successAlert.textContent = response.data.message;
                    successAlert.classList.remove('hidden');
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                } catch (error) {
                    if (error.response && error.response.status === 422) {
                        displayErrors(error.response.data.errors);
                    } else {
                        alert(`Terjadi kesalahan: ${error.response?.data?.message || error.message}`);
                    }
                } finally {
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Ajukan Rekognisi';
                }
            });

            // --- Helper Functions ---
            function clearErrors() {
                form.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            }

            function displayErrors(errors) {
                for (const field in errors) {
                    const inputName = field.split('.')[0]; // Handle array fields like 'member_ids.0'
                    const input = form.querySelector(`[name^="${inputName}"]`);
                    if (input) {
                        // Untuk TomSelect, cari parent yang lebih tinggi
                        const errorContainer = input.closest('div');
                        const errorEl = errorContainer ? errorContainer.querySelector('.error-message') : null;
                        if (errorEl) errorEl.textContent = errors[field][0];
                    }
                }
            }

            // --- Logika Form Tim ---
            const isTimSelect = document.getElementById('is_tim');
            const timFieldsContainer = document.getElementById('tim-fields');
            const namaTimInput = document.getElementById('nama_tim');

            isTimSelect.addEventListener('change', () => {
                if (isTimSelect.value === '1') {
                    timFieldsContainer.classList.remove('hidden');
                    namaTimInput.required = true;
                } else {
                    timFieldsContainer.classList.add('hidden');
                    namaTimInput.required = false;
                }
            });

            // --- [PERBAIKAN] Inisialisasi TomSelect untuk Peringkat ---
            const peringkatSelect = new TomSelect('#peringkat', {
                create: true,       // Izinkan pengguna membuat opsi baru
                createOnBlur: true, // Buat opsi baru saat input kehilangan fokus
                persist: false,     // Jangan simpan opsi baru di dropdown
                render: {
                    option_create: function(data, escape) {
                        return '<div class="create">Tambah <strong>' + escape(data.input) + '</strong>…</div>';
                    },
                }
            });

            // --- Inisialisasi TomSelect untuk pencarian anggota ---
            const memberSelect = new TomSelect('#member_ids', {
                valueField: 'id_user',
                labelField: 'nama',
                searchField: ['nama', 'nim'],
                create: false,
                render: {
                    option: function(data, escape) {
                        const nim = data.profil_mahasiswa ? `(${escape(data.profil_mahasiswa.nim)})` : '';
                        return `<div><span class="font-semibold">${escape(data.nama)}</span><span class="text-sm text-gray-500 ml-2">${nim}</span></div>`;
                    },
                    item: function(data, escape) {
                        const nim = data.profil_mahasiswa ? `(${escape(data.profil_mahasiswa.nim)})` : '';
                        return `<div>${escape(data.nama)} <span class="text-xs text-gray-500">${nim}</span></div>`;
                    }
                },
                load: function(query, callback) {
                    if (!query.length) return callback();
                    axios.get('/api/mahasiswa/search', {
                            params: {
                                q: query
                            }
                        })
                        .then(response => callback(response.data))
                        .catch(() => callback());
                }
            });
        });
    </script>
</body>

</html>