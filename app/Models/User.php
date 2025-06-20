<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id_user';
    public $incrementing = true;

    protected $fillable = [
        'username',
        'password',
        'nama',
        'email',
        'notelp',
        'foto_profile', // Sesuaikan dengan nama kolom di migrasi Anda
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function profilMahasiswa()
    {
        return $this->hasOne(ProfilMahasiswa::class, 'id_user', 'id_user');
    }

    // --- TAMBAHKAN DUA RELASI DI BAWAH INI UNTUK MEMPERBAIKI ERROR ---

    /**
     * Relasi untuk mendapatkan semua registrasi lomba yang dilakukan oleh user ini.
     * Seorang User memiliki banyak (hasMany) RegistrasiLomba.
     */
    public function registrasiLomba()
    {
        // Parameter kedua: foreign key di tabel 'registrasi_lomba'
        // Parameter ketiga: primary key di tabel 'users'
        return $this->hasMany(RegistrasiLomba::class, 'id_mahasiswa', 'id_user');
    }

    /**
     * Relasi untuk mendapatkan semua prestasi yang diraih oleh user ini.
     * Seorang User memiliki banyak (hasMany) Prestasi.
     */
    public function prestasi()
    {
        // Parameter kedua: foreign key di tabel 'prestasi'
        // Parameter ketiga: primary key di tabel 'users'
        return $this->hasMany(Prestasi::class, 'id_user', 'id_user');
    }
    public function bookmarkedLombas()
    {
        return $this->belongsToMany(Lomba::class, 'lomba_bookmarks', 'id_user', 'id_lomba')
                    ->withTimestamps(); // Opsional: agar bisa mengambil data created_at
    }
}