<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peran extends Model
{
    use HasFactory;

    protected $table = 'peran'; // nama tabel di database
    protected $fillable = ['kode_peran', 'nama_peran'];
}