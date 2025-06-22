<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use HasFactory;

    protected $table = 'prestasi';
    protected $primaryKey = 'id_prestasi';

    protected $fillable = [
        'id_user',
        'lomba_dari',
        'id_lomba',
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
    ];

    protected $casts = [
        'tanggal_diraih' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
    
    public function verifikator()
    {
        return $this->belongsTo(User::class, 'id_verifikator', 'id_user');
    }
    
    public function lomba()
    {
        return $this->belongsTo(Lomba::class, 'id_lomba', 'id_lomba');
    }

    // --- METHOD DI BAWAH INI DIHAPUS KARENA SALAH TEMPAT ---
    /* 
    public function prestasi()
    {
        return $this->hasMany(\App\Models\Prestasi::class, 'user_id', 'id');
    }
    */
}