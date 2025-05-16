@extends('layouts.main_layout', ['title' => $rencana->status_pengajuan == 'draft' ? 'Edit Rencana Pembelajaran' :
'Revisi
Rencana Pembelajaran'])
@section('content')
<div class="card mb-3 bg-white">
	<div class="card-body p-0 ">
		<div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">
			<span class="me-2">
				<a href="/rencana_pembelajaran"
					class="ti ti-arrow-left fw-bolder ms-2 text-dark text-opacity-50 link-custom"></a>
			</span>
			<a href="/rencana_pembelajaran" class="text-dark text-opacity-50 link-custom">Rencana Pembelajaran / </a>
			{{ $rencana->status_pengajuan == 'draft' ? 'Edit' : 'Revisi' }} Rencana Pembelajaran <span
				class="fw-bolder text-primary">{{ ucwords($rencana->klasifikasi) }}</span>
		</div>
		<form action="/rencana_pembelajaran/{{ $rencana->id }}" method="POST" class="px-4 py-2" id="editRencanaFormID">
			@csrf
			@method('PUT')
			{{-- TAHUN --}}
			<div class="form-group mt-1 mb-3">
				<label for="tahun" class="fw-semibold">Tahun</label>
				<div class="col-md-3">
					<input type="number" max="2099" step="1" value="{{ old('tahun', $rencana->tahun) }}"
						class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" required>
				</div>
				<span class="text-danger">{{ $errors->first('tahun') }}</span>
			</div>

			{{-- KLASIFIKASI --}}
			<div class="form-group mt-1 mb-3">
				<label for="klasifikasi" class="fw-semibold">Klasifikasi</label><br>
				@if($rencana->klasifikasi == 'pendidikan')
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="klasifikasi" id="pendidikan" value="pendidikan" {{
						old('klasifikasi', $rencana->klasifikasi) === 'pendidikan' ? 'checked' : '' }} required>
					<label class="form-check-label" for="pendidikan">Pendidikan</label>
				</div>
				@elseif($rencana->klasifikasi == 'pelatihan')
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="klasifikasi" id="pelatihan" value="pelatihan" {{
						old('klasifikasi', $rencana->klasifikasi) === 'pelatihan' ? 'checked' : '' }} required>
					<label class="form-check-label" for="pelatihan">Pelatihan</label>
				</div>
				@endif
				<span class="text-danger">{{ $errors->first('klasifikasi') }}</span>
			</div>

			<div class="row">
				<div class="col-md-6">
					{{-- KATEGORI --}}
					<div class="form-group mb-3">
						<label for="kategori" class="fw-semibold">Kategori
							<span id="spinner-container-kategori" class="d-none ms-1">
								<div class="spinner-border spinner-border-sm" role="status">
									<span class="visually-hidden">Loading...</span>
								</div>
							</span>
						</label>
						<select class="form-select kategori-single" id="kategori" name="kategori" @if($rencana->klasifikasi ==
							'pendidikan') disabled @endif onchange="updateBentukJalur()">
							<option value=""></option>
							@if($rencana->klasifikasi =='pendidikan')
							<option value="0" selected>Pendidikan</option>
							@endif
							@foreach ($kategori as $item)
							<option value="{{ $item->id }}" @if ($rencana->bentukJalur->kategori_id == $item->id) selected @endif>{{
								ucwords($item->kategori) }}</option>
							@endforeach
						</select>
						<span class="text-danger">{{ $errors->first('kategori') }}</span>
					</div>
				</div>

				<div class="col-md-6">
					<label for="bentuk_jalur" class="fw-semibold">Bentuk Jalur/Jenjang
						<span id="spinner-container-bj" class="d-none ms-1">
							<div class="spinner-border spinner-border-sm" role="status">
								<span class="visually-hidden">Loading...</span>
							</div>
						</span>
					</label><br>

					{{-- BENTUK JALUR --}}
					<div class="form-group mb-3 @if($rencana->klasifikasi == 'pendidikan') d-none @endif">
						<select name="bentuk_jalur" id="bentuk_jalur" class="form-select bentuk-jalur-single"
							@if($rencana->klasifikasi == 'pendidikan') disabled @endif>
							<option value=""></option>
							@foreach ($bentukJalur as $item)
							<option value="{{ $item->id }}" @if($rencana->bentuk_jalur_id == $item->id) selected @endif>{{
								$item->bentuk_jalur }}</option>
							@endforeach
						</select>
						<span class="text-danger">{{ $errors->first('bentuk_jalur') }}</span>
					</div>

					{{-- JENJANG --}}
					<div class="form-group mb-3 @if($rencana->klasifikasi == 'pelatihan') d-none @endif">
						<select name="jenjang" id="jenjang" class="form-control jenjang-single" onchange="loadJurusan()" required
							@if($rencana->klasifikasi == 'pelatihan') disabled @endif>
							<option value=""></option>
							@foreach ($jenjang as $item)
							<option value="{{ $item->id }}" @if ($jenjangTerpilih==$item->id) selected @endif>
								{{ $item->jenjang }}
							</option>
							@endforeach
						</select>
						@error('jenjang')
						<span class="invalid-feedback">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
				</div>
			</div>

			<label for="rumpun" class="fw-semibold">Rumpun/Jurusan
				<span id="spinner-container-rj" class="d-none ms-1">
					<div class="spinner-border spinner-border-sm" role="status">
						<span class="visually-hidden">Loading...</span>
					</div>
				</span>
			</label><br>

			{{-- RUMPUN --}}
			<div class="form-group mb-3 @if($rencana->klasifikasi == 'pendidikan') d-none @endif">
				<select name="rumpun" id="rumpun" class="form-control rumpun-single" required onchange="loadNamaPelatihan()"
					@if($rencana->klasifikasi == 'pendidikan') disabled @endif>
					<option value=""></option>
					@foreach ($rumpun as $item)
					<option value="{{ $item->id }}" @if($rumpunTerpilih==$item->id) selected @endif>
						{{ $item->rumpun }}
					</option>
					@endforeach
				</select>
				@error('rumpun')
				<span class="invalid-feedback">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>

			{{-- JURUSAN --}}
			<div class="form-group mb-3 @if($rencana->klasifikasi == 'pelatihan') d-none @endif">
				<select name="jurusan" id="jurusan" class="form-control jurusan-single" @if($rencana->klasifikasi ==
					'pelatihan') disabled @endif required>
					<option value=""></option>
					@foreach ($jurusan as $item)
					<option value="{{ $item->id }}" @if ($jurusanTerpilih==$item->id) selected @endif>
						{{ $item->jurusan }}
					</option>
					@endforeach
				</select>
				@error('jurusan')
				<span class="invalid-feedback">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>

			{{-- NAMA PELATIHAN --}}
			<div class="form-group mt-1 mb-3 @if($rencana->klasifikasi == 'pendidikan') d-none @endif">
				<label for="nama_pelatihan" class="fw-semibold">Nama Pelatihan
					<span id="spinner-container-namaPelatihan" class="d-none ms-1">
						<div class="spinner-border spinner-border-sm" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>
					</span>
				</label>
				<select name="nama_pelatihan" id="nama_pelatihan" class="form-control nama-pelatihan-single" required
					@if($rencana->klasifikasi == 'pendidikan') disabled @endif onchange="loadPelatihanInfo()">
					<option value=""></option>
					@foreach ($pelatihan as $item)
					<option value="{{ $item->id }}" @if ($pelatihanTerpilih && $pelatihanTerpilih->id == $item->id) selected
						@endif>
						{{ $item->nama_pelatihan }}
					</option>
					@endforeach
				</select>
				@error('nama_pelatihan')
				<span class="invalid-feedback">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>

			{{-- INFORMASI PELATIHAN --}}
			@if ($pelatihanTerpilih)
			<div class="card text-bg-primary bg-opacity-25" id="pelatihan-info-card">
				<div class="card-body">
					<p class="card-title fw-semibold" id="kode-pelatihan">Kode: {{ $pelatihanTerpilih->kode }}</p>
					<p class="card-text text-primary-emphasis" id="deskripsi-pelatihan">{{ $pelatihanTerpilih->deskripsi ?? 'Tidak
						ada deskripsi tersedia.' }}</p>
				</div>
			</div>
			@endif

			{{-- JENIS PENDIDIKAN --}}
			<div class="form-group mt-1 mb-3 @if($rencana->klasifikasi == 'pelatihan') d-none @endif">
				<label for="jenis_pendidikan" class="fw-semibold">Jenis Pendidikan
					<span id="spinner-container-nj" class="d-none ms-1">
						<div class="spinner-border spinner-border-sm" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>
					</span>
				</label>
				<div class="col">
					<select name="jenis_pendidikan" id="jenis_pendidikan" class="form-control jenis-pendidikan-single" required
						@if($rencana->klasifikasi == 'pelatihan') disabled @endif>
						<option value=""></option>
						@foreach ($jenisPendidikan as $item)
						<option value="{{ $item->id }}" @if ($jenisPendidikanTerpilih==$item->id) selected @endif>
							{{ $item->jenis_pendidikan }}
						</option>
						@endforeach
					</select>
				</div>
				<span class="text-danger">{{ $errors->first('jenis_pendidikan') }}</span>
			</div>

			<div class="row">
				<div class="col-md-5">

					{{-- JAM PELAJARAN --}}
					<div class="form-group mt-1 mb-3">
						<label for="jam_pelajaran" class="fw-semibold">Jam Pelajaran</label>
						<input type="number" max="50" step="1" value="{{ old('jam_pelajaran', $rencana->jam_pelajaran ?? 0) }}"
							class="form-control @error('jam_pelajaran') is-invalid @enderror" id="jam_pelajaran" name="jam_pelajaran"
							required @if($rencana->klasifikasi == 'pelatihan') readonly @endif>
						<span class="text-danger">{{ $errors->first('jam_pelajaran') }}</span>
					</div>

					{{-- REGIONAL --}}
					<div class="form-group mt-1 mb-3">
						<label for="regional" class="fw-semibold">Regional</label><br>
						@foreach ($region as $reg)
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="regional" id="regional_{{ $reg->id }}"
								value="{{ $reg->id }}" {{ old('regional', $rencana->region_id ?? '') == $reg->id ? 'checked' : '' }}
							required>
							<label class="form-check-label" for="regional_{{ $reg->id }}">
								{{ ucfirst($reg->region) }}
							</label>
						</div>
						@endforeach
						<span class="text-danger">{{ $errors->first('regional') }}</span>
					</div>


					{{-- ANGGARAN RENCANA --}}
					<div class="form-group mt-1 mb-3">
						<label for="anggaran_rencana" class="fw-semibold">Anggaran</label>
						<input type="text"
							value="Rp {{ old('anggaran_rencana', number_format($rencana->anggaran_rencana, 0, ',', '.')) }}"
							class="form-control format-rupiah @error('anggaran_rencana') is-invalid @enderror"
							id="anggaran_rencana_display" name="anggaran_rencana_display">
						<input type="hidden" id="anggaran_rencana" name="anggaran_rencana"
							value="{{ old('anggaran_rencana', $rencana->anggaran_rencana) }}">
						<span class="text-danger">{{ $errors->first('anggaran_rencana') }}</span>
					</div>


					{{-- PRIORITAS --}}
					<div class="form-group mt-1 mb-3">
						<label for="prioritas" class="fw-semibold">Prioritas</label><br>
						<div class="btn-group" role="group" aria-label="Default button group">
							<input class="btn-check" type="radio" name="prioritas" id="rendah" value="rendah" {{ old('prioritas',
								$rencana->prioritas ?? '') === 'rendah' ? 'checked' : '' }} autocomplete="off" required>
							<label class="btn btn-outline-success" for="rendah">Rendah</label>

							<input class="btn-check" type="radio" name="prioritas" id="sedang" value="sedang" {{ old('prioritas',
								$rencana->prioritas ?? '') === 'sedang' ? 'checked' : '' }} autocomplete="off">
							<label class="btn btn-outline-warning" for="sedang">Sedang</label>

							<input class="btn-check" type="radio" name="prioritas" id="tinggi" value="tinggi" {{ old('prioritas',
								$rencana->prioritas ?? '') === 'tinggi' ? 'checked' : '' }} autocomplete="off">
							<label class="btn btn-outline-danger" for="tinggi">Tinggi</label>
						</div>
						<span class="text-danger">{{ $errors->first('prioritas') }}</span>
					</div>


					{{-- TOMBOL SUBMIT --}}
					<button type="submit" class="btn btn-primary mb-2" id="editRencanaAlert">{{ $rencana->status_pengajuan ==
						'draft' ? 'SIMPAN' : 'SIMPAN REVISI' }}</button>
				</div>

				{{-- TABEL DETAIL RANGE ANGGARAN --}}
				<div class="col-md-7">
					{{-- TABEL RANGE ANGGARAN PENDIDIKAN --}}
					<div id="anggaran-pendidikan-container" class="@if($rencana->klasifikasi == 'pelatihan') d-none @endif">
						<label for="anggaranPendidikanTable" class="fw-semibold mb-2">Range Anggaran
							<span id="selected-jenjang" class="text-primary fw-bolder">
								{{ $rencana->jenjang->jenjang ?? 'Jenjang Tidak Diketahui' }}
							</span>:
							<span id="spinner-container-ap" class="d-none ms-1">
								<div class="spinner-border spinner-border-sm" role="status">
									<span class="visually-hidden">Loading...</span>
								</div>
							</span>
						</label>
						<table id="anggaranPendidikanTable" class="table table-bordered">
							<thead class="fs-3">
								<tr>
									<th>Region</th>
									<th>Anggaran Min</th>
									<th>Anggaran Maks</th>
								</tr>
							</thead>
							<tbody class="fs-3">
								@foreach ($anggaranPendidikan as $item)
								<tr>
									<td>{{ ucwords($item->region->region ?? 'Region Tidak Diketahui') }}</td>
									<td>{{ formatRupiah($item->anggaran_min) }}</td>
									<td>{{ formatRupiah($item->anggaran_maks) }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>


					{{-- TABEL RANGE ANGGARAN PELATIHAN --}}
					<div id="anggaran-pelatihan-container" class="@if($rencana->klasifikasi == 'pendidikan') d-none @endif">
						@if ($anggaranGrouped->isNotEmpty())
						<label for="anggaranPelatihanTable" class="fw-semibold mb-2">Range Anggaran
							<span id="selected-nama-pelatihan" class="text-primary fw-bolder">{{ $pelatihanTerpilih->nama_pelatihan
								}}</span>:
							<span id="spinner-container-apl" class="d-none ms-1">
								<div class="spinner-border spinner-border-sm" role="status">
									<span class="visually-hidden">Loading...</span>
								</div>
							</span>
						</label>
						<table id="anggaranPelatihanTable" class="table table-bordered">
							<thead class="fs-3">
								<tr>
									<th>Region</th>
									<th>Kategori</th>
									<th>Anggaran Min</th>
									<th>Anggaran Maks</th>
								</tr>
							</thead>
							<tbody class="fs-3">
								@foreach ($anggaranGrouped as $regionName => $anggaranItems)
								<tr>
									<td rowspan="{{ $anggaranItems->count() }}">{{ ucwords($regionName) }}</td>
									<td>{{ ucwords($anggaranItems->first()->kategori->kategori) }}</td>
									<td>{{ formatRupiah($anggaranItems->first()->anggaran_min) }}</td>
									<td>{{ formatRupiah($anggaranItems->first()->anggaran_maks) }}</td>
								</tr>
								@foreach ($anggaranItems->skip(1) as $item)
								<tr>
									<td>{{ ucwords($item->kategori->kategori) }}</td>
									<td>{{ formatRupiah($item->anggaran_min) }}</td>
									<td>{{ formatRupiah($item->anggaran_maks) }}</td>
								</tr>
								@endforeach
								@endforeach
							</tbody>
						</table>
						@else
						<p>Data anggaran tidak tersedia.</p>
						@endif
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection

{{-- SWEET ALERT UNTUK VALIDASI --}}
@push('alert-rencana')
<script>
	$(document).ready(function() {
    $("#editRencanaAlert").click(function(event) {
      event.preventDefault();

      let klasifikasi = $("input[name='klasifikasi']:checked").val();
      let kategori = $("#kategori").val();
      let regional = $("input[name='regional']:checked").val();
      let bentuk_jalur = $("#bentuk_jalur").val();
      let jenjang = $("#jenjang").val();
      let nama_pelatihan = $("#nama_pelatihan").val();
      let anggaran_rencana = $("#anggaran_rencana").val().replace(/\D/g, '');
      let tahun = $("#tahun").val();
      let jam_pelajaran = $("#jam_pelajaran").val();
      let prioritas = $("input[name='prioritas']:checked").val();
      let jurusan = $("#jurusan").val();
      let jenis_pendidikan = $("#jenis_pendidikan").val();
      let rumpun = $("#rumpun").val();

			if (
				!klasifikasi ||
				(!kategori && klasifikasi === "pelatihan") ||
				!regional ||
				(!bentuk_jalur && klasifikasi === "pelatihan") ||
				(!jenjang && klasifikasi === "pendidikan") ||
				(!nama_pelatihan && klasifikasi === "pelatihan") ||
				!anggaran_rencana ||
				!tahun ||
				!jam_pelajaran ||
				!prioritas ||
				(!jurusan && klasifikasi === "pendidikan") ||
				(!jenis_pendidikan && klasifikasi === "pendidikan") ||
				(!rumpun && klasifikasi === "pelatihan")
			) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Semua kolom form wajib diisi!',
					allowOutsideClick: true,
				});
				return;
			}

      $.ajax({
        url: "/validasi-anggaran",
        type: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          klasifikasi: klasifikasi,
          regional: regional,
          kategori: kategori,
          bentuk_jalur: bentuk_jalur,
          jenjang: jenjang,
          nama_pelatihan: nama_pelatihan,
          anggaran_rencana: anggaran_rencana
        },
        success: function(response) {
					if (response.status === "valid") {
						Swal.fire({
							title: "Konfirmasi Data!",
							text: "Pastikan data yang anda isikan sudah benar!",
							icon: "warning",
							showCancelButton: true,
							confirmButtonText: "Simpan",
							cancelButtonText: "Batal"
						}).then((result) => {
							if (result.isConfirmed){
								$("#editRencanaFormID").submit();
							}
						});
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Validasi Gagal!',
							text: response.message,
						});
					}
				},
        error: function(xhr) {
          Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: 'Terjadi kesalahan dalam validasi.',
          });
        }
      });
    });
  });
