<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tags';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_tag',
    ];

    /**
     * The contests that belong to the tag.
     */
    public function lombas()
    {
        return $this->belongsToMany(Lomba::class, 'daftar_tag', 'id_tag', 'id_lomba');
    }
}