<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Peran;

class PeranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin', 'mahasiswa', 'dosen', 'tendik', 'sarpras', 'teknisi'];

        foreach ($roles as $role) {
            Peran::create(['nama' => $role]);
        }
    }
}
