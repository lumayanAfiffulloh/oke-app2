@extends('layouts.app_modern', ['title'=>'Buat Rencana Pembelajaran'])
@section('content')
<div class="card bg-white">
	<div class="card-body p-0">
		<div class="card-header p-3 fs-5 fw-bolder " style="background-color: #ececec;">
			<span class="me-2">
				<a href="/rencana_pembelajaran" class="ti ti-arrow-left fw-bolder ms-2"></a>
			</span>
			<span class="text-dark text-opacity-50">
				<a href="/rencana_pembelajaran">Rencana Pembelajaran / </a>
			</span>
			Buat Rencana Pembelajaran
		</div>
		<form action="/rencana_pembelajaran" method="POST" class="px-4 py-2">
			@csrf
			{{-- TAHUN --}}
			<div class="form-group mt-1 mb-3">
				<label for="tahun" class="fw-semibold">Tahun</label>
				<div class="col-md-2">
					<input type="number" max="2099" step="1" value="{{ old('tahun', 2024) }}"
						class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun">
				</div>
				<span class="text-danger">{{ $errors->first('tahun') }}</span>
			</div>

			{{-- KLASIFIKASI --}}
			<div class="form-group mt-1 mb-3">
				<label for="klasifikasi" class="fw-semibold">Klasifikasi</label><br>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="klasifikasi" id="pendidikan" value="pendidikan" {{
						old('klasifikasi')==='pendidikan' ? 'checked' : '' }} onclick="updateCategoryOptions()">
					<label class="form-check-label" for="pendidikan">Pendidikan</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="klasifikasi" id="pelatihan" value="pelatihan" {{
						old('klasifikasi')==='pelatihan' ? 'checked' : '' }} onclick="updateCategoryOptions()">
					<label class="form-check-label" for="pelatihan">Pelatihan</label>
				</div>
				<span class="text-danger">{{ $errors->first('klasifikasi') }}</span>
			</div>

			{{-- KATEGORI --}}
			<div class="form-group mt-1 mb-3">
				<label for="kategori" class="fw-semibold">Kategori</label>
				<div class="col-md-6">
					<select class="form-select" id="kategori" name="kategori">
						<option value="" selected disabled id="pilih">-- Pilih Kategori --</option>
						<option value="pendidikan" {{ old('kategori')==='pendidikan' ? 'selected' : '' }} id="kategori-pendidikan">
							Pendidikan</option>
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
				<label for="bentuk_jalur" class="fw-semibold">Bentuk Jalur</label><br>
				<select name="bentuk_jalur" id="bentuk_jalur"
					class="form-control bentuk-jalur-select @error('bentuk_jalur') is-invalid @enderror" required
					style="width: 50%;">
					<option value=""></option>
					<option value="counselling">Counselling</option>
					<option value="coaching">Coaching</option>
					<option value="e-learning">E-Learning
					</option>
					<option value="pelatihan jarak jauh">Pelatihan Jarak Jauh</option>
					<option value="datasering">Datasering (secondment)
					</option>
					<option value="outbound">Pembelajaran alam terbuka
						(outbound)</option>
				</select>
				@error('bentuk_jalur')
				<span class="invalid-feedback">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>

			{{-- NAMA PELATIHAN --}}
			<div class="form-group mt-1 mb-3">
				<label for="nama_pelatihan" class="fw-semibold">Nama Pelatihan</label>
				<div class="col">
					<input type="text" class="form-control @error('nama_pelatihan') is-invalid @enderror" id="nama_pelatihan"
						name="nama_pelatihan" value="{{ old('nama_pelatihan') }}">
				</div>
				<span class="text-danger">{{ $errors->first('nama_pelatihan') }}</span>
			</div>

			{{-- JAM PELAJARAN --}}
			<div class="form-group mt-1 mb-3">
				<label for="jam_pelajaran" class="fw-semibold">Jam Pelajaran</label>
				<div class="col-md-2">
					<input type="number" min="1" max="50" step="1" value="{{ old('jam_pelajaran', 0) }}"
						class="form-control @error('jam_pelajaran') is-invalid @enderror" id="jam_pelajaran" name="jam_pelajaran">
				</div>
				<span class="text-danger">{{ $errors->first('jam_pelajaran') }}</span>
			</div>


			{{-- REGIONAL --}}
			<div class="form-group mt-1 mb-3">
				<label for="regional" class="fw-semibold">Regional</label><br>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="regional" id="nasional" value="nasional" {{
						old('regional')==='nasional' ? 'checked' : '' }}>
					<label class="form-check-label" for="nasional">Nasional</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="regional" id="internasional" value="internasional" {{
						old('regional')==='internasional' ? 'checked' : '' }}>
					<label class="form-check-label" for="internasional">Internasional</label>
				</div>
				<span class="text-danger">{{ $errors->first('regional') }}</span>
			</div>

			{{-- ANGGARAN --}}
			<div class="form-group mt-1 mb-3 col-md-4">
				<label for="anggaran" class="fw-semibold">Anggaran</label>
				<div class="input-group">
					<span class="input-group-text rounded-start">Rp</span>
					<input type="number" min="0" value="{{ old('anggaran', 0) }}" step="1000"
						class="form-control @error('anggaran') is-invalid @enderror" id="anggaran" name="anggaran">
				</div>
				<span class="text-danger">{{ $errors->first('anggaran') }}</span>
			</div>

			{{-- PRIORITAS --}}
			<div class="form-group mt-1 mb-3">
				<label for="prioritas" class="fw-semibold">Prioritas</label><br>
				<div class="btn-group" role="group" aria-label="Default button group">
					<input class="btn-check" type="radio" name="prioritas" id="rendah" value="rendah" {{
						old('prioritas')==='rendah' ? 'checked' : '' }} autocomplete="off">
					<label class="btn btn-outline-success" for="rendah">Rendah</label>

					<input class="btn-check" type="radio" name="prioritas" id="sedang" value="sedang" {{
						old('prioritas')==='sedang' ? 'checked' : '' }} autocomplete="off">
					<label class="btn btn-outline-warning" for="sedang">Sedang</label>

					<input class="btn-check" type="radio" name="prioritas" id="tinggi" value="tinggi" {{
						old('prioritas')==='tinggi' ? 'checked' : '' }} autocomplete="off">
					<label class="btn btn-outline-danger" for="tinggi">Tinggi</label>
				</div>
				<span class="text-danger">{{ $errors->first('prioritas') }}</span>
			</div>

			<button type="submit" class="btn btn-primary mb-2">SIMPAN</button>
		</form>
	</div>
</div>
@endsection

{{-- SCRIPT UNTUK MEMUNCULKAN KLASIFIKASI --}}
<script>
	function updateCategoryOptions() {
		// Disable all category options by default
		document.getElementById('kategori-pendidikan').style.display = 'none';
		document.getElementById('kategori-klasikal').style.display = 'none';
		document.getElementById('kategori-non-klasikal').style.display = 'none';
		
		// Get the selected classification
		const selectedKlasifikasi = document.querySelector('input[name="klasifikasi"]:checked').value;

		// Enable the appropriate category options
		if (selectedKlasifikasi === 'pendidikan') {
			document.getElementById('kategori-pendidikan').style.display = 'block';
			document.getElementById('pilih').selected = true;
		} else if (selectedKlasifikasi === 'pelatihan') {
			document.getElementById('kategori-klasikal').style.display = 'block';
			document.getElementById('kategori-non-klasikal').style.display = 'block';
			document.getElementById('pilih').selected = true;
		}
	}

	// Run the function on page load to handle old input
	window.onload = updateCategoryOptions;
</script>