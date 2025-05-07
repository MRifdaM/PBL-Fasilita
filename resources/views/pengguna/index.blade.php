@extends('layouts.main')

@section('content')
    <div class="w-100 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Pengguna</h4>
                <div class="table-responsive">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
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
@endsection

@push('css')
@endpush

@push('js')
    <script>
        var tablePengguna;
        $(document).ready(function() {
            tablePengguna = $('#table-pengguna').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url":"{{ route('pengguna.list') }}",
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
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'peran.nama_peran',
                        name: 'peran.nama_peran'
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
