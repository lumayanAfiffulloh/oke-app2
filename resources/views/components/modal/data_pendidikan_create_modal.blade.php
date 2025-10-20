<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5 fw-bold">
        Tambah Data Pendidikan
      </h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form action="/data_pendidikan" method="POST" class="py-2" id="createFormID">
      @csrf
      <div class="modal-body border border-2 mx-3 rounded-2">
        {{-- JENJANG --}}
        <div class="form-group mt-1 mb-3">
          <label class="fw-semibold" for="jenjang">Jenjang<span class="text-danger">*</span></label><br>
          <div class="form-check form-check-inline">
            <input class="form-check-input @error('jenjang') is-invalid @enderror" type="checkbox" name="jenjang[]"
              id="D1" value="D1"
              {{ is_array(old('jenjang')) && in_array('D1', old('jenjang')) ? 'checked' : '' }}>
            <label class="form-check-label" for="D1">D1</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input @error('jenjang') is-invalid @enderror" type="checkbox" name="jenjang[]"
              id="D2" value="D2"
              {{ is_array(old('jenjang')) && in_array('D2', old('jenjang')) ? 'checked' : '' }}>
            <label class="form-check-label" for="D2">D2</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input @error('jenjang') is-invalid @enderror" type="checkbox" name="jenjang[]"
              id="D3" value="D3"
              {{ is_array(old('jenjang')) && in_array('D3', old('jenjang')) ? 'checked' : '' }}>
            <label class="form-check-label" for="D3">D3</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input @error('jenjang') is-invalid @enderror" type="checkbox" name="jenjang[]"
              id="S1" value="S1"
              {{ is_array(old('jenjang')) && in_array('S1', old('jenjang')) ? 'checked' : '' }}>
            <label class="form-check-label" for="S1">S1/D4</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input @error('jenjang') is-invalid @enderror" type="checkbox" name="jenjang[]"
              id="S2" value="S2"
              {{ is_array(old('jenjang')) && in_array('S2', old('jenjang')) ? 'checked' : '' }}>
            <label class="form-check-label" for="S2">S2</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input @error('jenjang') is-invalid @enderror" type="checkbox" name="jenjang[]"
              id="S3" value="S3"
              {{ is_array(old('jenjang')) && in_array('S3', old('jenjang')) ? 'checked' : '' }}>
            <label class="form-check-label" for="S3">S3</label>
          </div>
          <br><span class="text-danger">{{ $errors->first('jenjang') }}</span>
        </div>

        {{-- JURUSAN --}}
        <div class="form-group mt-1 mb-3">
          <label for="jurusan" class="fw-bolder">Jurusan<span class="text-danger">*</span></label>
          <div class="col">
            <input type="text" class="form-control @error('jurusan') is-invalid @enderror" id="jurusan"
              name="jurusan" value="{{ old('jurusan') }}">
          </div>
          <span class="text-danger">{{ $errors->first('jurusan') }}</span>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary" id="createAlert">Simpan</button>
      </div>
    </form>
  </div>
</div>
