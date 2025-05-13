<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kriterias = [
            [
                'kode_kriteria'  => 'C1',
                'nama_kriteria'  => 'Urgensi Kerusakan',
                'bobot_kriteria' => 0.30,
                'tipe_kriteria' => 'benefit',
                'deskripsi'      => 'Seberapa parah kerusakan mengganggu fungsi fasilitas'
            ],
            [
                'kode_kriteria'  => 'C2',
                'nama_kriteria'  => 'Dampak Akademik',
                'bobot_kriteria' => 0.25,
                'tipe_kriteria' => 'benefit',
                'deskripsi'      => 'Seberapa besar gangguan pada proses belajar/mengajar'
            ],
            [
                'kode_kriteria'  => 'C3',
                'nama_kriteria'  => 'Jumlah Unit Rusak',
                'bobot_kriteria' => 0.15,
                'tipe_kriteria' => 'benefit',
                'deskripsi'      => 'Banyaknya unit rusak dalam satu alternatif'
            ],
            [
                'kode_kriteria'  => 'C4',
                'nama_kriteria'  => 'Risiko Keselamatan',
                'bobot_kriteria' => 0.15,
                'tipe_kriteria' => 'benefit',
                'deskripsi'      => 'Potensi bahaya fisik jika dibiarkan rusak'
            ],
            [
                'kode_kriteria'  => 'C5',
                'nama_kriteria'  => 'Jumlah Pelapor',
                'bobot_kriteria' => 0.15,
                'tipe_kriteria' => 'benefit',
                'deskripsi'      => 'Banyaknya user yang melaporkan insiden sama'
            ],
        ];

        foreach ($kriterias as $data) {
            Kriteria::create($data);
        }
    }
}
