<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'profil_mahasiswa';
    protected $primaryKey = 'id_profil_mahasiswa';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nim',
        'id_user',
        'id_program_studi',
        // --- TAMBAHKAN SEMUA KOLOM BARU DI SINI ---
        'tanggal_lahir',
        'jenis_kelamin',
        'headline',
        'domisili_provinsi',
        'domisili_kabupaten',
        'kode_pos',
        'alamat_lengkap',
        'sosial_media',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        // Memberitahu Laravel untuk otomatis mengubah kolom JSON menjadi array/object
        'sosial_media' => 'array',
        'tanggal_lahir' => 'date',
    ];

    /**
     * Relasi ke model User (pemilik profil).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke model ProgramStudi.
     */
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'id_program_studi', 'id_program_studi');
    }
}