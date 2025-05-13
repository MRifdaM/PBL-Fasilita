<?php

namespace App\Http\Controllers;

use App\Models\KategoriKerusakan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KategoriKerusakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Halaman Kategori Kerusakan', 'url' => route('kategori_kerusakan.index')]
        ];

        $activeMenu = 'kategoriKerusakan';
        return view('kategori_kerusakan.index', compact('activeMenu', 'breadcrumbs'));
    }
//id_kerusakan
    public function list(){
        $data = KategoriKerusakan::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function($row) {
                $btn = '<div class="btn-group">
                    <button onclick="modalAction(\'' . url('kategori_kerusakan/edit/' . $row->id_kategori_kerusakan) . '\')" type="button" class="btn btn-warning btn-sm btn-edit">
                        <i class="mdi mdi-pencil"></i>
                    </button>
                    <button onclick="modalAction(\'' . url('kategori_kerusakan/show/' . $row->id_kategori_kerusakan) . '\')" type="button" class="btn btn-info btn-sm btn-edit">
                        <i class="mdi mdi-file-document-box"></i>
                    </button>
                    <button onclick="modalAction(\'' . url('kategori_kerusakan/delete/' . $row->id_kategori_kerusakan) . '\')" type="button" class="btn btn-danger btn-sm btn-delete" data-id="'.$row->id_kategori_kerusakan.'">
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
        return view('kategori_kerusakan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_kerusakan' => 'required|string|min:3|unique:kategori_kerusakan,kode_kerusakan',
                'nama_kerusakan' => 'required|string|max:100',
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

            KategoriKerusakan::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data kategori kerusakan berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kategoriKerusakan = KategoriKerusakan::find($id);
        return view('kategori_kerusakan.show',[
            'kategoriKerusakan' => $kategoriKerusakan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategoriKerusakan = kategoriKerusakan::find($id);
        return view('kategori_kerusakan.edit',[
            'kategoriKerusakan' => $kategoriKerusakan
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
                'kode_kerusakan' => 'required|string|min:3|unique:kategori_kerusakan,kode_kerusakan,'.$id.',id_kategori_kerusakan',
                'nama_kerusakan' => 'required|string|max:100',
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

            $check = kategoriKerusakan::find($id);
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
        $kategoriKerusakan = kategoriKerusakan::find($id);
        return view('kategori_kerusakan.delete',[
            'kategoriKerusakan' => $kategoriKerusakan
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $kategoriKerusakan = kategoriKerusakan::find($id);
            if ($kategoriKerusakan) {
                $kategoriKerusakan->delete();
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
