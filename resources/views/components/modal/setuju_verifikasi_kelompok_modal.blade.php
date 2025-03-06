<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5 fw-semibold">Setujui Rencana</h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body border border-2 mx-3 rounded-2">
      <form id="setujuiForm" action="{{ route('verifikasi.setujui') }}" method="POST">
        @csrf
        <div class="form-group">
          <input type="hidden" name="rencana_pembelajaran_id" id="setujui_rencana_id">
          <input type="hidden" name="kelompok_id" id="setujui_kelompok_id">
          <div class="mb-2">
            <label for="setujui_catatan" class="form-label fw-semibold">Catatan: (opsional)</label>
            <textarea class="form-control" id="setujui_catatan" name="catatan" rows="3"></textarea>
          </div>
        </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      <button type="submit" class="btn btn-success" id="setujuiAlert">Setujui</button>
    </div>
    </form>
  </div>
</div>

@push('alert-setujui-tolak')
<script>
  document.getElementById('setujuiAlert').onclick = function(event){
    event.preventDefault();
    Swal.fire({
      title: "Konfirmasi Data",
      text: "Pastikan data yang anda isikan sudah benar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#13DEB9",
      confirmButtonText: "Setujui",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed){
        // Submit form atau aksi lain setelah konfirmasi
        document.getElementById('setujuiForm').submit(); // Sesuaikan ID form
      }
    });
  }
</script>
@endpush