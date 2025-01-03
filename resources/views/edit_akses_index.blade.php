@extends('layouts.app_modern', ['title' => 'Hak Akses'])
@section('content')

<div class="card mb-4 pb-4 bg-white">
	<div class="card-body px-0 py-0 ">
		<div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">Hak Akses Pegawai</div>
		<hr class="my-0">

		<div class="table-responsive">
			{{-- TABEL --}}
			<table class="table table-striped mb-3" style="font-size: 0.8rem" id="myTable">
				<thead>
					<th class="text-center">No.</th>
					<th>Nama</th>
					<th>Akses</th>
					<th>Aksi</th>
				</thead>
				<tbody>
					@foreach ($user as $item)
					<tr>
						<td class="py-2 text-center"> {{ $loop->iteration }} </td>
						<td class="py-2"> {{ $item->name }} </td>
						<td class="py-2">{{ ucwords(str_replace('_', ' ', $item->akses)) }}</td>
						<td class="py-2">
							<!-- Tombol untuk memunculkan modal -->
							<button class="col px-0" type="button">
								<a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
									data-bs-target="#editAksesModal{{ $item->id }}">
									<span>Edit Akses</span>
								</a>
							</button>

							<!-- Modal Bootstrap -->
							<div class="modal fade" id="editAksesModal{{ $item->id }}" aria-labelledby="editAksesModalLabel"
								data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h1 class="modal-title tw-text-[20px] fw-bolder">
												Edit Akses <span class="text-primary">{{ $item->name }}</span>
											</h1>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<form action="{{ route('edit_akses.update', $item->id) }}" method="POST">
											@csrf
											@method('PUT')
											<div class="modal-body border border-2 mx-3 rounded-2">
												<div class="form-group">
													<label for="akses" class="fw-bolder mb-2 fs-4">Hak Akses</label>
													<div class="form-check">
														<input type="checkbox" name="akses[]" id="pegawai" value="pegawai" class="form-check-input"
															{{ $item->akses == 'pegawai' ? 'checked' : '' }}>
														<label class="form-check-label" for="pegawai">Pegawai</label>
													</div>
													<div class="form-check">
														<input type="checkbox" name="akses[]" id="admin" value="admin" class="form-check-input" {{
															$item->akses == 'admin' ? 'checked' : '' }}>
														<label class="form-check-label" for="admin">Admin</label>
													</div>
													<div class="form-check">
														<input type="checkbox" name="akses[]" id="verifikator" value="verifikator"
															class="form-check-input" {{ $item->akses == 'verifikator' ? 'checked' : '' }}>
														<label class="form-check-label" for="verifikator">Verifikator</label>
													</div>
													<div class="form-check">
														<input type="checkbox" name="akses[]" id="approval" value="approval"
															class="form-check-input" {{ $item->akses == 'approval' ? 'checked' : '' }}>
														<label class="form-check-label" for="approval">Approval</label>
													</div>
													<div class="form-check">
														<input type="checkbox" name="akses[]" id="ketua_kelompok" value="ketua_kelompok"
															class="form-check-input" {{ $item->akses == 'ketua_kelompok' ? 'checked' : '' }}>
														<label class="form-check-label" for="ketua_kelompok">Ketua Kelompok</label>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
												<button type="submit" class="btn btn-primary">Simpan Perubahan</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>

	</div>
</div>

@endsection