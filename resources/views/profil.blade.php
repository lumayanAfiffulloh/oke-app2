@extends('layouts.app_modern', ['title'=>'Profil'])
@section('content')

{{-- ROW 1 --}}
<div class="row">
	{{-- FOTO --}}
	<div class="col col-md-6 d-flex align-items-strech">
		<div class="card w-100">
			<div class="card-body p-4">
				<h1 class="card-title fw-bolder">{{ ucwords($dataPegawai->nama) }}
					<span>
						@if($dataPegawai->jenis_kelamin === "laki-laki")
						<i class="text-primary ti ti-gender-male" style="font-size: 22px;"></i>
						@else
						<i class="ti ti-gender-female" style="font-size: 22px; color: #ff70e7"></i>
						@endif
					</span>
				</h1>
				<hr class="mx-0">
				<div class="row mt-3">
					<div class="col-4 text-center">
						@if ($dataPegawai->foto)
						<a href="{{ Storage::url($dataPegawai->foto) }}" target="blank">
							<img src="{{ Storage::url($dataPegawai->foto) }}"
								class="d-flex justify-content-center rounded-3 border border-2 border-dark mb-2"
								style="object-fit: cover; height: 190px; width: 150px;">
						</a>
						@else
						<div class="card tw-bg-slate-400 mb-2">
							<div class="card-body text-center text-white fs-3" style="height: 100px">
								Tidak ada foto tercantum
							</div>
							<button class="mx-3 mb-5">
								<a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal"
									data-bs-target="#tambahFotoModal">Unggah Foto</a>
							</button>
						</div>
						@endif
						<a href="/ganti_password" class="btn btn-warning btn-sm rounded-2 my-1">
							Ganti Password
						</a>
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
								<form action="profil/tambah_foto" method="POST" enctype="multipart/form-data">
									<div class="modal-body border border-2 mx-3 rounded-2">
										@csrf
										<div class="form-group">
											<label for="unggahFoto" class="form-label">Unggah File Foto (Maks : 5 MB)</label>
											<input type="file" class="form-control" name="foto" id="unggahFoto">
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
										<button type="submit" class="btn btn-warning">Unggah</button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="col-8">
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
@push('scripts')
<script>
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
		var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
			return new bootstrap.Tooltip(tooltipTriggerEl)
		})
</script>
@endpush
@endsection