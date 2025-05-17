<?php

namespace App\Http\Controllers;

use App\Models\Lantai;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Fasilitas;
use App\Models\Gedung;

class RuanganController extends Controller
{
    // 1️⃣ Index: daftar untuk satu lantai
    public function index(Lantai $lantai)
    {
        return view('ruangan.index', compact('lantai'));
    }

    // 2️⃣ AJAX list untuk DataTables
    public function list(Lantai $lantai)
    {
        $query = $lantai->ruangan()
                        ->select(['id_ruangan','kode_ruangan','nama_ruangan']);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function($row){
                // URL detail fasilitas
                $urlFas  = route('ruangan.fasilitas.index', $row->id_ruangan);
                $urlEdit = route('ruangan.edit',           $row->id_ruangan);
                $urlDel  = route('ruangan.delete',         $row->id_ruangan);

                return <<<HTML
<div class="btn-group">
  <!-- Detail ↪ fasilitas -->
  <button onclick="window.location='$urlFas'" class="btn btn-success btn-sm">
    <i class="mdi mdi-format-list-bulleted"></i>
  </button>
  <!-- Edit -->
  <button onclick="modalAction('$urlEdit')" class="btn btn-warning btn-sm">
    <i class="mdi mdi-pencil"></i>
  </button>
  <!-- Delete -->
  <button onclick="modalAction('$urlDel')" class="btn btn-danger btn-sm">
    <i class="mdi mdi-delete"></i>
  </button>
</div>
HTML;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    // 3️⃣ Create form
    public function create(Lantai $lantai)
    {
        return view('ruangan.create', compact('lantai'));
    }

    // 4️⃣ Store new
    public function store(Request $r, Lantai $lantai)
    {
        $r->validate([
            'kode_ruangan' => 'required|max:20|unique:ruangan,kode_ruangan',
            'nama_ruangan' => 'required|max:100',
        ]);

        $lantai->ruangan()->create($r->only('kode_ruangan','nama_ruangan'));

        return response()->json(['status'=>true,'message'=>'Ruangan ditambahkan']);
    }

    // 5️⃣ Edit form
    public function edit(Ruangan $ruangan)
    {
        return view('ruangan.edit', compact('ruangan'));
    }

    // 6️⃣ Update existing
    public function update(Request $r, Ruangan $ruangan)
    {
        $r->validate([
            'kode_ruangan' => [
                'required','max:20',
                Rule::unique('ruangan','kode_ruangan')
                    ->ignore($ruangan->id_ruangan,'id_ruangan'),
            ],
            'nama_ruangan' => 'required|max:100',
        ]);

        $ruangan->update($r->only('kode_ruangan','nama_ruangan'));

        return response()->json(['status'=>true,'message'=>'Ruangan diperbarui']);
    }

    // 7️⃣ Delete confirmation form
    public function delete(Ruangan $ruangan)
    {
        return view('ruangan.delete', compact('ruangan'));
    }

    // 8️⃣ Destroy
    public function destroy(Ruangan $ruangan)
    {
        // 1) Hapus dulu semua fasilitas di ruangan ini
        $ruangan->fasilitas()->delete();

        // 2) Baru hapus ruangan-nya
        $ruangan->delete();

        return response()->json([
          'status'  => true,
          'message' => 'Ruangan dan fasilitasnya berhasil dihapus'
        ]);
    }

    // 9️⃣ Show detail
    public function show(Ruangan $ruangan)
    {
        return view('ruangan.show', compact('ruangan'));
    }

    public function fasilitas()
{
    return $this->hasMany(Fasilitas::class, 'id_ruangan');
}
}
