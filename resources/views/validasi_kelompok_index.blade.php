@extends('layouts.main_layout', ['title' => 'Validasi Rencana Pembelajaran Kelompok'])
@section('content')
  <div class="card mb-4 pb-4 bg-white">
    <div class="card-body px-0 py-0">
      <div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">Rencana Pembelajaran Kelompok
        <span class="fw-bolder text-primary">{{ Auth::user()->name }}</span>
      </div>
      <hr class="my-0">
      <ul class="nav nav-tabs mt-2 px-2" id="statusTabs">
        <li class="nav-item">
          <a class="nav-link fw-semibold active" data-bs-toggle="tab" href="#belumdivalidasi">
            Belum Divalidasi
            <span class="badge bg-danger ms-1 fs-1">{{ $rencanaBelumDivalidasi->count() }}</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#disetujui">
            Disetujui
            <span class="badge bg-success ms-1 fs-1">{{ $rencanaDisetujui->count() }}</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#direvisi">
            Revisi
            <span class="badge bg-warning ms-1 fs-1">{{ $rencanaDirevisi->count() }}</span>
          </a>
        </li>
      </ul>

      <div class="tab-content">
        <!-- Tab Belum Divalidasi -->
        <div class="tab-pane fade show active" id="belumdivalidasi">
          @include('partials.tabel_belum_kelompok', ['rencana' => $rencanaBelumDivalidasi])
        </div>

        <!-- Tab Disetujui -->
        <div class="tab-pane fade" id="disetujui">
          @include('partials.tabel_disetujui_kelompok', ['rencana' => $rencanaDisetujui])
        </div>

        <!-- Tab Ditolak -->
        <div class="tab-pane fade" id="direvisi">
          @include('partials.tabel_direvisi_kelompok', ['rencana' => $rencanaDirevisi])
        </div>
      </div>
    </div>
  </div>
@endsection
