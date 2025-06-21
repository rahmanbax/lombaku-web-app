<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RegistrasiLomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasilLombaController extends Controller
{
    /**
     * Menampilkan halaman daftar lomba yang diikuti oleh mahasiswa.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil semua registrasi lomba yang status lombanya sudah selesai
        $lombaSelesai = $user->registrasiLomba()
            ->whereHas('lomba', function ($query) {
                $query->where('status', 'selesai');
            })
            ->with(['lomba', 'penilaian.tahap']) // Eager load relasi yang dibutuhkan
            ->get();

        return view('mahasiswa.lomba.hasil-lomba-list', compact('lombaSelesai'));
    }

    /**
     * Menampilkan detail hasil penilaian untuk satu pendaftaran lomba spesifik.
     */
    public function show(RegistrasiLomba $registrasi)
    {
        // Pastikan pengguna yang login adalah pemilik registrasi ini
        if ($registrasi->id_mahasiswa !== Auth::id()) {
            abort(403, 'Anda tidak diizinkan mengakses halaman ini.');
        }

        // Ambil data registrasi beserta relasi yang dibutuhkan
        $registrasi->load(['lomba', 'penilaian.tahap', 'penilaian.penilai']);

        return view('mahasiswa.lomba.hasil-lomba-detail', compact('registrasi'));
    }
}