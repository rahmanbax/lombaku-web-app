<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilDosen extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'profil_dosen';

    /**
     * Primary key untuk model.
     * Wajib didefinisikan karena primary key bukan 'id'.
     *
     * @var string
     */
    protected $primaryKey = 'id_profil_dosen';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nip',
        'id_user',
        'id_program_studi',
    ];

    /**
     * Relasi ke model User (pemilik profil).
     * Setiap profil dosen dimiliki oleh satu user.
     */
    public function user()
    {
        // Parameter kedua: foreign key di tabel 'profil_dosen'
        // Parameter ketiga: primary key di tabel 'users'
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke model ProgramStudi.
     * Setiap profil dosen terikat pada satu program studi.
     */
    public function programStudi()
    {
        // Parameter kedua: foreign key di tabel 'profil_dosen'
        // Parameter ketiga: primary key di tabel 'program_studi'
        return $this->belongsTo(ProgramStudi::class, 'id_program_studi', 'id_program_studi');
    }
}