<?php

use App\Http\Controllers\api\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Lomba;
use App\Http\Controllers\API\PrestasiController;


Route::get('/', function () {
    // Menghapus filter ->whereIn() agar semua lomba diambil
    $lombas = Lomba::with(['tags'])
        ->latest('created_at') // Urutkan dari yang terbaru
        ->paginate(9);         // Gunakan paginate untuk manajemen halaman yang baik

    return view('welcome', ['lombas' => $lombas]);
})->name('home');
Route::get('/ajukan-rekognisi', function () {
    return view('mahasiswa.lomba.ajukanrekognisi');
})->name('rekognisi.create')->middleware('auth');

Route::get('status', function () {
    return view('mahasiswa.lomba.statuslomba');
})->name('status')->middleware('auth');

Route::get('lombaterkini', function () {
    // Hanya kembalikan view-nya saja. JavaScript akan mengurus pengambilan data.
    return view('mahasiswa.lomba.lombaterkini');
})->name('lombaterkini');

Route::get('/simpanlomba', function () {
    return view('mahasiswa.lomba.simpanlomba');
})->name('simpanlomba')->middleware('auth');

// Route::get('status', function () {
//     return view('mahasiswa.lomba.statuslomba');
// })->name('status');

// Logout route
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

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
    return view('mahasiswa.profile.profile');
})->name('profile');
  Route::get('profile/edit', function () {
        return view('mahasiswa.profile.edit-profile');
    })->name('profile.edit');

Route::get('/lomba/{id}', function ($id) {
    return view('mahasiswa.lomba.detaillomba');
})->name('lomba.show');

// route untuk lihat sertifikat di rute /storage/sertifikat_prestasi/{filename}
Route::get('/storage/sertifikat_prestasi/{filename}', function ($filename) {
    $path = storage_path('app/public/sertifikat_prestasi/' . $filename);
    
    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->name('sertifikat.prestasi');

// Dashboard Route Kemahasiswaan
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

// Dashboard Route Admin Lomba
Route::get('/dashboard/adminlomba', function () {
    return view('dashboard.adminlomba.index');
});