<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Kriteria;
use App\Models\SkorTipe;
use App\Models\SkorTopsis;
use Illuminate\Http\Request;
use App\Models\LaporanFasilitas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class TopsisController extends Controller
{
    public function index(Request $request)
    {
        $kriterias = Kriteria::orderBy('kode_kriteria')->get();
    $alternatifs = LaporanFasilitas::with('penilaian.skorKriteriaLaporan.kriteria')
        ->where('id_status', Status::VALID)
        ->where('is_active', true)
        ->whereHas('penilaian')
        ->get();

    $steps = null;
    // Jika ada runId di query string, atau ambil run terakhir
    $runId = $request->input('runId')
           ?: optional(SkorTipe::where('tipe','global')->latest('id_skor_tipe')->first())->id_skor_tipe;

    if ($runId && Cache::has("topsis.steps.{$runId}")) {
        $steps = Cache::get("topsis.steps.{$runId}");
    }

     $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Perhitungan Sistem Pendukung Keputusan', 'url' => route('spk.index')],
        ];

    return view('perhitungan.index', array_merge([
            'kriterias'   => $kriterias,
            'alternatifs' => $alternatifs,
            'breadcrumbs'   => $breadcrumbs,
        ], $steps ?? []));
    }

    public function hitung(Request $request)
    {
         // 1) Ambil semua alternatif valid
        $alts = LaporanFasilitas::with('penilaian.skorKriteriaLaporan.kriteria')
            ->where('id_status', Status::VALID)
            ->where('is_active', true)
            ->whereHas('penilaian')
            ->get();

        // Jika kosong, kembali ke index dengan error
        if ($alts->isEmpty()) {
            return redirect()
                ->route('spk.index')
                ->with('error','Tidak ada alternatif valid untuk dihitung.');
        }

        // 2) Cek run global terakhir
        $last = SkorTipe::where('tipe','global')
                ->latest('created_at')->first();

        // Jika ada dan belum 3 hari berlalu, langsung redirect ke index
        if ($last && $last->created_at->gt(Carbon::now()->subDays(3))) {
            return redirect()
                ->route('spk.index',['runId'=>$last->id_skor_tipe])
                ->with('info','Perhitungan terakhir pada '.$last->created_at->format('d M Y H:i').'.');
        }

        // 3) Buat run baru
        $run = SkorTipe::create(['tipe'=>'global']);

        // 4) Siapkan data mentah
        $kriterias = Kriteria::orderBy('kode_kriteria')->get();
        $data = [];
        foreach($alts as $alt){
            $row = ['id'=>$alt->id_laporan_fasilitas];
            foreach($kriterias as $k){
                $sk = $alt->penilaian->first()?->skorKriteriaLaporan
                       ->firstWhere('id_kriteria',$k->id_kriteria);
                $row[$k->kode_kriteria] = $sk->nilai_mentah ?? 0;
            }
            $data[] = $row;
        }

        // 5) Normalisasi R
        $norm = [];
        foreach($kriterias as $k){
            $sumSq = array_sum(array_map(fn($r)=> pow($r[$k->kode_kriteria],2), $data));
            $den   = sqrt($sumSq) ?: 1;
            foreach($data as $i=>$r){
                $norm[$i][$k->kode_kriteria] = $r[$k->kode_kriteria]/$den;
            }
        }

        // 6) Matriks terbobot V
        $V = [];
        foreach($kriterias as $k){
            foreach($norm as $i=>$r){
                $V[$i][$k->kode_kriteria] = $r[$k->kode_kriteria] * $k->bobot_kriteria;
            }
        }

        // 7) Ideal positif/negatif
        $idealPos = []; $idealNeg = [];
        foreach($kriterias as $k){
            $col = array_column($V, $k->kode_kriteria);
            if($k->tipe_kriteria==='benefit'){
                $idealPos[$k->kode_kriteria] = max($col);
                $idealNeg[$k->kode_kriteria] = min($col);
            } else {
                $idealPos[$k->kode_kriteria] = min($col);
                $idealNeg[$k->kode_kriteria] = max($col);
            }
        }

        // 8) Jarak ke ideal
        $distPos = []; $distNeg = [];
        foreach($V as $i=>$r){
            $d1 = $d2 = 0;
            foreach($kriterias as $k){
                $d1 += pow($r[$k->kode_kriteria]-$idealPos[$k->kode_kriteria],2);
                $d2 += pow($r[$k->kode_kriteria]-$idealNeg[$k->kode_kriteria],2);
            }
            $distPos[$i] = sqrt($d1);
            $distNeg[$i] = sqrt($d2);
        }

        // 9) Hitung Ci & simpan
        $CiMap = [];
        DB::transaction(function() use($run,$alts,$distPos,$distNeg,&$CiMap){
            foreach($alts as $i=>$alt){
                $Ci = ($distPos[$i]+$distNeg[$i])>0
                    ? $distNeg[$i]/($distPos[$i]+$distNeg[$i])
                    : 0;
                SkorTopsis::updateOrCreate(
                    ['id_skor_tipe'=>$run->id_skor_tipe,
                     'id_laporan_fasilitas'=>$alt->id_laporan_fasilitas],
                    ['skor'=>$Ci]
                );
                $CiMap[$alt->id_laporan_fasilitas] = $Ci;
            }
        });

        // 10) Cache langkah perhitungan 60 menit
        Cache::put("topsis.steps.{$run->id_skor_tipe}", [
            'kriterias'   => $kriterias,
            'alternatifs' => $alts,
            'norm'        => $norm,
            'V'           => $V,
            'idealPos'    => $idealPos,
            'idealNeg'    => $idealNeg,
            'distPos'     => $distPos,
            'distNeg'     => $distNeg,
            'Ci'          => $CiMap,
            'runId'       => $run->id_skor_tipe
        ], now()->addDays(3));

        // Redirect ke index dengan runId
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
