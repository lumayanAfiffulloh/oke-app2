<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5 fw-bold">
        Tambah Bentuk Jalur
      </h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form action="/bentuk_jalur" method="POST" class="py-2" id="createFormID">
      @csrf
      {{-- KATEGORI --}}
      <div class="modal-body border border-2 mx-3 rounded-2">
        <div class="form-group mt-1 mb-3">
          <label for="kategori" class="fw-bolder">Kategori</label>
          <div class="col-md-6">
            <select class="form-select" id="kategori" name="kategori">
              <option value="" selected disabled id="pilih">-- Pilih Kategori --</option>
              <option value="klasikal" {{ old('kategori') === 'klasikal' ? 'selected' : '' }} id="kategori-klasikal">
                Klasikal</option>
              <option value="non-klasikal" {{ old('kategori') === 'non-klasikal' ? 'selected' : '' }}
                id="kategori-non-klasikal">Non-Klasikal</option>
            </select>
            <span class="text-danger">{{ $errors->first('kategori') }}</span>
          </div>
        </div>
        {{-- BENTUK JALUR --}}
        <div class="form-group mb-2">
          <label for="bentuk_jalur" class="fw-bolder">Nama Bentuk Jalur</label><br>
          <input type="text" class="form-control @error('bentuk_jalur') is-invalid @enderror" id="bentuk_jalur"
            name="bentuk_jalur" value="{{ old('bentuk_jalur') }}">
          <span class="text-danger">{{ $errors->first('bentuk_jalur') }}</span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary" id="createAlert">Simpan</button>
      </div>
    </form>
  </div>
</div>
