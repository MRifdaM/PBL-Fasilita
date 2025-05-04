<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_status';
    protected $table = 'status';
    protected $fillable = [
        'nama_status',
    ];

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'id_status');
    }

    public function riwayatLaporan(): HasMany
    {
        return $this->hasMany(RiwayatLaporanFasilitas::class, 'id_status');
    }
}
