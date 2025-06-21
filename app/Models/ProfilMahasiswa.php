<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilMahasiswa extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'profil_mahasiswa';

    /**
     * Primary key untuk model.
     *
     * @var string
     */
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
        // Kolom-kolom tambahan dari migrasi terakhir
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
        'sosial_media' => 'array',
        'tanggal_lahir' => 'date',
    ];

    /**
     * Relasi ke model User (pemilik profil).
     * Setiap profil mahasiswa dimiliki oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * INI ADALAH RELASI YANG HILANG DAN MENYEBABKAN ERROR
     * Relasi ke model ProgramStudi.
     * Setiap profil mahasiswa terikat pada satu program studi.
     */
    public function programStudi()
    {
        // Parameter kedua: foreign key di tabel ini ('profil_mahasiswa')
        // Parameter ketiga: primary key di tabel lain ('program_studi')
        return $this->belongsTo(ProgramStudi::class, 'id_program_studi', 'id_program_studi');
    }
}