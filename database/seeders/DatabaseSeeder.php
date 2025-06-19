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
        // Urutan Seeding Sangat Penting untuk menjaga relasi Foreign Key
        // 1. Master Data (tanpa ketergantungan)
        // 2. Users (data inti)
        // 3. Profiles (bergantung pada Users & Program Studi)
        // 4. Lomba (bergantung pada Users)
        // 5. Pivot Table Lomba-Tags (bergantung pada Lomba & Tags)
        // 6. Tim & Anggota (bergantung pada Users)
        // 7. Registrasi (bergantung pada hampir semua tabel)

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
            // [1] Role: kemahasiswaan
            [
                'id_user' => 1,
                'foto_profile' => 'images/profile/default-profile.png',
                'username' => 'kemahasiswaan',
                'password' => Hash::make('password'),
                'nama' => 'Bapak Kemahasiswaan',
                'notelp' => '081100000001',
                'email' => 'kemahasiswaan@kampus.ac.id',
                'role' => 'kemahasiswaan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // [2] Role: admin_prodi
            [
                'id_user' => 2,
                'foto_profile' => 'images/profile/default-profile.png',
                'username' => 'admin.if',
                'password' => Hash::make('password'),
                'nama' => 'Admin Prodi Informatika',
                'notelp' => '081100000002',
                'email' => 'admin.if@kampus.ac.id',
                'role' => 'admin_prodi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // [3] Role: admin_lomba
            [
                'id_user' => 3,
                'foto_profile' => 'images/profile/default-profile.png',
                'username' => 'lombapedia',
                'password' => Hash::make('password'),
                'nama' => 'Admin Lombapedia',
                'notelp' => '081100000003',
                'email' => 'contact@lombapedia.com',
                'role' => 'admin_lomba',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // [4] Role: dosen
            [
                'id_user' => 4,
                'foto_profile' => 'images/profile/default-profile.png',
                'username' => 'dosen.budi',
                'password' => Hash::make('password'),
                'nama' => 'Budi Santoso, M.Kom.',
                'notelp' => '081211112222',
                'email' => 'budi.s@kampus.ac.id',
                'role' => 'dosen',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // [5] Role: dosen
            [
                'id_user' => 5,
                'foto_profile' => 'images/profile/default-profile.png',
                'username' => 'dosen.ana',
                'password' => Hash::make('password'),
                'nama' => 'Ana Lestari, M.Ds.',
                'notelp' => '081233334444',
                'email' => 'ana.l@kampus.ac.id',
                'role' => 'dosen',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // [6] Role: mahasiswa
            [
                'id_user' => 6,
                'foto_profile' => 'images/profile/default-profile.png',
                'username' => 'mahasiswa.andi',
                'password' => Hash::make('password'),
                'nama' => 'Andi Hermawan',
                'notelp' => '085711112222',
                'email' => 'andi.h@student.kampus.ac.id',
                'role' => 'mahasiswa',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // [7] Role: mahasiswa
            [
                'id_user' => 7,
                'foto_profile' => 'images/profile/default-profile.png',
                'username' => 'mahasiswa.siti',
                'password' => Hash::make('password'),
                'nama' => 'Siti Aminah',
                'notelp' => '085733334444',
                'email' => 'siti.a@student.kampus.ac.id',
                'role' => 'mahasiswa',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // [8] Role: mahasiswa
            [
                'id_user' => 8,
                'foto_profile' => 'images/profile/default-profile.png',
                'username' => 'mahasiswa.rina',
                'password' => Hash::make('password'),
                'nama' => 'Rina Wijayanti',
                'notelp' => '085755556666',
                'email' => 'rina.w@student.kampus.ac.id',
                'role' => 'mahasiswa',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // =================================================================
        // 3. PROFILES (profil_mahasiswa, profil_dosen, profil_admin_lomba)
        // =================================================================
        DB::table('profil_mahasiswa')->insert([
            // Profil untuk Andi
            [
                'id_user' => 6, // <-- PENTING: ID ini HARUS SAMA dengan id_user Andi
                'nim' => 11223301,
                'id_program_studi' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Profil untuk Siti
            [
                'id_user' => 7, // <-- PENTING: ID ini HARUS SAMA dengan id_user Siti
                'nim' => 11223302,
                'id_program_studi' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Profil untuk Rina
            [
                'id_user' => 8, // <-- PENTING: ID ini HARUS SAMA dengan id_user Rina
                'nim' => 33221101,
                'id_program_studi' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        DB::table('profil_dosen')->insert([
            ['id_user' => 4, 'nip' => 99887701, 'id_program_studi' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 5, 'nip' => 99887702, 'id_program_studi' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Asumsi: profil_admin_lomba memiliki relasi one-to-one dengan user ber-role admin_lomba
        DB::table('profil_admin_lomba')->insert([
            // Menambahkan foreign key 'id_user' untuk relasi yang logis
            // 'id_user' => 3, // Jika Anda menambahkan kolom id_user di migrasi profil_admin_lomba
            'alamat' => 'Jl. Teknologi No. 1, Jakarta',
            'jenis_organisasi' => 'Perusahaan',
            'created_at' => now(),
            'updated_at' => now()
        ]);


        // =================================================================
        // 4. LOMBA
        // =================================================================
        DB::table('lomba')->insert([
            // [1] Lomba yang sedang berlangsung
            [
                'id_lomba' => 1,
                'foto_lomba' => 'images/lomba/image-lomba.jpg',
                'nama_lomba' => 'National Hackathon 2024',
                'deskripsi' => 'Kompetisi membuat aplikasi inovatif dalam 24 jam.',
                'lokasi' => 'online',
                'tingkat' => 'nasional',
                'status' => 'berlangsung',
                'tanggal_akhir_registrasi' => Carbon::now()->addDays(5),
                'tanggal_mulai_lomba' => Carbon::now()->subDays(1),
                'tanggal_selesai_lomba' => Carbon::now()->addDays(10),
                'penyelenggara' => 'Tech Indonesia',
                'id_pembuat' => 3, // Dibuat oleh admin_lomba
                'created_at' => now(),
                'updated_at' => now()
            ],
            // [2] Lomba yang sudah selesai
            [
                'id_lomba' => 2,
                'foto_lomba' => 'images/lomba/image-lomba.jpg',
                'nama_lomba' => 'UI/UX Challenge 2023',
                'deskripsi' => 'Rancang antarmuka aplikasi mobile yang ramah pengguna.',
                'lokasi' => 'online',
                'tingkat' => 'nasional',
                'status' => 'selesai',
                'tanggal_akhir_registrasi' => Carbon::now()->subMonths(2)->startOfMonth(),
                'tanggal_mulai_lomba' => Carbon::now()->subMonths(2)->day(10),
                'tanggal_selesai_lomba' => Carbon::now()->subMonths(2)->endOfMonth(),
                'penyelenggara' => 'Creative Hub',
                'id_pembuat' => 3, // Dibuat oleh admin_lomba
                'created_at' => now(),
                'updated_at' => now()
            ],
            // [3] Lomba yang akan datang dan belum disetujui
            [
                'id_lomba' => 3,
                'foto_lomba' => 'images/lomba/image-lomba.jpg',
                'nama_lomba' => 'International Business Case Competition',
                'deskripsi' => 'Selesaikan studi kasus bisnis dari perusahaan multinasional.',
                'lokasi' => 'online',
                'tingkat' => 'internasional',
                'status' => 'belum disetujui',
                'tanggal_akhir_registrasi' => Carbon::now()->addMonths(1),
                'tanggal_mulai_lomba' => Carbon::now()->addMonths(1)->addWeeks(2),
                'tanggal_selesai_lomba' => Carbon::now()->addMonths(2),
                'penyelenggara' => 'Global Business Association',
                'id_pembuat' => 3, // Dibuat oleh admin_lomba
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // =================================================================
        // 5. DAFTAR_TAG (Pivot Table Lomba & Tags)
        // =================================================================
        DB::table('daftar_tag')->insert([
            // Lomba 1 (Hackathon) punya tag Programming & Data Science
            ['id_lomba' => 1, 'id_tag' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_lomba' => 1, 'id_tag' => 4, 'created_at' => now(), 'updated_at' => now()],
            // Lomba 2 (UI/UX) punya tag UI/UX
            ['id_lomba' => 2, 'id_tag' => 2, 'created_at' => now(), 'updated_at' => now()],
            // Lomba 3 (Business) punya tag Business Case
            ['id_lomba' => 3, 'id_tag' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);


        // =================================================================
        // 6. TIM & MEMBER_TIM
        // =================================================================
        DB::table('tim')->insert([
            ['id_tim' => 1, 'nama_tim' => 'Tim Koding Keren', 'created_at' => now(), 'updated_at' => now()],
            ['id_tim' => 2, 'nama_tim' => 'Tim Desain Ciamik', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('member_tim')->insert([
            // Tim 1: Andi dan Siti
            ['id_tim' => 1, 'id_mahasiswa' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['id_tim' => 1, 'id_mahasiswa' => 7, 'created_at' => now(), 'updated_at' => now()],
            // Tim 2: Rina
            ['id_tim' => 2, 'id_mahasiswa' => 8, 'created_at' => now(), 'updated_at' => now()],
        ]);


        // =================================================================
        // 7. REGISTRASI_LOMBA
        // =================================================================
        DB::table('registrasi_lomba')->insert([
            // Tim Koding Keren (diwakili Andi) mendaftar ke Lomba 1, dibimbing Dosen Budi
            [
                'link_pengumpulan' => 'https://github.com/tim-koding-keren/hackathon2024',
                'status_verifikasi' => 'diterima',
                'id_mahasiswa' => 6, // Pendaftar/Ketua Tim
                'id_lomba' => 1,
                'id_tim' => 1, // Daftar sebagai tim
                'id_dosen' => 4, // Dibimbing Dosen Budi
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Tim Desain Ciamik (diwakili Rina) mendaftar ke Lomba 2, dibimbing Dosen Ana
            [
                'link_pengumpulan' => 'https://figma.com/tim-desain-ciamik/uiux2023',
                'status_verifikasi' => 'diterima',
                'id_mahasiswa' => 8, // Pendaftar/Ketua Tim
                'id_lomba' => 2,
                'id_tim' => 2, // Daftar sebagai tim
                'id_dosen' => 5, // Dibimbing Dosen Ana
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Mahasiswa Siti mendaftar Lomba 1 secara individu, tanpa pembimbing
            [
                'link_pengumpulan' => 'https://github.com/siti-aminah/hackathon-solo',
                'status_verifikasi' => 'menunggu',
                'id_mahasiswa' => 7, // Pendaftar
                'id_lomba' => 1,
                'id_tim' => null, // Daftar individu
                'id_dosen' => null, // Tanpa pembimbing
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // =================================================================
        // 8. TAHAP_LOMBA (BARU)
        // =================================================================
        DB::table('tahap_lomba')->insert([
            // Tahapan untuk Lomba 1 (Hackathon)
            ['id_tahap' => 1, 'id_lomba' => 1, 'nama_tahap' => 'Penyisihan', 'urutan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_tahap' => 2, 'id_lomba' => 1, 'nama_tahap' => 'Final', 'urutan' => 2, 'created_at' => now(), 'updated_at' => now()],

            // Tahapan untuk Lomba 2 (UI/UX) - cuma 1 tahap
            ['id_tahap' => 3, 'id_lomba' => 2, 'nama_tahap' => 'Penilaian Karya', 'urutan' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);


        // =================================================================
        // 9. PENILAIAN_PESERTA (BARU)
        // =================================================================
        DB::table('penilaian_peserta')->insert([
            // Penilaian untuk Lomba 1 (Hackathon), dinilai oleh admin_lomba (id_user=3)

            // Tahap Penyisihan (id_tahap=1)
            // - Peserta: Tim Koding Keren (id_registrasi_lomba=1)
            ['id_registrasi_lomba' => 1, 'id_tahap' => 1, 'id_penilai' => 3, 'nilai' => 85, 'catatan' => 'Ide bagus, eksekusi perlu ditingkatkan.', 'created_at' => now(), 'updated_at' => now()],
            // - Peserta: Siti Aminah (id_registrasi_lomba=3)
            ['id_registrasi_lomba' => 3, 'id_tahap' => 1, 'id_penilai' => 3, 'nilai' => 90, 'catatan' => 'Konsep sangat matang dan inovatif.', 'created_at' => now(), 'updated_at' => now()],

            // Tahap Final (id_tahap=2)
            // - Peserta: Siti Aminah (id_registrasi_lomba=3) - Anggap saja dia lolos
            ['id_registrasi_lomba' => 3, 'id_tahap' => 2, 'id_penilai' => 3, 'nilai' => 95, 'catatan' => 'Presentasi sangat meyakinkan dan produk berfungsi baik.', 'created_at' => now(), 'updated_at' => now()],

            // Penilaian untuk Lomba 2 (UI/UX), dinilai oleh admin_lomba (id_user=3)
            // Tahap Penilaian Karya (id_tahap=3)
            // - Peserta: Tim Desain Ciamik (id_registrasi_lomba=2)
            ['id_registrasi_lomba' => 2, 'id_tahap' => 3, 'id_penilai' => 3, 'nilai' => 88, 'catatan' => 'Desain visual menarik, namun ada beberapa isu UX pada alur pengguna.', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =================================================================
        // 10. PRESTASI (BARU)
        // =================================================================
        DB::table('prestasi')->insert([

            // --- Contoh Prestasi INTERNAL (dari Lomba di sistem) ---
            // Dicatat oleh admin_lomba setelah Lomba 1 selesai, status langsung disetujui.
            [
                'id_user' => 7, // Mahasiswa Siti Aminah
                'lomba_dari' => 'internal',
                'id_lomba' => 1, // Berasal dari National Hackathon 2024
                'nama_lomba_eksternal' => null,
                'penyelenggara_eksternal' => null,
                'tingkat' => 'nasional', // Diambil dari data lomba
                'peringkat' => 'Juara 1',
                'tanggal_diraih' => '2024-07-20', // Contoh tanggal pengumuman
                'sertifikat_path' => 'sertifikat/internal/lomba-1-juara-1.pdf',
                'status_verifikasi' => 'disetujui',
                'id_verifikator' => 3, // Langsung diverifikasi oleh admin_lomba
                'catatan_verifikasi' => 'Prestasi dicatat otomatis dari sistem.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user' => 6, // Mahasiswa Andi Hermawan
                'lomba_dari' => 'internal',
                'id_lomba' => 1, // Berasal dari National Hackathon 2024
                'nama_lomba_eksternal' => null,
                'penyelenggara_eksternal' => null,
                'tingkat' => 'nasional',
                'peringkat' => 'Juara 2',
                'tanggal_diraih' => '2024-07-20',
                'sertifikat_path' => 'sertifikat/internal/lomba-1-juara-2.pdf',
                'status_verifikasi' => 'disetujui',
                'id_verifikator' => 3,
                'catatan_verifikasi' => 'Prestasi dicatat otomatis dari sistem.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // --- Contoh Prestasi EKSTERNAL (di-upload oleh mahasiswa) ---
            // Diunggah oleh Mahasiswa Rina (id_user=8), status menunggu verifikasi.
            [
                'id_user' => 8, // Mahasiswa Rina Wijayanti
                'lomba_dari' => 'eksternal',
                'id_lomba' => null, // Tidak ada ID lomba dari sistem
                'nama_lomba_eksternal' => 'Gemastik XV - Cabang Desain Pengalaman Pengguna',
                'penyelenggara_eksternal' => 'Pusat Prestasi Nasional (Puspresnas)',
                'tingkat' => 'nasional',
                'peringkat' => 'Medali Perunggu',
                'tanggal_diraih' => '2023-11-15',
                'sertifikat_path' => 'sertifikat/eksternal/rina-gemastik-xv.pdf',
                'status_verifikasi' => 'menunggu',
                'id_verifikator' => null, // Belum ada yang verifikasi
                'catatan_verifikasi' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Contoh lain, diunggah oleh Mahasiswa Andi, sudah disetujui.
            [
                'id_user' => 6, // Mahasiswa Andi Hermawan
                'lomba_dari' => 'eksternal',
                'id_lomba' => null,
                'nama_lomba_eksternal' => 'Imagine Cup 2023 Southeast Asia',
                'penyelenggara_eksternal' => 'Microsoft',
                'tingkat' => 'internasional',
                'peringkat' => 'Finalis',
                'tanggal_diraih' => '2023-05-22',
                'sertifikat_path' => 'sertifikat/eksternal/andi-imagine-cup.pdf',
                'status_verifikasi' => 'disetujui',
                'id_verifikator' => 1, // Diverifikasi oleh Kemahasiswaan (id_user=1)
                'catatan_verifikasi' => 'Sertifikat valid.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
