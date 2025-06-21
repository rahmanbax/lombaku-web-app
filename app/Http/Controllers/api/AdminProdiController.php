<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use App\Models\Prestasi; // <-- TAMBAHKAN INI
use App\Models\RegistrasiLomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- TAMBAHKAN INI
use Illuminate\Support\Facades\Validator; // <-- TAMBAHKAN INI

class AdminProdiController extends Controller
{
    /**
     * Mengambil data dashboard untuk Admin Prodi dan mengembalikannya sebagai JSON.
     * Metode ini cocok untuk dipanggil melalui API.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $lombaAktif = Lomba::where('status', 'berlangsung')->count();
            $totalPeserta = RegistrasiLomba::count();
            $dokumenTertunda = RegistrasiLomba::where('status_verifikasi', 'menunggu')->count();

            $daftarLomba = Lomba::select('id_lomba', 'nama_lomba', 'tanggal_selesai_lomba', 'status')
                                ->latest('created_at')
                                ->paginate(10);

            $data = [
                'stats' => [
                    'lomba_aktif' => $lombaAktif,
                    'total_peserta' => $totalPeserta,
                    'dokumen_tertunda' => $dokumenTertunda,
                ],
                'daftar_lomba' => $daftarLomba
            ];

            return response()->json([
                'success' => true,
                'message' => 'Data dashboard berhasil diambil.',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getLombaList(Request $request)
    {
        $query = Lomba::query();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_lomba', 'like', '%' . $searchTerm . '%')
                  ->orWhere('penyelenggara', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $lombas = $query->latest()->paginate(10);

        return response()->json($lombas);
    }
    
    public function getPrestasiVerifications(Request $request)
    {
        $query = Prestasi::with(['mahasiswa.profilMahasiswa'])
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan status verifikasi
        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        // Paginate a result
        $prestasi = $query->paginate(10);

        return response()->json($prestasi);
    }
    public function approvePrestasi($id)
    {
        $prestasi = Prestasi::find($id);
        if (!$prestasi) {
            return response()->json(['success' => false, 'message' => 'Pengajuan tidak ditemukan.'], 404);
        }
        $prestasi->status_verifikasi = 'disetujui';
        $prestasi->id_verifikator = Auth::id();
        $prestasi->save();
        return response()->json(['success' => true, 'message' => 'Prestasi berhasil disetujui.']);
    }

    public function rejectPrestasi(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'catatan_verifikasi' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $prestasi = Prestasi::find($id);
        if (!$prestasi) {
            return response()->json(['success' => false, 'message' => 'Pengajuan tidak ditemukan.'], 404);
        }
        $prestasi->status_verifikasi = 'ditolak';
        $prestasi->id_verifikator = Auth::id();
        $prestasi->catatan_verifikasi = $request->catatan_verifikasi;
        $prestasi->save();
        return response()->json(['success' => true, 'message' => 'Prestasi berhasil ditolak.']);
    }
    
    public function getRegistrationHistory(Request $request)
    {
        $query = RegistrasiLomba::with(['mahasiswa.profilMahasiswa', 'lomba'])
                                ->orderBy('created_at', 'desc');

        // Filter berdasarkan status verifikasi
        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        // Filter pencarian
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                // Cari di nama lomba
                $q->whereHas('lomba', function ($lombaQuery) use ($searchTerm) {
                    $lombaQuery->where('nama_lomba', 'like', $searchTerm);
                })
                // Atau cari di nama mahasiswa
                ->orWhereHas('mahasiswa', function ($mahasiswaQuery) use ($searchTerm) {
                    $mahasiswaQuery->where('nama', 'like', $searchTerm);
                })
                // Atau cari di NIM mahasiswa
                ->orWhereHas('mahasiswa.profilMahasiswa', function ($profilQuery) use ($searchTerm) {
                    $profilQuery->where('nim', 'like', $searchTerm);
                });
            });
        }

        $history = $query->paginate(15); // Ambil 15 data per halaman

        return response()->json($history);
    }
    // ===============================================
    // === TAMBAHKAN METODE BARU DI BAWAH INI ===
    // ===============================================
    /**
     * Mengambil daftar lomba yang sudah diarsipkan (status = 'selesai').
     */
    public function getArchivedLombas(Request $request)
    {
        $query = Lomba::where('status', 'selesai')
                      ->orderBy('tanggal_selesai_lomba', 'desc'); // Urutkan dari yang terbaru selesai

        // Tambahkan fungsionalitas pencarian
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_lomba', 'like', $searchTerm)
                  ->orWhere('penyelenggara', 'like', $searchTerm);
            });
        }

        $archivedLombas = $query->paginate(15);

        return response()->json($archivedLombas);
    }
}