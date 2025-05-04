<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PelaporLaporanFasilitas extends Model
{
    use HasFactory;

    protected $table = 'pelapor_laporan_fasilitas';
    protected $primaryKey = 'id_pelapor_laporan_fasilitas';
    protected $fillable = [
        'id_laporan_fasilitas',
        'id_pengguna',
    ];

    public function laporanFasilitas(): BelongsTo
    {
        return $this->belongsTo(LaporanFasilitas::class, 'id_laporan_fasilitas');
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}
