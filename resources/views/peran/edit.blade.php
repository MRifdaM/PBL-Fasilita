<div class="modal-dialog modal-lg w-50">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Peran</h5>
            <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @empty($peran)
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/peran') }}" class="btn btn-warning">Kembali</a>
            </div>
        @else
            <form id="form-edit">
                <div class="modal-body">
                    {{-- Form fields --}}
                    <div class="form-group">
                        <label>Kode Peran</label>
                        <input type="text" name="kode_peran" class="form-control" value="{{ $peran->kode_peran }}">
                    </div>
                    <div class="form-group">
                        <label>Nama Peran</label>
                        <input type="text" name="nama_peran" class="form-control" value="{{ $peran->nama_peran }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        @endempty
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            $("#form-edit").validate({
                rules: {
                    lkode_peran: {
                        required: true,
                        minlength: 3,
                        maxlength: 20
                    },
                    nama_peran: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                datalevel.ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endpush
