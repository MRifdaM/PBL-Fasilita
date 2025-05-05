<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Skydash Admin</title>

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
            <div class="col-md-5 d-flex flex-column justify-content-between">
                <img src="{{ asset('assets/images/fasilita-logo.png') }}" class="img-fluid" style="max-width: 100px"
                    alt="">
                <form class="forms-sample pr-5" action="{{ route('login.attempt') }}" method="POST">
                    @csrf
                    <div class="my-auto">
                        <div class="text-center my-5">
                            <h3>Welcome Back</h3>
                            <h6>Sistem pelaporan dan perbaikan fasilitas kampus yang cepat dan terpercaya.</h6>
                        </div>
                        <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username"
                        placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password"
                        placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                    {{-- <button class="btn btn-light">Cancel</button> --}}
                    <h6 class="mt-5">Belum punya akun? <a href="{{ url('/register') }}">register</a></h6>
                </div>
                </form>
                <div>

                </div>
            </div>
            <div class="col-md-7 rounded-lg px-0"
                style="background-image: url('{{ asset('assets/images/bg-register2.png') }}')">
                <div class="d-flex flex-column h-100 justify-content-between">
                    <div class="d-flex flex-row justify-content-between h-25">
                        <div class="w-50 px-4">
                            <div class="d-flex justify-content-around align-items-center border border-white text-white py-1 px-2 mt-5 w-100" style="border-radius: 30px 30px">
                                <button type="button" class="btn btn-light btn-rounded btn-icon font-weight-bold" style="color: #4B49AC">
                                    <h3 class="m-0 font-weight-bold">?</h3>
                                  </button>
                                <h5 class="m-0">
                                    Jangan abaikan kerusakan.
                                </h5>
                            </div>
                        </div>
                        <div class="bg-white w-50 pl-3 align-content-center" style="border-radius: 0 0 0 30px; margin-top: -1px">
                            <div class="stretch-card transparent h-75">
                                <div class="card card-dark-blue">
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
    <!-- End custom js for this page-->
</body>

</html>
