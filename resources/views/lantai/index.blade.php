@extends('layouts.main')

@section('content')
<div class="card">
  <div class="card-body">
    <h3 class="card-title">Lantai — {{ $gedung->nama_gedung }}</h3>
    

    <div class="mb-3"> <div class="d-flex justify-content-between">{{-- Tombol Kembali ke daftar Gedung --}}
        <a href="{{ route('gedung.index') }}" class="btn btn-secondary">
          <i class="mdi mdi-arrow-left"></i> Kembali
        </a><button class="btn btn-primary"
              onclick="modalAction('{{ route('gedung.lantai.create',$gedung) }}')">
        Tambah Lantai
      </button></div>
    </div>

    <table class="table table-striped" id="table-lantai">
      <thead>
        <tr>
          <th>No</th>
          <th>Nomor Lantai</th>
          <th>Aksi</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

{{-- modal wrapper --}}
<div id="myModal" class="modal fade" tabindex="-1" aria-hidden="true"></div>
@endsection

@push('js')
<script>
  // helper untuk load modal via AJAX
  function modalAction(url){
    $('#myModal').load(url, function(){
      $(this).modal('show');
    });
  }

  // jadikan window.tableLantai global
  window.tableLantai = $('#table-lantai').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "{{ route('gedung.lantai.list',$gedung) }}",
      type: 'GET'
    },
    columns: [
      { data:'DT_RowIndex', orderable:false, searchable:false },
      { data:'nomor_lantai' },
      { data:'aksi', orderable:false, searchable:false },
    ]
  });
</script>
@endpush

