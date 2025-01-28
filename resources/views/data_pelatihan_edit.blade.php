@extends('layouts.app_modern', ['title'=>'Edit Data Pelatihan'])
@section('content')
<div class="card mb-3 bg-white">
  <div class="card-body p-0">
    <div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">
      {{-- BREADCRUMBS --}}
      <span class="me-2">
        <a href="/data_pelatihan" class="ti ti-arrow-left fw-bolder ms-2"></a>
      </span>
      <span class="text-dark text-opacity-50">
        <a href="/data_pelatihan">Data Pelatihan / </a>
      </span>
      Edit Data Pelatihan
    </div>
    <form action="/data_pelatihan/{{ $dataPelatihan->id }}" method="POST" class="px-3 py-3" id="editFormID">
      @method('PUT')
      @csrf

      {{-- KODE --}}
      <div class="row">
        <div class="col-md-6">
          <div class="form-group mt-1 mb-3">
            <label for="kode" class="fw-bolder">Kode</label>
            <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode"
              value="{{ old('kode') ?? $dataPelatihan->kode }}">
            <span class="text-danger">{{ $errors->first('kode') }}</span>
          </div>
        </div>
        <div class="col-md-6">
          {{-- RUMPUN --}}
          <div class="form-group mt-1 mb-3">
            <label for="rumpun_id" class="fw-bolder">Rumpun</label>
            <select class="form-select @error('rumpun_id') is-invalid @enderror rumpun-single-pelatihan" id="rumpun_id"
              name="rumpun_id">
              <option value=""></option>
              @foreach ($rumpuns as $rumpun)
              <option value="{{ $rumpun->id }}" {{ (old('rumpun_id') ?? $dataPelatihan->rumpun_id) == $rumpun->id ?
                'selected' : '' }}>
                {{ $rumpun->rumpun }}
              </option>
              @endforeach
            </select>
            <span class="text-danger">{{ $errors->first('rumpun_id') }}</span>
          </div>
        </div>
      </div>

      {{-- NAMA PELATIHAN --}}
      <div class="form-group mt-1 mb-3">
        <label for="nama_pelatihan" class="fw-bolder">Nama Pelatihan</label>
        <input type="text" class="form-control @error('nama_pelatihan') is-invalid @enderror" id="nama_pelatihan"
          name="nama_pelatihan" value="{{ old('nama_pelatihan') ?? $dataPelatihan->nama_pelatihan }}">
        <span class="text-danger">{{ $errors->first('nama_pelatihan') }}</span>
      </div>

      {{-- DESKRIPSI PELATIHAN --}}
      <div class="form-group mt-1 mb-3">
        <label for="deskripsi" class="fw-bolder">Deskripsi Pelatihan</label>
        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
          style="height: 130px">{{ old('deskripsi') ?? $dataPelatihan->deskripsi }}</textarea>
        <span class="text-danger">{{ $errors->first('deskripsi') }}</span>
      </div>

      {{-- JAM PELAJARAN --}}
      <div class="form-group mt-1 mb-3">
        <label for="jp" class="fw-bolder">Jam Pelajaran (JP)</label>
        <input type="number" class="form-control @error('jp') is-invalid @enderror" id="jp" name="jp"
          value="{{ old('jp') ?? $dataPelatihan->jp }}">
        <span class="text-danger">{{ $errors->first('jp') }}</span>
      </div>

      {{-- MATERI PELATIHAN --}}
      <div class="form-group mt-1 mb-3">
        <label for="materi" class="fw-bolder">Materi Pelatihan</label>
        <textarea class="form-control @error('materi') is-invalid @enderror w-100" id="materi"
          name="materi">{{ old('materi') ?? $dataPelatihan->materi }}</textarea>
        <span class="text-danger">{{ $errors->first('materi') }}</span>
      </div>
      <hr class="mb-3">
      {{-- ESTIMASI HARGA --}}
      @foreach ($dataPelatihan->anggaranPelatihan as $anggaran)
      <div class="mb-3">
        <label class="fw-bolder">Estimasi Harga untuk
          @if($anggaran->region->region == 'nasional')
          <span class="text-primary">NASIONAL</span>
          @elseif($anggaran->region->region == 'internasional')
          <span class="text-warning">INTERNASIONAL</span>
          @endif</span> - {{ucfirst($anggaran->kategori->kategori)}}
        </label>
        <div class="row">
          <div class="col-md-6">
            <!-- Input untuk tampilan (format rupiah) -->
            <input type="text"
              class="form-control format-rupiah @error('anggaran.'.$anggaran->id.'.anggaran_min') is-invalid @enderror"
              id="anggaran_min_display_{{ $anggaran->id }}"
              value="Rp{{ number_format(old('anggaran.'.$anggaran->id.'.anggaran_min', $anggaran->anggaran_min), 0, ',', '.') }}"
              placeholder="Min. Anggaran" onfocus="this.select()">

            <!-- Input hidden untuk nilai mentah -->
            <input type="hidden" name="anggaran[{{ $anggaran->id }}][anggaran_min]"
              id="anggaran_min_{{ $anggaran->id }}"
              value="{{ old('anggaran.'.$anggaran->id.'.anggaran_min', $anggaran->anggaran_min) }}">
            @error('anggaran.'.$anggaran->id.'.anggaran_min')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="col-md-6">
            <!-- Input untuk tampilan (format rupiah) -->
            <input type="text"
              class="form-control format-rupiah @error('anggaran.'.$anggaran->id.'.anggaran_maks') is-invalid @enderror"
              id="anggaran_maks_display_{{ $anggaran->id }}"
              value="Rp{{ number_format(old('anggaran.'.$anggaran->id.'.anggaran_maks', $anggaran->anggaran_maks), 0, ',', '.') }}"
              placeholder="Maks. Anggaran" onfocus="this.select()">

            <!-- Input hidden untuk nilai mentah -->
            <input type="hidden" name="anggaran[{{ $anggaran->id }}][anggaran_maks]"
              id="anggaran_maks_{{ $anggaran->id }}"
              value="{{ old('anggaran.'.$anggaran->id.'.anggaran_maks', $anggaran->anggaran_maks) }}">
            @error('anggaran.'.$anggaran->id.'.anggaran_maks')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
        </div>

      </div>
      @endforeach

      {{-- BUTTON --}}
      <div class="d-flex justify-content-start mt-4 mb-3">
        <form>
          <button type="submit" class="btn btn-primary me-1" id="editAlert">SIMPAN</button>
        </form>
        <a href="/data_pelatihan" class="btn btn-warning me-1">BATAL</a>
        <form action="/data_pelatihan/{{ $dataPelatihan->id }}" method="POST" class="d-flex">
          @csrf
          @method('delete')
          <button type="submit" class="btn btn-danger">HAPUS DATA</button>
        </form>
      </div>
    </form>
  </div>
