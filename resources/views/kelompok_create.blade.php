@extends('layouts.app_modern', ['title'=>'Buat Kelompok'])
@section('content')
<div class="card mb-4 bg-white">
  <div class="card-body px-0 py-0 ">
    <div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">Buat Kelompok Baru</div>
    <form action="{{ route('kelompok.store') }}" method="POST" class="px-4 py-2">
      @csrf

      <div class="form-group mt-2 mb-3">
        <label for="ketua_id">Ketua Kelompok</label>
        <select name="ketua_id" id="ketua_id" class="form-control placeholder-single" required>
          <option value=""></option>
          @foreach($listPegawai as $pegawai)
            <option value="{{ $pegawai->id }}" @selected(old('ketua_id'))>
              {{ $pegawai->nip }} - {{ $pegawai->nama }} | {{ $pegawai->unit_kerja }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="form-group mb-3">
        <label for="anggota">Pilih Anggota | <span class="text-warning">19 Orang</span></label>
        <select name="anggota[]" id="anggota" class="form-control placeholder-multiple @error('anggota') is-invalid @enderror" multiple="multiple" required>
          @foreach($listPegawai as $pegawai)
            <option value="{{ $pegawai->id }}" @selected(old('anggota', []))>
              {{ $pegawai->nip }} - {{ $pegawai->nama }} | {{ $pegawai->unit_kerja }}
            </option>
          @endforeach
        </select>
        @if ($errors->has('anggota'))
          <span class="invalid-feedback">
            <strong>{{ $errors->first('anggota') }}</strong>
          </span>
        @endif
      </div>

      <button type="submit" class="btn btn-primary mb-3">Buat Kelompok</button>
    </form>
  </div>
</div>
@endsection