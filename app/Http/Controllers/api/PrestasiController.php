<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Prestasi;

class PrestasiController extends Controller
{
    /**
     * Menyimpan pengajuan rekognisi prestasi baru.
     * POST /api/prestasi
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $validatedData = $request->validate([
            'nama_lomba_eksternal'  => 'required|string|max:255',
            'penyelenggara_eksternal' => 'required|string|max:255',
            'tingkat'               => 'required|in:internal,nasional,internasional',
            'peringkat'             => 'required|string|max:100',
            'tanggal_diraih'        => 'required|date',
            'sertifikat'            => 'required|file|mimes:pdf,jpg,png,jpeg|max:2048', // Wajib ada file sertifikat
        ]);

        // 2. Handle file upload untuk sertifikat
        $sertifikatPath = $request->file('sertifikat')->store('sertifikat_prestasi', 'public');

        // 3. Buat record baru di tabel 'prestasi'
        Prestasi::create([
            'id_user' => Auth::id(), // ID mahasiswa yang mengajukan
            'lomba_dari' => 'eksternal', // Menandakan ini dari pengajuan luar
            
            // Kolom dari hasil validasi
            'nama_lomba_eksternal'  => $validatedData['nama_lomba_eksternal'],
            'penyelenggara_eksternal' => $validatedData['penyelenggara_eksternal'],
            'tingkat'               => $validatedData['tingkat'],
            'peringkat'             => $validatedData['peringkat'],
            'tanggal_diraih'        => $validatedData['tanggal_diraih'],
            
            // Path file sertifikat yang sudah di-upload
            'sertifikat_path'       => $sertifikatPath,

            // Status default untuk verifikasi
            'status_verifikasi'     => 'menunggu',
        ]);

        // 4. Kirim respons sukses
        return response()->json([
            'success' => true,
            'message' => 'Pengajuan rekognisi prestasi berhasil dikirim! Silakan tunggu proses verifikasi.'
        ], 201);
    }
}