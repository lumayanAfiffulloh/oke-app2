@extends('layouts.app_modern', ['title'=>'Edit Data Pegawai'])
@section('content')
    <div class="card mb-3 bg-white">
        <div class="card-body p-0 ">
            <div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">Edit Data Pegawai <span class="fw-bolder tw-text-blue-500">{{ $data_pegawai->nama }}</span></div>
            <form action="/data_pegawai/{{ $data_pegawai->id }}" method="POST" enctype="multipart/form-data" class="px-3 py-3">
                @method('PUT')
                @csrf

                {{-- FOTO --}}
                <div class="form-group mt-1 mb-3">                    
                    @if($data_pegawai->foto) 
                    <a href="{{ Storage::url($data_pegawai->foto) }}" target="blank" id="fotobaru">
                        <img src="{{ Storage::url($data_pegawai->foto) }}" class="rounded mx-start d-block " style="object-fit: cover; height: 150px; width: 150px;">
                    </a>
                    @endif
                    <label for="foto" class="mt-2">Upload Foto Baru Pegawai</label> 
                    <input type="file" class="form-control @error('foto') is-invalid @enderror" id="fotoubah" name="foto">
                    <span class="text-danger">{{ $errors->first('foto') }}</span>
                </div>

                {{-- NAMA PEGAWAI --}}
                <div class="form-group mt-1 mb-3">
                    <label for="nama">Nama Pegawai</label> 
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') ?? $data_pegawai->nama }}">
                    <span class="text-danger">{{ $errors->first('nama') }}</span>
                </div>

                {{-- NIP--}}
                <div class="form-group mt-1 mb-3"> 
                    <label for="nip">NIP</label>
                    <input type="number" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip') ?? $data_pegawai->nip}}">
                    <span class="text-danger">{{ $errors->first('nip') }}</span>
                </div>
                
                {{-- EMAIL --}}
                <div class="form-group mt-1 mb-3">
                    <label for="email">Email</label> 
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}">
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>

                {{-- Status --}}
                <div class="form-group mt-1 mb-3"> 
                    <label for="status">Status</label><br> 
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="aktif" value="aktif" {{ old('status') ?? $data_pegawai->status === 'aktif' ? 'checked' : '' }}>
                        <label class="form-check-label" for="aktif">Aktif</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="non-aktif" value="non-aktif" {{ old('status') ?? $data_pegawai->status === 'non-aktif' ? 'checked' : '' }}>
                        <label class="form-check-label" for="non-aktif">Non-aktif</label>
                    </div>
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                </div>

                {{-- UNIT KERJA --}}
                <div class="form-group mt-1 mb-3"> 
                    <label for="unit_kerja">Unit Kerja</label>
                    <input type="text" class="form-control @error('unit_kerja') is-invalid @enderror" id="unit_kerja"
                    name="unit_kerja" value="{{ old('unit_kerja') ?? $data_pegawai->unit_kerja}}">
                    <span class="text-danger">{{ $errors->first('unit_kerja') }}</span>
                </div>

                {{-- JABATAN --}}
                <div class="form-group mt-1 mb-3"> 
                    <label for="jabatan">Jabatan</label>
                    <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan"
                    name="jabatan" value="{{ old('jabatan') ?? $data_pegawai->jabatan}}">
                    <span class="text-danger">{{ $errors->first('jabatan') }}</span>
                </div>

                {{-- PENDIDIKAN --}}
                <div class="form-group mt-1 mb-3"> 
                    <label for="pendidikan">Pendidikan Terakhir</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="pendidikan" id="SMA" value="SMA" {{ old('pendidikan') ?? $data_pegawai->pendidikan === 'SMA' ? 'checked' : '' }}>
                        <label class="form-check-label" for="SMA">SMA</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="pendidikan" id="S1" value="S1" {{ old('pendidikan') ?? $data_pegawai->pendidikan === 'S1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="S1">S1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="pendidikan" id="S2" value="S2" {{ old('pendidikan') ?? $data_pegawai->pendidikan === 'S2' ? 'checked' : '' }}>
                        <label class="form-check-label" for="S2">S2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="pendidikan" id="S3" value="S3" {{ old('pendidikan') ?? $data_pegawai->pendidikan === 'S3' ? 'checked' : '' }}>
                        <label class="form-check-label" for="S3">S3</label>
                    </div>
                    <span class="text-danger">{{ $errors->first('pendidikan') }}</span>
                </div>

                {{-- JENIS KELAMIN --}}
                <div class="form-group mt-1 mb-3"> 
                    <label for="jenis_kelamin">Jenis Kelamin</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki_laki" value="laki-laki" {{ old('jenis_kelamin') ?? $data_pegawai->jenis_kelamin === 'laki-laki' ? 'checked' : '' }}>
                        <label class="form-check-label" for="laki_laki">Laki-laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="perempuan" {{ old('jenis_kelamin') ?? $data_pegawai->jenis_kelamin === 'perempuan' ? 'checked' : '' }}>
                        <label class="form-check-label" for="perempuan">Perempuan</label>
                    </div>
                    <span class="text-danger">{{ $errors->first('jenis_kelamin') }}</span>
                </div>

                {{-- AKSES --}}
                <div class="form-group mt-1 mb-3"> 
                    <label for="akses">Akses</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="akses" id="pegawai" value="pegawai" {{ old('akses') ?? $user->akses === 'pegawai' ? 'checked' : '' }}>
                        <label class="form-check-label" for="pegawai">Pegawai</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="akses" id="ketua_kelompok" value="ketua_kelompok" {{ old('akses') ?? $user->akses === 'ketua_kelompok' ? 'checked' : '' }}>
                        <label class="form-check-label" for="ketua_kelompok">Ketua Kelompok</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="akses" id="approval" value="approval" {{ old('akses') ?? $user->akses === 'approval' ? 'checked' : '' }}>
                        <label class="form-check-label" for="approval">Approval</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="akses" id="verifikator" value="verifikator" {{ old('akses') ?? $user->akses === 'verifikator' ? 'checked' : '' }}>
                        <label class="form-check-label" for="verifikator">Verifikator</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="akses" id="admin" value="admin" {{ old('akses') ?? $user->akses === 'admin' ? 'checked' : '' }}>
                        <label class="form-check-label" for="admin">Admin</label>
                    </div>
                    <span class="text-danger">{{ $errors->first('akses') }}</span>
                </div>

                {{-- BUTTON --}}
                <div class="d-flex justify-content-start mt-2">
                    <form>
                        <button type="submit" class="btn btn-primary me-1 tw-transition tw-ease-in-out tw-delay-10 hover:tw-translate-y-0 hover:tw-scale-110 hover:tw-bg-blue-600 tw-duration-200">SIMPAN</button>
                    </form>
                    <a name="" id="" class="btn btn-warning me-1 tw-transition tw-ease-in-out tw-delay-10 hover:tw-translate-y-0 hover:tw-scale-110 hover:tw-bg-orange-400 tw-duration-200" href="/data_pegawai">BATAL EDIT</a>
                    <form action="/data_pegawai/{{ $data_pegawai->id }}" method="POST" class="d-flex">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger tw-transition tw-ease-in-out tw-delay-10 hover:tw-translate-y-0 hover:tw-scale-110 hover:tw-bg-red-500 tw-duration-200" onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                            HAPUS DATA
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>
@endsection