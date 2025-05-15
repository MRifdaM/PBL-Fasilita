@extends('layouts.main')

@section('content')
    <div class="w-100 grid-margin stretch-card">
        <div class="card">
            <div class="card-body w-auto">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title my-5 w-25">Data Kategori Kerusakan</h3>
                    <button class="btn btn-primary px-5" onclick="modalAction('{{ url('kategori_kerusakan/create') }}')">
                        Tambah Kategori Kerusakan
                    </button>
                </div>
                <div class="table-responsive">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <table class="table table-hover table-striped" id="table-kategori-kerusakan">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Kategori Kerusakan</th>
                                <th>Nama Kategori Kerusakan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true">
    </div>
@endsection

@push('css')

@endpush

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var tablePeran;
        $(document).ready(function() {
            tablePeran = $('#table-kategori-kerusakan').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('kategori_kerusakan/list') }}",
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
                        data: 'kode_kerusakan',
                        name: 'kode_kerusakan',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'nama_kerusakan',
                        name: 'nama_kerusakan',
                        orderable: true,
                        searchable: true
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
