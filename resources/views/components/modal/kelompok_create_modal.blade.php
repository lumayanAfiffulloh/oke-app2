<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title tw-text-[20px] fw-bold">
        Buat Kelompok
      </h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body border border-2 mx-3 rounded-2">
      <form action="{{ route('kelompok.store') }}" method="POST" id="createFormID">
        @csrf
        <div class="form-group mb-3">
          <label for="ketua_id" class="fw-semibold">Ketua Kelompok</label>
          <select name="ketua_id" id="ketua_id"
            class="form-control placeholder-single @error('ketua_id') is-invalid @enderror" required>
            <option value=""></option>
            @foreach($listPegawai as $pegawai)
            <option value="{{ $pegawai->id }}" @selected(old('ketua_id'))>
              {{ $pegawai->nppu }} - {{ $pegawai->nama }} | {{ $pegawai->unit_kerja }}
            </option>
            @endforeach
          </select>
          @error('ketua_id')
          <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>

        <div class="form-group mb-3">
          <label for="anggota" class="fw-semibold">Pilih Anggota | <span class="text-warning">19 Orang</span></label>
          <select name="anggota[]" id="anggota"
            class="form-control placeholder-multiple @error('anggota') is-invalid @enderror" multiple="multiple"
            required>
            @foreach($listPegawai as $pegawai)
            <option value="{{ $pegawai->id }}" @selected(old('anggota', []))>
              {{ $pegawai->nppu }} - {{ $pegawai->nama }} | {{ $pegawai->unit_kerja }}
            </option>
            @endforeach
          </select>
          @error('anggota')
          <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      <button type="submit" class="btn btn-warning" id="createAlert">Buat Kelompok</button>
    </div>
    </form>
  </div>
</div>