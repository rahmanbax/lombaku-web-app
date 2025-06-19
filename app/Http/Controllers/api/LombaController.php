<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Lomba;
use App\Models\RegistrasiLomba;

class LombaController extends Controller
{
    /**
     * Menampilkan semua data lomba.
     * GET /api/lomba
     */
  public function index(Request $request)
    {
        // Mulai query builder dengan eager loading
        $query = Lomba::with(['tags'])->latest();

        // 1. Fungsionalitas Pencarian (Search)
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_lomba', 'like', '%' . $searchTerm . '%')
                  ->orWhere('deskripsi', 'like', '%' . $searchTerm . '%')
                  ->orWhere('penyelenggara', 'like', '%' . $searchTerm . '%');
            });
        }
        
        // 2. Fungsionalitas Filter
        if ($request->has('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }
        if ($request->has('lokasi')) {
            $query->where('lokasi', $request->lokasi);
        }
        
        // 3. Paginasi
        // Ambil data dengan paginasi (misalnya, 9 item per halaman)
        $lombas = $query->paginate(9)->withQueryString();

        return response()->json($lombas, 200);
    }
    /**
     * Menyimpan lomba baru ke database.
     * POST /api/lomba
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lomba'    => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'lokasi'     => 'required|in:online,offline',
            'tingkat'       => 'required|in:nasional,internasional,internal',
            'tanggal_akhir_registrasi' => 'required|date',
            'tanggal_mulai_lomba' => 'required|date|after_or_equal:tanggal_akhir_registrasi',
            'tanggal_selesai_lomba' => 'required|date|after_or_equal:tanggal_mulai_lomba',
            'penyelenggara' => 'nullable|string|max:255',
            'foto_lomba'    => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags'          => 'required|array',
            'tags.*'        => 'exists:tags,id_tag', // Memastikan setiap tag ID ada di tabel tags
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Upload gambar
        $image = $request->file('foto_lomba');

        // 1. Buat nama file yang unik untuk menghindari penimpaan file dengan nama yang sama.
        //    Contoh: 1678886400.jpg
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        // 2. Tentukan folder tujuan di dalam direktori 'public'.
        //    helper public_path() akan memberikan path absolut ke folder public Anda.
        $destinationPath = public_path('/images/lomba');

        // 3. Pindahkan file yang di-upload ke folder tujuan dengan nama baru.
        $image->move($destinationPath, $imageName);

        // 4. Simpan path relatif dari folder public untuk disimpan ke database.
        //    Hasilnya akan menjadi string seperti: 'images/lomba/1678886400.jpg'
        $image_path = 'images/lomba/' . $imageName;

        // Dapatkan ID user yang sedang login (sebagai pembuat)
        // Pastikan route ini dilindungi oleh middleware 'auth:api' atau 'auth:sanctum'
        // $id_pembuat = auth()->id(); 
        $id_pembuat = 1;

        // Buat lomba
        $lomba = Lomba::create([
            'nama_lomba'    => $request->nama_lomba,
            'deskripsi'     => $request->deskripsi,
            'lokasi'        => $request->lokasi,
            'tingkat'       => $request->tingkat,
            'status'        => 'belum disetujui', // Status default saat dibuat
            'tanggal_akhir_registrasi' => $request->tanggal_akhir_registrasi,
            'tanggal_mulai_lomba' => $request->tanggal_mulai_lomba,
            'tanggal_selesai_lomba' => $request->tanggal_selesai_lomba,
            'penyelenggara' => $request->penyelenggara,
            'foto_lomba'    => $image_path,
            'id_pembuat'    => $id_pembuat,
        ]);

        // Lampirkan tags ke lomba yang baru dibuat
        $lomba->tags()->attach($request->tags);

        return response()->json([
            'success' => true,
            'message' => 'Lomba Berhasil Dibuat',
            'data' => Lomba::with('tags')->find($lomba->id_lomba) // Kirim kembali data lomba dengan tags
        ], 201);
    }

    /**
     * Menampilkan satu data lomba spesifik.
     * GET /api/lomba/{id}
     */
   public function show($id)
    {
        $lomba = Lomba::with(['tags', 'pembuat'])->find($id);

        if (!$lomba) {
            return response()->json([
                'success' => false,
                'message' => 'Lomba Tidak Ditemukan',
            ], 404);
        }

        // --- INI BAGIAN YANG DIPERBAIKI ---
        $isBookmarked = false;
        // Sekarang kita gunakan Auth::guard('sanctum')->check() untuk secara eksplisit
        // memeriksa apakah request API ini membawa token otentikasi yang valid.
        if (Auth::guard('sanctum')->check()) {
            // Kode ini hanya akan berjalan jika user login DAN request API-nya terotentikasi.
            $user = Auth::guard('sanctum')->user();
            $isBookmarked = $user->bookmarkedLombas()->where('lomba.id_lomba', $id)->exists();
        }

        // Tambahkan properti baru ke objek lomba
        $lomba->is_bookmarked = $isBookmarked;
        
        return response()->json([
            'success' => true,
            'message' => 'Detail Lomba Ditemukan',
            'data' => $lomba
        ], 200);
    }

    /**
     * Memperbarui data lomba.
     * PUT/PATCH /api/lomba/{id}
     */
    public function update(Request $request, $id)
    {
        $lomba = Lomba::find($id);

        if (!$lomba) {
            return response()->json(['success' => false, 'message' => 'Lomba tidak ditemukan'], 404);
        }

        // Opsi: Tambahkan otorisasi untuk memastikan hanya pembuat yang bisa mengedit
        // if ($lomba->id_pembuat !== auth()->id()) {
        //     return response()->json(['success' => false, 'message' => 'Tidak diizinkan'], 403);
        // }

        $validator = Validator::make($request->all(), [
            'nama_lomba'    => 'sometimes|required|string|max:255',
            'deskripsi'     => 'sometimes|required|string',
            'lokasi'        => 'sometimes|in:online,offline',
            'tingkat'       => 'sometimes|required|in:nasional,internasional,internal',
            'status'        => 'sometimes|required|in:belum disetujui,disetujui,berlangsung,selesai',
            'tanggal_akhir_registrasi' => 'sometimes|required|date',
            'tanggal_mulai_lomba' => 'sometimes|required|date',
            'tanggal_selesai_lomba' => 'sometimes|required|date',
            'penyelenggara' => 'nullable|string|max:255',
            'foto_lomba'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags'          => 'sometimes|required|array',
            'tags.*'        => 'exists:tags,id_tag',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validasi Gagal', 'errors' => $validator->errors()], 422);
        }

        // Mengambil data yang tervalidasi
        $validatedData = $validator->validated();

        if ($request->hasFile('foto_lomba')) {
            // Hapus gambar lama
            Storage::disk('public')->delete($lomba->foto_lomba);

            // Upload gambar baru
            $image = $request->file('foto_lomba');
            $validatedData['foto_lomba'] = $image->store('assets/lomba', 'public');
        }

        // Update lomba dengan data yang divalidasi
        $lomba->update($validatedData);

        // Sinkronisasi tags, sync() akan menghapus tag lama dan menambah tag baru
        if ($request->has('tags')) {
            $lomba->tags()->sync($request->tags);
        }

        return response()->json([
            'success' => true,
            'message' => 'Lomba Berhasil Diperbarui',
            'data' => Lomba::with('tags')->find($lomba->id_lomba)
        ], 200);
    }

    /**
     * Menghapus data lomba.
     * DELETE /api/lomba/{id}
     */
    public function destroy($id)
    {
        $lomba = Lomba::find($id);

        if (!$lomba) {
            return response()->json(['success' => false, 'message' => 'Lomba tidak ditemukan'], 404);
        }

        // Opsi: Otorisasi
        // if ($lomba->id_pembuat !== auth()->id()) {
        //     return response()->json(['success' => false, 'message' => 'Tidak diizinkan'], 403);
        // }

        // Hapus file gambar dari storage
        Storage::disk('public')->delete($lomba->foto_lomba);

        // Hapus relasi di tabel pivot terlebih dahulu
        $lomba->tags()->detach();

        // Hapus lomba
        $lomba->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lomba Berhasil Dihapus'
        ], 200);
    }

    public function getPendaftar($id)
    {
        // Cek apakah lomba ada
        if (!Lomba::find($id)) {
            return response()->json(['success' => false, 'message' => 'Lomba tidak ditemukan'], 404);
        }

        // Ambil semua data registrasi untuk lomba ini
        // Eager load semua relasi yang dibutuhkan untuk ditampilkan di tabel
        $registrations = RegistrasiLomba::where('id_lomba', $id)
            ->with([
                'mahasiswa.profilMahasiswa.programStudi', // Mahasiswa -> Profil -> Prodi
                'tim',
                'dosenPembimbing'
            ])
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar pendaftar berhasil diambil',
            'data' => $registrations
        ], 200);
    }

    public function getStats()
    {
        // 1. Hitung total semua lomba
        $totalLomba = Lomba::count();

        // 2. Hitung total semua pendaftar
        $totalPendaftar = RegistrasiLomba::count();

        // 3. Hitung jumlah lomba berdasarkan status menggunakan satu query efisien
        $statusCounts = DB::table('lomba')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->keyBy('status'); // keyBy('status') mengubah koleksi menjadi array asosiatif

        // 4. Siapkan data dengan nilai default 0 untuk semua status
        $statusData = [
            'belum_disetujui' => $statusCounts->get('belum disetujui')->total ?? 0,
            // Status 'disetujui' kita anggap sebagai 'Belum dimulai' di frontend
            'disetujui' => $statusCounts->get('disetujui')->total ?? 0,
            'berlangsung' => $statusCounts->get('berlangsung')->total ?? 0,
            'selesai' => $statusCounts->get('selesai')->total ?? 0,
        ];

        // 5. Gabungkan semua data ke dalam satu respons
        return response()->json([
            'success' => true,
            'message' => 'Statistik berhasil diambil',
            'data' => [
                'total_lomba' => $totalLomba,
                'total_pendaftar' => $totalPendaftar,
                'status_counts' => $statusData,
            ]
        ], 200);
    }
}
