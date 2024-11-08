@extends('layouts.app_modern', ['title'=>'Tambah Data Pegawai'])
@section('content')
	<div class="card bg-white">
		<div class="card-body p-0">
			<div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">
				<span class="me-2">
					<a href="/data_pegawai" class="ti ti-arrow-left fw-bolder ms-2"></a>
				</span>
				Form Pegawai</div>
			<form action="/data_pegawai" method="POST" enctype="multipart/form-data" class="px-4 py-2" id="createFormID">
				@csrf
				{{-- FOTO --}}
				<div class="form-group mt-1 mb-3">
					<label for="foto">Foto Pegawai</label> 
					<input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto">
					<span class="text-danger">{{ $errors->first('foto') }}</span>
				</div>

				{{-- NAMA PEGAWAI --}}
				<div class="form-group mt-1 mb-3">
					<label for="nama">Nama Pegawai</label> 
					<input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}">
					<span class="text-danger">{{ $errors->first('nama') }}</span>
				</div>

				{{-- NIP --}}
				<div class="form-group mt-1 mb-3">
					<label for="nip">NIP</label> 
					<input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip') }}">
					<span class="text-danger">{{ $errors->first('nip') }}</span>
				</div>

				{{-- EMAIL --}}
				<div class="form-group mt-1 mb-3">
					<label for="email">Email</label> 
					<input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
					<span class="text-danger">{{ $errors->first('email') }}</span>
				</div>

				{{-- STATUS --}}
				<div class="form-group mt-1 mb-3"> 
					<label for="status">Status</label><br> 
					<div class="form-check form-check-inline">
						<input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="aktif" value="aktif" {{ old('status') === 'aktif' ? 'checked' : '' }}>
						<label class="form-check-label" for="aktif">Aktif</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="non-aktif" value="non-aktif" {{ old('status') === 'non-aktif' ? 'checked' : '' }}>
						<label class="form-check-label" for="non-aktif">Non-aktif</label>
					</div>
					<span class="text-danger">{{ $errors->first('status') }}</span>
				</div>
				
				{{-- UNIT KERJA --}}
				<div class="form-group mt-1 mb-3"> 
					<label for="unit_kerja">Unit Kerja</label>
					<input type="text" class="form-control @error('unit_kerja') is-invalid @enderror" id="unit_kerja"
					name="unit_kerja" value="{{ old('unit_kerja') }}">
					<span class="text-danger">{{ $errors->first('unit_kerja') }}</span>
				</div>

				{{-- JABATAN --}}
				<div class="form-group mt-1 mb-3"> 
					<label for="jabatan">Jabatan</label>
					<input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan"
					name="jabatan" value="{{ old('jabatan') }}">
					<span class="text-danger">{{ $errors->first('jabatan') }}</span>
				</div>

				{{-- PENDIDIKAN --}}
				<div class="form-group mt-1 mb-3"> 
					<label for="pendidikan">Pendidikan Terakhir</label><br>
					<div class="form-check form-check-inline">
						<input class="form-check-input @error('pendidikan') is-invalid @enderror" type="radio" name="pendidikan" id="SMA" value="SMA" {{ old('pendidikan') === 'SMA' ? 'checked' : '' }}>
						<label class="form-check-label" for="SMA">SMA</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input @error('pendidikan') is-invalid @enderror" type="radio" name="pendidikan" id="S1" value="S1" {{ old('pendidikan') === 'S1' ? 'checked' : '' }}>
						<label class="form-check-label" for="S1">S1</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input @error('pendidikan') is-invalid @enderror" type="radio" name="pendidikan" id="S2" value="S2" {{ old('pendidikan') === 'S2' ? 'checked' : '' }}>
						<label class="form-check-label" for="S2">S2</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input @error('pendidikan') is-invalid @enderror" type="radio" name="pendidikan" id="S3" value="S3" {{ old('pendidikan') === 'S3' ? 'checked' : '' }}>
						<label class="form-check-label" for="S3">S3</label>
					</div>
					<span class="text-danger">{{ $errors->first('pendidikan') }}</span>
				</div>
				
				{{-- JENIS KELAMIN --}}
				<div class="form-group mt-1 mb-3"> 
					<label for="jenis_kelamin">Jenis Kelamin</label><br>
					<div class="form-check form-check-inline">
						<input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" name="jenis_kelamin" id="laki_laki" value="laki-laki" {{ old('jenis_kelamin') === 'laki-laki' ? 'checked' : '' }}>
						<label class="form-check-label" for="laki_laki">Laki-laki</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" name="jenis_kelamin" id="perempuan" value="perempuan" {{ old('jenis_kelamin') === 'perempuan' ? 'checked' : '' }}>
						<label class="form-check-label" for="perempuan">Perempuan</label>
					</div>
					<span class="text-danger">{{ $errors->first('jenis_kelamin') }}</span>
				</div>

				{{-- AKSES --}}
				<div class="form-group mt-1 mb-3"> 
					<label for="akses">Akses</label><br>
					<div class="form-check form-check-inline">
						<input class="form-check-input @error('akses') is-invalid @enderror" type="radio" name="akses" id="pegawai" value="pegawai" {{ old('akses') === 'pegawai' ? 'checked' : '' }}>
						<label class="form-check-label" for="pegawai">Pegawai</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input @error('akses') is-invalid @enderror" type="radio" name="akses" id="ketua_kelompok" value="ketua_kelompok" {{ old('akses') === 'ketua_kelompok' ? 'checked' : '' }}>
						<label class="form-check-label" for="ketua_kelompok">Ketua Kelompok</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input @error('akses') is-invalid @enderror" type="radio" name="akses" id="approval" value="approval" {{ old('akses') === 'approval' ? 'checked' : '' }}>
						<label class="form-check-label" for="approval">Approval</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input @error('akses') is-invalid @enderror" type="radio" name="akses" id="verifikator" value="verifikator" {{ old('akses') === 'verifikator' ? 'checked' : '' }}>
						<label class="form-check-label" for="verifikator">Verifikator</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input @error('akses') is-invalid @enderror" type="radio" name="akses" id="admin" value="admin" {{ old('akses') === 'admin' ? 'checked' : '' }}>
						<label class="form-check-label" for="admin">Admin</label>
					</div>
					<span class="text-danger">{{ $errors->first('akses') }}</span>
				</div>
				<button type="submit" class="btn btn-primary mb-2" id="createAlert">SIMPAN</button>
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