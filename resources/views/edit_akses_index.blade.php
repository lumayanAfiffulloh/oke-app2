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
					@foreach ($user as $index => $item)
					<tr>
						<td class="py-2 text-center"> {{ $user->firstItem() + $index }} </td>
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
													<label for="akses" class="form-label">Hak Akses</label>
													<select name="akses" class="form-select">
														<option value="pegawai" {{ $item->akses == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
														<option value="admin" {{ $item->akses == 'admin' ? 'selected' : '' }}>Admin</option>
														<option value="verifikator" {{ $item->akses == 'verifikator' ? 'selected' : ''
															}}>Verifikator</option>
														<option value="approval" {{ $item->akses == 'approval' ? 'selected' : '' }}>Approval
														</option>
														<option value="ketua_kelompok" {{ $item->akses == 'ketua_kelompok' ? 'selected' : ''
															}}>Ketua Kelompok</option>
													</select>
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

<script>
	document.getElementById('search-unit-form').addEventListener('submit', function(event) {
			if (document.getElementById('unit-input').value === '') {
				event.preventDefault();
			}
		});
</script>

{{-- SWEET ALERT --}}
<script>
	document.querySelectorAll('.deleteAlert').forEach(function(button, index) {
		button.addEventListener('click', function(event) {
			event.preventDefault(); // Mencegah submit langsung

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
								// Submit form yang terkait dengan tombol ini
								button.closest('form').submit(); // Submit form terkait
						});
				}
			});
		});
	});
</script>
@endsection