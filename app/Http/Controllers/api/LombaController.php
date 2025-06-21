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
use App\Models\TahapLomba;
use Illuminate\Support\Facades\Log;

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
            'lokasi'     => 'required|in:online,offline',
            'lokasi_offline' => 'nullable|string|max:255|required_if:lokasi,offline',
            'tingkat'       => 'required|in:nasional,internasional,internal',
            'tanggal_akhir_registrasi' => 'required|date',
            'tanggal_mulai_lomba' => 'required|date|after_or_equal:tanggal_akhir_registrasi',
            'tanggal_selesai_lomba' => 'required|date|after_or_equal:tanggal_mulai_lomba',
            'penyelenggara' => 'nullable|string|max:255',
            'foto_lomba'    => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags'          => 'required|array',
            'tags.*'        => 'exists:tags,id_tag', // Memastikan setiap tag ID ada di tabel tags
            'tahap'         => 'required|array|min:1', // <-- VALIDASI BARU
            'tahap.*.nama'        => 'required|string|max:100',
            'tahap.*.deskripsi'   => 'nullable|string'
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
        $id_pembuat = Auth::id();

        // Buat lomba
        $lomba = Lomba::create([
            'nama_lomba'    => $request->nama_lomba,
            'deskripsi'     => $request->deskripsi,
            'lokasi'        => $request->lokasi,
            'lokasi_offline' => $request->lokasi === 'offline' ? $request->lokasi_offline : null,
            'tingkat'       => $request->tingkat,
            'status'        => 'belum disetujui',
            'penyelenggara' => $request->penyelenggara, // Bisa diisi atau dibiarkan kosong
            'tanggal_akhir_registrasi' => $request->tanggal_akhir_registrasi,
            'tanggal_mulai_lomba' => $request->tanggal_mulai_lomba,
            'tanggal_selesai_lomba' => $request->tanggal_selesai_lomba,
            'foto_lomba'    => $image_path,
            'id_pembuat'    => $id_pembuat,
        ]);

        Log::info('Lomba created by user ID: ' . $id_pembuat, [
            'lomba_id' => $lomba->id_lomba,
            'nama_lomba' => $lomba->nama_lomba,
            'penyelenggara' => $lomba['penyelenggara'],
            'lokasi' => $request->lokasi,
            'lokasi_offline' => $request->lokasi_offline
        ]);

        if ($request->filled('penyelenggara')) { // filled() lebih baik dari has() karena juga mengecek string kosong
            $lomba['penyelenggara'] = $request->penyelenggara;
        } else {
            // Pastikan kolom 'nama' ada di model User Anda
            $lomba['penyelenggara'] = $user->nama;
        }

        // Lampirkan tags ke lomba yang baru dibuat
        $lomba->tags()->attach($request->tags);

        foreach ($request->tahap as $index => $dataTahap) {
            TahapLomba::create([
                'id_lomba' => $lomba->id_lomba,
                'nama_tahap' => $dataTahap['nama'],
                'deskripsi' => $dataTahap['deskripsi'] ?? null,
                'urutan' => $index + 1,
            ]);
        }

        Log::info('Lomba berhasil dibuat:', $lomba->toArray());

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
        if (!Lomba::find($id)) {
            return response()->json(['success' => false, 'message' => 'Lomba tidak ditemukan'], 404);
        }

        // --- PERUBAHAN DI SINI ---
        // Eager load semua relasi yang dibutuhkan, termasuk penilaian dan detailnya
        $registrations = RegistrasiLomba::where('id_lomba', $id)
            ->with([
                'mahasiswa.profilMahasiswa.programStudi',
                'tim',
                'dosenPembimbing',
                // Muat relasi penilaian, dan di dalam penilaian, muat relasi tahap & penilai
                'penilaian.tahap',
                'penilaian.penilai'
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
        $query->orderByRaw("FIELD(status, 'belum disetujui', 'disetujui', 'berlangsung', 'selesai', 'ditolak')");
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
        $totalPendaftar = RegistrasiLomba::whereHas('lomba', function ($query) use ($userId) {
            $query->where('id_pembuat', $userId);
        })->count();

        // 4. Siapkan data untuk respons JSON
        $data = [
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
}
