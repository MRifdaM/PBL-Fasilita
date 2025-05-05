<?php

namespace App\Models;

use App\Models\Peran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    use HasFactory;
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    protected $fillable = [
        'id_peran',
        'username',
        'nama',
        'password',
        'foto_profil',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function peran(): BelongsTo
    {
        return $this->belongsTo(Peran::class, 'id_peran');
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'id_pengguna');
    }

    public function pelaporLaporanFasilitas(): HasMany
    {
        return $this->hasMany(PelaporLaporanFasilitas::class, 'id_pengguna');
    }

    public function riwayatLaporan(): HasMany
    {
        return $this->hasMany(RiwayatLaporanFasilitas::class, 'id_pengguna');
    }

    public function penugasan(): HasMany
    {
        return $this->hasMany(Penugasan::class, 'id_teknisi');
    }

    public function penilaian(): HasMany
    {
        return $this->hasMany(Penilaian::class, 'id_sarpras');
    }

    public function penilaianPengguna(): HasMany
    {
        return $this->hasMany(PenilaianPengguna::class, 'id_pengguna');
    }
}
