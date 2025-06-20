<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lomba; // Opsional, bisa digunakan untuk Route Model Binding di masa depan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * Menampilkan semua lomba yang di-bookmark oleh user yang sedang login.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Mengambil user yang sedang terotentikasi oleh Sanctum
        $user = Auth::user();

        // Mengambil semua lomba yang terhubung dengan user ini melalui tabel pivot
        // dan mengurutkannya dari yang paling baru disimpan.
        // Eager loading 'tags' dan 'pembuat' untuk menghindari N+1 query problem.
        $bookmarkedLombas = $user->bookmarkedLombas()
                                ->with(['tags', 'pembuat'])
                                ->latest('lomba_bookmarks.created_at') // Urutkan berdasarkan kapan di-bookmark
                                ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar bookmark berhasil diambil.',
            'data' => $bookmarkedLombas
        ], 200);
    }

    /**
     * Menyimpan (menambah) bookmark baru untuk user yang sedang login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi input: pastikan 'id_lomba' dikirim dan benar-benar ada di tabel 'lomba'.
        $request->validate([
            'id_lomba' => 'required|integer|exists:lomba,id_lomba'
        ]);

        // Menggunakan syncWithoutDetaching() adalah cara paling aman dan efisien:
        // - Jika bookmark belum ada, ia akan membuatnya.
        // - Jika bookmark sudah ada, ia tidak akan melakukan apa-apa (mencegah duplikasi).
        Auth::user()->bookmarkedLombas()->syncWithoutDetaching($request->id_lomba);

        return response()->json([
            'success' => true, 
            'message' => 'Lomba berhasil disimpan ke bookmark.'
        ], 200); // 200 OK atau 201 Created bisa digunakan, 200 lebih umum untuk aksi seperti ini.
    }

    /**
     * Menghapus sebuah bookmark berdasarkan id_lomba.
     *
     * @param  int  $id_lomba
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id_lomba)
    {
        // detach() adalah metode yang tepat untuk menghapus relasi many-to-many.
        // Ia akan menghapus record dari tabel pivot 'lomba_bookmarks'.
        Auth::user()->bookmarkedLombas()->detach($id_lomba);

        return response()->json([
            'success' => true, 
            'message' => 'Bookmark berhasil dihapus.'
        ], 200);
    }
}