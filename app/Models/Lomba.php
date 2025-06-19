<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lomba extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'lomba';

    /**
     * Primary key untuk model.
     *
     * @var string
     */
    protected $primaryKey = 'id_lomba';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'foto_lomba',
        'nama_lomba',
        'deskripsi',
        'tingkat',
        'status',
        'tanggal_akhir_registrasi',
        'tanggal_mulai_lomba',
        'tanggal_selesai_lomba',
        'penyelenggara',
        'id_pembuat',
    ];

    /**
     * Mendefinisikan relasi "belongs to" ke model User (pembuat lomba).
     */
    public function pembuat()
    {
        // Parameter kedua: foreign key di tabel 'lomba'
        // Parameter ketiga: primary key di tabel 'users'
        return $this->belongsTo(User::class, 'id_pembuat', 'id_user');
    }

    /**
     * Mendefinisikan relasi "many-to-many" ke model Tag melalui tabel pivot 'daftar_tag'.
     */
    public function tags()
    {
        // Parameter kedua: nama tabel pivot
        // Parameter ketiga: foreign key model ini di tabel pivot
        // Parameter keempat: foreign key model lain di tabel pivot
        return $this->belongsToMany(Tag::class, 'daftar_tag', 'id_lomba', 'id_tag');
    }

    /**
     * Mendefinisikan relasi "has many" ke model RegistrasiLomba.
     */
    public function registrasi()
    {
        return $this->hasMany(RegistrasiLomba::class, 'id_lomba', 'id_lomba');
    }
}