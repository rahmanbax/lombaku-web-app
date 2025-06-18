<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     * Wajib didefinisikan karena nama tabel menggunakan snake_case.
     *
     * @var string
     */
    protected $table = 'program_studi';

    /**
     * Primary key untuk model.
     * Wajib didefinisikan karena primary key bukan 'id'.
     *
     * @var string
     */
    protected $primaryKey = 'id_program_studi';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_program_studi',
    ];

    /**
     * Mendefinisikan relasi "has many" ke model User.
     * Satu program studi bisa memiliki banyak user (mahasiswa, dosen, admin prodi).
     */
    public function users()
    {
        // Parameter kedua: foreign key di tabel 'users'
        // Parameter ketiga: primary key di tabel 'program_studi'
        return $this->hasMany(User::class, 'id_program_studi', 'id_program_studi');
    }

    /**
     * Mendefinisikan relasi "has many" ke model ProfilMahasiswa.
     * Satu program studi memiliki banyak profil mahasiswa.
     */
    public function profilMahasiswas()
    {
        return $this->hasMany(ProfilMahasiswa::class, 'id_program_studi', 'id_program_studi');
    }

    /**
     * Mendefinisikan relasi "has many" ke model ProfilDosen.
     * Satu program studi memiliki banyak profil dosen.
     */
    public function profilDosens()
    {
        // Pastikan Anda juga sudah membuat model ProfilDosen.php
        return $this->hasMany(ProfilDosen::class, 'id_program_studi', 'id_program_studi');
    }
}