<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', function () {
    return view('auth.login');
});
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

Route::get('/dashboard/kemahasiswaan/lomba/buat', function () {
    return view('dashboard.kemahasiswaan.lomba.buat');
});