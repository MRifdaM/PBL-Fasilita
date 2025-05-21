<?php

namespace App\Http\Controllers;


use App\Models\Status;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use App\Models\LaporanFasilitas;
use App\Models\RiwayatLaporanFasilitas;
use Yajra\DataTables\Facades\DataTables;


class RiwayatLaporanFasilitasController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['title' => 'Dashboard',          'url' => route('dashboard')],
            ['title' => 'Riwayat Laporan Fasilitas', 'url' => route('riwayat.index')],
        ];
        $activeMenu = 'laporanFasilitas';


        $statuses = Status::select('id_status','nama_status')->get();

        $petugas  = Pengguna::whereHas('peran', fn($q)=>
                      $q->whereIn('kode_peran',['ADM','SPR']))
                    ->select('id_pengguna','nama')
                    ->get();

        return view('riwayat.index', compact(
            'breadcrumbs','activeMenu','statuses','petugas'
        ));
    }

    public function list(Request $request)
    {
        $latest = RiwayatLaporanFasilitas::selectRaw('MAX(id_riwayat_laporan_fasilitas) as id')
                ->groupBy('id_laporan_fasilitas');

        $query = RiwayatLaporanFasilitas::with([
                    'laporanFasilitas.fasilitas',
                    'laporanFasilitas.laporan.pengguna',
                    'status',
                    'pengguna'
                ])
                ->whereIn('id_riwayat_laporan_fasilitas', function($q) use ($latest) {
                    $q->fromSub($latest, 'x')->select('x.id');
                });


        if ($request->filled('status_id')) {
            $query->where('id_status', $request->status_id);
        }


        if ($request->filled('petugas_id')) {
            $query->where('id_pengguna', $request->petugas_id);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('pelapor', fn($r) => $r->laporanFasilitas->laporan->pengguna->nama)
            ->addColumn('fasilitas', fn($r) => $r->laporanFasilitas->fasilitas->nama_fasilitas)
            ->addColumn('status', fn($r) => $r->status->nama_status)
            ->addColumn('petugas', fn($r) => $r->pengguna->nama)
            ->addColumn('waktu', fn($r) => $r->created_at->format('d-m-Y H:i'))
            ->addColumn('aksi', function($r) {
                // Gunakan id_laporan_fasilitas untuk route
                $lapfasId = $r->id_laporan_fasilitas;

                $showUrl = route('riwayat.show', $lapfasId);
                $editUrl = route('riwayat.edit', $lapfasId);
                $delUrl  = route('riwayat.destroy', $lapfasId);

                return
                "<button class='btn btn-sm btn-info' onclick=\"modalAction('$showUrl')\">
                    <i class='mdi mdi-eye'></i>
                </button> ".
                "<button class='btn btn-sm btn-warning' onclick=\"modalAction('$editUrl')\">
                    <i class='mdi mdi-pencil'></i>
                </button> ".
                "<button class='btn btn-sm btn-danger btn-delete' data-url='$delUrl'>
                    <i class='mdi mdi-trash'></i>
                </button>";
            })
            ->rawColumns(['aksi'])
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
     * Display the specified resource.
     */
    public function show($lapfasId)
    {
        $lapfas = LaporanFasilitas::with([
            'fasilitas',
            'kategoriKerusakan',
            'laporan.pengguna',
            'laporan.gedung',
            'laporan.lantai',
            'laporan.ruangan',
        ])->findOrFail($lapfasId);

        $riwayats = RiwayatLaporanFasilitas::with('status','pengguna')
                    ->where('id_laporan_fasilitas', $lapfasId)
                    ->orderBy('created_at')
                    ->get();

        return view('riwayat.show', [
            'lapfas'   => $lapfas,
            'riwayats' => $riwayats,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($lapfasId)
    {
        // ambil laporan fasilitas beserta relasi untuk header/modal
        $lapfas = LaporanFasilitas::with([
            'fasilitas',
            'laporan.pengguna',
            'laporan.gedung',
            'laporan.lantai',
            'laporan.ruangan',
        ])->findOrFail($lapfasId);

        // ambil entri riwayat terakhir
        $riwayat = RiwayatLaporanFasilitas::where('id_laporan_fasilitas', $lapfasId)
                    ->orderByDesc('id_riwayat_laporan_fasilitas')
                    ->firstOrFail();

        // semua opsi status
        $statuses = Status::all();

        return view('riwayat.edit', compact('lapfas','riwayat','statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $lapfasId)
    {
        $request->validate([
            'riwayat_id'    => 'required|exists:riwayat_laporan_fasilitas,id_riwayat_laporan_fasilitas',
            'new_status_id' => 'required|exists:status,id_status',
            'catatan'       => 'nullable|string',
        ]);

        // ambil laporan fasilitas
        $lapfas = LaporanFasilitas::findOrFail($lapfasId);

        // cek entri terakhir sesuai riwayat_id
        $last = RiwayatLaporanFasilitas::where('id_laporan_fasilitas', $lapfasId)
                  ->orderByDesc('id_riwayat_laporan_fasilitas')
                  ->first();
        abort_if($last->id_riwayat_laporan_fasilitas != $request->riwayat_id, 403,
                 'Hanya entry terakhir yang boleh diubah.');

        // update main status
        $lapfas->id_status = $request->new_status_id;
        $lapfas->save();

        // buat entri baru di riwayat
        RiwayatLaporanFasilitas::create([
            'id_laporan_fasilitas' => $lapfasId,
            'id_status'            => $request->new_status_id,
            'id_pengguna'          => auth()->id(),
            'catatan'              => $request->catatan,
        ]);

        return response()->json(['message'=>'Status berhasil diperbarui.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($lapfasId)
    {
    
    }
}
