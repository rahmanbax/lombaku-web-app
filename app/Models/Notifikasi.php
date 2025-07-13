<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model.
     *
     * @var string
     */
    protected $table = 'notifikasi';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',
        'tipe',
        'judul',
        'pesan',
        'data',
        'dibaca_pada',
    ];

    /**
     * Tipe data asli dari atribut harus di-cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => 'array', // Otomatis mengubah JSON menjadi array dan sebaliknya
        'dibaca_pada' => 'datetime',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model User.
     * Setiap notifikasi dimiliki oleh satu user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        // Parameter kedua ('id_user') adalah foreign key di tabel 'notifikasi'
        // Parameter ketiga ('id_user') adalah primary key di tabel 'users'
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
