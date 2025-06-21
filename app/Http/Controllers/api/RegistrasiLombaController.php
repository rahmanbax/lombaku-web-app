<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use App\Models\RegistrasiLomba;
use App\Models\Tim;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegistrasiLombaController extends Controller
{
    // Metode create() tidak perlu diubah, biarkan seperti adanya.
    public function create(Lomba $lomba)
    {
        $dosenList = User::where('role', 'dosen')->orderBy('nama')->get(['id_user', 'nama']);
        $mahasiswaList = User::where('role', 'mahasiswa')
            ->where('id_user', '!=', Auth::id())
            ->orderBy('nama')
            ->get(['id_user', 'nama']);
        return view('mahasiswa.lomba.registrasilomba', compact('lomba', 'dosenList', 'mahasiswaList'));
    }

    /**
     * TUGAS 2: Menerima data dari form, memvalidasi, dan menyimpannya.
     * Metode ini akan dipanggil oleh rute di api.php.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'mahasiswa') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak. Hanya mahasiswa yang bisa mendaftar.'], 403);
        }

        // =====================================================================
        // === PERBAIKAN UTAMA ADA DI SINI ===
        // =====================================================================
        $validator = Validator::make($request->all(), [
            'id_lomba'          => 'required|exists:lomba,id_lomba',
            'tipe_pendaftaran'  => 'required|in:individu,kelompok',

            // Aturan baru yang lebih cerdas untuk nama_tim
            'nama_tim'          => [
                'nullable', // 1. Bolehkan field ini kosong atau tidak ada.
                'string',   // 2. Jika ada, harus berupa string.
                'max:255',
                // 3. Wajib diisi HANYA JIKA tipe pendaftaran adalah 'kelompok'.
                Rule::requiredIf($request->tipe_pendaftaran == 'kelompok'),
            ],

            'members'           => 'nullable|array',
            // Aturan ini juga kita perbaiki agar hanya berjalan jika tipe kelompok
            'members.*'         => ['required_with:nama_tim', 'integer', Rule::exists('users', 'id_user')->where('role', 'mahasiswa')],

            'id_dosen'          => [
                'nullable',
                'integer',
                Rule::exists('users', 'id_user')->where('role', 'dosen')
            ],

            'link_pengumpulan'  => 'required|url|max:255',
        ]);
        // =====================================================================

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        // Cek duplikasi pendaftaran (kode ini tetap sama)
        if (RegistrasiLomba::where('id_lomba', $request->id_lomba)->where('id_mahasiswa', $user->id_user)->exists()) {
            return response()->json(['success' => false, 'message' => 'Anda sudah terdaftar pada lomba ini.'], 409);
        }

        // Transaksi Database (kode ini tetap sama)
        try {
            DB::beginTransaction();
            $timId = null;
            if ($request->tipe_pendaftaran === 'kelompok') {
                $tim = Tim::create(['nama_tim' => $request->nama_tim]);
                $timId = $tim->id_tim;
                $memberIds = $request->members ?? [];
                $memberIds[] = $user->id_user;
                $tim->members()->attach(array_unique($memberIds));
            }
            RegistrasiLomba::create([
                'id_mahasiswa'      => $user->id_user,
                'id_lomba'          => $request->id_lomba,
                'id_tim'            => $timId,
                'id_dosen'          => $request->id_dosen,
                'link_pengumpulan'  => $request->link_pengumpulan,
                'status_verifikasi' => 'menunggu',
            ]);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pendaftaran lomba berhasil dikirim!'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal saat proses pendaftaran lomba: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan pada server.'], 500);
        }
    }

    public function getMyButuhPenilaian()
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Tidak terautentikasi.'], 401);
        }

        // 1. Ambil semua LOMBA yang relevan milik admin ini
        $lombas = Lomba::where('id_pembuat', $userId)
            ->whereIn('status', ['berlangsung', 'selesai'])
            // Eager load semua relasi yang akan kita butuhkan nanti
            ->with([
                'tahaps:id_lomba,id_tahap', // Hanya butuh ID untuk menghitung
                'registrasi' => function ($query) {
                    // Ambil hanya pendaftar yang diterima
                    $query->where('status_verifikasi', 'diterima')
                        // Untuk setiap pendaftar, hitung penilaiannya
                        ->withCount('penilaian')
                        // Dan ambil data mahasiswanya
                        ->with('mahasiswa:id_user,nama');
                }
            ])
            ->get();

        // 2. Olah data di level Collection untuk membentuk struktur yang diinginkan
        $lombasButuhPenilaian = $lombas->map(function ($lomba) {

            // Hitung total tahap sekali saja untuk lomba ini
            $totalTahap = $lomba->tahaps->count();

            // Filter pendaftar dari lomba ini yang penilaiannya belum lengkap
            $pesertaButuhDinilai = $lomba->registrasi->filter(function ($pendaftar) use ($totalTahap) {
                return $pendaftar->penilaian_count < $totalTahap;
            });

            // Jika ada peserta yang butuh dinilai di lomba ini
            if ($pesertaButuhDinilai->isNotEmpty()) {
                // Kembalikan objek baru dengan struktur yang kita inginkan
                return [
                    'id_lomba' => $lomba->id_lomba,
                    'nama_lomba' => $lomba->nama_lomba,
                    'peserta' => $pesertaButuhDinilai->map(function ($pendaftar) {
                        return [
                            'id_registrasi_lomba' => $pendaftar->id_registrasi_lomba,
                            'nama_mahasiswa' => $pendaftar->mahasiswa->nama,
                        ];
                    })->values() // ->values() untuk mereset key array
                ];
            }

            // Jika tidak ada peserta yang butuh dinilai, kembalikan null
            return null;
        })
            // Hilangkan semua hasil null dari koleksi
            ->filter()
            // Urutkan berdasarkan nama lomba
            ->sortBy('nama_lomba')
            // Ambil 5 lomba teratas
            ->take(5);

        if ($lombasButuhPenilaian->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Tidak ada submission yang perlu Anda nilai saat ini.'], 404);
        }

        // ->values() untuk mereset key array setelah semua proses
        return response()->json(['success' => true, 'data' => $lombasButuhPenilaian->values()]);
    }
}
