<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use App\Models\RegistrasiLomba;
use App\Models\Prestasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class RiwayatController extends Controller
{
    public function getRiwayat(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        
        $filter = $request->query('filter', 'all');
        $perPage = 10;
        
        $partisipasi = collect();
        $prestasi = collect();
        
        // Bagian Partisipasi Lomba (tidak diubah)
        if ($filter === 'all' || $filter === 'lomba') {
            $claimedLombaIds = $user->prestasi()->whereNotNull('id_lomba')->pluck('id_lomba')->toArray();
            $partisipasi = $user->registrasiLomba()
                                ->with(['lomba.tags', 'tim.members', 'dosenPembimbing'])
                                ->get()
                                ->map(function ($item) use ($claimedLombaIds) {
                
                $lomba = $item->lomba;
                $statusText = 'Status Tidak Diketahui'; $statusClass = 'status-ditolak';
                $actionText = 'Detail Lomba'; $actionUrl = $lomba ? url('/lomba/' . $lomba->id_lomba) : null;
                switch ($item->status_verifikasi) {
                    case 'menunggu': $statusText = 'Menunggu Verifikasi'; $statusClass = 'status-menunggu'; break;
                    case 'diterima':
                        $statusText = 'Pendaftaran Diterima'; $statusClass = 'status-diterima';
                        if ($lomba?->status === 'berlangsung') $statusText = 'Lomba Berlangsung';
                        if ($lomba?->status === 'selesai') { $statusText = 'Lomba Selesai'; $statusClass = 'status-prestasi'; }
                        break;
                    case 'ditolak': $statusText = 'Pendaftaran Ditolak'; break;
                }

                $mainDate = $lomba?->tanggal_mulai_lomba ?? $item->created_at?->toDateString();

                return [
                    'id' => 'reg-' . $item->id_registrasi_lomba, 'type' => 'Partisipasi Lomba',
                    'nama' => $lomba?->nama_lomba ?? 'Lomba Telah Dihapus', 'tanggal' => $mainDate,
                    'status_text' => $statusText, 'status_class' => $statusClass, 'kategori' => $lomba?->tags->first()?->nama_tag ?? 'Umum',
                    'sertifikat_path' => null, 'action_text' => $actionText, 'action_url' => $actionUrl,
                    'lomba_id' => $lomba?->id_lomba, 'lomba_status' => $lomba?->status,
                    'has_claimed_prestasi' => $lomba ? in_array($lomba->id_lomba, $claimedLombaIds) : true,
                    'rekognisi_url' => null, // Tidak ada rekognisi dari partisipasi
                ];
            });
        }

        // === PERBAIKAN UTAMA DI SINI ===
        if ($filter === 'all' || $filter === 'prestasi') {
            $prestasi = $user->prestasi()->with('lomba.tags', 'lomba.pembuat')->get()->map(function ($item) {
                $lomba = $item->lomba;
                $statusText = 'Verifikasi: ' . ucfirst($item->status_verifikasi);
                $statusClass = 'status-ditolak';
                
                // [LOGIKA KUNCI] Buat URL untuk tombol "Ajukan Rekognisi"
                $rekognisiUrl = null;

                switch ($item->status_verifikasi) {
                    case 'menunggu': $statusClass = 'status-menunggu'; break;
                    case 'disetujui':
                        $statusText = $item->peringkat;
                        $statusClass = 'status-prestasi';
                        
                        // Buat URL HANYA jika ini prestasi internal yang sudah disetujui
                        if ($item->lomba_dari === 'internal' && $item->sertifikat_path) {
                            $queryParams = http_build_query([
                                'nama_lomba_eksternal' => $lomba?->nama_lomba ?? 'Prestasi Internal',
                                'penyelenggara_eksternal' => $lomba?->penyelenggara ?? $lomba?->pembuat?->nama ?? 'Penyelenggara Internal',
                                'tingkat' => $lomba?->tingkat ?? 'internal',
                                'peringkat' => $item->peringkat,
                                'tanggal_diraih' => Carbon::parse($item->tanggal_diraih)->toDateString(),
                                'existing_sertifikat_path' => $item->sertifikat_path,
                                'from_internal' => 'true' // Penanda untuk JavaScript
                            ]);
                            $rekognisiUrl = url('/ajukan-rekognisi?' . $queryParams);
                        }
                        break;
                    case 'ditolak': $statusClass = 'status-ditolak'; break;
                }

                $mainDate = $item->tanggal_diraih ? Carbon::parse($item->tanggal_diraih)->toDateString() : ($item->created_at ? $item->created_at->toDateString() : null);

                return [
                    'id' => 'pres-' . $item->id_prestasi,
                    'type' => $item->lomba_dari === 'eksternal' ? 'Pengajuan Prestasi' : 'Prestasi Internal',
                    'nama' => $lomba?->nama_lomba ?? $item->nama_lomba_eksternal,
                    'tanggal' => $mainDate,
                    'status_text' => $statusText, 'status_class' => $statusClass,
                    'kategori' => $lomba?->tags->first()?->nama_tag ?? ucfirst($item->tingkat ?? ''),
                    'sertifikat_path' => $item->sertifikat_path,
                    'action_text' => null, 'action_url' => null,
                    'rekognisi_url' => $rekognisiUrl, // [DATA BARU] Kirim URL ini ke frontend
                ];
            });
        }
        
        $kegiatanGabungan = $partisipasi->merge($prestasi);
        $kegiatanTersortir = $kegiatanGabungan->filter(fn($item) => !is_null($item['tanggal']))->sortByDesc('tanggal');
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $kegiatanTersortir->slice(($currentPage - 1) * $perPage, $perPage)->values()->all();
        $paginatedItems = new LengthAwarePaginator($currentItems, count($kegiatanTersortir), $perPage, $currentPage, ['path' => request()->url(), 'query' => $request->query()]);
        return response()->json($paginatedItems);
    }
}