<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\API\BookmarkController;
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
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});



Route::get('/lomba/{id}/pendaftar', [LombaController::class, 'getPendaftar']);
Route::get('/lomba/stats', [LombaController::class, 'getStats']);
Route::get('/lomba/butuh-persetujuan', [LombaController::class, 'getLombaButuhPersetujuan']);
Route::get('/program-studi', [ProgramStudiController::class, 'index']);
Route::patch('/lomba/{id}/setujui', [LombaController::class, 'setujuiLomba']);
Route::apiResource('lomba', LombaController::class);
Route::apiResource('tags', TagController::class)->only(['index']);
Route::apiResource('mahasiswa', MahasiswaController::class);