<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Rekognisi Prestasi - Lombaku</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background-color: #f9fafb; }
        .form-input { background-color: #f9fafb; border-color: #d1d5db; transition: all 0.2s ease; }
        .form-input:focus { border-color: #3B82F6; box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5); background-color: white; }
        .form-label { display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; }
        .error-message { color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: none; }
        .file-drop-area { border: 2px dashed #d1d5db; transition: all 0.2s ease; }
        .file-drop-area.highlight { border-color: #3B82F6; background-color: #eff6ff; }
    </style>
</head>
<body class="bg-gray-50">

<x-public-header-nav />

<div class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Formulir Pengajuan Rekognisi Prestasi</h1>
            <p class="text-gray-500 mt-2">Isi formulir di bawah ini untuk prestasi yang Anda raih di luar platform Lombaku.</p>
        </div>
        
        <div id="success-message" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" style="display: none;"></div>

        <form id="rekognisi-form" novalidate>
            <div class="space-y-6">
                <div>
                    <label for="nama_lomba_eksternal" class="form-label">Nama Lomba / Kompetisi</label>
                    <input type="text" id="nama_lomba_eksternal" name="nama_lomba_eksternal" class="w-full p-3 border rounded-lg form-input" required>
                    <p id="error-nama_lomba_eksternal" class="error-message"></p>
                </div>

                <div>
                    <label for="penyelenggara_eksternal" class="form-label">Penyelenggara Lomba</label>
                    <input type="text" id="penyelenggara_eksternal" name="penyelenggara_eksternal" class="w-full p-3 border rounded-lg form-input" required>
                    <p id="error-penyelenggara_eksternal" class="error-message"></p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tingkat" class="form-label">Tingkat Lomba</label>
                        <select id="tingkat" name="tingkat" class="w-full p-3 border rounded-lg form-input" required>
                            <option value="">Pilih Tingkat</option>
                            <option value="internal">Internal Kampus</option>
                            <option value="nasional">Nasional</option>
                            <option value="internasional">Internasional</option>
                        </select>
                        <p id="error-tingkat" class="error-message"></p>
                    </div>
                     <div>
                        <label for="peringkat" class="form-label">Peringkat / Juara</label>
                        <input type="text" id="peringkat" name="peringkat" class="w-full p-3 border rounded-lg form-input" placeholder="Contoh: Juara 1, Medali Emas" required>
                        <p id="error-peringkat" class="error-message"></p>
                    </div>
                </div>

                <div>
                    <label for="tanggal_diraih" class="form-label">Tanggal Prestasi Diraih</label>
                    <input type="date" id="tanggal_diraih" name="tanggal_diraih" class="w-full p-3 border rounded-lg form-input" required>
                    <p id="error-tanggal_diraih" class="error-message"></p>
                </div>

                <div>
                    <label class="form-label">Bukti Sertifikat</label>
                    <div id="file-drop-area" class="file-drop-area p-6 text-center rounded-lg">
                        <input type="file" id="sertifikat" name="sertifikat" class="hidden" accept=".pdf,.jpg,.jpeg,.png" required>
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                        <p id="file-info" class="text-gray-500">Seret & lepas file di sini, atau <span class="text-blue-600 font-semibold cursor-pointer">klik untuk memilih file</span>.</p>
                        <p class="text-xs text-gray-400 mt-1">Maks. 2MB (PDF, JPG, PNG)</p>
                    </div>
                    <p id="error-sertifikat" class="error-message"></p>
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" id="submit-button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-lg py-3 px-6 rounded-lg transition-colors">
                    Ajukan Rekognisi
                </button>
            </div>
        </form>
    </div>
</div>
 <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-20">
        <div class="container mx-auto px-4 py-12">
            <div class="max-w-3xl mx-auto text-center mb-8">
                <p class="text-xl md:text-2xl font-medium mb-6">Butuh mahasiswa potensial untuk mengikuti lomba anda?</p>
                <button class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-3 px-8 rounded-full text-lg transition-colors">
                    Daftar sebagai Admin Lomba
                </button>
            </div>
        </div>
        <div class="bg-gray-900 py-6">
            <div class="container mx-auto px-4 text-center">
                <p class="text-gray-400">&copy; lombaku@2025. All rights reserved.</p>
            </div>
        </div>
    </footer>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('rekognisi-form');
    const submitButton = document.getElementById('submit-button');
    const successMessage = document.getElementById('success-message');
    
    const fileDropArea = document.getElementById('file-drop-area');
    const fileInput = document.getElementById('sertifikat');
    const fileInfo = document.getElementById('file-info');

    // --- File Upload UI Logic ---
    fileDropArea.addEventListener('click', () => fileInput.click());
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        fileDropArea.addEventListener(eventName, e => {
            e.preventDefault();
            e.stopPropagation();
        }, false);
    });
    ['dragenter', 'dragover'].forEach(eventName => {
        fileDropArea.addEventListener(eventName, () => fileDropArea.classList.add('highlight'));
    });
    ['dragleave', 'drop'].forEach(eventName => {
        fileDropArea.addEventListener(eventName, () => fileDropArea.classList.remove('highlight'));
    });
    fileDropArea.addEventListener('drop', e => {
        fileInput.files = e.dataTransfer.files;
        updateFileInfo();
    });
    fileInput.addEventListener('change', updateFileInfo);

    function updateFileInfo() {
        if (fileInput.files.length > 0) {
            fileInfo.innerHTML = `<span class="text-green-600 font-semibold">${fileInput.files[0].name}</span> terpilih.`;
        }
    }

    // --- Form Submission Logic ---
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        submitButton.disabled = true;
        submitButton.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i> Mengirim...`;

        // Clear previous errors
        document.querySelectorAll('.error-message').forEach(el => el.style.display = 'none');
        successMessage.style.display = 'none';

        const formData = new FormData(form);
        
        try {
            const response = await axios.post('/api/prestasi', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            // Handle success
            successMessage.textContent = response.data.message;
            successMessage.style.display = 'block';
            form.reset();
            fileInfo.innerHTML = `Seret & lepas file di sini, atau <span class="text-blue-600 font-semibold cursor-pointer">klik untuk memilih file</span>.`;
            window.scrollTo(0, 0); // Scroll to top to see success message

        } catch (error) {
            if (error.response && error.response.status === 422) {
                // Handle validation errors
                const errors = error.response.data.errors;
                for (const field in errors) {
                    const errorEl = document.getElementById(`error-${field}`);
                    if (errorEl) {
                        errorEl.textContent = errors[field][0];
                        errorEl.style.display = 'block';
                    }
                }
            } else {
                console.error('Submission error:', error);
                alert('Terjadi kesalahan saat mengirim formulir. Silakan coba lagi.');
            }
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = 'Ajukan Rekognisi';
        }
    });
});
</script>

</body>
</html>