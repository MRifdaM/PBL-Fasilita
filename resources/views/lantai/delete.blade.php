@empty($lantai)
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-body">
      <div class="alert alert-danger">Data tidak ditemukan.</div>
    </div>
  </div></div>
@else
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">

    <div class="modal-header bg-danger text-white">
      <h5 class="modal-title">Hapus Lantai</h5>
      <button type="button" class="btn-close btn-close-white" data-dismiss="modal">X</button>
    </div>

    <form id="form-delete-lantai" class="ajax"
          action="{{ route('lantai.destroy', $lantai) }}"
          method="POST">
      @csrf
      @method('DELETE')
      <div class="modal-body">
        Yakin menghapus lantai <strong>{{ $lantai->nomor_lantai }}</strong>?
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
      </div>
    </form>
  </div>
</div>

<script>
  $('#form-delete-lantai').on('submit', function(e){
    e.preventDefault();
    const $f      = $(this),
          url     = this.action,
          method  = ($f.find('input[name="_method"]').val() || this.method).toUpperCase();

    $.ajax({
      url:  url,
      type: method,          // "DELETE"
      data: $f.serialize(),
      success(res){
        $('#myModal').modal('hide');
        // reload DataTable tanpa refresh halaman
        window.tableLantai.ajax.reload(null, false);
        Swal.fire('Berhasil', res.message, 'success');
      },
      error(xhr){
        console.error(xhr.responseText);
        Swal.fire('Error', xhr.statusText, 'error');
      }
    });
  });
</script>
@endempty
