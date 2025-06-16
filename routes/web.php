<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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