@extends('layouts.main')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="mb-4">Fasilitas di {{ $ruangan->nama_ruangan }}</h4>
    <div class="d-flex justify-content-between mb-3">
      <a href="{{ route('lantai.ruangan.index', $ruangan->lantai) }}" class="btn btn-secondary">
  <i class="mdi mdi-arrow-left"></i> Kembali
</a>
      <button class="btn btn-primary"
              onclick="modalAction('{{ route('ruangan.fasilitas.create',$ruangan) }}')">
        <i class="mdi mdi-plus"></i> Tambah Fasilitas
      </button>
    </div>

    <table class="table table-hover" id="table-fasilitas">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Fasilitas</th>
          <th>Jumlah</th>
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

  window.tableFasilitas = $('#table-fasilitas').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "{{ route('ruangan.fasilitas.list',$ruangan) }}",
      type: 'GET'
    },
    columns:[
      { data:'DT_RowIndex', orderable:false, searchable:false },
      { data:'nama_fasilitas' },
      { data:'jumlah_fasilitas' },
      { data:'aksi', orderable:false, searchable:false },
    ]
  });
</script>
@endpush
