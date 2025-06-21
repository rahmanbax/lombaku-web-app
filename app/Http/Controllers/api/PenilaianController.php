<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PenilaianPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PenilaianController extends Controller
{
    // index kosong
    public function index() {}
    /**
     * Menyimpan data penilaian baru.
     * Method ini akan dipanggil oleh POST /api/penilaian
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Jika tidak ada user yang login (misalnya token tidak dikirim), kembalikan error.
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Tidak terautentikasi.'], 401);
        }

        $validator = Validator::make($request->all(), [
            'id_registrasi_lomba' => 'required|exists:registrasi_lomba,id_registrasi_lomba',
            'id_tahap' => [
                'required',
                'exists:tahap_lomba,id_tahap',
                // ==========================================================
                // === PERUBAHAN UTAMA ADA DI SINI ===
                // ==========================================================
                // Aturan ini sekarang memeriksa kombinasi 3 kolom:
                // id_registrasi_lomba, id_penilai, DAN id_tahap.
                Rule::unique('penilaian_peserta')->where(function ($query) use ($request, $user) {
                    return $query->where('id_registrasi_lomba', $request->id_registrasi_lomba)
                        ->where('id_penilai', $user->id_user)
                        ->where('id_tahap', $request->id_tahap); // <-- INI YANG DITAMBAHKAN
                })
            ],
            'nilai' => 'required|integer|min:0|max:100',
            'catatan' => 'nullable|string|max:1000', // Memberi batas max untuk catatan
        ]);

        if ($validator->fails()) {
            // Mengembalikan pesan error yang lebih spesifik jika validasi unique gagal
            if ($validator->errors()->has('id_tahap')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah memberikan penilaian untuk peserta ini di tahap yang sama.'
                ], 422);
            }

            return response()->json(['success' => false, 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        // Jika validasi lolos, buat record baru
        $penilaian = PenilaianPeserta::create([
            'id_registrasi_lomba' => $request->id_registrasi_lomba,
            'id_tahap' => $request->id_tahap,
            'id_penilai' => $user->id_user,
            'nilai' => $request->nilai,
            'catatan' => $request->catatan,
        ]);

        return response()->json(['success' => true, 'message' => 'Penilaian berhasil disimpan.', 'data' => $penilaian], 201);
    }

    public function update(Request $request, $id)
    {
        // 1. Cari data penilaian yang akan diupdate
        $penilaian = PenilaianPeserta::find($id);

        if (!$penilaian) {
            return response()->json([
                'success' => false,
                'message' => 'Data penilaian tidak ditemukan.'
            ], 404);
        }

        // 2. Otorisasi: Pastikan hanya pembuat penilaian yang bisa mengedit
        if ($penilaian->id_penilai !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk mengubah penilaian ini.'
            ], 403); // 403 Forbidden
        }

        // 3. Validasi input yang masuk
        // 'sometimes' digunakan karena mungkin user hanya ingin update nilai, atau hanya catatan
        $validator = Validator::make($request->all(), [
            'nilai' => 'sometimes|required|integer|min:0|max:100',
            'catatan' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        // 4. Lakukan update pada record
        // Menggunakan $validator->validated() untuk keamanan, agar hanya field yang divalidasi yang diupdate
        $penilaian->update($validator->validated());

        // 5. Kembalikan respons sukses dengan data yang sudah diperbarui
        return response()->json([
            'success' => true,
            'message' => 'Penilaian berhasil diperbarui.',
            'data' => $penilaian
        ], 200);
    }
}
