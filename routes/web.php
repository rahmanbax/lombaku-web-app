<?php

use App\Http\Controllers\api\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use App\Models\Lomba;
use App\Models\ProgramStudi;
use App\Http\Controllers\API\PrestasiController;
use App\Http\Controllers\API\RegistrasiLombaController;
use App\Http\Controllers\Api\AdminProdiController;
use App\Http\Controllers\API\DosenController;
use App\Http\Controllers\API\HasilLombaController;
use App\Http\Controllers\API\MahasiswaController;

// ==========================================================
// Rute Dosen
// ==========================================================
Route::get('/dosen', function () {
    return view('dosen.dashboard');
})->middleware('auth')->name('dosen.dashboard');

Route::get('/dosen/riwayat', function () {
    return view('dosen.riwayat');
})->middleware('auth')->name('dosen.riwayat');
// ==========================================================
// === TAMBAHKAN ROUTE BARU INI ===
Route::get('/dosen/persetujuan', function () {
    return view('dosen.persetujuan');
})->middleware('auth')->name('dosen.persetujuan');

// ==========================================================
// Rute Admin Prodi
// ==========================================================
Route::get('/adminprodi', function () {
    return view('admin.dashboard');
})->name('dashboard.admin_prodi.view');

Route::get('/adminprodi/daftar-lomba', function () {
    return view('admin.daftar-lomba');
})->name('admin_prodi.lomba.index');

Route::get('/adminprodi/lomba/{id}', function ($id) {
    return view('admin.detail-lomba', ['id' => $id]);
})->name('admin_prodi.lomba.show');

Route::get('/adminprodi/verifikasi-prestasi', function () {
    return view('admin.verifikasi-prestasi');
})->name('admin_prodi.prestasi.verifikasi');

Route::get('/adminprodi/riwayat-pendaftaran', function () {
    return view('admin.riwayat-pendaftaran');
})->name('admin_prodi.registrasi.history');

Route::get('/adminprodi/arsip-lomba', function () {
    return view('admin.arsip-lomba');
})->name('admin_prodi.lomba.arsip');

// Data JSON untuk Dashboard Admin Prodi
Route::get('/dashboard/admin-prodi-data', [AdminProdiController::class, 'index'])
    ->name('dashboard.admin_prodi.data');
// ==========================================================

// ==========================================================
// Rute Umum Mahasiswa & Publik
// ==========================================================
Route::get('/lomba/{lomba}/registrasi', [RegistrasiLombaController::class, 'create'])
    ->middleware('auth') // Wajib login untuk akses
    ->name('lomba.registrasi');

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/hasil-rekognisi', function () {
        return view('mahasiswa.lomba.hasilrekognisi'); // Arahkan ke view baru
    })->name('hasil-rekognisi');
Route::get('/ajukan-rekognisi', function () {
    return view('mahasiswa.lomba.ajukanrekognisi');
})->name('rekognisi.create')->middleware('auth');

Route::get('status', function () {
    return view('mahasiswa.lomba.statuslomba');
})->name('status')->middleware('auth');

Route::get('lombaterkini', function () {
    return view('mahasiswa.lomba.lombaterkini');
})->name('lombaterkini');

Route::get('/bookmark', function () {
    return view('mahasiswa.lomba.bookmark');
})->name('bookmark')->middleware('auth');

// Rute untuk halaman daftar hasil lomba
Route::get('/hasil-lomba', [HasilLombaController::class, 'index'])
    ->middleware('auth')
    ->name('hasil-lomba.index');

// Rute untuk halaman detail hasil lomba per pendaftaran
Route::get('/hasil-lomba/{registrasi}', [HasilLombaController::class, 'show'])
    ->middleware('auth')
    ->name('hasil-lomba.show');

