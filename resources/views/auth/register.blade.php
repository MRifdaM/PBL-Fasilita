<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register – FASILITA</title>
<!-- plugins:css -->
<link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">

<!-- endinject -->
<!-- Plugin css for this page -->
<link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/js/select.dataTables.min.css') }}">
<!-- End plugin css for this page -->

<!-- inject:css -->
<link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">

<link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">

<!-- endinject -->
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
</head>

<body>
    <main class="container" style="height: 700px">
        <div class="row py-5 h-100">
            <div class="col-md-5">
                <img src="{{ asset('assets/images/fasilita-logo.png') }}" class="img-fluid mb-5"
                    style="max-width: 100px" alt="">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}" class="forms-sample" id="form-register">
                    @csrf

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" id="nama" name="nama"
                            class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                            placeholder="Nama Lengkap">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username"
                            class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}"
                            placeholder="Username">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control" placeholder="Konfirmasi Password">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                </form>

                <p class="mt-3">
                    Sudah punya akun?
                    <a href="{{ route('login') }}">Login di sini</a>
                </p>
            </div>
            <div class="col-md-7 px-0"
                style="background-image: url('{{ asset('assets/images/bg-register2.png') }}'); border-radius: 30px">
                <div class="d-flex flex-column h-100 justify-content-between">
                    <div class="d-flex flex-row justify-content-between h-25">
                        <div class="w-50 px-4">
                            <div class="d-flex justify-content-around align-items-center border border-white text-white py-1 px-2 mt-5 w-100"
                                style="border-radius: 30px 30px">
                                <button type="button" class="btn btn-light btn-rounded btn-icon font-weight-bold"
                                    style="color: #4B49AC">
                                    <h3 class="m-0 font-weight-bold">?</h3>
                                </button>
                                <h5 class="m-0">
                                    Jangan abaikan kerusakan.
                                </h5>
                            </div>
                        </div>
                        <div class="bg-white w-50 pl-3 " style="border-radius: 0 0 0 30px; margin-top: -1px; ">
                            <div class="stretch-card transparent h-100 pb-3">
                                <div class="card card-dark-blue" style="border-radius: 0 30px 0 30px;">
                                    <div class="card-body d-flex flex-column justify-content-end">
                                        <h3>100%</h3>
                                        <h5>Setiap laporan segera diproses</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-100">
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4>Temukan Masalah di Sekitarmu?</h4>
                                    <p>Sudah 124 mahasiswa menggunakan FASILITA minggu ini!</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- plugins:js -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.select.min.js') }}"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>

    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
    <!-- End plugin js for this page -->

    <!-- inject:js -->
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <!-- endinject -->

    <!-- Custom js for this page-->
    <script src="{{ asset('assets/js/chart.js') }}"></script>
    <!-- endinject -->

    <!-- Custom js for this page-->
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/Chart.roundedBarCharts.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/additional-methods.min.js') }}"></script>
    <!-- End custom js for this page-->
    <script>
        $(document).ready(function() {
            $('#form-register').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                // Bersihkan error sebelumnya
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert('Berhasil disimpan!');
                        // Redirect atau reset form
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, val) {
                                let input = $('[name="' + key + '"]');
                                input.addClass('is-invalid');
                                input.after('<div class="invalid-feedback">' + val[0] +
                                    '</div>');
                            });
                        } else {
                            alert('Terjadi kesalahan server');
                        }
                    }
                });
            });
        });
    </script>
</body>


</html>
