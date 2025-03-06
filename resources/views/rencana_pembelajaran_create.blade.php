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
		<form action="/rencana_pembelajaran" method="POST" class="px-4 py-2" id="createRencanaFormID">
			@csrf

			{{-- TAHUN --}}
			<div class="form-group mt-1 mb-3">
				<label for="tahun" class="fw-semibold">Tahun</label>
				<div class="col-md-3">
					<input type="number" max="2099" step="1" value="{{ old('tahun', 2024) }}"
						class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" required>
				</div>
				<span class="text-danger">{{ $errors->first('tahun') }}</span>
			</div>

			{{-- KLASIFIKASI --}}
			<div class="form-group mt-1 mb-3">
				<label for="klasifikasi" class="fw-semibold">Klasifikasi</label><br>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="klasifikasi" id="pendidikan" value="pendidikan" {{
						old('klasifikasi')==='pendidikan' ? 'checked' : '' }} required>
					<label class="form-check-label" for="pendidikan">Pendidikan</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="klasifikasi" id="pelatihan" value="pelatihan" {{
						old('klasifikasi')==='pelatihan' ? 'checked' : '' }} required>
					<label class="form-check-label" for="pelatihan">Pelatihan</label>
				</div>
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
						<select class="form-select kategori-single" id="kategori" name="kategori" onchange="updateCategoryOptions()"
							disabled required>
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
					<div class="form-group mb-3 d-none">
						<select name="bentuk_jalur" id="bentuk_jalur" class="form-control bentuk-jalur-single" disabled
							onchange="updateRumpunOptions(this.value)" required>
							<option value=""></option>
						</select>
						@error('bentuk_jalur')
						<span class=" invalid-feedback">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					{{-- JENJANG --}}
					<div class="form-group mb-3 d-none">
						<select name="jenjang" id="jenjang" class="form-control jenjang-single" disabled onchange="loadJurusan()"
							required>
							<option value=""></option>
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
			<div class="form-group mb-3 d-none">
				<select name="rumpun" id="rumpun" class="form-control rumpun-single" disabled onchange="loadNamaPelatihan()"
					required>
					<option value=""></option>
				</select>
				@error('rumpun')
				<span class="invalid-feedback">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>

			{{-- JURUSAN --}}
			<div class="form-group mb-3 d-none">
				<select name="jurusan" id="jurusan" class="form-control jurusan-single" disabled
					onchange="loadJenisPendidikan()" required>
					<option value=""></option>
				</select>
				@error('jurusan')
				<span class="invalid-feedback">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>

			{{-- NAMA PELATIHAN --}}
			<div class="form-group mt-1 mb-3 d-none">
				<label for="nama_pelatihan" class="fw-semibold">Nama Pelatihan
					<span id="spinner-container-namaPelatihan" class="d-none ms-1">
						<div class="spinner-border spinner-border-sm" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>
					</span>
				</label>
				<div class="col">
					<select name="nama_pelatihan" id="nama_pelatihan" class="form-control nama-pelatihan-single" disabled
						onchange="loadPelatihanInfo()" required>
						<option value=""></option>
					</select>
				</div>
				<span class="text-danger">{{ $errors->first('nama_pelatihan') }}</span>
			</div>

			{{-- INFORMASI PELATIHAN --}}
			<div class="card text-bg-primary bg-opacity-25 d-none" id="pelatihan-info-card">
				<div class="card-body">
					<p class="card-title fw-semibold" id="kode-pelatihan"></p>
					<p class="card-text text-primary-emphasis" id="deskripsi-pelatihan"></p>
				</div>
			</div>

			{{-- JENIS PENDIDIKAN --}}
			<div class="form-group mt-1 mb-3 d-none">
				<label for="jenis_pendidikan" class="fw-semibold">Jenis Pendidikan
					<span id="spinner-container-nj" class="d-none ms-1">
						<div class="spinner-border spinner-border-sm" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>
					</span>
				</label>
				<div class="col">
					<select name="jenis_pendidikan" id="jenis_pendidikan" class="form-control jenis-pendidikan-single" disabled
						required>
						<option value=""></option>
					</select>
				</div>
				<span class="text-danger">{{ $errors->first('jenis_pendidikan') }}</span>
			</div>

			<div class="row">
				<div class="col-md-5">

					{{-- JAM PELAJARAN --}}
					<div class="form-group mt-1 mb-3">
						<label for="jam_pelajaran" class="fw-semibold">Jam Pelajaran</label>
						<input type="number" max="50" step="1" value="{{ old('jam_pelajaran', 0) }}"
							class="form-control @error('jam_pelajaran') is-invalid @enderror" id="jam_pelajaran" name="jam_pelajaran"
							required readonly>
						<span class="text-danger">{{ $errors->first('jam_pelajaran') }}</span>
					</div>

					{{-- REGIONAL --}}
					<div class="form-group mt-1 mb-3">
						<label for="regional" class="fw-semibold">Regional</label><br>
						@foreach ($region as $region)
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="regional" id="{{ $region->id }}"
								value="{{ $region->id }}" {{ old('regional')==$region->id ? 'checked' : '' }} required>
							<label class="form-check-label" for="{{ $region->id }}">
								{{ ucfirst($region->region) }}
							</label>
						</div>
						@endforeach
						<span class="text-danger">{{ $errors->first('regional') }}</span>
					</div>

					{{-- ANGGARAN RENCANA --}}
					<div class="form-group mt-1 mb-3">
						<label for="anggaran_rencana" class="fw-semibold">Anggaran</label>
						<input type="text" value="{{ old('anggaran_rencana') }}"
							class="form-control format-rupiah @error('anggaran_rencana') is-invalid @enderror" id="anggaran_rencana"
							name="anggaran_rencana_display">
						<input type="hidden" id="anggaran_rencana" name="anggaran_rencana">
						<span class="text-danger">{{ $errors->first('anggaran_rencana') }}</span>
					</div>

					{{-- PRIORITAS --}}
					<div class="form-group mt-1 mb-3">
						<label for="prioritas" class="fw-semibold">Prioritas</label><br>
						<div class="btn-group" role="group" aria-label="Default button group">
							<input class="btn-check" type="radio" name="prioritas" id="rendah" value="rendah" {{
								old('prioritas')==='rendah' ? 'checked' : '' }} autocomplete="off" required>
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
					<button type="submit" class="btn btn-primary mb-2" id="createRencanaAlert">SIMPAN</button>
				</div>

				{{-- TABEL DETAIL RANGE ANGGARAN --}}
				<div class="col-md-7">
					{{-- TABEL RANGE ANGGARAN PENDIDIKAN--}}
					<div id="anggaran-pendidikan-container" class="d-none">
						<label for="anggaranPendidikanTable" class="fw-semibold mb-2">Range Anggaran
							<span id="selected-jenjang" class="text-primary fw-bolder">
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
							<tbody class="fs-3"></tbody>
						</table>
					</div>

					{{-- TABEL RANGE ANGGARAN PELATIHAN --}}
					<div id="anggaran-pelatihan-container" class="d-none">
						<label for="anggaranPelatihanTable" class="fw-semibold mb-2">Range Anggaran
							<span id="selected-nama-pelatihan" class="text-primary fw-bolder">
							</span>:
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
							<tbody class="fs-3"></tbody>
						</table>
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
    $("#createRencanaAlert").click(function(event) {
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
							title: "Konfirmasi Data",
							text: "Pastikan data yang anda isikan sudah benar!",
							icon: "warning",
							showCancelButton: true,
							confirmButtonText: "Simpan",
							cancelButtonText: "Batal"
						}).then((result) => {
							if (result.isConfirmed){
								$("#createRencanaFormID").submit();
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

{{-- FORMAT HURUF BESAR --}}
<script>
	function ucwords(str) {
  return str.toLowerCase().replace(/\b\w/g, function(txt) {
    return txt.charAt(0).toUpperCase() + txt.substr(1);
		});
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

{{-- MEMUNCULKAN SEMUA SEMUA --}}
<script>
	document.addEventListener('DOMContentLoaded', function () {
  // Fungsi untuk menangani perubahan klasifikasi
		function handleKlasifikasiChange() {
			const klasifikasi = document.querySelector('input[name="klasifikasi"]:checked');
			const kategoriSelect = document.getElementById('kategori');
			const bentukJalurSelect = document.getElementById('bentuk_jalur');
			const rumpunSelect = document.getElementById('rumpun');
			const jurusanSelect = document.getElementById('jurusan');
			const namaPelatihanSelect = document.getElementById('nama_pelatihan');
			const jenisPendidikanSelect = document.getElementById('jenis_pendidikan');
			const jamPelajaran = document.getElementById('jam_pelajaran');
			const bentukJalurGroup = document.querySelector('.bentuk-jalur-single').closest('.form-group');
			const anggaranPendidikanGroup = document.getElementById('anggaran-pendidikan-container');
			const anggaranPelatihanGroup = document.getElementById('anggaran-pelatihan-container');
			const pelatihanInfoGroup = document.getElementById('pelatihan-info-card');
			const jenjangGroup = document.querySelector('.jenjang-single').closest('.form-group');
			const rumpunGroup = document.querySelector('.rumpun-single').closest('.form-group');
			const jurusanGroup = document.querySelector('.jurusan-single').closest('.form-group');
			const jenisPendidikanGroup = document.querySelector('.jenis-pendidikan-single').closest('.form-group');
			const namaPelatihanGroup = document.querySelector('.nama-pelatihan-single').closest('.form-group');

			bentukJalurGroup.classList.remove('d-none');
			rumpunGroup.classList.remove('d-none');

			if (klasifikasi) {
				if (klasifikasi.value === 'pelatihan') {
					// Aktifkan dropdown dan isi opsi kategori
					$('#spinner-container-kategori').removeClass('d-none');
					jurusanSelect.setAttribute('disabled', true);
					jamPelajaran.setAttribute('readonly', true);
					jenisPendidikanSelect.setAttribute('disabled', true);
					namaPelatihanGroup.classList.remove('d-none');
					jenjangGroup.classList.add('d-none');
					anggaranPendidikanGroup.classList.add('d-none');
					jurusanGroup.classList.add('d-none');
					jenisPendidikanGroup.classList.add('d-none');

					kategoriSelect.innerHTML = `
						<option value=""></option>
					`;

					$.ajax({
							type: 'GET',
							url: '/get-kategori-by-klasifikasi',
							dataType: 'json',
							success: function(response) {
									kategoriSelect.removeAttribute('disabled');
									kategoriSelect.innerHTML = '<option value=""></option>';
									$.each(response, function(key, value) {
											kategoriSelect.innerHTML += '<option value="' + value.id + '">' + ucwords(value.kategori) + '</option>';
									});
									$('#spinner-container-kategori').addClass('d-none');
							}
					});

					jurusanSelect.innerHTML = `<option value=""></option>`;
					jenisPendidikanSelect.innerHTML = `<option value=""></option>`;
					
				} else if (klasifikasi.value === 'pendidikan') {
					// Nonaktifkan dropdown dan isi otomatis kategori
					jamPelajaran.removeAttribute('readonly');
					kategoriSelect.setAttribute('disabled', true);
					rumpunSelect.setAttribute('disabled', true);
					namaPelatihanSelect.setAttribute('disabled', true);
					bentukJalurGroup.classList.add('d-none');
					rumpunGroup.classList.add('d-none');
					namaPelatihanGroup.classList.add('d-none');
					anggaranPelatihanGroup.classList.add('d-none');
					pelatihanInfoGroup.classList.add('d-none');
					jenjangGroup.classList.remove('d-none');
					jurusanGroup.classList.remove('d-none');
					jenisPendidikanGroup.classList.remove('d-none');

					kategoriSelect.innerHTML = `
						<option value="0">Pendidikan</option>
					`;

					bentukJalurSelect.innerHTML = `<option value=""></option>`;
					rumpunSelect.innerHTML = `<option value=""></option>`;
					namaPelatihanSelect.innerHTML = `<option value=""></option>`;
				}
			}
		}

		// Tambahkan event listener ke semua radio button klasifikasi
		const klasifikasiRadios = document.querySelectorAll('input[name="klasifikasi"]');
		klasifikasiRadios.forEach(radio => {
			radio.addEventListener('change', handleKlasifikasiChange);
		});

		// Jalankan fungsi saat halaman dimuat
		handleKlasifikasiChange();
});
</script>


{{-- MENAMPILKAN BENTUK JALUR SESUAI KATEGORI --}}
<script>
	function updateCategoryOptions() {
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

<script>
	// MEMUNCULKAN JENJANG
document.addEventListener("DOMContentLoaded", function () {
  const klasifikasiRadios = document.querySelectorAll('input[name="klasifikasi"]');
  const jenjangSelect = document.getElementById('jenjang');

  klasifikasiRadios.forEach((radio) => {
    radio.addEventListener('change', function () {
      const selectedValue = this.value;

      // Reset bentuk jalur form
      jenjangSelect.disabled = true;
      jenjangSelect.innerHTML = '<option value=""></option>';
      $('#spinner-container-bj').removeClass('d-none');

      if (selectedValue === 'pelatihan') {
        jenjangSelect.disabled = true;

        // Logika pelatihan seperti biasa
        updateCategoryOptions();
      } else if (selectedValue === 'pendidikan') {
        jenjangSelect.disabled = false;

        // Ambil data jenjang dari server
        fetch('/get-jenjang')
          .then(response => response.json())
          .then(data => {
            const jenjangOptions = data.jenjang.map(jenjang =>
              `<option value="${jenjang.id}">${jenjang.jenjang}</option>`
            ).join('');
            jenjangSelect.innerHTML += jenjangOptions;

            // Inisialisasi Select2
            $(jenjangSelect).select2({
              theme: 'bootstrap4',
              placeholder: "-- Pilih Jenjang --",
              allowClear: true
            });

            // Hapus spinner setelah selesai
            $('#spinner-container-bj').addClass('d-none');
          })
          .catch(error => {
            console.error('Error fetching jenjang:', error);
            alert('Gagal memuat data jenjang.');
            // Hapus spinner setelah selesai
            $('#spinner-container-bj').addClass('d-none');
          });
      }
    });
  });
});
</script>

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


<script>
	// MENAMPILKAN RUMPUN
	function updateRumpunOptions(bentukJalurId) {
		var bentukJalurId = $('#bentuk_jalur').val();

		if (!bentukJalurId) {
			$('#rumpun').prop('disabled', true); // Disable jurusan if no jenjang is selected
			return;
		}

		// Tampilkan spinner
		$('#spinner-container-rj').removeClass('d-none');

		// Lakukan request AJAX untuk mendapatkan rumpun
		$.ajax({
			url: '/get-rumpun',
			type: 'GET',
			success: function(data) {
				// Sembunyikan spinner
				$('#spinner-container-rj').addClass('d-none');
				$('#rumpun').empty(); // Clear previous options
				$('#rumpun').prop('disabled', false);

				// Tambahkan opsi default "-- Pilih Rumpun --"
				$('#rumpun').append('<option value="">-- Pilih Rumpun --</option>');

				if (data.length > 0) {
					// Isi dropdown dengan data baru
					data.forEach(function(rumpun) {
						$('#rumpun').append('<option value="' + rumpun.id + '">' + rumpun.rumpun + '</option>');
					});
				} else {
					$('#rumpun').append('<option value="">Tidak ada rumpun</option>');
				}
			},
			error: function(xhr, status, error) {
				alert("Terjadi kesalahan dalam memuat rumpun: " + error);
				$('#spinner-container-rj').addClass('d-none');
			}
		});
	}
</script>

<script>
	// MEMUNCULKAN NAMA PELATIHAN
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
	// MEMUNCULKAN JENIS PENDIDIKAN
function loadJenisPendidikan() {
  // Tampilkan spinner
  $('#spinner-container-nj').removeClass('d-none');

  $.ajax({
    type: 'GET',
    url: '/get-jenis-pendidikan/',
    success: function(data) {
      // Sembunyikan spinner
      $('#spinner-container-nj').addClass('d-none');

      $('#jenis_pendidikan').empty(); // Clear previous options
      $('#jenis_pendidikan').prop('disabled', false);

      // Tambahkan opsi default "-- Pilih Nama Pelatihan --"
      $('#jenis_pendidikan').append('<option value=""></option>');

      // Isi dropdown dengan data baru
      $.each(data, function(key, value) {
        $('#jenis_pendidikan').append('<option value="' + value.id + '" >' +
          ucwords(value.jenis_pendidikan) + ' (' + ucwords(value.keterangan) + ')</option>');
      });

      // Inisialisasi ulang Select2
      $('#jenis_pendidikan').select2({
        theme: 'bootstrap4',
        placeholder: "-- Pilih Jenis Pendidikan --",
        allowClear: true
      });
    },
    error: function(xhr, status, error) {
      alert("Terjadi kesalahan dalam memuat jenis pendidikan: " + error);
      $('#spinner-container-nj').addClass('d-none');
    }
  });
}
</script>


{{-- MENAMPILKAN INFO PELATIHAN --}}
<script>
	// Fungsi untuk memuat informasi pelatihan
	function loadPelatihanInfo() {
		const pelatihanId = document.getElementById('nama_pelatihan').value;

		if (pelatihanId) {
			// Kirim AJAX ke server untuk mendapatkan informasi pelatihan
			$.ajax({
				url: '/get-pelatihan-info/' + pelatihanId,
				method: 'GET',
				success: function(data) {
					$('#kode-pelatihan').text('Kode: ' + data.kode);
					$('#selected-nama-pelatihan').text(data.nama_pelatihan);
					$('#deskripsi-pelatihan').text(data.deskripsi || 'Tidak ada deskripsi tersedia.');
					$('#pelatihan-info-card').removeClass('d-none');

					// MENAMBAHKAN LOGIKA UNTUK MENGISI JAM PELAJARAN SECARA OTOMATIS
					if (data.jp) {
						$('#jam_pelajaran').val(data.jp); // Isi otomatis dengan jp
						console.log("Jam Pelajaran diisi dengan:", data.jp);
					} else {
						$('#jam_pelajaran').val(""); // Kosongkan jika tidak ada jp
						console.log("Data pelatihan tidak memiliki jp.");
					}
				},
				error: function(xhr, status, error) {
					console.error('Error:', error);
					alert('Gagal memuat informasi pelatihan. Silakan coba lagi.');
				}
			});

			// Data anggaran pelatihan
			$.ajax({
				url: '/get-anggaran-by-pelatihan',
				type: 'GET',
				data: { pelatihan_id: pelatihanId },
				beforeSend: function() {
					$('#spinner-container-apl').removeClass('d-none');
				},
				success: function(data) {
					$('#spinner-container-apl').addClass('d-none');
					$('#anggaranPelatihanTable tbody').empty();

					if (data.length > 0) {
						$('#anggaran-pelatihan-container').removeClass('d-none');
						const groupedData = groupByRegion(data);

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
				error: function() {
					$('#spinner-container-apl').addClass('d-none');
					alert('Gagal memuat data anggaran');
				}
			});
		} else {
			$('#pelatihan-info-card').addClass('d-none');
			$('#anggaran-pelatihan-container').addClass('d-none');
			$('#jam_pelajaran').val(""); // Kosongkan jika tidak ada pelatihan
		}
	}

	// Fungsi untuk mengelompokkan data berdasarkan region
	function groupByRegion(data) {
		return data.reduce(function(result, item) {
			const regionName = item.region.region; // Ambil nama region dari relasi
			(result[regionName] = result[regionName] || []).push(item);
			return result;
		}, {});
	}

	// Fungsi untuk memformat angka menjadi format Rupiah
	function formatRupiahPelatihan(angka) {
		return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	}
</script>