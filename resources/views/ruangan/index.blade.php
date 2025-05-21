@extends('layouts.main')

@section('content')
  {{-- Breadcrumb --}}
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('gedung.index') }}">Gedung</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('gedung.lantai.index', $lantai->gedung) }}">
          {{ $lantai->gedung->nama_gedung }}
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ $lantai->nomor_lantai }}
      </li>
    </ol>
  </nav>

  <div class="card">
  <div class="card-body">

    <div class="d-flex justify-content-between mb-3">
      <button class="btn btn-primary"
              onclick="modalAction('{{ route('lantai.ruangan.create',$lantai) }}')">
        <i class="mdi mdi-plus"></i> Tambah Ruangan
      </button>
    </div>

    <table class="table table-hover" id="table-ruangan">
      <thead>
        <tr>
          <th>No</th>
          <th>Kode</th>
          <th>Nama</th>
          <th>Aksi</th>
        </tr>
      </thead>
    </table>

  </div>
</div>

<div id="myModal" class="modal fade" tabindex="-1" aria-hidden="true"></div>
@endsection

@push('js')
<script>
  function modalAction(url){
    $('#myModal').load(url, ()=> $('#myModal').modal('show'));
  }

  window.tableRuangan = $('#table-ruangan').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "{{ route('lantai.ruangan.list',$lantai) }}",
      type: 'GET'
    },
    columns: [
      { data: 'DT_RowIndex', orderable:false, searchable:false },
      { data: 'kode_ruangan' },
      { data: 'nama_ruangan' },
      { data: 'aksi', orderable:false, searchable:false },
    ]
  });
</script>
@endpush
