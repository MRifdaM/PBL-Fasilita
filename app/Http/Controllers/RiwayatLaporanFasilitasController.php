<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class RiwayatLaporanFasilitasController extends Controller
{
    public function list(Request $request)
    {
        $userId = auth()->user()->id_pengguna;

        $data = Laporan::select([
                'id_laporan',
                'id_pengguna',
                'id_gedung',
                'id_lantai',
                'id_ruangan',
                'created_at'
            ])
            ->with([
                'gedung:id_gedung,nama_gedung',
                'lantai:id_lantai,nama_lantai',
                'ruangan:id_ruangan,nama_ruangan',
                'laporanFasilitas:id_laporan_fasilitas,id_laporan,id_fasilitas,deskripsi,path_foto',
                'laporanFasilitas.fasilitas:id_fasilitas,nama_fasilitas'
            ])
            ->where('id_pengguna', $userId)
            ->latest();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('gedung', fn($row) => optional($row->gedung)->nama_gedung ?? '-')
            ->addColumn('lantai', fn($row) => optional($row->lantai)->nama_lantai ?? '-')
            ->addColumn('ruangan', fn($row) => optional($row->ruangan)->nama_ruangan ?? '-')
            ->addColumn('fasilitas', function ($row) {
                return optional($row->laporanFasilitas->first()->fasilitas)->nama_fasilitas ?? '-';
            })
            ->addColumn('deskripsi', function ($row) {
                return optional($row->laporanFasilitas->first())->deskripsi ?? '-';
            })
            ->addColumn('gambar', function ($row) {
                $foto = optional($row->laporanFasilitas->first())->path_foto;
                return $foto
                    ? '<img src="' . asset('storage/' . $foto) . '" alt="gambar" width="100">'
                    : '-';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d-m-Y');
            })
            ->addColumn('aksi', function ($row) {
                $url = url('/laporan/show/' . $row->id_laporan); 
                return '<button onclick="modalAction(\'' . $url . '\')" type="button" class="btn btn-info btn-sm btn-edit">
                            <i class="mdi mdi-file-document-box"></i>
                        </button>';
            })
            ->rawColumns(['gambar', 'aksi'])
            ->make(true);
    }

    public function show($id)
    {
        $laporan = Laporan::with([
            'gedung',
            'lantai',
            'ruangan',
            'laporanFasilitas.fasilitas',
            'laporanFasilitas.kategoriKerusakan',
            'laporanFasilitas.status'
        ])->find($id);

        if (!$laporan) {
            return response()->json(['status' => false, 'message' => 'Laporan tidak ditemukan']);
        }

        return response()->json([
            'status' => true,
            'data' => $laporan
        ]);
    }
}
