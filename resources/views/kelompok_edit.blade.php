@extends('layouts.main_layout', ['title'=>'Edit Kelompok'])
@section('content')
<div class="card mb-3 bg-white">
  <div class="card-body p-0 ">
    <div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">
      <span class="me-2">
        <a href="/kelompok" class="ti ti-arrow-left fw-bolder ms-2"></a>
      </span>
      <span class="text-dark text-opacity-50">
        <a href="/kelompok">Data Kelompok / </a>
      </span>
      Edit Kelompok <span class="fw-bolder text-primary">{{ $kelompok->ketua->nama }}</span>
    </div>
    <form action="/kelompok/{{ $kelompok->id }}" method="POST" class="px-4 py-2" id="editFormID">
      @method('PUT')
      @csrf
      <div class="form-group mt-2 mb-3">
        <label for="id_ketua" class="fw-semibold">Edit Ketua Kelompok</label>
        <select name="id_ketua" id="id_ketua" class="form-control placeholder-single-edit">
          <option value=""></option>
          @foreach($listPegawai as $pegawai)
          <option value="{{ $pegawai->id }}" @selected(in_array($pegawai->id, $kelompok->pluck('id_ketua')->toArray()))>
            {{ $pegawai->nppu }} - {{ $pegawai->nama }} | {{ $pegawai->unitKerja->unit_kerja }}
          </option>
          @endforeach
        </select>
      </div>

      <div class="form-group mb-3">
        <label for="anggota" class="fw-semibold">Edit Anggota | <span class="text-warning">19 Orang</span></label>
        <select name="anggota[]" id="anggota"
          class="form-control placeholder-multiple-edit @error('anggota') is-invalid @enderror" multiple="multiple">
          @foreach($listPegawai as $pegawai)
          @if($pegawai->id != $kelompok->id_ketua)
          <option value="{{ $pegawai->id }}" @selected(in_array($pegawai->id,
            $kelompok->anggota->pluck('id')->toArray()))>
            {{ $pegawai->nppu }} - {{ $pegawai->nama }} | {{ $pegawai->unitKerja->unit_kerja }}
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

@endsection