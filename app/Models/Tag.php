<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'tags';

    /**
     * Primary key untuk model.
     *
     * @var string
     */
    protected $primaryKey = 'id_tag';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_tag',
    ];

    /**
     * Mendefinisikan relasi "many-to-many" ke model Lomba melalui tabel pivot 'daftar_tag'.
     */
    public function lombas()
    {
        // Parameter kedua: nama tabel pivot
        // Parameter ketiga: foreign key model ini (Tag) di tabel pivot
        // Parameter keempat: foreign key model lain (Lomba) di tabel pivot
        return $this->belongsToMany(Lomba::class, 'daftar_tag', 'id_tag', 'id_lomba');
    }
}