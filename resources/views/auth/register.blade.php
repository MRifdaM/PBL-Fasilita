<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register – FASILITA</title>
  <!-- CSS Skydash -->
  <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
</head>
<body>
  <main class="container" style="height: 700px">
    <div class="row py-5 h-100">
      <div class="col-md-5 d-flex flex-column justify-content-center">
        <img src="{{ asset('assets/images/fasilita-logo.png') }}"
             class="img-fluid mb-4" style="max-width: 100px" alt="">

        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('register.store') }}" class="forms-sample">
          @csrf

          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text"
                   id="nama"
                   name="nama"
                   class="form-control @error('nama') is-invalid @enderror"
                   value="{{ old('nama') }}"
                   placeholder="Nama Lengkap" required>
            @error('nama')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="username">Username</label>
            <input type="text"
                   id="username"
                   name="username"
                   class="form-control @error('username') is-invalid @enderror"
                   value="{{ old('username') }}"
                   placeholder="Username" required>
            @error('username')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="password"
                   id="password"
                   name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Password" required>
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password"
                   id="password_confirmation"
                   name="password_confirmation"
                   class="form-control"
                   placeholder="Konfirmasi Password" required>
          </div>

          <button type="submit" class="btn btn-primary w-100">Sign Up</button>
        </form>

        <p class="mt-3">
          Sudah punya akun?
          <a href="{{ route('login') }}">Login di sini</a>
        </p>
      </div>

      <div class="col-md-7 rounded-lg px-0"
           style="background-image: url('{{ asset('assets/images/bg-register2.png') }}'); background-size: cover;">
        <!-- kanan dekorasi/skydash -->
      </div>
    </div>
  </main>

  <!-- JS Skydash -->
  <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('assets/js/template.js') }}"></script>
  <script src="{{ asset('assets/js/settings.js') }}"></script>
</body>
</html>
