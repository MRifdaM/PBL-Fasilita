@extends('layouts.main')

@section('content')
    <div class="w-100 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Peran</h4>
                <div class="table-responsive">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <table class="table table-hover table-striped" id="table-peran">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Peran</th>
                                <th>Nama Peran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        var tablePerang;
        $(document).ready(function() {
            tablePerang = $('#table-peran').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url":"{{ url('peran/list') }}",
                    "dataType": "json",
                    "type": "GET"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kode_peran',
                        name: 'kode_peran'
                    },
                    {
                        data: 'nama_peran',
                        name: 'nama_peran'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    },
                ]
            })
        })
    </script>
@endpush
