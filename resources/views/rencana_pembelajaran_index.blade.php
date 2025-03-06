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
			<table class="table table-hover table-bordered mb-3" style="font-size: 0.7rem" id="myTable">
				<thead>
					<tr>
						<th class="align-middle" rowspan="2">No.</th>
						<th class="align-middle" rowspan="2">Tahun <br> Kode</th>
						<th class="align-middle" rowspan="2">Bentuk</th>
						<th class="align-middle" rowspan="2">Kegiatan</th>
						<th class="align-middle" colspan="3">Verifikasi & Validasi</th>
						<th class="align-middle" rowspan="2">Rencana</th>
						<th class="align-middle" rowspan="2">Keterangan</th>
						<th class="align-middle" rowspan="2">AKSI</th>
					</tr>
					<tr>
						<th>Ketua Kelompok</th>
						<th>Pimpinan Unit Kerja</th>
						<th>Universitas</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($rencana_pembelajaran as $index => $rencana)
					<tr>
						<td class="px-2 text-center">{{ $index + 1 }}</td>
						<td class="px-2 text-center">{{ $rencana->tahun }}
							@if ($rencana->klasifikasi == 'pelatihan')
							<br> <span class="fw-semibold">{{ ucwords($rencana->dataPelatihan->kode) }}</span>
							@endif
						</td>
						<td class="px-2">
							@if ($rencana->klasifikasi == 'pelatihan')
							@if ($rencana->bentukJalur->kategori->kategori == "klasikal")
							<span class="badge text-bg-secondary" style="font-size: 0.7rem">
								{{ ucwords($rencana->bentukJalur->kategori->kategori) ?? '-' }}
							</span>
							@else
							<span class="badge text-bg-warning" style="font-size: 0.7rem">
								{{ ucwords($rencana->bentukJalur->kategori->kategori) ?? '-' }}
							</span>
							@endif
							<br>
							<span class="fw-semibold">Bentuk Jalur: </span>{{ $rencana->bentukJalur->bentuk_jalur ?? '' }} <br>
							<span class="fw-semibold">Rumpun:</span> {{ $rencana->dataPelatihan->rumpun->rumpun ?? '' }}
							@elseif($rencana->klasifikasi == 'pendidikan')
							<span class="badge text-bg-primary" style="font-size: 0.7rem">
								{{ ucwords($rencana->klasifikasi) ?? '-' }}
							</span><br>
							<span class="fw-semibold">Jenjang:</span>
							{{ $rencana->jenjang->jenjang ?? '' }}
							@endif
						</td>
						<td class="px-2">
							@if($rencana->klasifikasi == 'pelatihan')
							<span class="fw-semibold">Nama Pelatihan: </span><br>
							{{ $rencana->dataPelatihan->nama_pelatihan ?? '-' }}
							@else
							<span class="fw-semibold">Jurusan: </span><br>
							{{ $rencana->dataPendidikan->jurusan ?? '-' }}
							@endif
						</td>
						<td class="px-2">
							@if($rencana->verifikasiKelompok)
							@if($rencana->verifikasiKelompok->status == 'disetujui')
							<span class="badge text-bg-success" style="font-size: 0.7rem">Disetujui</span>
							@elseif($rencana->verifikasiKelompok->status == 'ditolak')
							<span class="badge text-bg-danger" style="font-size: 0.7rem">Ditolak</span>
							@endif
							<br>
							<span class="fw-semibold">Catatan:</span> {{ $rencana->verifikasiKelompok->catatan ?? '-' }}
							@else
							<span style="font-size: 0.7rem">-</span>
							@endif
						</td>
						<td class="px-2">-</td> {{-- Verifikasi Satker --}}
						<td class="px-2">-</td> {{-- Verifikasi Biro SDM --}}
						<td class="px-2">
							<span class="fw-semibold">Region: </span>{{ ucwords($rencana->region->region) ?? '-' }} <br>
							<span class="fw-semibold">JP: </span>{{ $rencana->jam_pelajaran }} JP <br>
							<span class="fw-semibold">Anggaran: </span>Rp{{ number_format($rencana->anggaran_rencana, 0, ',', '.') }}
						</td>
						<td class="px-2">
							<span class="fw-semibold">Prioritas:</span>
							@if ($rencana->prioritas == 'rendah')
							<span class="badge rounded-pill text-bg-success" style="font-size: 0.7rem">Rendah</span>
							@elseif ($rencana->prioritas == 'sedang')
							<span class="badge rounded-pill text-bg-warning" style="font-size: 0.7rem">Sedang</span>
							@elseif ($rencana->prioritas == 'tinggi')
							<span class="badge rounded-pill text-bg-danger" style="font-size: 0.7rem">Tinggi</span>
							@endif
							<br><span class="fw-semibold">Status:</span>
							{{ ucwords($rencana->status_pengajuan) }}

						</td>
						<td class="px-2">
							@if($rencana->verifikasiKelompok)
							@if($rencana->verifikasiKelompok->status == 'disetujui')
							<div class="fw-bold">*Rencana yang disetujui tidak bisa dihapus atau diedit</div>
							@else
							@if($rencana->verifikasiKelompok->status_revisi != 'sudah_direvisi')
							<div class="btn-group" role="group">
								<a href="/rencana_pembelajaran/{{ $rencana->id }}/edit" class="btn btn-warning btn-sm"
									style="font-size: 0.8rem" title="Revisi"><span class="ti ti-scissors"></span></a>

								<form action="{{ route('rencana_pembelajaran.kirim_revisi', $rencana->id) }}" method="POST"
									id="kirimRevisiForm">
									@csrf
									<button type="submit" class="btn btn-success btn-sm rounded-end-1"
										style="font-size: 0.8rem; border-radius: 0" title="Kirim Revisi" id="kirimRevisiAlert">
										<span class="ti ti-script"></span>
									</button>
								</form>
							</div>
							@else
							<div class="fw-bold">*Rencana yang sudah dikirim revisinya tidak bisa diedit.</div>
							@endif
							@if($rencana->verifikasiKelompok->status_revisi)
							<br>
							<span class="fw-semibold">Status Revisi:</span>
							<span
								class="badge {{ $rencana->verifikasiKelompok->status_revisi == 'belum_direvisi' ? 'text-bg-danger' : ($rencana->verifikasiKelompok->status_revisi == 'sedang_direvisi' ? 'text-bg-warning' : 'text-bg-success') }} fs-1">
								{{ $rencana->verifikasiKelompok->status_revisi == 'sedang_direvisi' ? 'Revisi perlu dikirim' :
								ucwords(str_replace("_", " ", $rencana->verifikasiKelompok->status_revisi)) }}
							</span>
							@endif
							@endif
							@elseif($rencana->status_pengajuan === 'draft')
							<div class="btn-group" role="group">
								<a href="/rencana_pembelajaran/{{ $rencana->id }}/edit" class="btn btn-warning btn-sm"
									style="font-size: 0.8rem" title="Edit"><span class="ti ti-pencil"></span></a>

								<form action="/rencana_pembelajaran/{{ $rencana->id }}" method="POST" class="d-inline deleteForm">
									@csrf
									@method('delete')
									<button type="submit" class="btn btn-danger btn-sm deleteAlert"
										style="font-size: 0.8rem; border-radius: 0" title="Hapus">
										<span class="ti ti-trash"></span>
									</button>
								</form>

								<form action="{{ route('rencana.ajukan', $rencana->id) }}" method="POST" id="ajukanForm">
									@csrf
									<button type="submit" class="btn btn-success btn-sm rounded-end-1"
										style="font-size: 0.8rem; border-radius: 0" title="Ajukan Verifikasi" id="ajukanAlert">
										<span class="ti ti-check"></span>
									</button>
								</form>
							</div>
							@else
							<div class="fw-bold">*Rencana tidak bisa dihapus atau diedit selama sedang diverifikasi</div>
							@endif
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection

