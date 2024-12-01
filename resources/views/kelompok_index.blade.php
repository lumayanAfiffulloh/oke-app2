@extends('layouts.app_modern', ['title'=>'Data Kelompok'])
@section('content')
<div class="card mb-4 bg-white">
	<div class="card-body px-0 py-0 ">
		<div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">Data Kelompok</div>
		<div class="row mx-1 mt-2 mb-2 justify-content-between align-items-center">
			<div class="col-md-5 d-flex justify-content-start align-items-center">
				<button class="col text-start ps-0">
					<a href="/kelompok/create" class="btn btn-outline-primary my-2" style="font-size: 0.9rem">
						<span>
							<i class="ti ti-file-plus me-1"></i>
						</span>
						<span>Buat Kelompok Baru</span>
					</a>
				</button>
				<div class="col">
					<form action="/kelompok/reset" method="POST"
						onsubmit="return confirm('Apakah Anda yakin ingin mereset semua kelompok? Semua pegawai akan dikeluarkan dari kelompok mereka.')">
						@csrf
						<button type="submit" class="btn btn-warning">Reset</button>
					</form>
				</div>
			</div>
			<div class="col-md-5 p-0 mx-3">
				<form action="">
					<div class="input-group">
						<input class="form-control" type="text" name="q" placeholder="Cari berdasarkan Nama Ketua Kelompok"
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
	<div class="table-responsive px-0">
		<table class="table table-striped mb-3" style="font-size: 0.8rem">
			<thead>
				<th class="text-center">No.</th>
				<th>Ketua Kelompok</th>
				<th>Aksi</th>
			</thead>
			<tbody>
				@foreach ($kelompok as $index => $item)
				<tr>
					<td class="text-center"> {{ $kelompok->firstItem() + $index }} </td>
					<td>{{ $item->ketua->nama }}</td>
					<td>
						<div class="btn-group" role="group">
							<button class="btn btn-primary btn-sm" style="font-size: 0.8rem" data-bs-toggle="modal"
								data-bs-target="#detailModal{{ $item->id }}" title="Detail Kelompok"><span class="ti ti-eye"></span>
							</button>

							{{-- MODAL --}}
							<div class="modal fade" id="detailModal{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
								tabindex="-1" aria-labelledby="staticBackdropLabel{{ $item->id }}" aria-hidden="true">
								<div class="modal-dialog modal-xl">
									<div class="modal-content">
										<div class="modal-header">
											<h1 class="modal-title tw-text-[20px] fw-bold" id="staticBackdropLabel{{ $item->id }}">
												Detail Kelompok <span class="text-primary">{{ $item->ketua->nama }}</span>
											</h1>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body border border-2 mx-3 rounded-2">
											<table class="table table-bordered fs-3 mb-0">
												<thead>
													<tr>
														<th>Ketua</th>
														<th>NIP</th>
														<th>Unit Kerja</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>{{ $item->ketua->nama }}</td>
														<td>{{ $item->ketua->nip }}</td>
														<td>{{ $item->ketua->unit_kerja }}</td>
													</tr>
												</tbody>
												<thead>
													<tr>
														<th>Anggota</th>
														<th>NIP</th>
														<th>Unit Kerja</th>
													</tr>
												</thead>
												<tbody>
													@foreach($item->anggota->where('id', '!=', $item->ketua->id) as $pegawai)
													<tr>
														<td>{{ $pegawai->nama }}</td>
														<td>{{ $pegawai->nip }}</td>
														<td>{{ $pegawai->unit_kerja }}</td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
											<a href="/kelompok/{{ $item->id }}/edit" class="btn btn-warning"
												style="font-size: 0.8rem">Edit</a>
										</div>
									</div>
								</div>
							</div>

							<a href="/kelompok/{{ $item->id }}/edit" class="btn btn-warning btn-sm" style="font-size: 0.8rem"
								title="Edit"><span class="ti ti-pencil"></span></a>

							<form action="/kelompok/{{ $item->id }}" method="POST">
								@csrf
								@method('delete')
								<button type="submit" class="btn btn-danger btn-sm rounded-end-1"
									onclick="return confirm('Anda yakin ingin menghapus data ini?')"
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
@endsection