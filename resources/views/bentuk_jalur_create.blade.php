@extends('layouts.app_modern', ['title'=>'Tambah Bentuk Jalur'])
@section('content')
<div class="card bg-white">
  <div class="card-body p-0">
    <div class="card-header p-3 fs-5 fw-bolder " style="background-color: #ececec;">
      <span class="me-2">
        <a href="/bentuk_jalur" class="ti ti-arrow-left fw-bolder ms-2"></a>
      </span>
      Tambah Bentuk Jalur
    </div>
    <form action="/bentuk_jalur" method="POST" class="px-4 py-2">
      @csrf
      {{-- KATEGORI --}}
      <div class="form-group mt-1 mb-3">
        <label for="kategori" class="fw-bolder">Kategori</label>
        <div class="col-md-6">
          <select class="form-select" id="kategori" name="kategori">
            <option value="" selected disabled id="pilih">-- Pilih Kategori --</option>
            <option value="klasikal" {{ old('kategori')==='klasikal' ? 'selected' : '' }} id="kategori-klasikal">
              Klasikal</option>
            <option value="non-klasikal" {{ old('kategori')==='non-klasikal' ? 'selected' : '' }}
              id="kategori-non-klasikal">Non-Klasikal</option>
          </select>
          <span class="text-danger">{{ $errors->first('kategori') }}</span>
        </div>
      </div>

      {{-- BENTUK JALUR --}}
      <div class="form-group mt-1 mb-3">
        <label for="bentuk_jalur" class="fw-bolder">Bentuk Jalur</label><br>
        <div class="col">
          <input type="text" class="form-control @error('bentuk_jalur') is-invalid @enderror" id="bentuk_jalur"
            name="bentuk_jalur" value="{{ old('bentuk_jalur') }}">
        </div>
        <span class="text-danger">{{ $errors->first('bentuk_jalur') }}</span>
      </div>

      <button type="submit" class="btn btn-primary mb-2">SIMPAN</button>
    </form>
  </div>
</div>
@endsection