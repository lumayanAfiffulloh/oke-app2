<div class="col">
  <div class="card">
    <div class="card-body p-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bolder m-0">
          <i class="ti ti-calendar-time me-2"></i>Jadwal Verifikasi
        </h5>
        <span class="badge bg-primary bg-opacity-10 text-primary">
          <i class="ti ti-user me-1"></i>Verifikator
        </span>
      </div>
      <hr class="mb-2">

      @if($jadwalVerifikasi)
      <div class="timeline-wrapper mb-4">
        <div class="d-flex align-items-center mb-2">
          <div class="badge bg-primary rounded-circle p-2 me-3">
            <i class="ti ti-player-play"></i>
          </div>
          <div>
            <h6 class="mb-0">Mulai Verifikasi</h6>
            <small class="text-muted">{{ $jadwalVerifikasi['waktuMulai']->translatedFormat('d F Y, H:i') }}</small>
          </div>
        </div>

        <div class="d-flex align-items-center">
          <div class="badge bg-danger rounded-circle p-2 me-3">
            <i class="ti ti-flag"></i>
          </div>
          <div>
            <h6 class="mb-0">Batas Akhir</h6>
            <small class="text-muted">{{ $jadwalVerifikasi['waktuSelesai']->translatedFormat('d F Y, H:i') }}</small>
          </div>
        </div>
      </div>

      {{-- Progress Bar & Countdown --}}
      <div class="mb-3">
        @if ($jadwalVerifikasi['isActive'])
        @php
        $totalDuration = $jadwalVerifikasi['waktuMulai']->diffInSeconds($jadwalVerifikasi['waktuSelesai']);
        $elapsedDuration = Carbon\Carbon::now()->diffInSeconds($jadwalVerifikasi['waktuMulai']);
        $progressPercentage = min(100, max(0, ($elapsedDuration / $totalDuration) * 100));
        @endphp

        <div class="d-flex justify-content-between mb-2">
          <span class="text-success fw-semibold">
            <i class="ti ti-clock me-1"></i> Sisa: {{ $jadwalVerifikasi['sisaHari'] }} hari
          </span>
          <span class="text-primary">{{ round($progressPercentage) }}%</span>
        </div>
        <div class="progress" style="height: 8px;">
          <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"
            style="width: {{ $progressPercentage }}%">
          </div>
        </div>
        @else
        <div class="alert alert-{{ $jadwalVerifikasi['sisaHari'] > 0 ? 'info' : 'danger' }} py-2 mb-0">
          <i class="ti ti-{{ $jadwalVerifikasi['sisaHari'] > 0 ? 'clock' : 'alert-circle' }} me-2"></i>
          {{ $jadwalVerifikasi['sisaHari'] > 0 ? 'Perencanaan belum dimulai' : 'Tenggat waktu telah berakhir!' }}
        </div>
        @endif
      </div>

      {{-- Tombol Aksi --}}
      <div class="d-grid gap-0">
        @if ($jadwalVerifikasi['isActive'])
        <a href="{{ route('rencana_pembelajaran.create') }}" class="btn btn-success">
          <i class="ti ti-pencil me-2"></i> Verifikasi Rencana Sekarang
        </a>
        <a href="#" class="btn btn-outline-primary mt-2">
          <i class="ti ti-info-circle me-2"></i> Panduan Penyusunan
        </a>
        @else
        <button class="btn btn-dark btn-lg d-flex align-items-center justify-content-center" disabled>
          <i class="ti ti-lock me-2 fs-4"></i>
          <span class="fs-3">{{ $jadwalVerifikasi['sisaHari'] > 0 ? 'Waktu verifikasi belum dimulai' : 'Masa verifikasi
            telah berakhir!' }}</span>
        </button>
        @endif
      </div>
      @else
      <div class="alert alert-warning d-flex align-items-center">
        <i class="ti ti-alert-triangle me-3 fs-4"></i>
        <div>
          <h6 class="mb-1">Tenggat waktu belum ditetapkan</h6>
          <small class="m-0">Silakan hubungi admin untuk mengatur jadwal perencanaan</small>
        </div>
      </div>
      @endif
    </div>
  </div>
</div>