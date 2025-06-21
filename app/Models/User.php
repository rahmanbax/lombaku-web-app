<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_user';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'nama',
        'email',
        'notelp',
        'foto_profile',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Get the profile associated with the user.
     */
    public function profilMahasiswa()
    {
        return $this->hasOne(ProfilMahasiswa::class, 'id_user', 'id_user');
    }

    /**
     * Get all of the contest registrations for the user.
     */
    public function registrasiLomba()
    {
        return $this->hasMany(RegistrasiLomba::class, 'id_mahasiswa', 'id_user');
    }

    /**
     * Get all of the achievements for the user.
     */
    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'id_user', 'id_user');
    }

    /**
     * The contests that are bookmarked by the user.
     */
    public function bookmarkedLombas()
    {
        return $this->belongsToMany(Lomba::class, 'lomba_bookmarks', 'id_user', 'id_lomba')
                    ->withTimestamps();
    }
}