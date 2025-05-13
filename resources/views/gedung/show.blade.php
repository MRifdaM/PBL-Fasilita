<div class="modal-dialog modal-lg modal-dialog-centered">
  <div class="modal-content rounded-4 shadow-lg">
    <div class="modal-header text-white"
         style="background:#0d6efd">
      <h5 class="modal-title">
        <i class="bi bi-info-circle me-2"></i> Detail Gedung
      </h5>
      <button class="btn-close btn-close-white" data-bs-dismiss="modal">X</button>
    </div>

    <div class="modal-body p-4">
      <table class="table align-middle">
        <tr><th class="w-25">Kode</th><td>{{ $gedung->kode_gedung }}</td></tr>
        <tr><th>Nama</th><td>{{ $gedung->nama_gedung }}</td></tr>
        <tr><th>Lokasi</th><td>{{ $gedung->lokasi ?? '—' }}</td></tr>
        <tr><th>Dibuat</th><td>{{ $gedung->created_at->format('d M Y') }}</td></tr>
      </table>
    </div>

    <div class="modal-footer border-0"> 
    </div>
  </div>
</div>
