<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrasiLomba extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'registrasi_lomba';

    /**
     * Primary key untuk model.
     *
     * @var string
     */
    protected $primaryKey = 'id_registrasi_lomba';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'link_pengumpulan',
        'status_verifikasi',
        'id_mahasiswa',
        'id_lomba',
        'id_tim',
        'id_dosen',
    ];

    /**
     * Relasi ke model Lomba.
     * Setiap registrasi pasti milik satu lomba.
     */
    public function lomba()
    {
        return $this->belongsTo(Lomba::class, 'id_lomba', 'id_lomba');
    }

    /**
     * Relasi ke model User (sebagai Mahasiswa yang mendaftar).
     * Setiap registrasi dibuat oleh satu mahasiswa.
     */
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'id_mahasiswa', 'id_user');
    }

    /**
     * Relasi ke model User (sebagai Dosen Pembimbing).
     * Setiap registrasi bisa memiliki satu dosen pembimbing (atau null).
     */
    public function dosenPembimbing()
    {
        return $this->belongsTo(User::class, 'id_dosen', 'id_user');
    }

    /**
     * Relasi ke model Tim.
     * Setiap registrasi bisa dimiliki oleh satu tim (atau null jika perorangan).
     */
    public function tim()
    {
        // Pastikan Anda juga sudah membuat model Tim.php
        return $this->belongsTo(Tim::class, 'id_tim', 'id_tim');
    }

    public function penilaian()
    {
        return $this->hasMany(PenilaianPeserta::class, 'id_registrasi_lomba', 'id_registrasi_lomba');
    }
}