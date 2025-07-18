<?php

namespace App\Http\Controllers\API;

use App\Exports\MahasiswaExport;
use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\User;
use App\Models\ProfilMahasiswa;
use App\Models\RegistrasiLomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    /**
     * Menampilkan daftar semua mahasiswa.
     * GET /api/mahasiswa
     */
    public function index()
    {
        // Ambil semua user dengan role 'mahasiswa' dan eager load relasi profil & prodi
        $mahasiswas = User::where('role', 'mahasiswa')
            // Eager load relasi profilMahasiswa, dan DI DALAM profilMahasiswa, load relasi programStudi
            ->with('profilMahasiswa.programStudi') // <-- PERUBAHAN DI SINI
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Mahasiswa Berhasil Diambil',
            'data' => $mahasiswas
        ], 200);
    }

    /**
     * Menyimpan mahasiswa baru (membuat User dan ProfilMahasiswa).
     * POST /api/mahasiswa
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password'          => 'required|string|min:8|confirmed',
            'nama'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email',
            'notelp'            => 'nullable|string',
            'nim'               => 'required|integer|unique:profil_mahasiswa,nim',
            'id_program_studi'  => 'required|exists:program_studi,id_program_studi',
            'foto_profil'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validasi Gagal', 'errors' => $validator->errors()], 422);
        }

        // Gunakan transaksi database untuk memastikan kedua tabel berhasil diisi
        try {
            DB::beginTransaction();

            // 1. Buat User baru
            $user = User::create([
                'password'          => Hash::make($request->password),
                'nama'              => $request->nama,
                'email'             => $request->email,
                'notelp'            => $request->notelp,
                'role'              => 'mahasiswa', // Set role secara otomatis
                'id_program_studi'  => $request->id_program_studi,
            ]);

            $foto_path = null;
            if ($request->hasFile('foto_profil')) {
                // Simpan foto ke public/images/profil_mahasiswa
                $image = $request->file('foto_profil');
                $imageName = $user->id_user . '_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/profil_mahasiswa'), $imageName);
                $foto_path = 'images/profil_mahasiswa/' . $imageName;
            }

            // 2. Buat ProfilMahasiswa yang terhubung
            ProfilMahasiswa::create([
                'nim'               => $request->nim,
                'id_user'           => $user->id_user,
                'id_program_studi'  => $request->id_program_studi,
                'foto_profil'       => $foto_path,
            ]);

            DB::commit();

            // Ambil kembali data lengkap untuk respons
            $createdMahasiswa = User::with('profilMahasiswa.programStudi')->find($user->id_user);

            return response()->json([
                'success' => true,
                'message' => 'Mahasiswa Berhasil Dibuat',
                'data' => $createdMahasiswa
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi Kesalahan Server',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menampilkan detail satu mahasiswa.
     * GET /api/mahasiswa/{id}
     */
    public function show($id)
    {
        $mahasiswa = User::where('role', 'mahasiswa')
            ->with(['profilMahasiswa.programStudi', 'programStudi'])
            ->find($id);

        if (!$mahasiswa) {
            return response()->json(['success' => false, 'message' => 'Mahasiswa tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $mahasiswa], 200);
    }

    /**
     * Memperbarui data mahasiswa.
     * PUT /api/mahasiswa/{id} (Gunakan POST dengan _method=PUT untuk form-data)
     */
    public function update(Request $request, $id)
    {
        $mahasiswa = User::where('role', 'mahasiswa')->with('profilMahasiswa')->find($id);

        if (!$mahasiswa) {
            return response()->json(['success' => false, 'message' => 'Mahasiswa tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama'              => 'sometimes|required|string|max:255',
            'email'             => 'sometimes|required|email|unique:users,email,' . $id . ',id_user',
            'notelp'            => 'nullable|string',
            'nim'               => 'sometimes|required|integer|unique:profil_mahasiswa,nim,' . $mahasiswa->profilMahasiswa->id_profil_mahasiswa . ',id_profil_mahasiswa',
            'id_program_studi'  => 'sometimes|required|exists:program_studi,id_program_studi',
            'foto_profil'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validasi Gagal', 'errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            $mahasiswa->update($request->only(['nama', 'email', 'notelp', 'id_program_studi']));

            if ($request->hasFile('foto_profil')) {
                // Hapus foto lama jika ada
                if ($mahasiswa->profilMahasiswa->foto_profil) {
                    if (file_exists(public_path($mahasiswa->profilMahasiswa->foto_profil))) {
                        unlink(public_path($mahasiswa->profilMahasiswa->foto_profil));
                    }
                }
                // Upload foto baru
                $image = $request->file('foto_profil');
                $imageName = $mahasiswa->id_user . '_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/profil_mahasiswa'), $imageName);
                $request['foto_profil'] = 'images/profil_mahasiswa/' . $imageName;
            }

            $mahasiswa->profilMahasiswa->update($request->only(['nim', 'id_program_studi', 'foto_profil']));

            DB::commit();

            $updatedMahasiswa = User::with('profilMahasiswa.programStudi')->find($id);

            return response()->json(['success' => true, 'message' => 'Data Mahasiswa Berhasil Diperbarui', 'data' => $updatedMahasiswa], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui data', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Menghapus data mahasiswa.
     * DELETE /api/mahasiswa/{id}
     */
    public function destroy($id)
    {
        $mahasiswa = User::where('role', 'mahasiswa')->with('profilMahasiswa')->find($id);

        if (!$mahasiswa) {
            return response()->json(['success' => false, 'message' => 'Mahasiswa tidak ditemukan'], 404);
        }

        // Hapus file foto dari storage
        if ($mahasiswa->profilMahasiswa && $mahasiswa->profilMahasiswa->foto_profil) {
            if (file_exists(public_path($mahasiswa->profilMahasiswa->foto_profil))) {
                unlink(public_path($mahasiswa->profilMahasiswa->foto_profil));
            }
        }

        // Karena di migrasi profil_mahasiswa ada onDelete('cascade'),
        // kita hanya perlu menghapus user, dan profilnya akan ikut terhapus.
        $mahasiswa->delete();

        return response()->json(['success' => true, 'message' => 'Mahasiswa berhasil dihapus'], 200);
    }

    public function exportXlsx()
    {
        // Tentukan nama file yang akan di-download
        $fileName = 'daftar-mahasiswa-' . now()->format('Y-m-d') . '.xlsx';

        // Panggil library untuk men-download file menggunakan Export Class kita
        return Excel::download(new MahasiswaExport, $fileName);
    }

    public function getDashboardStats(Request $request) // <-- Tambahkan Request $request
    {
        // 1. Mengambil Statistik Kartu (Cards)
        // Statistik tetap menghitung total, tidak terpengaruh oleh pencarian.
        $stats = [
            'total_mahasiswa' => User::where('role', 'mahasiswa')->count(),
            'total_prestasi' => Prestasi::where('status_verifikasi', 'disetujui')->count(),
            'tahap_pendaftaran' => RegistrasiLomba::where('status_verifikasi', 'menunggu')->count(),
            'butuh_persetujuan_pembimbing' => RegistrasiLomba::whereNotNull('id_dosen')
                ->where('status_verifikasi', 'menunggu')->count(),
            'sedang_berlangsung' => RegistrasiLomba::whereHas('lomba', function ($query) {
                $query->where('status', 'berlangsung');
            })->count(),
            'selesai' => RegistrasiLomba::whereHas('lomba', function ($query) {
                $query->where('status', 'selesai');
            })->count(),
        ];

        // [PERUBAHAN UTAMA DI SINI]
        // 2. Mengambil Daftar Mahasiswa dengan Paginasi dan Pencarian

        // Mulai query builder untuk User
        $mahasiswaQuery = User::query()->where('role', 'mahasiswa');

        // Terapkan pencarian jika ada parameter 'search' di URL
        if ($request->has('search') && $request->input('search') != '') {
            $searchTerm = $request->input('search');

            $mahasiswaQuery->where(function ($query) use ($searchTerm) {
                // Cari di kolom 'nama' pada tabel 'users'
                $query->where('nama', 'LIKE', "%{$searchTerm}%")
                    // Atau cari di kolom 'nim' pada tabel 'profil_mahasiswa' melalui relasi
                    ->orWhereHas('profilMahasiswa', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('nim', 'LIKE', "%{$searchTerm}%");
                    });
            });
        }

        // Lanjutkan query dengan withCount, orderBy, dan paginate
        $mahasiswa = $mahasiswaQuery->with('profilMahasiswa.programStudi')
            ->withCount([
                'registrasiLomba as total_lomba_diikuti',
                'prestasi' => function ($query) {
                    $query->where('status_verifikasi', 'disetujui');
                },
                'registrasiLomba as menunggu_persetujuan_count' => function ($query) {
                    $query->where('status_verifikasi', 'menunggu');
                }
            ])
            ->orderBy('nama', 'asc')
            ->paginate(10)
            // [PENTING] Menambahkan query string ke link paginasi
            ->withQueryString();


        // 3. Mengembalikan data sebagai JSON
        return response()->json([
            'success' => true,
            'message' => 'Data Dashboard Berhasil Diambil',
            'data' => [
                'stats' => $stats,
                'mahasiswa' => $mahasiswa,
            ]
        ], 200);
    }

    public function showDetail($nim)
    {
        // 1. Temukan profil mahasiswa berdasarkan NIM.
        // firstOrFail() akan otomatis menghasilkan 404 Not Found jika NIM tidak ada.
        $profilMahasiswa = ProfilMahasiswa::where('nim', $nim)->firstOrFail();

        // 2. Ambil model User yang berelasi dengan profil tersebut.
        $mahasiswa = $profilMahasiswa->user;

        // Jika user tidak ditemukan (kasus data tidak konsisten), kembalikan error.
        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data User untuk NIM ini tidak ditemukan.'
            ], 404);
        }

        // 3. Eager load semua relasi yang dibutuhkan untuk halaman detail.
        // Sama seperti sebelumnya, kita load relasinya ke objek $mahasiswa.
        $mahasiswa->load([
            'profilMahasiswa.programStudi',
            'registrasiLomba' => function ($query) {
                // Untuk setiap registrasi, kita langsung load relasi yang dibutuhkan
                $query->with([
                    'lomba',
                    'tim.members.profilMahasiswa', // <-- Ini akan memuat tim, lalu member, lalu detail user dari member
                    'dosenPembimbing'
                ])->latest('created_at');
            },
            'prestasi' => function ($query) {
                $query->where('status_verifikasi', 'disetujui')
                    ->with('lomba') // Load juga relasi lomba di dalam prestasi
                    ->latest('tanggal_diraih');
            }
        ]);

        // $mahasiswa->registrasiLomba->load('lomba', 'tim', 'dosenPembimbing');
        // $mahasiswa->prestasi->load('lomba');

        // 4. Hitung statistik
        $stats = [
            'total_lomba_diikuti' => $mahasiswa->registrasiLomba->count(),
            'prestasi_terverifikasi' => $mahasiswa->prestasi->count(),
            'menunggu_persetujuan' => $mahasiswa->registrasiLomba->where('status_verifikasi', 'menunggu')->count(),
            'lomba_berlangsung' => $mahasiswa->registrasiLomba->where('lomba.status', 'berlangsung')->count(),
        ];

        $mahasiswa->stats = $stats;

        return response()->json([
            'success' => true,
            'message' => 'Detail mahasiswa berhasil diambil',
            'data' => $mahasiswa
        ], 200);
    }
}
