@extends('layouts.main_layout', ['title'=>'Profil'])
@section('content')

{{-- MODAL NOTIFIKASI TENGGAT WAKTU --}}
@if(session('deadline_notification') && !session('default_password'))
@include('components.modal.notifikasi_deadline_modal')
<script>
	document.addEventListener('DOMContentLoaded', function () {
    var deadlineModal = new bootstrap.Modal(document.getElementById('notifDeadlineModal'));
    deadlineModal.show();
  });
</script>
@endif

{{-- ROW 1 --}}
<div class="row">
	{{-- KOLOM 1 (RENCANA PEMBELAJARAN) --}}
	<div class="col @if(auth()->user()->roles()->where('role', 'admin')->exists()) col-md-6 @else
		col-md-7 @endif d-flex align-items-stretch">
		<div class="card w-100">
			<div class="card-body p-4">
				<div class="d-flex align-items-center mb-4">
					<!-- Foto Profil -->
					<div class="me-4 flex-shrink-0">
						@if ($dataPegawai->foto)
						<a href="{{ Storage::url($dataPegawai->foto) }}" target="blank">
							<img src="{{ Storage::url($dataPegawai->foto) }}"
								class="rounded-circle border border-2 border-dark border-opacity-25"
								style="object-fit: cover; height: 120px; width: 120px;">
						</a>
						@else
						<div
							class="rounded-circle bg-info bg-opacity-50 d-flex flex-column justify-content-center align-items-center"
							style="height: 120px; width: 120px;">
							<p class="text-white small mb-1">No Photo</p>
							<a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal"
								data-bs-target="#tambahFotoModal">Upload</a>
						</div>
						@endif
					</div>

					<!-- Nama dan Informasi -->
					<div class="flex-grow-1 me-3">
						<div class="card-title fw-bolder mb-1 fs-4">{{ ucwords($dataPegawai->nama) }}
							<span>
								@if($dataPegawai->jenis_kelamin === "L")
								<i class="text-primary ti ti-gender-male" style="font-size: 22px;"></i>
								@else
								<i class="ti ti-gender-female" style="font-size: 22px; color: #ff70e7"></i>
								@endif
							</span>
						</div>
						<p class="text-muted mb-">NPPU: {{ $dataPegawai->nppu }}</p>

						<div class="mt-2">
							<a href="#" class="btn btn-warning btn-sm rounded-2 px-3" data-bs-toggle="modal"
								data-bs-target="#editFotoModal">
								<span class="ti ti-pencil me-1"></span>Edit Foto
							</a>
						</div>
					</div>

					<!-- Unit Kerja -->
					<div class="ms-auto text-end" style="min-width: 180px;">
						<div class="d-flex flex-column align-items-end">
							<span class="text-muted small mb-1">Unit Kerja</span>
							<span
								class="badge bg-primary bg-opacity-10 text-primary py-2 px-3 d-inline-flex align-items-center border border-primary border-opacity-25">
								<i class="ti ti-building-community me-2"></i>
								<span class="fw-medium text-truncate" style="max-width: 150px;">{{ $dataPegawai->unitKerja->unit_kerja
									?? 'Belum ditentukan' }}</span>
							</span>
						</div>
					</div>
				</div>

				<hr class="my-3">

				<!-- Bagian Rencana Pembelajaran -->
				<div class="mt-3">
					<div class="fw-semibold h5 mb-3">Rencana Pembelajaran</div>
					<div class="table-responsive">
						<table class="table table-striped text-center">
							<thead class="table-light">
								<tr>
									<th class="py-2 px-2">Tahun</th>
									<th class="py-2 px-2">Jam Pelajaran</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($rencanaPembelajaran as $index => $item)
								<tr>
									<td class="py-2 align-middle">{{ $item->tahun }}</td>
									<td class="py-2 align-middle">
										<span class="badge rounded-pill {{ $item->total_jam_pelajaran < 20 ? 'bg-danger' : 'bg-success' }}"
											@if($item->total_jam_pelajaran < 20) data-bs-toggle="tooltip" data-bs-placement="right"
												data-bs-title="JP minimal per tahun 20 jam" @endif>
												{{ $item->total_jam_pelajaran }} JP
												@if($item->total_jam_pelajaran < 20) <i class="ti ti-alert-circle ms-1"></i>
													@endif
										</span>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	{{-- KOLOM MANAJEMEN JADWAL UNTUK ADMIN --}}
	@can('admin')
	@include('partials.manajemen_jadwal_admin')
	@endcan

	{{-- KOLOM JADWAL UNTUK AKTOR LAIN --}}
	@php
	$rolePartials = [
	'pegawai' => 'partials.jadwal_rencana_pegawai',
	'ketua_kelompok' => 'partials.jadwal_validasi_kelompok',
	'verifikator' => 'partials.jadwal_verifikasi_unit_kerja',
	'approver' => 'partials.jadwal_approval_universitas',
	];
	@endphp

	<div class="col-md-5 d-flex flex-column">
		{{-- Tab Navigasi --}}
		<ul class="nav nav-tabs mb-3" id="roleTabs" role="tablist">
			@foreach ($roles as $index => $role)
			@if (isset($rolePartials[$role]))
			<li class="nav-item" role="presentation">
				<button class="nav-link @if($index === 0) active @endif" id="tab-{{ $role }}" data-bs-toggle="tab"
					data-bs-target="#content-{{ $role }}" type="button" role="tab">
					{{ ucwords(str_replace('_', ' ', $role)) }}
				</button>
			</li>
			@endif
			@endforeach
		</ul>

		{{-- Konten Tiap Tab --}}
		<div class="tab-content" id="roleTabContent">
			@foreach ($roles as $index => $role)
			@if (isset($rolePartials[$role]))
			<div class="tab-pane fade @if($index === 0) show active @endif" id="content-{{ $role }}" role="tabpanel"
				aria-labelledby="tab-{{ $role }}">
				@include($rolePartials[$role])
			</div>
			@endif
			@endforeach
		</div>
	</div>
</div>
{{-- MODAL TAMBAH FOTO --}}
<div class="modal fade" data-bs-backdrop="static" tabindex="-1" aria-hidden="true" id="tambahFotoModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5 fw-bold">
					Unggah Foto Profil
				</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="profil/tambah_foto" method="POST" enctype="multipart/form-data" id="createFormID">
				<div class="modal-body border border-2 mx-3 rounded-2">
					@csrf
					<div class="form-group">
						<label for="unggahFoto" class="fw-semibold">Unggah File Foto (Maks : 5 MB)</label>
						<input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="unggahFoto">
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
				<h1 class="modal-title fs-5 fw-semibold">
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
								<input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="unggahFoto">
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