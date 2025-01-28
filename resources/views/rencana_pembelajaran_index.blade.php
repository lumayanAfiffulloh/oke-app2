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
			<table class="table table-striped table-bordered mb-3" style="font-size: 0.7rem" id="myTable">
				<thead>
					<tr>
						<th class="align-middle" rowspan="2">No.</th>
						<th class="align-middle" rowspan="2">Tahun <br> Kode</th>
						<th class="align-middle" rowspan="2">Bentuk</th>
						<th class="align-middle" rowspan="2">Kegiatan</th>
						<th class="align-middle" colspan="3">Verifikasi & Validasi</th>
						<th class="align-middle" rowspan="2">Realisasi</th>
						<th class="align-middle" rowspan="2">Keterangan</th>
						<th class="align-middle" rowspan="2">AKSI</th>
					</tr>
					<tr>
						<th>Atasan</th>
						<th>Satker</th>
						<th>Biro SDM</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection