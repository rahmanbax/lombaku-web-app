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
            ['id_tag' => 12, 'nama_tag' => 'Film Making', 'created_at' => now(), 'updated_at' => now()], // Untuk Videografi
            ['id_tag' => 13, 'nama_tag' => 'Photography', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 14, 'nama_tag' => 'Graphic Design', 'created_at' => now(), 'updated_at' => now()], // Untuk Desain, Poster
            ['id_tag' => 15, 'nama_tag' => 'Entrepreneurship', 'created_at' => now(), 'updated_at' => now()], // Untuk Bisnis
            ['id_tag' => 16, 'nama_tag' => 'Debate', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 17, 'nama_tag' => 'Essay Competition', 'created_at' => now(), 'updated_at' => now()], // Untuk Esai, Karya Tulis, Artikel
            ['id_tag' => 18, 'nama_tag' => 'Public Speaking', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 19, 'nama_tag' => 'Sports', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 20, 'nama_tag' => 'Music', 'created_at' => now(), 'updated_at' => now()], // Untuk Nasyid, Menyanyi
            ['id_tag' => 21, 'nama_tag' => 'Dance', 'created_at' => now(), 'updated_at' => now()], // Untuk Tari
            ['id_tag' => 22, 'nama_tag' => 'Culinary', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 23, 'nama_tag' => 'Finance', 'created_at' => now(), 'updated_at' => now()], // Untuk Keuangan
            ['id_tag' => 24, 'nama_tag' => 'Accounting', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 25, 'nama_tag' => 'Marketing', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 26, 'nama_tag' => 'IT', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 27, 'nama_tag' => 'Bisnis', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 28, 'nama_tag' => 'Desain', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 29, 'nama_tag' => 'Agama', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 30, 'nama_tag' => 'Kesehatan', 'created_at' => now(), 'updated_at' => now()],
            ['id_tag' => 31, 'nama_tag' => 'Seni', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =================================================================
        // 2. USERS (Data tidak diubah)
        // =================================================================
        $this->command->info('Seeding Users (Admins, Staff, Dosen, and Mahasiswa)...');
        DB::table('users')->insert([
            // Admins & Staff (ID 1-3)
            ['id_user' => 1, 'foto_profile' => 'foto_profile/default-profile.png', 'password' => Hash::make('password'), 'nama' => 'Kemahasiswaan', 'notelp' => '081100000001', 'email' => 'kemahasiswaan@kampus.ac.id', 'role' => 'kemahasiswaan', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 2, 'foto_profile' => 'foto_profile/default-profile.png', 'password' => Hash::make('password'), 'nama' => 'Admin Prodi Informatika', 'notelp' => '081100000002', 'email' => 'admin.if@kampus.ac.id', 'role' => 'admin_prodi', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 3, 'foto_profile' => 'foto_profile/default-profile.png', 'password' => Hash::make('password'), 'nama' => 'Admin Lombapedia', 'notelp' => '081100000003', 'email' => 'contact@lombapedia.com', 'role' => 'admin_lomba', 'created_at' => now(), 'updated_at' => now()],

            // Dosen (ID 4-5)
            ['id_user' => 4, 'foto_profile' => 'foto_profile/default-profile.png', 'password' => Hash::make('password'), 'nama' => 'Budi Santoso, M.Kom.', 'notelp' => '081211112222', 'email' => 'budi.s@kampus.ac.id', 'role' => 'dosen', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 5, 'foto_profile' => 'foto_profile/default-profile.png', 'password' => Hash::make('password'), 'nama' => 'Ana Lestari, M.Ds.', 'notelp' => '081233334444', 'email' => 'ana.l@kampus.ac.id', 'role' => 'dosen', 'created_at' => now(), 'updated_at' => now()],

            // Mahasiswa (ID 6-18)
            ['id_user' => 6, 'foto_profile' => 'foto_profile/photo-1654110455429-cf322b40a906.jpeg', 'password' => Hash::make('password'), 'nama' => 'Andi Hermawan', 'notelp' => '085711112222', 'email' => 'andi.h@student.kampus.ac.id', 'role' => 'mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 7, 'foto_profile' => 'foto_profile/photo-1438761681033-6461ffad8d80.jpeg', 'password' => Hash::make('password'), 'nama' => 'Siti Aminah', 'notelp' => '085733334444', 'email' => 'siti.a@student.kampus.ac.id', 'role' => 'mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 8, 'foto_profile' => 'foto_profile/photo-1438761681033-6461ffad8d80.jpeg', 'password' => Hash::make('password'), 'nama' => 'Rina Wijayanti', 'notelp' => '085755556666', 'email' => 'rina.w@student.kampus.ac.id', 'role' => 'mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 9, 'foto_profile' => 'foto_profile/photo-1654110455429-cf322b40a906.jpeg', 'password' => Hash::make('password'), 'nama' => 'Eko Prasetyo', 'notelp' => '085777778888', 'email' => 'eko.p@student.kampus.ac.id', 'role' => 'mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 10, 'foto_profile' => 'foto_profile/photo-1438761681033-6461ffad8d80.jpeg', 'password' => Hash::make('password'), 'nama' => 'Dewi Safitri', 'notelp' => '085799990000', 'email' => 'dewi.s@student.kampus.ac.id', 'role' => 'mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 11, 'foto_profile' => 'foto_profile/photo-1654110455429-cf322b40a906.jpeg', 'password' => Hash::make('password'), 'nama' => 'Fajar Nugroho', 'notelp' => '085710101010', 'email' => 'fajar.n@student.kampus.ac.id', 'role' => 'mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 12, 'foto_profile' => 'foto_profile/photo-1438761681033-6461ffad8d80.jpeg', 'password' => Hash::make('password'), 'nama' => 'Indah Permata', 'notelp' => '085720202020', 'email' => 'indah.p@student.kampus.ac.id', 'role' => 'mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 13, 'foto_profile' => 'foto_profile/photo-1654110455429-cf322b40a906.jpeg', 'password' => Hash::make('password'), 'nama' => 'Guntur Wibowo', 'notelp' => '085730303030', 'email' => 'guntur.w@student.kampus.ac.id', 'role' => 'mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 14, 'foto_profile' => 'foto_profile/photo-1438761681033-6461ffad8d80.jpeg', 'password' => Hash::make('password'), 'nama' => 'Lestari Handayani', 'notelp' => '085740404040', 'email' => 'lestari.h@student.kampus.ac.id', 'role' => 'mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 15, 'foto_profile' => 'foto_profile/photo-1654110455429-cf322b40a906.jpeg', 'password' => Hash::make('password'), 'nama' => 'Putra Maulana', 'notelp' => '085750505050', 'email' => 'putra.m@student.kampus.ac.id', 'role' => 'mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 16, 'foto_profile' => 'foto_profile/photo-1438761681033-6461ffad8d80.jpeg', 'password' => Hash::make('password'), 'nama' => 'Nadia Utami', 'notelp' => '085760606060', 'email' => 'nadia.u@student.kampus.ac.id', 'role' => 'mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 17, 'foto_profile' => 'foto_profile/photo-1654110455429-cf322b40a906.jpeg', 'password' => Hash::make('password'), 'nama' => 'Risky Aditya', 'notelp' => '085770707070', 'email' => 'risky.a@student.kampus.ac.id', 'role' => 'mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 18, 'foto_profile' => 'foto_profile/photo-1438761681033-6461ffad8d80.jpeg', 'password' => Hash::make('password'), 'nama' => 'Sri Wahyuni', 'notelp' => '085780808080', 'email' => 'sri.w@student.kampus.ac.id', 'role' => 'mahasiswa', 'created_at' => now(), 'updated_at' => now()],

            // Admin Lomba (ID 19 - 28)
            ['id_user' => 19, 'foto_profile' => 'foto_profile/ariq-66.png', 'password' => Hash::make('password'), 'nama' => 'Himadira Telkom University', 'notelp' => '081219191919', 'email' => 'secomp@lomba.test', 'role' => 'admin_lomba', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 20, 'foto_profile' => 'foto_profile/udinus-14.png', 'password' => Hash::make('password'), 'nama' => 'Udinus', 'notelp' => '081220202020', 'email' => 'udinus@lomba.test', 'role' => 'admin_lomba', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 21, 'foto_profile' => 'foto_profile/sevenpreneur-74.png', 'password' => Hash::make('password'), 'nama' => 'Sevenpreneur', 'notelp' => '081221212121', 'email' => 'sevenpreneur@lomba.test', 'role' => 'admin_lomba', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 22, 'foto_profile' => 'foto_profile/fiddo-79.jpeg', 'password' => Hash::make('password'), 'nama' => 'XLSMART', 'notelp' => '081222222222', 'email' => 'xlsmart@lomba.test', 'role' => 'admin_lomba', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 23, 'foto_profile' => 'foto_profile/abid-al-hafizh-72.png', 'password' => Hash::make('password'), 'nama' => 'Kubivent', 'notelp' => '081223232323', 'email' => 'kubivent@lomba.test', 'role' => 'admin_lomba', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 24, 'foto_profile' => 'foto_profile/komunitas-nasyid-nusantara-jawabarat--nn-jabar--76.png', 'password' => Hash::make('password'), 'nama' => 'Panitia Pasanggiri Nasyid', 'notelp' => '081224242424', 'email' => 'nasyid@lomba.test', 'role' => 'admin_lomba', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 25, 'foto_profile' => 'foto_profile/lembaga-kerohanian-islam-lki-fakultas-kedokteran-universitas-brawijaya-9.png', 'password' => Hash::make('password'), 'nama' => 'LKI FK UB', 'notelp' => '081225252525', 'email' => 'imscobi@lomba.test', 'role' => 'admin_lomba', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 26, 'foto_profile' => 'foto_profile/arbiventaubmo--45.jpeg', 'password' => Hash::make('password'), 'nama' => 'Airlangga University Bidikmisi/KIP-K Organization (AUBMO)', 'notelp' => '081226262626', 'email' => 'aubmo.unair@lomba.test', 'role' => 'admin_lomba', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 27, 'foto_profile' => 'foto_profile/otoritas-jasa-keuangan-ojk-90.png', 'password' => Hash::make('password'), 'nama' => 'Otoritas Jasa Keuangan (OJK)', 'notelp' => '081227272727', 'email' => 'ojk@lomba.test', 'role' => 'admin_lomba', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 28, 'foto_profile' => 'foto_profile/himanika-universitas-muhammadiyah-magelang-21.png', 'password' => Hash::make('password'), 'nama' => 'HIMANIKA UNIMMA', 'notelp' => '081228282828', 'email' => 'monalesa@lomba.test', 'role' => 'admin_lomba', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =================================================================
        // 3. PROFILES (Data tidak diubah)
        // =================================================================
        $this->command->info('Seeding Profiles (Mahasiswa, Dosen, Admin Lomba)...');
        DB::table('profil_mahasiswa')->insert([
            ['id_user' => 6, 'id_program_studi' => 1, 'nim' => 11223301, 'tanggal_lahir' => '2002-05-10', 'jenis_kelamin' => 'Laki-laki', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 7, 'id_program_studi' => 1, 'nim' => 11223302, 'tanggal_lahir' => '2002-08-15', 'jenis_kelamin' => 'Perempuan', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 8, 'id_program_studi' => 7, 'nim' => 77221101, 'tanggal_lahir' => '2003-01-20', 'jenis_kelamin' => 'Perempuan', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 9, 'id_program_studi' => 2, 'nim' => 22223301, 'tanggal_lahir' => '2002-11-30', 'jenis_kelamin' => 'Laki-laki', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 10, 'id_program_studi' => 2, 'nim' => 22223302, 'tanggal_lahir' => '2003-03-25', 'jenis_kelamin' => 'Perempuan', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 11, 'id_program_studi' => 3, 'nim' => 33221101, 'tanggal_lahir' => '2002-07-19', 'jenis_kelamin' => 'Laki-laki', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 12, 'id_program_studi' => 4, 'nim' => 44221101, 'tanggal_lahir' => '2003-02-14', 'jenis_kelamin' => 'Perempuan', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 13, 'id_program_studi' => 5, 'nim' => 55221101, 'tanggal_lahir' => '2002-09-09', 'jenis_kelamin' => 'Laki-laki', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 14, 'id_program_studi' => 6, 'nim' => 66221101, 'tanggal_lahir' => '2003-04-01', 'jenis_kelamin' => 'Perempuan', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 15, 'id_program_studi' => 7, 'nim' => 77221102, 'tanggal_lahir' => '2002-12-12', 'jenis_kelamin' => 'Laki-laki', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 16, 'id_program_studi' => 8, 'nim' => 88221101, 'tanggal_lahir' => '2003-06-06', 'jenis_kelamin' => 'Perempuan', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 17, 'id_program_studi' => 9, 'nim' => 99221101, 'tanggal_lahir' => '2002-10-20', 'jenis_kelamin' => 'Laki-laki', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 18, 'id_program_studi' => 1, 'nim' => 11223303, 'tanggal_lahir' => '2003-08-17', 'jenis_kelamin' => 'Perempuan', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('profil_dosen')->insert([
            ['id_user' => 4, 'id_program_studi' => 1, 'nip' => 99887701, 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 5, 'id_program_studi' => 7, 'nip' => 99887702, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('profil_admin_lomba')->insert([
            ['id_user' => 3, 'alamat' => 'Jl. Teknologi No. 1, Jakarta', 'jenis_organisasi' => 'Perusahaan', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 19, 'alamat' => 'Kampus Politeknik Negeri Batam', 'jenis_organisasi' => 'Mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 20, 'alamat' => 'Jl. Imam Bonjol No. 207, Semarang', 'jenis_organisasi' => 'Mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 21, 'alamat' => 'Kuningan City, Jakarta Selatan', 'jenis_organisasi' => 'Perusahaan', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 22, 'alamat' => 'Online Event Organizer', 'jenis_organisasi' => 'Perusahaan', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 23, 'alamat' => 'Online Event Organizer', 'jenis_organisasi' => 'Lainnya', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 24, 'alamat' => 'Jl. Cibodas Raya No. 3, Bandung', 'jenis_organisasi' => 'Lainnya', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 25, 'alamat' => 'Fakultas Kedokteran', 'jenis_organisasi' => 'Mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 26, 'alamat' => 'Kampus C, Universitas Airlangga', 'jenis_organisasi' => 'Mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 27, 'alamat' => 'Gedung Wisma Mulia 2, Jakarta', 'jenis_organisasi' => 'Perusahaan', 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 28, 'alamat' => 'Magelang, Jawa Tengah', 'jenis_organisasi' => 'Lainnya', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =================================================================
        // 4. LOMBA (DATA BARU SESUAI PERMINTAAN)
        // =================================================================
        $this->command->info('Seeding Lomba with new data...');
        DB::table('lomba')->insert([
            // [ID 1] SECOMP25 - Berlangsung
            [
                'id_lomba' => 1,
                'foto_lomba' => 'foto_lomba/secomp25-26.png',
                'nama_lomba' => 'SECOMP25',
                'deskripsi' => '📢 [SOFTWARE ENGINEER COMPETITION 2025]📢

            "Digital Harmony for Society 5.0"

            ✨ Haloo, Sobat IT💻 ✨

            Dengan adanya kesempatan ini, kami mengadakan Perlombaan IT yang bertujuan untuk mengasah kreativitas, inovasi, dan kemampuan problem-solving di bidang teknologi informasi.

            Terbuka untuk seluruh mahasiswa di Indonesia!🤩

            🏆Adapun bidang lomba yang akan dipertandingkan meliputi:
            🎨UI/UX Design Competition
            💻Website Programming
            ⚡Competitive Programming

            🗓️ Pendaftaran: 1Juni - 21Juli 2025

            🏆 Benefits🤔: 
            - Uang Pembinaan 
            - Merchandise
            - Sertifikat Nasional
            - Pengalaman
            - Relasi

            Tunggu apalagi, ayo segera daftarkan timmu!

            📱Contact Person:
            📞: wa.me/6285155226325 (Ariq) 

            Salam,
            Panitia Pelaksana',
                'deskripsi_pengumpulan' => 'Link Drive berisi proposal dan video demo', // <-- INI PERBAIKANNYA
                'jenis_lomba' => 'kelompok',
                'lokasi' => 'online',
                'lokasi_offline' => null,
                'tingkat' => 'internal',
                'status' => 'berlangsung',
                'alasan_penolakan' => null,
                'tanggal_akhir_registrasi' => '2025-07-21',
                'tanggal_mulai_lomba' => '2025-06-01',
                'tanggal_selesai_lomba' => '2025-07-21',
                'penyelenggara' => null,
                'id_pembuat' => 19,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // [ID 2] HEALPIC 2025 - Berlangsung
            ['id_lomba' => 2, 'foto_lomba' => 'foto_lomba/healpic-2025-89.jpeg', 'nama_lomba' => 'HEALPIC 2025: Health Photography International Contest', 'deskripsi' => '📸 HEALPIC 2025: Health Photography International Contest by Udinus 📸

            Are you ready to make your mark on a global stage?

            Unleash your creativity and let your lens tell stories that matter. Capture the beauty, complexity, and connection between health, humanity, and nature. Show off your photography skills and win exciting prizes while making a meaningful impact on public health awareness!

            📸 Theme: "Health, Humanity, and Nature in Frame"  
            Subthemes:  
            1.⁠ ⁠Health and Society  
            2.⁠ ⁠Nature and Environment

            ⏳ Timeline  
            •⁠  ⁠Registration: June 8 – August 16, 2025  
            •⁠  ⁠Finalists Announcement: August 23, 2025  
            •⁠  ⁠Final Competition: September 11, 2025  
            •⁠  ⁠Awarding Ceremony: September 16, 2025  

            📞 Contact Person  
            •⁠  ⁠Nugraheni: Https://wa.me/6288238053977
            •⁠  ⁠Nadia: Https://wa.me/6285801778594
            ', 'deskripsi_pengumpulan' => 'Submit your photo according to the contest guidelines.', 'jenis_lomba' => 'individu', 'lokasi' => 'online', 'lokasi_offline' => null, 'tingkat' => 'internasional', 'status' => 'berlangsung', 'alasan_penolakan' => null, 'tanggal_akhir_registrasi' => '2025-08-16', 'tanggal_mulai_lomba' => '2025-07-01', 'tanggal_selesai_lomba' => '2025-09-16', 'penyelenggara' => null, 'id_pembuat' => 20, 'created_at' => now(), 'updated_at' => now()],

            // [ID 3] Sevenpreneur Business Plan Competition - Berlangsung
            ['id_lomba' => 3, 'foto_lomba' => 'foto_lomba/sevenpreneur-business-plan-competition-82.jpeg', 'nama_lomba' => 'Sevenpreneur Business Plan Competition 2025', 'deskripsi' => "✨ Sevenpreneur Business Plan Competition 2025 ✨
            Part of RE:START Conference 2025

            Punya ide bisnis keren? Ini saatnya buat tampil di panggung utama depan expert nasional dan ribuan audiens!

            What You'll Get:
            - Prizes worth millions of Rupiah
            - Exclusive internship opportunity at Sevenpreneur
            - VIP Ticket to RE:START Conference 2025 for the Winner
            - Full scholarship for SBBP Batch 7 Intensive Class
            - Direct investment opportunities
            - Official E-Certificate
            - Live pitch in front of top business experts
            - Exclusive networking dinner with professionals
            - Special front-row seat near the guest speaker
            - FREE official merchandise!

            Timeline:
            Daftar & submit proposal: 9 Juli 2025
            Grand Final: 26 Juli 2025 (📍Kuningan City Grand Ballroom, Jakarta Selatan)

            📚 Guidebook: https://bit.ly/Guidebook7PBPC

            Siap jadi entrepreneur masa depan? Yuk join!

            Contact Person (WhatsApp):
            - Dellyza - +6281384565433", 'deskripsi_pengumpulan' => 'Link proposal anda', 'jenis_lomba' => 'kelompok', 'lokasi' => 'offline', 'lokasi_offline' => 'Kuningan City Grand Ballroom, Jakarta Selatan', 'tingkat' => 'nasional', 'status' => 'berlangsung', 'alasan_penolakan' => null, 'tanggal_akhir_registrasi' => '2025-07-09', 'tanggal_mulai_lomba' => '2025-06-09', 'tanggal_selesai_lomba' => '2025-07-26', 'penyelenggara' => null, 'id_pembuat' => 21, 'created_at' => now(), 'updated_at' => now()],

            // [ID 4] Kompetisi Desain Ilustrasi XLSMART 2025 - Disetujui (belum mulai)
            ['id_lomba' => 4, 'foto_lomba' => 'foto_lomba/kompetisi-desain-ilustrasi-xlsmart-2025-4.png', 'nama_lomba' => 'Kompetisi Desain Ilustrasi XLSMART 2025', 'deskripsi' => '🎨🤖 KOMPETISI DESAIN NASIONAL XLSMART 2025

            📢 Tema : “Ekspresi Digital untuk Indonesia”

            Saatnya kamu tunjukkan ekspresi kreatifmu lewat karya desain futuristik!
            🧑‍🎨 Terbuka untuk umum!
            Pendaftaran melalui = https://bit.ly/kompetisidesainxlsmart
            🖼 Kirim 1 karya original kamu (AI/PSD, .CDR, 300 DPI, CMYK)
            📆 Jadwal Kompetisi:
            ▪️ 1 Juli – 10 Agustus: Pendaftaran & Pengumpulan
            ▪️ 15 Agustus Seleksi & Penjurian
            ▪️ 22 Agustus: Pengumuman Pemenang

            👨‍⚖️ Juri: Dodo Argo Gumilar

            🎁 TOTAL HADIAH: $1000 USD 💸

            * Smartfren Home Router
            * Smart Watch
            * Piala (10 Terbaik)
            * E-sertifikat & Kartu Perdana 9GB untuk semua peserta!

            📸 Jangan lupa upload karyamu di Instagram & tulis caption-nya
            Gunakan tagar: #XLSmartUntukIndonesia #KompetisiDesainXLSmart
            * Tag 3 teman kamu buat ikutan juga!

            📲 Follow:
            @smartfrenworld @XLSMART
            Ayo buktikan ekspresi digitalmu! 🚀✨
            ', 'deskripsi_pengumpulan' => 'Pendaftaran dan pengumpulan karya melalui: https://bit.ly/kompetisidesainxlsmart', 'jenis_lomba' => 'individu', 'lokasi' => 'online', 'lokasi_offline' => null, 'tingkat' => 'nasional', 'status' => 'disetujui', 'alasan_penolakan' => null, 'tanggal_akhir_registrasi' => '2025-08-10', 'tanggal_mulai_lomba' => '2025-07-01', 'tanggal_selesai_lomba' => '2025-08-22', 'penyelenggara' => null, 'id_pembuat' => 22, 'created_at' => now(), 'updated_at' => now()],

            // [ID 5] Cita Rasa Kita - Belum Disetujui
            ['id_lomba' => 5, 'foto_lomba' => 'foto_lomba/cita-rasa-kita-kreativitas-di-setiap-gigitan-9.png', 'nama_lomba' => 'Cita Rasa Kita: Kreativitas di Setiap Gigitan', 'deskripsi' => '📣 "Cita Rasa Kita: Kreativitas di Setiap Gigitan"

            Lomba poster nasional yang harus banget kamu ikuti! Tinggal beberapa hari lagi, jangan sampai kelewatan kesempatan ini!

            💡 Kenapa kamu harus daftar sekarang?
            ✅ Hadiah menarik: Voucher + merchandise eksklusif.
            ✅ E-Certificate untuk semua peserta (cocok buat CV & portofolio).
            ✅ Hadiah uang tunai!

            🗓 Pendaftaran Ditutup: 7 Juli 2025

            📥 Cara Daftar:
            1️⃣ Klik link di bio kami.
            2️⃣ Isi form pendaftaran + upload bukti pembayaran.
            3️⃣ Mulai persiapkan ide terbaikmu!

            🚨 Slot hampir penuh! Daftar sekarang sebelum terlambat!

            📌 Follow & tag temanmu di @Kubivent_ untuk info lebih lanjut.
            ✨ Tunjukkan kreativitasmu dan jadi bagian dari kompetisi ini!
            ', 'deskripsi_pengumpulan' => 'Upload karya melalui form pendaftaran.', 'jenis_lomba' => 'individu', 'lokasi' => 'online', 'lokasi_offline' => null, 'tingkat' => 'nasional', 'status' => 'belum disetujui', 'alasan_penolakan' => null, 'tanggal_akhir_registrasi' => '2025-07-07', 'tanggal_mulai_lomba' => '2025-06-25', 'tanggal_selesai_lomba' => '2025-07-07', 'penyelenggara' => null, 'id_pembuat' => 23, 'created_at' => now(), 'updated_at' => now()],

            // [ID 6] Pasanggiri Nasyid Jawa Barat 2025 - Ditolak
            ['id_lomba' => 6, 'foto_lomba' => 'foto_lomba/pasanggiri-nasyid-jawabarat-2025-9.jpeg', 'nama_lomba' => 'Pasanggiri Nasyid Jawa Barat 2025', 'deskripsi' => '🎶 Pasanggiri Nasyid 2025 Audisi Bandung 🎤

            Panggilan untuk para munsyid di Kota Bandung, Cimahi, KBB dan sekitarnya! Jangan lewatkan kesempatan emas untuk menunjukkan bakat terbaikmu di Audisi Pasanggiri Nasyid 2025! 🌟

            🗓️ Tanggal: Sabtu, 12 Juli 2025
            🕘 Waktu: 09.00 WIB - Selesai
            📍 Tempat: Kamikamu Coffee, Jl. Cibodas Raya No. 3, Antapani, Kota Bandung (Masuk dari gerbang PDAM Cibodas)

            Syarat Umum:
            - Pria Wanita beragama Islam
            - Membawakan 2 lagu wajib (1 lagu wajib dari Panji Sakti)
            - Berdomisili di Jawa Barat

            Hadiah Audisi:
            Golden Ticket untuk babak interview
            Uang Pembinaan & Sertifikat

            Cara Mendaftar:
            - Klik link atau scan barcode yang tersedia
            - Lakukan pembayaran sesuai kategori
            - Gabung grup peserta untuk mendapatkan petunjuk teknis audisi selanjutnya

            Info Pendaftaran:
            📱 Dhei: +62 882-2248-7379
            📱 Arifin: +62 882-2218-9008

            Jangan sampai ketinggalan! Daftarkan diri kamu sekarang dan buktikan bakat nasyidmu! 🎤✨.', 'deskripsi_pengumpulan' => 'Tampil langsung saat audisi.', 'jenis_lomba' => 'individu', 'lokasi' => 'offline', 'lokasi_offline' => 'Kamikamu Coffee, Bandung', 'tingkat' => 'nasional', 'status' => 'ditolak', 'alasan_penolakan' => 'Tingkat kompetisi regional (Jawa Barat), belum dapat dikategorikan sebagai tingkat Nasional.', 'tanggal_akhir_registrasi' => '2025-07-10', 'tanggal_mulai_lomba' => '2025-06-28', 'tanggal_selesai_lomba' => '2025-07-12', 'penyelenggara' => null, 'id_pembuat' => 24, 'created_at' => now(), 'updated_at' => now()],

            // [ID 7] IMSCOBI 2025 - Selesai (contoh data lampau)
            ['id_lomba' => 7, 'foto_lomba' => 'foto_lomba/imscobi-2025-4.png', 'nama_lomba' => 'IMSCOBI 2025', 'deskripsi' => '🌟 [ OPEN REGISTRATION IMSCOBI 2025 ] 🌟

            Assalamu’alaikum, haloo mahasiswa muslim se-Indonesia! 🧑🏻‍⚕🧕🏻

            Kabar baik datang nih! IMSCOBI kembali hadir di tahun 2025! 🤩
            IMSCOBI (Islamic Medicine Scientific Competition and Seminar Collaboration) tahun ini mengangkat tema:

            ✨ “Discovering More About Islam: Islamic Interventions in Breaking The Chain of Endocrinological Disease” ✨

            Menarik banget, kan? Jadi, tunggu apa lagi? Saatnya kamu dan timmu bergabung dalam IMSCOBI 2025!
            Lewat ajang ini, kamu bisa menyalurkan ide, riset, dan kontribusi nyata demi mewujudkan dunia kesehatan Indonesia yang lebih Islami dan solutif. 🧠📖

            📌 Info lebih lanjut panduan lomba dapat diakses melalui link berikut:
            🔗 [https://linktr.ee/imscobi2025]

            💡 Jangan lewatkan kesempatan emas ini untuk berkarya, belajar, dan berdakwah melalui ilmu. Jadikan IMSCOBI 2025 sebagai langkah awalmu dalam menebar manfaat seluas-luasnya! 💫

            “The best among you are those who bring the greatest benefit to others.” — Prophet Muhammad ﷺ (Narrated by al-Tabarani) 🌍

            Jangan lupa terus pantau linimasa kami dalam: 
            📱IG: @imscobi2025
            📩 Email: imscobi2025@gmail.com

            ☎ Contact Person:
            👳🏻‍♂ M. Assidiq Herbowo (081366579899 / massiddiqherbowo19)
            🧕🏻 Tamara Adn Setiawan (082312392753 / 110505tam)
            ', 'deskripsi_pengumpulan' => 'Informasi pengumpulan dapat diakses melalui linktr.ee/imscobi2025', 'jenis_lomba' => 'kelompok', 'lokasi' => 'offline', 'lokasi_offline' => 'Lokasi Acara IMSCOBI', 'tingkat' => 'nasional', 'status' => 'selesai', 'alasan_penolakan' => null, 'tanggal_akhir_registrasi' => Carbon::now()->subMonths(2)->day(23), 'tanggal_mulai_lomba' => Carbon::now()->subMonths(3)->day(29), 'tanggal_selesai_lomba' => Carbon::now()->subMonths(2)->day(23), 'penyelenggara' => null, 'id_pembuat' => 25, 'created_at' => now(), 'updated_at' => now()],

            // [ID 8] KIP-K ART FESTIVAL - Berlangsung
            ['id_lomba' => 8, 'foto_lomba' => 'foto_lomba/kipk-art-festival--51.jpeg', 'nama_lomba' => 'KIP-K ART FESTIVAL 2025', 'deskripsi' => '‼️ OPEN SUBMISSION ‼️
            KIP-K ART FESTIVAL 2025 🎭✨

            Halo, teman-teman mahasiswa seluruh Indonesia! 🖐🏻

            Airlangga University Bidikmisi/KIP-K Organization (AUBMO) sedang mengadakan KIP-K ART FESTIVAL 2025 🏆✨
            Sebuah kompetisi nasional dengan tema “Harmoni Kreasi Generasi Masa Kini”

            🏅 BIDANG LOMBA
            - Tari 💃🏻
            - Menyanyi 🎙️
            - Videografi 📹 

            📆 TIMELINE KEGIATAN
            - Pendaftaran: 
            Batch 1: 1–15 Juli 2025
            Batch 2: 16–28 Juli 2025
            - Pengumpulan Karya: 1–28 Juli 2025
            - Penjurian: 29–30 Juli 2025
            - Pengumuman: 2 Agustus 2025

            WAJIB MEMBACA GUIDEBOOK‼️
            https://drive.google.com/file/d/13KqbfoRjtRBy5tgaXyW1ATOKOzK7qbYk/view?usp=drivesdk

            Tunggu apa lagi, segera persiapkan dan tunjukkan karya terbaikmu dalam ajang KIP-K Art Festival 2025! 🔥
            More Information
            📱: wa.me/62895337422031 (Dinar)
                    wa.me/6285859751019 (Rosa)
            📸: @arbiventaubmo
                    @bidikmisikipkunair

            ╞•════ ༶ ❅ ༶ ════•╡', 'deskripsi_pengumpulan' => 'Pengumpulan karya sesuai dengan guidebook.', 'jenis_lomba' => 'individu', 'lokasi' => 'online', 'lokasi_offline' => null, 'tingkat' => 'nasional', 'status' => 'berlangsung', 'alasan_penolakan' => null, 'tanggal_akhir_registrasi' => '2025-07-28', 'tanggal_mulai_lomba' => '2025-07-01', 'tanggal_selesai_lomba' => '2025-08-02', 'penyelenggara' => null, 'id_pembuat' => 25, 'created_at' => now(), 'updated_at' => now()],

            // [ID 9] Innovation Paper Competition - Berlangsung
            ['id_lomba' => 9, 'foto_lomba' => 'foto_lomba/innovation-paper-competition-38.jpeg', 'nama_lomba' => 'Innovation Paper Competition', 'deskripsi' => 'Otoritas Jasa Keuangan proudly present :
            ✨ Innovation Paper Competition ✨️

            📢Hai Mahasiswa se-Indonesia, yuk ikuti kompetisinya! Pendaftaran GRATISSS!!!🤩🥳

            Menangkan hadiah dengan total puluhan juta rupiah & berkesempatan hadir dalam Risk & Governance Summit (RGS) 2025, bertemu banyak Pimpinan Industri Jasa Keuangan, Ekonom, Praktisi dan Pakar GRC dari Mancanegara 

            📌 TEMA 
            "Tata Kelola untuk Mengakselerasi Pertumbuhan Ekonomi yang Berkelanjutan"

            🔖SUB-TEMA
            1. Tata Kelola dalam Penguatan Ketahanan Pangan Nasional
            2. Pencegahan Fraud dan Pencucian Uang di Sektor Keuangan Digital
            3. Regulatory Technology ( RegTech ) dalam Mendukung Tata Kelola yang Baik di Sektor Jasa Keuangan
            4. Inovasi Peningkatan Kapabilitas Sumber Daya Manusia (SDM) Fungsi Governance, Risk, and Compliance (GRC)

            🗓️ TIMELINE
            Pendaftaran dan Pengumpulan Paper: 1 Juni - 15 Juli 2025
            Seleksi Administratif dan Pengumuman Finalis: 16 Juli - 1 Agustus 2025
            Presentasi Finalis: 7 Agustus 2025
            Pengumuman Pemenang: 19 Agustus 2025

            🌐 MORE INFORMATION
            bit.ly/OJK-RGS-InnovationPaperCompetition

            Pantau terus website kami untuk informasi-informasi selanjutnya!🙌

            ☎️Narahubung:
            Fitri: 085255041340
            Satriyo: 081294495000
            ', 'deskripsi_pengumpulan' => 'Pengumpulan paper melalui: bit.ly/OJK-RGS-InnovationPaperCompetition', 'jenis_lomba' => 'individu', 'lokasi' => 'online', 'lokasi_offline' => null, 'tingkat' => 'nasional', 'status' => 'berlangsung', 'alasan_penolakan' => null, 'tanggal_akhir_registrasi' => '2025-07-15', 'tanggal_mulai_lomba' => '2025-06-01', 'tanggal_selesai_lomba' => '2025-08-19', 'penyelenggara' => null, 'id_pembuat' => 26, 'created_at' => now(), 'updated_at' => now()],

            // [ID 10] MONALESA VOL.4 - Berlangsung
            ['id_lomba' => 10, 'foto_lomba' => 'foto_lomba/monalesa-vol4-84.jpeg', 'nama_lomba' => 'MONALESA VOL.4', 'deskripsi' => '📢 MONALESA IS CALLING!
            Tahun ini, MONALESA VOL.4 hadir dengan gebrakan baru!
            Kami menantang kamu — para generasi muda kreatif — untuk menunjukkan bakat dan kepedulianmu terhadap budaya lewat 3 kompetisi besar yang sayang banget buat dilewatkan! 🌟

            🎯 PR Campaign Competition
            Punya ide brilian buat kampanye pelestarian budaya? Tuangkan gagasanmu dalam strategi komunikasi yang kreatif, berdampak, dan penuh makna. Jadilah komunikator budaya yang bisa menyuarakan nilai-nilai lokal dengan cara unikmu!

            📸 Lomba Fotografi – Mlaku Magelang
            Kaki melangkah, kamera merekam. Tangkap keindahan dan cerita dari sudut-sudut kota Magelang yang kaya akan sejarah, budaya, dan kehidupan. Lewat satu bidikan, kamu bisa menyuarakan sejuta pesan!

            🎤 News Anchor Competition
            Saatnya kamu bersuara! Bukan hanya membaca naskah, tapi menyampaikan berita dengan artikulasi, etika, dan pesona yang menginspirasi. Tunjukkan skill jurnalistikmu dan buktikan kalau kamu layak jadi wajah media masa depan!

            ✨ Dari kamu yang suka menulis, memotret, hingga berbicara di depan kamera — MONALESA VOL.4 adalah panggungmu untuk berkarya sekaligus berkontribusi.
            Karena setiap langkah, suara, dan ide kita punya peran dalam menjaga warisan budaya.

            🎁 Menangkan hadiah menarik berupa uang pembinaan, sertifikat, dan goodie bag untuk setiap kategori lomba!

            📆 Cek timeline masing-masing lomba & segera daftar sebelum terlambat!
            📍 Info lengkap bisa kamu dapatkan langsung dari contact person kami.

            Jangan cuma jadi penonton—jadi pelaku perubahan lewat karya yang berdampak.
            ', 'deskripsi_pengumpulan' => 'Pengumpulan karya sesuai dengan kategori lomba masing-masing.', 'jenis_lomba' => 'individu', 'lokasi' => 'offline', 'lokasi_offline' => 'Magelang', 'tingkat' => 'nasional', 'status' => 'berlangsung', 'alasan_penolakan' => null, 'tanggal_akhir_registrasi' => '2025-07-20', 'tanggal_mulai_lomba' => '2025-06-14', 'tanggal_selesai_lomba' => '2025-07-20', 'penyelenggara' => null, 'id_pembuat' => 27, 'created_at' => now(), 'updated_at' => now()],
        ]);


        // =================================================================
        // 5. TAHAP_LOMBA (DATA BARU SESUAI LOMBA)
        // =================================================================
        $this->command->info('Seeding Tahap Lomba...');
        DB::table('tahap_lomba')->insert([
            // Lomba 1: SECOMP25
            ['id_lomba' => 1, 'nama_tahap' => 'Pendaftaran & Pengumpulan', 'urutan' => 1, 'deskripsi' => 'Peserta mendaftar dan mengumpulkan karya sesuai bidang lomba.', 'created_at' => now(), 'updated_at' => now()],
            ['id_lomba' => 1, 'nama_tahap' => 'Penjurian Final', 'urutan' => 2, 'deskripsi' => 'Presentasi final di depan juri.', 'created_at' => now(), 'updated_at' => now()],
            // Lomba 2: HEALPIC 2025
            ['id_lomba' => 2, 'nama_tahap' => 'Registration & Submission', 'urutan' => 1, 'deskripsi' => 'Registration and photo submission period.', 'created_at' => now(), 'updated_at' => now()],
            ['id_lomba' => 2, 'nama_tahap' => 'Finalists Announcement', 'urutan' => 2, 'deskripsi' => 'Announcement of the selected finalists.', 'created_at' => now(), 'updated_at' => now()],
            ['id_lomba' => 2, 'nama_tahap' => 'Awarding Ceremony', 'urutan' => 3, 'deskripsi' => 'Winner announcement and awarding.', 'created_at' => now(), 'updated_at' => now()],
            // Lomba 3: Sevenpreneur
            ['id_lomba' => 3, 'nama_tahap' => 'Pendaftaran & Submit Proposal', 'urutan' => 1, 'deskripsi' => 'Peserta mendaftar dan mengirimkan proposal bisnis.', 'created_at' => now(), 'updated_at' => now()],
            ['id_lomba' => 3, 'nama_tahap' => 'Grand Final Pitching', 'urutan' => 2, 'deskripsi' => 'Finalis melakukan pitching di depan para juri.', 'created_at' => now(), 'updated_at' => now()],
            // Lomba 9: OJK Paper Competition
            ['id_lomba' => 9, 'nama_tahap' => 'Pendaftaran dan Pengumpulan Paper', 'urutan' => 1, 'deskripsi' => 'Periode pendaftaran dan pengumpulan paper.', 'created_at' => now(), 'updated_at' => now()],
            ['id_lomba' => 9, 'nama_tahap' => 'Presentasi Finalis', 'urutan' => 2, 'deskripsi' => 'Finalis mempresentasikan papernya.', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =================================================================
        // 6. DAFTAR_TAG (DATA BARU SESUAI LOMBA)
        // =================================================================
        $this->command->info('Seeding Daftar Tag...');
        DB::table('daftar_tag')->insert([
            // Lomba 1: SECOMP25
            ['id_lomba' => 1, 'id_tag' => 26, 'created_at' => now(), 'updated_at' => now()], // IT
            ['id_lomba' => 1, 'id_tag' => 2, 'created_at' => now(), 'updated_at' => now()],  // UI/UX
            ['id_lomba' => 1, 'id_tag' => 1, 'created_at' => now(), 'updated_at' => now()],  // Programming
            // Lomba 2: HEALPIC 2025
            ['id_lomba' => 2, 'id_tag' => 13, 'created_at' => now(), 'updated_at' => now()], // Photography
            ['id_lomba' => 2, 'id_tag' => 30, 'created_at' => now(), 'updated_at' => now()], // Kesehatan
            // Lomba 3: Sevenpreneur
            ['id_lomba' => 3, 'id_tag' => 27, 'created_at' => now(), 'updated_at' => now()], // Bisnis
            ['id_lomba' => 3, 'id_tag' => 15, 'created_at' => now(), 'updated_at' => now()], // Entrepreneurship
            // Lomba 4: XLSMART
            ['id_lomba' => 4, 'id_tag' => 28, 'created_at' => now(), 'updated_at' => now()], // Desain
            ['id_lomba' => 4, 'id_tag' => 14, 'created_at' => now(), 'updated_at' => now()], // Graphic Design
            // Lomba 5: Cita Rasa Kita
            ['id_lomba' => 5, 'id_tag' => 28, 'created_at' => now(), 'updated_at' => now()], // Desain
            ['id_lomba' => 5, 'id_tag' => 22, 'created_at' => now(), 'updated_at' => now()], // Culinary
            // Lomba 6: Pasanggiri Nasyid
            ['id_lomba' => 6, 'id_tag' => 20, 'created_at' => now(), 'updated_at' => now()], // Music
            ['id_lomba' => 6, 'id_tag' => 29, 'created_at' => now(), 'updated_at' => now()], // Agama
            // Lomba 7: IMSCOBI 2025
            ['id_lomba' => 7, 'id_tag' => 28, 'created_at' => now(), 'updated_at' => now()], // Desain
            ['id_lomba' => 7, 'id_tag' => 17, 'created_at' => now(), 'updated_at' => now()], // Essay Competition
            ['id_lomba' => 7, 'id_tag' => 12, 'created_at' => now(), 'updated_at' => now()], // Film Making (Videografi)
            ['id_lomba' => 7, 'id_tag' => 29, 'created_at' => now(), 'updated_at' => now()], // Agama
            ['id_lomba' => 7, 'id_tag' => 30, 'created_at' => now(), 'updated_at' => now()], // Kesehatan
            // Lomba 8: KIP-K ART FESTIVAL
            ['id_lomba' => 8, 'id_tag' => 20, 'created_at' => now(), 'updated_at' => now()], // Music
            ['id_lomba' => 8, 'id_tag' => 31, 'created_at' => now(), 'updated_at' => now()], // Seni
            ['id_lomba' => 8, 'id_tag' => 12, 'created_at' => now(), 'updated_at' => now()], // Film Making (Videografi)
            ['id_lomba' => 8, 'id_tag' => 21, 'created_at' => now(), 'updated_at' => now()], // Dance
            // Lomba 9: Innovation Paper Competition
            ['id_lomba' => 9, 'id_tag' => 17, 'created_at' => now(), 'updated_at' => now()], // Essay Competition
            ['id_lomba' => 9, 'id_tag' => 23, 'created_at' => now(), 'updated_at' => now()], // Finance
            // Lomba 10: MONALESA VOL.4
            ['id_lomba' => 10, 'id_tag' => 13, 'created_at' => now(), 'updated_at' => now()], // Photography
            ['id_lomba' => 10, 'id_tag' => 18, 'created_at' => now(), 'updated_at' => now()], // Public Speaking
        ]);

        // =================================================================
        // 7. TIM & MEMBER_TIM (Data tidak diubah)
        // =================================================================
        $this->command->info('Seeding Tim dan Member...');
        DB::table('tim')->insert([
            ['id_tim' => 1, 'nama_tim' => 'Tim Koding Keren', 'created_at' => now(), 'updated_at' => now()],
            ['id_tim' => 2, 'nama_tim' => 'Tim CyberSec', 'created_at' => now(), 'updated_at' => now()],
            ['id_tim' => 3, 'nama_tim' => 'Tim Data Diggers', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('member_tim')->insert([
            // Tim 1: Koding Keren (Andi & Siti)
            ['id_tim' => 1, 'id_mahasiswa' => 6, 'created_at' => now(), 'updated_at' => now()], // Andi
            ['id_tim' => 1, 'id_mahasiswa' => 7, 'created_at' => now(), 'updated_at' => now()], // Siti
            // Tim 2: CyberSec (Fajar & Guntur)
            ['id_tim' => 2, 'id_mahasiswa' => 11, 'created_at' => now(), 'updated_at' => now()], // Fajar
            ['id_tim' => 2, 'id_mahasiswa' => 13, 'created_at' => now(), 'updated_at' => now()], // Guntur
            // Tim 3: Data Diggers (Eko & Sri)
            ['id_tim' => 3, 'id_mahasiswa' => 9, 'created_at' => now(), 'updated_at' => now()], // Eko
            ['id_tim' => 3, 'id_mahasiswa' => 18, 'created_at' => now(), 'updated_at' => now()], // Sri
        ]);

        // =================================================================
        // 8. REGISTRASI_LOMBA (Perlu penyesuaian manual jika ingin data konsisten)
        // =================================================================
        $this->command->info('Skipping Registrasi Lomba seeding. Please adjust manually for data consistency with new competitions.');

        // =================================================================
        // 9. PENILAIAN_PESERTA (Perlu penyesuaian manual)
        // =================================================================
        $this->command->info('Skipping Penilaian Peserta seeding. Please adjust manually.');

        // =================================================================
        // 10. PRESTASI (Perlu penyesuaian manual)
        // =================================================================
        $this->command->info('Skipping Prestasi seeding. Please adjust manually.');
    }
}
