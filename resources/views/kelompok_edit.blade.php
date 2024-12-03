@extends('layouts.app_modern', ['title'=>'Edit Kelompok'])
@section('content')
<div class="card mb-3 bg-white">
  <div class="card-body p-0 ">
    <div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">
      <span class="me-2">
        <a href="/kelompok" class="ti ti-arrow-left fw-bolder ms-2"></a>
      </span>
      Edit Kelompok <span class="fw-bolder tw-text-blue-500">{{ $kelompok->ketua->nama }}</span>
    </div>
    <form action="/kelompok/{{ $kelompok->id }}" method="POST" class="px-4 py-2" id="editFormID">
      @method('PUT')
      @csrf
      <div class="form-group mt-2 mb-3">
        <label for="ketua_id">Edit Ketua Kelompok</label>
        <select name="ketua_id" id="ketua_id" class="form-control placeholder-single">
          <option value=""></option>
          @foreach($listPegawai as $pegawai)
          <option value="{{ $pegawai->id }}" @selected(in_array($pegawai->id, $kelompok->pluck('ketua_id')->toArray()))>
            {{ $pegawai->nppu }} - {{ $pegawai->nama }} | {{ $pegawai->unit_kerja }}
          </option>
          @endforeach
        </select>
      </div>

      <div class="form-group mb-3">
        <label for="anggota">Edit Anggota | <span class="text-warning">19 Orang</span></label>
        <select name="anggota[]" id="anggota"
          class="form-control placeholder-multiple @error('anggota') is-invalid @enderror" multiple="multiple">
          @foreach($listPegawai as $pegawai)
          @if($pegawai->id != $kelompok->ketua_id)
          <option value="{{ $pegawai->id }}" @selected(in_array($pegawai->id,
            $kelompok->anggota->pluck('id')->toArray()))>
            {{ $pegawai->nppu }} - {{ $pegawai->nama }} | {{ $pegawai->unit_kerja }}
          </option>
          @endif
          @endforeach
        </select>
        @if ($errors->has('anggota'))
        <span class="invalid-feedback">
          <strong>{{ $errors->first('anggota') }}</strong>
        </span>
        @endif
      </div>

      <div class="d-flex justify-content-start my-2">
        <form>
          <button type="submit" class="btn btn-primary me-1" id="editAlert">SIMPAN</button>
        </form>
        <a href="/kelompok" class="btn btn-warning me-1">BATAL EDIT</a>
        <form action="/kelompok/{{ $kelompok->id }}" method="POST" class="d-flex" id="deleteFormID">
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

<script>
  document.getElementById('editAlert').onclick = function(event){
  event.preventDefault();
  Swal.fire({
      title: "Konfirmasi Data",
      text: "Pastikan Data yang Anda Edit Sudah Benar",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Simpan",
      cancelButtonText: "Batal"
  }).then((result) => {
      if (result.isConfirmed) {
        // Submit form atau aksi lain setelah konfirmasi
        document.getElementById('editFormID').submit(); // Sesuaikan ID form
      }
    });
  }
</script>
<script>
  document.getElementById('deleteAlert').onclick = function(event){
  event.preventDefault();
  Swal.fire({
      title: "Apakah Anda Yakin?",
      text: "Data Akan Dihapus Permanen dari Basis Data!",
      icon: "warning",
      showCancelButton: true,
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, Hapus!",
      cancelButtonText: "Batal"
  }).then((result) => {
      if (result.isConfirmed) {
      Swal.fire({
          title: "Berhasil!",
          text: "Data Berhasil Dihapus",
          icon: "error"
      }).then(() => {
          // Submit form atau aksi lain setelah konfirmasi
          document.getElementById('deleteFormID').submit(); // Sesuaikan ID form
      });
      }
  });
  }
</script>

@endsection