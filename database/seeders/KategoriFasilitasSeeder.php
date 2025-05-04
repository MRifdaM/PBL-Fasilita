<?php

namespace Database\Seeders;

use App\Models\KategoriFasilitas;
use Illuminate\Database\Seeder;

class KategoriFasilitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriFasilitas = [
            [
                'kode_kategori' => 'ETN',
                'nama_kategori' => 'Elektronik',
            ],
            [
                'kode_kategori' => 'FNT',
                'nama_kategori' => 'Furniture',
            ],
            [
                'kode_kategori' => 'LAB',
                'nama_kategori' => 'Laboratorium',
            ],
            [
                'kode_kategori' => 'PRS',
                'nama_kategori' => 'Peralatan Presentasi',
            ],
            [
                'kode_kategori' => 'ACV',
                'nama_kategori' => 'AC & Ventilasi',
            ],
            [
                'kode_kategori' => 'SFT',
                'nama_kategori' => 'Perlengkapan Keselamatan',
            ],
            [
                'kode_kategori' => 'SAN',
                'nama_kategori' => 'Sanitasi',
            ],
            [
                'kode_kategori' => 'JAR',
                'nama_kategori' => 'Jaringan IT',
            ],
        ];

        foreach ($kategoriFasilitas as $data) {
            KategoriFasilitas::create($data);
        }
    }
}
