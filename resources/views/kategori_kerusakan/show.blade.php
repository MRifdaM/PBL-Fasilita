<div class="modal-dialog modal-lg w-50">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Data Kategori</h5>
            <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @empty($kategoriKerusakan)
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/kategori_kerusakan') }}" class="btn btn-warning">Kembali</a>
            </div>
        @else
            <div class="modal-body">
                <table class="table table-striped">
                    <tr>
                        <th>Kode Kategori Kerusakan</th>
                        <td>{{ $kategoriKerusakan->kode_kerusakan }}</td>
                    </tr>
                    <tr>
                        <th>Nama Kategori Kerusakan</th>
                        <td>{{ $kategoriKerusakan->nama_kerusakan }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
            </div>
        @endempty
    </div>
</div>