<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilAdminLomba extends Model
{
    use HasFactory;
    protected $table = 'profil_admin_lomba'; // Pastikan nama tabel benar
    protected $primaryKey = 'id_profil_admin_lomba'; // Sesuaikan jika perlu

    protected $fillable = [
        'id_user',
        'alamat',
        'jenis_organisasi',
    ];
}