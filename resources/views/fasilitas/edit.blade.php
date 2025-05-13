@empty($fasilitas)
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-body">
      <div class="alert alert-danger">Data tidak ditemukan</div>
    </div>
  </div></div>
@else
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">

    <div class="modal-header bg-warning text-white">
      <h5 class="modal-title"><i class="mdi mdi-pencil"></i> Edit Fasilitas</h5>
      <button type="button" class="btn-close btn-close-white"
              data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <form id="form-fasilitas-edit"
          action="{{ route('fasilitas.update', $fasilitas) }}"
          method="POST">
      @csrf
      @method('PUT')
      <div class="modal-body p-4">
        <div class="mb-3">
          <label>Nama Fasilitas</label>
          <input name="nama_fasilitas" type="text" class="form-control"
                 value="{{ $fasilitas->nama_fasilitas }}" required maxlength="100">
          <small class="error-text text-danger"></small>
        </div>
        <div class="mb-3">
          <label>Jumlah</label>
          <input name="jumlah_fasilitas" type="number" class="form-control"
                 value="{{ $fasilitas->jumlah_fasilitas }}" required min="1">
          <small class="error-text text-danger"></small>
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-light"
                data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>

  </div>
</div>

<script>
$('#form-fasilitas-edit').on('submit', function(e){
  e.preventDefault();
  $.ajax({
    url: this.action,
    type: 'PUT',
    data: $(this).serialize(),
    success(res){
      $('#myModal').modal('hide');
      Swal.fire('Berhasil', res.message, 'success');
      tableFasilitas.ajax.reload(null,false);
    },
    error(err){
      Swal.fire('Error', err.responseJSON?.message||err.statusText, 'error');
    }
  });
});
</script>
@endempty
