<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Lomba;
use App\Models\Prestasi;
use App\Models\RegistrasiLomba;
use App\Models\TahapLomba;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LombaController extends Controller
{
    /**
     * Menampilkan semua data lomba.
     * GET /api/lomba
     */
    public function index(Request $request)
    {
        
        // Mulai query builder dengan eager loading
        $query = Lomba::with(['tags', 'pembuat'])->withCount('registrasi');

        // 1. Fungsionalitas Pencarian (Search)
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_lomba', 'like', '%' . $searchTerm . '%')
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

        if (Auth::check() && in_array(Auth::user()->role, ['admin_lomba', 'kemahasiswaan'])) {

            // A. Filter berdasarkan status jika ada di request
            if ($request->filled('status')) {
                $query->where('status', $request->query('status'));
            }

            // B. Urutkan berdasarkan prioritas status untuk admin
            //    'belum disetujui' akan selalu muncul paling atas.
            $query->orderByRaw("FIELD(status, 'belum disetujui', 'disetujui', 'berlangsung', 'selesai', 'ditolak')");
        }

        $perPage = $request->input('limit', 10);
        if ($request->has('tags') && is_array($request->tags) && count($request->tags) > 0) {
            $tagIds = $request->tags;
            // Gunakan whereHas untuk memfilter lomba yang memiliki setidaknya satu dari tag yang dipilih
            $query->whereHas('tags', function ($tagQuery) use ($tagIds) {
                $tagQuery->whereIn('tags.id_tag', $tagIds);
            });
        }
        // Ganti get() dengan paginate()
        // Metode latest() tetap digunakan untuk mengurutkan
        $lombas = $query->latest()->paginate($perPage);
        // ==========================================================

        return response()->json([
            'success' => true,
            'message' => 'Daftar Lomba Berhasil Diambil ',
            'data' => $lombas
        ], 200);
    }
    /**
     * Menyimpan lomba baru ke database.
     * POST /api/lomba
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'nama_lomba'    => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'deskripsi_pengumpulan' => 'required|string',
            'lokasi'        => 'required|in:online,offline',
            'lokasi_offline' => 'nullable|string|max:255|required_if:lokasi,offline',
            'tingkat'       => 'required|in:nasional,internasional,internal',
            'tanggal_akhir_registrasi' => 'required|date|after_or_equal:today',
            'tanggal_mulai_lomba'      => 'required|date|after_or_equal:tanggal_akhir_registrasi',
            'tanggal_selesai_lomba'    => 'required|date|after_or_equal:tanggal_mulai_lomba',
            'penyelenggara' => 'nullable|string|max:255',
            'foto_lomba'    => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags'          => 'required|array',
            'tags.*'        => 'exists:tags,id_tag',
            'tahap'         => 'required|array|min:1',
            'tahap.*.nama'  => 'required|string|max:100',
            'tahap.*.deskripsi' => 'nullable|string'
        ], [
            'tanggal_akhir_registrasi.after_or_equal' => 'Tanggal akhir registrasi tidak boleh tanggal yang sudah lewat.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $image_path = null; // Inisialisasi path gambar

        try {
            DB::beginTransaction();

            // --- [PERUBAHAN] Logika Penyimpanan Gambar ---
            if ($request->hasFile('foto_lomba')) {
                $file = $request->file('foto_lomba');

                // Buat nama file yang unik berdasarkan waktu dan nama asli file
                // Ini aman karena tidak bergantung pada ID yang belum ada
                $fileName = 'lomba_' . time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

                // Simpan file ke storage/app/public/foto_lomba
                // Metode storeAs() akan mengembalikan path relatif dari folder 'storage/app/public'
                $image_path = $file->storeAs('foto_lomba', $fileName, 'public');
            }
            // ---------------------------------------------

            $penyelenggaraNama = $request->filled('penyelenggara')
                ? $request->penyelenggara
                : $user->nama;

            // Buat lomba dengan path gambar dari storage
            $lomba = Lomba::create([
                'nama_lomba'    => $request->nama_lomba,
                'deskripsi'     => $request->deskripsi,
                'deskripsi_pengumpulan' => $request->deskripsi_pengumpulan,
                'lokasi'        => $request->lokasi,
                'lokasi_offline' => $request->lokasi === 'offline' ? $request->lokasi_offline : null,
                'tingkat'       => $request->tingkat,
                'status'        => 'belum disetujui',
                'penyelenggara' => $penyelenggaraNama,
                'tanggal_akhir_registrasi' => $request->tanggal_akhir_registrasi,
                'tanggal_mulai_lomba' => $request->tanggal_mulai_lomba,
                'tanggal_selesai_lomba' => $request->tanggal_selesai_lomba,
                'foto_lomba'    => $image_path, // Simpan path dari storage
                'id_pembuat'    => $user->id_user,
            ]);

            $lomba->tags()->attach($request->tags);

            foreach ($request->tahap as $index => $dataTahap) {
                TahapLomba::create([
                    'id_lomba' => $lomba->id_lomba,
                    'nama_tahap' => $dataTahap['nama'],
                    'deskripsi' => $dataTahap['deskripsi'] ?? null,
                    'urutan' => $index + 1,
                ]);
            }

            DB::commit();

            Log::info('Lomba berhasil dibuat oleh user ID: ' . $user->id_user, ['lomba_id' => $lomba->id_lomba]);

            return response()->json([
                'success' => true,
                'message' => 'Lomba Berhasil Dibuat',
                'data' => Lomba::with('tags', 'tahaps')->find($lomba->id_lomba)
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            // [PERBAIKAN] Hapus file yang sudah ter-upload jika terjadi error
            if ($image_path && Storage::disk('public')->exists($image_path)) {
                Storage::disk('public')->delete($image_path);
            }

            Log::error('Gagal membuat lomba: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server saat membuat lomba.'
            ], 500);
        }
    }

    /**
     * Menampilkan satu data lomba spesifik.
     * GET /api/lomba/{id}
     */
    public function show($id)
    {
        $lomba = Lomba::with(['tags', 'pembuat', 'tahaps'])->find($id);

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
        Log::info($request);

        $lomba = Lomba::with('tahaps')->find($id);

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
            'lokasi_offline' => 'nullable|string|max:255|required_if:lokasi,offline',
            'tingkat'       => 'sometimes|required|in:nasional,internasional,internal',
            'status'        => 'sometimes|required|in:belum disetujui,disetujui,berlangsung,selesai',
            'tanggal_akhir_registrasi' => 'sometimes|required|date',
            'tanggal_mulai_lomba' => 'sometimes|required|date',
            'tanggal_selesai_lomba' => 'sometimes|required|date',
            'penyelenggara' => 'nullable|string|max:255',
            'foto_lomba'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags'          => 'sometimes|required|array',
            'tags.*'        => 'exists:tags,id_tag',
            'tahap'               => 'sometimes|required|array|min:1',
            'tahap.*.id'          => 'nullable|integer|exists:tahap_lomba,id_tahap', // ID boleh null (untuk tahap baru)
            'tahap.*.nama'        => 'required|string|max:100',
            'tahap.*.deskripsi'   => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validasi Gagal', 'errors' => $validator->errors()], 422);
        }

        // Mengambil data yang tervalidasi
        $validatedData = $validator->validated();

        if ($lomba->status === 'ditolak') {
            $validatedData['status'] = 'belum disetujui';
        }

        if (isset($validatedData['lokasi']) && $validatedData['lokasi'] === 'online') {
            $validatedData['lokasi_offline'] = null;
        }

        if ($request->hasFile('foto_lomba')) {
            // Hapus gambar lama
            Storage::disk('public')->delete($lomba->foto_lomba);

            // Upload gambar baru
            $image = $request->file('foto_lomba');
            $validatedData['foto_lomba'] = $image->store('assets/lomba', 'public');
        }

        // Update lomba dengan data yang divalidasi
        $lomba->update($validatedData);

        if ($request->has('tahap')) {
            $incomingTahaps = collect($request->tahap);
            $incomingTahapIds = $incomingTahaps->pluck('id')->filter()->all(); // Ambil semua ID yang dikirim

            // 1. Hapus tahap yang tidak ada lagi di request
            $lomba->tahaps()->whereNotIn('id_tahap', $incomingTahapIds)->delete();

            // 2. Update atau Buat tahap baru
            foreach ($incomingTahaps as $index => $tahapData) {
                TahapLomba::updateOrCreate(
                    [
                        // Kondisi untuk mencari: ID Lomba dan ID Tahap (jika ada)
                        'id_lomba' => $lomba->id_lomba,
                        'id_tahap' => $tahapData['id'] ?? null,
                    ],
                    [
                        // Data untuk diupdate atau dibuat
                        'nama_tahap' => $tahapData['nama'],
                        'deskripsi' => $tahapData['deskripsi'] ?? null,
                        'urutan' => $index + 1,
                    ]
                );
            }
        }

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
        if ($lomba->id_pembuat !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Tidak diizinkan'], 403);
        }

        // [PERUBAHAN] Gunakan transaction untuk keamanan
        DB::beginTransaction();
        try {
            // Hapus relasi di tabel pivot terlebih dahulu
            $lomba->tags()->detach();

            // [TAMBAHAN] Hapus semua record yang bergantung pada lomba ini
            $lomba->registrasi()->delete(); // Hapus semua pendaftaran
            $lomba->tahaps()->delete();  // Hapus semua tahaps

            // Hapus file gambar dari storage
            if ($lomba->foto_lomba && Storage::disk('public')->exists($lomba->foto_lomba)) {
                Storage::disk('public')->delete($lomba->foto_lomba);
            }

            // Terakhir, hapus lomba itu sendiri
            $lomba->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Lomba berhasil dihapus.'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menghapus lomba: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus lomba.'], 500);
        }
    }

    /**
     * Mengambil daftar pendaftar sebuah lomba.
     * Logika ini disesuaikan berdasarkan peran user:
     * - Kemahasiswaan/Prodi melihat pendaftar yang perlu verifikasi ('menunggu_verifikasi', 'ditolak').
     * - Admin Lomba melihat pendaftar yang sudah diverifikasi ('diterima') untuk dinilai.
     * GET /api/lomba/{id}/pendaftar
     */
    public function getPendaftar($id)
    {
        $lomba = Lomba::find($id);
        if (!$lomba) {
            return response()->json(['success' => false, 'message' => 'Lomba tidak ditemukan'], 404);
        }

        // Dapatkan user yang sedang login untuk menentukan filter
        $user = Auth::user();

        // Mulai query builder untuk registrasi
        $registrationsQuery = RegistrasiLomba::where('id_lomba', $id);

        // ==========================================================
        // === PERUBAHAN UTAMA: Filter Pendaftar Berdasarkan Peran ===
        // ==========================================================
        if ($user && in_array($user->role, ['admin_lomba'])) {
            $registrationsQuery->where('status_verifikasi', 'diterima');
        }
        // ==========================================================
        // === AKHIR PERUBAHAN ===
        // ==========================================================

        // Eager load semua relasi yang dibutuhkan setelah filter diterapkan
        $registrations = $registrationsQuery->with([
            'mahasiswa' => function ($query) use ($id) {
                $query->with([
                    'profilMahasiswa.programStudi', // Relasi mahasiswa ke profil
                    // Muat prestasi yang relevan dengan lomba ini saja
                    'prestasi' => function ($prestasiQuery) use ($id) {
                        $prestasiQuery->where('id_lomba', $id);
                    }
                ]);
            },
            'tim.members.profilMahasiswa.programStudi',
            'dosenPembimbing',
            'penilaian.tahap',
            'penilaian.penilai',
        ])
            ->get();

        // Tambahkan deskripsi pengumpulan dari lomba ke setiap objek registrasi
        // (ini berguna untuk admin lomba)
        foreach ($registrations as $registration) {
            $registration->deskripsi_pengumpulan = $lomba->deskripsi_pengumpulan;
        }

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

    // fungsi getlomba yang butuh persetujuan
    public function getLombaButuhPersetujuan()
    {
        // Ambil semua lomba yang statusnya 'belum disetujui'
        $lomba = Lomba::where('status', 'belum disetujui')
            ->with(['tags', 'pembuat'])
            ->get();

        // jika lomba kosong
        if ($lomba->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada lomba yang butuh persetujuan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Daftar Lomba Butuh Persetujuan Berhasil Diambil',
            'data' => $lomba
        ], 200);
    }

    /**
     * Mengambil daftar lomba yang dibuat oleh user (admin lomba) yang sedang login.
     * GET /api/lomba/saya
     */
    public function setujuiLomba($id)
    {
        // 1. Dapatkan user yang sedang terautentikasi
        $user = Auth::user();

        // 2. Otorisasi: Pastikan hanya peran tertentu yang bisa menyetujui
        // Anda bisa menyesuaikan array ini sesuai kebutuhan
        if (!$user || !in_array($user->role, ['kemahasiswaan', 'admin_prodi'])) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk melakukan tindakan ini.'
            ], 403); // 403 Forbidden
        }

        // 3. Cari lomba yang akan disetujui
        $lomba = Lomba::find($id);
        if (!$lomba) {
            return response()->json([
                'success' => false,
                'message' => 'Lomba tidak ditemukan'
            ], 404); // 404 Not Found
        }

        // 4. Validasi Status: Pastikan hanya lomba yang 'belum disetujui' yang bisa diproses
        if ($lomba->status !== 'belum disetujui') {
            return response()->json([
                'success' => false,
                'message' => 'Lomba ini tidak dapat disetujui karena statusnya bukan "Belum Disetujui". Status saat ini: ' . $lomba->status
            ], 422); // 422 Unprocessable Entity
        }

        // 5. Update status dan simpan
        $lomba->status = 'disetujui';
        $lomba->save();

        // 6. Kembalikan respons sukses dengan data lomba yang sudah diupdate
        return response()->json([
            'success' => true,
            'message' => 'Lomba berhasil disetujui.',
            'data' => $lomba
        ], 200);
    }

    /**
     * Mengambil daftar lomba yang dibuat oleh user (admin lomba) yang sedang login.
     * GET /api/lomba/saya
     */
    public function getMyLombas(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak terautentikasi. Silakan login terlebih dahulu.'
            ], 401);
        }

        $query = Lomba::where('id_pembuat', $user->id_user)
            ->with(['tags', 'pembuat'])
            ->withCount('registrasi');

        $query->withCount(['registrasi as pendaftar_diterima' => function ($query) {
            $query->where('status_verifikasi', 'diterima');
        }]);

        if ($request->filled('search')) { // Gunakan filled() untuk Cek jika parameter ada dan tidak kosong
            $searchTerm = $request->search;
            $query->where('nama_lomba', 'like', '%' . $searchTerm . '%');
        }

        if ($request->filled('status')) { // Gunakan filled() untuk Cek jika parameter ada dan tidak kosong
            // Validasi status agar lebih aman
            $validStatuses = ['belum disetujui', 'disetujui', 'berlangsung', 'selesai', 'ditolak'];
            if (in_array($request->status, $validStatuses)) {
                $query->where('status', $request->status);
            }
        }

        // ==========================================================
        // === TAMBAHAN KODE: SORTING PRIORITAS UNTUK ADMIN ===
        // ==========================================================
        // Urutkan berdasarkan prioritas status. 'belum disetujui' akan selalu di atas.
        $query->orderByRaw("FIELD(status, 'ditolak', 'belum disetujui', 'disetujui', 'berlangsung', 'selesai')");
        // ==========================================================
        // === AKHIR TAMBAHAN KODE ===
        // ==========================================================

        $perPage = $request->input('limit', 10);
        // latest() sekarang menjadi pengurutan sekunder setelah orderByRaw
        $lombas = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Daftar lomba Anda berhasil diambil',
            'data' => $lombas
        ], 200);
    }

    /**
     * Menolak sebuah lomba dan memberikan alasan.
     * PATCH /api/lomba/{id}/tolak
     */
    public function tolakLomba(Request $request, $id)
    {
        // 1. Validasi input: alasan penolakan wajib diisi
        $validator = Validator::make($request->all(), [
            'alasan_penolakan' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. Otorisasi: Pastikan hanya peran tertentu yang bisa menolak
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['kemahasiswaan', 'admin_prodi'])) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk melakukan tindakan ini.'
            ], 403);
        }

        // 3. Cari lomba
        $lomba = Lomba::find($id);
        if (!$lomba) {
            return response()->json(['success' => false, 'message' => 'Lomba tidak ditemukan'], 404);
        }

        // 4. Pastikan statusnya masih 'belum disetujui'
        if ($lomba->status !== 'belum disetujui') {
            return response()->json([
                'success' => false,
                'message' => 'Lomba ini tidak dapat ditolak karena sudah diproses.'
            ], 422);
        }

        // 5. Update status dan alasan penolakan
        $lomba->status = 'ditolak';
        $lomba->alasan_penolakan = $request->alasan_penolakan;
        $lomba->save();

        // 6. Kembalikan respons sukses
        return response()->json([
            'success' => true,
            'message' => 'Lomba berhasil ditolak.',
            'data' => $lomba
        ], 200);
    }

    public function getMyLombaDitolak()
    {
        // Dapatkan ID user yang sedang login
        $userId = Auth::id();

        // Jika tidak ada user yang login (sebagai pengaman tambahan)
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Tidak terautentikasi.'], 401);
        }

        $lombasDitolak = Lomba::where('status', 'ditolak')
            // === PERUBAHAN UTAMA DI SINI ===
            // Tambahkan kondisi untuk hanya mengambil lomba yang dibuat oleh user ini
            ->where('id_pembuat', $userId)
            // ===============================
            ->with('pembuat')
            ->latest()
            ->take(5) // Ambil 5 terbaru saja agar tidak terlalu panjang
            ->get();

        if ($lombasDitolak->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Tidak ada lomba Anda yang ditolak.'], 404);
        }

        return response()->json(['success' => true, 'message' => 'Daftar lomba Anda yang ditolak berhasil diambil.', 'data' => $lombasDitolak]);
    }

    public function getMyStats()
    {
        // 1. Dapatkan ID user yang sedang login
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Tidak terautentikasi.'], 401);
        }

        $totalLomba = Lomba::where('id_pembuat', $userId)->count();

        // 2. Hitung jumlah lomba berdasarkan status menggunakan satu query efisien
        //    Ini akan menjadi dasar untuk semua statistik lomba
        $statusCounts = Lomba::where('id_pembuat', $userId)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status'); // pluck() membuat koleksi ['status' => total, ...]

        // 3. Hitung statistik yang dibutuhkan

        // 'Lomba Aktif' adalah gabungan dari 'Disetujui' dan 'Berlangsung'
        $lombaAktif = $statusCounts->get('disetujui', 0) + $statusCounts->get('berlangsung', 0);

        // 'Total Pendaftar' dihitung dari semua lomba yang dibuat oleh user ini
        $totalPendaftar = RegistrasiLomba::where('status_verifikasi', 'diterima')
            ->whereHas('lomba', function ($query) use ($userId) {
                $query->where('id_pembuat', $userId);
            })->count();

        // 4. Siapkan data untuk respons JSON
        $data = [
            'total_lomba' => $totalLomba,
            'lomba_aktif' => $lombaAktif,
            'total_pendaftar' => $totalPendaftar,
            'disetujui' => $statusCounts->get('disetujui', 0),
            'berlangsung' => $statusCounts->get('berlangsung', 0),
            'selesai' => $statusCounts->get('selesai', 0),
            // Anda juga bisa menambahkan statistik lain jika perlu
            'menunggu_persetujuan' => $statusCounts->get('belum disetujui', 0),
        ];

        // 5. Gabungkan semua data ke dalam satu respons
        return response()->json([
            'success' => true,
            'message' => 'Statistik pribadi Anda berhasil diambil',
            'data' => $data
        ], 200);
    }

    /**
     * Mengambil data untuk grafik distribusi pendaftar per lomba.
     * GET /api/lomba/saya/distribusi-pendaftar
     */
    public function getDistribusiPendaftar()
    {
        $userId = Auth::id();

        $topLombas = Lomba::where('id_pembuat', $userId)
            ->withCount('registrasi') // Menghitung pendaftar
            ->orderBy('registrasi_count', 'desc') // Urutkan dari pendaftar terbanyak
            ->take(5) // Ambil 5 teratas
            ->get(['nama_lomba', 'registrasi_count']);

        // Format data agar sesuai dengan kebutuhan Chart.js
        $labels = $topLombas->pluck('nama_lomba');
        $data = $topLombas->pluck('registrasi_count');

        return response()->json([
            'success' => true,
            'data' => [
                'labels' => $labels,
                'data' => $data,
            ]
        ]);
    }

    /**
     * Mengambil daftar lomba milik admin yang sedang berlangsung.
     * GET /api/lomba/saya/berlangsung
     */
    public function getLombaBerlangsung()
    {
        $userId = Auth::id();

        $lombasBerlangsung = Lomba::where('id_pembuat', $userId)
            ->where('status', 'berlangsung')
            // dengan total jumlah pendaftar pada lomba tersebut
            ->with('registrasi')
            ->withCount('registrasi')
            ->latest()
            ->take(5) // Batasi 5 saja
            ->get(['id_lomba', 'nama_lomba']); // Ambil hanya kolom yang perlu

        if ($lombasBerlangsung->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Tidak ada lomba yang sedang berlangsung.'], 404);
        }

        return response()->json(['success' => true, 'data' => $lombasBerlangsung]);
    }

    /**
     * Mengambil 5 lomba terbaru milik admin untuk ditampilkan di dashboard.
     * GET /api/lomba/saya/terbaru
     */
    public function getMyRecentLombas()
    {
        $userId = Auth::id();

        $recentLombas = Lomba::where('id_pembuat', $userId)
            ->withCount('registrasi')
            ->latest() // Ambil yang paling baru dibuat
            ->take(5)   // Batasi 5 record
            ->get(['id_lomba', 'nama_lomba', 'tingkat', 'status']);

        return response()->json([
            'success' => true,
            'data' => $recentLombas
        ]);
    }

    public function getGlobalStats()
    {
        // === 1. STATISTIK LOMBA (GLOBAL) ===
        $statusCounts = Lomba::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $lombaStats = [
            'total' => $statusCounts->sum(),
            'butuh_approval' => $statusCounts->get('belum disetujui', 0),
            'berlangsung' => $statusCounts->get('berlangsung', 0),
            'selesai' => $statusCounts->get('selesai', 0),
        ];


        // === 2. STATISTIK PARTISIPASI MAHASISWA (GLOBAL) ===

        // Jumlah mahasiswa unik yang pernah mendaftar lomba
        $jumlahTerdaftar = RegistrasiLomba::distinct('id_mahasiswa')->count();

        // Jumlah pendaftaran yang sedang aktif (di lomba yang 'berlangsung')
        $sedangBerkompetisi = RegistrasiLomba::whereHas('lomba', function ($query) {
            $query->where('status', 'berlangsung');
        })->count();

        // Jumlah prestasi yang tercatat dari lomba internal (status disetujui)
        $jumlahPrestasi = Prestasi::where('lomba_dari', 'internal')
            ->where('status_verifikasi', 'disetujui')
            ->count();

        // Jumlah pendaftar yang statusnya 'menunggu' dan memilih dosen pembimbing
        $butuhPersetujuanDosen = RegistrasiLomba::where('status_verifikasi', 'menunggu')
            ->whereNotNull('id_dosen')
            ->count();

        $mahasiswaStats = [
            'jumlah_terdaftar' => $jumlahTerdaftar,
            'butuh_persetujuan_dosen' => $butuhPersetujuanDosen,
            'sedang_berkompetisi' => $sedangBerkompetisi,
            'prestasi' => $jumlahPrestasi,
        ];


        // === 3. DATA UNTUK CHART ===

        // Data untuk Bar Chart: Sebaran Prodi Pendaftar Lomba
        $sebaranProdi = DB::table('registrasi_lomba')
            ->join('users', 'registrasi_lomba.id_mahasiswa', '=', 'users.id_user')
            ->join('profil_mahasiswa', 'users.id_user', '=', 'profil_mahasiswa.id_user')
            ->join('program_studi', 'profil_mahasiswa.id_program_studi', '=', 'program_studi.id_program_studi')
            ->select('program_studi.nama_program_studi', DB::raw('count(DISTINCT registrasi_lomba.id_mahasiswa) as jumlah_mahasiswa'))
            ->groupBy('program_studi.nama_program_studi')
            ->orderBy('jumlah_mahasiswa', 'desc')
            ->get();

        // Data untuk Pie Chart: Sebaran Tingkat Lomba
        $sebaranTingkatLomba = Lomba::query()
            ->select('tingkat', DB::raw('count(*) as total'))
            ->groupBy('tingkat')
            ->pluck('total', 'tingkat');

        $chartData = [
            'sebaran_prodi' => $sebaranProdi,
            'sebaran_tingkat_lomba' => $sebaranTingkatLomba,
        ];


        // === 4. GABUNGKAN SEMUA DATA DALAM SATU RESPONS ===
        return response()->json([
            'success' => true,
            'message' => 'Statistik global berhasil diambil',
            'data' => [
                'lomba_stats' => $lombaStats,
                'mahasiswa_stats' => $mahasiswaStats,
                'chart_data' => $chartData,
            ]
        ], 200);
    }
}
