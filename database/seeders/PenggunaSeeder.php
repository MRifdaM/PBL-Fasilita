<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pengguna = [
            [
                'id_peran' => 1,
                'username' => 'admin',
                'nama' => 'Natalia Willy',
                'hash_password' => Hash::make('12345')
            ],
            [
                'id_peran' => 2,
                'username' => 'mahasiswa',
                'nama' => 'Rizky Maulana',
                'hash_password' => Hash::make('12345')
            ],
            [
                'id_peran' => 3,
                'username' => 'dosen',
                'nama' => 'Dr. Andi Saputra',
                'hash_password' => Hash::make('12345')
            ],
            [
                'id_peran' => 4,
                'username' => 'tendik',
                'nama' => 'Budi Santoso',
                'hash_password' => Hash::make('12345')
            ],
            [
                'id_peran' => 5,
                'username' => 'sarpras',
                'nama' => 'Siti Aminah',
                'hash_password' => Hash::make('12345')
            ],
            [
                'id_peran' => 6,
                'username' => 'teknisi',
                'nama' => 'Joko Susilo',
                'hash_password' => Hash::make('12345')
            ],
        ];

        foreach ($pengguna as $data) {
            Pengguna::create($data);
        }
    }
}
