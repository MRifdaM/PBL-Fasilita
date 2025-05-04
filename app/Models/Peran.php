<?php

namespace App\Models;

use App\Models\Pengguna;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peran extends Model
{
    use HasFactory;

    protected $table = 'peran'; // nama tabel di database
    protected $primaryKey = 'id_peran'; // nama primary key di tabel
    protected $fillable = ['kode_peran', 'nama_peran'];

    public function pengguna(): HasMany
    {
        return $this->hasMany(Pengguna::class, 'id_peran');
    }
}
