@extends('layouts.main_layout', ['title' => 'Hak Akses'])
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
					<th>Hak Akses</th>
					<th>Aksi</th>
				</thead>
				<tbody>
					@foreach ($users as $user)
					<tr>
						<td class="py-2 text-center">{{ $loop->iteration }}</td>
						<td class="py-2">{{ $user->name }}</td>
						<td class="py-2">
							{{-- Tampilkan daftar roles user --}}
							@foreach ($user->roles as $role)
							<span class="badge bg-secondary fs-2">{{ ucwords(str_replace('_', ' ', $role->role)) }}</span>
							@endforeach
						</td>
						<td class="py-2">
							<!-- Tombol untuk memunculkan modal -->
							<a href="#" class="btn btn-warning btn-sm col" data-bs-toggle="modal"
								data-bs-target="#editAksesModal{{ $user->id }}">
								<span class="ti ti-pencil"></span>
							</a>


							<!-- Modal Bootstrap -->
							<div class="modal fade" id="editAksesModal{{ $user->id }}" aria-labelledby="editAksesModalLabel"
								data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h1 class="modal-title fs-5 fw-bolder">
												Edit Akses <span class="text-primary">{{ $user->name }}</span>
											</h1>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<form action="{{ route('edit_akses.update', $user->id) }}" method="POST" id="editFormID">
											@csrf
											@method('PUT')
											<div class="modal-body border border-2 mx-3 rounded-2">
												<div class="form-group">
													<label for="roles" class="fw-bolder mb-2 fs-4">Hak Akses</label>
													{{-- Checkbox roles --}}
													@foreach ($roles as $role)
													<div class="form-check">
														<input type="checkbox" name="roles[]" id="role_{{ $role->id }}" value="{{ $role->id }}"
															class="form-check-input" {{ in_array($role->id, $user->roles->pluck('id')->toArray()) ?
														'checked' : '' }}>
														<label class="form-check-label" for="role_{{ $role->id }}">
															{{ ucwords(str_replace('_', ' ', $role->role)) }}
														</label>
													</div>
													@endforeach
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
												<button type="submit" class="btn btn-warning" id="editAlert{{$user->id}}">Simpan</button>
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