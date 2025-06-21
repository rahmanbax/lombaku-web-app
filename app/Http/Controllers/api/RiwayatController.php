<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\User;
// import Log Facades
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;


class RiwayatController extends Controller
{
    public function getRiwayat()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        
        $perPage = 10;

        // --- BAGIAN PARTISIPASI LOMBA ---
        $partisipasi = $user->registrasiLomba()
                            ->with(['lomba.tags', 'tim.members', 'dosenPembimbing'])
                            ->get()
                            ->map(function ($item) {
            
            $lomba = $item->lomba;
            $statusText = 'Status Tidak Diketahui';
            $statusClass = 'status-ditolak';
            $actionText = 'Detail Lomba';
            $actionUrl = $lomba ? url('/lomba/' . $lomba->id_lomba) : null;

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
                    break;
            }

            if ($lomba?->status === 'selesai') {
                $statusText = 'Lomba Selesai';
                $statusClass = 'status-prestasi';
                $actionText = 'Lihat Hasil Penilaian';
                $actionUrl = url('/kegiatan/hasil/' . $item->id_registrasi_lomba);
            }

            $members = ($item->tim && $item->tim->members) ? $item->tim->members->pluck('nama')->all() : [];
            $mainDate = $lomba?->tanggal_mulai_lomba ?? ($item->created_at ? $item->created_at->toDateString() : null);

            return [
                'id'                => 'reg-' . $item->id_registrasi_lomba,
                'type'              => 'Partisipasi Lomba',
                'nama'              => $lomba?->nama_lomba ?? 'Lomba Telah Dihapus',
                'tanggal'           => $mainDate,
                'status_raw'        => $item->status_verifikasi,
                'status_text'       => $statusText,
                'status_class'      => $statusClass,
                'kategori'          => $lomba?->tags->first()?->nama_tag ?? 'Umum',
                'sertifikat_path'   => null,
                'action_text'       => $actionText,
                'action_url'        => $actionUrl,
                'nama_tim'          => $item->tim?->nama_tim,
                'members'           => $members,
                'nama_dosen'        => $item->dosenPembimbing?->nama,
            ];
        });

        // --- BAGIAN PRESTASI ---
        $prestasi = $user->prestasi()->with('lomba.tags')->get()->map(function ($item) {
            $lomba = $item->lomba;
            $statusText = 'Verifikasi: ' . ucfirst($item->status_verifikasi);
            $statusClass = 'status-ditolak';
            $actionText = 'Lihat Detail Lomba';
            $actionUrl = $lomba ? url('/lomba/' . $lomba->id_lomba) : null;

            switch ($item->status_verifikasi) {
                case 'menunggu': $statusClass = 'status-menunggu'; break;
                case 'disetujui':
                    $statusText = $item->peringkat;
                    $statusClass = 'status-prestasi';
                    break;
                case 'ditolak': $statusClass = 'status-ditolak'; break;
            }

            $mainDate = $item->tanggal_diraih ? Carbon::parse($item->tanggal_diraih)->toDateString() : ($item->created_at ? $item->created_at->toDateString() : null);

            return [
                'id'                => 'pres-' . $item->id_prestasi,
                'type'              => $item->lomba_dari === 'eksternal' ? 'Pengajuan Prestasi' : 'Prestasi Internal',
                'nama'              => $lomba?->nama_lomba ?? $item->nama_lomba_eksternal,
                'tanggal'           => $mainDate,
                'status_raw'        => $item->status_verifikasi,
                'status_text'       => $statusText,
                'status_class'      => $statusClass,
                'kategori'          => $lomba?->tags?->first()?->nama_tag ?? ucfirst($item->tingkat ?? ''),
                'sertifikat_path'   => $item->sertifikat_path,
                'action_text'       => $actionUrl ? $actionText : null,
                'action_url'        => $actionUrl,
                'nama_tim'          => null,
                'members'           => [],
                'nama_dosen'        => null,
            ];
        });

        // Gabungkan, filter yang tidak punya tanggal, urutkan, dan paginasi
        $kegiatanGabungan = $partisipasi->merge($prestasi);
        $kegiatanTersortir = $kegiatanGabungan->filter(fn($item) => !is_null($item['tanggal']))->sortByDesc('tanggal');
        
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $kegiatanTersortir->slice(($currentPage - 1) * $perPage, $perPage)->values()->all();
        $paginatedItems = new LengthAwarePaginator($currentItems, count($kegiatanTersortir), $perPage, $currentPage, [
            'path' => request()->url(),
        ]);
        Log::info('Riwayat kegiatan mahasiswa', [
            'user_id' => $user->id,
            'items_count' => count($paginatedItems),
            'current_page' => $currentPage,
        ]);
        return response()->json($paginatedItems);
    }
}