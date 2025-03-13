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
						<th class="align-middle" colspan="3">validasi & Validasi</th>
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

						{{-- TAHUN DAN KODE --}}
						<td class="px-2 text-center">{{ $rencana->tahun }}
							@if ($rencana->klasifikasi == 'pelatihan')
							<br> <span class="fw-semibold">{{ ucwords($rencana->dataPelatihan->kode) }}</span>
							@endif
						</td>

						{{-- BENTUK --}}
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

						{{-- KEGIATAN --}}
						<td class="px-2">
							@if($rencana->klasifikasi == 'pelatihan')
							<span class="fw-semibold">Nama Pelatihan: </span><br>
							{{ $rencana->dataPelatihan->nama_pelatihan ?? '-' }}
							@else
							<span class="fw-semibold">Jurusan: </span><br>
							{{ $rencana->dataPendidikan->jurusan ?? '-' }}
							@endif
						</td>

						{{-- VERIFIKASI DAN VALIDASI--}}

						{{-- Validasi Kelompok --}}
						<td class="px-2">
							@if($rencana->kelompokCanValidating)
							@if($rencana->kelompokCanValidating->status == 'disetujui')
							<span class="badge text-bg-success" style="font-size: 0.7rem">Disetujui</span>
							@elseif($rencana->kelompokCanValidating->status == 'direvisi')
							<span class="badge text-bg-warning" style="font-size: 0.7rem">Perlu Revisi</span>
							@endif
							<br>
							@if ($rencana->kelompokCanValidating->catatanValidasiKelompok->count() > 0)
							<span class="fw-semibold">Catatan:</span>
							<ul>
								@foreach ($rencana->kelompokCanValidating->catatanValidasiKelompok as $catatan)
								<li>{{ $catatan->catatan }}</li>
								@endforeach
							</ul>
							@endif
							@else
							<span style="font-size: 0.7rem">-</span>
							@endif
						</td>

						{{-- validasi Satker --}}
						<td class="px-2">-</td>

						{{-- validasi Biro SDM --}}
						<td class="px-2">-</td>

						{{-- RENCANA --}}
						<td class="px-2">
							<span class="fw-semibold">Region: </span>{{ ucwords($rencana->region->region) ?? '-' }} <br>
							<span class="fw-semibold">JP: </span>{{ $rencana->jam_pelajaran }} JP <br>
							<span class="fw-semibold">Anggaran: </span>Rp{{ number_format($rencana->anggaran_rencana, 0, ',', '.') }}
						</td>

						{{-- KETERANGAN --}}
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

						{{-- AKSI --}}
						<td class="px-2">
							@if($rencana->kelompokCanValidating)
							@if($rencana->kelompokCanValidating->status == 'disetujui')
							<div class="fw-bold">*Rencana yang disetujui tidak bisa dihapus atau diedit</div>
							@else
							@if($rencana->kelompokCanValidating->status_revisi != 'sudah_direvisi')
							<div class="btn-group" role="group">
								{{-- Revisi --}}
								<a href="/rencana_pembelajaran/{{ $rencana->id }}/edit" class="btn btn-warning btn-sm"
									style="font-size: 0.8rem" title="Revisi"><span class="ti ti-scissors"></span></a>

								{{-- Kirim Revisi --}}
								<form action="{{ route('rencana_pembelajaran.kirim_revisi', $rencana->id) }}" method="POST"
									id="kirimRevisiForm-{{ $rencana->id }}">
									@csrf
									<button type="submit" class="btn btn-success btn-sm rounded-end-1 kirimRevisiAlert"
										data-form-id="kirimRevisiForm-{{ $rencana->id }}" style="font-size: 0.8rem; border-radius: 0"
										title="Kirim Revisi">
										<span class="ti ti-script"></span>
									</button>
								</form>
							</div>
							@else
							<div class="fw-bold">*Rencana yang sudah dikirim revisinya tidak bisa diedit.</div>
							@endif
							@if($rencana->kelompokCanValidating->status_revisi)
							<br>
							<span class="fw-semibold">Status Revisi:</span>
							<span
								class="badge {{ $rencana->kelompokCanValidating->status_revisi == 'belum_direvisi' ? 'text-bg-danger' : ($rencana->kelompokCanValidating->status_revisi == 'sedang_direvisi' ? 'text-bg-warning' : 'text-bg-success') }} fs-1">
								{{ $rencana->kelompokCanValidating->status_revisi == 'sedang_direvisi' ? 'Revisi perlu dikirim' :
								ucwords(str_replace("_", " ", $rencana->kelompokCanValidating->status_revisi)) }}
							</span>
							@endif
							@endif
							@elseif($rencana->status_pengajuan === 'draft')
							<div class="btn-group" role="group">
								{{-- Tombol Edit --}}
								<a href="/rencana_pembelajaran/{{ $rencana->id }}/edit" class="btn btn-warning btn-sm"
									style="font-size: 0.8rem" title="Edit"><span class="ti ti-pencil"></span></a>

								{{-- Tombol Hapus --}}
								<form action="/rencana_pembelajaran/{{ $rencana->id }}" method="POST" class="d-inline deleteForm">
									@csrf
									@method('delete')
									<button type="submit" class="btn btn-danger btn-sm deleteAlert"
										style="font-size: 0.8rem; border-radius: 0" title="Hapus">
										<span class="ti ti-trash"></span>
									</button>
								</form>

								{{-- Tombol Ajukan --}}
								<form action="{{ route('rencana.ajukan', $rencana->id) }}" method="POST"
									id="ajukanForm-{{ $rencana->id }}">
									@csrf
									<button type="submit" class="btn btn-success btn-sm rounded-end-1 ajukanAlert"
										style="font-size: 0.8rem; border-radius: 0" title="Ajukan validasi"
										data-form-id="ajukanForm-{{ $rencana->id }}">
										<span class="ti ti-check"></span>
									</button>
								</form>
							</div>
							@else
							<div class="fw-bold">*Rencana tidak bisa dihapus atau diedit selama sedang divalidasi</div>
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

