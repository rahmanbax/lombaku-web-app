<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ProfilAdminLombaController extends Controller
{
    /**
     * Menampilkan profil admin yang terotentikasi.
     * Endpoint: GET /api/profil
     */
    public function show(Request $request)
    {
        $user = $request->user();

        // Eager load relasi untuk efisiensi
        // firstOrCreate memastikan profil selalu ada dan tidak error jika admin baru
        $profil = $user->profilAdminLomba()->firstOrCreate(['id_user' => $user->id_user]);
        $user->setRelation('profilAdminLomba', $profil);

        return response()->json($user);
    }

    /**
     * Memperbarui profil admin yang terotentikasi.
     * Endpoint: POST /api/profil
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'notelp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'jenis_organisasi' => ['required', Rule::in(['Perusahaan', 'Mahasiswa', 'Lainnya'])],
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Update tabel users
        $user->nama = $validatedData['nama'];
        $user->notelp = $validatedData['notelp'];

        if ($request->hasFile('foto_profile')) {
            $file = $request->file('foto_profile');
            $filename = 'foto_profile_' . Str::slug($user->nama) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('foto_profile', $filename, 'public');

            $user->foto_profile = 'foto_profile/' . $filename;
        }

        $user->save();

        // Update tabel profil_admin_lomba
        $user->profilAdminLomba()->update([
            'alamat' => $validatedData['alamat'],
            'jenis_organisasi' => $validatedData['jenis_organisasi'],
        ]);

        // Kirim kembali data user yang sudah ter-update
        return response()->json([
            'message' => 'Profil berhasil diperbarui!',
            'user' => $user->fresh()->load('profilAdminLomba') // ambil data terbaru dari DB
        ]);
    }
}
