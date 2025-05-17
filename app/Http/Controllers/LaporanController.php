<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Pengguna;
use App\Models\Gedung;
use App\Models\Lantai;
use App\Models\Ruangan;
use App\Models\LaporanFasilitas;
use App\Models\PenilaianPengguna;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Halaman Laporan', 'url' => route('laporan.index')]
        ];

        $activeMenu = 'laporan';
        return view('laporan.index', compact('activeMenu', 'breadcrumbs'));
    }

    public function list()
    {
        $data = Laporan::select('id_laporan', 'id_pengguna', 'id_gedung', 'id_lantai', 'id_ruangan', 'is_active', 'created_at')
            ->with([
                'pengguna',
                'gedung',
                'lantai',
                'ruangan',
                'laporanFasilitas',
                'penilaianPengguna'
            ]);
        return DataTables::of($data)
            ->addIndexColumn()
            // Format tanggal di sini
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d-m-Y');
            })
            ->addColumn('aksi', function ($row) {
                $btn = '<div class="btn-group">
                    <button onclick="modalAction(\'' . url('/laporan/edit/' . $row->id_laporan) . '\')" type="button" class="btn btn-warning btn-sm btn-edit">
                        <i class="mdi mdi-pencil"></i>
                    </button>
                    <button onclick="modalAction(\'' . url('/laporan/show/' . $row->id_laporan) . '\')" type="button" class="btn btn-info btn-sm btn-edit">
                        <i class="mdi mdi-file-document-box"></i>
                    </button>
                    <button onclick="modalAction(\'' . url('/laporan/delete/' . $row->id_laporan) . '\')" type="button" class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id_laporan . '">
                        <i class="mdi mdi-delete"></i>
                    </button>
                </div>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Halaman Laporan', 'url' => route('laporan.index')],
            ['title' => 'Tambah Laporan', 'url' => route('laporan.create')]
        ];

        $activeMenu = 'laporan';

        $gedung = Gedung::all();
        $lantai = Lantai::all();
        $ruangan = Ruangan::all();

        return view('laporan.create', [
            'gedung' => $gedung,
            'lantai' => $lantai,
            'ruangan' => $ruangan,
            'activeMenu' => $activeMenu,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function getLantai($idGedung)
    {
        return response()->json(Lantai::where('id_gedung', $idGedung)->get());
    }

    public function getRuangan($idLantai)
    {
        return response()->json(Ruangan::where('id_lantai', $idLantai)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_pengguna' => 'required|integer',
                'id_gedung' => 'required|integer',
                'id_lantai' => 'required|integer',
                'id_ruangan' => 'required|integer',
                'is_active' => 'required|string',
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }

            Laporan::create([
                'id_pengguna' => $request->id_pengguna,
                'id_gedung' => $request->id_gedung,
                'id_lantai' => $request->id_lantai,
                'id_ruangan' => $request->id_ruangan,
                'is_active' => $request->is_active,
                'created_at' => now()
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data laporan berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $laporan = Laporan::find($id);
        $laporanFasilitas = LaporanFasilitas::with([
            'fasilitas',
            'kategoriKerusakan',
            'status',
            'riwayatLaporanFasilitas',
            'penugasan',
            'penilaian',
            'skorTopsis'
        ])->where('id_laporan', $id)->get();
        return view('laporan.show', [
            'laporan' => $laporan,
            'laporanFasilitas' => $laporanFasilitas
        ],);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $laporan = Laporan::find($id);

        return view('laporan.edit', [
            'laporan' => $laporan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // cek apakah request dari ajax 
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_peran' => 'required|string|min:3|unique:peran,kode_peran,' . $id . ',id_peran',
                'nama_peran' => 'required|string|max:100',
            ];
            // use Illuminate\Support\Facades\Validator; 
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,    // respon json, true: berhasil, false: gagal 
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors()  // menunjukkan field mana yang error 
                ]);
            }

            $check = Laporan::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        redirect('/');
    }

    /**
     * Show data for confirmation before deletion.
     */
    public function delete(string $id)
    {
        $peran = Laporan::find($id);
        return view('peran.delete', [
            'peran' => $peran
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $peran = Laporan::find($id);
            if ($peran) {
                $peran->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        redirect('/');
    }
}
