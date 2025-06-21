<?php

use App\Http\Controllers\Api\AdminProdiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\API\BookmarkController;
use App\Http\Controllers\API\DosenController;
use App\Http\Controllers\API\HasilLombaController;
use App\Http\Controllers\api\LombaController;
use App\Http\Controllers\api\TagController;
use App\Http\Controllers\api\MahasiswaController;
use App\Http\Controllers\API\PenilaianController;
use App\Http\Controllers\API\ProfilMahasiswaController;
use App\Http\Controllers\api\ProgramStudiController;
use App\Http\Controllers\API\PrestasiController;
use App\Http\Controllers\API\RegistrasiLombaController;
use App\Http\Controllers\API\RiwayatController;
use App\Http\Controllers\api\TahapLombaController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rute yang memerlukan autentikasi
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profil-mahasiswa', [ProfilMahasiswaController::class, 'show']);
    Route::post('/profil-mahasiswa', [ProfilMahasiswaController::class, 'update']);
    Route::post('/prestasi', [PrestasiController::class, 'store']);
    Route::get('/riwayat', [RiwayatController::class, 'getRiwayat']);
    Route::get('/bookmarks', [BookmarkController::class, 'index']);
    Route::post('/bookmarks', [BookmarkController::class, 'store']);
    Route::delete('/bookmarks/{id_lomba}', [BookmarkController::class, 'destroy']);
    Route::get('/lomba/{id}/pendaftar', [LombaController::class, 'getPendaftar']);

    // ==========================================================
    // === TAMBAHKAN ROUTE INI UNTUK MENANGANI PENDAFTARAN LOMBA ===
    // ==========================================================
    Route::post('/registrasi-lomba', [RegistrasiLombaController::class, 'store']);
    // ==========================================================
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});


// Rute Dosen (sudah di dalam middleware auth)
Route::get('/dosen/dashboard', [DosenController::class, 'dashboardData']);
Route::get('/dosen/riwayat-peserta', [DosenController::class, 'riwayatPeserta']);

// Rute Admin Prodi (sudah di dalam middleware auth)
Route::get('/admin-prodi/arsip-lomba', [App\Http\Controllers\Api\AdminProdiController::class, 'getArchivedLombas']);
Route::get('/admin-prodi/registration-history', [App\Http\Controllers\Api\AdminProdiController::class, 'getRegistrationHistory']);
Route::get('/admin-prodi/prestasi-verifikasi', [App\Http\Controllers\Api\AdminProdiController::class, 'getPrestasiVerifications']);
Route::get('/admin-prodi/lombas', [AdminProdiController::class, 'getLombaList']);

// Rute Publik & Lainnya
Route::patch('/prestasi/{id}/verifikasi/setujui', [App\Http\Controllers\Api\AdminProdiController::class, 'approvePrestasi']);
Route::patch('/prestasi/{id}/verifikasi/tolak', [App\Http\Controllers\Api\AdminProdiController::class, 'rejectPrestasi']);

// Rute Kemahasiswaan dan Admin Lomba
Route::get('/submission/butuh-penilaian', [RegistrasiLombaController::class, 'getMyButuhPenilaian']);
Route::get('/lomba/mystats', [LombaController::class, 'getMyStats']);
Route::get('/lomba/ditolak', [LombaController::class, 'getMyLombaDitolak']);
Route::get('/lomba/stats', [LombaController::class, 'getStats']);
Route::get('/lomba/butuh-persetujuan', [LombaController::class, 'getLombaButuhPersetujuan']);
Route::get('/program-studi', [ProgramStudiController::class, 'index']);
Route::get('/lomba/saya', [LombaController::class, 'getMyLombas']);
Route::get('/lomba/{id}/tahap', [TahapLombaController::class, 'index']);
Route::patch('/lomba/{id}/setujui', [LombaController::class, 'setujuiLomba']);
Route::patch('/lomba/{id}/tolak', [LombaController::class, 'tolakLomba']);
Route::put('/penilaian/{id}', [PenilaianController::class, 'update']);
Route::post('/penilaian', [PenilaianController::class, 'store']);
Route::apiResource('lomba', LombaController::class);
Route::apiResource('tags', TagController::class)->only(['index']);
Route::apiResource('mahasiswa', MahasiswaController::class);