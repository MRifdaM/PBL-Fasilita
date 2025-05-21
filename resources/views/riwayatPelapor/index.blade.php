@extends('layouts.main')

@section('content')
<div class="container-fluid">

  {{-- 1) BARIS RINGKASAN STATUS --}}
  <div class="row gx-3 gy-4 mb-5">
    @foreach($counts as $status => $cnt)
      @php
        // mapping status → [mdi-icon, kelas warna]
        $icons = [
          'Menunggu Aktivasi'    => ['mdi-history',                         'text-warning'],
          'Aktivasi Laporan'     => ['mdi-checkbox-marked-circle-outline',  'text-success'],
          'Laporan Diproses'     => ['mdi-file-document-outline',           'text-primary'],
          'Laporan Diterima'     => ['mdi-file-document-check-outline',     'text-success'],
          'Laporan Ditolak'      => ['mdi-file-cancel-outline',             'text-danger'],
          'Edit Laporan'         => ['mdi-pencil-box-outline',              'text-secondary'],
        ];
        // fallback jika ada status baru
        $m = $icons[$status] ?? ['mdi-file-outline','text-secondary'];
      @endphp
      

      <div class="col-6 col-md-4 col-lg-2">
        <div class="card border-0 shadow-sm rounded-3 h-100">
          <div class="card-body d-flex align-items-center">
            <i class="mdi {{ $m[0] }} {{ $m[1] }}" style="font-size:1.5rem;"></i>
            <div class="ms-3">
              <small class="text-muted">{{ $status }}</small><br>
              <span class="h5 mb-0">{{ $cnt }}</span>
            </div>
          </div>
        </div>
      </div>
    @endforeach

    {{-- tombol tambah (“+”) --}}
    <div class="col-6 col-md-4 col-lg-2">
      <div class="card border-0 shadow-sm rounded-3 h-100 d-flex align-items-center justify-content-center">
      </div>
    </div>
  </div>

  {{-- 2) TABEL RIWAYAT --}}
  <div class="card">
    <div class="card-body">
      <h5 class="card-title mb-4">Daftar Riwayat Pelaporan</h5>

      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle" id="riwayat-table">
          <thead class="table-light">
            <tr>
              <th style="width:5%">No</th>
              <th>Fasilitas</th>
              <th>Gedung</th>
              <th>Ruangan</th>
              <th>Status</th>
              <th style="width:10%">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($reports as $item)
              @php
                $fac    = $item->fasilitas;
                $room   = $fac->ruangan;
                $lantai = $room->lantai;
                $ged    = $lantai->gedung;
              @endphp
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $fac->nama_fasilitas }}</td>
                <td>{{ $ged->nama_gedung }}</td>
                <td>{{ $room->kode_ruangan }}</td>
                <td>
                  @php
                    $badge = match($item->status->nama_status){
                      'Menunggu Aktivasi'=>'bg-warning text-dark',
                      'Aktivasi Laporan'=>'bg-success',
                      'Laporan Diproses'=>'bg-primary',
                      'Laporan Diterima'=>'bg-success',
                      'Laporan Ditolak'=>'bg-danger',
                      'Edit Laporan'=>'bg-info text-white',
                      default=>'bg-secondary',
                    };
                  @endphp
                  <span class="badge {{ $badge }}">
                    {{ $item->status->nama_status }}
                  </span>
                </td>
                <td>
                  {{-- Tombol Edit --}}
                  <a href="{{ route('riwayatPelapor.edit', $item->id_laporan_fasilitas) }}"
                     class="btn btn-sm btn-outline-warning me-1">
                    <i class="mdi mdi-pencil-box-outline"></i>
                  </a>
                  {{-- Tombol Detail --}}
                  <a href="{{ route('riwayatPelapor.show', $item->id_laporan_fasilitas) }}"
                     class="btn btn-sm btn-outline-primary">
                    <i class="mdi mdi-file-document-box"></i>
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center">Belum ada riwayat pelaporan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>
@endsection
