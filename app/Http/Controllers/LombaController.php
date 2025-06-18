<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class LombaController extends Controller
{
    /**
     * Menampilkan semua data lomba.
     * GET /api/lomba
     */
    public function index()
    {
        // Eager loading untuk relasi 'tags' dan 'pembuat' untuk efisiensi query
        $lombas = Lomba::with(['tags', 'pembuat'])->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Lomba Berhasil Diambil',
            'data' => $lombas
        ], 200);
    }

    /**
     * Menyimpan lomba baru ke database.
     * POST /api/lomba
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lomba'    => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'tingkat'       => 'required|in:nasional,internasional,internal',
            'tanggal_akhir_registrasi' => 'required|date',
            'tanggal_mulai_lomba' => 'required|date|after_or_equal:tanggal_akhir_registrasi',
            'tanggal_selesai_lomba' => 'required|date|after_or_equal:tanggal_mulai_lomba',
            'penyelenggara' => 'nullable|string|max:255',
            'foto_lomba'    => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags'          => 'required|array',
            'tags.*'        => 'exists:tags,id_tag', // Memastikan setiap tag ID ada di tabel tags
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Upload gambar
        $image = $request->file('foto_lomba');
        $image_path = $image->store('assets/lomba', 'public');

        // Dapatkan ID user yang sedang login (sebagai pembuat)
        // Pastikan route ini dilindungi oleh middleware 'auth:api' atau 'auth:sanctum'
        // $id_pembuat = auth()->id(); 
        $id_pembuat = 1; 
        
        // Buat lomba
        $lomba = Lomba::create([
            'nama_lomba'    => $request->nama_lomba,
            'deskripsi'     => $request->deskripsi,
            'tingkat'       => $request->tingkat,
            'status'        => 'belum disetujui', // Status default saat dibuat
            'tanggal_akhir_registrasi' => $request->tanggal_akhir_registrasi,
            'tanggal_mulai_lomba' => $request->tanggal_mulai_lomba,
            'tanggal_selesai_lomba' => $request->tanggal_selesai_lomba,
            'penyelenggara' => $request->penyelenggara,
            'foto_lomba'    => $image_path,
            'id_pembuat'    => $id_pembuat,
        ]);
        
        // Lampirkan tags ke lomba yang baru dibuat
        $lomba->tags()->attach($request->tags);

        return response()->json([
            'success' => true,
            'message' => 'Lomba Berhasil Dibuat',
            'data' => Lomba::with('tags')->find($lomba->id_lomba) // Kirim kembali data lomba dengan tags
        ], 201);
    }

    /**
     * Menampilkan satu data lomba spesifik.
     * GET /api/lomba/{id}
     */
    public function show($id)
    {
        $lomba = Lomba::with(['tags', 'pembuat'])->find($id);

        if (!$lomba) {
            return response()->json([
                'success' => false,
                'message' => 'Lomba Tidak Ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Lomba Ditemukan',
            'data' => $lomba
        ], 200);
    }

    /**
     * Memperbarui data lomba.
     * PUT/PATCH /api/lomba/{id}
     */
    public function update(Request $request, $id)
    {
        $lomba = Lomba::find($id);

        if (!$lomba) {
            return response()->json(['success' => false, 'message' => 'Lomba tidak ditemukan'], 404);
        }
        
        // Opsi: Tambahkan otorisasi untuk memastikan hanya pembuat yang bisa mengedit
        // if ($lomba->id_pembuat !== auth()->id()) {
        //     return response()->json(['success' => false, 'message' => 'Tidak diizinkan'], 403);
        // }

        $validator = Validator::make($request->all(), [
            'nama_lomba'    => 'sometimes|required|string|max:255',
            'deskripsi'     => 'sometimes|required|string',
            'tingkat'       => 'sometimes|required|in:nasional,internasional,internal',
            'status'        => 'sometimes|required|in:belum disetujui,disetujui,berlangsung,selesai',
            'tanggal_akhir_registrasi' => 'sometimes|required|date',
            'tanggal_mulai_lomba' => 'sometimes|required|date',
            'tanggal_selesai_lomba' => 'sometimes|required|date',
            'penyelenggara' => 'nullable|string|max:255',
            'foto_lomba'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags'          => 'sometimes|required|array',
            'tags.*'        => 'exists:tags,id_tag',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validasi Gagal', 'errors' => $validator->errors()], 422);
        }
        
        // Mengambil data yang tervalidasi
        $validatedData = $validator->validated();

        if ($request->hasFile('foto_lomba')) {
            // Hapus gambar lama
            Storage::disk('public')->delete($lomba->foto_lomba);
            
            // Upload gambar baru
            $image = $request->file('foto_lomba');
            $validatedData['foto_lomba'] = $image->store('assets/lomba', 'public');
        }

        // Update lomba dengan data yang divalidasi
        $lomba->update($validatedData);

        // Sinkronisasi tags, sync() akan menghapus tag lama dan menambah tag baru
        if ($request->has('tags')) {
            $lomba->tags()->sync($request->tags);
        }

        return response()->json([
            'success' => true,
            'message' => 'Lomba Berhasil Diperbarui',
            'data' => Lomba::with('tags')->find($lomba->id_lomba)
        ], 200);
    }

    /**
     * Menghapus data lomba.
     * DELETE /api/lomba/{id}
     */
    public function destroy($id)
    {
        $lomba = Lomba::find($id);

        if (!$lomba) {
            return response()->json(['success' => false, 'message' => 'Lomba tidak ditemukan'], 404);
        }

        // Opsi: Otorisasi
        // if ($lomba->id_pembuat !== auth()->id()) {
        //     return response()->json(['success' => false, 'message' => 'Tidak diizinkan'], 403);
        // }

        // Hapus file gambar dari storage
        Storage::disk('public')->delete($lomba->foto_lomba);
        
        // Hapus relasi di tabel pivot terlebih dahulu
        $lomba->tags()->detach();

        // Hapus lomba
        $lomba->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lomba Berhasil Dihapus'
        ], 200);
    }
}