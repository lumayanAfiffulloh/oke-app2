@extends('layouts.app_modern', ['title'=>'Tambah Data Pegawai'])
@section('content')
<div class="card bg-white">
	<div class="card-body p-0">
		<div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">
			<span class="me-2">
				<a href="/data_pegawai" class="ti ti-arrow-left fw-bolder ms-2"></a>
			</span>
			<span class="text-dark text-opacity-50">
				<a href="/data_pegawai">Data Pegawai / </a>
			</span>
			Form Tambah Pegawai
		</div>
		<form action="/data_pegawai" method="POST" enctype="multipart/form-data" class="px-4 py-2" id="createFormID">
			@csrf
			{{-- FOTO --}}
			<div class="form-group mt-1 mb-3">
				<label class="fw-semibold" for="foto">Foto Pegawai</label>
				<input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto">
				<span class="text-danger">{{ $errors->first('foto') }}</span>
			</div>

			{{-- NAMA PEGAWAI --}}
			<div class="form-group mt-1 mb-3">
				<label class="fw-semibold" for="nama">Nama Pegawai<span class="text-danger">*</span></label>
				<input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
					value="{{ old('nama') }}">
				<span class="text-danger">{{ $errors->first('nama') }}</span>
			</div>

			<div class="row">
				{{-- NPPU --}}
				<div class="col-md-6">
					<div class="form-group mt-1 mb-3">
						<label class="fw-semibold" for="nppu">NPPU<span class="text-danger">*</span></label>
						<input type="text" class="form-control @error('nppu') is-invalid @enderror" id="nppu" name="nppu"
							value="{{ old('nppu') }}">
						<span class="text-danger">{{ $errors->first('nppu') }}</span>
					</div>
				</div>

				{{-- EMAIL --}}
				<div class="col-md-6">
					<div class="form-group mt-1 mb-3">
						<label class="fw-semibold" for="email">Email<span class="text-danger">*</span></label>
						<input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
							value="{{ old('email') }}">
						<span class="text-danger">{{ $errors->first('email') }}</span>
					</div>
				</div>
			</div>

			{{-- STATUS --}}
			<div class="form-group mt-1 mb-3">
				<label class="fw-semibold" for="status">Status<span class="text-danger">*</span></label><br>
				<div class="form-check form-check-inline">
					<input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="aktif"
						value="aktif" {{ old('status')==='aktif' ? 'checked' : '' }}>
					<label class="form-check-label" for="aktif">Aktif</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status"
						id="non-aktif" value="non-aktif" {{ old('status')==='non-aktif' ? 'checked' : '' }}>
					<label class="form-check-label" for="non-aktif">Non-aktif</label>
				</div>
				<span class="text-danger">{{ $errors->first('status') }}</span>
			</div>

			<div class="row">
				{{-- UNIT KERJA --}}
				<div class="col-md-6">
					<div class="form-group mt-1 mb-3">
						<label class="fw-semibold" for="unit_kerja">Unit Kerja<span class="text-danger">*</span></label>
						<input type="text" class="form-control @error('unit_kerja') is-invalid @enderror" id="unit_kerja"
							name="unit_kerja" value="{{ old('unit_kerja') }}">
						<span class="text-danger">{{ $errors->first('unit_kerja') }}</span>
					</div>
				</div>

				{{-- JABATAN --}}
				<div class="col-md-6">
					<div class="form-group mt-1 mb-3">
						<label class="fw-semibold" for="jabatan">Jabatan<span class="text-danger">*</span></label>
						<input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan"
							value="{{ old('jabatan') }}">
						<span class="text-danger">{{ $errors->first('jabatan') }}</span>
					</div>
				</div>
			</div>

			{{-- PENDIDIKAN --}}
			<div class="form-group mt-1 mb-3">
				<label class="fw-semibold" for="pendidikan">Pendidikan Terakhir<span class="text-danger">*</span></label><br>
				<div class="form-check form-check-inline">
					<input class="form-check-input @error('pendidikan') is-invalid @enderror" type="radio" name="pendidikan"
						id="SMA" value="SMA" {{ old('pendidikan')==='SMA' ? 'checked' : '' }}>
					<label class="form-check-label" for="SMA">SMA</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input @error('pendidikan') is-invalid @enderror" type="radio" name="pendidikan"
						id="D1" value="D1" {{ old('pendidikan')==='D1' ? 'checked' : '' }}>
					<label class="form-check-label" for="D1">D1</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input @error('pendidikan') is-invalid @enderror" type="radio" name="pendidikan"
						id="D2" value="D2" {{ old('pendidikan')==='D2' ? 'checked' : '' }}>
					<label class="form-check-label" for="D2">D2</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input @error('pendidikan') is-invalid @enderror" type="radio" name="pendidikan"
						id="D3" value="D3" {{ old('pendidikan')==='D3' ? 'checked' : '' }}>
					<label class="form-check-label" for="D3">D3</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input @error('pendidikan') is-invalid @enderror" type="radio" name="pendidikan"
						id="S1" value="S1" {{ old('pendidikan')==='S1' ? 'checked' : '' }}>
					<label class="form-check-label" for="S1">S1/D4</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input @error('pendidikan') is-invalid @enderror" type="radio" name="pendidikan"
						id="S2" value="S2" {{ old('pendidikan')==='S2' ? 'checked' : '' }}>
					<label class="form-check-label" for="S2">S2</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input @error('pendidikan') is-invalid @enderror" type="radio" name="pendidikan"
						id="S3" value="S3" {{ old('pendidikan')==='S3' ? 'checked' : '' }}>
					<label class="form-check-label" for="S3">S3</label>
				</div>
				<br><span class="text-danger">{{ $errors->first('pendidikan') }}</span>
			</div>

			{{-- JURUSAN PENDIDIKAN --}}
			<div class="form-group mt-1 mb-3">
				<label class="fw-semibold" for="jurusan_pendidikan">Jurusan<span class="text-danger">*</span></label>
				<input type="text" class="form-control @error('jurusan_pendidikan') is-invalid @enderror"
					id="jurusan_pendidikan" name="jurusan_pendidikan" value="{{ old('jurusan_pendidikan') }}">
				<span class="text-danger">{{ $errors->first('jurusan_pendidikan') }}</span>
			</div>

			<div class="row">
				{{-- JENIS KELAMIN --}}
				<div class="col-md-3">
					<div class="form-group mt-1 mb-3">
						<label class="fw-semibold" for="jenis_kelamin">Jenis Kelamin<span class="text-danger">*</span></label><br>
						<div class="form-check form-check-inline">
							<input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio"
								name="jenis_kelamin" id="L" value="L" {{ old('jenis_kelamin')==='L' ? 'checked' : '' }}>
							<label class="form-check-label" for="L">Laki-laki</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio"
								name="jenis_kelamin" id="P" value="P" {{ old('jenis_kelamin')==='P' ? 'checked' : '' }}>
							<label class="form-check-label" for="P">Perempuan</label>
						</div>
						<span class="text-danger">{{ $errors->first('jenis_kelamin') }}</span>
					</div>
				</div>

				{{-- NOMOR TELEPON --}}
				<div class="col-md-9">
					<div class="form-group mt-1 mb-3">
						<label class="fw-semibold" for="nomor_telepon">No. Telepon</label>
						<input type="number" class="form-control @error('nomor_telepon') is-invalid @enderror" id="nomor_telepon"
							name="nomor_telepon" value="{{ old('nomor_telepon') }}">
						<span class="text-danger">{{ $errors->first('nomor_telepon') }}</span>
					</div>
				</div>
			</div>

			{{-- ROLE --}}
			<div class="form-group mt-1 mb-3">
				<label class="fw-semibold" for="roles">Akases<span class="text-danger">*</span></label><br>
				<div class="form-check form-check-inline">
					<input class="form-check-input @error('roles') is-invalid @enderror" type="checkbox" name="roles[]" id="admin"
						value="admin" {{ is_array(old('roles')) && in_array('admin', old('roles')) ? 'checked' : '' }}>
					<label class="form-check-label" for="admin">Admin</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input @error('roles') is-invalid @enderror" type="checkbox" name="roles[]"
						id="pegawai" value="pegawai" {{ is_array(old('roles')) && in_array('pegawai', old('roles')) ? 'checked' : ''
						}}>
					<label class="form-check-label" for="pegawai">Pegawai</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input @error('roles') is-invalid @enderror" type="checkbox" name="roles[]"
						id="ketua_kelompok" value="ketua_kelompok" {{ is_array(old('roles')) && in_array('ketua_kelompok',
						old('roles')) ? 'checked' : '' }}>
					<label class="form-check-label" for="ketua_kelompok">Ketua Kelompok</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input @error('roles') is-invalid @enderror" type="checkbox" name="roles[]" id="S2"
						value="verifikator" {{ is_array(old('roles')) && in_array('verifikator', old('roles')) ? 'checked' : '' }}>
					<label class="form-check-label" for="verifikator">Verifikator</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input @error('roles') is-invalid @enderror" type="checkbox" name="roles[]"
						id="approver" value="approver" {{ is_array(old('roles')) && in_array('approver', old('roles')) ? 'checked'
						: '' }}>
					<label class="form-check-label" for="approver">Approver</label>
				</div>
				<br><span class="text-danger">{{ $errors->first('roles') }}</span>
			</div>

			<button type="submit" class="btn btn-primary mb-2" id="createAlert">SIMPAN</button>
		</form>
	</div>
</div>
@endsection