@extends('layouts.main_layout', ['title' => 'Approval Rencana Pembelajaran - Universitas'])
@section('content')
  <div class="container-fluid px-3">
    <!-- Page Header dengan Informasi Penting -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="mb-1">Approval Rencana Pembelajaran</h2>
        <div class="d-flex align-items-center gap-2">
          <span class="badge bg-primary bg-opacity-10 text-primary">
            <i class="ti ti-user me-1"></i> {{ $namaPegawai }}
          </span>
          <span class="badge bg-secondary bg-opacity-10 text-secondary">
            <i class="ti ti-building-community me-1"></i> Level: Universitas
          </span>
        </div>
      </div>

      <!-- Alert Deadline -->
      @if (!$isDeadlineSet)
        <!-- Alert ketika deadline belum diset admin -->
        <div class="d-flex align-items-center px-3 py-2 rounded"
          style="background-color: #fff3e0; border-left: 4px solid #ff9800;">
          <i class="ti ti-alert-triangle me-2" style="color: #ff9800;"></i>
          <div>
            <div class="fw-semibold" style="font-size: 0.85rem; color: #ff9800;">
              Tenggat Belum Ditetapkan
            </div>
            <div style="font-size: 0.8rem; color: #e65100;">
              Admin belum menetapkan periode approval
            </div>
          </div>
        </div>
      @elseif($isNotStartedYet)
        <!-- Alert ketika tenggat sudah ditetapkan tapi belum mulai -->
        <div class="d-flex align-items-center px-3 py-2 rounded"
          style="background-color: #e3f2fd; border-left: 4px solid #2196f3;">
          <i class="ti ti-clock me-2" style="color: #2196f3;"></i>
          <div>
            <div class="fw-semibold" style="font-size: 0.85rem; color: #2196f3;">
              Periode Approval Akan Dimulai
            </div>
            <div style="font-size: 0.8rem; color: #0d47a1;">
              Mulai: {{ $startDate->isoFormat('dddd, D MMMM YYYY [pukul] HH:mm') }}
              @if ($daysUntilStart > 0)
                ({{ floor($daysUntilStart) }} hari lagi)
              @else
                (Segera)
              @endif
            </div>
          </div>
        </div>
      @elseif($isWithinDeadline)
        <!-- Alert deadline normal -->
        <div class="d-flex align-items-center px-3 py-2 rounded"
          style="background-color: #e8f5e9; border-left: 4px solid #4caf50;">
          <i class="ti ti-calendar me-2" style="color: #4caf50;"></i>
          <div>
            <div class="fw-semibold" style="font-size: 0.85rem; color: #4caf50;">
              Batas Approval:
            </div>
            <div style="font-size: 0.8rem; color: #2e7d32;">
              {{ $endDate->isoFormat('dddd, D MMMM YYYY [pukul] HH:mm') }}
            </div>
          </div>
        </div>
      @else
        <!-- Alert deadline telah berakhir -->
        <div class="d-flex align-items-center px-3 py-2 rounded"
          style="background-color: #ffebee; border-left: 4px solid #f44336;">
          <i class="ti ti-alert-circle me-2" style="color: #f44336;"></i>
          <div>
            <div class="fw-semibold" style="font-size: 0.85rem; color: #f44336;">
              Masa Approval Telah Berakhir
            </div>
            <div style="font-size: 0.8rem; color: #c62828;">
              Batas akhir: {{ $endDate->isoFormat('dddd, D MMMM YYYY [pukul] HH:mm') }}
            </div>
          </div>
        </div>
      @endif
    </div>

    <!-- Statistik Ringkas -->
    <div class="row mb-3">
      <div class="col-md-3">
        <div class="card mb-1 shadow-none border">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h5 class="text-muted mb-2">Total Unit Kerja</h5>
                <h3 class="mb-0">{{ $unitKerjasData->count() }}</h3>
              </div>
              <div class="bg-primary bg-opacity-10 p-3 rounded">
                <i class="ti ti-building-community text-primary" style="font-size: 1.5rem"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card mb-1 shadow-none border">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h5 class="text-muted mb-2">Total Rencana</h5>
                <h3 class="mb-0">{{ $unitKerjasData->sum('totalRencana') }}</h3>
              </div>
              <div class="bg-info bg-opacity-10 p-3 rounded">
                <i class="ti ti-list text-info" style="font-size: 1.5rem"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card mb-1 shadow-none border">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h5 class="text-muted mb-2">Disetujui</h5>
                <h3 class="mb-0">{{ $unitKerjasData->sum(fn($u) => $u['rencanaDisetujui']->count()) }}</h3>
              </div>
              <div class="bg-success bg-opacity-10 p-3 rounded">
                <i class="ti ti-circle-check text-success" style="font-size: 1.5rem"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card mb-1 shadow-none border">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h5 class="text-muted mb-2">Ditolak</h5>
                <h3 class="mb-0">{{ $unitKerjasData->sum(fn($u) => $u['rencanaDitolak']->count()) }}</h3>
              </div>
              <div class="bg-danger bg-opacity-10 p-3 rounded">
                <i class="ti ti-x text-danger" style="font-size: 1.5rem"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Card Daftar --}}
    <div class="card mb-4 pb-2 bg-white">
      <div class="card-header p-3 fs-5 fw-bolder bg-white">
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="mb-0 fw-semibold">Daftar Rencana per Unit Kerja</h5>
          <div class="input-group input-group-sm" style="width: 25%">
            <input type="text" class="form-control form-control-sm" placeholder="Cari..." aria-label="Cari"
              aria-describedby="button-addon2">
            <button class="btn btn-outline-dark" style="opacity: 15%" type="button" id="button-addon2"><i
                class="ti ti-search"></i></button>
          </div>
        </div>
      </div>
      <hr class="mt-0 mb-1 text-body-tertiary">

      <div class="card-body p-3">
        @if ($unitKerjasData->isEmpty())
          <div class="alert alert-warning">
            Tidak ada data unit kerja atau rencana pembelajaran yang perlu diapprove.
          </div>
        @else
          <div class="accordion" id="unitKerjaAccordion">
            @foreach ($unitKerjasData as $index => $unitData)
              <div class="accordion-item" data-key="{{ $index }}">
                <div class="accordion-header" id="heading-{{ $unitData['unit_kerja']->id }}">
                  <button class="accordion-button bg-white shadow-none collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse-{{ $unitData['unit_kerja']->id }}"
                    aria-expanded="true" aria-controls="collapse-{{ $unitData['unit_kerja']->id }}">
                    <span class="fw-semibold fs-5">
                      Unit Kerja: {{ $unitData['unit_kerja']->unit_kerja }}
                    </span>
                    <span class="badge bg-primary ms-2 fs-2">
                      {{ $unitData['totalRencana'] }} Rencana
                    </span>
                  </button>
                </div>

                <div id="collapse-{{ $unitData['unit_kerja']->id }}" class="accordion-collapse collapse"
                  data-bs-parent="#unitKerjaAccordion" aria-labelledby="heading-{{ $unitData['unit_kerja']->id }}">
                  <div class="accordion-body p-0 pt-3">
                    <ul class="nav nav-tabs px-3" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-semibold" data-bs-toggle="tab"
                          data-bs-target="#belumdiapprove-{{ $unitData['unit_kerja']->id }}" type="button"
                          role="tab">
                          Belum Diapprove
                          <span
                            class="badge bg-warning ms-1 fs-1">{{ $unitData['rencanaBelumDiapprove']->count() }}</span>
                        </button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold" data-bs-toggle="tab"
                          data-bs-target="#ditolak-{{ $unitData['unit_kerja']->id }}" type="button" role="tab">
                          Ditolak
                          <span class="badge bg-danger ms-1 fs-1">{{ $unitData['rencanaDitolak']->count() }}</span>
                        </button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold" data-bs-toggle="tab"
                          data-bs-target="#disetujui-{{ $unitData['unit_kerja']->id }}" type="button" role="tab">
                          Disetujui
                          <span class="badge bg-success ms-1 fs-1">{{ $unitData['rencanaDisetujui']->count() }}</span>
                        </button>
                      </li>
                    </ul>

                    <div class="tab-content p-2 px-0">
                      <!-- Tab Belum Diapprove -->
                      <div class="tab-pane fade show active" id="belumdiapprove-{{ $unitData['unit_kerja']->id }}"
                        role="tabpanel">
                        @if ($unitData['rencanaBelumDiapprove']->isEmpty())
                          @if ($unitData['rencanaDisetujui']->count() + $unitData['rencanaDitolak']->count() > 0)
                            <div class="alert alert-success m-2 mx-3">
                              <i class="ti ti-circle-check me-2"></i>Semua rencana pembelajaran telah diapprove
                            </div>
                          @else
                            <div class="alert alert-info m-2 mx-3">
                              <i class="ti ti-info-circle me-2"></i>Tidak ada rencana yang belum diapprove
                            </div>
                          @endif
                        @else
                          @include('partials.tabel_belum_approval', ['unitData' => $unitData])
                        @endif
                      </div>

                      <!-- Tab Ditolak -->
                      <div class="tab-pane fade" id="ditolak-{{ $unitData['unit_kerja']->id }}" role="tabpanel">
                        @if ($unitData['rencanaDitolak']->isEmpty())
                          <div class="alert alert-info m-2">
                            <i class="ti ti-info-circle me-2"></i>Tidak ada rencana yang ditolak
                          </div>
                        @else
                          @include('partials.tabel_ditolak_approval', [
                              'rencana' => $unitData['rencanaDitolak'],
                              'unitKerja' => $unitData['unit_kerja'],
                          ])
                        @endif
                      </div>

                      <!-- Tab Disetujui -->
                      <div class="tab-pane fade" id="disetujui-{{ $unitData['unit_kerja']->id }}" role="tabpanel">
                        @if ($unitData['rencanaDisetujui']->isEmpty())
                          <div class="alert alert-info m-2 mx-3">
                            <i class="ti ti-info-circle me-2"></i>Tidak ada rencana yang disetujui
                          </div>
                        @else
                          @include('partials.tabel_disetujui_approval', [
                              'rencana' => $unitData['rencanaDisetujui'],
                              'unitKerja' => $unitData['unit_kerja'],
                          ])
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection
