<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use HasFactory;

    protected $table = 'prestasi';
    protected $primaryKey = 'id_prestasi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',
        'lomba_dari',
        'id_lomba',
        'id_tim',
        'nama_lomba_eksternal',
        'penyelenggara_eksternal',
        'tingkat',
        'tipe_prestasi',
        'peringkat',
        'tanggal_diraih',
        'sertifikat_path',
        'status_verifikasi',
        'id_verifikator',
        'catatan_verifikasi',
        'status_rekognisi', // <-- [PERBAIKAN KRITIS] Tambahkan ini!
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_diraih' => 'date',
    ];

    /**
     * Get the user that owns the prestasi.
     */
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Get the user who verified the prestasi.
     */
    public function verifikator()
    {
        return $this->belongsTo(User::class, 'id_verifikator', 'id_user');
    }

    /**
     * Get the lomba associated with the prestasi.
     */
    public function lomba()
    {
        return $this->belongsTo(Lomba::class, 'id_lomba', 'id_lomba');
    }
    
    /**
     * Get the team associated with the prestasi.
     */
    public function tim()
    {
        return $this->belongsTo(Tim::class, 'id_tim', 'id_tim');
    }
}