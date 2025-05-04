<?php

namespace Database\Seeders;

use App\Models\KategoriKerusakan;
use Illuminate\Database\Seeder;

class KategoriKerusakanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriKerusakan = [
             // Kerusakan Hardware
            [
                'kode_kerusakan' => 'HW-001',
                'nama_kerusakan' => 'Kerusakan Perangkat Keras',
            ],
            [
                'kode_kerusakan' => 'HW-002',
                'nama_kerusakan' => 'Kerusakan Layar',
            ],
            [
                'kode_kerusakan' => 'HW-003',
                'nama_kerusakan' => 'Kerusakan Input Device',
            ],

            // Masalah Jaringan
            [
                'kode_kerusakan' => 'NET-001',
                'nama_kerusakan' => 'Masalah Konektivitas Jaringan',
            ],
            [
                'kode_kerusakan' => 'NET-002',
                'nama_kerusakan' => 'Bandwidth Lambat',
            ],
            [
                'kode_kerusakan' => 'NET-003',
                'nama_kerusakan' => 'Autentikasi Jaringan',
            ],

            // Kerusakan Software
            [
                'kode_kerusakan' => 'SW-001',
                'nama_kerusakan' => 'Aplikasi Crash',
            ],
            [
                'kode_kerusakan' => 'SW-002',
                'nama_kerusakan' => 'Sistem Operasi Error',
            ],
            [
                'kode_kerusakan' => 'SW-003',
                'nama_kerusakan' => 'Virus/Malware',
            ],

            //Kerusakan Furnitur
            [
                'kode_kerusakan' => 'OTH-001',
                'nama_kerusakan' => 'Kerusakan Furniture',
            ],
            [
                'kode_kerusakan' => 'OTH-002',
                'nama_kerusakan' => 'Masalah Listrik',
            ]
            ];

            foreach ($kategoriKerusakan as $data) {
                KategoriKerusakan::create($data);
            }
    }
}
