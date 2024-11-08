@extends('layouts.app_modern', ['title' => 'Bentuk Jalur'])
@section('content')
<div class="card mb-4 bg-white">
	<div class="card-body px-0 pt-0">
		<div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">
			Bentuk Jalur
		</div>
		<div class="row my-3">
			<div class="col-md-6 d-flex">
				<button class="position-relative ">
					<a href="/bentuk_jalur/create" class="btn btn-outline-primary ms-3 " style="font-size: 0.9rem">
						<span class="me-1">
							<i class="ti ti-clipboard-plus"></i>
						</span>
						<span>Tambah Bentuk Jalur</span>
					</a>
				</button>
				<form action="">
					<div class="input-group mx-2">
						<select name="kategori" id="" class="form-select">
							<option value="" selected disabled>-- Filter Kategori --</option>
							<option value="klasikal" {{ $kategori==='klasikal' ? 'selected' : '' }}>Klasikal</option>
							<option value="non-klasikal" {{ $kategori==='non-klasikal' ? 'selected' : '' }}>Non-Klasikal</option>
						</select>
						<button type="submit" class="btn btn-primary">
							<i class="ti ti-adjustments-horizontal"></i>
						</button>
					</div>
				</form>
			</div>
		</div>
		<hr class="my-0">
		<div class="table-responsive">
			<table class="table table-striped mb-3" style="font-size: 0.8rem">
				<thead>
					<th class="text-center">No.</th>
					<th>Kategori</th>
					<th>Bentuk Jalur</th>
					<th>Aksi</th>
				</thead>
				<tbody>
					@foreach ($bentuk_jalur as $index => $item)
					<tr>
						<td class="text-center"> {{ $bentuk_jalur instanceof \Illuminate\Pagination\LengthAwarePaginator ?
							$bentuk_jalur->firstItem() + $index : $index + 1 }} </td>
						<td>{{ ucwords($item->kategori) }}</td>
						<td>{{ ucwords($item->bentuk_jalur) }}</td>
						<td>
							<a href="/bentuk_jalur/{{ $item->id }}/edit" class="btn btn-warning btn-sm"
								style="font-size: 0.8rem">Edit</a>
							<form action="/bentuk_jalur/{{ $item->id }}" method="POST" class="d-inline deleteForm">
								@csrf
								@method('delete')
								<button type="submit" class="btn btn-danger btn-sm"
									onclick="return confirm('Anda yakin ingin menghapus data ini?')" style="font-size: 0.8rem;">
									Hapus
								</button>
							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="mx-3">
			@if ($bentuk_jalur instanceof \Illuminate\Pagination\LengthAwarePaginator)
			{!! $bentuk_jalur->links() !!}
			@endif
		</div>
	</div>
</div>
@endsection