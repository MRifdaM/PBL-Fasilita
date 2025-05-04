<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaian';
    protected $primaryKey = 'id_penilaian';
    protected $fillable = [
        'id_laporan_fasilitas',
        'id_pengguna' //id sarpras
    ];

    public function laporanFasilitas(): BelongsTo
    {
        return $this->belongsTo(LaporanFasilitas::class, 'id_laporan_fasilitas');
    }

    public function sarpras(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function skorKriteriaLaporan(): HasMany
    {
        return $this->hasMany(SkorKriteriaLaporan::class, 'id_penilaian');
    }
}
