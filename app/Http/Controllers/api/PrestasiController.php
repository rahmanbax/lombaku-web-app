<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Prestasi;
use App\Models\Tim;
use App\Models\User;
use App\Models\RegistrasiLomba;
use Illuminate\Support\Facades\DB;
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
        // --- [PERBAIKAN 1 DARI 2: TAMBAHKAN VALIDASI UNTUK ID SUMBER] ---
        $validator = Validator::make($request->all(), [
            // Validasi Tim
            'is_tim' => 'required|boolean',
            'nama_tim' => 'required_if:is_tim,1|nullable|string|max:255',
            'member_ids' => 'sometimes|nullable|array',
            'member_ids.*' => 'exists:users,id_user',

            // Validasi Detail Prestasi
            'nama_lomba_eksternal' => 'required|string|max:255',
            'penyelenggara_eksternal' => 'required|string|max:255',
            'tingkat' => 'required|in:internal,nasional,internasional',
            'peringkat' => 'required|string|max:100', // <-- TIDAK PERLU DIUBAH, SUDAH BENAR
            'tanggal_diraih' => 'required|date',
            'sertifikat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',

            // Validasi ID sumber (jika ini adalah pengajuan dari prestasi internal)
            'id_prestasi_internal_sumber' => 'sometimes|nullable|exists:prestasi,id_prestasi',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $sertifikatPath = $request->file('sertifikat')->store('sertifikat_prestasi', 'public');

        DB::beginTransaction();
        try {
            $user = Auth::user();
            $idTim = null;
            // Anggota tim selalu dimulai dengan user yang sedang login (ketua tim)
            $anggotaIds = [$user->id_user];

            // Jika ini adalah pengajuan tim
            if ($validatedData['is_tim']) {
                $tim = Tim::create(['nama_tim' => $validatedData['nama_tim']]);
                $idTim = $tim->id_tim;

                if (!empty($validatedData['member_ids'])) {
                    $anggotaIds = array_unique(array_merge($anggotaIds, $validatedData['member_ids']));
                }

                $tim->members()->attach($anggotaIds);
            }

            // Siapkan data dasar untuk setiap record prestasi
            $dataPrestasi = [
                'lomba_dari' => 'eksternal',
                'id_tim' => $idTim,
                'nama_lomba_eksternal' => $validatedData['nama_lomba_eksternal'],
                'penyelenggara_eksternal' => $validatedData['penyelenggara_eksternal'],
                'tingkat' => $validatedData['tingkat'],
                'peringkat' => $validatedData['peringkat'],
                'tipe_prestasi' => 'pemenang',
                'tanggal_diraih' => $validatedData['tanggal_diraih'],
                'sertifikat_path' => $sertifikatPath,
                'status_verifikasi' => 'menunggu',
            ];

            // Buat record prestasi untuk SETIAP ANGGOTA
            foreach ($anggotaIds as $userId) {
                $dataPrestasi['id_user'] = $userId;
                Prestasi::create($dataPrestasi);
            }

            // --- [PERBAIKAN 2 DARI 2: PERBARUI STATUS REKOGNISI PADA PRESTASI INTERNAL ASLI] ---
            // Jika request ini berasal dari pengajuan rekognisi prestasi internal...
            if ($request->filled('id_prestasi_internal_sumber')) {
                // Cari prestasi internal asli yang menjadi sumber pengajuan
                $prestasiSumber = Prestasi::find($request->id_prestasi_internal_sumber);
                if ($prestasiSumber) {
                    // Update statusnya, sehingga tombol 'Ajukan' tidak akan muncul lagi di riwayat
                    $prestasiSumber->update(['status_rekognisi' => 'menunggu']);
                }
            }
            // --- AKHIR PERBAIKAN ---

            DB::commit();

            $message = $validatedData['is_tim'] ? 'Pengajuan rekognisi berhasil dikirim untuk seluruh tim!' : 'Pengajuan rekognisi berhasil dikirim!';
            return response()->json(['success' => true, 'message' => $message], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($sertifikatPath) && Storage::disk('public')->exists($sertifikatPath)) {
                Storage::disk('public')->delete($sertifikatPath);
            }
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan pada server.', 'error' => $e->getMessage()], 500);
        }
    }

    public function berikan(Request $request)
    {
        // 1. Validasi Input Awal
        $validator = Validator::make($request->all(), [
            'id_user'             => 'required|exists:users,id_user', // ID Ketua Tim/Pendaftar Individu
            'id_lomba'            => 'required|exists:lomba,id_lomba',
            'peringkat'           => 'required|string|max:255',
            'tipe_prestasi'       => 'required|in:pemenang,peserta',
            'tier_lomba'          => 'required|in:1,2,3',
            'tanggal_diraih'      => 'required|date',
            'sertifikat'          => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        // 2. Temukan data registrasi asli untuk mendapatkan ID Tim
        $registrasiAwal = RegistrasiLomba::where('id_lomba', $request->id_lomba)
            ->where('id_mahasiswa', $request->id_user)
            ->first();
        if (!$registrasiAwal) {
            return response()->json(['success' => false, 'message' => 'Data pendaftaran asli untuk peserta ini tidak ditemukan.'], 404);
        }

        // 3. Tentukan daftar user yang akan menerima prestasi
        $userIdsToReceive = [];
        if ($registrasiAwal->id_tim) {
            // --- JIKA INI LOMBA KELOMPOK ---
            // Ambil semua ID mahasiswa dari anggota tim
            $userIdsToReceive = DB::table('member_tim')->where('id_tim', $registrasiAwal->id_tim)->pluck('id_mahasiswa')->all();
        }

        // Jika bukan kelompok atau tim tidak ditemukan, daftarnya hanya berisi ketua tim.
        if (empty($userIdsToReceive)) {
            $userIdsToReceive[] = $request->id_user;
        }

        // 4. Validasi kedua: Pastikan tidak ada anggota tim yang sudah punya prestasi di lomba ini
        $existingPrestasiCount = Prestasi::where('id_lomba', $request->id_lomba)
            ->whereIn('id_user', $userIdsToReceive)
            ->count();
        if ($existingPrestasiCount > 0) {
            return response()->json(['success' => false, 'message' => 'Satu atau lebih anggota tim sudah pernah diberikan prestasi untuk lomba ini.'], 422);
        }


        // 5. Mulai Transaksi Database
        DB::beginTransaction();
        try {
            // 6. Simpan file sertifikat sekali saja
            $sertifikatPath = null;
            if ($request->hasFile('sertifikat')) {
                $file = $request->file('sertifikat');
                // Buat nama file yang lebih umum untuk tim
                $fileName = 'sertifikat_lomba_' . $request->id_lomba . '_tim_' . ($registrasiAwal->id_tim ?? $request->id_user) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $sertifikatPath = $file->storeAs('sertifikat', $fileName, 'public');
            }

            // 7. Siapkan data dasar prestasi
            $prestasiData = [
                'id_lomba'            => $request->id_lomba,
                'peringkat'           => $request->peringkat,
                'tipe_prestasi'       => $request->tipe_prestasi,
                'tanggal_diraih'      => $request->tanggal_diraih,
                'sertifikat_path'     => $sertifikatPath,
                'status_verifikasi'   => 'disetujui',
                'lomba_dari'          => 'internal',
                'id_verifikator'      => Auth::id(), // ID Verifikator (admin yang memberikan prestasi)
            ];

            // 8. Loop dan buat record prestasi untuk SETIAP ANGGOTA
            foreach ($userIdsToReceive as $userId) {
                $dataToInsert = $prestasiData;
                $dataToInsert['id_user'] = $userId;
                Prestasi::create($dataToInsert);
            }

            // 9. Cek apakah semua pendaftar sudah diberi prestasi untuk mengubah status lomba
            $lomba = Lomba::find($request->id_lomba);
            if ($lomba) {
                $totalPendaftarDiterima = $lomba->registrasi()->where('status_verifikasi', 'diterima')->count();
                $totalPenerimaPrestasi = Prestasi::where('id_lomba', $request->id_lomba)->count();

                // Logika ini mungkin perlu disesuaikan. Jika 1 tim (3 orang) menang dari 10 pendaftar,
                // apakah lombanya selesai? Jika ya, logika ini benar. Jika tidak, perlu penyesuaian.
                if ($totalPendaftarDiterima > 0 && $totalPendaftarDiterima === $totalPenerimaPrestasi) {
                    $lomba->status = 'selesai';
                    $lomba->save();
                }
            }

            // 10. Commit transaksi
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Prestasi berhasil diberikan kepada ' . count($userIdsToReceive) . ' peserta.'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($sertifikatPath) && Storage::disk('public')->exists($sertifikatPath)) {
                Storage::disk('public')->delete($sertifikatPath);
            }

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses permintaan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $validator = Validator::make($request->all(), [
            'peringkat'     => 'sometimes|required|string|max:255',
            'tier_lomba'    => 'sometimes|required|in:1,2,3',
            'tipe_prestasi' => 'sometimes|required|in:pemenang,peserta',
            'tanggal_diraih' => 'sometimes|required|date',
            'sertifikat'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validasi gagal', 'errors' => $validator->errors()], 422);
        }

        $updateData = $request->only(['peringkat', 'tipe_prestasi', 'tanggal_diraih']);

        if ($request->hasFile('sertifikat')) {
            if ($prestasi->file_sertifikat && Storage::disk('public')->exists($prestasi->file_sertifikat)) {
                Storage::disk('public')->delete($prestasi->file_sertifikat);
            }
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
