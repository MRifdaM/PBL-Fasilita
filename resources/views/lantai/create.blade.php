<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">

    <div class="modal-header bg-primary text-white">
      <h5 class="modal-title">Tambah Lantai</h5>
      <button type="button" class="btn-close btn-close-white" data-dismiss="modal">X</button>
    </div>

    <form id="form-lantai-create" class="ajax"
          action="{{ route('gedung.lantai.store',$gedung) }}"
          method="POST">
      @csrf

      <div class="modal-body p-3">
        <div class="mb-3">
          <label class="form-label">Nomor Lantai</label>
          <input name="nomor_lantai" type="text" class="form-control" required maxlength="10">
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
  // validasi & AJAX submit
  $('#form-lantai-create').validate({
    rules: { nomor_lantai:{required:true,maxlength:10} },
    submitHandler(form){
      $.ajax({
        url:  form.action,
        type: form.method,
        data: $(form).serialize(),
        success(res){
          $('#myModal').modal('hide');
          Swal.fire('Berhasil',res.message,'success');
          tableLantai.ajax.reload();
        }
      });
    }
  });
</script>
