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
            'peringkat' => 'required|string|max:100',
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
        $validator = Validator::make($request->all(), [
            'id_user'             => 'required|exists:users,id_user',
            'id_lomba'            => [
                'required',
                'exists:lomba,id_lomba',
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

        DB::beginTransaction();

        try {
            $sertifikatPath = null;
            if ($request->hasFile('sertifikat')) {
                $file = $request->file('sertifikat');
                $fileName = 'sertifikat_lomba_' . $request->id_lomba . '_user_' . $request->id_user . '_' . time() . '.' . $file->getClientOriginalExtension();
                $sertifikatPath = $file->storeAs('sertifikat', $fileName, 'public');
            }

            $prestasi = Prestasi::create([
                'id_user'             => $request->id_user,
                'id_lomba'            => $request->id_lomba,
                'peringkat'           => $request->peringkat,
                'tipe_prestasi'       => $request->tipe_prestasi,
                'tanggal_diraih'      => $request->tanggal_diraih,
                'sertifikat_path'     => $sertifikatPath,
                'status_verifikasi'   => 'disetujui',
                'lomba_dari'          => 'internal'
            ]);

            $lombaId = $request->id_lomba;
            $lomba = Lomba::find($lombaId);

            if ($lomba) {
                $totalPendaftarDiterima = $lomba->registrasi()
                    ->where('status_verifikasi', 'diterima')
                    ->count();
                $totalPenerimaPrestasi = Prestasi::where('id_lomba', $lombaId)->count();
                if ($totalPendaftarDiterima > 0 && $totalPendaftarDiterima === $totalPenerimaPrestasi) {
                    $lomba->status = 'selesai';
                    $lomba->save();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Prestasi berhasil diberikan.',
                'data'    => $prestasi
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