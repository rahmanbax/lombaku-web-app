<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class RiwayatController extends Controller
{
    /**
     * Mengambil riwayat gabungan (partisipasi & prestasi) untuk user yang login,
     * dengan dukungan filter dan paginasi.
     * GET /api/riwayat
     */
    public function getRiwayat(Request $request)
    {
        $user = Auth::user();
        $perPage = 10; // Jumlah item per halaman

        // --- PERBAIKAN: Menggunakan null-safe operator (?->) untuk keamanan ---
        // 1. Ambil data partisipasi lomba
        $partisipasi = $user->registrasiLomba()->with('lomba.tags')->get()->map(function ($item) {
            return [
                'id'                => 'reg-' . $item->id_registrasi_lomba,
                'type'              => 'Partisipasi Lomba',
                'nama'              => $item->lomba?->nama_lomba ?? 'Lomba Telah Dihapus',
                'tanggal'           => $item->lomba?->tanggal_mulai_lomba ?? $item->created_at,
                'status_raw'        => $item->status_verifikasi,
                'status_text'       => 'Verifikasi: ' . ucfirst($item->status_verifikasi),
                'kategori'          => $item->lomba?->tags?->first()?->nama_tag ?? 'Umum',
                'sertifikat_path'   => null,
                'lomba_id'          => $item->lomba?->id_lomba,
            ];
        });

        // --- PERBAIKAN: Mengambil semua status prestasi, bukan hanya yang disetujui ---
        // 2. Ambil SEMUA data prestasi
        $prestasi = $user->prestasi()->with('lomba.tags')->get()->map(function ($item) {
            // Logika status yang lebih baik
            $statusText = 'Verifikasi: ' . ucfirst($item->status_verifikasi);
            if ($item->status_verifikasi === 'disetujui') {
                $statusText = $item->peringkat;
            }

            return [
                'id'                => 'pres-' . $item->id_prestasi,
                'type'              => $item->lomba_dari === 'eksternal' ? 'Pengajuan Prestasi' : 'Prestasi Internal',
                'nama'              => $item->lomba?->nama_lomba ?? $item->nama_lomba_eksternal,
                'tanggal'           => $item->tanggal_diraih,
                'status_raw'        => $item->status_verifikasi,
                'status_text'       => $statusText,
                'kategori'          => $item->lomba?->tags?->first()?->nama_tag ?? ucfirst($item->tingkat),
                'sertifikat_path'   => $item->sertifikat_path,
                'lomba_id'          => $item->lomba?->id_lomba,
            ];
        });

        // 3. Gabungkan kedua koleksi
        $kegiatanGabungan = $partisipasi->merge($prestasi);

        // 4. Urutkan berdasarkan tanggal (terbaru dulu)
        $kegiatanTersortir = $kegiatanGabungan->sortByDesc('tanggal');

        // 5. Buat paginator secara manual dari koleksi yang sudah diurutkan
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $kegiatanTersortir->slice(($currentPage - 1) * $perPage, $perPage)->values()->all();
        $paginatedItems = new LengthAwarePaginator($currentItems, count($kegiatanTersortir), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return response()->json($paginatedItems, 200);
    }
}