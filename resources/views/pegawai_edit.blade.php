@extends('layouts.main_layout', ['title'=>'Edit Data Pegawai'])
@section('content')
<div class="card mb-3 bg-white">
	<div class="card-body p-0 ">
		<div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">
			<span class="me-2">
				<a href="/data_pegawai" class="ti ti-arrow-left fw-bolder ms-2"></a>
			</span>
			<span class="text-dark text-opacity-50">
				<a href="/data_pegawai">Data Pegawai / </a>
			</span>
			Edit Data Pegawai
			<span class="fw-bolder text-primary">
				{{ $data_pegawai->nama }}
			</span>
		</div>
		<form action="/data_pegawai/{{ $data_pegawai->id }}" method="POST" enctype="multipart/form-data" class="px-3 py-3"
			id="editFormID">
			@method('PUT')
			@csrf

			{{-- FOTO --}}
			<div class="form-group mt-1 mb-3">
				@if($data_pegawai->foto)
				<a href="{{ Storage::url($data_pegawai->foto) }}" target="blank" id="fotobaru">
					<img src="{{ Storage::url($data_pegawai->foto) }}" class="rounded mx-start d-block "
						style="object-fit: cover; height: 150px; width: 150px;">
				</a>
				@endif
				<label class="fw-semibold" for="foto" class="mt-2">Upload Foto Baru Pegawai</label>
				<input type="file" class="form-control @error('foto') is-invalid @enderror" id="fotoubah" name="foto">
				<span class="text-danger">{{ $errors->first('foto') }}</span>
			</div>

			{{-- NAMA PEGAWAI --}}
			<div class="form-group mt-1 mb-3">
				<label class="fw-semibold" for="nama">Nama Pegawai</label>
				<input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
					value="{{ old('nama') ?? $data_pegawai->nama }}">
				<span class="text-danger">{{ $errors->first('nama') }}</span>
			</div>

			<div class="row">
				<div class="col-md-6">
					{{-- NPPU--}}
					<div class="form-group mt-1 mb-3">
						<label class="fw-semibold" for="nppu">NPPU</label>
						<input type="text" class="form-control @error('nppu') is-invalid @enderror" id="nppu" name="nppu"
							value="{{ old('nppu') ?? $data_pegawai->nppu}}">
						<span class="text-danger">{{ $errors->first('nppu') }}</span>
					</div>
				</div>
				<div class="col-md-6">
					{{-- EMAIL --}}
					<div class="form-group mt-1 mb-3">
						<label class="fw-semibold" for="email">Email</label>
						<input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
							value="{{ old('email', $user->email) }}">
						<span class="text-danger">{{ $errors->first('email') }}</span>
					</div>
				</div>
			</div>

			{{-- STATUS --}}
			<div class="form-group mt-1 mb-3">
				<label class="fw-semibold" for="status">Status</label><br>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="status" id="aktif" value="aktif" {{ old('status',
						$data_pegawai->status) === 'aktif' ? 'checked' : '' }}>
					<label class="form-check-label" for="aktif">Aktif</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="status" id="non-aktif" value="non-aktif" {{ old('status',
						$data_pegawai->status) === 'non-aktif' ? 'checked' : '' }}>
					<label class="form-check-label" for="non-aktif">Non-aktif</label>
				</div>
				<span class="text-danger">{{ $errors->first('status') }}</span>
			</div>

			<div class="row">
				<div class="col-md-6">
					{{-- UNIT KERJA --}}
					<div class="form-group mt-1 mb-3">
						<label class="fw-semibold" for="unit_kerja">Unit Kerja</label>
						<input type="text" class="form-control @error('unit_kerja') is-invalid @enderror" id="unit_kerja"
							name="unit_kerja" value="{{ old('unit_kerja') ?? $data_pegawai->unitKerja->unit_kerja}}">
						<span class="text-danger">{{ $errors->first('unit_kerja') }}</span>
					</div>
				</div>
				<div class="col-md-6">
					{{-- JABATAN --}}
					<div class="form-group mt-1 mb-3">
						<label class="fw-semibold" for="jabatan">Jabatan</label>
						<input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan"
							value="{{ old('jabatan') ?? $data_pegawai->jabatan->jabatan}}">
						<span class="text-danger">{{ $errors->first('jabatan') }}</span>
					</div>
				</div>
			</div>

			{{-- PENDIDIKAN --}}
			<div class="form-group mt-1 mb-3">
				<label class="fw-semibold" for="pendidikan">Pendidikan Terakhir</label><br>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="pendidikan" id="SMA" value="SMA" {{ old('pendidikan') ??
						$pendidikan_terakhir->jenjangTerakhir->jenjang_terakhir === 'SMA' ? 'checked' : '' }}>
					<label class="form-check-label" for="SMA">SMA</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="pendidikan" id="D1" value="D1" {{ old('pendidikan') ??
						$pendidikan_terakhir->jenjangTerakhir->jenjang_terakhir === 'D1' ? 'checked' : '' }}>
					<label class="form-check-label" for="D1">D1</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="pendidikan" id="D2" value="D2" {{ old('pendidikan') ??
						$pendidikan_terakhir->jenjangTerakhir->jenjang_terakhir === 'D2' ? 'checked' : '' }}>
					<label class="form-check-label" for="D2">D2</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="pendidikan" id="D3" value="D3" {{ old('pendidikan') ??
						$pendidikan_terakhir->jenjangTerakhir->jenjang_terakhir === 'D3' ? 'checked' : '' }}>
					<label class="form-check-label" for="D3">D3</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="pendidikan" id="S1" value="S1" {{ old('pendidikan') ??
						$pendidikan_terakhir->jenjangTerakhir->jenjang_terakhir === 'S1' ? 'checked' : '' }}>
					<label class="form-check-label" for="S1">S1/D4</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="pendidikan" id="S2" value="S2" {{ old('pendidikan') ??
						$pendidikan_terakhir->jenjangTerakhir->jenjang_terakhir === 'S2' ? 'checked' : '' }}>
					<label class="form-check-label" for="S2">S2</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="pendidikan" id="S3" value="S3" {{ old('pendidikan') ??
						$pendidikan_terakhir->jenjangTerakhir->jenjang_terakhir === 'S3' ? 'checked' : '' }}>
					<label class="form-check-label" for="S3">S3</label>
				</div>
				<span class="text-danger">{{ $errors->first('pendidikan') }}</span>
			</div>

			{{-- JURUSAN PENDIDIKAN --}}
			<div class="form-group mt-1 mb-3">
				<label class="fw-semibold" for="jurusan_pendidikan">Jurusan</label>
				<input type="text" class="form-control @error('jurusan_pendidikan') is-invalid @enderror"
					id="jurusan_pendidikan" name="jurusan_pendidikan"
					value="{{ old('jurusan_pendidikan') ?? $data_pegawai->pendidikanTerakhir->jurusan }}">
				<span class="text-danger">{{ $errors->first('jurusan_pendidikan') }}</span>
			</div>

			<div class="row">
				<div class="col-md-3">
					{{-- JENIS KELAMIN --}}
					<div class="form-group mt-1 mb-3">
						<label class="fw-semibold" for="jenis_kelamin">Jenis Kelamin</label><br>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="jenis_kelamin" id="L" value="L" {{ old('jenis_kelamin')
								?? $data_pegawai->jenis_kelamin === 'L' ? 'checked' : '' }}>
							<label class="form-check-label" for="L">Laki-laki</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="jenis_kelamin" id="P" value="P" {{ old('jenis_kelamin')
								?? $data_pegawai->jenis_kelamin === 'P' ? 'checked' : '' }}>
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
							name="nomor_telepon" value="{{ old('nomor_telepon') ?? $data_pegawai->nomor_telepon }}">
						<span class="text-danger">{{ $errors->first('nomor_telepon') }}</span>
					</div>
				</div>
			</div>

			{{-- AKSES --}}
			<div class="form-group mt-1 mb-3">
				<label class="fw-semibold" for="roles">Akses<span class="text-danger">*</span></label><br>

				@foreach ($roles as $role)
				<div class="form-check form-check-inline">
					<input class="form-check-input @error('roles') is-invalid @enderror" type="checkbox" name="roles[]"
						id="role_{{ $role->id }}" value="{{ $role->id }}" {{ in_array($role->id, old('roles', $userRoles)) ?
					'checked' : '' }}>
					<label class="form-check-label" for="role_{{ $role->id }}">{{ ucwords(str_replace('_', ' ', $role->role))
						}}</label>
				</div>
				@endforeach
				<br><span class="text-danger">{{ $errors->first('roles') }}</span>
			</div>



			{{-- BUTTON --}}
			<div class="d-flex justify-content-start mt-4 mb-2">
				<form>
					<button type="submit" class="btn btn-primary me-1" id="editAlert">SIMPAN</button>
				</form>
				<a href="/data_pegawai" class="btn btn-warning me-1">BATAL EDIT</a>
				<form action="/data_pegawai/{{ $data_pegawai->id }}" method="POST" class="d-flex" id="deleteFormID">
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
            title: "Konfirmasi Data!",
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