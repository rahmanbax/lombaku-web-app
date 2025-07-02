<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // <-- TAMBAHKAN INI

class BookmarkController extends Controller
{
    /**
     * Menampilkan semua lomba yang di-bookmark oleh user yang sedang login.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();

        $bookmarkedLombas = $user->bookmarkedLombas()
                                ->with(['tags', 'pembuat'])
                                ->latest('lomba_bookmarks.created_at')
                                ->get();

        // ======================================================
        // === INI BAGIAN YANG DIPERBAIKI =======================
        // ======================================================
        // Kita akan melakukan transformasi pada koleksi untuk menambahkan URL gambar
        $bookmarkedLombas->transform(function ($lomba) {
            // Logika ini sama persis dengan yang ada di LombaController
            $lomba->foto_lomba_url = $lomba->foto_lomba 
                ? Storage::url($lomba->foto_lomba)
                : null; // atau berikan URL default jika perlu
            return $lomba;
        });
        // ======================================================
        // === AKHIR DARI PERBAIKAN =============================
        // ======================================================

        return response()->json([
            'success' => true,
            'message' => 'Daftar bookmark berhasil diambil.',
            'data' => $bookmarkedLombas
        ], 200);
    }

    // ... (method store() dan destroy() tidak perlu diubah) ...
    
    /**
     * Menyimpan (menambah) bookmark baru untuk user yang sedang login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_lomba' => 'required|integer|exists:lomba,id_lomba'
        ]);

        Auth::user()->bookmarkedLombas()->syncWithoutDetaching($request->id_lomba);

        return response()->json([
            'success' => true, 
            'message' => 'Lomba berhasil disimpan ke bookmark.'
        ], 200);
    }

    /**
     * Menghapus sebuah bookmark berdasarkan id_lomba.
     *
     * @param  int  $id_lomba
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id_lomba)
    {
        Auth::user()->bookmarkedLombas()->detach($id_lomba);

        return response()->json([
            'success' => true, 
            'message' => 'Bookmark berhasil dihapus.'
        ], 200);
    }
}