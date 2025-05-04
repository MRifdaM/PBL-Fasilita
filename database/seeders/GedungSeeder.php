<?php

namespace Database\Seeders;

use App\Models\Gedung;
use Illuminate\Database\Seeder;

class GedungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gedung = [
            [
                'kode_gedung' => 'TS',
                'nama_gedung' => 'Gedung Teknik Sipil',
            ],
            [
                'kode_gedung' => 'AO',
                'nama_gedung' => 'Gedung Teknik Kimia',
            ],
            [
                'kode_gedung' => 'AQ',
                'nama_gedung' => 'Laboratorium Teknik Kimia',
            ]
        ];

        foreach ($gedung as $data) {
            Gedung::create($data);
        }
    }
}
