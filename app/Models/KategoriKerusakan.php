<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriKerusakan extends Model
{
    use HasFactory;

    protected $table = 'kategori_kerusakan';
    protected $primaryKey = 'id_kategori_kerusakan';
    protected $fillable = [
        'kode_kerusakan',
        'nama_kerusakan',
    ];

    public function laporanFasilitas(): HasMany
    {
        return $this->hasMany(LaporanFasilitas::class, 'id_kategori_kerusakan');
    }
}
