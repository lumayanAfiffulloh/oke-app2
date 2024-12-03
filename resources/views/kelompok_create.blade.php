@extends('layouts.app_modern', ['title'=>'Buat Kelompok'])
@section('content')
<div class="card mb-4 pb-2 bg-white">
  <div class="card-body px-0 py-0 ">
    <div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">
      <span class="me-2">
        <a href="/kelompok" class="ti ti-arrow-left fw-bolder ms-2"></a>
      </span>
      Buat Kelompok Baru
    </div>
    <form action="{{ route('kelompok.store') }}" method="POST" class="px-4 py-2" id="createFormID">
      @csrf

      <div class="form-group mt-2 mb-3">
        <label for="ketua_id">Ketua Kelompok</label>
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
        <label for="anggota">Pilih Anggota | <span class="text-warning">19 Orang</span></label>
        <select name="anggota[]" id="anggota"
          class="form-control placeholder-multiple @error('anggota') is-invalid @enderror" multiple="multiple" required>
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

      <button type="submit" class="btn btn-primary mb-3" id="createAlert">Buat Kelompok</button>
    </form>
  </div>
</div>

<script>
  document.getElementById('createAlert').onclick = function(event){
    event.preventDefault();
    Swal.fire({
      title: "Konfirmasi Data",
      text: "Pastikan Data yang Anda Isikan Sudah Benar",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Simpan",
      cancelButtonText: "Batal"
    }).then(() => {
          // Submit form atau aksi lain setelah konfirmasi
          document.getElementById('createFormID').submit(); // Sesuaikan ID form
        });
      }
</script>

@endsection