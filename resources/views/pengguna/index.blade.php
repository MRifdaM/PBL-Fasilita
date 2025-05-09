@extends('layouts.main')

@section('content')
  <div class="w-100 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title my-5 w-25">Data Pengguna</h3>
            <div>
                <button class="btn btn-success btn-sm mr-2">
                    <a href="{{ route('pengguna.export_excel') }}" class="text-white text-decoration-none">
                        <i class="fa fa-file-excel"></i> Excel
                    </a>
                </button>
                <button class="btn btn-danger btn-sm mr-2">
                    <a href="{{ route('pengguna.export_pdf') }}" class="text-white text-decoration-none" target="_blank">
                        <i class="fa fa-file-pdf"></i> PDF
                    </a>
                </button>
                <button class="btn btn-success btn-sm mr-2" onclick="modalAction('{{ route('pengguna.import') }}')">
                    <i class="fa fa-file-import"></i> Import
                </button>
                <button class="btn btn-primary btn-sm" onclick="modalAction('{{ route('pengguna.create') }}')">
                    Tambah Pengguna
                </button>
            </div>
        </div>

        {{-- Filter Role --}}
        <div class="mb-3">
          <label for="filter-role">Filter Peran:</label>
          <select id="filter-role" class="form-control w-25">
            <option value="">Semua</option>
            @foreach($peran as $role)
              <option value="{{ $role->id_peran }}">{{ $role->nama_peran }}</option>
            @endforeach
          </select>
        </div>

        <div class="table-responsive">
          <table class="table table-hover table-striped" id="table-pengguna">
            <thead>
              <tr>
                <th>No</th>
                <th>Username Pengguna</th>
                <th>Nama Pengguna</th>
                <th>Peran</th>
                <th>Aksi</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>

  {{-- Modal container --}}
  <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog"
       data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true">
  </div>
@endsection

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    var tablePengguna;
    $(document).ready(function() {
        tablePengguna = $('#table-pengguna').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": "{{ route('pengguna.list') }}",
            "dataType": "json",
            "type": "GET",
            "data": function(d) {
                d.role_id = $('#filter-role').val();
            },
            error: function(xhr) {
                if (xhr.status === 403 || xhr.status === 401) {
                    window.location.href = '{{ route('dashboard') }}';
                }
            }
        },
        columns: [
            { data: 'DT_RowIndex',     name: 'DT_RowIndex',     orderable: false, searchable: false },
            { data: 'username',        name: 'username' },
            { data: 'nama',            name: 'nama' },
            { data: 'peran.nama_peran',name: 'peran.nama_peran' },
            { data: 'aksi',            name: 'aksi',            orderable: false, searchable: false },
        ]
        });

        // Reload saat filter berubah
        $('#filter-role').on('change', function() {
            tablePengguna.ajax.reload();
        });

    });
</script>
@endpush
