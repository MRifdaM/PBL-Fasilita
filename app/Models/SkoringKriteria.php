<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SkoringKriteria extends Model
{
    use HasFactory;

    protected $table = 'skoring_kriteria';
    protected $primaryKey = 'id_skoring_kriteria';
    protected $fillable = [
        'id_kriteria',
        'parameter',
        'nilai_referensi',
    ];

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria');
    }
}
