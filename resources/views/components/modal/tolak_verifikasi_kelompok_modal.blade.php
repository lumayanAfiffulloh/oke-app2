<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5 fw-semibold">Tolak Rencana</h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body border border-2 mx-3 rounded-2">
      <form id="tolakForm" action="{{ route('verifikasi.tolak') }}" method="POST">
        @csrf
        <input type="hidden" name="rencana_pembelajaran_id" id="tolak_rencana_id">
        <input type="hidden" name="kelompok_id" id="tolak_kelompok_id">
        <div class="mb-3">
          <label for="tolak_catatan" class="form-label fw-semibold">Catatan:<span class="text-danger">*</span></label>
          <textarea class="form-control" id="tolak_catatan" name="catatan" rows="3" required></textarea>
        </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      <button type="submit" class="btn btn-danger" id="tolakAlert">Tolak</button>
    </div>
    </form>
  </div>
</div>

@push('alert-setujui-tolak')
<script>
  document.getElementById('tolakAlert').onclick = function(event){
    event.preventDefault();
    var form = document.getElementById('tolakForm');
    if (form.checkValidity()) {
      Swal.fire({
        title: "Konfirmasi Data",
        text: "Pastikan data yang anda isikan sudah benar!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ff695e",
        confirmButtonText: "Tolak",
        cancelButtonText: "Batal"
      }).then((result) => {
        if (result.isConfirmed){
          // Submit form atau aksi lain setelah konfirmasi
          form.submit();
        }
      });
    } else {
      form.reportValidity();
    }
  }
</script>
@endpush