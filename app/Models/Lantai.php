<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lantai extends Model
{
    use HasFactory;

    protected $table = 'lantai';
    protected $primaryKey = 'id_lantai';
    protected $fillable = [
        'id_gedung',
        'kode_lantai',
        'nomor_lantai',
    ];

    public function gedung(): BelongsTo
    {
        return $this->belongsTo(Gedung::class, 'id_gedung');
    }

    public function ruangan(): HasMany
    {
        return $this->hasMany(Ruangan::class, 'id_lantai');
    }
}
