<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ruang extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_ruang',
        'jam_buka',
        'jam_tutup',
    ];

    public function reservasi():HasMany
    {
        return $this->hasMany(Reservasi::class, 'ruang_id', 'id');
    }
}
