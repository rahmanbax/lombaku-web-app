<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

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
        
        $partisipasiItems = [];
        $prestasiItems = [];
        
        if ($filter === 'all' || $filter === 'lomba') {
            $claimedLombaIds = $user->prestasi()->whereNotNull('id_lomba')->pluck('id_lomba')->toArray();
            
            $partisipasiItems = $user->registrasiLomba()
                                ->with(['lomba', 'tim.members', 'dosenPembimbing'])
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
                        if ($lomba?->status === 'selesai') { 
                            $statusText = 'Lomba Selesai'; 
                            $statusClass = 'status-prestasi'; 
                        }
                        break;
                    case 'ditolak': $statusText = 'Pendaftaran Ditolak'; break;
                }

                $mainDate = $lomba?->tanggal_mulai_lomba ?? $item->created_at?->toDateString();

                return [
                    'id' => 'reg-' . $item->id_registrasi_lomba,
                    'type' => 'Partisipasi Lomba',
                    'nama' => $lomba?->nama_lomba ?? 'Lomba Telah Dihapus',
                    'tanggal' => $mainDate,
                    'status_text' => $statusText,
                    'status_class' => $statusClass, 
                    'tingkat' => ucfirst($lomba?->tingkat ?? 'Tidak Diketahui'),
                    'sertifikat_path' => null, 
                    'action_text' => $actionText,
                    'action_url' => $actionUrl,
                    'lomba_id' => $lomba?->id_lomba,
                    'lomba_status' => $lomba?->status,
                    'has_claimed_prestasi' => $lomba ? in_array($lomba->id_lomba, $claimedLombaIds) : true,
                    'rekognisi_data' => null,
                    'status_rekognisi' => null, 
                    'status_rekognisi_class' => null,
                    'team_info' => null,
                ];
            })->all(); 
        }

        if ($filter === 'all' || $filter === 'prestasi') {
            $prestasiItems = $user->prestasi()
                                ->with(['lomba.pembuat', 'tim.members'])
                                ->get()
                                ->map(function ($item) {
                $lomba = $item->lomba;
                $rekognisiData = null;
                $statusRekognisi = null;
                $statusRekognisiClass = null;
                $statusText = '';
                $statusClass = '';
                $type = '';
                
                $teamInfo = null;
                if ($item->tim) {
                    $memberNames = $item->tim->members->pluck('nama')->toArray();
                    $teamInfo = [
                        'nama_tim' => $item->tim->nama_tim,
                        'members' => implode(', ', $memberNames),
                    ];
                }

                if ($item->lomba_dari === 'eksternal') {
                    $type = 'Pengajuan Prestasi';
                    if ($item->status_verifikasi === 'disetujui') {
                        $statusText = $item->peringkat;
                        $statusClass = 'status-prestasi';
                    } else {
                        $statusText = 'Diajukan';
                        $statusClass = 'status-netral';
                    }
                    switch ($item->status_verifikasi) {
                        case 'menunggu': $statusRekognisi = 'Menunggu Verifikasi'; $statusRekognisiClass = 'status-menunggu'; break;
                        case 'disetujui': $statusRekognisi = 'Verifikasi Disetujui'; $statusRekognisiClass = 'status-diterima'; break;
                        case 'ditolak': $statusRekognisi = 'Verifikasi Ditolak'; $statusRekognisiClass = 'status-ditolak'; break;
                    }
                } else {
                    $type = 'Prestasi Internal';
                    $statusText = $item->peringkat;
                    $statusClass = 'status-prestasi';
                    
                    // Kondisi ini hanya terpenuhi jika prestasi internal dan BELUM pernah diajukan rekognisi
                    if ($item->sertifikat_path && is_null($item->status_rekognisi)) {
                        $rekognisiData = [
                            'nama_lomba_eksternal' => $lomba?->nama_lomba ?? 'Prestasi Internal',
                            'penyelenggara_eksternal' => $lomba?->penyelenggara ?? $lomba?->pembuat?->nama ?? 'Penyelenggara Internal',
                            'tingkat' => $lomba?->tingkat ?? 'internal',
                            'peringkat' => $item->peringkat,
                            'tanggal_diraih' => Carbon::parse($item->tanggal_diraih)->toDateString(),
                            'existing_sertifikat_url' => Storage::url($item->sertifikat_path), 
                            'id_prestasi_internal_sumber' => $item->id_prestasi,
                            'is_tim' => $item->id_tim ? 1 : 0,
                            'member_ids' => $item->tim ? $item->tim->members->pluck('id_user')->toArray() : [],
                            'nama_tim' => $item->tim ? $item->tim->nama_tim : null,
                        ];
                    }

                    // Kondisi ini akan menampilkan status jika SUDAH pernah diajukan rekognisi
                    if (!is_null($item->status_rekognisi)) {
                        switch ($item->status_rekognisi) {
                            case 'menunggu': $statusRekognisi = 'Menunggu Rekognisi'; $statusRekognisiClass = 'status-menunggu'; break;
                            case 'disetujui': $statusRekognisi = 'Rekognisi Disetujui'; $statusRekognisiClass = 'status-diterima'; break;
                            case 'ditolak': $statusRekognisi = 'Rekognisi Ditolak'; $statusRekognisiClass = 'status-ditolak'; break;
                        }
                    }
                }

                $mainDate = $item->tanggal_diraih ? Carbon::parse($item->tanggal_diraih)->toDateString() : ($item->created_at ? $item->created_at->toDateString() : null);

                return [
                    'id' => 'pres-' . $item->id_prestasi,
                    'type' => $type,
                    'nama' => $lomba?->nama_lomba ?? $item->nama_lomba_eksternal,
                    'tanggal' => $mainDate,
                    'status_text' => $statusText,
                    'status_class' => $statusClass,
                    'tingkat' => ucfirst($lomba?->tingkat ?? $item->tingkat ?? 'Tidak Diketahui'),
                    'sertifikat_path' => $item->sertifikat_path,
                    'action_text' => null, 'action_url' => null,
                    'rekognisi_data' => $rekognisiData,
                    'status_rekognisi' => $statusRekognisi,
                    'status_rekognisi_class' => $statusRekognisiClass,
                    'team_info' => $teamInfo,
                ];
            })->all();
        }
        
        $kegiatanGabunganArray = array_merge($partisipasiItems, $prestasiItems);
        $kegiatanGabungan = collect($kegiatanGabunganArray);
        
        $kegiatanTersortir = $kegiatanGabungan->filter(fn($item) => !is_null($item['tanggal']))->sortByDesc('tanggal');
        
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $kegiatanTersortir->slice(($currentPage - 1) * $perPage, $perPage)->values()->all();
        
        $paginatedItems = new LengthAwarePaginator(
            $currentItems, 
            $kegiatanTersortir->count(),
            $perPage, 
            $currentPage, 
            ['path' => request()->url(), 'query' => $request->query()]
        );
        
        return response()->json($paginatedItems);
    }
}