@extends('layouts.app_modern', ['title' => 'Data Pegawai'])
@section('content')

<div class="card mb-4 pb-4 bg-white">
	<div class="card-body px-0 py-0 ">
		<div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">Data Pegawai</div>
		<div class="row mx-3 mt-1 justify-content-start align-items-center">
			<div class="col ps-0">
				<button class="px-0 text-start">
					<a href="/data_pegawai/create" class="btn btn-outline-primary my-2" style="font-size: 0.9rem">
						<span>
							<i class="ti ti-user-plus me-1"></i>
						</span>
						<span>Tambah Pegawai</span>
					</a>
				</button>

				{{-- IMPORT EXCEL --}}
				<button class="px-0 text-start ms-2" type="button">
					<a href="#" class="btn btn-outline-success my-2" style="font-size: 0.9rem" data-bs-toggle="modal"
						data-bs-target="#excelModal">
						<span>
							<i class="ti ti-table-import me-1"></i>
						</span>
						<span>Import Excel</span>
					</a>
				</button>
				{{-- MODAL IMPORT EXCEL --}}
				<div class="modal fade" data-bs-backdrop="static" tabindex="-1" aria-hidden="true" id="excelModal">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h1 class="modal-title tw-text-[20px] fw-bold">
									Import Data Pegawai dari Excel
								</h1>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<form action="data_pegawai/import" method="POST" enctype="multipart/form-data">
								<div class="modal-body border border-2 mx-3 rounded-2">
									@csrf
									<div class="form-group">
										<label for="importExcel" class="form-label">Unggah File Excel (Sesuai
											Template)</label>
										<input type="file" class="form-control" name="importDataPegawai" id="importExcel">
									</div>
									<div class="mt-2">
										<p class="fw-bolder">Unduh Template Excel : <span>
												<a href="https://drive.google.com/uc?export=download&id=1xzdyANHS0m9t_yqTV6SI_1v8Fgrsq4wU"
													class="btn btn-link px-1 pt-1">Klik di Sini!</a>
											</span></p>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
									<button type="submit" class="btn btn-warning">Import</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<hr style="margin-top: 0.3rem">
		<div class="table-responsive">
			{{-- TABEL --}}
			<table class="table table-striped mb-3" style="font-size: 0.8rem; width:100%" id="myTable">
				<thead>
					<th class="text-center">No.</th>
					<th>Nama</th>
					<th class="text-start">NPPU</th>
					<th>Email</th>
					<th>Status</th>
					<th>Unit Kerja</th>
					<th>AKSI</th>
				</thead>
				<tbody>
					@foreach ($data_pegawai as $item)
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
								{{ $item->nama }} <span>({{ $item->kelompok_id }})</span>
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
						<td>{{ $item->unit_kerja }}</td>
						<td>
							<div class="btn-group" role="group">
								<button class="btn btn-sm btn-primary" data-bs-toggle="modal"
									data-bs-target="#detailModal{{ $item->id }}" title="Detail" style="font-size: 0.8rem"><span
										class="ti ti-eye"></span></button>
								<!-- Detail Modal -->
								<div class="modal fade" id="detailModal{{ $item->id }}" data-bs-backdrop="static"
									data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel{{ $item->id }}"
									aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<h1 class="modal-title tw-text-[20px] fw-bold" id="staticBackdropLabel{{ $item->id }}">
													Detail Pegawai <span class="fw-semibold tw-text-blue-500">{{ $item->nama }}</span>
												</h1>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<div class="modal-body border border-2 mx-3 rounded-2">
												<ol class="list-group">
													<li class="list-group-item">
														<h2 class="fs-5 d-inline">
															<span style="display:inline-block; width:200px;">Nama</span>
															<span class="tw-text-sky-500 fw-bold">: {{ ucwords($item->nama) }} </span>
														</h2>
													</li>
													<li class="list-group-item">
														<h2 class="fs-5 d-inline">
															<span style="display:inline-block; width:200px;">NPPU</span>
															<span class="tw-text-sky-500 fw-bold">: {{ ucwords($item->nppu) }}</span>
														</h2>
													</li>
													<li class="list-group-item">
														<h2 class="fs-5 d-inline">
															<span style="display:inline-block; width:200px;">Email</span>
															<span class="tw-text-sky-500 fw-bold">: {{ ($item->user->email) }} </span>
														</h2>
													</li>
													<li class="list-group-item">
														<h2 class="fs-5 d-inline">
															<span style="display:inline-block; width:200px;">Status</span>
															<span class="tw-text-sky-500 fw-bold">: @if ($item->status === 'aktif')
																<span class="badge rounded-pill bg-success">Aktif</span>
																@else
																<span class="badge rounded-pill bg-danger">Non-Aktif</span>
																@endif</span>
														</h2>
													</li>
													<li class="list-group-item">
														<h2 class="fs-5 d-inline">
															<span style="display:inline-block; width:200px;">Unit Kerja</span>
															<span class="tw-text-sky-500 fw-bold">: {{ ucwords($item->unit_kerja) }} </span>
														</h2>
													</li>
													<li class="list-group-item">
														<h2 class="fs-5 d-inline">
															<span style="display:inline-block; width:200px;">Jabatan</span>
															<span class="tw-text-sky-500 fw-bold">: {{ ucwords($item->jabatan) }} Jam</span>
														</h2>
													</li>
													<li class="list-group-item">
														<h2 class="fs-5 d-inline">
															<span style="display:inline-block; width:200px;">Pendidikan</span>
															<span class="tw-text-sky-500 fw-bold">: {{ ucwords($item->pendidikan) }} </span>
														</h2>
													</li>
													<li class="list-group-item">
														<h2 class="fs-5 d-inline">
															<span style="display:inline-block; width:200px;">Jurusan Pendidikan</span>
															<span class="tw-text-sky-500 fw-bold">: {{ ucwords($item->jurusan_pendidikan) }} </span>
														</h2>
													</li>
												</ol>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
												<a href="/data_pegawai/{{ $item->id }}/edit" class="btn btn-warning"
													style="font-size: 0.8rem">Edit</a>
											</div>
										</div>
									</div>
								</div>

								<a href="/data_pegawai/{{ $item->id }}/edit" class="btn btn-warning btn-sm" style="font-size: 0.8rem"
									title="Edit"><span class="ti ti-pencil"></span></a>

								<form action="/data_pegawai/{{ $item->id }}" method="POST" class="d-inline deleteForm">
									@csrf
									@method('delete')
									<button type="submit" class="btn btn-danger btn-sm rounded-end-1 deleteAlert"
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