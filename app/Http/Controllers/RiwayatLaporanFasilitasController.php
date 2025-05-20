<?php

namespace App\Http\Controllers;

use App\Models\LaporanFasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatLaporanFasilitasController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // hitung per-status
        $counts = [
            'Menunggu Aktivasi'   => LaporanFasilitas::whereHas('laporan', fn($q)=> $q->where('id_pengguna',$userId))
                                        ->where('id_status',1)->count(),
            'Aktivasi Laporan'    => LaporanFasilitas::whereHas('laporan', fn($q)=> $q->where('id_pengguna',$userId))
                                        ->where('id_status',2)->count(),
            'Laporan Diproses'    => LaporanFasilitas::whereHas('laporan', fn($q)=> $q->where('id_pengguna',$userId))
                                        ->where('id_status',3)->count(),
            'Laporan Diterima'    => LaporanFasilitas::whereHas('laporan', fn($q)=> $q->where('id_pengguna',$userId))
                                        ->where('id_status',4)->count(),
            'Laporan Ditolak'     => LaporanFasilitas::whereHas('laporan', fn($q)=> $q->where('id_pengguna',$userId))
                                        ->where('id_status',5)->count(),
            'Edit Laporan'        => LaporanFasilitas::whereHas('laporan', fn($q)=> $q->where('id_pengguna',$userId))
                                        ->where('id_status',6)->count(),
        ];

        $reports = LaporanFasilitas::with([
                        'laporan',
                        'fasilitas.ruangan.lantai.gedung',
                        'status'
                    ])
                    ->whereHas('laporan', fn($q)=> $q->where('id_pengguna',$userId))
                    ->orderByDesc('created_at')
                    ->get();

        return view('riwayatPelapor.index', compact('counts','reports'));
    }

    public function show($id)
    {
        $lf = LaporanFasilitas::with([
                    'laporan',
                    'fasilitas.ruangan.lantai.gedung',
                    'status','riwayat.status','riwayat.pengguna'
                ])
                ->whereHas('laporan', fn($q)=> $q->where('id_pengguna',Auth::id()))
                ->findOrFail($id);

        // cek apakah status terakhir = Edit Laporan
        $last = $lf->riwayat->sortBy('created_at')->last();

        return view('riwayatPelapor.show', [
            'lf'      => $lf,
            'canEdit' => $last && $last->status->nama_status === 'Edit Laporan'
        ]);
    }

    public function edit($id)
    {
        $lf = LaporanFasilitas::with('riwayat.status')
                ->whereHas('laporan', fn($q)=> $q->where('id_pengguna',Auth::id()))
                ->findOrFail($id);

        // hanya jika status terakhir = Edit Laporan
        $last = $lf->riwayat->sortBy('created_at')->last();
        if (! $last || $last->status->nama_status !== 'Edit Laporan') {
            abort(403, 'Anda tidak diizinkan mengedit laporan ini.');
        }

        return view('riwayatPelapor.edit', compact('lf'));
    }

    public function update(Request $r, $id)
    {
        $lf = LaporanFasilitas::whereHas('laporan', fn($q)=> $q->where('id_pengguna',Auth::id()))
                ->findOrFail($id);

        // validasi input
        $r->validate([
            'jumlah_rusak' => 'required|integer|min:1',
            'deskripsi'    => 'required|string',
            'path_foto'    => 'nullable|image|max:2048',
        ]);

        // simpan perubahan
        $lf->jumlah_rusak = $r->input('jumlah_rusak');
        $lf->deskripsi    = $r->input('deskripsi');
        if ($file = $r->file('path_foto')) {
            $lf->path_foto = $file->store('laporan_foto','public');
        }
        // kembalikan ke “Menunggu Aktivasi” (id_status=1)
        $lf->id_status = 1;
        $lf->save();

        // catat riwayat
        $lf->riwayat()->create([
            'id_status'   => 1,
            'id_pengguna' => Auth::id(),
            'catatan'     => 'Mahasiswa edit ulang laporan',
        ]);

        return redirect()
               ->route('riwayatPelapor.show',$id)
               ->with('success','Laporan diperbarui. Menunggu konfirmasi admin.');
    }
}
