<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ProfilMahasiswaController extends Controller
{
    /**
     * Menampilkan data profil mahasiswa yang sedang login.
     */
    public function show()
    {
        $user = Auth::user();

        // Menggunakan eager loading untuk efisiensi
        $user->load('profilMahasiswa.programStudi');

        if (!$user->profilMahasiswa) {
            return response()->json(['success' => false, 'message' => 'Profil mahasiswa tidak ditemukan.'], 404);
        }

        // Menggabungkan data user dan profil ke dalam satu array
        $profileData = $user->profilMahasiswa->toArray();
        $profileData['user'] = $user->toArray();
        $profileData['program_studi'] = $user->profilMahasiswa->programStudi;

        return response()->json(['success' => true, 'data' => $profileData]);
    }

    /**
     * Memperbarui data profil mahasiswa yang sedang login.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $profilMahasiswa = $user->profilMahasiswa;

        if (!$profilMahasiswa) {
            return response()->json(['success' => false, 'message' => 'Profil mahasiswa tidak ditemukan.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id_user, 'id_user')],
            'nim' => ['required', 'string', 'max:20', Rule::unique('profil_mahasiswa')->ignore($profilMahasiswa->id_profil_mahasiswa, 'id_profil_mahasiswa')],
            'id_program_studi' => 'required|exists:program_studi,id_program_studi',
            'notelp' => 'nullable|string|max:15',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'alamat_lengkap' => 'nullable|string|max:255',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk foto
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            // Update data di tabel users
            $user->nama = $request->nama;
            $user->email = $request->email;
            $user->notelp = $request->notelp;

            // Handle upload foto profil
            if ($request->hasFile('foto_profile')) {
                // Hapus foto lama jika ada
                if ($user->foto_profile && Storage::disk('public')->exists($user->foto_profile)) {
                    Storage::disk('public')->delete($user->foto_profile);
                }
                // Simpan foto baru dan dapatkan path-nya
                $path = $request->file('foto_profile')->store('foto_profil', 'public');
                $user->foto_profile = $path;
            }

            $user->save();

            // Update data di tabel profil_mahasiswa
            $profilMahasiswa->nim = $request->nim;
            $profilMahasiswa->id_program_studi = $request->id_program_studi;
            $profilMahasiswa->tanggal_lahir = $request->tanggal_lahir;
            $profilMahasiswa->jenis_kelamin = $request->jenis_kelamin;
            $profilMahasiswa->alamat_lengkap = $request->alamat_lengkap;
            $profilMahasiswa->save();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Profil berhasil diperbarui!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui profil: ' . $e->getMessage()], 500);
        }
    }
}