</div>

{{-- FORMAT RUPIAH RIBUAN --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
      // Seleksi semua input dengan class "format-rupiah"
      const rupiahInputs = document.querySelectorAll('.format-rupiah');

      rupiahInputs.forEach((input) => {
          // Event listener saat pengguna mengetik di input
          input.addEventListener('input', function () {
              let rawValue = this.value.replace(/[^0-9]/g, ''); // Hanya angka
              const formattedValue = formatRupiah(rawValue);
              this.value = formattedValue; // Update tampilan dengan format

              // Update nilai di input hidden
              const hiddenInput = document.getElementById(this.id.replace('_display', ''));
              if (hiddenInput) {
                  hiddenInput.value = rawValue; // Simpan nilai mentah (angka)
              }
          });

          // Format ulang nilai yang sudah ada saat halaman dimuat
          input.dispatchEvent(new Event('input'));
      });

      // Fungsi untuk memformat angka menjadi format Rupiah
      function formatRupiah(angka) {
          if (!angka) return 'Rp '; // Jika kosong, tampilkan 'Rp '
          const numberString = angka.toString();
          const sisa = numberString.length % 3;
          let rupiah = numberString.substr(0, sisa);
          const ribuan = numberString.substr(sisa).match(/\d{3}/g);

          if (ribuan) {
              const separator = sisa ? '.' : '';
              rupiah += separator + ribuan.join('.');
          }

          return 'Rp ' + rupiah; // Tambahkan 'Rp ' di depan
      }
  });
</script>




@endsection