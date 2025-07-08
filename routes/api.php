<?php

use App\Http\Controllers\Api\AdminProdiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\API\BookmarkController;
use App\Http\Controllers\API\DosenController;
use App\Http\Controllers\api\LombaController;
use App\Http\Controllers\api\TagController;
use App\Http\Controllers\api\MahasiswaController;
use App\Http\Controllers\API\PenilaianController;
use App\Http\Controllers\API\ProfilMahasiswaController;
use App\Http\Controllers\api\ProgramStudiController;
use App\Http\Controllers\API\PrestasiController;
use App\Http\Controllers\Api\ProfilAdminLombaController;
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
    Route::post('/prestasi', [PrestasiController::class, 'store']); // Untuk form eksternal
    Route::post('/prestasi/internal', [PrestasiController::class, 'storeInternal']); // Untuk klaim awal
    Route::get('/prestasi/internal-untuk-rekognisi', [PrestasiController::class, 'getInternalUntukRekognisi']); // [ROUTE BARU/PENTING]
    Route::get('/prestasi/lomba-yang-bisa-diklaim', [PrestasiController::class, 'getLombaUntukDiklaim']);
    Route::post('/prestasi/{prestasi}/ajukan-rekognisi', [PrestasiController::class, 'ajukanRekognisi'])->name('prestasi.ajukan-rekognisi');

    // ==========================================================
    // === TAMBAHKAN ROUTE INI UNTUK MENANGANI PENDAFTARAN LOMBA ===
    // ==========================================================
    Route::post('/registrasi-lomba', [RegistrasiLombaController::class, 'store']);
    // ==========================================================

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});


Route::prefix('dosen')->group(function () {
    // URL yang dihasilkan: /api/dosen/dashboard
    Route::get('/dashboard', [DosenController::class, 'dashboardData']);

    // URL yang dihasilkan: /api/dosen/riwayat-peserta
    Route::get('/riwayat-peserta', [DosenController::class, 'riwayatPeserta']);

    // URL yang dihasilkan: /api/dosen/persetujuan
    Route::get('/persetujuan', [DosenController::class, 'getPersetujuanList']);

    // URL yang dihasilkan: /api/dosen/pendaftaran/{id}/setujui
    Route::patch('/pendaftaran/{id}/setujui', [DosenController::class, 'setujuiPendaftaran']);

    // URL yang dihasilkan: /api/dosen/pendaftaran/{id}/tolak
    Route::patch('/pendaftaran/{id}/tolak', [DosenController::class, 'tolakPendaftaran']);
});

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
Route::get('/lomba/distribusi-pendaftar', [LombaController::class, 'getDistribusiPendaftar']);
Route::get('/lomba/berlangsung', [LombaController::class, 'getLombaBerlangsung']);
Route::get('/lomba/terbaru', [LombaController::class, 'getMyRecentLombas']);
Route::get('/lomba/kemahasiswaan', [LombaController::class, 'getGlobalStats']);
Route::patch('/lomba/{id}/setujui', [LombaController::class, 'setujuiLomba']);
Route::patch('/lomba/{id}/tolak', [LombaController::class, 'tolakLomba']);
Route::put('/penilaian/{id}', [PenilaianController::class, 'update']);
Route::put('/prestasi/{prestasi}', [PrestasiController::class, 'update']);
Route::post('/prestasi/berikan', [PrestasiController::class, 'berikan']);
Route::post('/penilaian', [PenilaianController::class, 'store']);
Route::get('/mahasiswa/stats', [MahasiswaController::class, 'getDashboardStats']);
Route::get('/mahasiswa/{nim}/detail', [MahasiswaController::class, 'showDetail']);
Route::apiResource('lomba', LombaController::class);
Route::apiResource('tags', TagController::class)->only(['index']);
Route::apiResource('mahasiswa', MahasiswaController::class);
Route::get('/profil', [ProfilAdminLombaController::class, 'show']);
Route::post('/profil', [ProfilAdminLombaController::class, 'update']);


