<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Status;
use App\Models\Kriteria;
use App\Models\SkorTipe;
use App\Models\SkorTopsis;
use Illuminate\Http\Request;
use App\Models\LaporanFasilitas;
use Illuminate\Support\Facades\DB;
use App\Models\SkorKriteriaLaporan;
use Illuminate\Support\Facades\Cache;

class TopsisController extends Controller
{
    public function index(Request $request)
    {
        $kriterias   = Kriteria::orderBy('kode_kriteria')->get();
        $alternatifs = LaporanFasilitas::with('fasilitas','laporan.pengguna','penilaian.skorKriteriaLaporan')
            ->where('id_status', Status::VALID)
            ->where('is_active', true)
            ->whereDoesntHave('penugasan') // hanya yang belum ditugaskan
            ->whereHas('penilaian')
            ->get();

        $runId = $request->input('runId')
               ?: optional(SkorTipe::where('tipe','global')->latest('created_at')->first())->id_skor_tipe;

         $steps = Cache::get("topsis.steps.{$runId}", []);

        $breadcrumbs = [
            ['title'=>'Dashboard','url'=>route('dashboard')],
            ['title'=>'Analisis TOPSIS','url'=>route('spk.index')],
        ];

        // base view data
        $data = [
            'kriterias'   => $kriterias,
            'alternatifs' => $alternatifs,
            'breadcrumbs' => $breadcrumbs,
            // these may or may not exist
            'norm'        => $steps['norm']        ?? null,
            'V'           => $steps['V']           ?? null,
            'idealPos'    => $steps['idealPos']    ?? null,
            'idealNeg'    => $steps['idealNeg']    ?? null,
            'distPos'     => $steps['distPos']     ?? null,
            'distNeg'     => $steps['distNeg']     ?? null,
            'Ci'          => $steps['Ci']          ?? null,
            'runId'       => $steps['runId']       ?? null,
        ];

        return view('perhitungan.index', $data);
    }