</script>
@endpush

<script>
	// Fungsi untuk memuat Jurusan berdasarkan Jenjang
	function loadJurusan() {
		var jenjangId = $('#jenjang').val();
		var jenjangText = $('#jenjang option:selected').text();

		if (!jenjangId) {
			$('#jurusan').prop('disabled', true);
			$('#anggaran-pendidikan-container').addClass('d-none');
			$('#selected-jenjang').text('(jenjang)');
			return;
		}

		$('#spinner-container-rj').removeClass('d-none');
		$('#spinner-container-ap').removeClass('d-none');
		$('#selected-jenjang').text(jenjangText);

		// Memuat data jurusan berdasarkan jenjang
		$.ajax({
			url: '/get-jurusan-by-jenjang',
			type: 'GET',
			data: { jenjang_id: jenjangId },
			success: function (data) {
				$('#spinner-container-rj').addClass('d-none');
				$('#spinner-container-ap').addClass('d-none');
				$('#jurusan').empty();

				$('#jurusan').append('<option value="">-- Pilih Jurusan --</option>');

				if (data.length > 0) {
					$('#jurusan').prop('disabled', false);

					data.forEach(function (jurusan) {
						$('#jurusan').append('<option value="' + jurusan.id + '" >' + jurusan.jurusan + '</option>');
					});

					$('#jurusan').select2({
						theme: 'bootstrap4',
						placeholder: "-- Pilih Jurusan --",
						allowClear: true
					});
				} else {
					$('#jurusan').append('<option value="">Tidak ada jurusan untuk jenjang ini</option>');
				}
			},
			error: function () {
				$('#spinner-container-rj').addClass('d-none');
				$('#spinner-container-ap').addClass('d-none');
				$('#jurusan').append('<option value="">Error loading jurusan</option>');
			}
		});

		// MENAMPILKAN ANGGARAN
		$.ajax({
			url: '/get-anggaran-by-pendidikan',
			type: 'GET',
			data: { jenjang_id: jenjangId },
			success: function (data) {
				const tbody = $('#anggaranPendidikanTable tbody');
				tbody.empty();

				// Pastikan tabel selalu ditampilkan
				$('#anggaran-pendidikan-container').removeClass('d-none');

				if (data.length > 0) {
					data.forEach(function (item) {
						// Sesuaikan dengan data region dari entitas region terpisah
						const region = item.region.region.replace(/\b\w/g, char => char.toUpperCase()); // Ambil nama region dari relasi region
						const anggaranMin = formatRupiahPendidikan(item.anggaran_min);
						const anggaranMaks = formatRupiahPendidikan(item.anggaran_maks);

						$('#anggaranPendidikanTable tbody').append(`
							<tr>
								<td>${region}</td>
								<td>${anggaranMin}</td>
								<td>${anggaranMaks}</td>
							</tr>
						`);
					});
				} else {
					// Jika tidak ada data, tambahkan baris dengan pesan
					$('#anggaranPendidikanTable tbody').append(`
						<tr>
							<td colspan="3" class="text-center">Data anggaran tidak tersedia untuk jenjang ini.</td>
						</tr>
					`);
				}
			},
			error: function () {
				const tbody = $('#anggaranPendidikanTable tbody');
				tbody.empty();
				// Pastikan tabel tetap muncul dengan pesan error
				$('#anggaran-pendidikan-container').removeClass('d-none');
				$('#anggaranPendidikanTable tbody').append(`
					<tr>
						<td colspan="3" class="text-center text-danger">Terjadi kesalahan saat memuat data.</td>
					</tr>
				`);
			}
		});
	}

	// Fungsi untuk memformat angka menjadi rupiah
	function formatRupiahPendidikan(angka) {
		return 'Rp' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
	}