@push('alert-verifikasi-kelompok')
@if($notifikasi['disetujui'] > 0)
<script>
	Swal.fire({
		icon: 'success',
		title: 'Yeay.. Ada Rencana Disetujui!',
		text: 'Ada {{ $notifikasi["disetujui"] }} rencana pembelajaran Anda telah disetujui.',
	});
</script>
@endif

@if($notifikasi['ditolak'] > 0)
<script>
	Swal.fire({
		icon: 'error',
		title: 'Waduh.. Ada Rencana Ditolak!',
		text: 'Ada {{ $notifikasi["ditolak"] }} rencana pembelajaran Anda ditolak. Silakan lakukan revisi.',
	});
</script>
@endif

<script>
	document.getElementById('ajukanAlert').onclick = function(event){
    event.preventDefault();
    var form = document.getElementById('ajukanForm');
    if (form.checkValidity()) {
      Swal.fire({
        title: "Konfirmasi Data",
        text: "Pastikan kembali rencana pembelajaran yang anda canangkan benar! Data rencana anda akan tidak bisa dihapus atau diedit saat dalam proses verifikasi.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ajukan",
        cancelButtonText: "Batal"
      }).then((result) => {
        if (result.isConfirmed){
          // Submit form atau aksi lain setelah konfirmasi
          form.submit();
        }
      });
    } else {
      form.reportValidity();
    }
  }
</script>

<script>
	document.getElementById('kirimRevisiAlert').onclick = function(event){
    event.preventDefault();
    var form = document.getElementById('kirimRevisiForm');
    if (form.checkValidity()) {
      Swal.fire({
        title: "Konfirmasi Data",
        text: "Pastikan kembali rencana pembelajaran sudah anda revisi dengan benar menurut catatan penolakan! Data rencana anda akan tidak bisa diedit saat dalam proses verifikasi.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ajukan",
        cancelButtonText: "Batal"
      }).then((result) => {
        if (result.isConfirmed){
          // Submit form atau aksi lain setelah konfirmasi
          form.submit();
        }
      });
    } else {
      form.reportValidity();
    }
  }
</script>


@endpush