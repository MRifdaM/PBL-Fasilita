<?php

namespace Database\Seeders;

use App\Models\Lantai;
use Illuminate\Database\Seeder;

class LantaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lantai = [
            [
                'id_gedung' => 1,
                'nomor_lantai' => 'Lantai 1',
            ],
            [
                'id_gedung' => 1,
                'nomor_lantai' => 'Lantai 2',
            ],
            [
                'id_gedung' => 1,
                'nomor_lantai' => 'Lantai 3',
            ],
            [
                'id_gedung' => 1,
                'nomor_lantai' => 'Lantai 4',
            ],
            [
                'id_gedung' => 1,
                'nomor_lantai' => 'Lantai 5',
            ],
            [
                'id_gedung' => 1,
                'nomor_lantai' => 'Lantai 6',
            ],
            [
                'id_gedung' => 1,
                'nomor_lantai' => 'Lantai 7',
            ],
            [
                'id_gedung' => 1,
                'nomor_lantai' => 'Lantai 8',
            ],
        ];

        foreach($lantai as $data){
            Lantai::create($data);
        }
    }
}
