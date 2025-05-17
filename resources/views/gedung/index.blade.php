@extends('layouts.main')

@section('content')
<div class="w-100 grid-margin stretch-card">
  <div class="card">
    <div class="card-body w-auto">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="card-title my-2">Data Gedung</h3>
        <button class="btn btn-primary"
                onclick="modalAction('{{ route('gedung.create') }}')">
          Tambah Gedung
        </button>
      </div>

      <table class="table table-hover table-striped" id="table-gedung">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode Gedung</th>
            <th>Nama Gedung</th>
            <th>Aksi</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<div id="myModal" class="modal fade"></div>
@endsection

@push('js')
<script>
function modalAction(url = '') {
    $('#myModal').load(url, () => $('#myModal').modal('show'));
}

let tableGedung;
$(function () {
    tableGedung = $('#table-gedung').DataTable({
        processing: true,
        serverSide: true,
        ajax: { url: "{{ route('gedung.list') }}", type: 'GET' },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'kode_gedung', name: 'kode_gedung' },
            { data: 'nama_gedung', name: 'nama_gedung' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
        ]
    })
})
</script>
@endpush
