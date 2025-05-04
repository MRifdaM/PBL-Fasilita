<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gedung extends Model
{
    use HasFactory;

    protected $table = 'gedung';
    protected $primaryKey = 'id_gedung';
    protected $fillable = ['kode_gedung', 'nama_gedung', 'lokasi'];

    public function lantai(): HasMany
    {
        return $this->hasMany(Lantai::class, 'id_gedung');
    }
}
