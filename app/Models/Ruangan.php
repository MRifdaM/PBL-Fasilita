<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangan';
    protected $primaryKey = 'id_ruangan';
    protected $fillable = [
        'id_lantai',
        'kode_ruangan',
        'nama_ruangan',
    ];

    public function lantai(): BelongsTo
    {
        return $this->belongsTo(Lantai::class, 'id_lantai');
    }

    public function fasilitas(): HasMany
    {
        return $this->hasMany(Fasilitas::class, 'id_ruangan');
    }
}