</script>

{{-- FORMAT RUPIAH RIBUAN --}}
<script>
	document.addEventListener('DOMContentLoaded', function () {
        // Seleksi semua input dengan class "format-rupiah"
        const rupiahInputs = document.querySelectorAll('.format-rupiah');

        rupiahInputs.forEach((input) => {
            // Event listener saat input berubah
            input.addEventListener('input', function () {
                formatRupiah(input);
            });
        });
    });

    function formatRupiah(input) {
        // Ambil nilai input dan buang format lama
        let rawValue = input.value.replace(/[^,\d]/g, '');

        // Masukkan ke input hidden terkait
        const hiddenInput = input.nextElementSibling;
        if (hiddenInput && hiddenInput.type === 'hidden') {
            hiddenInput.value = rawValue;
        }

        // Format ulang untuk menampilkan sebagai rupiah
        let formattedValue = '';
        const split = rawValue.split(',');
        const sisa = split[0].length % 3;
        formattedValue += split[0].substr(0, sisa);
        const ribuan = split[0].substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            const separator = sisa ? '.' : '';
            formattedValue += separator + ribuan.join('.');
        }

        input.value = 'Rp ' + formattedValue + (split[1] ? ',' + split[1] : '');
    }
</script>

{{-- MENAMPILKAN BENTUK JALUR SESUAI KATEGORI --}}
<script>
	function updateBentukJalur() {
		var kategoriId = document.getElementById('kategori').value;
		var bentukJalurSelect = document.getElementById('bentuk_jalur');

		// Tampilkan spinner
		$('#spinner-container-bj').removeClass('d-none');

		if (kategoriId) {
			$.ajax({
				url: '/get-bentuk-jalur/' + kategoriId,
				method: 'GET',
				success: function(data) {
					var bentukJalurSelect = $('#bentuk_jalur');
					bentukJalurSelect.empty(); // Kosongkan dropdown
					bentukJalurSelect.prop('disabled', false);
					bentukJalurSelect.append('<option value=""></option>');

					// Isi dropdown dengan data baru
					data.bentuk_jalur.forEach(function(item) {
						bentukJalurSelect.append('<option value="' + item.id + '">' + item.bentuk_jalur + '</option>');
					});

					// Inisialisasi ulang Select2 setelah data dimuat
					bentukJalurSelect.select2({
						theme: 'bootstrap4',
						placeholder: "-- Pilih Bentuk Jalur --",
						allowClear: true
					});

					// Hapus spinner setelah selesai
					$('#spinner-container-bj').addClass('d-none');
				},
				error: function(xhr, status, error) {
					alert("Terjadi kesalahan dalam memuat bentuk jalur: " + error);
					$('#spinner-container-bj').addClass('d-none');
				}
			});
		} else {
			bentukJalurSelect.setAttribute('disabled', true);
			$('#spinner-container-bj').addClass('d-none');
		}
	}
