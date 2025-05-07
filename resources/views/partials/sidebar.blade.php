<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

      {{-- Dashboard (accessible to all users) --}}
      <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>

      {{-- ============================= --}}
      {{-- ADMIN MENU                    --}}
      {{-- ============================= --}}
      @if(auth()->user()->hasRole('ADM'))
        {{-- User Management --}}
        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#user-management" aria-expanded="false">
            <i class="icon-people menu-icon"></i>
            <span class="menu-title">Manajemen Pengguna</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="user-management">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                <a class="nav-link" href="{{ route('peran.index') }}">Peran & Hak Akses</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('pengguna.index') }}">Daftar Pengguna</a>
              </li>
            </ul>
          </div>
        </li>

        {{-- Facility Management --}}
        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#facility-management" aria-expanded="false">
            <i class="icon-home menu-icon"></i>
            <span class="menu-title">Manajemen Fasilitas</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="facility-management">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                <a class="nav-link" href="{{ route('gedung.index') }}">Gedung</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('lantai.index') }}">Lantai</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('ruangan.index') }}">Ruangan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('fasilitas.index') }}">Fasilitas</a>
              </li>
            </ul>
          </div>
        </li>

        {{-- Master Data --}}
        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#master-data" aria-expanded="false">
            <i class="icon-layers menu-icon"></i>
            <span class="menu-title">Master Data</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="master-data">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                <a class="nav-link" href="{{ route('kategoriF.index') }}">Kategori Fasilitas</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('kategoriK.index') }}">Kategori Kerusakan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('status.index') }}">Status Laporan</a>
              </li>
            </ul>
          </div>
        </li>

        {{-- SPK & Criteria --}}
        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#spk-management" aria-expanded="false">
            <i class="icon-calculator menu-icon"></i>
            <span class="menu-title">SPK & Kriteria</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="spk-management">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                <a class="nav-link" href="{{ route('kriteria.index') }}">Kriteria Penilaian</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('skoring.index') }}">Skoring Kriteria</a>
              </li>
            </ul>
          </div>
        </li>
      @endif

      {{-- ============================= --}}
      {{-- ADMIN & SARPRAS MENU          --}}
      {{-- ============================= --}}
      @if(auth()->user()->hasAnyRole(['ADM','SPR']))
      <li class="nav-item">
        {{-- <a class="nav-link" href="{{ route('verifikasi.index') }}"> --}}
          <i class="fas fa-clipboard-check"></i> <!-- Ganti ikon di sini -->
          <span class="menu-title">Verifikasi Laporan</span>
        </a>
      </li>
    @endif

      {{-- ============================= --}}
      {{-- SARPRAS MENU                  --}}
      {{-- ============================= --}}
      @if(auth()->user()->hasRole('SPR'))
        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#task-management" aria-expanded="false">
            <i class="icon-wrench menu-icon"></i>
            <span class="menu-title">Manajemen Tugas</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="task-management">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                <a class="nav-link" href="{{ route('spk.topsis') }}">SPK TOPSIS</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('penugasan.index') }}">Penugasan Teknisi</a>
              </li>
            </ul>
          </div>
        </li>
      @endif

      {{-- ============================= --}}
      {{-- EXTERNAL USER MENU (MHS/DSN/TDK) --}}
      {{-- ============================= --}}
      @if(auth()->user()->hasAnyRole(['MHS','DSN','TDK']))
        <li class="nav-item">
          <a class="nav-link" href="{{ route('laporan.create') }}">
            <i class="icon-note menu-icon"></i>
            <span class="menu-title">Buat Laporan</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('laporan.index') }}">
            <i class="icon-clock menu-icon"></i>
            <span class="menu-title">Riwayat Laporan</span>
          </a>
        </li>
      @endif

      {{-- ============================= --}}
      {{-- TECHNICIAN MENU               --}}
      {{-- ============================= --}}
      @if(auth()->user()->hasRole('TNS'))
        <li class="nav-item">
          <a class="nav-link" href="{{ route('tugas.index') }}">
            <i class="icon-wrench menu-icon"></i>
            <span class="menu-title">Daftar Tugas</span>
          </a>
        </li>
      @endif

      {{-- ============================= --}}
      {{-- LOGOUT                        --}}
      {{-- ============================= --}}
      <li class="nav-item mt-4">
        <a class="nav-link text-danger" href="#"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="icon-power menu-icon"></i>
          <span class="menu-title">Keluar</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
          @csrf
        </form>
      </li>

    </ul>
  </nav>
