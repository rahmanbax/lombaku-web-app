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
        $this->command->info('Seeding Master Data (Program Studi, Tags)...');
        DB::table('program_studi')->insert([
            ['id_program_studi' => 1, 'nama_program_studi' => 'D3 Teknik Informatika', 'created_at' => now(), 'updated_at' => now()],
            ['id_program_studi' => 2, 'nama_program_studi' => 'D3 Sistem Informasi', 'created_at' => now(), 'updated_at' => now()],
            ['id_program_studi' => 3, 'nama_program_studi' => 'D3 Teknik Komputer', 'created_at' => now(), 'updated_at' => now()],
            ['id_program_studi' => 4, 'nama_program_studi' => 'D3 Digital Accounting (Sistem Informasi Akuntansi)', 'created_at' => now(), 'updated_at' => now()],
            ['id_program_studi' => 5, 'nama_program_studi' => 'D3 Digital Marketing', 'created_at' => now(), 'updated_at' => now()],
            ['id_program_studi' => 6, 'nama_program_studi' => 'D3 Hospitality & Culinary Art', 'created_at' => now(), 'updated_at' => now()],
            ['id_program_studi' => 7, 'nama_program_studi' => 'S1 Terapan Digital Creative Multimedia', 'created_at' => now(), 'updated_at' => now()],
            ['id_program_studi' => 8, 'nama_program_studi' => 'S1 Terapan Digital Creative Multimedia (Lanjutan)', 'created_at' => now(), 'updated_at' => now()],
            ['id_program_studi' => 9, 'nama_program_studi' => 'S1 Terapan Sistem Informasi Kota Cerdas', 'created_at' => now(), 'updated_at' => now()],
        ]);


        DB::table('tags')->insert([
            ['id_tag' => 1, 'nama_tag' => 'Programming', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 2, 'nama_tag' => 'UI/UX', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 3, 'nama_tag' => 'Business Case', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 4, 'nama_tag' => 'Data Science', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 5, 'nama_tag' => 'Networking', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 6, 'nama_tag' => 'Cyber Security', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 7, 'nama_tag' => 'Robotics', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 8, 'nama_tag' => 'IoT', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 9, 'nama_tag' => 'Artificial Intelligence', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 10, 'nama_tag' => 'Game Development', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 11, 'nama_tag' => 'Animation', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 12, 'nama_tag' => 'Film Making', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 13, 'nama_tag' => 'Photography', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 14, 'nama_tag' => 'Graphic Design', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 15, 'nama_tag' => 'Entrepreneurship', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 16, 'nama_tag' => 'Debate', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 17, 'nama_tag' => 'Essay Competition', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 18, 'nama_tag' => 'Public Speaking', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 19, 'nama_tag' => 'Sports', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 20, 'nama_tag' => 'Music', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 21, 'nama_tag' => 'Dance', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 22, 'nama_tag' => 'Culinary', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 23, 'nama_tag' => 'Finance', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 24, 'nama_tag' => 'Accounting', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 25, 'nama_tag' => 'Marketing', 'created_at' => now(), 'updated_at' => now()],
        ]);


        // =================================================================
        // 2. USERS
        // =================================================================
        $this->command->info('Seeding Users...');
        DB::table('users')->insert([
            // Admins & Staff (ID 1-3)
            ['id_user' => 1, 'foto_profile' => 'images/profile/default-profile.png', 'username' => 'kemahasiswaan', 'password' => Hash::make('password'), 'nama' => 'Bapak Kemahasiswaan', 'notelp' => '081100000001', 'email' => 'kemahasiswaan@kampus.ac.id', 'role' => 'kemahasiswaan', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 2, 'foto_profile' => 'images/profile/default-profile.png', 'username' => 'admin.if', 'password' => Hash::make('password'), 'nama' => 'Admin Prodi Informatika', 'notelp' => '081100000002', 'email' => 'admin.if@kampus.ac.id', 'role' => 'admin_prodi', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 3, 'foto_profile' => 'images/profile/default-profile.png', 'username' => 'lombapedia', 'password' => Hash::make('password'), 'nama' => 'Admin Lombapedia', 'notelp' => '081100000003', 'email' => 'contact@lombapedia.com', 'role' => 'admin_lomba', 'created_at' => now(), 'updated_at' => now()],

            // Dosen (ID 4-5)
            ['id_user' => 4, 'foto_profile' => 'images/profile/default-profile.png', 'username' => 'dosen.budi', 'password' => Hash::make('password'), 'nama' => 'Budi Santoso, M.Kom.', 'notelp' => '081211112222', 'email' => 'budi.s@kampus.ac.id', 'role' => 'dosen', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 5, 'foto_profile' => 'images/profile/default-profile.png', 'username' => 'dosen.ana', 'password' => Hash::make('password'), 'nama' => 'Ana Lestari, M.Ds.', 'notelp' => '081233334444', 'email' => 'ana.l@kampus.ac.id', 'role' => 'dosen', 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa (ID 6-8)
            ['id_user' => 6, 'foto_profile' => 'images/profile/default-profile.png', 'username' => 'mahasiswa.andi', 'password' => Hash::make('password'), 'nama' => 'Andi Hermawan', 'notelp' => '085711112222', 'email' => 'andi.h@student.kampus.ac.id', 'role' => 'mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 7, 'foto_profile' => 'images/profile/default-profile.png', 'username' => 'mahasiswa.siti', 'password' => Hash::make('password'), 'nama' => 'Siti Aminah', 'notelp' => '085733334444', 'email' => 'siti.a@student.kampus.ac.id', 'role' => 'mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 8, 'foto_profile' => 'images/profile/default-profile.png', 'username' => 'mahasiswa.rina', 'password' => Hash::make('password'), 'nama' => 'Rina Wijayanti', 'notelp' => '085755556666', 'email' => 'rina.w@student.kampus.ac.id', 'role' => 'mahasiswa', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =================================================================
        // 3. PROFILES
        // =================================================================
        $this->command->info('Seeding Profiles (Mahasiswa, Dosen, Admin Lomba)...');
        DB::table('profil_mahasiswa')->insert([
            ['id_user' => 6, 'id_program_studi' => 1, 'nim' => 11223301, 'tanggal_lahir' => '2002-05-10', 'jenis_kelamin' => 'Laki-laki', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 7, 'id_program_studi' => 1, 'nim' => 11223302, 'tanggal_lahir' => '2002-08-15', 'jenis_kelamin' => 'Perempuan', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 8, 'id_program_studi' => 3, 'nim' => 33221101, 'tanggal_lahir' => '2003-01-20', 'jenis_kelamin' => 'Perempuan', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('profil_dosen')->insert([
            ['id_user' => 4, 'id_program_studi' => 1, 'nip' => 99887701, 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 5, 'id_program_studi' => 3, 'nip' => 99887702, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Catatan: Migrasi profil_admin_lomba tidak memiliki foreign key 'id_user'.
        // Untuk fungsionalitas penuh, disarankan menambahkan `id_user` ke tabel tsb.
        // Di sini, kita akan mengasumsikan profil ini milik user dengan id=3.
        DB::table('profil_admin_lomba')->insert([
            // Seharusnya ada: 'id_user' => 3,
            ['alamat' => 'Jl. Teknologi No. 1, Jakarta', 'jenis_organisasi' => 'Perusahaan', 'created_at' => now(), 'updated_at' => now()]
        ]);

        // =================================================================
        // 4. LOMBA (Mencakup semua status: disetujui, ditolak, dll)
        // =================================================================
        $this->command->info('Seeding Lomba...');
        $this->command->info('Seeding Lomba...');

        DB::table('lomba')->insert([
            ['id_lomba' => 1, 'foto_lomba' => 'images/lomba/image-lomba.jpg', 'nama_lomba' => 'National Hackathon 2024', 'deskripsi' => 'Kompetisi membuat aplikasi inovatif untuk solusi perkotaan.', 'deskripsi_pengumpulan' => 'Proposal aplikasi Smart City.', 'jenis_lomba' => 'kelompok', 'lokasi' => 'online', 'lokasi_offline' => null, 'tingkat' => 'nasional', 'status' => 'berlangsung', 'alasan_penolakan' => null, 'tanggal_akhir_registrasi' => Carbon::now()->addDays(5), 'tanggal_mulai_lomba' => Carbon::now()->subDays(1), 'tanggal_selesai_lomba' => Carbon::now()->addDays(10), 'penyelenggara' => 'Tech Indonesia', 'id_pembuat' => 3, 'created_at' => now(), 'updated_at' => now()],

            ['id_lomba' => 2, 'foto_lomba' => 'images/lomba/image-lomba.jpg', 'nama_lomba' => 'UI/UX Challenge 2023', 'deskripsi' => 'Rancang antarmuka aplikasi mobile banking yang ramah pengguna.', 'deskripsi_pengumpulan' => 'Desain UI/UX mobile banking submission.', 'jenis_lomba' => 'individu', 'lokasi' => 'online', 'lokasi_offline' => null, 'tingkat' => 'nasional', 'status' => 'selesai', 'alasan_penolakan' => null, 'tanggal_akhir_registrasi' => Carbon::now()->subMonths(2)->startOfMonth(), 'tanggal_mulai_lomba' => Carbon::now()->subMonths(2)->day(10), 'tanggal_selesai_lomba' => Carbon::now()->subMonths(2)->endOfMonth(), 'penyelenggara' => 'Creative Hub', 'id_pembuat' => 3, 'created_at' => now(), 'updated_at' => now()],

            ['id_lomba' => 3, 'foto_lomba' => 'images/lomba/image-lomba.jpg', 'nama_lomba' => 'Global Business Case Competition', 'deskripsi' => 'Selesaikan studi kasus bisnis dari perusahaan multinasional.', 'deskripsi_pengumpulan' => 'Deskripsi singkat ide bisnis.', 'jenis_lomba' => 'kelompok', 'lokasi' => 'offline', 'lokasi_offline' => 'Bali Convention Center', 'tingkat' => 'internasional', 'status' => 'belum disetujui', 'alasan_penolakan' => null, 'tanggal_akhir_registrasi' => Carbon::now()->addMonths(1), 'tanggal_mulai_lomba' => Carbon::now()->addMonths(1)->addWeeks(2), 'tanggal_selesai_lomba' => Carbon::now()->addMonths(2), 'penyelenggara' => 'Global Business Inc.', 'id_pembuat' => 3, 'created_at' => now(), 'updated_at' => now()],

            ['id_lomba' => 4, 'foto_lomba' => 'images/lomba/image-lomba.jpg', 'nama_lomba' => 'Capture The Flag 2025', 'deskripsi' => 'Kompetisi keamanan siber untuk mahasiswa dan profesional.', 'deskripsi_pengumpulan' => 'CTF qualification writeup', 'jenis_lomba' => 'kelompok', 'lokasi' => 'online', 'lokasi_offline' => null, 'tingkat' => 'nasional', 'status' => 'disetujui', 'alasan_penolakan' => null, 'tanggal_akhir_registrasi' => Carbon::now()->addMonths(3), 'tanggal_mulai_lomba' => Carbon::now()->addMonths(4), 'tanggal_selesai_lomba' => Carbon::now()->addMonths(4)->addDays(2), 'penyelenggara' => 'Cyber Community', 'id_pembuat' => 3, 'created_at' => now(), 'updated_at' => now()],

            ['id_lomba' => 5, 'foto_lomba' => 'images/lomba/image-lomba.jpg', 'nama_lomba' => 'Lomba Makan Kerupuk Internal', 'deskripsi' => 'Kompetisi adu cepat makan kerupuk dalam rangka 17-an.', 'deskripsi_pengumpulan' => 'Proposal keikutsertaan.', 'jenis_lomba' => 'individu', 'lokasi' => 'offline', 'lokasi_offline' => 'Lapangan Kampus', 'tingkat' => 'internal', 'status' => 'ditolak', 'alasan_penolakan' => 'Lomba tidak relevan dengan bidang akademik dan prestasi mahasiswa.', 'tanggal_akhir_registrasi' => Carbon::now()->subDays(10), 'tanggal_mulai_lomba' => Carbon::now()->subDays(9), 'tanggal_selesai_lomba' => Carbon::now()->subDays(9), 'penyelenggara' => 'Panitia HUT RI Kampus', 'id_pembuat' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);




        // =================================================================
        // 5. TAHAP_LOMBA
        // =================================================================
        $this->command->info('Seeding Tahap Lomba...');
        $this->command->info('Seeding Tahap Lomba...');

        DB::table('tahap_lomba')->insert([
            // Lomba 1
            ['id_lomba' => 1, 'nama_tahap' => 'Penyisihan Proposal', 'urutan' => 1, 'deskripsi' => 'Seleksi awal berdasarkan proposal.', 'created_at' => now(), 'updated_at' => now()],
            ['id_lomba' => 1, 'nama_tahap' => 'Final Presentation', 'urutan' => 2, 'deskripsi' => 'Presentasi final di depan juri.', 'created_at' => now(), 'updated_at' => now()],

            // Lomba 2
            ['id_lomba' => 2, 'nama_tahap' => 'Pengumpulan & Penilaian Karya', 'urutan' => 1, 'deskripsi' => 'Penilaian hasil UI/UX.', 'created_at' => now(), 'updated_at' => now()],

            // Lomba 3
            ['id_lomba' => 3, 'nama_tahap' => 'Seleksi Proposal Bisnis', 'urutan' => 1, 'deskripsi' => 'Seleksi awal berdasarkan proposal bisnis.', 'created_at' => now(), 'updated_at' => now()],

            // Lomba 4
            ['id_lomba' => 4, 'nama_tahap' => 'Babak Kualifikasi', 'urutan' => 1, 'deskripsi' => 'Kualifikasi online.', 'created_at' => now(), 'updated_at' => now()],

            // Lomba 5
            ['id_lomba' => 5, 'nama_tahap' => 'Penulisan Esai', 'urutan' => 1, 'deskripsi' => 'Mengumpulkan esai sesuai tema.', 'created_at' => now(), 'updated_at' => now()],

        ]);


        // =================================================================
        // 6. DAFTAR_TAG (Pivot Lomba-Tags)
        // =================================================================
        $this->command->info('Seeding Daftar Tag...');
        DB::table('daftar_tag')->insert([
            ['id_lomba' => 1, 'id_tag' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_lomba' => 1, 'id_tag' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id_lomba' => 2, 'id_tag' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_lomba' => 3, 'id_tag' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_lomba' => 4, 'id_tag' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['id_lomba' => 4, 'id_tag' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id_lomba' => 5, 'id_tag' => 17, 'created_at' => now(), 'updated_at' => now()],
        ]);


        // =================================================================
        // 7. TIM & MEMBER_TIM
        // =================================================================
        $this->command->info('Seeding Tim dan Member...');
        DB::table('tim')->insert([
            ['id_tim' => 1, 'nama_tim' => 'Tim Koding Keren', 'created_at' => now(), 'updated_at' => now()],
            ['id_tim' => 2, 'nama_tim' => 'Tim CyberSec', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('member_tim')->insert([
            // Tim 1 (Andi & Siti)
            ['id_tim' => 1, 'id_mahasiswa' => 6, 'created_at' => now(), 'updated_at' => now()], // Andi
            ['id_tim' => 1, 'id_mahasiswa' => 7, 'created_at' => now(), 'updated_at' => now()], // Siti
            // Tim 2 (Andi & Rina)
            ['id_tim' => 2, 'id_mahasiswa' => 6, 'created_at' => now(), 'updated_at' => now()], // Andi
            ['id_tim' => 2, 'id_mahasiswa' => 8, 'created_at' => now(), 'updated_at' => now()], // Rina
        ]);

        // =================================================================
        // 8. REGISTRASI_LOMBA
        // =================================================================
        $this->command->info('Seeding Registrasi Lomba...');
        DB::table('registrasi_lomba')->insert([
            ['id_registrasi_lomba' => 1, 'link_pengumpulan' => 'https://github.com/tim-koding-keren/hackathon2024', 'status_verifikasi' => 'diterima', 'id_mahasiswa' => 6, 'id_lomba' => 1, 'id_tim' => 1, 'id_dosen' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id_registrasi_lomba' => 2, 'link_pengumpulan' => 'https://figma.com/rina-wijayanti/uiux2023', 'status_verifikasi' => 'diterima', 'id_mahasiswa' => 8, 'id_lomba' => 2, 'id_tim' => null, 'id_dosen' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_registrasi_lomba' => 3, 'link_pengumpulan' => 'https://docs.google.com/siti-business-idea', 'status_verifikasi' => 'menunggu', 'id_mahasiswa' => 7, 'id_lomba' => 3, 'id_tim' => null, 'id_dosen' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_registrasi_lomba' => 4, 'link_pengumpulan' => 'https://docs.google.com/tim-cybersec-ctf', 'status_verifikasi' => 'ditolak', 'id_mahasiswa' => 6, 'id_lomba' => 4, 'id_tim' => 2, 'id_dosen' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id_registrasi_lomba' => 5, 'link_pengumpulan' => 'https://github.com/tim-cybersec/ctf-qual', 'status_verifikasi' => 'diterima', 'id_mahasiswa' => 7, 'id_lomba' => 4, 'id_tim' => 2, 'id_dosen' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id_registrasi_lomba' => 6, 'link_pengumpulan' => 'https://docs.google.com/smartcity-idea', 'status_verifikasi' => 'menunggu', 'id_mahasiswa' => 7, 'id_lomba' => 1, 'id_tim' => null, 'id_dosen' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_registrasi_lomba' => 7, 'link_pengumpulan' => 'https://figma.com/siti-uxdesign2023', 'status_verifikasi' => 'ditolak', 'id_mahasiswa' => 7, 'id_lomba' => 2, 'id_tim' => null, 'id_dosen' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_registrasi_lomba' => 8, 'link_pengumpulan' => 'https://github.com/tim-cybersec/ctf-final', 'status_verifikasi' => 'diterima', 'id_mahasiswa' => 8, 'id_lomba' => 4, 'id_tim' => 2, 'id_dosen' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_registrasi_lomba' => 9, 'link_pengumpulan' => 'https://github.com/tim-koding-keren/prototype', 'status_verifikasi' => 'menunggu', 'id_mahasiswa' => 6, 'id_lomba' => 1, 'id_tim' => 1, 'id_dosen' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);


        // =================================================================
        // 9. PENILAIAN_PESERTA
        // =================================================================
        $this->command->info('Seeding Penilaian Peserta...');
        DB::table('penilaian_peserta')->insert([
            // Penilaian untuk Registrasi 1 (Tim Koding Keren) di Lomba 1 (Hackathon)
            ['id_registrasi_lomba' => 1, 'id_tahap' => 1, 'id_penilai' => 3, 'nilai' => 85, 'catatan' => 'Ide bagus, eksekusi proposal perlu lebih detail.', 'created_at' => now(), 'updated_at' => now()],
            ['id_registrasi_lomba' => 1, 'id_tahap' => 2, 'id_penilai' => 3, 'nilai' => 92, 'catatan' => 'Presentasi sangat meyakinkan dan demo berjalan lancar.', 'created_at' => now(), 'updated_at' => now()],
            // Penilaian untuk Registrasi 2 (Rina) di Lomba 2 (UI/UX)
            ['id_registrasi_lomba' => 2, 'id_tahap' => 3, 'id_penilai' => 3, 'nilai' => 88, 'catatan' => 'Desain visual sangat menarik, flow pengguna jelas.', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =================================================================
        // 10. PRESTASI
        // =================================================================
        $this->command->info('Seeding Prestasi...');
        DB::table('prestasi')->insert([
            // [1] Internal - Pemenang - Disetujui (ditarik dari data lomba selesai)
            ['id_user' => 8, 'lomba_dari' => 'internal', 'tipe_prestasi' => 'pemenang', 'id_lomba' => 2, 'nama_lomba_eksternal' => null, 'penyelenggara_eksternal' => null, 'tingkat' => 'nasional', 'peringkat' => 'Juara 1', 'tanggal_diraih' => '2023-12-13', 'sertifikat_path' => 'sertifikat/internal/lomba-2-juara-1.pdf', 'status_verifikasi' => 'disetujui', 'id_verifikator' => 2, 'catatan_verifikasi' => 'Data ditarik otomatis dari sistem.', 'created_at' => now(), 'updated_at' => now()],
            // [2] Eksternal - Pemenang - Menunggu Verifikasi
            ['id_user' => 6, 'lomba_dari' => 'eksternal', 'tipe_prestasi' => 'pemenang', 'id_lomba' => null, 'nama_lomba_eksternal' => 'Gemastik XVI - Programming', 'penyelenggara_eksternal' => 'Puspresnas', 'tingkat' => 'nasional', 'peringkat' => 'Medali Emas', 'tanggal_diraih' => '2023-11-15', 'sertifikat_path' => 'sertifikat/eksternal/andi-gemastik-xvi.pdf', 'status_verifikasi' => 'menunggu', 'id_verifikator' => null, 'catatan_verifikasi' => null, 'created_at' => now(), 'updated_at' => now()],
            // [3] Eksternal - Peserta - Disetujui
            ['id_user' => 7, 'lomba_dari' => 'eksternal', 'tipe_prestasi' => 'peserta', 'id_lomba' => null, 'nama_lomba_eksternal' => 'Imagine Cup 2023 SEA', 'penyelenggara_eksternal' => 'Microsoft', 'tingkat' => 'internasional', 'peringkat' => 'Finalis', 'tanggal_diraih' => '2023-05-22', 'sertifikat_path' => 'sertifikat/eksternal/siti-imagine-cup.pdf', 'status_verifikasi' => 'disetujui', 'id_verifikator' => 1, 'catatan_verifikasi' => 'Sertifikat valid, diakui sebagai partisipasi tingkat internasional.', 'created_at' => now(), 'updated_at' => now()],
            // [4] Eksternal - Pemenang - Ditolak
            ['id_user' => 8, 'lomba_dari' => 'eksternal', 'tipe_prestasi' => 'pemenang', 'id_lomba' => null, 'nama_lomba_eksternal' => 'Lomba Esai Ilmiah Populer', 'penyelenggara_eksternal' => 'Blog Pribadi Dosen X', 'tingkat' => 'nasional', 'peringkat' => 'Juara Harapan 1', 'tanggal_diraih' => '2023-08-01', 'sertifikat_path' => 'sertifikat/eksternal/rina-esai.pdf', 'status_verifikasi' => 'ditolak', 'id_verifikator' => 1, 'catatan_verifikasi' => 'Penyelenggara tidak terverifikasi sebagai lembaga kredibel.', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
