@extends('layouts.app_modern', ['title'=>'Tambah Data Pegawai'])
@section('content')
    <div class="card bg-white">
        <div class="card-body p-0">
            <div class="card-header p-3 fs-5 fw-bolder">Form Pegawai</div>
            <form action="/data_pegawai" method="POST" enctype="multipart/form-data" class="px-4 py-2">
                @csrf
                <div class="form-group mt-1 mb-3">
                    <label for="foto">Foto Pegawai</label> {{-- FOTO --}}
                    <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto">
                    <span class="text-danger">{{ $errors->first('foto') }}</span>
                </div>
                <div class="form-group mt-1 mb-3">
                    <label for="nama">Nama Pegawai</label> {{-- NAMA PEGAWAI --}}
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}">
                    <span class="text-danger">{{ $errors->first('nama') }}</span>
                </div>
                <div class="form-group mt-1 mb-3"> {{-- Status --}}
                    <label for="status">Status</label><br> 
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="aktif" value="aktif" {{ old('status') === 'aktif' ? 'checked' : '' }}>
                        <label class="form-check-label" for="aktif">Aktif</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="non-aktif" value="non-aktif" {{ old('status') === 'non-aktif' ? 'checked' : '' }}>
                        <label class="form-check-label" for="non-aktif">Non-aktif</label>
                    </div>
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                </div>
                <div class="form-group mt-1 mb-3"> {{-- TANGGAL LAHIR --}}
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                    <spanclass="text-danger">{{ $errors->first('tanggal_lahir') }}</span>
                </div>
                <div class="form-group mt-1 mb-3"> {{-- UNIT KERJA --}}
                    <label for="unit_kerja">Unit Kerja</label>
                    <input type="text" class="form-control @error('unit_kerja') is-invalid @enderror" id="unit_kerja"
                    name="unit_kerja" value="{{ old('unit_kerja') }}">
                    <span class="text-danger">{{ $errors->first('unit_kerja') }}</span>
                </div>
                <div class="form-group mt-1 mb-3"> {{-- JABATAN --}}
                    <label for="jabatan">Jabatan</label>
                    <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan"
                    name="jabatan" value="{{ old('jabatan') }}">
                    <span class="text-danger">{{ $errors->first('jabatan') }}</span>
                </div>
                <div class="form-group mt-1 mb-3"> {{-- PENDIDIKAN --}}
                    <label for="pendidikan">Pendidikan Terakhir</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="pendidikan" id="SMA" value="SMA" {{ old('pendidikan') === 'SMA' ? 'checked' : '' }}>
                        <label class="form-check-label" for="SMA">SMA</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="pendidikan" id="S1" value="S1" {{ old('pendidikan') === 'S1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="S1">S1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="pendidikan" id="S2" value="S2" {{ old('pendidikan') === 'S2' ? 'checked' : '' }}>
                        <label class="form-check-label" for="S2">S2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="pendidikan" id="S3" value="S3" {{ old('pendidikan') === 'S3' ? 'checked' : '' }}>
                        <label class="form-check-label" for="S3">S3</label>
                    </div>
                    <span class="text-danger">{{ $errors->first('pendidikan') }}</span>
                </div>
                <div class="form-group mt-1 mb-3"> {{-- ROLE --}}
                    <label for="role">Daftar Sebagai</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role" id="user" value="user" {{ old('role') === 'user' ? 'checked' : '' }}>
                        <label class="form-check-label" for="user">user</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role" id="ketua kelompok" value="ketua kelompok" {{ old('role') === 'ketua kelompok' ? 'checked' : '' }}>
                        <label class="form-check-label" for="ketua kelompok">ketua kelompok</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role" id="admin" value="admin" {{ old('role') === 'admin' ? 'checked' : '' }}>
                        <label class="form-check-label" for="admin">admin</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role" id="verifikator" value="verifikator" {{ old('role') === 'verifikator' ? 'checked' : '' }}>
                        <label class="form-check-label" for="verifikator">verifikator</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role" id="approval" value="approval" {{ old('role') === 'approval' ? 'checked' : '' }}>
                        <label class="form-check-label" for="approval">approval</label>
                    </div>
                    <span class="text-danger">{{ $errors->first('role') }}</span>
                </div>
                <div class="form-group mt-1 mb-3"> {{-- JENIS KELAMIN --}}
                    <label for="jenis_kelamin">Jenis Kelamin</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki_laki" value="laki-laki" {{ old('jenis_kelamin') === 'laki-laki' ? 'checked' : '' }}>
                        <label class="form-check-label" for="laki_laki">Laki-laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="perempuan" {{ old('jenis_kelamin') === 'perempuan' ? 'checked' : '' }}>
                        <label class="form-check-label" for="perempuan">Perempuan</label>
                    </div>
                    <span class="text-danger">{{ $errors->first('jenis_kelamin') }}</span>
                </div>
                <button type="submit" class="btn btn-primary mb-2 tw-transition tw-ease-in-out tw-delay-10 hover:tw-translate-y-0 hover:tw-scale-110 hover:tw-bg-blue-500 tw-duration-200">SIMPAN</button>
            </form>
        </div>
    </div>
@endsection