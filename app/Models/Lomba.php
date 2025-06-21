<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lomba extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lomba';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_lomba';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'foto_lomba',
        'nama_lomba',
        'deskripsi',
        'lokasi', // Anda lupa menambahkan ini di fillable
        'tingkat',
        'status',
        'alasan_penolakan', // Anda lupa menambahkan ini di fillable
        'lokasi',
        'lokasi_offline',
        'tanggal_akhir_registrasi',
        'tanggal_mulai_lomba',
        'tanggal_selesai_lomba',
        'penyelenggara',
        'id_pembuat',
    ];

    /**
     * Get the user who created the contest.
     */
    public function pembuat()
    {
        return $this->belongsTo(User::class, 'id_pembuat', 'id_user');
    }

    /**
     * The tags that belong to the contest.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'daftar_tag', 'id_lomba', 'id_tag');
    }

    /**
     * Get all of the registrations for the contest.
     */
    public function registrasi()
    {
        return $this->hasMany(RegistrasiLomba::class, 'id_lomba', 'id_lomba');
    }

    /**
     * --- INI PERBAIKANNYA ---
     * Get the users who have bookmarked this contest.
     */
    public function bookmarkedByUsers()
    {
        // Relasi ke User, bukan ke Lomba lagi.
        // Foreign key untuk User di tabel pivot adalah 'id_user'.
        // Foreign key untuk Lomba (model ini) di tabel pivot adalah 'id_lomba'.
        return $this->belongsToMany(User::class, 'lomba_bookmarks', 'id_lomba', 'id_user')
            ->withTimestamps();
    }

    public function tahaps()
    {
        // Parameter kedua: foreign key di tabel tujuan ('tahap_lomba')
        // Parameter ketiga: primary key di tabel ini ('lomba')
        return $this->hasMany(TahapLomba::class, 'id_lomba', 'id_lomba')->orderBy('urutan', 'asc');
    }
}
