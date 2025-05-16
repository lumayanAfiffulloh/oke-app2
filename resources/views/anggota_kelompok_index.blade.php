@extends('layouts.main_layout', ['title' => 'Anggota Kelompok'])
@section('content')
<div class="card mb-4 pb-4 bg-white">
	<div class="card-body px-0 py-0">
		<div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">Anggota Kelompok
			<span class="fw-bolder text-primary">{{ Auth::user()->name }}</span>
		</div>
		<hr class="my-0">
		<div class="table-responsive">
			<table class="table table-hover table-bordered mb-3" style="font-size: 0.7rem" id="myTable">
				<thead>
					<tr>
						<th class="align-middle">No.</th>
						<th>Nama</th>
						<th class="text-start">NPPU</th>
						<th>Email</th>
						<th>Status</th>
						<th>Unit Kerja</th>
						<th>AKSI</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($dataPegawai as $item)
					<tr>
						<td class="text-center"> {{ $loop->iteration }} </td>
						<td>
							<div>
								<span>
									@if ($item->jenis_kelamin === 'L')
									<i class="ti ti-gender-male text-primary" style="font-size: 15px"></i>
									@else
									<i class="ti ti-gender-female" style="font-size: 15px; color: #ff70e7"></i>
									@endif
								</span>
								{{ $item->nama }}
							</div>
						</td>
						<td class="text-start">{{ $item->nppu }}</td>
						<td>{{ $item->user->email }}</td>
						<td>
							@if ($item->status === 'aktif')
							<span class="badge rounded-pill bg-success" style="font-size: 0.8rem">Aktif</span>
							@else
							<span class="badge rounded-pill bg-danger" style="font-size: 0.8rem">Non-Aktif</span>
							@endif
						</td>
						<td>{{ $item->unitKerja->unit_kerja }}</td>
						<td>
							<button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}"
								title="Detail" style="font-size: 0.8rem"><span class="ti ti-eye"></span></button>
							<!-- Detail Modal -->
							<div class="modal fade" id="detailModal{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
								tabindex="-1" aria-labelledby="staticBackdropLabel{{ $item->id }}" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<h1 class="modal-title fs-5 fw-semibold" id="staticBackdropLabel{{ $item->id }}">
												Detail Pegawai <span class="fw-semibold text-primary">{{ $item->nama }}</span>
											</h1>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body border border-2 mx-3 rounded-2">
											<ol class="list-group">
												<li class="list-group-item">
													<h2 class="fs-5 d-inline">
														<span style="display:inline-block; width:200px;">Nama</span>
														<span class="text-secondary fw-bold">: {{ ucwords($item->nama) }} </span>
													</h2>
												</li>
												<li class="list-group-item">
													<h2 class="fs-5 d-inline">
														<span style="display:inline-block; width:200px;">NPPU</span>
														<span class="text-secondary fw-bold">: {{ ucwords($item->nppu) }}</span>
													</h2>
												</li>
												<li class="list-group-item">
													<h2 class="fs-5 d-inline">
														<span style="display:inline-block; width:200px;">Email</span>
														<span class="text-secondary fw-bold">: {{ ($item->user->email) }} </span>
													</h2>
												</li>
												<li class="list-group-item">
													<h2 class="fs-5 d-inline">
														<span style="display:inline-block; width:200px;">Status</span>
														<span class="text-secondary fw-bold">: @if ($item->status === 'aktif')
															<span class="badge rounded-pill bg-success">Aktif</span>
															@else
															<span class="badge rounded-pill bg-danger">Non-Aktif</span>
															@endif</span>
													</h2>
												</li>
												<li class="list-group-item">
													<h2 class="fs-5 d-inline">
														<span style="display:inline-block; width:200px;">Unit Kerja</span>
														<span class="text-secondary fw-bold">: {{ ucwords($item->unitKerja->unit_kerja) }}
														</span>
													</h2>
												</li>
												<li class="list-group-item">
													<h2 class="fs-5 d-inline">
														<span style="display:inline-block; width:200px;">Jabatan</span>
														<span class="text-secondary fw-bold">: {{ ucwords($item->jabatan->jabatan) }}</span>
													</h2>
												</li>
												<li class="list-group-item">
													<h2 class="fs-5 d-inline">
														<span style="display:inline-block; width:200px;">Pendidikan</span>
														<span class="text-secondary fw-bold">: {{
															ucwords($item->pendidikanTerakhir->jenjangTerakhir->jenjang_terakhir) }}
														</span>
													</h2>
												</li>
												<li class="list-group-item">
													<h2 class="fs-5 d-inline">
														<span style="display:inline-block; width:200px;">Jurusan Pendidikan</span>
														<span class="text-secondary fw-bold">: {{ ucwords($item->pendidikanTerakhir->jurusan)
															}} </span>
													</h2>
												</li>
											</ol>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
										</div>
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