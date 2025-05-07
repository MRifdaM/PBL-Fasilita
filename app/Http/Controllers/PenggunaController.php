<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Halaman Pengguna', 'url' => route('pengguna.index')]
        ];

        $activeMenu = 'pengguna';
        return view('pengguna.index', compact('activeMenu', 'breadcrumbs'));
    }

    public function list()
    {
        $data = Pengguna::select('id_pengguna', 'username', 'nama', 'id_peran')
        ->with('peran');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn = '<div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm btn-edit" data-id="'.$row->id_pengguna.'">
                        <i class="mdi mdi-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="'.$row->id_pengguna.'">
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
    public function show(Pengguna $pengguna)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengguna $pengguna)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengguna $pengguna)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengguna $pengguna)
    {
        //
    }
}
