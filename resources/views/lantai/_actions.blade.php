@php($g = $gedung->id_gedung)
<div class="btn-group">
  <!-- Edit -->
  <button onclick="modalAction('{{ route('lantai.edit',$row->id_lantai) }}')"
          class="btn btn-warning btn-sm">
    <i class="mdi mdi-pencil"></i>
  </button>

  <!-- Delete -->
  <button onclick="modalAction('{{ route('lantai.delete',$row->id_lantai) }}')"
          class="btn btn-danger btn-sm">
    <i class="mdi mdi-delete"></i>
  </button>
</div>
