<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title fs-5 fw-bold">Edit Bentuk Jalur</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="editForm" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-body border border-2 mx-3 rounded-2">
        {{-- Kategori --}}
        <div class="form-group mt-1 mb-3">
          <label for="editKategori" class="fw-bolder">Kategori</label>
          <select class="form-select" id="editKategori" name="kategori">
            <option value="" disabled>-- Pilih Kategori --</option>
            <option value="klasikal">Klasikal</option>
            <option value="non-klasikal">Non-Klasikal</option>
          </select>
        </div>
        {{-- Bentuk Jalur --}}
        <div class="form-group mb-2">
          <label for="editBentukJalur" class="fw-bolder">Nama Bentuk Jalur</label>
          <input type="text" class="form-control" id="editBentukJalur" name="bentuk_jalur">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
