@extends('layouts.main')

@section('content')
    <div class="w-100 grid-margin stretch-card">
        <div class="card">
            <div class="card-body w-auto">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title my-2 w-25">Data Laporan</h3>
                </div>
                <a href="{{ route('laporan.index') }}" class="btn btn-light"><i class="mdi mdi-arrow-left"> Kembali</i></a>

                <h3 class="my-2">Silakan lengkapi form di bawah ini dengan jelas dan detail.</h3>
                <p class="my-3">Data yang Anda isi akan membantu tim sarana dan prasarana kampus dalam menindaklanjuti
                    laporan secara
                    cepat dan tepat. Pastikan Anda menyertakan lokasi, jenis fasilitas, serta deskripsi kerusakan atau
                    masalah yang ditemukan.</p>
                <form class="my-5 w-100" id="form-tambah" method="post">
                    @csrf
                    <select class="form-control text-dark" id="inputGedung" name="id_gedung">
                        <option value="">Pilih Gedung</option>
                        @foreach ($gedung as $g)
                            <option value="{{ $g->id_gedung }}">{{ $g->nama_gedung }}</option>
                        @endforeach
                    </select>

                    <div class="my-5 d-flex justify-content-between gap-5" style="gap: 20px">
                        <select class="form-control text-dark" id="inputLantai" name="id_lantai" disabled>
                            <option value="">Pilih Lantai</option>
                        </select>

                        <select class="form-control text-dark" id="inputRuangan" name="id_ruangan" disabled>
                            <option value="">Pilih Ruangan</option>
                        </select>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#inputGedung').on('change', function() {
                const idGedung = $(this).val();
                $('#inputLantai').empty().append('<option value="">Pilih Lantai</option>').prop('disabled',
                    true);
                $('#inputRuangan').empty().append('<option value="">Pilih Ruangan</option>').prop(
                    'disabled', true);

                if (idGedung) {
                    $.ajax({
                        url: '/laporan/get-lantai/' + idGedung,
                        type: 'GET',
                        success: function(data) {
                            if (data.length > 0) {
                                $('#inputLantai').prop('disabled', false);
                                $.each(data, function(i, item) {
                                    $('#inputLantai').append(
                                        `<option value="${item.id_lantai}">${item.nomor_lantai}</option>`
                                    );
                                });
                            }
                        }
                    });
                }
            });

            $('#inputLantai').on('change', function() {
                const idLantai = $(this).val();
                $('#inputRuangan').empty().append('<option value="">Pilih Ruangan</option>').prop(
                    'disabled', true);

                if (idLantai) {
                    $.ajax({
                        url: '/laporan/get-ruangan/' + idLantai,
                        type: 'GET',
                        success: function(data) {
                            if (data.length > 0) {
                                $('#inputRuangan').prop('disabled', false);
                                $.each(data, function(i, item) {
                                    $('#inputRuangan').append(
                                        `<option value="${item.id_ruangan}">${item.nama_ruangan}</option>`
                                    );
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#form-tambah").validate({
                rules: {
                    kode_peran: {
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
                                tablePeran.ajax.reload();
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
