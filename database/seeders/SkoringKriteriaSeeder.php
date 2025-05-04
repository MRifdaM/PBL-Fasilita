<?php

namespace Database\Seeders;

use App\Models\SkoringKriteria;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SkoringKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            // C1: Urgensi Kerusakan
            ['id_kriteria' => 1, 'parameter' => 'Goresan/lecet ringan (hanya kosmetik)',                        'nilai_referensi' => 1],
            ['id_kriteria' => 1, 'parameter' => 'Cat mengelupas/retak rambut (ganggu estetika)',               'nilai_referensi' => 2],
            ['id_kriteria' => 1, 'parameter' => 'Retak dangkal/sambungan longgar (mulai mengganggu fungsi)',  'nilai_referensi' => 3],
            ['id_kriteria' => 1, 'parameter' => 'Retak dalam/kerusakan struktural minor',                     'nilai_referensi' => 4],
            ['id_kriteria' => 1, 'parameter' => 'Kerusakan parah (patah/bocor total, tidak berfungsi)',       'nilai_referensi' => 5],

            // C2: Dampak Akademik
            ['id_kriteria' => 2, 'parameter' => 'Gangguan tidak signifikan (digantikan cepat, kelas lancar)', 'nilai_referensi' => 1],
            ['id_kriteria' => 2, 'parameter' => 'Mengganggu sebagian sesi (butuh workaround)',                'nilai_referensi' => 2],
            ['id_kriteria' => 2, 'parameter' => 'Mengganggu satu mata kuliah penuh',                         'nilai_referensi' => 3],
            ['id_kriteria' => 2, 'parameter' => 'Mengganggu banyak sesi atau lab penting',                   'nilai_referensi' => 4],
            ['id_kriteria' => 2, 'parameter' => 'Menghentikan seluruh kegiatan belajar/mengajar',           'nilai_referensi' => 5],

            // C3: Jumlah Unit Rusak
            ['id_kriteria' => 3, 'parameter' => '1 unit rusak',    'nilai_referensi' => 1],
            ['id_kriteria' => 3, 'parameter' => '2–3 unit rusak',  'nilai_referensi' => 2],
            ['id_kriteria' => 3, 'parameter' => '4–5 unit rusak',  'nilai_referensi' => 3],
            ['id_kriteria' => 3, 'parameter' => '6–7 unit rusak',  'nilai_referensi' => 4],
            ['id_kriteria' => 3, 'parameter' => '≥ 8 unit rusak',   'nilai_referensi' => 5],

            // C4: Risiko Keselamatan
            ['id_kriteria' => 4, 'parameter' => 'Risiko minimal (potensi kecil)',         'nilai_referensi' => 1],
            ['id_kriteria' => 4, 'parameter' => 'Risiko rendah (cedera ringan mungkin)',   'nilai_referensi' => 2],
            ['id_kriteria' => 4, 'parameter' => 'Risiko sedang (cedera sedang mungkin)',  'nilai_referensi' => 3],
            ['id_kriteria' => 4, 'parameter' => 'Risiko tinggi (cedera serius mungkin)',  'nilai_referensi' => 4],
            ['id_kriteria' => 4, 'parameter' => 'Risiko kritis (bahaya fatal mungkin)',   'nilai_referensi' => 5],

            // C5: Jumlah Pelapor
            ['id_kriteria' => 5, 'parameter' => '1 pelapor',     'nilai_referensi' => 1],
            ['id_kriteria' => 5, 'parameter' => '2–3 pelapor',   'nilai_referensi' => 2],
            ['id_kriteria' => 5, 'parameter' => '4–5 pelapor',   'nilai_referensi' => 3],
            ['id_kriteria' => 5, 'parameter' => '6–7 pelapor',   'nilai_referensi' => 4],
            ['id_kriteria' => 5, 'parameter' => '≥ 8 pelapor',    'nilai_referensi' => 5],
        ];

        foreach ($datas as $data) {
            SkoringKriteria::create($data);
        }
    }
}
