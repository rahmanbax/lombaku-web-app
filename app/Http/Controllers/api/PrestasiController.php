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
            'id_prestasi_internal_sumber' => 'nullable|exists:prestasi,id_prestasi', // Validasi sumber prestasi internal
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

        DB::beginTransaction();
        try {
            // Langkah 1: Buat record prestasi 'eksternal' baru untuk pengajuan rekognisi
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
                'id_prestasi_internal_sumber' => $validatedData['id_prestasi_internal_sumber'] ?? null,
            ]);

            // Langkah 2: Jika ini berasal dari pengajuan rekognisi, update status prestasi internal asli
            if (!empty($validatedData['id_prestasi_internal_sumber'])) {
                $prestasiInternalAsli = Prestasi::find($validatedData['id_prestasi_internal_sumber']);
                if ($prestasiInternalAsli && $prestasiInternalAsli->id_user == Auth::id()) {
                    $prestasiInternalAsli->status_rekognisi = 'menunggu';
                    $prestasiInternalAsli->save();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan rekognisi prestasi berhasil dikirim!'
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->hasFile('sertifikat') && isset($sertifikatPath) && Storage::disk('public')->exists($sertifikatPath)) {
                Storage::disk('public')->delete($sertifikatPath);
            }
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error' => $e->getMessage()
            ], 500);
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