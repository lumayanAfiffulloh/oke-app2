<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5 fw-bold">
        Buat Kelompok
      </h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body border border-2 mx-3 rounded-2">
      <form action="{{ route('kelompok.store') }}" method="POST" id="createFormID">
        @csrf
        <div class="form-group mb-3">
          <label for="id_ketua" class="fw-semibold">Ketua Kelompok</label>
          <select name="id_ketua" id="id_ketua"
            class="form-control placeholder-single @error('id_ketua') is-invalid @enderror" required>
            <option value=""></option>
            @foreach ($listPegawai as $pegawai)
              <option value="{{ $pegawai->id }}" {{ old('id_ketua') == $pegawai->id ? 'selected' : '' }}>
                {{ $pegawai->nppu }} - {{ $pegawai->nama }} | {{ $pegawai->unitKerja->unit_kerja }}
              </option>
            @endforeach
          </select>
          @error('id_ketua')
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
            @foreach ($listPegawai as $pegawai)
              <option value="{{ $pegawai->id }}" {{ in_array($pegawai->id, old('anggota', [])) ? 'selected' : '' }}>
                {{ $pegawai->nppu }} - {{ $pegawai->nama }} | {{ $pegawai->unitKerja->unit_kerja }}
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
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
      <button type="submit" class="btn btn-warning" id="createAlert">Buat Kelompok</button>
    </div>
    </form>
  </div>
</div>

@php
  $pegawaiArray = [];
  foreach ($listPegawai as $p) {
      $pegawaiArray[] = [
          'id' => $p->id,
          'nama' => "{$p->nppu} - {$p->nama} | {$p->unitKerja->unit_kerja}",
          'unit_id' => $p->unitKerja->id,
      ];
  }
@endphp

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const pegawaiData = {!! json_encode($pegawaiArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!};

    const ketuaSelect = document.getElementById('id_ketua');
    const anggotaSelect = document.getElementById('anggota');

    // awalnya disable
    anggotaSelect.disabled = true;

    function renderAnggotaOptions(ketuaId, preselected = []) {
      // kosongkan isi select
      $(anggotaSelect).empty();

      if (!ketuaId) {
        anggotaSelect.disabled = true;
        $(anggotaSelect).trigger('change'); // refresh UI select2
        return;
      }

      const ketua = pegawaiData.find(p => p.id == ketuaId);
      if (!ketua) {
        anggotaSelect.disabled = true;
        $(anggotaSelect).trigger('change');
        return;
      }

      const filtered = pegawaiData.filter(p => p.unit_id == ketua.unit_id && p.id != ketuaId);

      filtered.forEach(p => {
        const isSelected = preselected.includes(p.id);
        const newOpt = new Option(p.nama, p.id, isSelected, isSelected);
        $(anggotaSelect).append(newOpt);
      });

      anggotaSelect.disabled = false;
      $(anggotaSelect).trigger('change'); // refresh tampilan select2
    }

    // event saat ketua berubah
    $('#id_ketua').on('change', function() {
      renderAnggotaOptions(this.value);
    });

    // handle old value (pas validasi gagal)
    const initialKetua = ketuaSelect.value;
    if (initialKetua) {
      const oldAnggota = @json(old('anggota', []));
      renderAnggotaOptions(initialKetua, oldAnggota);
    }
  });
</script>
