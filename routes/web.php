<?php

use App\Http\Controllers\api\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Lomba;
use App\Http\Controllers\API\PrestasiController;
use App\Http\Controllers\API\RegistrasiLombaController;
use App\Http\Controllers\Api\AdminProdiController;
use App\Http\Controllers\API\DosenController;
use App\Http\Controllers\API\HasilLombaController;
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

Route::get('/adminprodi/riwayat-pendaftaran', function() {
    return view('admin.riwayat-pendaftaran');
})->name('admin_prodi.registrasi.history');

Route::get('/adminprodi/arsip-lomba', function() {
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

Route::get('/ajukan-rekognisi', function () {
    return view('mahasiswa.lomba.ajukanrekognisi');
})->name('rekognisi.create')->middleware('auth');

Route::get('status', function () {
    return view('mahasiswa.lomba.statuslomba');
})->name('status')->middleware('auth');

Route::get('lombaterkini', function () {
    return view('mahasiswa.lomba.lombaterkini');
})->name('lombaterkini');

Route::get('/simpanlomba', function () {
    return view('mahasiswa.lomba.simpanlomba');
})->name('simpanlomba')->middleware('auth');

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
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
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

// ==========================================================
// === RUTE SERTIFIKAT DIHAPUS DARI SINI ===
// Akses file akan ditangani langsung oleh web server melalui symbolic link.
// ==========================================================

// ==========================================================
// Dashboard Route Kemahasiswaan

// lindungi dengan middleware auth
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/kemahasiswaan', function () {
        return view('dashboard.kemahasiswaan.index');
    });

    Route::get('/dashboard/kemahasiswaan/lomba', function () {
        return view('dashboard.kemahasiswaan.lomba.index');
    });

    Route::get('/dashboard/kemahasiswaan/lomba/buat', function () {
        return view('dashboard.kemahasiswaan.lomba.buat');
    });

    Route::get('/dashboard/kemahasiswaan/lomba/{id}', function ($id) {
        return view('dashboard.kemahasiswaan.lomba.detail', ['id' => $id]);
    });

    Route::get('/dashboard/kemahasiswaan/mahasiswa', function () {
        return view('dashboard.kemahasiswaan.mahasiswa.index');
    });

    Route::get('/dashboard/kemahasiswaan/mahasiswa/{nim}', function ($nim) {
        return view('dashboard.kemahasiswaan.mahasiswa.detail', ['nim' => $nim]);
    });

    // Dashboard Route Admin Lomba
    Route::get('/dashboard/adminlomba', function () {
        return view('dashboard.adminlomba.index');
    });

    Route::get('/dashboard/adminlomba/lomba', function () {
        return view('dashboard.adminlomba.lomba.index');
    });

    Route::get('/dashboard/adminlomba/lomba/buat', function () {
        return view('dashboard.adminlomba.lomba.buat');
    });

    Route::get('/dashboard/adminlomba/lomba/edit/{id}', function ($id) {
        return view('dashboard.adminlomba.lomba.edit', ['id' => $id]);
    });


    Route::get('/dashboard/adminlomba/lomba/{id}', function ($id) {
        return view('dashboard.adminlomba.lomba.detail', ['id' => $id]);
    });
});
