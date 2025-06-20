<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfilMahasiswaController extends Controller
{
    /**
     * Menampilkan profil mahasiswa yang sedang login.
     * GET /api/profil-mahasiswa
     */
    public function show()
    {
        $user = Auth::user();

        // Ambil profil mahasiswa beserta data user dan program studinya
        $profil = $user->profilMahasiswa ? $user->profilMahasiswa->load('user', 'programStudi') : null;

        if (!$profil) {
            return response()->json(['success' => false, 'message' => 'Profil mahasiswa tidak ditemukan.'], 404);
        }

        return response()->json(['success' => true, 'data' => $profil], 200);
    }

    /**
     * Memperbarui profil mahasiswa yang sedang login.
     * POST /api/profil-mahasiswa
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $profil = $user->profilMahasiswa;

        if (!$profil) {
            return response()->json(['success' => false, 'message' => 'Profil mahasiswa tidak ditemukan.'], 404);
        }

        // --- INI BAGIAN YANG DIPERBAIKI SECARA TOTAL ---

        // 1. Validasi semua data yang mungkin masuk dari request
        $validatedData = $request->validate([
            // Data untuk tabel 'users'
            'nama'              => 'sometimes|required|string|max:100',
            'notelp'            => 'nullable|string|max:15',
            'email'             => ['sometimes', 'required', 'email', Rule::unique('users')->ignore($user->id_user, 'id_user')],
            
            // Data untuk tabel 'profil_mahasiswa'
            'nim'               => ['sometimes', 'required', 'integer', Rule::unique('profil_mahasiswa')->ignore($profil->id_profil_mahasiswa, 'id_profil_mahasiswa')],
            'id_program_studi'  => 'sometimes|required|exists:program_studi,id_program_studi',
            'tanggal_lahir'     => 'nullable|date',
            'jenis_kelamin'     => 'nullable|in:Laki-laki,Perempuan',
            'headline'          => 'nullable|string|max:255',
            'domisili_provinsi' => 'nullable|string|max:255',
            'domisili_kabupaten'=> 'nullable|string|max:255',
            'kode_pos'          => 'nullable|string|max:10',
            'alamat_lengkap'    => 'nullable|string',
            'sosial_media'      => 'nullable|array',
            'sosial_media.linkedin' => 'nullable|url',
            'sosial_media.github'   => 'nullable|url',
        ]);
        
        // 2. Pisahkan data untuk setiap tabel
        $userData = [
            'nama' => $validatedData['nama'] ?? $user->nama,
            'email' => $validatedData['email'] ?? $user->email,
            'notelp' => $validatedData['notelp'] ?? $user->notelp,
        ];

        // Ambil semua data kecuali data user untuk diupdate ke profil
        $profileData = collect($validatedData)->except(['nama', 'email', 'notelp'])->all();
        
        // 3. Update setiap tabel dengan datanya masing-masing
        $user->update($userData);
        $profil->update($profileData);

        // --------------------------------------------------------

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui.',
            'data' => $profil->fresh()->load('user', 'programStudi') // Ambil data terbaru
        ], 200);
    }
}