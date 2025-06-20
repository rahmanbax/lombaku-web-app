<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahapLomba extends Model
{
    use HasFactory;

    protected $table = 'tahap_lomba';
    protected $primaryKey = 'id_tahap';

    protected $fillable = [
        'id_lomba',
        'nama_tahap',
        'urutan',
        'deskripsi',
    ];

    public function lomba()
    {
        return $this->belongsTo(Lomba::class, 'id_lomba', 'id_lomba');
    }
}