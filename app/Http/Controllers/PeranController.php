<?php

namespace App\Http\Controllers;

use App\Models\Peran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PeranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Halaman Peran', 'url' => route('peran.index')]
        ];

        $activeMenu = 'peran';
        return view('peran.index', compact('activeMenu', 'breadcrumbs'));
    }

    public function list(){
        $data = Peran::select('id_peran', 'kode_peran', 'nama_peran');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function($row) {
                $btn = '<div class="btn-group">
                    <button onclick="modalAction(\'' . url('/peran/edit/' . $row->id_peran) . '\')" type="button" class="btn btn-warning btn-sm btn-edit">
                        <i class="mdi mdi-pencil"></i>
                    </button>
                    <button onclick="modalAction(\'' . url('/peran/delete/' . $row->id_peran) . '\')" type="button" class="btn btn-danger btn-sm btn-delete" data-id="'.$row->id_peran.'">
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
        return view('peran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_peran' => 'required|string|min:3|unique:peran,kode_peran',
                'nama_peran' => 'required|string|max:100',
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

            Peran::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data peran berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $peran = Peran::find($id);
        return view('peran.edit',[
            'peran' => $peran
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Show data for confirmation before deletion.
     */
    public function delete(string $id)
    {
        $peran = Peran::find($id);
        return view('peran.delete',[
            'peran' => $peran
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }
}
