<div class="modal-dialog modal-lg modal-dialog-centered">
  <div class="modal-content rounded-4 shadow">
    <div class="modal-header bg-danger text-white">
      <h5 class="modal-title"><i class="bi bi-trash me-2"></i>Hapus Gedung</h5>
      <button class="btn-close btn-close-white" data-dismiss="modal">X</button>
    </div>

    <form id="form-delete"
      action="{{ route('gedung.destroy', $gedung) }}"   {{-- <— ini PENTING --}}
      method="POST">
  @csrf
  @method('DELETE')
  …
      <div class="modal-body">
        <p class="fs-5">Yakin menghapus data berikut?</p>
        <ul class="list-group mb-3">
          <li class="list-group-item d-flex justify-content-between">
            <span>Kode</span><b>{{ $gedung->kode_gedung }}</b>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>Nama</span><b>{{ $gedung->nama_gedung }}</b>
          </li>
        </ul>
      </div>
      <div class="modal-footer border-0">   
        <button type="submit" class="btn btn-danger">
          <i class="bi bi-check2-circle me-1"></i>Ya, Hapus
        </button>
      </div>
    </form>
  </div>
</div>

{{-- ===  SCRIPT KHUSUS MODAL INI  === --}}
<script>
  $(function () {
  
    $('#form-delete').on('submit', function (e) {
        e.preventDefault();           // cegah submit normal
  
        $.ajax({
          url :  this.action,
          type: this.method,          // POST, tapi ada _method=DELETE
          data: $(this).serialize(),
          success: res => {
            if (res.status) {
                $('#myModal').modal('hide');
                Swal.fire('Berhasil', res.message, 'success');
                // reload DataTable gedung jika tersedia
                if (typeof tableGedung !== 'undefined') tableGedung.ajax.reload();
            } else {
                Swal.fire('Gagal', res.message ?? 'Terjadi kesalahan', 'error');
            }
          },
          error: xhr => {
            Swal.fire('Error '+xhr.status, xhr.statusText, 'error');
          }
        });
    });
  
  });
  </script>