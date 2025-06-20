<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registrasi Lomba: {{ $lomba->nama_lomba }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Styling untuk Select2 agar sesuai dengan tema */
        .select2-container .select2-selection--single { height: 44px !important; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem;}
        .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 28px !important; }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 42px !important; }
        .select2-container .select2-selection--multiple { min-height: 44px !important; border-radius: 0.5rem; border: 1px solid #d1d5db; padding-top: 5px; padding-left: 0.5rem;}
        
        /* Styling untuk Pilihan Tipe Pendaftaran yang lebih menarik */
        .registration-type-card {
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }
        .registration-type-card.selected {
            border-color: #3b82f6; /* blue-500 */
            background-color: #eff6ff; /* blue-50 */
            box-shadow: 0 0 0 2px #3b82f6;
        }
        .registration-type-card input[type="radio"] {
            display: none; /* Sembunyikan radio button asli */
        }
        #form-errors li { list-style-type: disc; margin-left: 20px; }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    
    <x-public-header-nav />

    <main class="container mx-auto p-4 lg:py-10">
        <form id="registrasi-form" novalidate>
            <!-- Layout 2 Kolom -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
                
                <!-- KOLOM KIRI: Detail Lomba & Info Pendaftar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-10 space-y-6">
                        <!-- Card Info Lomba -->
                        <div class="bg-white p-6 rounded-xl shadow-md">
                            <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Lomba</h2>
                            <img src="{{ url($lomba->foto_lomba) }}" alt="Foto Lomba" class="rounded-lg w-full object-cover aspect-video mb-4">
                            <h3 class="font-semibold text-lg text-gray-900">{{ $lomba->nama_lomba }}</h3>
                            <p class="text-sm text-gray-500">Diselenggarakan oleh {{ $lomba->penyelenggara }}</p>
                            <div class="border-t my-4"></div>
                            <div class="space-y-2 text-sm">
                                <p class="flex justify-between">
                                    <span class="text-gray-600">Tingkat:</span>
                                    <span class="font-medium text-gray-800 capitalize">{{ $lomba->tingkat }}</span>
                                </p>
                                 <p class="flex justify-between">
                                    <span class="text-gray-600">Batas Daftar:</span>
                                    <span class="font-medium text-red-600">{{ \Carbon\Carbon::parse($lomba->tanggal_akhir_registrasi)->translatedFormat('d F Y') }}</span>
                                </p>
                            </div>
                        </div>

                        <!-- Card Info Pendaftar (Untuk Individu) -->
                        <div id="individu-info" class="bg-white p-6 rounded-xl shadow-md">
                             <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Pendaftar</h2>
                             <div class="flex items-center space-x-4">
                                <img src="{{ Auth::user()->foto_profile ? url(Auth::user()->foto_profile) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->nama).'&background=E0E7FF&color=3730A3' }}" alt="Foto Profil" class="w-16 h-16 rounded-full object-cover">
                                <div>
                                    <p class="font-bold text-lg text-gray-900">{{ Auth::user()->nama }}</p>
                                    <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                                </div>
                             </div>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN: Form Utama -->
                <div class="lg:col-span-2">
                    <div class="bg-white p-8 rounded-xl shadow-md">
                        <input type="hidden" id="id_lomba" value="{{ $lomba->id_lomba }}">
                        <div id="form-errors" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md mb-6" role="alert">
                            <p class="font-bold">Oops! Ada beberapa kesalahan:</p>
                            <ul class="mt-2"></ul>
                        </div>
                        
                        <!-- Step 1: Tipe Pendaftaran -->
                        <div class="mb-8">
                            <label class="block text-xl font-bold text-gray-800 mb-4">1. Pilih Tipe Pendaftaran</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="registration-type-card border-2 rounded-lg p-6 flex items-center space-x-4 selected">
                                    <input type="radio" name="tipe_pendaftaran" value="individu" checked>
                                    <i class="fas fa-user text-3xl text-blue-500"></i>
                                    <div>
                                        <h4 class="font-bold text-lg">Individu</h4>
                                        <p class="text-sm text-gray-600">Mendaftar sebagai perorangan.</p>
                                    </div>
                                </label>
                                <label class="registration-type-card border-2 rounded-lg p-6 flex items-center space-x-4">
                                    <input type="radio" name="tipe_pendaftaran" value="kelompok">
                                    <i class="fas fa-users text-3xl text-green-500"></i>
                                    <div>
                                        <h4 class="font-bold text-lg">Kelompok</h4>
                                        <p class="text-sm text-gray-600">Mendaftar sebagai sebuah tim.</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Step 2: Detail Tim (Hanya untuk Kelompok) -->
                        <div id="kelompok-section" class="hidden mb-8">
                             <label class="block text-xl font-bold text-gray-800 mb-4">2. Isi Detail Tim</label>
                             <div class="space-y-6 bg-gray-50 p-6 rounded-lg border">
                                <div>
                                    <label for="nama_tim" class="block text-gray-700 text-sm font-bold mb-2">Nama Tim</label>
                                    <input type="text" id="nama_tim" class="shadow-sm appearance-none border rounded-lg w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="members" class="block text-gray-700 text-sm font-bold mb-2">Anggota Tim (Cari dan pilih nama)</label>
                                    <select id="members" name="members[]" multiple="multiple" class="w-full">
                                        @foreach ($mahasiswaList as $mahasiswa)
                                            <option value="{{ $mahasiswa->id_user }}">{{ $mahasiswa->nama }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-gray-500 mt-2">Anda sebagai ketua tim akan otomatis ditambahkan.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Informasi Tambahan -->
                        <div class="mb-8">
                            <label class="block text-xl font-bold text-gray-800 mb-4">Lengkapi Informasi</label>
                             <div class="space-y-6 bg-gray-50 p-6 rounded-lg border">
                                <div>
                                    <label for="id_dosen" class="block text-gray-700 text-sm font-bold mb-2">Ajukan Dosen Pembimbing (Opsional)</label>
                                    <select id="id_dosen" class="w-full">
                                        <option value="">-- Tidak mengajukan dosen pembimbing --</option>
                                        @foreach ($dosenList as $dosen)
                                            <option value="{{ $dosen->id_user }}">{{ $dosen->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="link_pengumpulan" class="block text-gray-700 text-sm font-bold mb-2">Link Pengumpulan Karya/Berkas</label>
                                    <input type="url" id="link_pengumpulan" class="shadow-sm appearance-none border rounded-lg w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="https://drive.google.com/..." required>
                                    <p class="text-xs text-gray-500 mt-2">Contoh: Link Google Drive, GitHub, Figma, dll yang dapat diakses publik.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="mt-8 text-center">
                            <button type="submit" id="submit-btn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition-all text-lg shadow-lg hover:shadow-xl disabled:bg-gray-400 disabled:shadow-none">
                                <i class="fas fa-paper-plane mr-2"></i> Kirim Pendaftaran
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function() {
        // Inisialisasi Select2
        $('#id_dosen').select2({ placeholder: "Pilih Dosen Pembimbing", allowClear: true });
        $('#members').select2({ placeholder: "Cari dan tambah anggota" });

        // Logika untuk Pilihan Tipe Pendaftaran yang interaktif
        const individuInfo = $('#individu-info');
        const kelompokSection = $('#kelompok-section');
        const typeCards = $('.registration-type-card');

        typeCards.on('click', function() {
            typeCards.removeClass('selected');
            $(this).addClass('selected');
            
            const selectedValue = $(this).find('input[type="radio"]').val();
            if (selectedValue === 'kelompok') {
                individuInfo.slideUp();
                kelompokSection.slideDown();
            } else {
                kelompokSection.slideUp();
                individuInfo.slideDown();
            }
        });

        // Handle Form Submission
        $('#registrasi-form').on('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = $('#submit-btn');
            const formErrorsDiv = $('#form-errors');
            const formErrorsList = formErrorsDiv.find('ul');

            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Mengirim...');
            formErrorsDiv.slideUp();
            formErrorsList.empty();

            const formData = {
                id_lomba: $('#id_lomba').val(),
                tipe_pendaftaran: $('input[name="tipe_pendaftaran"]:checked').val(),
                nama_tim: $('#nama_tim').val(),
                members: $('#members').val(),
                id_dosen: $('#id_dosen').val(),
                link_pengumpulan: $('#link_pengumpulan').val(),
            };

            axios.post('/api/registrasi-lomba', formData)
                .then(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pendaftaran Berhasil!',
                        text: response.data.message,
                        timer: 2500,
                        showConfirmButton: false,
                        willClose: () => {
                             window.location.href = "{{ route('status') }}";
                        }
                    });
                })
                .catch(function(error) {
                    let errorMessage = 'Terjadi kesalahan yang tidak diketahui.';
                    if (error.response) {
                         if (error.response.status === 422) {
                           const errors = error.response.data.errors;
                           errorMessage = error.response.data.message;
                           Object.values(errors).flat().forEach(msg => {
                                formErrorsList.append(`<li>${msg}</li>`);
                           });
                           formErrorsDiv.slideDown();
                        } else {
                           errorMessage = error.response.data.message || `Error: ${error.response.statusText}`;
                        }
                    }
                    Swal.fire({ icon: 'error', title: 'Gagal', text: errorMessage });
                })
                .finally(function() {
                    submitBtn.prop('disabled', false).html('<i class="fas fa-paper-plane mr-2"></i> Kirim Pendaftaran');
                });
        });
    });
    </script>
</body>
</html>