<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Prestasi;
use App\Models\RegistrasiLomba;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

    public function berikan(Request $request)
    {
        // 1. Validasi input dari form admin
        $validator = Validator::make($request->all(), [
            // Validasi input baru
            'id_user'             => 'required|exists:users,id_user',
            'id_lomba'            => [
                'required',
                'exists:lomba,id_lomba',
                // Validasi unique pada kombinasi id_user dan id_lomba
                Rule::unique('prestasi')->where(function ($query) use ($request) {
                    return $query->where('id_user', $request->id_user);
                }),
            ],
            'peringkat'           => 'required|string|max:255',
            'tipe_prestasi'       => 'required|in:pemenang,peserta',
            'tanggal_diraih'      => 'required|date',
            'sertifikat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'id_lomba.unique' => 'Peserta ini sudah pernah diberikan prestasi untuk lomba yang sama.'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validasi gagal', 'errors' => $validator->errors()], 422);
        }

        // 2. Handle File Upload (tetap sama, tapi nama file bisa disesuaikan)
        $sertifikatPath = null;
        if ($request->hasFile('sertifikat')) {
            $file = $request->file('sertifikat');
            $fileName = 'sertifikat_lomba_' . $request->id_lomba . '_user_' . $request->id_user . '_' . time() . '.' . $file->getClientOriginalExtension();
            // Simpan file dan dapatkan path-nya
            $sertifikatPath = $file->storeAs('sertifikat', $fileName, 'public');
        }

        // 3. Simpan ke Database
        $prestasi = Prestasi::create([
            // Menggunakan data langsung dari request
            'id_user'             => $request->id_user,
            'id_lomba'            => $request->id_lomba,
            'peringkat'           => $request->peringkat,
            'tipe_prestasi'       => $request->tipe_prestasi,
            'tanggal_diraih'      => $request->tanggal_diraih,
            'sertifikat_path'     => $sertifikatPath,
            'status_verifikasi'   => 'disetujui',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Prestasi berhasil diberikan.',
            'data'    => $prestasi
        ], 201);
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        // Otorisasi, pastikan admin yang benar yang bisa mengedit
        // $this->authorize('update', $prestasi);

        // Validasi
        $validator = Validator::make($request->all(), [
            'peringkat'     => 'sometimes|required|string|max:255',
            'tipe_prestasi' => 'sometimes|required|in:pemenang,peserta',
            'tanggal_diraih' => 'sometimes|required|date',
            'sertifikat'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validasi gagal', 'errors' => $validator->errors()], 422);
        }

        $updateData = $request->only(['peringkat', 'tipe_prestasi', 'tanggal_diraih']);

        // Handle jika ada file sertifikat baru yang di-upload
        if ($request->hasFile('sertifikat')) {
            // Hapus file lama jika ada
            if ($prestasi->file_sertifikat && Storage::disk('public')->exists($prestasi->file_sertifikat)) {
                Storage::disk('public')->delete($prestasi->file_sertifikat);
            }

            // Simpan file baru
            $path = $request->file('sertifikat')->store('sertifikat', 'public');
            $updateData['file_sertifikat'] = $path;
        }

        $prestasi->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Prestasi berhasil diperbarui.',
            'data'    => $prestasi
        ]);
    }
}
