@extends('layouts.app_modern', ['title'=>'Profil'])
@section('content')

{{-- ROW 1 --}}
<div class="row">
	<div class="col col-md-6 d-flex align-items-strech">
		<div class="card w-100">
			<div class="card-body p-4">
				<h1 class="card-title fw-bolder">{{ ucwords($dataPegawai->nama) }}
					<span>
						@if($dataPegawai->jenis_kelamin === "L")
						<i class="text-primary ti ti-gender-male" style="font-size: 22px;"></i>
						@else
						<i class="ti ti-gender-female" style="font-size: 22px; color: #ff70e7"></i>
						@endif
					</span>
				</h1>
				<hr class="mx-0">
				<div class="row mt-3">
					<div class="col-md-4 text-center">
						@if ($dataPegawai->foto)
						<a href="{{ Storage::url($dataPegawai->foto) }}" target="blank">
							<img src="{{ Storage::url($dataPegawai->foto) }}"
								class="rounded-3 border border-2 border-dark border-opacity-25"
								style="object-fit: cover; height: 200px; width: 150px;">
						</a>
						<a href="#" class="btn btn-warning btn-sm rounded-2 my-1 px-3" data-bs-toggle="modal"
							data-bs-target="#editFotoModal">
							<span class="ti ti-pencil me-2"></span>Edit Foto
						</a>
						@else
						<div class="card bg-info bg-opacity-50 card-responsive mw-100" style="height: 200px; width: 150px;">
							<div class="d-flex flex-column justify-content-center card-body px-2 text-white">
								<p>Tidak ada foto tercantum</p>

								<button class="mt-2">
									<a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal"
										data-bs-target="#tambahFotoModal">Unggah Foto</a>
								</button>
							</div>
						</div>
						@endif
					</div>

					{{-- MODAL TAMBAH FOTO --}}
					<div class="modal fade" data-bs-backdrop="static" tabindex="-1" aria-hidden="true" id="tambahFotoModal">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h1 class="modal-title tw-text-[20px] fw-bold">
										Unggah Foto Profil
									</h1>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<form action="profil/tambah_foto" method="POST" enctype="multipart/form-data" id="createFormID">
									<div class="modal-body border border-2 mx-3 rounded-2">
										@csrf
										<div class="form-group">
											<label for="unggahFoto" class="fw-semibold">Unggah File Foto (Maks : 5 MB)</label>
											<input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto"
												id="unggahFoto">
											<span class="text-danger">{{ $errors->first('foto') }}</span>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
										<button type="submit" class="btn btn-warning" id="createAlert">Unggah</button>
									</div>
								</form>
							</div>
						</div>
					</div>

					{{-- MODAL EDIT FOTO --}}
					<div class="modal fade" data-bs-backdrop="static" tabindex="-1" aria-hidden="true" id="editFotoModal">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h1 class="modal-title tw-text-[20px] fw-semibold">
										Update Foto Profil
									</h1>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<form action="profil/tambah_foto" method="POST" enctype="multipart/form-data" id="editFormID">
									<div class="modal-body border border-2 mx-3 rounded-2">
										@csrf
										<div class="row">
											<div class="col-md-5 pe-0">
												<label class="fw-semibold ms-2 mb-1">Foto Lama:</label>
												<a href="{{ Storage::url($dataPegawai->foto) }}" target="blank">
													<img src="{{ Storage::url($dataPegawai->foto) }}"
														class="d-flex justify-content-center rounded-3 border border-2 border-dark border-opacity-25"
														style="object-fit: cover; height: 200px; width: 150px;" id="fotoLama">
												</a>
											</div>
											<div class="col-md-7 ps-md-0 mt-1 mt-md-0 d-flex flex-column justify-content-center">
												<div class="form-group">
													<label for="unggahFoto" class="fw-semibold mb-1">Unggah Foto Baru (Maks : 5 MB)</label>
													<input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto"
														id="unggahFoto">
													<span class="text-danger">{{ $errors->first('foto') }}</span>
													<div class="mt-2 text-end">
														<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
														<button type="submit" class="btn btn-warning" id="editAlert">Unggah</button>
													</div>

												</div>
											</div>
										</div>
									</div>
									<div class="modal-footer">

									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="col-md-8">
						<p class="fw-bolder fs-4 border border-2 border-dark border-opacity-25 rounded mb-2 py-2 ps-3"
							style="max-width: 70%">Rencana Pembelajaran</p>
						<hr>
						<div class="table-responsive">
							<table class="table table-striped text-center">
								<thead>
									<th class="pt-2 pb-2 px-1">Tahun</th>
									<th class="pt-2 pb-2 px-1">Jam Pelajaran</th>
									<th class="pt-2 pb-2 px-1">Aksi</th>
								</thead>
								<tbody>
									@foreach ($rencanaPembelajaran as $index => $item)
									<tr>
										<td class="py-2">{{ $item->tahun }}</td>
										<td class="py-2">
											<span
												class="badge rounded-pill {{ $item->total_jam_pelajaran < 20 ? 'bg-danger' : 'bg-success' }}"
												@if($item->total_jam_pelajaran < 20) data-bs-toggle="tooltip" data-bs-placement="right"
													data-bs-title="JP minimal per tahun 20 jam" @endif>
													{{ $item->total_jam_pelajaran }} JP
													@if($item->total_jam_pelajaran < 20) <i class="ti ti-xbox-x ms-1" style="color: #b60000"></i>
														<!-- Icon ditampilkan jika JP kurang dari 20 -->
														@endif
											</span>
										</td>
										<td class="py-2 align-middle">
											<a href="" class="btn btn-primary btn-sm ">Detail</a>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>

					</div>
				</div>
				<div class="row justify-content-start">

				</div>
			</div>
		</div>
	</div>
</div>

{{-- TOOLTIPS --}}
@push('scripts')
<script>
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
		var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
			return new bootstrap.Tooltip(tooltipTriggerEl)
		})
</script>
@endpush

{{-- PAKSA BUKA MODAL JIKA ADA ERROR --}}
<script>
	@if ($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        var editFotoModal = new bootstrap.Modal(document.getElementById('editFotoModal'));
        editFotoModal.show();
    });
	@endif
</script>

<script>
	@if ($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        var tambahFotoModal = new bootstrap.Modal(document.getElementById('tambahFotoModal'));
        tambahFotoModal.show();
    });
	@endif
</script>

<script>
	document.addEventListener("DOMContentLoaded", function () {
    const modalElement = document.getElementById('notifPasswordModal');
    if (modalElement) {
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
    }
});

</script>

@endsection