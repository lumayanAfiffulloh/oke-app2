<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header bg-info bg-opacity-10">
        <h5 class="card-title mb-0 fw-bold text-info">
          <i class="ti ti-checklist me-2"></i>Progres Verifikasi Rencana Pembelajaran
        </h5>
      </div>
      <div class="card-body">
        <div class="row">
          {{-- Validasi oleh Kelompok --}}
          <div class="col-md-4">
            <div class="card shadow-none border">
              <div class="card-header bg-warning bg-opacity-10 py-2">
                <h6 class="card-title mb-0 fw-bold text-warning">
                  <i class="ti ti-affiliate me-1"></i>Validasi Kelompok
                </h6>
              </div>
              <div class="card-body">
                @if ($progresValidasi)
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small">Total: {{ $progresValidasi['total'] }} Rencana</span>
                    <span class="badge bg-primary">
                      {{ $progresValidasi['persen_disetujui'] + $progresValidasi['persen_direvisi'] }}%
                    </span>
                  </div>

                  <div class="progress mb-3" style="height:20px;">
                    <div class="progress-bar bg-success fw-bold"
                      style="width: {{ $progresValidasi['persen_disetujui'] }}%;" role="progressbar"
                      aria-valuenow="{{ $progresValidasi['persen_disetujui'] }}" aria-valuemin="0" aria-valuemax="100"
                      data-bs-toggle="tooltip"
                      title="Disetujui: {{ $progresValidasi['disetujui'] }} ({{ $progresValidasi['persen_disetujui'] }}%)">
                      {{ $progresValidasi['persen_disetujui'] }}%
                    </div>
                    <div class="progress-bar bg-warning fw-bold"
                      style="width: {{ $progresValidasi['persen_direvisi'] }}%;" role="progressbar"
                      aria-valuenow="{{ $progresValidasi['persen_direvisi'] }}" aria-valuemin="0" aria-valuemax="100"
                      data-bs-toggle="tooltip"
                      title="Direvisi: {{ $progresValidasi['direvisi'] }} ({{ $progresValidasi['persen_direvisi'] }}%)">
                      {{ $progresValidasi['persen_direvisi'] }}%
                    </div>
                    <div class="progress-bar fw-bold"
                      style="width: {{ $progresValidasi['persen_belum'] }}%; background-color:#959595 ;"
                      role="progressbar" aria-valuenow="{{ $progresValidasi['persen_belum'] }}" aria-valuemin="0"
                      aria-valuemax="100" data-bs-toggle="tooltip"
                      title="Belum: {{ $progresValidasi['belum'] }} ({{ $progresValidasi['persen_belum'] }}%)">
                      {{ $progresValidasi['persen_belum'] }}%
                    </div>
                  </div>

                  <div class="d-flex justify-content-around text-center">
                    <div>
                      <span class="d-block fw-bold text-success">{{ $progresValidasi['disetujui'] }}</span>
                      <span class="small text-muted">Disetujui</span>
                    </div>
                    <div>
                      <span class="d-block fw-bold text-warning">{{ $progresValidasi['direvisi'] }}</span>
                      <span class="small text-muted">Direvisi</span>
                    </div>
                    <div>
                      <span class="d-block fw-bold" style="color: #959595;">{{ $progresValidasi['belum'] }}</span>
                      <span class="small text-muted">Belum</span>
                    </div>
                  </div>
                @else
                  <div class="text-center py-3 text-muted">
                    <i class="ti ti-info-circle me-1"></i>Data validasi tidak tersedia
                  </div>
                @endif
              </div>
            </div>
          </div>

          {{-- Verifikasi oleh Unit Kerja --}}
          <div class="col-md-4">
            <div class="card shadow-none border">
              <div class="card-header bg-info bg-opacity-10 py-2">
                <h6 class="card-title mb-0 fw-bold text-info">
                  <i class="ti ti-building me-1"></i>Verifikasi Unit Kerja
                </h6>
              </div>
              <div class="card-body">
                @if ($progresVerifikasi)
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small">Total: {{ $progresVerifikasi['total'] }} Rencana</span>
                    <span class="badge bg-primary">
                      {{ $progresVerifikasi['persen_disetujui'] + $progresVerifikasi['persen_direvisi'] }}%
                    </span>
                  </div>

                  <div class="progress mb-3" style="height:20px;">
                    <div class="progress-bar bg-success fw-bold"
                      style="width: {{ $progresVerifikasi['persen_disetujui'] }}%;"
                      title="Disetujui: {{ $progresVerifikasi['disetujui'] }} ({{ $progresVerifikasi['persen_disetujui'] }}%)">
                      {{ $progresVerifikasi['persen_disetujui'] }}%
                    </div>
                    <div class="progress-bar bg-warning fw-bold"
                      style="width: {{ $progresVerifikasi['persen_direvisi'] }}%;"
                      title="Direvisi: {{ $progresVerifikasi['direvisi'] }} ({{ $progresVerifikasi['persen_direvisi'] }}%)">
                      {{ $progresVerifikasi['persen_direvisi'] }}%
                    </div>
                    <div class="progress-bar fw-bold"
                      style="width: {{ $progresVerifikasi['persen_belum'] }}%; background-color:#959595 ;"
                      title="Belum: {{ $progresVerifikasi['belum'] }} ({{ $progresVerifikasi['persen_belum'] }}%)">
                      {{ $progresVerifikasi['persen_belum'] }}%
                    </div>
                  </div>

                  <div class="d-flex justify-content-around text-center">
                    <div>
                      <span class="d-block fw-bold text-success">{{ $progresVerifikasi['disetujui'] }}</span>
                      <span class="small text-muted">Disetujui</span>
                    </div>
                    <div>
                      <span class="d-block fw-bold text-warning">{{ $progresVerifikasi['direvisi'] }}</span>
                      <span class="small text-muted">Direvisi</span>
                    </div>
                    <div>
                      <span class="d-block fw-bold" style="color: #959595;">{{ $progresVerifikasi['belum'] }}</span>
                      <span class="small text-muted">Belum</span>
                    </div>
                  </div>
                @else
                  <div class="text-center py-3 text-muted">
                    <i class="ti ti-info-circle me-1"></i>Data verifikasi tidak tersedia
                  </div>
                @endif
              </div>
            </div>
          </div>

          {{-- Approval oleh Universitas --}}
          <div class="col-md-4">
            <div class="card shadow-none border">
              <div class="card-header bg-success bg-opacity-10 py-2">
                <h6 class="card-title mb-0 fw-bold text-success">
                  <i class="ti ti-school me-1"></i>Approval Universitas
                </h6>
              </div>
              <div class="card-body">
                @if ($progresApproval)
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small">Total: {{ $progresApproval['total'] }} Rencana</span>
                    <span class="badge bg-primary">
                      {{ $progresApproval['persen_disetujui'] + $progresApproval['persen_ditolak'] }}%
                    </span>
                  </div>

                  <div class="progress mb-3" style="height:20px;">
                    <div class="progress-bar bg-success fw-bold"
                      style="width: {{ $progresApproval['persen_disetujui'] }}%;"
                      title="Disetujui: {{ $progresApproval['disetujui'] }} ({{ $progresApproval['persen_disetujui'] }}%)">
                      {{ $progresApproval['persen_disetujui'] }}%
                    </div>
                    <div class="progress-bar bg-danger fw-bold"
                      style="width: {{ $progresApproval['persen_ditolak'] }}%"
                      title="Ditolak: {{ $progresApproval['ditolak'] }} ({{ $progresApproval['persen_ditolak'] }}%)">
                      {{ $progresApproval['persen_ditolak'] }}%
                    </div>
                    <div class="progress-bar fw-bold"
                      style="width: {{ $progresApproval['persen_belum'] }}%; background-color:#959595 ;"
                      title="Belum: {{ $progresApproval['belum'] }} ({{ $progresApproval['persen_belum'] }}%)">
                      {{ $progresApproval['persen_belum'] }}%
                    </div>
                  </div>

                  <div class="d-flex justify-content-around text-center">
                    <div>
                      <span class="d-block fw-bold text-success">{{ $progresApproval['disetujui'] }}</span>
                      <span class="small text-muted">Disetujui</span>
                    </div>
                    <div>
                      <span class="d-block fw-bold text-danger">{{ $progresApproval['ditolak'] }}</span>
                      <span class="small text-muted">Ditolak</span>
                    </div>
                    <div>
                      <span class="d-block fw-bold" style="color: #959595;">{{ $progresApproval['belum'] }}</span>
                      <span class="small text-muted">Belum</span>
                    </div>
                  </div>
                @else
                  <div class="text-center py-3 text-muted">
                    <i class="ti ti-info-circle me-1"></i>Data approval tidak tersedia
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>

        {{-- Ringkasan Keseluruhan --}}
        <div class="row">
          <div class="col-12">
            <div class="card shadow-none border bg-light mb-0">
              <div class="card-body py-2">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <span class="fw-bold">Total Rencana Pembelajaran: </span>
                    <span class="badge bg-primary">{{ $dataPegawai->rencanaPembelajaran->count() }}</span>
                  </div>
                  <div class="text-end">
                    <small class="text-muted">Terakhir diperbarui: {{ now()->format('d M Y H:i') }}</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
