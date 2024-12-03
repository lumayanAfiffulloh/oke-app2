@extends('layouts.app_modern', ['title' => 'Data Pelatihan'])
@section('content')
<div class="card mb-4 pb-4 bg-white">
	<div class="card-body px-0 py-0">
		<div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">Data Pelatihan</div>
		<div class="row my-3">
			<div class="col-6">
				<button class="position-relative ">
					<a href="#" class="btn btn-outline-primary ms-3 " style="font-size: 0.9rem" data-bs-toggle="modal"
						data-bs-target="#createPelatihanModal">
						<span class="me-1">
							<i class="ti ti-clipboard-plus"></i>
						</span>
						<span>Tambah Data Pelatihan</span>
					</a>
				</button>
				{{-- MODAL TAMBAH Data Pelatihan --}}
				<div class="modal fade" data-bs-backdrop="static" tabindex="-1" aria-hidden="true" id="createPelatihanModal">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h1 class="modal-title tw-text-[20px] fw-bold">
									Tambah Data Pelatihan
								</h1>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<form action="/data_pelatihan" method="POST" class="py-2" id="createFormID">
								@csrf
								<div class="modal-body border border-2 mx-3 rounded-2">
									{{-- KATEGORI --}}
									<div class="form-group mt-1 mb-3">
										<label for="kategori" class="fw-bolder">Kategori</label>
										<div class="col">
											<select class="form-select" id="kategori" name="kategori">
												<option value="" selected disabled id="pilih">-- Pilih Kategori --</option>
												<option value="klasikal" {{ old('kategori')==='klasikal' ? 'selected' : '' }}
													id="kategori-klasikal">
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
											<select class="form-control" id="bentuk_jalur" name="bentuk_jalur" style="width: 100%;">
												<option value="" selected disabled>-- Pilih Bentuk Jalur --</option>
											</select>
											<span class=" text-danger">{{ $errors->first('bentuk_jalur') }}</span>
										</div>
									</div>

									{{-- NAMA PELATIHAN --}}
									<div class="form-group mt-1 mb-3">
										<label for="nama_pelatihan" class="fw-bolder">Nama Pelatihan</label>
										<div class="col">
											<input type="text" class="form-control @error('nama_pelatihan') is-invalid @enderror"
												id="nama_pelatihan" name="nama_pelatihan" value="{{ old('nama_pelatihan') }}">
										</div>
										<span class="text-danger">{{ $errors->first('nama_pelatihan') }}</span>
									</div>

									{{-- Minimum Anggaran --}}
									<div class="form-group mt-1 mb-3">
										<label for="min_anggaran" class="fw-bolder">Minimum Anggaran</label>
										<div class="col-md-6">
											<input type="number" value="{{ old('min_anggaran', 0) }}"
												class="form-control @error('min_anggaran') is-invalid @enderror" id="min_anggaran"
												name="min_anggaran">
										</div>
										<span class="text-danger">{{ $errors->first('min_anggaran') }}</span>
									</div>

									{{-- Maksimum Anggaran --}}
									<div class="form-group mt-1 mb-3">
										<label for="maks_anggaran" class="fw-bolder">Maksimum Anggaran</label>
										<div class="col-md-6">
											<input type="number" step="1000" value="{{ old('maks_anggaran', 0) }}"
												class="form-control @error('maks_anggaran') is-invalid @enderror" id="maks_anggaran"
												name="maks_anggaran">
										</div>
										<span class="text-danger">{{ $errors->first('maks_anggaran') }}</span>
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
									<button type="submit" class="btn btn-warning" id="createAlert">Simpan</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<button class="position-relative ">
					<a href="/bentuk_jalur" class="btn btn-outline-warning ms-sm-1" style="font-size: 0.9rem">
						<span class="me-1">
							<i class="ti ti-shape"></i>
						</span>
						<span>Kelola Bentuk Jalur Pelatihan</span>
					</a>
				</button>

			</div>
		</div>
		<hr class="my-0">
		<div class="table-responsive">
			<table class="table table-striped mb-3" style="font-size: 0.8rem" id="myTable">
				<thead>
					<th class="text-center">No.</th>
					<th>Kategori</th>
					<th>Bentuk Jalur</th>
					<th>Nama Pelatihan</th>
					<th>Minimum Anggaran</th>
					<th>Maksimum Anggaran</th>
					<th>AKSI</th>
				</thead>
				<tbody>
					@foreach ($data_pelatihan as $item)
					<tr>
						<td class="text-center py-3"> {{ $loop->iteration }} </td>
						<td class="py-3">{{ ucwords($item->kategori) }}</td>
						<td class="py-3">{{ ucwords($item->bentuk_jalur) }}</td>
						<td class="py-3">{{ ucwords($item->nama_pelatihan) }}</td>
						<td class="py-3">{{ ($item->min_anggaran) }}</td>
						<td class="py-3">{{ ($item->maks_anggaran) }}</td>
						<td class="py-3">
							<div class="btn-group" role="group">
								<button class="btn btn-sm btn-primary" data-bs-toggle="modal"
									data-bs-target="#detailModal{{ $item->id }}" title="Detail" style="font-size: 0.8rem">
									<span class="ti ti-eye"></span>
								</button>
								<!-- Detail Modal -->
								<div class="modal fade" id="detailModal{{ $item->id }}" data-bs-backdrop="static"
									data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel{{ $item->id }}"
									aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h1 class="modal-title tw-text-[20px] fw-bold" id="staticBackdropLabel{{ $item->id }}">
													Detail Pelatihan <span class="text-primary fw-bolder">{{ ucwords($item->nama_pelatihan)
														}}</span>
												</h1>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<div class="modal-body border border-2 mx-3 rounded-2">
												<ol class="list-group">
													<li class="list-group-item">
														<h2 class="fs-5 d-inline">
															<span style="display:inline-block; width:150px;">Kategori</span>
															<span class="tw-text-sky-500 fw-bold">: {{ ucwords($item->kategori) }} </span>
														</h2>
													</li>
													<li class="list-group-item">
														<h2 class="fs-5 d-inline">
															<span style="display:inline-block; width:150px;">Bentuk Jalur</span>
															<span class="tw-text-sky-500 fw-bold">: {{ ucwords($item->bentuk_jalur) }}</span>
														</h2>
													</li>
													<li class="list-group-item">
														<h2 class="fs-5 d-inline">
															<span style="display:inline-block; width:150px;">Min. Anggaran</span>
															<span class="tw-text-sky-500 fw-bold">: {{ ucwords($item->min_anggaran) }} </span>
														</h2>
													</li>
													<li class="list-group-item">
														<h2 class="fs-5 d-inline">
															<span style="display:inline-block; width:150px;">Maks. Anggaran</span>
															<span class="tw-text-sky-500 fw-bold">: {{ ucwords($item->maks_anggaran) }} </span>
														</h2>
													</li>
												</ol>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
												<a href="/data_pelatihan/{{ $item->id }}/edit" class="btn btn-warning"
													style="font-size: 0.8rem">Edit</a>
											</div>
										</div>
									</div>
								</div>

								<a href="/data_pelatihan/{{ $item->id }}/edit" class="btn btn-warning btn-sm" style="font-size: 0.8rem"
									title="Edit">
									<span class="ti ti-pencil"></span>
								</a>

								<form action="/data_pelatihan/{{ $item->id }}" method="POST">
									@csrf
									@method('delete')
									<button type="submit" class="btn btn-danger btn-sm rounded-end-1 deleteAlert"
										style="font-size: 0.8rem; border-radius: 0" title="Hapus">
										<span class="ti ti-trash"></span>
									</button>
								</form>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
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
					option.value = jalur.bentuk_jalur;
					option.text = jalur.bentuk_jalur;
					bentukJalurSelect.appendChild(option);
				});
			})
			.catch(error => console.error('Error:', error));
		}
	});
</script>
@endsection