@push('alert-validasi-kelompok')
@if($notifikasi['disetujui'] > 0)
<script>
	Swal.fire({
		icon: 'success',
		title: 'Yeay.. Ada Rencana Disetujui!',
		text: 'Ada {{ $notifikasi["disetujui"] }} rencana pembelajaran Anda telah disetujui.',
	});
</script>
@endif
@if($notifikasi['direvisi'] > 0)
<script>
	Swal.fire({
		icon: 'warning',
		title: 'Waduh.. Ada Rencana yang Perlu Revisi!',
		text: 'Ada {{ $notifikasi["direvisi"] }} rencana pembelajaran Anda diberi revisi. Silakan lakukan revisi.',
	});
</script>
@endif

<script>
	document.querySelectorAll('.ajukanAlert').forEach(button => {
    button.addEventListener('click', event => {
      event.preventDefault();
      let formId = button.getAttribute('data-form-id');
      Swal.fire({
        title: "Konfirmasi Data",
        text: "Data rencana anda akan tidak bisa dihapus atau diedit saat dalam proses validasi!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#13DEB9",
        confirmButtonText: "Ajukan",
        cancelButtonText: "Batal"
      }).then(result => {
        if (result.isConfirmed) {
          document.getElementById(formId).submit();
        }
      });
    });
  });
</script>

<script>
	document.querySelectorAll('.kirimRevisiAlert').forEach(button => {
    button.addEventListener('click', event => {
      event.preventDefault();

      let formId = button.getAttribute('data-form-id');
      let row = button.closest('tr');
      let statusRevisiElement = row.querySelector('.badge.text-bg-danger');

      if (statusRevisiElement && statusRevisiElement.textContent.trim() === 'Belum Direvisi') {
        Swal.fire({
          title: "Pengiriman Diblokir!",
          text: "Anda tidak dapat mengirim revisi sebelum melakukan perubahan.",
          icon: "error",
          confirmButtonColor: "#FA896B",
          confirmButtonText: "MENGERTI"
        });
      } else {
        Swal.fire({
          title: "Konfirmasi Pengiriman",
          text: "Setelah dikirim, revisi tidak dapat diubah atau dihapus.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#13DEB9",
          confirmButtonText: "Kirim",
          cancelButtonText: "Batal"
        }).then(result => {
          if (result.isConfirmed) {
            document.getElementById(formId).submit();
          }
        });
      }
    });
  });
</script>


@endpush