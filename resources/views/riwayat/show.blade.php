{{-- resources/views/riwayat/show.blade.php --}}
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header bg-primary text-white">
      <h5 class="modal-title">
        <i class="fas fa-history me-2 mx-2"></i>Detail Riwayat Fasilitas
      </h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
      <div class="row mb-4">
        <!-- Foto Fasilitas -->
        <div class="col-md-3 mb-3 mb-md-0">
          <div class="card h-100">
            <img src="{{ asset('storage/' . $lapfas->path_foto) }}"
                 class="card-img-top img-fluid rounded"
                 alt="Foto Fasilitas"
                 style="height: 200px; object-fit: cover;">
            <div class="card-footer bg-transparent">
              <small class="text-muted">Foto Fasilitas</small>
            </div>
          </div>
        </div>

        <!-- Detail Laporan -->
        <div class="col-md-9">
          <div class="card h-100">
            <div class="card-header bg-light">
              <h6 class="mb-0"><i class="fas fa-info-circle me-2 mx-2"></i>Informasi Laporan</h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <p class="mb-2">
                    <strong><i class="fas fa-warehouse me-2 mx-2"></i>Fasilitas:</strong><br>
                    {{ $lapfas->fasilitas->nama_fasilitas }}
                  </p>
                  <p class="mb-2">
                    <strong><i class="fas fa-tools me-2 mx-2"></i>Jenis Kerusakan:</strong><br>
                    {{ $lapfas->kategoriKerusakan->nama_kerusakan }}
                  </p>
                  <p class="mb-2">
                    <strong><i class="fas fa-hashtag me-2 mx-2"></i>Jumlah Unit Rusak:</strong><br>
                    {{ $lapfas->jumlah_rusak }} unit
                  </p>
                </div>
                <div class="col-md-6">
                  <p class="mb-2">
                    <strong><i class="fas fa-user me-2 mx-2"></i>Pelapor:</strong><br>
                    {{ $lapfas->laporan->pengguna->nama }}
                  </p>
                  <p class="mb-2">
                    <strong><i class="fas fa-map-marker-alt me-2 mx-2"></i>Lokasi:</strong><br>
                    {{ $lapfas->laporan->gedung->nama_gedung }} &raquo;
                    Lantai {{ $lapfas->laporan->lantai->nomor_lantai }} &raquo;
                    {{ $lapfas->laporan->ruangan->nama_ruangan }}
                  </p>
                  <p class="mb-0">
                    <strong><i class="far fa-clock me-2 mx-2"></i>Tanggal Pelaporan:</strong><br>
                    {{ $lapfas->created_at->format('d F Y H:i') }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Deskripsi Kerusakan -->
      <div class="card mb-4">
        <div class="card-header bg-light">
          <h6 class="mb-0"><i class="fas fa-align-left me-2 mx-2"></i>Deskripsi Kerusakan</h6>
        </div>
        <div class="card-body">
          <p class="mb-0">{{ $lapfas->deskripsi }}</p>
        </div>
      </div>

      <!-- Riwayat Status -->
      <div class="card">
        <div class="card-header bg-light">
          <h6 class="mb-0"><i class="fas fa-list-ol me-2 mx-2"></i>Riwayat Perubahan Status</h6>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead class="table-light">
                <tr>
                  <th width="5%">#</th>
                  <th width="20%">Status</th>
                  <th width="20%">Modifikator</th>
                  <th width="20%">Peran</th>
                  <th width="35%">Catatan</th>
                  <th width="20%">Waktu</th>
                </tr>
              </thead>
              <tbody>
                @foreach($riwayats as $idx => $item)
                <tr>
                  <td>{{ $idx + 1 }}</td>
                  <td>
                    <span class="badge
                      @if($item->status->nama_status == 'Valid') bg-primary text-light
                      @elseif($item->status->nama_status == 'Tidak Valid') bg-warning text-dark
                      @elseif($item->status->nama_status == 'Selesai') bg-success
                      @elseif($item->status->nama_status == 'Ditolak') bg-danger
                      @else bg-secondary @endif">
                      {{ $item->status->nama_status }}
                    </span>
                  </td>
                  <td>{{ $item->pengguna->nama }}</td>
                  <td>{{ $item->pengguna->peran->nama_peran }}</td>
                  <td>{{ $item->catatan ?: '-' }}</td>
                  <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

   <!-- Footer Modal -->
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-warning" data-dismiss="modal">
            Tutup
        </button>
      </div>
  </div>
</div>
