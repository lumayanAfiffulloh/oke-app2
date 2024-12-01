@extends('layouts.app_modern', ['title' => 'Bentuk Jalur'])
@section('content')
<div class="card mb-4 bg-white">
	<div class="card-body px-0 pt-0">
		<div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">
			<span>
				<a href="/data_pelatihan" class="ti ti-arrow-left fw-bolder mx-2"></a>
			</span>
			<span class="text-dark text-opacity-50">
				<a href="/data_pelatihan">Data Pelatihan / </a>
			</span>
			Bentuk Jalur
		</div>
		<div class=" row my-3">
			<div class="col d-flex">
				<button class="position-relative ">
					<a href="#" class="btn btn-outline-primary ms-3 " style="font-size: 0.9rem" data-bs-toggle="modal"
						data-bs-target="#createJalurModal">
						<span class="me-1">
							<i class="ti ti-clipboard-plus"></i>
						</span>
						<span>Tambah Bentuk Jalur</span>
					</a>
				</button>
				{{-- MODAL TAMBAH BENTUK JALUR --}}
				<div class="modal fade" data-bs-backdrop="static" tabindex="-1" aria-hidden="true" id="createJalurModal">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h1 class="modal-title tw-text-[20px] fw-bold">
									Tambah Bentuk Jalur
								</h1>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<form action="/bentuk_jalur" method="POST" class="py-2" id="createFormID">
								@csrf
								{{-- KATEGORI --}}
								<div class="modal-body border border-2 mx-3 rounded-2">
									<div class="form-group mt-1 mb-3">
										<label for="kategori" class="fw-bolder">Kategori</label>
										<div class="col-md-6">
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
									<div class="form-group mb-2">
										<label for="bentuk_jalur" class="fw-bolder">Nama Bentuk Jalur</label><br>
										<input type="text" class="form-control @error('bentuk_jalur') is-invalid @enderror"
											id="bentuk_jalur" name="bentuk_jalur" value="{{ old('bentuk_jalur') }}">
										<span class="text-danger">{{ $errors->first('bentuk_jalur') }}</span>
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

				<div class="mx-2">
					<form action="">
						<div class="input-group">
							<select name="kategori" id="kategoriFilter" class="form-select" onchange="applyLiveFilter()">
								<option value="" selected disabled>-- Filter Kategori --</option>
								<option value="" {{ is_null(request('kategori')) ? 'selected' : '' }}>Semua Kategori</option>
								<option value=" klasikal" {{ $kategori==='klasikal' ? 'selected' : '' }}>Klasikal</option>
								<option value="non-klasikal" {{ $kategori==='non-klasikal' ? 'selected' : '' }}>Non-Klasikal
								</option>
							</select>
							<button type="submit" class="btn btn-primary">
								<i class="ti ti-adjustments-horizontal"></i>
							</button>
						</div>
					</form>
				</div>

				<div>
					<form action="">
						<div class="input-group">
							<input class="form-control" type="text" name="q" placeholder="Cari Bentuk Jalur"
								value="{{ request('q') }}">
							<button type="submit" class="btn btn-primary">
								<i class="ti ti-search"></i>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<hr class="my-0">
		<div class="table-responsive">
			<table class="table table-striped mb-3" style="font-size: 0.8rem">
				<thead>
					<th class="text-center">No.</th>
					<th>Kategori</th>
					<th>Bentuk Jalur</th>
					<th>Aksi</th>
				</thead>
				<tbody>
					@foreach ($bentuk_jalur as $index => $item)
					<tr>
						<td class="text-center"> {{ $bentuk_jalur instanceof \Illuminate\Pagination\LengthAwarePaginator ?
							$bentuk_jalur->firstItem() + $index : $index + 1 }} </td>
						<td>{{ ucwords($item->kategori) }}</td>
						<td>{{ ucwords($item->bentuk_jalur) }}</td>
						<td>
							<a href="#" class="btn btn-warning btn-sm editButton" data-id="{{ $item->id }}"
								data-kategori="{{ $item->kategori }}" data-bentuk_jalur="{{ $item->bentuk_jalur }}"
								data-bs-toggle="modal" data-bs-target="#editJalurModal" style="font-size: 0.8rem">
								Edit
							</a>

							{{-- MODAL EDIT BENTUK JALUR --}}
							<div class="modal fade" id="editJalurModal" tabindex="-1" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title">Edit Bentuk Jalur</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<form id="editForm" method="POST">
											@csrf
											@method('PUT')
											<div class="modal-body border border-2 mx-3 rounded-2">
												{{-- Kategori --}}
												<div class="form-group mt-1 mb-3">
													<label for="editKategori" class="fw-bolder">Kategori</label>
													<select class="form-select" id="editKategori" name="kategori">
														<option value="" disabled>-- Pilih Kategori --</option>
														<option value="klasikal">Klasikal</option>
														<option value="non-klasikal">Non-Klasikal</option>
													</select>
												</div>
												{{-- Bentuk Jalur --}}
												<div class="form-group mb-2">
													<label for="editBentukJalur" class="fw-bolder">Nama Bentuk Jalur</label>
													<input type="text" class="form-control" id="editBentukJalur" name="bentuk_jalur">
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
												<button type="submit" class="btn btn-primary">Simpan</button>
											</div>
										</form>
									</div>
								</div>
							</div>

							<form action="/bentuk_jalur/{{ $item->id }}" method="POST" class="d-inline deleteForm">
								@csrf
								@method('delete')
								<button type="submit" class="btn btn-danger btn-sm deleteAlert" style="font-size: 0.8rem;">
									Hapus
								</button>
							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="mx-3">
			@if ($bentuk_jalur instanceof \Illuminate\Pagination\LengthAwarePaginator)
			{!! $bentuk_jalur->links() !!}
			@endif
		</div>
	</div>
</div>




{{-- UNTUK MEMUNCULKAN DATA YANG AKAN DIEDIT PADA MODAL --}}
<script>
	document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.editButton');
    const editModal = document.getElementById('editJalurModal');
    const editForm = document.getElementById('editForm');
    const editKategori = document.getElementById('editKategori');
    const editBentukJalur = document.getElementById('editBentukJalur');

    editButtons.forEach(button => {
			button.addEventListener('click', function () {
				// Ambil data dari atribut tombol
				const id = this.getAttribute('data-id');
				const kategori = this.getAttribute('data-kategori');
				const bentukJalur = this.getAttribute('data-bentuk_jalur');

				// Isi data ke dalam form modal
				editForm.action = `/bentuk_jalur/${id}`;
				editKategori.value = kategori;
				editBentukJalur.value = bentukJalur;
			});
    });
	});
</script>

<script>
	function applyLiveFilter() {
			const kategori = document.getElementById('kategoriFilter').value;

			// Kirim permintaan AJAX
			fetch(`{{ url('bentuk_jalur') }}?kategori=${kategori}`, {
					headers: {
							'X-Requested-With': 'XMLHttpRequest'
					}
			})
			.then(response => response.text())
			.then(html => {
					// Perbarui tabel dengan data baru
					document.getElementById('dataTableContainer').innerHTML = html;
			})
			.catch(error => {
					console.error('Error:', error);
			});
	}
</script>
@endsection