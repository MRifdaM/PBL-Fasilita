@extends('layouts.main')

@section('content')
<div class="container-fluid">

  {{-- 1) Link “Back” --}}
  <div class="mb-2">
  <a href="{{ route('riwayatPelapor.index') }}"
     class="text-decoration-none text-dark">
    <i class="mdi mdi-arrow-left"></i> Back
  </a>
</div>

<h1 style="font-size: 2rem;"
    class="mt-4 mb-4"><strong>Detail Laporan</strong></h1>

  {{-- Banner Foto Kerusakan --}}
  <img 
      src="{{ $lf->path_foto 
            ? asset('uploads/laporan/'. $lf->path_foto) 
            : asset('storage/'.$lf->path_foto) }}"
    alt="Foto Kerusakan"
    class="img-fluid rounded-3 w-100 shadow-sm mb-5">

  {{-- Deskripsi --}}
  <div class="mb-5">
    <h5 class="fw-bold mb-2">Deskripsi</h5>
    <p class="text-muted">{{ $lf->deskripsi }}</p>
  </div>

  {{-- Detail Tempat --}}
  <h5 class="fw-bold mb-3">Detail Tempat</h5>
  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">

    {{-- Gedung --}}
    <div class="col">
      <div class="d-flex align-items-center p-3 bg-light rounded-3 shadow-sm h-100">
        <i class="mdi mdi-office-building-outline fs-3 text-secondary me-3"></i>
        <div>
          <small class="text-muted">Gedung</small>
          <div class="fw-semibold">{{ $lf->fasilitas->ruangan->lantai->gedung->nama_gedung }}</div>
        </div>
      </div>
    </div>

    {{-- Lantai --}}
    <div class="col">
      <div class="d-flex align-items-center p-3 bg-light rounded-3 shadow-sm h-100">
        <i class="mdi mdi-chart-timeline-variant fs-3 text-secondary me-3"></i>
        <div>
          <small class="text-muted">Lantai</small>
          <div class="fw-semibold">{{ $lf->fasilitas->ruangan->lantai->nomor_lantai }}</div>
        </div>
      </div>
    </div>

    {{-- Ruangan --}}
    <div class="col">
      <div class="d-flex align-items-center p-3 bg-light rounded-3 shadow-sm h-100">
        <i class="mdi mdi-door fs-3 text-secondary me-3"></i>
        <div>
          <small class="text-muted">Ruangan</small>
          <div class="fw-semibold">{{ $lf->fasilitas->ruangan->kode_ruangan }}</div>
        </div>
      </div>
    </div>

    {{-- Kategori Kerusakan --}}
    <div class="col">
      <div class="d-flex align-items-center p-3 bg-light rounded-3 shadow-sm h-100">
        <i class="mdi mdi-alert-circle-outline fs-3 text-secondary me-3"></i>
        <div>
          <small class="text-muted">Kategori Kerusakan</small>
          <div class="fw-semibold">
            {{ optional($lf->kategoriKerusakan)->nama_kategori ?? '-' }}
          </div>
        </div>
      </div>
    </div>

    {{-- Fasilitas --}}
    <div class="col">
      <div class="d-flex align-items-center p-3 bg-light rounded-3 shadow-sm h-100">
        <i class="mdi mdi-wrench fs-3 text-secondary me-3"></i>
        <div>
          <small class="text-muted">Fasilitas</small>
          <div class="fw-semibold">{{ $lf->fasilitas->nama_fasilitas }}</div>
        </div>
      </div>
    </div>

    {{-- Jumlah Rusak --}}
    <div class="col">
      <div class="d-flex align-items-center p-3 bg-light rounded-3 shadow-sm h-100">
        <i class="mdi mdi-counter fs-3 text-secondary me-3"></i>
        <div>
          <small class="text-muted">Jumlah Rusak</small>
          <div class="fw-semibold">{{ $lf->jumlah_rusak }}</div>
        </div>
      </div>
    </div>

  </div>

  {{-- Riwayat Status --}}
  <div class="mb-5">
    <ul class="list-unstyled">
      @foreach($lf->riwayatLaporanFasilitas->sortBy('created_at') as $r)
        <li class="d-flex mb-3">
          <span class="badge 
            @switch($r->status->nama_status)
              @case('Menunggu')      bg-warning text-dark @break
              @case('Terverifikasi') bg-success            @break
              @case('Diproses')      bg-primary            @break
              @case('Selesai')       bg-success            @break
              @case('Ditutup')       bg-danger             @break
              @default               bg-secondary         @endswitch
          ">
            {{ $r->status->nama_status }}
          </span>
          <div class="ms-3">
            <small class="text-muted">
              oleh <strong>{{ $r->pengguna->nama }}</strong>
              pada {{ $r->created_at->format('d M Y, H:i') }}
            </small>
            <p class="mb-0">{{ $r->catatan }}</p>
          </div>
        </li>
      @endforeach
    </ul>
  </div>

</div>
@endsection