</script>

{{-- MEMUNCULKAN NAMA PELATIHAN --}}
<script>
	function loadNamaPelatihan() {
		var rumpunId = $('#rumpun').val();

		// Tampilkan spinner
		$('#spinner-container-namaPelatihan').removeClass('d-none');

		$.ajax({
			type: 'GET',
			url: '/nama-pelatihan/' + rumpunId,
			success: function(data) {
				// Sembunyikan spinner
				$('#spinner-container-namaPelatihan').addClass('d-none');

				$('#nama_pelatihan').empty(); // Clear previous options
				$('#nama_pelatihan').prop('disabled', false);

				// Tambahkan opsi default "-- Pilih Nama Pelatihan --"
				$('#nama_pelatihan').append('<option value=""></option>');

				// Isi dropdown dengan data baru
				$.each(data, function(key, value) {
					$('#nama_pelatihan').append(
						'<option value= "' + value.id + '" >' + value.nama_pelatihan + '</option>'
					);
				});

				// Inisialisasi ulang Select2
				$('#nama_pelatihan').select2({
					theme: 'bootstrap4',
					placeholder: "-- Pilih Nama Pelatihan --",
					allowClear: true
				});
			},
			error: function(xhr, status, error) {
				alert("Terjadi kesalahan dalam memuat nama pelatihan: " + error);
				$('#spinner-container-namaPelatihan').addClass('d-none');
			}
		});
	}

	$('#rumpun').on('change', loadNamaPelatihan);
