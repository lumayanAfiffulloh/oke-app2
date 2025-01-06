<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title tw-text-[20px] fw-bold">
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
            <input class="form-check-input @error('jenjang') is-invalid @enderror" type="radio" name="jenjang" id="D1"
              value="D1" {{ old('jenjang')==='D1' ? 'checked' : '' }}>
            <label class="form-check-label" for="D1">D1</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input @error('jenjang') is-invalid @enderror" type="radio" name="jenjang" id="D2"
              value="D2" {{ old('jenjang')==='D2' ? 'checked' : '' }}>
            <label class="form-check-label" for="D2">D2</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input @error('jenjang') is-invalid @enderror" type="radio" name="jenjang" id="D3"
              value="D3" {{ old('jenjang')==='D3' ? 'checked' : '' }}>
            <label class="form-check-label" for="D3">D3</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input @error('jenjang') is-invalid @enderror" type="radio" name="jenjang" id="S1"
              value="S1" {{ old('jenjang')==='S1' ? 'checked' : '' }}>
            <label class="form-check-label" for="S1">S1/D4</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input @error('jenjang') is-invalid @enderror" type="radio" name="jenjang" id="S2"
              value="S2" {{ old('jenjang')==='S2' ? 'checked' : '' }}>
            <label class="form-check-label" for="S2">S2</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input @error('jenjang') is-invalid @enderror" type="radio" name="jenjang" id="S3"
              value="S3" {{ old('jenjang')==='S3' ? 'checked' : '' }}>
            <label class="form-check-label" for="S3">S3</label>
          </div>
          <br><span class="text-danger">{{ $errors->first('jenjang') }}</span>
        </div>

        {{-- JURUSAN --}}
        <div class="form-group mt-1 mb-3">
          <label for="jurusan" class="fw-bolder">Jurusan<span class="text-danger">*</span></label>
          <div class="col">
            <input type="text" class="form-control @error('jurusan') is-invalid @enderror" id="jurusan" name="jurusan"
              value="{{ old('jurusan') }}">
          </div>
          <span class="text-danger">{{ $errors->first('jurusan') }}</span>
        </div>

        {{-- ESTIMASI HARGA NASIONAL --}}
        <label class="fw-bolder">ESTIMASI HARGA <span class="text-primary">NASIONAL</span></label>
        <hr>
        {{-- KATEGORI KLASIKAL --}}
        <div class="row mt-2">
          {{-- Minimal Anggaran --}}
          <div class="col-md-6">
            <div class="form-group mt-1 mb-2">
              <input type="text" value="{{ old('nasional_min') }}"
                class="form-control format-rupiah @error('nasional_min') is-invalid @enderror" id="nasional_min"
                name="nasional_min_display" placeholder="Min. Anggaran">
              <input type="hidden" id="nasional_min" name="nasional_min">
              <span class="text-danger">{{ $errors->first('nasional_min') }}</span>
            </div>
          </div>
          {{-- Maksimum Anggaran --}}
          <div class="col-md-6">
            <div class="form-group mt-1 mb-2">
              <input type="text" value="{{ old('nasional_maks') }}"
                class="form-control format-rupiah @error('nasional_maks') is-invalid @enderror" id="nasional_maks"
                name="nasional_maks_display" placeholder="Maks. Anggaran">
              <input type="hidden" id="nasional_maks" name="nasional_maks">
              <span class="text-danger">{{ $errors->first('nasional_maks') }}</span>
            </div>
          </div>
        </div>

        {{-- ESTIMASI HARGA INTERNASIONAL --}}
        <label class="fw-bolder mt-2">ESTIMASI HARGA <span class="text-warning">INTERNASIONAL</span></label>
        <hr>
        <div class="row mt-2">
          {{-- Minimal Anggaran --}}
          <div class="col-md-6">
            <div class="form-group mt-1 mb-2">
              <input type="text" value="{{ old('internasional_min') }}"
                class="form-control format-rupiah @error('internasional_min') is-invalid @enderror"
                id="internasional_min" name="internasional_min_display" placeholder="Min. Anggaran">
              <input type="hidden" id="internasional_min" name="internasional_min">
              <span class="text-danger">{{ $errors->first('internasional_min') }}</span>
            </div>
          </div>
          {{-- Maksimum Anggaran --}}
          <div class="col-md-6">
            <div class="form-group mt-1 mb-2">
              <input type="text" value="{{ old('internasional_maks') }}"
                class="form-control format-rupiah @error('internasional_maks') is-invalid @enderror"
                id="internasional_maks" name="internasional_maks_display" placeholder="Maks. Anggaran">
              <input type="hidden" id="internasional_maks" name="internasional_maks">
              <span class="text-danger">{{ $errors->first('internasional_maks') }}</span>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-warning" id="createAlert">Simpan</button>
      </div>
    </form>
  </div>
</div>