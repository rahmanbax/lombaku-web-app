<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Rekognisi Prestasi - Lombaku</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background-color: #f9fafb; }
        .form-input:focus { border-color: #3B82F6; box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5); }
        .error-message { color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; }
        .file-drop-area { border: 2px dashed #d1d5db; transition: all 0.2s ease; }
        .file-drop-area.highlight { border-color: #3B82F6; background-color: #eff6ff; }
    </style>
</head>
<body class="bg-gray-50">

<x-public-header-nav />

<div class="container mx-auto px-4 py-12 max-w-3xl">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800">Formulir Pengajuan Prestasi</h1>
            <p class="text-lg text-gray-600 mt-2">Gunakan formulir ini untuk mengajukan rekognisi prestasi Anda ke pihak universitas.</p>
        </div>
        
        <div id="success-alert" class="hidden bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md"></div>
        
        <div id="info-rekognisi" class="hidden mb-6 p-4 bg-blue-50 border-l-4 border-blue-400 text-blue-800 rounded-r-lg">
            <p class="font-semibold"><i class="fas fa-info-circle mr-2"></i>Anda mengajukan rekognisi dari prestasi internal.</p>
            <p class="text-sm mt-1">Data di bawah ini telah terisi otomatis. Anda dapat mengubahnya jika perlu.</p>
        </div>

        <form id="rekognisi-form" novalidate>
            <div class="space-y-6">
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
                        <label for="peringkat_eksternal" class="font-medium text-gray-700">Peringkat / Juara</label>
                        <input type="text" id="peringkat_eksternal" name="peringkat" class="mt-1 w-full p-3 border rounded-lg form-input" placeholder="Contoh: Juara 1" required>
                        <p class="error-message"></p>
                    </div>
                </div>
                <div>
                    <label for="tanggal_diraih_eksternal" class="font-medium text-gray-700">Tanggal Prestasi Diraih</label>
                    <input type="date" id="tanggal_diraih_eksternal" name="tanggal_diraih" class="mt-1 w-full p-3 border rounded-lg form-input" required>
                    <p class="error-message"></p>
                </div>
                <div>
                    <label class="font-medium text-gray-700">Bukti Sertifikat</label>
                    <div id="sertifikat-display" class="hidden mt-1 text-sm text-gray-600">
                       <i class="fas fa-check-circle text-green-500 mr-2"></i>Sertifikat sudah ada. <a id="existing-sertifikat-link" href="#" target="_blank" class="text-blue-600 hover:underline">Lihat di sini</a>. Upload file baru hanya jika ingin menggantinya.
                    </div>
                    <div class="mt-2 file-drop-area p-6 text-center rounded-lg">
                        <input type="file" name="sertifikat" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                        <p class="file-info text-gray-500">Seret & lepas atau <span class="text-blue-600 font-semibold">pilih file</span>.</p>
                    </div>
                    <p class="error-message"></p>
                </div>
            </div>
            <div class="mt-8">
                <button type="submit" id="submit-button" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold text-lg py-3 px-6 rounded-lg transition-colors">
                    Ajukan Rekognisi
                </button>
            </div>
        </form>
    </div>
</div>

<x-footer />
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('rekognisi-form');
    const submitButton = document.getElementById('submit-button');
    const successAlert = document.getElementById('success-alert');

    // --- File Input UI Logic ---
    form.querySelectorAll('.file-drop-area').forEach(dropArea => {
        const input = dropArea.querySelector('input[type="file"]');
        const info = dropArea.querySelector('.file-info');
        dropArea.addEventListener('click', () => input.click());
        dropArea.addEventListener('dragover', (e) => { e.preventDefault(); dropArea.classList.add('bg-blue-50'); });
        dropArea.addEventListener('dragleave', () => dropArea.classList.remove('bg-blue-50'));
        dropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dropArea.classList.remove('bg-blue-50');
            if (e.dataTransfer.files.length > 0) {
                input.files = e.dataTransfer.files;
                info.textContent = input.files[0].name;
            }
        });
        input.addEventListener('change', () => {
            if (input.files.length > 0) info.textContent = input.files[0].name;
        });
    });

    // --- Reusable Form Submission Handler ---
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        submitButton.disabled = true;
        submitButton.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i> Mengirim...`;
        clearErrors();

        const formData = new FormData(form);

        try {
            const response = await axios.post('/api/prestasi', formData, { 
                headers: { 'Content-Type': 'multipart/form-data' }
            });
            
            form.reset();
            form.querySelector('.file-info').innerHTML = 'Seret & lepas atau <span class="text-blue-600 font-semibold">pilih file</span>.';
            successAlert.textContent = response.data.message;
            successAlert.classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });

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

    function clearErrors() {
        form.querySelectorAll('.error-message').forEach(el => el.textContent = '');
    }

    function displayErrors(errors) {
        for (const field in errors) {
            const input = form.querySelector(`[name="${field}"]`);
            if (input) {
                const errorEl = input.parentElement.querySelector('.error-message') || input.parentElement.parentElement.querySelector('.error-message');
                if (errorEl) errorEl.textContent = errors[field][0];
            }
        }
    }
    
    // --- [FUNGSI KUNCI] Membaca URL dan mengisi form ---
    function prefillFormFromUrl() {
        const params = new URLSearchParams(window.location.search);
        
        if (!params.has('from_internal')) {
            return; // Jika tidak ada parameter, tidak melakukan apa-apa
        }
        
        // Isi semua field dari parameter URL
        document.getElementById('nama_lomba_eksternal').value = params.get('nama_lomba_eksternal') || '';
        document.getElementById('penyelenggara_eksternal').value = params.get('penyelenggara_eksternal') || '';
        document.getElementById('tingkat').value = params.get('tingkat') || '';
        document.getElementById('peringkat_eksternal').value = params.get('peringkat') || '';
        document.getElementById('tanggal_diraih_eksternal').value = params.get('tanggal_diraih') || '';

        const sertifikatPath = params.get('existing_sertifikat_path');
        if (sertifikatPath) {
            const fileInput = form.querySelector('input[name="sertifikat"]');
            const sertifikatDisplay = document.getElementById('sertifikat-display');
            const sertifikatLink = document.getElementById('existing-sertifikat-link');

            sertifikatDisplay.classList.remove('hidden');
            sertifikatLink.href = `/storage/${sertifikatPath}`;
            
            // Jadikan input file tidak lagi wajib jika sudah ada sertifikat
            fileInput.required = false;

            // Buat dan tambahkan hidden input untuk mengirim path sertifikat yang sudah ada
            let hiddenInput = form.querySelector('input[name="existing_sertifikat_path"]');
            if (!hiddenInput) {
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'existing_sertifikat_path';
                form.appendChild(hiddenInput);
            }
            hiddenInput.value = sertifikatPath;
            
            // Tampilkan info tambahan
            document.getElementById('info-rekognisi').classList.remove('hidden');
        }
    }
    
    // Panggil fungsi ini saat halaman dimuat
    prefillFormFromUrl(); 
});
</script>
</body>
</html>