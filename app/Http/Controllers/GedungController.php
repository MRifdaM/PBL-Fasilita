<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class GedungController extends Controller
{
    /* ----------  LIST PAGE  ---------- */
    public function index()
    {
        return view('gedung.index');
    }

    /* ----------  DATATABLES AJAX  ---------- */
    public function list()
    {
        $data = Gedung::select('id_gedung', 'kode_gedung', 'nama_gedung');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return '
                <div class="btn-group">

                    <!-- tombol PILIH (lihat lantai) -->
                    <button onclick="window.location=\'' .
                        route('gedung.lantai.index', $row->id_gedung) . '\'"
                        class="btn btn-success btn-sm">
                        <i class="mdi mdi-layers mr-1"></i>Pilih
                    </button>

                    <!-- tombol EDIT -->
                    <button onclick="modalAction(\'' .
                        route('gedung.edit', $row->id_gedung) . '\')"
                        class="btn btn-warning btn-sm">
                        <i class="mdi mdi-pencil"></i>
                    </button>

                    <!-- tombol HAPUS -->
                    <button onclick="modalAction(\'' .
                        route('gedung.delete', $row->id_gedung) . '\')"
                        class="btn btn-danger btn-sm">
                        <i class="mdi mdi-delete"></i>
                    </button>
                </div>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /* ----------  MODAL TAMBAH  ---------- */
    public function create()
    {
        return view('gedung.create');   // modal blade
    }

    public function store(Request $r)
    {
        $r->validate([
            'kode_gedung' => 'required|max:10|unique:gedung,kode_gedung',
            'nama_gedung' => 'required|max:100',
        ]);

        Gedung::create($r->only('kode_gedung', 'nama_gedung'));
        return response()->json(['status' => true, 'message' => 'Gedung ditambahkan']);
    }

    /* ----------  MODAL EDIT / UPDATE  ---------- */
    public function edit(Gedung $gedung) {
        return view('gedung.edit', compact('gedung'));
    }

    public function update(Request $r, Gedung $gedung)
    {
        $r->validate([
            'kode_gedung' => [
                'required','max:10',
                Rule::unique('gedung','kode_gedung')->ignore($gedung->id_gedung,'id_gedung'),
            ],
            'nama_gedung' => 'required|max:100',
        ]);

        $gedung->update($r->only('kode_gedung', 'nama_gedung'));
        return response()->json(['status' => true, 'message' => 'Gedung diperbarui']);
    }

    /* ----------  MODAL HAPUS / DESTROY  ---------- */
    public function delete(Gedung $gedung)
    {
        return view('gedung.delete', compact('gedung'));
    }

    public function destroy(Gedung $gedung)
    {
        $gedung->delete();
        return response()->json(['status' => true, 'message' => 'Gedung dihapus']);
    }

    /* ----------  MODAL DETAIL  ---------- */
    public function show(Gedung $gedung)
    {
        return view('gedung.show', compact('gedung'));
    }
}
