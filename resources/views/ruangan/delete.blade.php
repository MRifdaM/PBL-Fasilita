@empty($ruangan)
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-body"><div class="alert alert-danger">Data tidak ditemukan</div></div>
  </div></div>
@else
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">

    <div class="modal-header bg-danger text-white">
      <h5 class="modal-title"><i class="mdi mdi-trash-can"></i> Hapus Ruangan</h5>
      <button type="button"
              class="btn-close btn-close-white"
              data-dismiss="modal"
              data-bs-dismiss="modal">x</button>
    </div>

    <form id="form-ruangan-delete" class="ajax"
          action="{{ route('ruangan.destroy',$ruangan) }}"
          method="POST">
      @csrf @method('DELETE')
      <div class="modal-body p-4">
        Yakin menghapus ruangan <strong>{{ $ruangan->nama_ruangan }}</strong>?
      </div>
      <div class="modal-footer border-0">
        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
      </div>
    </form>
  </div>
</div>

<script>
$('#form-ruangan-delete').on('submit',function(e){
  e.preventDefault();
  $.ajax({
    url:  this.action,
    type: 'DELETE',
    data: $(this).serialize(),
    success(res){
      $('#myModal').modal('hide');
      Swal.fire('Berhasil',res.message,'success');
      tableRuangan.ajax.reload(null,false);
    },
    error(xhr){
      Swal.fire('Error',xhr.statusText,'error');
    }
  });
});
</script>
@endempty
