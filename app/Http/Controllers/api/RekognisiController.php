<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProfilMahasiswa;
use App\Models\Rekognisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RekognisiController extends Controller
{
    /**
     * Menyimpan data rekognisi baru.
     * Endpoint ini biasanya dipanggil oleh admin.
     */
    

    /**
     * Mengambil semua data rekognisi untuk mahasiswa tertentu.
     */
    public function getForMahasiswaByNim($nim) // <-- Parameter sekarang adalah $nim
    {
        // 1. Cari dulu profil mahasiswa berdasarkan NIM untuk mendapatkan user_id.
        // Ini juga berfungsi sebagai validasi apakah NIM tersebut ada.
        $profil = ProfilMahasiswa::where('nim', $nim)->first();

        // Jika profil dengan NIM tersebut tidak ditemukan, kirim respons 404.
        if (!$profil) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa dengan NIM tersebut tidak ditemukan.'
            ], 404);
        }

        // 2. Ambil user_id dari profil yang ditemukan.
        $userId = $profil->id_user;

        // 3. Lakukan query rekognisi seperti sebelumnya, tapi menggunakan userId yang sudah kita temukan.
        $rekognisi = Rekognisi::whereHas('prestasi', function ($query) use ($userId) {
            $query->where('id_user', $userId);
        })
            ->with('prestasi:id_prestasi,peringkat,id_lomba')
            ->latest()
            ->get();

        // 4. Kirim respons.
        return response()->json([
            'success' => true,
            'message' => 'Daftar rekognisi berhasil diambil.',
            'data' => $rekognisi
        ]);
    }
}
