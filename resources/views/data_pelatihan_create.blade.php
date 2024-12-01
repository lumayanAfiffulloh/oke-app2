@extends('layouts.app_modern', ['title'=>'Tambah Data Pelatihan'])
@section('content')
<div class="card bg-white">
	<div class="card-body p-0">
		<div class="card-header p-3 fs-5 fw-bolder " style="background-color: #ececec;">
			<span class="me-2">
				<a href="/data_pelatihan" class="ti ti-arrow-left fw-bolder ms-2"></a>
			</span>
			Tambah Data Pelatihan
		</div>
		<form action="/data_pelatihan" method="POST" class="px-4 py-2">
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
				<div class="col-md-6">
					<select class="form-select bentukjalur-placeholder-single" id="bentuk_jalur" name="bentuk_jalur">
						<option value="" selected disabled>-- Pilih Bentuk Jalur --</option>
					</select>
					<span class="text-danger">{{ $errors->first('bentuk_jalur') }}</span>
				</div>
			</div>

			{{-- NAMA PELATIHAN --}}
			<div class="form-group mt-1 mb-3">
				<label for="nama_pelatihan" class="fw-bolder">Nama Pelatihan</label>
				<div class="col">
					<input type="text" class="form-control @error('nama_pelatihan') is-invalid @enderror" id="nama_pelatihan"
						name="nama_pelatihan" value="{{ old('nama_pelatihan') }}">
				</div>
				<span class="text-danger">{{ $errors->first('nama_pelatihan') }}</span>
			</div>

			{{-- Minimum Anggaran --}}
			<div class="form-group mt-1 mb-3">
				<label for="min_anggaran" class="fw-bolder">Minimum Anggaran</label>
				<div class="col-md-2">
					<input type="number" value="{{ old('min_anggaran', 0) }}"
						class="form-control @error('min_anggaran') is-invalid @enderror" id="min_anggaran" name="min_anggaran">
				</div>
				<span class="text-danger">{{ $errors->first('min_anggaran') }}</span>
			</div>

			{{-- Maksimum Anggaran --}}
			<div class="form-group mt-1 mb-3">
				<label for="min_anggaran" class="fw-bolder">Maksimum Anggaran</label>
				<div class="col-md-2">
					<input type="number" value="{{ old('min_anggaran', 0) }}"
						class="form-control @error('min_anggaran') is-invalid @enderror" id="min_anggaran" name="min_anggaran">
				</div>
				<span class="text-danger">{{ $errors->first('min_anggaran') }}</span>
			</div>

			<button type="submit" class="btn btn-primary mb-2">SIMPAN</button>
		</form>
	</div>
</div>
{{-- <script>
	document.getElementById('kategori').addEventListener('change', function () {
		var kategori = this.value;

		// Kosongkan opsi bentuk jalur
		var bentukJalurSelect = document.getElementById('bentuk_jalur');
		bentukJalurSelect.innerHTML = '<option value="" selected disabled>-- Pilih Bentuk Jalur --</option>';

		if (kategori) {
			// Lakukan AJAX untuk mengambil bentuk jalur berdasarkan kategori
			fetch(`/bentuk_jalur/filter/${kategori}`)
			.then(response => response.json())
			.then(data => {
				data.forEach(jalur => {
					var option = document.createElement('option');
					option.value = jalur.id;
					option.text = jalur.bentuk_jalur;
					bentukJalurSelect.appendChild(option);
				});
			})
			.catch(error => console.error('Error:', error));
		}
	});
</script> --}}
@endsection