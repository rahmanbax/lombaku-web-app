<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // =================================================================
        // 1. MASTER DATA (program_studi, tags)
        // =================================================================
        DB::table('program_studi')->insert([
            ['id_program_studi' => 1, 'nama_program_studi' => 'Teknik Informatika', 'created_at' => now(), 'updated_at' => now()],
            ['id_program_studi' => 2, 'nama_program_studi' => 'Sistem Informasi', 'created_at' => now(), 'updated_at' => now()],
            ['id_program_studi' => 3, 'nama_program_studi' => 'Desain Komunikasi Visual', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('tags')->insert([
            ['id_tag' => 1, 'nama_tag' => 'Programming', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 2, 'nama_tag' => 'UI/UX', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 3, 'nama_tag' => 'Business Case', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 4, 'nama_tag' => 'Data Science', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 5, 'nama_tag' => 'Networking', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =================================================================
        // 2. USERS
        // =================================================================
        DB::table('users')->insert([
            ['id_user' => 1, 'foto_profile' => 'images/profile/default-profile.png', 'username' => 'kemahasiswaan', 'password' => Hash::make('password'), 'nama' => 'Bapak Kemahasiswaan', 'notelp' => '081100000001', 'email' => 'kemahasiswaan@kampus.ac.id', 'role' => 'kemahasiswaan', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 2, 'foto_profile' => 'images/profile/default-profile.png', 'username' => 'admin.if', 'password' => Hash::make('password'), 'nama' => 'Admin Prodi Informatika', 'notelp' => '081100000002', 'email' => 'admin.if@kampus.ac.id', 'role' => 'admin_prodi', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 3, 'foto_profile' => 'images/profile/default-profile.png', 'username' => 'lombapedia', 'password' => Hash::make('password'), 'nama' => 'Admin Lombapedia', 'notelp' => '081100000003', 'email' => 'contact@lombapedia.com', 'role' => 'admin_lomba', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 4, 'foto_profile' => 'images/profile/default-profile.png', 'username' => 'dosen.budi', 'password' => Hash::make('password'), 'nama' => 'Budi Santoso, M.Kom.', 'notelp' => '081211112222', 'email' => 'budi.s@kampus.ac.id', 'role' => 'dosen', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 5, 'foto_profile' => 'images/profile/default-profile.png', 'username' => 'dosen.ana', 'password' => Hash::make('password'), 'nama' => 'Ana Lestari, M.Ds.', 'notelp' => '081233334444', 'email' => 'ana.l@kampus.ac.id', 'role' => 'dosen', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 6, 'foto_profile' => 'images/profile/default-profile.png', 'username' => 'mahasiswa.andi', 'password' => Hash::make('password'), 'nama' => 'Andi Hermawan', 'notelp' => '085711112222', 'email' => 'andi.h@student.kampus.ac.id', 'role' => 'mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 7, 'foto_profile' => 'images/profile/default-profile.png', 'username' => 'mahasiswa.siti', 'password' => Hash::make('password'), 'nama' => 'Siti Aminah', 'notelp' => '085733334444', 'email' => 'siti.a@student.kampus.ac.id', 'role' => 'mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 8, 'foto_profile' => 'images/profile/default-profile.png', 'username' => 'mahasiswa.rina', 'password' => Hash::make('password'), 'nama' => 'Rina Wijayanti', 'notelp' => '085755556666', 'email' => 'rina.w@student.kampus.ac.id', 'role' => 'mahasiswa', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =================================================================
        // 3. PROFILES
        // =================================================================
        DB::table('profil_mahasiswa')->insert([
            ['id_user' => 6, 'nim' => 11223301, 'id_program_studi' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 7, 'nim' => 11223302, 'id_program_studi' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 8, 'nim' => 33221101, 'id_program_studi' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('profil_dosen')->insert([
            ['id_user' => 4, 'nip' => 99887701, 'id_program_studi' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 5, 'nip' => 99887702, 'id_program_studi' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('profil_admin_lomba')->insert([
            ['alamat' => 'Jl. Teknologi No. 1, Jakarta', 'jenis_organisasi' => 'Perusahaan', 'created_at' => now(), 'updated_at' => now()]
        ]);

        // =================================================================
        // 4. LOMBA (Menambahkan status disetujui dan ditolak)
        // =================================================================
        DB::table('lomba')->insert([
            // [1] Lomba yang BERLANGSUNG
            ['id_lomba' => 1, 'foto_lomba' => 'images/lomba/image-lomba.jpg', 'nama_lomba' => 'National Hackathon 2024', 'deskripsi' => 'Kompetisi membuat aplikasi inovatif.', 'lokasi' => 'online', 'tingkat' => 'nasional', 'status' => 'berlangsung', 'alasan_penolakan' => null, 'tanggal_akhir_registrasi' => Carbon::now()->addDays(5), 'tanggal_mulai_lomba' => Carbon::now()->subDays(1), 'tanggal_selesai_lomba' => Carbon::now()->addDays(10), 'penyelenggara' => 'Tech Indonesia', 'id_pembuat' => 3, 'created_at' => now(), 'updated_at' => now()],
            // [2] Lomba yang SELESAI
            ['id_lomba' => 2, 'foto_lomba' => 'images/lomba/image-lomba.jpg', 'nama_lomba' => 'UI/UX Challenge 2023', 'deskripsi' => 'Rancang antarmuka aplikasi.', 'lokasi' => 'online', 'tingkat' => 'nasional', 'status' => 'selesai', 'alasan_penolakan' => null, 'tanggal_akhir_registrasi' => Carbon::now()->subMonths(2)->startOfMonth(), 'tanggal_mulai_lomba' => Carbon::now()->subMonths(2)->day(10), 'tanggal_selesai_lomba' => Carbon::now()->subMonths(2)->endOfMonth(), 'penyelenggara' => 'Creative Hub', 'id_pembuat' => 3, 'created_at' => now(), 'updated_at' => now()],
            // [3] Lomba yang BELUM DISETUJUI
            ['id_lomba' => 3, 'foto_lomba' => 'images/lomba/image-lomba.jpg', 'nama_lomba' => 'Business Case Competition', 'deskripsi' => 'Selesaikan studi kasus bisnis.', 'lokasi' => 'offline', 'tingkat' => 'internasional', 'status' => 'belum disetujui', 'alasan_penolakan' => null, 'tanggal_akhir_registrasi' => Carbon::now()->addMonths(1), 'tanggal_mulai_lomba' => Carbon::now()->addMonths(1)->addWeeks(2), 'tanggal_selesai_lomba' => Carbon::now()->addMonths(2), 'penyelenggara' => 'Global Business Inc.', 'id_pembuat' => 3, 'created_at' => now(), 'updated_at' => now()],
            // [4] Lomba yang DISETUJUI (belum dimulai)
            ['id_lomba' => 4, 'foto_lomba' => 'images/lomba/image-lomba.jpg', 'nama_lomba' => 'Capture The Flag 2025', 'deskripsi' => 'Kompetisi keamanan siber.', 'lokasi' => 'online', 'tingkat' => 'nasional', 'status' => 'disetujui', 'alasan_penolakan' => null, 'tanggal_akhir_registrasi' => Carbon::now()->addMonths(3), 'tanggal_mulai_lomba' => Carbon::now()->addMonths(4), 'tanggal_selesai_lomba' => Carbon::now()->addMonths(4)->addDays(2), 'penyelenggara' => 'Cyber Community', 'id_pembuat' => 3, 'created_at' => now(), 'updated_at' => now()],
            // [5] Lomba yang DITOLAK
            ['id_lomba' => 5, 'foto_lomba' => 'images/lomba/image-lomba.jpg', 'nama_lomba' => 'Lomba Makan Kerupuk', 'deskripsi' => 'Kompetisi adu cepat makan kerupuk.', 'lokasi' => 'offline', 'tingkat' => 'internal', 'status' => 'ditolak', 'alasan_penolakan' => 'Lomba tidak relevan dengan bidang akademik.', 'tanggal_akhir_registrasi' => Carbon::now()->subDays(10), 'tanggal_mulai_lomba' => Carbon::now()->subDays(9), 'tanggal_selesai_lomba' => Carbon::now()->subDays(9), 'penyelenggara' => 'Panitia HUT RI', 'id_pembuat' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =================================================================
        // 5. TAHAP_LOMBA
        // =================================================================
        DB::table('tahap_lomba')->insert([
            ['id_tahap' => 1, 'id_lomba' => 1, 'nama_tahap' => 'Penyisihan', 'urutan' => 1, 'deskripsi' => 'Seleksi awal proposal.', 'created_at' => now(), 'updated_at' => now()],
            ['id_tahap' => 2, 'id_lomba' => 1, 'nama_tahap' => 'Final', 'urutan' => 2, 'deskripsi' => 'Presentasi final di depan juri.', 'created_at' => now(), 'updated_at' => now()],
            ['id_tahap' => 3, 'id_lomba' => 2, 'nama_tahap' => 'Penilaian Karya', 'urutan' => 1, 'deskripsi' => 'Penilaian UI/UX.', 'created_at' => now(), 'updated_at' => now()],
            ['id_tahap' => 4, 'id_lomba' => 4, 'nama_tahap' => 'Kualifikasi', 'urutan' => 1, 'deskripsi' => 'Babak kualifikasi online.', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =================================================================
        // 6. DAFTAR_TAG
        // =================================================================
        DB::table('daftar_tag')->insert([
            ['id_lomba' => 1, 'id_tag' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_lomba' => 1, 'id_tag' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id_lomba' => 2, 'id_tag' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_lomba' => 3, 'id_tag' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_lomba' => 4, 'id_tag' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =================================================================
        // 7. TIM & MEMBER_TIM
        // =================================================================
        DB::table('tim')->insert([
            ['id_tim' => 1, 'nama_tim' => 'Tim Koding Keren', 'created_at' => now(), 'updated_at' => now()],
            ['id_tim' => 2, 'nama_tim' => 'Tim Desain Ciamik', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('member_tim')->insert([
            ['id_tim' => 1, 'id_mahasiswa' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['id_tim' => 1, 'id_mahasiswa' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['id_tim' => 2, 'id_mahasiswa' => 8, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =================================================================
        // 8. REGISTRASI_LOMBA (menambahkan status ditolak)
        // =================================================================
        DB::table('registrasi_lomba')->insert([
            // [1] Diterima (tim, dengan dosen)
            ['id_registrasi_lomba' => 1, 'deskripsi_pengumpulan' => 'Pengumpulan proposal tahap awal.', 'link_pengumpulan' => 'https://github.com/tim-koding-keren/hackathon2024', 'status_verifikasi' => 'diterima', 'id_mahasiswa' => 6, 'id_lomba' => 1, 'id_tim' => 1, 'id_dosen' => 4, 'created_at' => now(), 'updated_at' => now()],
            // [2] Diterima (tim, dengan dosen)
            ['id_registrasi_lomba' => 2, 'deskripsi_pengumpulan' => 'Link presentasi Figma.', 'link_pengumpulan' => 'https://figma.com/tim-desain-ciamik/uiux2023', 'status_verifikasi' => 'diterima', 'id_mahasiswa' => 8, 'id_lomba' => 2, 'id_tim' => 2, 'id_dosen' => 5, 'created_at' => now(), 'updated_at' => now()],
            // [3] Menunggu (individu, tanpa dosen)
            ['id_registrasi_lomba' => 3, 'deskripsi_pengumpulan' => 'Pengumpulan source code.', 'link_pengumpulan' => 'https://github.com/siti-aminah/hackathon-solo', 'status_verifikasi' => 'menunggu', 'id_mahasiswa' => 7, 'id_lomba' => 1, 'id_tim' => null, 'id_dosen' => null, 'created_at' => now(), 'updated_at' => now()],
            // [4] Ditolak (individu, tanpa dosen)
            ['id_registrasi_lomba' => 4, 'deskripsi_pengumpulan' => 'Pengumpulan essay bisnis.', 'link_pengumpulan' => 'https://docs.google.com/essay-bisnis-rina', 'status_verifikasi' => 'ditolak', 'id_mahasiswa' => 8, 'id_lomba' => 3, 'id_tim' => null, 'id_dosen' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =================================================================
        // 9. PENILAIAN_PESERTA
        // =================================================================
        DB::table('penilaian_peserta')->insert([
            ['id_penilaian' => 1, 'id_registrasi_lomba' => 1, 'id_tahap' => 1, 'id_penilai' => 3, 'nilai' => 85, 'catatan' => 'Ide bagus, eksekusi perlu ditingkatkan.', 'created_at' => now(), 'updated_at' => now()],
            ['id_penilaian' => 2, 'id_registrasi_lomba' => 3, 'id_tahap' => 1, 'id_penilai' => 3, 'nilai' => 90, 'catatan' => 'Konsep sangat matang dan inovatif.', 'created_at' => now(), 'updated_at' => now()],
            ['id_penilaian' => 3, 'id_registrasi_lomba' => 3, 'id_tahap' => 2, 'id_penilai' => 3, 'nilai' => 95, 'catatan' => 'Presentasi sangat meyakinkan.', 'created_at' => now(), 'updated_at' => now()],
            ['id_penilaian' => 4, 'id_registrasi_lomba' => 2, 'id_tahap' => 3, 'id_penilai' => 3, 'nilai' => 88, 'catatan' => 'Desain visual menarik.', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =================================================================
        // 10. PRESTASI (menambahkan status ditolak)
        // =================================================================
        DB::table('prestasi')->insert([
            // Internal - Disetujui
            ['id_user' => 7, 'lomba_dari' => 'internal', 'id_lomba' => 1, 'nama_lomba_eksternal' => null, 'penyelenggara_eksternal' => null, 'tingkat' => 'nasional', 'peringkat' => 'Juara 1', 'tanggal_diraih' => '2024-07-20', 'sertifikat_path' => 'sertifikat/internal/lomba-1-juara-1.pdf', 'status_verifikasi' => 'disetujui', 'id_verifikator' => 3, 'catatan_verifikasi' => 'Dicatat otomatis dari sistem.', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 6, 'lomba_dari' => 'internal', 'id_lomba' => 1, 'nama_lomba_eksternal' => null, 'penyelenggara_eksternal' => null, 'tingkat' => 'nasional', 'peringkat' => 'Juara 2', 'tanggal_diraih' => '2024-07-20', 'sertifikat_path' => 'sertifikat/internal/lomba-1-juara-2.pdf', 'status_verifikasi' => 'disetujui', 'id_verifikator' => 3, 'catatan_verifikasi' => 'Dicatat otomatis dari sistem.', 'created_at' => now(), 'updated_at' => now()],
            // Eksternal - Menunggu
            ['id_user' => 8, 'lomba_dari' => 'eksternal', 'id_lomba' => null, 'nama_lomba_eksternal' => 'Gemastik XV - Desain UX', 'penyelenggara_eksternal' => 'Puspresnas', 'tingkat' => 'nasional', 'peringkat' => 'Medali Perunggu', 'tanggal_diraih' => '2023-11-15', 'sertifikat_path' => 'sertifikat/eksternal/rina-gemastik-xv.pdf', 'status_verifikasi' => 'menunggu', 'id_verifikator' => null, 'catatan_verifikasi' => null, 'created_at' => now(), 'updated_at' => now()],
            // Eksternal - Disetujui
            ['id_user' => 6, 'lomba_dari' => 'eksternal', 'id_lomba' => null, 'nama_lomba_eksternal' => 'Imagine Cup 2023 SEA', 'penyelenggara_eksternal' => 'Microsoft', 'tingkat' => 'internasional', 'peringkat' => 'Finalis', 'tanggal_diraih' => '2023-05-22', 'sertifikat_path' => 'sertifikat/eksternal/andi-imagine-cup.pdf', 'status_verifikasi' => 'disetujui', 'id_verifikator' => 1, 'catatan_verifikasi' => 'Sertifikat valid.', 'created_at' => now(), 'updated_at' => now()],
            // Eksternal - Ditolak
            ['id_user' => 7, 'lomba_dari' => 'eksternal', 'id_lomba' => null, 'nama_lomba_eksternal' => 'Lomba Artikel Ilmiah', 'penyelenggara_eksternal' => 'Universitas X', 'tingkat' => 'nasional', 'peringkat' => 'Peserta', 'tanggal_diraih' => '2023-08-01', 'sertifikat_path' => 'sertifikat/eksternal/siti-artikel.pdf', 'status_verifikasi' => 'ditolak', 'id_verifikator' => 1, 'catatan_verifikasi' => 'Sertifikat hanya sebagai peserta, bukan pemenang.', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
