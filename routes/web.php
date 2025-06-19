<?php

use App\Http\Controllers\api\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Lomba;

Route::get('/', function () {
    // Fetch the data from the Lomba model
    $lombas = Lomba::all();  // Fetching all lombas

    return view('welcome', ['lombas' => $lombas]);  // Passing the lombas to the view
})->name('home');
Route::get('lombaterkini', function () {
    // Fetch the data from the Lomba model
    $lombas = Lomba::all();  // Fetching all lombas

    return view('mahasiswa.lombaterkini', ['lombas' => $lombas]);  // Passing the lombas to the view
})->name('lombaterkini');
Route::get('simpanlomba', function () {
    return view('mahasiswa.simpanlomba');
})->name('simpanlomba');
// Route::get('lombaterkini', function () {
//     return view('mahasiswa.lombaterkini');
// })->name('lombaterkini');
Route::get('status', function () {
    return view('mahasiswa.statuslomba');
})->name('status');
// Logout route
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
// Route::post('register', [AuthController::class, 'register'])->name('register.post');

Route::get('login', function () {
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
    
    return view('welcome', ['user' => $user]);
})->name('welcome');

// Rute untuk menampilkan form login (GET)
Route::get('login', function () {
    return view('auth.login');
})->name('login');

// Rute untuk menangani proses login (POST)
Route::post('login', [AuthController::class, 'login'])->name('login.post');

Route::get('register', function () {
    return view('auth.register');
})->name('register'); 

Route::post('register', [AuthController::class, 'register'])->name('register.post');

Route::get('profile', function () {
    return view('mahasiswa.profile');
})->name('profile'); 

Route::get('detail', function () {
    return view('mahasiswa.detaillomba');
})->name('detail'); 


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
Route::get('/dashboard/kemahasiswaan/lomba/edit/{id}', function ($id) {
    return view('dashboard.kemahasiswaan.lomba.edit', ['id' => $id]);
});

Route::get('/dashboard/kemahasiswaan/mahasiswa', function () {
    return view('dashboard.kemahasiswaan.mahasiswa.index');
});

Route::get('/dashboard/kemahasiswaan/mahasiswa/{nim}', function ($nim) {
    return view('dashboard.kemahasiswaan.mahasiswa.detail', ['nim' => $nim]);
});

Route::get('/project/{id}', function ($id) {
    return view('project.detail', ['id' => $id]);
});


