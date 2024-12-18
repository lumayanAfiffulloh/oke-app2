@extends('layouts.app_modern', ['title' => 'Rencana Pembelajaran Anda'])
@section('content')
<div class="card mb-4 pb-4 bg-white">
	<div class="card-body px-0 py-0">
		<div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">Rencana Pembelajaran
			<span class="fw-bolder tw-text-blue-600">{{ Auth::user()->name }}</span>
		</div>
		<button class="position-relative my-2">
			<a href="/rencana_pembelajaran/create" class="btn btn-outline-primary mx-3 my-2" style="font-size: 0.9rem">
				<span class="me-1">
					<i class="ti ti-clipboard-plus"></i>
				</span>
				<span>Tambah Rencana Pembelajaran</span>
			</a>
		</button>
		<hr class="my-0">
		<div class="table-responsive">
			<table class="table table-striped mb-3" style="font-size: 0.8rem" id="myTable">
				<thead>
					<th class="text-center">No.</th>
					<th>Tahun</th>
					<th>Klasifikasi</th>
					<th>Kategori</th>
					<th>Bentuk Jalur</th>
					<th>Nama Pelatihan</th>
					<th>JP</th>
					<th>Prioritas</th>
					<th>AKSI</th>
				</thead>
				<tbody>
					@foreach ($rencana_pembelajaran as $item)
					<tr>
						<td class="text-center"> {{ $loop->iteration }} </td>
						<td>{{ $item->tahun }}</td>
						<td>{{ ucwords($item->klasifikasi) }}</td>
						<td>{{ ucwords($item->kategori) }}</td>
						<td>{{ ucwords($item->bentuk_jalur) }}</td>
						<td>{{ ucwords($item->nama_pelatihan) }}</td>
						<td>
							{{ ($item->jam_pelajaran) }}
						</td>
						<td>
							@if ($item->prioritas === 'rendah')
							<span class="badge rounded-pill bg-success" style="font-size: 0.8rem">Rendah</span>
							@elseif ($item->prioritas === 'sedang')
							<span class="badge rounded-pill bg-warning" style="font-size: 0.8rem">Sedang</span>
							@else
							<span class="badge rounded-pill bg-danger" style="font-size: 0.8rem">Tinggi</span>
							@endif
						</td>
						<td>
							<div class="btn-group" role="group">
								<button class="btn btn-primary btn-sm" style="font-size: 0.8rem" data-bs-toggle="modal"
									data-bs-target="#detailModal{{ $item->id }}" title="Detail"><span class="ti ti-eye"></span>
								</button>
								<!-- Detail Modal -->
								<div class="modal fade" id="detailModal{{ $item->id }}" data-bs-backdrop="static"
									data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel{{ $item->id }}"
									aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h1 class="modal-title tw-text-[20px] fw-bold" id="staticBackdropLabel{{ $item->id }}">
													Detail {{ $item->klasifikasi }} {{ $item->nama_pelatihan }}
													<span class="tw-text-blue-600 fw-bolder">{{ Auth::user()->name }}</span>
												</h1>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<div class="modal-body border border-2 mx-3 rounded-2">
												<ol class="list-group">
													<li class="list-group-item">
														<h2 class="fs-5 d-inline">
															<span style="display:inline-block; width:150px;">Nama Pelatihan</span>
															<span class="tw-text-sky-500 fw-bold">: {{ ucwords($item->nama_pelatihan) }} </span>
														</h2>
													</li>
													<li class="list-group-item">
														<h2 class="fs-5 d-inline">
															<span style="display:inline-block; width:150px;">Tahun</span>
															<span class="tw-text-sky-500 fw-bold">: {{ ucwords($item->tahun) }}</span>
														</h2>
													</li>
													<li class="list-group-item">
														<h2 class="fs-5 d-inline">
															<span style="display:inline-block; width:150px;">Klasifikasi</span>
															<span class="tw-text-sky-500 fw-bold">: {{ ucwords($item->klasifikasi) }} </span>
														</h2>
													</li>
													<li class="list-group-item">
														<h2 class="fs-5 d-inline">
															<span style="display:inline-block; width:150px;">Kategori</span>
															<span class="tw-text-sky-500 fw-bold">: {{ ucwords($item->kategori) }}</span>
														</h2>
													</li>
													<li class="list-group-item">
														<h2 class="fs-5 d-inline">
															<span style="display:inline-block; width:150px;">Bentuk Jalur</span>
															<span class="tw-text-sky-500 fw-bold">: {{ ucwords($item->bentuk_jalur) }} </span>
														</h2>
													</li>
													<li class="list-group-item">
														<h2 class="fs-5 d-inline">
															<span style="display:inline-block; width:150px;">Jam Pelajaran</span>
															<span class="tw-text-sky-500 fw-bold">: {{ ucwords($item->jam_pelajaran) }} Jam</span>
														</h2>
													</li>
													<li class="list-group-item">
														<h2 class="fs-5 d-inline">
															<span style="display:inline-block; width:150px;">Regional</span>
															<span class="tw-text-sky-500 fw-bold">: {{ ucwords($item->regional) }} </span>
														</h2>
													</li>
													<li class="list-group-item">
														<h2 class="fs-5 d-inline">
															<span style="display:inline-block; width:150px;">Anggaran</span>
															<span class="tw-text-sky-500 fw-bold">: {{ formatRupiah($item->anggaran) }} </span>
														</h2>
													</li>
													<li class="list-group-item">
														<h2 class="fs-5 d-inline">
															<span style="display:inline-block; width:150px;">Prioritas</span>
															@if ($item->prioritas === 'rendah')
															<span class="fw-bold tw-text-sky-500">: </span><span
																class="badge rounded-pill bg-success">Rendah</span>
															@elseif ($item->prioritas === 'sedang')
															<span class="fw-bold tw-text-sky-500">: </span><span
																class="badge rounded-pill bg-warning">Sedang</span>
															@else
															<span class="fw-bold tw-text-sky-500">: </span><span
																class="badge rounded-pill bg-danger">Tinggi</span>
															@endif
														</h2>
													</li>
												</ol>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
												<a href="/rencana_pembelajaran/{{ $item->id }}/edit" class="btn btn-warning"
													style="font-size: 0.8rem">Edit</a>
											</div>
										</div>
									</div>
								</div>
								<a href="/rencana_pembelajaran/{{ $item->id }}/edit" class="btn btn-warning btn-sm"
									style="font-size: 0.8rem" title="Edit"><span class="ti ti-pencil"></span></a>

								<form action="/rencana_pembelajaran/{{ $item->id }}" method="POST">
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