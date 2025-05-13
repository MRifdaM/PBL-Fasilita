@extends('layouts.main')

@section('content')
<div class="card">
  <div class="card-body">

    <div class="d-flex justify-content-between mb-3">
      <a href="{{ route('gedung.lantai.index',$lantai->gedung) }}" class="btn btn-secondary">
        <i class="mdi mdi-arrow-left"></i> Kembali
      </a>
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
