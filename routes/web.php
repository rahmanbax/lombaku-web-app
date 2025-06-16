<?php

use App\Http\Controllers\api\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route utama
Route::get('/', function () {
    return view('welcome');
});

Route::get('1', function () {
    // Pastikan user sudah login
    if (!Auth::check()) {
        return redirect('/login');
    }
    
    // Ambil data user dari session
    $user = [
        'id' => session('user_id'),
        'username' => session('username'),
        'nama' => session('nama'),
        'email' => session('email'),
        'notelp' => session('notelp'),
        'role' => session('role'),
        'nim_atau_nip' => session('nim_atau_nip'),
        'instansi' => session('instansi'),
    ];
    
    return view('1', ['user' => $user]);
})->name('dashboard');

// Rute untuk menampilkan form login (GET)
Route::get('login', function () {
    return view('auth.login');
})->name('login');

// Rute untuk menangani proses login (POST)
Route::post('login', [AuthController::class, 'login'])->name('login.post');

Route::get('register', function () {
    return view('auth.register');
});

Route::get('/mahasiswa/profile', function () {
    return view('mahasiswa.profile');
});

Route::get('/dashboard/kemahasiswaan', function () {
    return view('dashboard.kemahasiswaan.index');
});

Route::get('/dashboard/kemahasiswaan/lomba', function () {
    return view('dashboard.kemahasiswaan.lomba.index');
});

Route::get('/dashboard/kemahasiswaan/mahasiswa', function () {
    return view('dashboard.kemahasiswaan.mahasiswa.index');
});

Route::get('/dashboard/kemahasiswaan/lomba/buat', function () {
    return view('dashboard.kemahasiswaan.lomba.buat');
});

// Logout route
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('register', [AuthController::class, 'register'])->name('register.post');