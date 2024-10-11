@extends('layouts.app_modern', ['title'=>'Tambah Data Pegawai'])
@section('content')
<div class="card mb-4 bg-white">
	<div class="card-body px-0 py-0 ">
		<div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">Data Kelompok</div>
		<div class="row mx-1 mt-2 mb-2 justify-content-end align-items-center">
			<button class="col ps-0 text-start ms-2">
				<a href="/kelompok/create"
					class="btn btn-outline-primary my-2"
					style="font-size: 0.9rem">
					<span>
							<i class="ti ti-file-plus me-1"></i>
					</span>
					<span>Buat Kelompok Baru</span>
				</a>
			</button>
			<form action="/kelompok/reset" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mereset semua kelompok? Semua pegawai akan dikeluarkan dari kelompok mereka.')">
				@csrf
				<button type="submit" class="btn btn-warning mb-3">Reset Semua Kelompok</button>
			</form>
			<hr class="my-0">
			<div class="table-responsive">
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
										<button
											class="btn btn-primary btn-sm"
											style="font-size: 0.8rem" data-bs-toggle="modal"
											data-bs-target="#detailModal{{ $item->id }}">Detail
										</button>
										
										<a href="/kelompok/{{ $item->id }}/edit" class="btn btn-warning btn-sm" style="font-size: 0.8rem">Edit</a>
													
										<form action="/kelompok/{{ $item->id }}" method="POST">
											@csrf
											@method('delete')
											<button type="submit"
												class="btn btn-danger btn-sm rounded-end-1" onclick="return confirm('Anda yakin ingin menghapus data ini?')" style="font-size: 0.8rem; border-radius: 0">
												Hapus
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
</div>
@endsection