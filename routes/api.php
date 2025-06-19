<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\LombaController;
use App\Http\Controllers\api\TagController;
use App\Http\Controllers\api\MahasiswaController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rute yang memerlukan autentikasi
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::get('/lomba/{id}/pendaftar', [LombaController::class, 'getPendaftar']);
Route::get('/lomba/stats', [LombaController::class, 'getStats']);

Route::apiResource('lomba', LombaController::class);
Route::apiResource('tags', TagController::class)->only(['index']);
Route::apiResource('mahasiswa', MahasiswaController::class);