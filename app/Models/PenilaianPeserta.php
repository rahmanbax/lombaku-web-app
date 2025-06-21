<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianPeserta extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'penilaian_peserta';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_penilaian';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_registrasi_lomba',
        'id_tahap',
        'id_penilai',
        'nilai',
        'catatan',
    ];

    /**
     * Get the registration associated with the assessment.
     */
    public function registrasiLomba()
    {
        return $this->belongsTo(RegistrasiLomba::class, 'id_registrasi_lomba', 'id_registrasi_lomba');
    }

    /**
     * Get the stage associated with the assessment.
     */
    public function tahap()
    {
        return $this->belongsTo(TahapLomba::class, 'id_tahap', 'id_tahap');
    }

    /**
     * Get the judge who gave the assessment.
     */
    public function penilai()
    {
        return $this->belongsTo(User::class, 'id_penilai', 'id_user');
    }
}