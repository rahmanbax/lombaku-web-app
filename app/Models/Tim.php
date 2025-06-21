<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tim';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_tim';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_tim',
    ];

    /**
     * The members that belong to the team.
     */
    public function members()
    {
        // Relasi ke User melalui tabel pivot 'member_tim'
        // Foreign key untuk Tim di pivot adalah 'id_tim'
        // Foreign key untuk User di pivot adalah 'id_mahasiswa'
        return $this->belongsToMany(User::class, 'member_tim', 'id_tim', 'id_mahasiswa');
    }

    /**
     * Get all of the contest registrations for the team.
     */
    public function registrasiLomba()
    {
        return $this->hasMany(RegistrasiLomba::class, 'id_tim', 'id_tim');
    }
}