<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Prestasi;
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
    $validatedData = $request->validate([
        'nama_lomba_eksternal'  => 'required|string|max:255',
        'penyelenggara_eksternal' => 'required|string|max:255',
        'tingkat'               => 'required|in:internal,nasional,internasional',
        'peringkat'             => 'required|string|max:100',
        'tanggal_diraih'        => 'required|date',
        'sertifikat'            => 'required_without:existing_sertifikat_path|nullable|file|mimes:pdf,jpg,png,jpeg|max:2048',
        'existing_sertifikat_path' => 'nullable|string',
    ]);

    $sertifikatPath = null;
    
    if ($request->hasFile('sertifikat')) {
        $sertifikatPath = $request->file('sertifikat')->store('sertifikat_prestasi', 'public');
    } 
    elseif ($request->filled('existing_sertifikat_path')) {
        $sertifikatPath = $request->existing_sertifikat_path;
    }

    if (is_null($sertifikatPath)) {
        return response()->json(['message' => 'Bukti sertifikat wajib ada.'], 422);
    }

    Prestasi::create([
        'id_user' => Auth::id(), 
        'lomba_dari' => 'eksternal',
        'nama_lomba_eksternal'  => $validatedData['nama_lomba_eksternal'],
        'penyelenggara_eksternal' => $validatedData['penyelenggara_eksternal'],
        'tingkat'               => $validatedData['tingkat'],
        'peringkat'             => $validatedData['peringkat'],
        'tanggal_diraih'        => $validatedData['tanggal_diraih'],
        'sertifikat_path'       => $sertifikatPath,
        'status_verifikasi'     => 'menunggu',
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Pengajuan rekognisi prestasi berhasil dikirim!'
    ], 201);
}

    public function berikan(Request $request)
    {
        // 1. Validasi input (tetap sama)
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

        // <-- [PERUBAHAN] Mulai Database Transaction -->
        DB::beginTransaction();

        try {
            // 2. Handle File Upload (tetap sama)
            $sertifikatPath = null;
            if ($request->hasFile('sertifikat')) {
                $file = $request->file('sertifikat');
                $fileName = 'sertifikat_lomba_' . $request->id_lomba . '_user_' . $request->id_user . '_' . time() . '.' . $file->getClientOriginalExtension();
                $sertifikatPath = $file->storeAs('sertifikat', $fileName, 'public');
            }

            // 3. Simpan ke Database (tetap sama)
            $prestasi = Prestasi::create([
                'id_user'             => $request->id_user,
                'id_lomba'            => $request->id_lomba,
                'peringkat'           => $request->peringkat,
                'tipe_prestasi'       => $request->tipe_prestasi,
                'tanggal_diraih'      => $request->tanggal_diraih,
                'sertifikat_path'     => $sertifikatPath,
                'status_verifikasi'   => 'disetujui',
                'lomba_dari'          => 'internal' // Pastikan ini diset
            ]);

            // <-- [PERUBAHAN] Logika untuk update status lomba -->
            $lombaId = $request->id_lomba;
            $lomba = Lomba::find($lombaId);

            if ($lomba) {
                // Hitung total pendaftar yang statusnya 'diterima'
                $totalPendaftarDiterima = $lomba->registrasi()
                    ->where('status_verifikasi', 'diterima')
                    ->count();

                // Hitung total peserta yang sudah diberi prestasi di lomba ini
                $totalPenerimaPrestasi = Prestasi::where('id_lomba', $lombaId)->count();

                // Cek apakah semua pendaftar yang diterima sudah diberi prestasi
                if ($totalPendaftarDiterima > 0 && $totalPendaftarDiterima === $totalPenerimaPrestasi) {
                    // Jika ya, ubah status lomba menjadi 'selesai'
                    $lomba->status = 'selesai';
                    $lomba->save();
                }
            }

            // <-- [PERUBAHAN] Commit transaction jika semua berhasil -->
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Prestasi berhasil diberikan.',
                'data'    => $prestasi
            ], 201);
        } catch (\Exception $e) {
            // <-- [PERUBAHAN] Rollback transaction jika terjadi kesalahan -->
            DB::rollBack();

            // Hapus file yang mungkin sudah ter-upload jika terjadi error
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
