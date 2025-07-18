<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekognisi extends Model
{
    use HasFactory;

    protected $table = 'rekognisi';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_prestasi',
        'mata_kuliah',
        'jenis_rekognisi',
        'bobot_nilai',
    ];

    /**
     * Relasi ke model Prestasi.
     * Setiap rekognisi pasti milik satu prestasi.
     */
    public function prestasi()
    {
        return $this->belongsTo(Prestasi::class, 'id_prestasi', 'id_prestasi');
    }
}