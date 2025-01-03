@extends('layouts.app_modern', ['title'=>'Edit Data Pelatihan'])
@section('content')
<div class="card mb-3 bg-white">
  <div class="card-body p-0 ">
    <div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">
      {{-- BREADCRUMBS --}}
      <span class="me-2">
        <a href="/data_pelatihan" class="ti ti-arrow-left fw-bolder ms-2"></a>
      </span>
      <span class="text-dark text-opacity-50">
        <a href="/data_pelatihan">Data Pelatihan / </a>
      </span>
      {{-- BREADCRUMBS END --}}
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
            <div class="col">
              <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode"
                value="{{ old('kode') ?? $dataPelatihan->kode}}">
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
                value="{{ old('rumpun') ?? $dataPelatihan->rumpun }}">
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
            name="nama_pelatihan" value="{{ old('nama_pelatihan') ?? $dataPelatihan->nama_pelatihan}}">
        </div>
        <span class="text-danger">{{ $errors->first('nama_pelatihan') }}</span>
      </div>

      {{-- DESKRIPSI PELATIHAN --}}
      <div class="form-group mt-1 mb-3">
        <label for="deskripsi" class="fw-bolder">Deskripsi Pelatihan</label>
        <div class="col">
          <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi"
            name="deskripsi">{{ old('deskripsi') ?? $dataPelatihan->deskripsi }}</textarea>
        </div>
        <span class="text-danger">{{ $errors->first('deskripsi') }}</span>
      </div>

      {{-- JAM PELAJARAN --}}
      <div class="form-group mt-1 mb-3">
        <label for="jp" class="fw-bolder">Jam Pelajaran (JP)</label>
        <div class="col-md-7">
          <input type="text" class="form-control @error('jp') is-invalid @enderror" id="jp" name="jp"
            value="{{ old('jp') ?? $dataPelatihan->jp }}">
        </div>
        <span class="text-danger">{{ $errors->first('jp') }}</span>
      </div>

      {{-- MATERI PELATIHAN --}}
      <div class="form-group mt-1 mb-3">
        <label for="materi" class="fw-bolder">Materi Pelatihan</label>
        <div class="col">
          <textarea type="text" class="form-control @error('materi') is-invalid @enderror" id="materi"
            name="materi">{{ old('materi') ?? $dataPelatihan->materi }}</textarea>
        </div>
        <span class="text-danger">{{ $errors->first('materi') }}</span>
      </div>


      @foreach ($dataPelatihan->estimasiHarga as $estimasi)
      {{-- ESTIMASI HARGA NASIONAL --}}
      <div>
        <label class="fw-bolder">Estimasi Harga <span
            class="{{ $estimasi->region === 'internasional' ? 'text-warning' : 'text-primary' }}">{{
            ucfirst($estimasi->region) }}
          </span> - <span class="text-secondary">{{ ucfirst($estimasi->kategori) }}</span>
        </label>
        <div class="row mb-2">
          <div class="col-md-6">
            <div class="form-group">
              <label for="anggaran_min_{{ $estimasi->id }}">Anggaran Minimum</label>
              <input type="text" name="estimasi[{{ $estimasi->id }}][anggaran_min_display]"
                id="anggaran_min_{{ $estimasi->id }}" class="form-control format-rupiah"
                value="Rp {{ number_format($estimasi->anggaran_min, 0, ',', '.') }}">
              <input type="hidden" name="estimasi[{{ $estimasi->id }}][anggaran_min]"
                value="{{ $estimasi->anggaran_min }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="anggaran_maks_{{ $estimasi->id }}">Anggaran Maksimum</label>
              <input type="text" name="estimasi[{{ $estimasi->id }}][anggaran_maks_display]"
                id="anggaran_maks_{{ $estimasi->id }}" class="form-control format-rupiah"
                value="Rp {{ number_format($estimasi->anggaran_maks, 0, ',', '.') }}">
              <input type="hidden" name="estimasi[{{ $estimasi->id }}][anggaran_maks]"
                value="{{ $estimasi->anggaran_maks }}">
            </div>
          </div>
        </div>

      </div>
      @endforeach

      {{-- BUTTON --}}
      <div class="d-flex justify-content-start mt-4 mb-3">
        <form>
          <button type="submit" class="btn btn-primary me-1" id="editAlert">SIMPAN</button>
        </form>
        <a href="/data_pelatihan" class="btn btn-warning me-1">BATAL EDIT</a>
        <form action="/data_pelatihan/{{ $dataPelatihan->id }}" method="POST" class="d-flex" id="deleteFormID">
          @csrf
          @method('delete')
          <button type="submit" class="btn btn-danger" id="deleteAlert">
            HAPUS DATA
          </button>
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
      // Event listener saat input berubah
      input.addEventListener('input', function () {
        formatRupiah(input);
      });
    });
  });

  function formatRupiah(input) {
    // Ambil nilai input dan buang format lama
    let rawValue = input.value.replace(/[^,\d]/g, '');

    // Masukkan ke input hidden terkait
    const hiddenInput = input.nextElementSibling;
    if (hiddenInput && hiddenInput.type === 'hidden') {
      hiddenInput.value = rawValue;
    }

    // Format ulang untuk menampilkan sebagai rupiah
    let formattedValue = '';
    const split = rawValue.split(',');
    const sisa = split[0].length % 3;
    formattedValue += split[0].substr(0, sisa);
    const ribuan = split[0].substr(sisa).match(/\d{3}/g);

    if (ribuan) {
      const separator = sisa ? '.' : '';
      formattedValue += separator + ribuan.join('.');
    }

    input.value = 'Rp ' + formattedValue + (split[1] ? ',' + split[1] : '');
  }
</script>


@endsection