<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title tw-text-[20px] fw-bold">
        Tambah Data Pelatihan
      </h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form action="/data_pelatihan" method="POST" class="py-2" id="createFormID">
      @csrf
      <div class="modal-body border border-2 mx-3 rounded-2">
        {{-- KODE --}}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group mt-1 mb-3">
              <label for="kode" class="fw-bolder">Kode</label>
              <div class="col">
                <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode"
                  value="{{ old('kode') }}">
              </div>
              <span class="text-danger">{{ $errors->first('kode') }}</span>
            </div>
          </div>
          <div class="col-md-6">
            {{-- RUMPUN --}}
            <div class="form-group mt-1 mb-3">
              <label for="rumpun" class="fw-bolder">Rumpun</label>
              <div class="col">
                <input type="text" class="form-control @error('rumpun') is-invalid @enderror" id="rumpun" name="rumpun"
                  value="{{ old('rumpun') }}">
              </div>
              <span class="text-danger">{{ $errors->first('rumpun') }}</span>
            </div>
          </div>
        </div>

        {{-- NAMA PELATIHAN --}}
        <div class="form-group mt-1 mb-3">
          <label for="nama_pelatihan" class="fw-bolder">Nama Pelatihan</label>
          <div class="col">
            <input type="text" class="form-control @error('nama_pelatihan') is-invalid @enderror" id="nama_pelatihan"
              name="nama_pelatihan" value="{{ old('nama_pelatihan') }}">
          </div>
          <span class="text-danger">{{ $errors->first('nama_pelatihan') }}</span>
        </div>

        {{-- DESKRIPSI PELATIHAN --}}
        <div class="form-group mt-1 mb-3">
          <label for="deskripsi" class="fw-bolder">Deskripsi Pelatihan</label>
          <div class="col">
            <textarea type="text" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi"
              name="deskripsi" value="{{ old('deskripsi') }}"></textarea>
          </div>
          <span class="text-danger">{{ $errors->first('deskripsi') }}</span>
        </div>

        {{-- JAM PELAJARAN --}}
        <div class="form-group mt-1 mb-3">
          <label for="jp" class="fw-bolder">Jam Pelajaran (JP)</label>
          <div class="col-md-7">
            <input type="text" class="form-control @error('jp') is-invalid @enderror" id="jp" name="jp"
              value="{{ old('jp') }}">
          </div>
          <span class="text-danger">{{ $errors->first('jp') }}</span>
        </div>

        {{-- MATERI PELATIHAN --}}
        <div class="form-group mt-1 mb-3">
          <label for="materi" class="fw-bolder">Materi Pelatihan</label>
          <div class="col">
            <textarea type="text" class="form-control @error('materi') is-invalid @enderror" id="materi" name="materi"
              value="{{ old('materi') }}"></textarea>
          </div>
          <span class="text-danger">{{ $errors->first('materi') }}</span>
        </div>

        {{-- ESTIMASI HARGA NASIONAL --}}
        <label class="fw-bolder">FORM ESTIMASI HARGA <span class="text-primary">NASIONAL</span></label>
        <hr>
        {{-- KATEGORI KLASIKAL --}}
        <div class="row mt-2">
          <label class="fw-bolder">Anggaran Klasikal</label>
          <div class="col-md-6">
            <div class="form-group mt-1 mb-2">
              <input type="text" value="{{ old('nasional_klasikal_min') }}"
                class="form-control format-rupiah @error('nasional_klasikal_min') is-invalid @enderror"
                id="nasional_klasikal_min" name="nasional_klasikal_min_display" placeholder="Min. Anggaran">
              <input type="hidden" id="nasional_klasikal_min" name="nasional_klasikal_min">
              <span class="text-danger">{{ $errors->first('nasional_klasikal_min') }}</span>
            </div>
          </div>
          {{-- Maksimum Anggaran --}}
          <div class="col-md-6">
            <div class="form-group mt-1 mb-2">
              <input type="text" value="{{ old('nasional_klasikal_maks') }}"
                class="form-control format-rupiah @error('nasional_klasikal_maks') is-invalid @enderror"
                id="nasional_klasikal_maks" name="nasional_klasikal_maks_display" placeholder="Maks. Anggaran">
              <input type="hidden" id="nasional_klasikal_maks" name="nasional_klasikal_maks">
              <span class="text-danger">{{ $errors->first('nasional_klasikal_maks') }}</span>
            </div>
          </div>
        </div>

        {{-- KATEGORI NON-KLASIKAL --}}
        <div class="row">
          <label class="fw-bolder">Anggaran Nonklasikal</label>
          {{-- Minimum Anggaran --}}
          <div class="col-md-6">
            <div class="form-group mt-1 mb-2">
              <input type="text" value="{{ old('nasional_non-klasikal_min') }}"
                class="form-control format-rupiah @error('nasional_non-klasikal_min') is-invalid @enderror"
                id="nasional_non-klasikal_min" name="nasional_non-klasikal_min_display" placeholder="Min. Anggaran">
              <input type="hidden" id="nasional_non-klasikal_min" name="nasional_non-klasikal_min">
              <span class="text-danger">{{ $errors->first('nasional_non-klasikal_min') }}</span>
            </div>
          </div>
          <div class="col-md-6">
            {{-- Maksimum Anggaran --}}
            <div class="form-group mt-1 mb-2">
              <input type="text" value="{{ old('nasional_non-klasikal_maks') }}"
                class="form-control format-rupiah @error('nasional_non-klasikal_maks') is-invalid @enderror"
                id="nasional_non-klasikal_maks" name="nasional_non-klasikal_maks_display" placeholder="Maks. Anggaran">
              <input type="hidden" id="nasional_non-klasikal_maks" name="nasional_non-klasikal_maks">
              <span class="text-danger">{{ $errors->first('nasional_non-klasikal_maks') }}</span>
            </div>
          </div>
        </div>

        {{-- ESTIMASI HARGA INTERNASIONAL --}}
        <label class="fw-bolder mt-2">FORM ESTIMASI HARGA <span class="text-warning">INTERNASIONAL</span></label>
        <hr>
        {{-- KATEGORI KLASIKAL --}}
        <div class="row mt-2">
          <label class="fw-bolder">Anggaran Klasikal</label>
          <div class="col-md-6">
            <div class="form-group mt-1 mb-2">
              <input type="text" value="{{ old('internasional_klasikal_min') }}"
                class="form-control format-rupiah @error('internasional_klasikal_min') is-invalid @enderror"
                id="internasional_klasikal_min" name="internasional_klasikal_min_display" placeholder="Min. Anggaran">
              <input type="hidden" id="internasional_klasikal_min" name="internasional_klasikal_min">
              <span class="text-danger">{{ $errors->first('internasional_klasikal_min') }}</span>
            </div>
          </div>
          {{-- Maksimum Anggaran --}}
          <div class="col-md-6">
            <div class="form-group mt-1 mb-2">
              <input type="text" value="{{ old('internasional_klasikal_maks') }}"
                class="form-control format-rupiah @error('internasional_klasikal_maks') is-invalid @enderror"
                id="internasional_klasikal_maks" name="internasional_klasikal_maks_display"
                placeholder="Maks. Anggaran">
              <input type="hidden" id="internasional_klasikal_maks" name="internasional_klasikal_maks">
              <span class="text-danger">{{ $errors->first('internasional_klasikal_maks') }}</span>
            </div>
          </div>
        </div>

        {{-- KATEGORI NON-KLASIKAL --}}
        <div class="row">
          <label class="fw-bolder">Anggaran Nonklasikal</label>
          {{-- Minimum Anggaran --}}
          <div class="col-md-6">
            <div class="form-group mt-1 mb-2">
              <input type="text" value="{{ old('internasional_non-klasikal_min') }}"
                class="form-control format-rupiah @error('internasional_non-klasikal_min') is-invalid @enderror"
                id="internasional_non-klasikal_min" name="internasional_non-klasikal_min_display"
                placeholder="Min. Anggaran">
              <input type="hidden" id="internasional_non-klasikal_min" name="internasional_non-klasikal_min">
              <span class="text-danger">{{ $errors->first('internasional_non-klasikal_min') }}</span>
            </div>
          </div>
          <div class="col-md-6">
            {{-- Maksimum Anggaran --}}
            <div class="form-group mt-1 mb-2">
              <input type="text" value="{{ old('internasional_non-klasikal_maks') }}"
                class="form-control format-rupiah @error('internasional_non-klasikal_maks') is-invalid @enderror"
                id="internasional_non-klasikal_maks" name="internasional_non-klasikal_maks_display"
                placeholder="Maks. Anggaran">
              <input type="hidden" id="internasional_non-klasikal_maks" name="internasional_non-klasikal_maks">
              <span class="text-danger">{{ $errors->first('internasional_non-klasikal_maks') }}</span>
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