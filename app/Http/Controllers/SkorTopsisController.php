<?php

namespace App\Http\Controllers;

use App\Models\Peran;
use App\Models\SkorTipe;
use App\Models\SkorTopsis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SkorTopsisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        // Breadcrumbs dan filter peran
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Prioritas Perbaikan', 'url' => route('skorTopsis.index')],
        ];
        // Hanya Mahasiswa, Dosen, Tendik
        $roles = Peran::whereIn('kode_peran',['MHS','DSN','TDK'])
                    ->select('id_peran','nama_peran')
                    ->get();

        return view('skorTopsis.index', compact('breadcrumbs','roles'));
    }

    public function list(Request $request)
    {
         // Ambil global run terbaru
    $run = SkorTipe::where('tipe', 'global')
           ->latest('id_skor_tipe')
           ->firstOrFail();

    // Query builder dengan join, hanya kolom yang diperlukan
    $query = DB::table('skor_topsis as s')
        ->join('laporan_fasilitas as lf', 's.id_laporan_fasilitas', '=', 'lf.id_laporan_fasilitas')
        ->join('fasilitas as f',         'lf.id_fasilitas',        '=', 'f.id_fasilitas')
        ->join('laporan as l',           'lf.id_laporan',          '=', 'l.id_laporan')
        ->join('pengguna as u',          'l.id_pengguna',          '=', 'u.id_pengguna')
        ->join('peran as p',             'u.id_peran',             '=', 'p.id_peran')
        ->where('s.id_skor_tipe', $run->id_skor_tipe)
        // Filter peran langsung di join
        ->when($request->filled('role_id'), function($q) use($request){
            $q->where('p.id_peran', $request->role_id);
        })
        ->select([
            's.id_skor_topsis',
            'f.nama_fasilitas as alternatif',
            'u.nama              as pelapor',
            'p.nama_peran        as peran',
            's.skor',
        ]);

    return DataTables::of($query)
        ->addIndexColumn()
        ->editColumn('skor', fn($row) => number_format($row->skor, 4))
        ->addColumn('aksi', function($row) {
            $url = route('skorTopsis.assign', $row->id_skor_topsis);
            return "<button class='btn btn-sm btn-success assign' data-url='$url'>Tugaskan</button>";
        })
        ->rawColumns(['aksi'])
        ->orderColumns(['skor'], ':column $1')
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SkorTopsis $skorTopsis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SkorTopsis $skorTopsis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SkorTopsis $skorTopsis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SkorTopsis $skorTopsis)
    {
        //
    }
}
