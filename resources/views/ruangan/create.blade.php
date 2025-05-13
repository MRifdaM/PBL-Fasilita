<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">

    <div class="modal-header bg-primary text-white">
      <h5 class="modal-title"><i class="mdi mdi-plus-box"></i> Tambah Ruangan</h5>
      <button type="button" class="btn-close btn-close-white" data-dismiss="modal">x</button>
    </div>

    <form id="form-ruangan-create" class="ajax"
          action="{{ route('lantai.ruangan.store',$lantai) }}"
          method="POST">
      @csrf
      <div class="modal-body p-4">
        <div class="mb-3">
          <label>Kode Ruangan</label>
          <input name="kode_ruangan" type="text" class="form-control" required maxlength="20">
          <small class="error-text text-danger"></small>
        </div>
        <div class="mb-3">
          <label>Nama Ruangan</label>
          <input name="nama_ruangan" type="text" class="form-control" required maxlength="100">
          <small class="error-text text-danger"></small>
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>

  </div>
</div>

<script>
$(function(){
  $('#form-ruangan-create').validate({
    rules:{
      kode_ruangan:{required:true,maxlength:20},
      nama_ruangan:{required:true,maxlength:100}
    },
    submitHandler(form){
      $.ajax({
        url:  form.action,
        type: form.method,
        data: $(form).serialize(),
        success(res){
          $('#myModal').modal('hide');
          Swal.fire('Berhasil',res.message,'success');
          window.tableRuangan.ajax.reload();
        }
      });
      return false;
    }
  });
});
</script>
