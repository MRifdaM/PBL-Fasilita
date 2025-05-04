<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fasilitas extends Model
{
    use HasFactory;

    protected $table = 'fasilitas';
    protected $primaryKey = 'id_fasilitas';
    protected $fillable = [
        'id_ruangan',
        'id_kategori_fasilitas',
        'kode_fasilitas',
        'nama_fasilitas',
        'jumlah',
    ];

    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }

    public function kategoriFasilitas(): BelongsTo
    {
        return $this->belongsTo(KategoriFasilitas::class, 'id_kategori_fasilitas');
    }

    public function laporanFasilitas(): HasMany
    {
        return $this->hasMany(LaporanFasilitas::class, 'id_fasilitas');
    }
}
