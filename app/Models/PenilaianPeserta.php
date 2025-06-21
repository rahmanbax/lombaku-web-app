<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TahapLomba;

class PenilaianPeserta extends Model
{
    use HasFactory;

    protected $table = 'penilaian_peserta';
    protected $primaryKey = 'id_penilaian';

    protected $fillable = [
        'id_registrasi_lomba',
        'id_tahap',
        'id_penilai',
        'nilai',
        'catatan',
    ];

    public function registrasiLomba()
    {
        return $this->belongsTo(RegistrasiLomba::class, 'id_registrasi_lomba', 'id_registrasi_lomba');
    }

    public function tahapLomba()
    {
        return $this->belongsTo(TahapLomba::class, 'id_tahap', 'id_tahap');
    }

    public function penilai()
    {
        return $this->belongsTo(User::class, 'id_penilai', 'id_user');
    }

    public function tahap()
    {
        // Parameter kedua: foreign key di tabel 'penilaian_peserta'
        // Parameter ketiga: primary key di tabel 'tahap_lomba'
        return $this->belongsTo(TahapLomba::class, 'id_tahap', 'id_tahap');
    }
}