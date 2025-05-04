<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatLaporanFasilitas extends Model
{
    use HasFactory;

    protected $table = 'riwayat_laporan_fasilitas';
    protected $primaryKey = 'id_riwayat_laporan_fasilitas';
    protected $fillable = [
        'id_laporan_fasilitas',
        'id_status',
        'id_pengguna',
        'catatan',
    ];

    public function laporanFasilitas(): BelongsTo
    {
        return $this->belongsTo(LaporanFasilitas::class, 'id_laporan_fasilitas');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'id_status');
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}
