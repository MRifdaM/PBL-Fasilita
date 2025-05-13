<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">

    <div class="modal-header bg-info text-white">
      <h5 class="modal-title"><i class="mdi mdi-file-document-box"></i> Detail Ruangan</h5>
      <button type="button" class="btn-close btn-close-white" data-dismiss="modal">X</button>
    </div>

    <div class="modal-body p-4">
      <table class="table table-borderless">
        <tr><th>Kode</th><td>{{ $ruangan->kode_ruangan }}</td></tr>
        <tr><th>Nama</th><td>{{ $ruangan->nama_ruangan }}</td></tr>
      </table>
    </div>

  </div>
</div>
