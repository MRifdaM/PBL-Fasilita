<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peran extends Model
{
    use HasFactory;

    protected $table = 'peran'; // nama tabel di database
    protected $fillable = ['nama']; // field yang bisa diisi
}