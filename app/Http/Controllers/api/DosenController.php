<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegistrasiLomba;

class DosenController extends Controller
{
    /**
     * Menyediakan data untuk dashboard Dosen Pembina.
     * Endpoint: GET /api/dosen/dashboard
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function dashboardData()
    {
        // 1. Dapatkan user Dosen yang sedang login melalui Sanctum
        $dosen = Auth::user();

        // 2. Otorisasi: Pastikan user adalah dosen
        if (!$dosen || $dosen->role !== 'dosen') {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Anda bukan dosen.'
            ], 403); // 403 Forbidden
        }

        try {
            // 3. Buat query dasar untuk semua registrasi yang dibimbing oleh dosen ini
            $registrationsQuery = RegistrasiLomba::where('id_dosen', $dosen->id_user);

            // 4. Hitung data untuk kartu statistik
            // Gunakan clone agar query tidak saling mempengaruhi
            $stats = [
                'mahasiswa_aktif' => (clone $registrationsQuery)->distinct('id_mahasiswa')->count('id_mahasiswa'),
                'lomba_diikuti' => (clone $registrationsQuery)->count(),
                'menunggu_persetujuan' => (clone $registrationsQuery)->where('status_verifikasi', 'menunggu')->count(),
            ];

            // 5. Ambil data untuk tabel dengan eager loading & paginasi
            // Eager loading `mahasiswa` dan `lomba` untuk performa (menghindari N+1 query)
            // Hanya pilih kolom yang dibutuhkan untuk efisiensi
            $daftarBimbingan = $registrationsQuery
                                    ->with([
                                        'mahasiswa:id_user,nama', 
                                        'lomba:id_lomba,nama_lomba'
                                    ])
                                    ->latest() // Urutkan dari yang terbaru
                                    ->paginate(10); // Ambil 10 data per halaman

            // 6. Gabungkan semua data ke dalam satu struktur respons
            $data = [
                'stats' => $stats,
                'daftar_bimbingan' => $daftarBimbingan,
            ];

            // 7. Kembalikan respons JSON yang berhasil
            return response()->json([
                'success' => true,
                'message' => 'Data dashboard dosen berhasil diambil.',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            // Tangani jika ada error tak terduga dari server/database
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function riwayatPeserta()
    {
        $dosen = Auth::user();

        if (!$dosen || $dosen->role !== 'dosen') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        try {
            // Ambil semua prestasi yang diraih oleh mahasiswa (id_user)
            // yang pernah mendaftar lomba dengan dosen ini sebagai pembimbing.
            $riwayatQuery = Prestasi::whereHas('mahasiswa.registrasiLomba', function ($query) use ($dosen) {
                $query->where('id_dosen', $dosen->id_user);
            })
            ->with(['mahasiswa:id_user,nama', 'lomba:id_lomba,nama_lomba,tanggal_mulai_lomba,tanggal_selesai_lomba'])
            ->latest('tanggal_diraih'); // Urutkan berdasarkan tanggal prestasi diraih

            $dataRiwayat = $riwayatQuery->paginate(15);

            return response()->json([
                'success' => true,
                'message' => 'Data riwayat peserta berhasil diambil.',
                'data' => $dataRiwayat
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
