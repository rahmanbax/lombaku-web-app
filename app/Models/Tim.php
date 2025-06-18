<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'tim';

    /**
     * Primary key untuk model.
     *
     * @var string
     */
    protected $primaryKey = 'id_tim';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_tim',
    ];

    /**
     * Mendefinisikan relasi "many-to-many" ke model User (sebagai anggota tim).
     * Sebuah Tim bisa memiliki banyak User (mahasiswa) sebagai anggota.
     */
    public function members()
    {
        // Parameter kedua: nama tabel pivot
        // Parameter ketiga: foreign key model ini (Tim) di tabel pivot
        // Parameter keempat: foreign key model lain (User) di tabel pivot
        return $this->belongsToMany(User::class, 'member_tim', 'id_tim', 'id_mahasiswa');
    }

    /**
     * Mendefinisikan relasi "has many" ke model RegistrasiLomba.
     * Sebuah Tim bisa mendaftar di banyak Lomba.
     */
    public function registrasiLomba()
    {
        // Parameter kedua: foreign key di tabel 'registrasi_lomba'
        // Parameter ketiga: primary key di tabel 'tim'
        return $this->hasMany(RegistrasiLomba::class, 'id_tim', 'id_tim');
    }
}