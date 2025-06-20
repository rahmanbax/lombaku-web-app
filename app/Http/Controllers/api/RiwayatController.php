<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\User;

class RiwayatController extends Controller
{
    /**
     * Mengambil riwayat gabungan (partisipasi & prestasi) untuk user yang login.
     */
    public function getRiwayat(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        
        $perPage = 10;

        // =========================================================================
        // PERBAIKAN 1: Eager load relasi tim, anggota tim, dan dosen pembimbing
        // =========================================================================
        $partisipasi = $user->registrasiLomba()
                            ->with(['lomba.tags', 'tim.members', 'dosenPembimbing']) // <-- Perubahan di sini
                            ->get()
                            ->map(function ($item) {
            
            $statusText = 'Status Tidak Diketahui';
            $statusClass = 'status-ditolak';
            switch ($item->status_verifikasi) {
                case 'menunggu':
                    $statusText = 'Menunggu Verifikasi';
                    $statusClass = 'status-menunggu';
                    break;
                case 'diterima':
                    $statusText = 'Pendaftaran Diterima';
                    $statusClass = 'status-diterima';
                    break;
                case 'ditolak':
                    $statusText = 'Pendaftaran Ditolak';
                    $statusClass = 'status-ditolak';
                    break;
            }

            return [
                'id'                => 'reg-' . $item->id_registrasi_lomba,
                'type'              => 'Partisipasi Lomba',
                'nama'              => $item->lomba?->nama_lomba ?? 'Lomba Telah Dihapus',
                'tanggal'           => $item->lomba?->tanggal_mulai_lomba ?? $item->created_at->toDateString(),
                'status_raw'        => $item->status_verifikasi,
                'status_text'       => $statusText,
                'status_class'      => $statusClass,
                'kategori'          => $item->lomba?->tags?->first()?->nama_tag ?? 'Umum',
                'sertifikat_path'   => null,
                'lomba_id'          => $item->lomba?->id_lomba,
                
                // =========================================================================
                // PERBAIKAN 2: Tambahkan data baru ke respons API
                // =========================================================================
                'nama_tim'          => $item->tim?->nama_tim,
                'members'           => $item->tim?->members->pluck('nama')->all(), // Ambil nama semua anggota
                'nama_dosen'        => $item->dosenPembimbing?->nama,
            ];
        });

        // Bagian untuk mengambil data prestasi tidak perlu diubah
        $prestasi = $user->prestasi()->with('lomba.tags')->get()->map(function ($item) {
            $statusText = 'Verifikasi: ' . ucfirst($item->status_verifikasi);
            $statusClass = 'status-ditolak';
            switch ($item->status_verifikasi) {
                case 'menunggu':
                    $statusClass = 'status-menunggu';
                    break;
                case 'disetujui':
                    $statusText = $item->peringkat;
                    $statusClass = 'status-prestasi';
                    break;
                case 'ditolak':
                    $statusClass = 'status-ditolak';
                    break;
            }
            return [
                'id'                => 'pres-' . $item->id_prestasi,
                'type'              => $item->lomba_dari === 'eksternal' ? 'Pengajuan Prestasi' : 'Prestasi Internal',
                'nama'              => $item->lomba?->nama_lomba ?? $item->nama_lomba_eksternal,
                'tanggal'           => $item->tanggal_diraih,
                'status_raw'        => $item->status_verifikasi,
                'status_text'       => $statusText,
                'status_class'      => $statusClass,
                'kategori'          => $item->lomba?->tags?->first()?->nama_tag ?? ucfirst($item->tingkat ?? ''),
                'sertifikat_path'   => $item->sertifikat_path,
                'lomba_id'          => $item->lomba?->id_lomba,
                // Pastikan struktur sama, tambahkan null untuk konsistensi
                'nama_tim'          => null,
                'members'           => [],
                'nama_dosen'        => null,
            ];
        });

        // Sisa kode (gabung, urutkan, paginasi) tetap sama
        $kegiatanGabungan = $partisipasi->merge($prestasi);
        $kegiatanTersortir = $kegiatanGabungan->sortByDesc('tanggal');
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $kegiatanTersortir->slice(($currentPage - 1) * $perPage, $perPage)->values()->all();
        $paginatedItems = new LengthAwarePaginator($currentItems, count($kegiatanTersortir), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);
        return response()->json($paginatedItems, 200);
    }
}