// ==========================================================
// Rute Autentikasi
// ==========================================================
// Route::get('/register', function () {
//     return view('auth.register');
// })->name('register');
// Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');
// Route::post('/login', [AuthController::class, 'login'])->name('login.post');
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', function () {
    // 1. Ambil semua data program studi dari database, urutkan berdasarkan nama
    $programStudis = ProgramStudi::orderBy('nama_program_studi', 'asc')->get();

    // 2. Kirim data tersebut ke view dengan nama variabel 'programStudis'
    return view('auth.register', ['programStudis' => $programStudis]);
})->name('register');
// PERUBAHAN SELESAI DI SINI

Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// ==========================================================
// Rute Profil & Detail Lomba
// ==========================================================
Route::get('profile', function () {
    return view('mahasiswa.profile.profile');
})->name('profile');

Route::get('profile/edit', function () {
    return view('mahasiswa.profile.edit-profile');
})->name('profile.edit');

Route::get('/lomba/{lomba}', function (Lomba $lomba) {
    return view('mahasiswa.lomba.detaillomba', compact('lomba'));
})->name('lomba.show');

// lindungi dengan middleware auth
Route::middleware('auth')->group(function () {

    // ===============================================
    // GRUP ROUTE UNTUK KEMAHASISWAAN
    // ===============================================
    // Gunakan prefix untuk membuat URL lebih rapi dan middleware untuk keamanan
    Route::prefix('dashboard/kemahasiswaan')
        ->middleware('role.kemahasiswaan')
        ->name('kemahasiswaan.') // Memberi nama prefix pada rute
        ->group(function () {

            Route::get('/', function () {
                return view('dashboard.kemahasiswaan.index');
            })->name('dashboard'); // Nama rute: kemahasiswaan.dashboard

            Route::get('/lomba', function () {
                return view('dashboard.kemahasiswaan.lomba.index');
            })->name('lomba.index');

            Route::get('/lomba/buat', function () {
                return view('dashboard.kemahasiswaan.lomba.buat');
            })->name('lomba.buat');

            Route::get('/lomba/{id}', function ($id) {
                return view('dashboard.kemahasiswaan.lomba.detail', ['id' => $id]);
            })->name('lomba.detail');

            Route::get('/mahasiswa', function () {
                return view('dashboard.kemahasiswaan.mahasiswa.index');
            })->name('mahasiswa.index');

            Route::get('/mahasiswa/{nim}', function ($nim) {
                return view('dashboard.kemahasiswaan.mahasiswa.detail', ['nim' => $nim]);
            })->name('mahasiswa.detail');
        });


    // ===============================================
    // GRUP ROUTE UNTUK ADMIN LOMBA
    // ===============================================
    Route::prefix('dashboard/adminlomba')
        ->middleware('role.adminlomba')
        ->name('adminlomba.') // Memberi nama prefix pada rute
        ->group(function () {

            Route::get('/', function () {
                return view('dashboard.adminlomba.index');
            })->name('dashboard'); // Nama rute: adminlomba.dashboard

            Route::get('/lomba', function () {
                return view('dashboard.adminlomba.lomba.index');
            })->name('lomba.index');

            Route::get('/lomba/buat', function () {
                return view('dashboard.adminlomba.lomba.buat');
            })->name('lomba.buat');

            Route::get('/lomba/edit/{id}', function ($id) {
                return view('dashboard.adminlomba.lomba.edit', ['id' => $id]);
            })->name('lomba.edit');

            Route::get('/lomba/{id}', function ($id) {
                return view('dashboard.adminlomba.lomba.detail', ['id' => $id]);
            })->name('lomba.detail');

            Route::get('/profile', function () {
                return view('dashboard.adminlomba.editprofile');
            })->name('profile.edit');
        });
});

// rute lihat sertifikat
Route::get('/sertifikat/{filename}', function ($filename) {
    $path = storage_path('app/public/sertifikat/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    return Response::file($path);
});


// Rute untuk download file XLSX
Route::get('/kemahasiswaan/mahasiswa/export', [MahasiswaController::class, 'exportXlsx'])
    ->name('kemahasiswaan.mahasiswa.export');