</script>

<script>
	function loadPelatihanInfo() {
		const pelatihanId = $('#nama_pelatihan').val();

		if (pelatihanId) {
			// AJAX untuk mendapatkan info pelatihan
			$.ajax({
				url: '/get-pelatihan-info/' + pelatihanId,
				method: 'GET',
				success: function(data) {
					$('#kode-pelatihan').text('Kode: ' + data.kode);
					$('#selected-nama-pelatihan').text(data.nama_pelatihan);
					$('#deskripsi-pelatihan').text(data.deskripsi || 'Tidak ada deskripsi tersedia.');
					$('#pelatihan-info-card').removeClass('d-none');

					// Isi jam pelajaran otomatis
					$('#jam_pelajaran').val(data.jp || '');
				},
				error: function(xhr, status, error) {
					console.error('Error:', error);
					alert('Gagal memuat informasi pelatihan.');
				}
			});

			// AJAX untuk mendapatkan anggaran pelatihan
			$.ajax({
				url: '/get-anggaran-by-pelatihan',
				type: 'GET',
				data: { pelatihan_id: pelatihanId },
				beforeSend: function() {
					$('#spinner-container-apl').removeClass('d-none');
				},
				success: function(data) {
					console.log("Data anggaran diterima:", data); // Debugging

					$('#spinner-container-apl').addClass('d-none');
					$('#anggaranPelatihanTable tbody').empty();

					if (data.length > 0) {
						$('#anggaran-pelatihan-container').removeClass('d-none');

						// Kelompokkan data berdasarkan region
						const groupedData = groupByRegion(data);

						// Tampilkan data berdasarkan region
						Object.keys(groupedData).forEach(function(region) {
							$('#anggaranPelatihanTable tbody').append(`
								<tr>
									<td rowspan="${groupedData[region].length}">${ucwords(region)}</td>
									<td>${ucwords(groupedData[region][0].kategori.kategori)}</td>
									<td>${formatRupiahPelatihan(groupedData[region][0].anggaran_min)}</td>
									<td>${formatRupiahPelatihan(groupedData[region][0].anggaran_maks)}</td>
								</tr>
							`);

							for (let i = 1; i < groupedData[region].length; i++) {
								$('#anggaranPelatihanTable tbody').append(`
									<tr>
										<td>${ucwords(groupedData[region][i].kategori.kategori)}</td>
										<td>${formatRupiahPelatihan(groupedData[region][i].anggaran_min)}</td>
										<td>${formatRupiahPelatihan(groupedData[region][i].anggaran_maks)}</td>
									</tr>
								`);
							}
						});
					} else {
						$('#anggaranPelatihanTable tbody').append(`
							<tr>
								<td colspan="4" class="text-center">Data anggaran tidak tersedia.</td>
							</tr>
						`);
					}
				},
				error: function(xhr, status, error) {
					console.error("Gagal memuat anggaran:", error);
					$('#spinner-container-apl').addClass('d-none');
					alert('Gagal memuat data anggaran');
				}
			});
		} else {
			$('#pelatihan-info-card').addClass('d-none');
			$('#anggaran-pelatihan-container').addClass('d-none');
			$('#jam_pelajaran').val("");
		}
	}

	// Fungsi untuk mengelompokkan data berdasarkan region
	function groupByRegion(data) {
		return data.reduce(function(result, item) {
			const regionName = item.region?.region || 'Tidak Diketahui'; 
			(result[regionName] = result[regionName] || []).push(item);
			return result;
		}, {});
	}

	// Fungsi untuk memformat angka menjadi rupiah
	function formatRupiahPelatihan(angka) {
		if (!angka) return 'Rp 0';
		return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	}

	// Konversi teks ke format huruf kapital di awal kata
	function ucwords(str) {
		return str.replace(/\b\w/g, function(l) {
			return l.toUpperCase();
		});
	}

	// Pastikan event listener untuk select dropdown dijalankan
	$('#nama_pelatihan').on('change', loadPelatihanInfo);
</script>