    public function hitung(Request $request)
    {
         // 1) Ambil count alternatif & kriteria sekarang
        $curAlt = LaporanFasilitas::where('id_status',Status::VALID)
                    ->where('is_active',true)
                    ->whereDoesntHave('penugasan')
                    ->count();
        $curCri = Kriteria::count();

        // 2) Cek run global terakhir
        $last = SkorTipe::where('tipe','global')->latest('created_at')->first();

        // 2a) Cek perubahan pada nilai kriteria (skor mentah)
        $lastScoreUpdateRaw = SkorKriteriaLaporan::max('updated_at');
        $lastScoreUpdate = $lastScoreUpdateRaw ? Carbon::parse($lastScoreUpdateRaw) : null;
        // bisa juga filter hanya penilaian dalam pool terbaru, tapi global cukup

        // 2b) Jika belum 3 hari, jumlah alt/cri sama, dan skor tidak berubah sejak run terakhir → skip
        if ($last
            && $last->created_at->gt(now()->subDays(3))
            && $last->alt_count === $curAlt
            && $last->cri_count === $curCri
            && (! $lastScoreUpdate || $lastScoreUpdate->lte($last->created_at))
        ) {
            return redirect()
                ->route('spk.index',['runId'=>$last->id_skor_tipe])
                ->with('info','Tidak ada perubahan data atau nilai sejak perhitungan terakhir. Skip.');
        }

        // 3) Ambil pool alternatif & validasi minimal satu
        $alts = LaporanFasilitas::with('penilaian.skorKriteriaLaporan.kriteria')
            ->where('id_status',Status::VALID)
            ->where('is_active',true)
            ->whereDoesntHave('penugasan')
            ->whereHas('penilaian')
            ->get();

        if ($alts->isEmpty()) {
            return redirect()
                ->route('spk.index')
                ->with('error','Tidak ada alternatif valid untuk dihitung.');
        }

        // 4) Buat run baru, simpan counts
        $run = SkorTipe::create([
            'tipe'=>'global',
            'alt_count'=>$curAlt,
            'cri_count'=>$curCri,
        ]);

        // 5) Persiapkan data matriks
        $kriterias = Kriteria::orderBy('kode_kriteria')->get();
        $data = [];
        foreach($alts as $alt){
            $row = ['id'=>$alt->id_laporan_fasilitas];
            foreach($kriterias as $k){
                $sk = $alt->penilaian->first()
                    ?->skorKriteriaLaporan
                    ->firstWhere('id_kriteria',$k->id_kriteria);
                $row[$k->kode_kriteria] = $sk->nilai_mentah ?? 0;
            }
            $data[] = $row;
        }

        // 6) Normalisasi R
        $norm = [];
        foreach($kriterias as $k){
            $sumSq = array_sum(array_map(fn($r)=> pow($r[$k->kode_kriteria],2), $data));
            $den   = sqrt($sumSq) ?: 1;
            foreach($data as $i=>$r){
                $norm[$i][$k->kode_kriteria] = $r[$k->kode_kriteria]/$den;
            }
        }

        // 7) Matriks terbobot V
        $V = [];
        foreach($kriterias as $k){
            foreach($norm as $i=>$r){
                $V[$i][$k->kode_kriteria] = $r[$k->kode_kriteria] * $k->bobot_kriteria;
            }
        }

        // 8) Ideal positif & negatif
        $idealPos = []; $idealNeg = [];
        foreach($kriterias as $k){
            $col = array_column($V, $k->kode_kriteria);
            if ($k->tipe_kriteria==='benefit') {
                $idealPos[$k->kode_kriteria] = max($col);
                $idealNeg[$k->kode_kriteria] = min($col);
            } else {
                $idealPos[$k->kode_kriteria] = min($col);
                $idealNeg[$k->kode_kriteria] = max($col);
            }
        }

        // 9) Hitung jarak & Ci
        $distPos = []; $distNeg = []; $CiMap = [];
        foreach($V as $i=>$r){
            $d1=$d2=0;
            foreach($kriterias as $k){
                $d1 += pow($r[$k->kode_kriteria]-$idealPos[$k->kode_kriteria],2);
                $d2 += pow($r[$k->kode_kriteria]-$idealNeg[$k->kode_kriteria],2);
            }
            $distPos[$i]=sqrt($d1);
            $distNeg[$i]=sqrt($d2);
            $CiMap[$data[$i]['id']] =
                ($distPos[$i]+$distNeg[$i])>0
                ? $distNeg[$i]/($distPos[$i]+$distNeg[$i])
                : 0;
        }

        // 10) Simpan Ci ke DB
        DB::transaction(fn() =>
            collect($alts)->each(fn($alt,$i) =>
                SkorTopsis::updateOrCreate(
                    ['id_skor_tipe'=>$run->id_skor_tipe,'id_laporan_fasilitas'=>$alt->id_laporan_fasilitas],
                    ['skor'=>$CiMap[$alt->id_laporan_fasilitas]]
                )
            )
        );

        // 11) Cache langkah selengkapnya selama 3 hari
        Cache::put("topsis.steps.{$run->id_skor_tipe}", [
            'kriterias'=>$kriterias,
            'alternatifs'=>$alts,
            'norm'=>$norm,
            'V'=>$V,
            'idealPos'=>$idealPos,
            'idealNeg'=>$idealNeg,
            'distPos'=>$distPos,
            'distNeg'=>$distNeg,
            'Ci'=>$CiMap,
            'runId'=>$run->id_skor_tipe,
        ], now()->addDays(3));

        return redirect()
            ->route('spk.index',['runId'=>$run->id_skor_tipe])
            ->with('success','Perhitungan TOPSIS selesai.');
    }

    public function edit($id)
    {
        $laporan = LaporanFasilitas::with(['fasilitas','laporan.pengguna','penilaian.skorKriteriaLaporan'])
                    ->findOrFail($id);
        $kriterias = Kriteria::with('skoringKriterias')->orderBy('kode_kriteria')->get();

        return view('perhitungan.edit', compact('laporan','kriterias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|array'
        ]);

        $laporan = LaporanFasilitas::with('penilaian')->findOrFail($id);
        $penilaian = $laporan->penilaian()->firstOrCreate([ 'id_laporan_fasilitas' => $id ], [ 'id_sarpras' => auth()->id() ]);

        foreach($request->nilai as $id_kriteria => $val) {
            $penilaian->skorKriteriaLaporan()->updateOrCreate(
                ['id_kriteria' => $id_kriteria],
                ['nilai_mentah' => $val]
            );
        }

        return response()->json(['success' => true]);
    }

}
