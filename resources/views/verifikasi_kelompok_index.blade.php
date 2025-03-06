@extends('layouts.app_modern', ['title' => 'Verifikasi Rencana Pembelajaran Kelompok'])
@section('content')
<div class="card mb-4 pb-4 bg-white">
	<div class="card-body px-0 py-0">
		<div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">Rencana Pembelajaran Kelompok
			<span class="fw-bolder tw-text-blue-600">{{ Auth::user()->name }}</span>
		</div>
		<hr class="my-0">
		<ul class="nav nav-tabs mt-2 px-2" id="statusTabs">
			<li class="nav-item">
				<a class="nav-link fw-semibold" data-bs-toggle="tab" href="#disetujui">Disetujui</a>
			</li>
			<li class="nav-item">
				<a class="nav-link fw-semibold" data-bs-toggle="tab" href="#ditolak">Ditolak</a>
			</li>
			<li class="nav-item">
				<a class="nav-link fw-semibold active" data-bs-toggle="tab" href="#belumdiverifikasi">Belum Diverifikasi</a>
			</li>
		</ul>

		<div class="tab-content">
			<!-- Tab Disetujui -->
			<div class="tab-pane fade" id="disetujui">
				@include('partials.tabel_verifikasi_kelompok', ['rencana' => $rencanaDisetujui, 'status' => 'disetujui'])
			</div>

			<!-- Tab Ditolak -->
			<div class="tab-pane fade" id="ditolak">
				@include('partials.tabel_verifikasi_kelompok', ['rencana' => $rencanaDitolak, 'status' => 'ditolak'])
			</div>

			<!-- Tab Belum Diverifikasi -->
			<div class="tab-pane fade show active" id="belumdiverifikasi">
				@include('partials.tabel_verifikasi_kelompok', ['rencana' => $rencanaBelumDiverifikasi, 'status' =>
				'belumdiverifikasi'])
			</div>
		</div>
	</div>
</div>
@endsection

<script>
	document.addEventListener("DOMContentLoaded", function() {
    // Setujui
    document.querySelectorAll("[data-bs-target='#setujuiModal']").forEach(button => {
      button.addEventListener("click", function() {
        document.getElementById("setujui_rencana_id").value = this.getAttribute("data-rencana-pembelajaran");
        document.getElementById("setujui_kelompok_id").value = "{{ $kelompok->id }}";
      });
    });

    // Tolak
    document.querySelectorAll("[data-bs-target='#tolakModal']").forEach(button => {
      button.addEventListener("click", function() {
        document.getElementById("tolak_rencana_id").value = this.getAttribute("data-rencana-pembelajaran");
        document.getElementById("tolak_kelompok_id").value = "{{ $kelompok->id }}";
      });
    });
  });
</script>