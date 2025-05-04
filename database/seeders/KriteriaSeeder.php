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
                'deskripsi'      => 'Seberapa parah kerusakan mengganggu fungsi fasilitas (1 = minor, 5 = kritis)'
            ],
            [
                'kode_kriteria'  => 'C2',
                'nama_kriteria'  => 'Dampak Akademik',
                'bobot_kriteria' => 0.25,
                'deskripsi'      => 'Seberapa besar gangguan pada proses belajar/mengajar (1 = kecil, 5 = kelas terhenti sepenuhnya)'
            ],
            [
                'kode_kriteria'  => 'C3',
                'nama_kriteria'  => 'Jumlah Unit Rusak',
                'bobot_kriteria' => 0.15,
                'deskripsi'      => 'Banyaknya unit rusak dalam satu alternatif (diskoring 1–5 berdasarkan rentang jumlah unit rusak)'
            ],
            [
                'kode_kriteria'  => 'C4',
                'nama_kriteria'  => 'Risiko Keselamatan',
                'bobot_kriteria' => 0.15,
                'deskripsi'      => 'Potensi bahaya fisik jika dibiarkan rusak (1 = rendah, 5 = tinggi)'
            ],
            [
                'kode_kriteria'  => 'C5',
                'nama_kriteria'  => 'Jumlah Pelapor',
                'bobot_kriteria' => 0.15,
                'deskripsi'      => 'Banyaknya user yang melaporkan insiden sama (diskoring 1–5 berdasarkan rentang jumlah pelapor)'
            ],
        ];

        foreach ($kriterias as $data) {
            Kriteria::create($data);
        }
    }
}
