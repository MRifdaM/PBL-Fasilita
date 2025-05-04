<?php

namespace Database\Seeders;

use App\Models\Ruangan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ruangan = [
            [
                'id_lantai' => 5,
                'kode_ruangan' => 'RT-1',
                'nama_ruangan' => 'Ruang Teori 1'
            ],
            [
                'id_lantai' => 5,
                'kode_ruangan' => 'RT-2',
                'nama_ruangan' => 'Ruang Teori 2'
            ],
            [
                'id_lantai' => 5,
                'kode_ruangan' => 'RT-3',
                'nama_ruangan' => 'Ruang Teori 3'
            ],
            [
                'id_lantai' => 5,
                'kode_ruangan' => 'RT-4',
                'nama_ruangan' => 'Ruang Teori 4'
            ],
            [
                'id_lantai' => 5,
                'kode_ruangan' => 'RT-5',
                'nama_ruangan' => 'Ruang Teori 5'
            ],
            [
                'id_lantai' => 5,
                'kode_ruangan' => 'RT-6',
                'nama_ruangan' => 'Ruang Teori 6'
            ],
            [
                'id_lantai' => 5,
                'kode_ruangan' => 'RT-7',
                'nama_ruangan' => 'Ruang Teori 7'
            ],
            [
                'id_lantai' => 5,
                'kode_ruangan' => 'LPY-1',
                'nama_ruangan' => 'Lab Proyek 1'
            ],
            [
                'id_lantai' => 5,
                'kode_ruangan' => 'RTEK-1',
                'nama_ruangan' => 'Ruang Teknisi 1'
            ],
            [
                'id_lantai' => 5,
                'kode_ruangan' => 'TL-5',
                'nama_ruangan' => 'Toilet Laki-Laki 5'
            ],
            [
                'id_lantai' => 5,
                'kode_ruangan' => 'TP-5',
                'nama_ruangan' => 'Toilet Perempuan 5'
            ],
            [
                'id_lantai' => 7,
                'kode_ruangan' => 'LPR-1',
                'nama_ruangan' => 'Lab Praktikum 1'
            ]
        ];

        foreach ($ruangan as $data) {
            Ruangan::create($data);
        }
    }
}
