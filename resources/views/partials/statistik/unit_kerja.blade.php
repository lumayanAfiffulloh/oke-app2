{{-- ROW 5: STATISTIK KHUSUS VERIFIKATOR UNIT KERJA --}}
@if ($statistikVerifikasiUnit)
  <div class="row">
    <div class="col-12">
      <div class="card mb-1">
        <div class="card-header bg-info bg-opacity-10">
          <h5 class="card-title mb-0 fw-bold text-info">
            <i class="ti ti-building me-2"></i>Statistik Verifikasi Unit Kerja:
            {{ $statistikVerifikasiUnit['unit_kerja'] }}
          </h5>
        </div>
        <div class="card-body">
          {{-- Ringkasan Statistik --}}
          <div class="row mb-2">
            <div class="col-md-3 col-sm-6 mb-3">
              <div class="bg-light rounded p-3 text-center border">
                <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-flex mb-2">
                  <i class="ti ti-users text-primary fs-3"></i>
                </div>
                <h4 class="fw-bold mb-0">{{ $statistikVerifikasiUnit['jumlah_pegawai'] }}</h4>
                <p class="text-muted mb-0">Pegawai di Unit Kerja</p>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
              <div class="bg-light rounded p-3 text-center border">
                <div class="bg-success bg-opacity-10 rounded-circle p-3 d-inline-flex mb-2">
                  <i class="ti ti-checklist text-success fs-3"></i>
                </div>
                <h4 class="fw-bold mb-0">{{ $statistikVerifikasiUnit['total'] }}</h4>
                <p class="text-muted mb-0">Total Rencana Tervalidasi</p>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
              <div class="bg-light rounded p-3 text-center border">
                <div class="bg-warning bg-opacity-10 rounded-circle p-3 d-inline-flex mb-2">
                  <i class="ti ti-chart-bar text-warning fs-3"></i>
                </div>
                <h4 class="fw-bold mb-0">{{ $statistikVerifikasiUnit['rencana_per_pegawai'] }}</h4>
                <p class="text-muted mb-0">Rata-rata per Pegawai</p>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
              <div class="bg-light rounded p-3 text-center border">
                <div class="bg-info bg-opacity-10 rounded-circle p-3 d-inline-flex mb-2">
                  <i class="ti ti-cash text-info fs-3"></i>
                </div>
                <h4 class="fw-bold mb-0">Rp {{ number_format($statistikVerifikasiUnit['total_anggaran'], 0, ',', '.') }}
                </h4>
                <p class="text-muted mb-0">Total Anggaran</p>
              </div>
            </div>
          </div>

          {{-- Progress Verifikasi --}}
          <div class="row mb-2 d-flex align-items-stretch">
            <div class="col-md-8 d-flex">
              {{-- Chart Distribusi per Kelompok --}}
              <div class="card w-100 shadow-none border mb-3">
                <div class="card-header bg-warning bg-opacity-10">
                  <h6 class="card-title mb-0 fw-bold text-warning">
                    <i class="ti ti-chart-bar me-1"></i>Distribusi Verifikasi Rencana per Kelompok
                  </h6>
                </div>
                <div class="card-body">
                  <canvas id="kelompokChart" height="250"></canvas>
                </div>
              </div>
            </div>

            {{-- DISTRIBUSI JENIS KEGIATAN --}}
            <div class="col-md-4 d-flex">
              <div class="card w-100 shadow-none border mb-3">
                <div class="card-header bg-info bg-opacity-10">
                  <h6 class="card-title mb-0 fw-bold text-info">
                    <i class="ti ti-chart-pie me-1"></i>Distribusi Jenis Kegiatan
                  </h6>
                </div>
                <div class="card-body">
                  <canvas id="jenisKegiatanChart" height="250"></canvas>
                  <div class="mt-4">
                    <h6 class="fw-semibold mb-3">Rincian Statistik Verifikasi Unit</h6>

                    @php
                      $totalStatistik = $statistikVerifikasiUnit['rencana_per_jenis']->sum('jumlah');
                      $totalJamPelajaran = $statistikVerifikasiUnit['total_jam_pelajaran'];
                    @endphp

                    @foreach ($statistikVerifikasiUnit['rencana_per_jenis'] as $jenis => $item)
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center">
                          <span class="badge rounded-circle p-2 me-2"
                            style="background-color: {{ $loop->first ? 'rgba(54, 162, 235, 0.7)' : 'rgba(255, 99, 132, 0.7)' }}; width: 12px; height: 12px;"></span>
                          <span class="small">{{ $jenis }}</span>
                        </div>
                        <div>
                          <span class="fw-medium">{{ $item['jumlah'] }} ({{ $item['jam_pelajaran'] }} jam)</span>
                          <span class="text-muted ms-1 small">
                            ({{ $statistikVerifikasiUnit['total'] > 0 ? number_format(($item['jumlah'] / $statistikVerifikasiUnit['total']) * 100, 1) : 0 }}%)
                          </span>
                        </div>
                      </div>
                    @endforeach

                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-center">
                      <span class="fw-semibold">Total</span>
                      <span class="fw-bold text-primary">
                        {{ $statistikVerifikasiUnit['total'] }}
                        ({{ $statistikVerifikasiUnit['rencana_per_jenis']->sum('jam_pelajaran') }} jam)
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Tabel Rincian per Kelompok --}}
          <div class="card shadow-none border mb-4">
            <div class="card-header bg-success bg-opacity-10">
              <h6 class="card-title mb-0 fw-bold text-success">
                <i class="ti ti-table me-1"></i>Rincian Verifikasi per Kelompok
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Kelompok</th>
                      <th>Total Rencana</th>
                      <th>Disetujui</th>
                      <th>Direvisi</th>
                      <th>Belum</th>
                      <th>Progress</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($statistikVerifikasiUnit['rencana_per_kelompok'] as $kelompok => $data)
                      @php
                        $total = $data['jumlah'];
                        $disetujui = $data['disetujui'];
                        $direvisi = $data['direvisi'];
                        $belum = $data['belum'];
                        $persentase = $total > 0 ? round((($disetujui + $direvisi) / $total) * 100, 1) : 0;
                      @endphp
                      <tr>
                        <td class="fw-medium">{{ $kelompok ?? 'Tidak dikelompokkan' }}</td>
                        <td><span class="badge bg-primary">{{ $total }}</span></td>
                        <td><span class="badge bg-success">{{ $disetujui }}</span></td>
                        <td><span class="badge bg-warning">{{ $direvisi }}</span></td>
                        <td><span class="badge bg-secondary">{{ $belum }}</span></td>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="progress flex-grow-1 me-2" style="height: 8px;">
                              <div class="progress-bar" role="progressbar"
                                style="width: {{ $persentase }}%; background-color: {{ $persentase == 100 ? '#198754' : '#0d6efd' }};"
                                aria-valuenow="{{ $persentase }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted">{{ $persentase }}%</small>
                          </div>
                        </td>
                        <td>
                          <a href="{{ route('verifikasi.index', $kelompok) }}" class="btn btn-sm btn-outline-primary">
                            <i class="ti ti-eye me-1"></i>Detail
                          </a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          {{-- Progres Verifikasi Unit Kerja --}}
          <div class="card h-100 shadow-none border mb-1">
            <div class="card-header bg-primary bg-opacity-10">
              <h6 class="card-title mb-0 fw-bold text-primary">
                <i class="ti ti-circle-check me-1"></i>Progress Verifikasi Unit Kerja
              </h6>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Total: {{ $statistikVerifikasiUnit['total'] }} Rencana</span>
                <span
                  class="badge bg-primary">{{ $statistikVerifikasiUnit['persen_disetujui'] + $statistikVerifikasiUnit['persen_direvisi'] }}%
                  Terverifikasi</span>
              </div>

              <div class="progress mb-4" style="height: 25px;">
                <div class="progress-bar bg-success fw-bold"
                  style="width: {{ $statistikVerifikasiUnit['persen_disetujui'] }}%;" role="progressbar"
                  aria-valuenow="{{ $statistikVerifikasiUnit['persen_disetujui'] }}" aria-valuemin="0"
                  aria-valuemax="100" data-bs-toggle="tooltip"
                  title="Disetujui: {{ $statistikVerifikasiUnit['disetujui'] }} ({{ $statistikVerifikasiUnit['persen_disetujui'] }}%)">
                  {{ $statistikVerifikasiUnit['persen_disetujui'] }}%
                </div>
                <div class="progress-bar bg-warning fw-bold"
                  style="width: {{ $statistikVerifikasiUnit['persen_direvisi'] }}%;" role="progressbar"
                  aria-valuenow="{{ $statistikVerifikasiUnit['persen_direvisi'] }}" aria-valuemin="0"
                  aria-valuemax="100" data-bs-toggle="tooltip"
                  title="Direvisi: {{ $statistikVerifikasiUnit['direvisi'] }} ({{ $statistikVerifikasiUnit['persen_direvisi'] }}%)">
                  {{ $statistikVerifikasiUnit['persen_direvisi'] }}%
                </div>
                <div class="progress-bar fw-bold"
                  style="width: {{ $statistikVerifikasiUnit['persen_belum'] }}%; background-color: #959595;"
                  role="progressbar" aria-valuenow="{{ $statistikVerifikasiUnit['persen_belum'] }}"
                  aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip"
                  title="Belum: {{ $statistikVerifikasiUnit['belum'] }} ({{ $statistikVerifikasiUnit['persen_belum'] }}%)">
                  {{ $statistikVerifikasiUnit['persen_belum'] }}%
                </div>
              </div>

              <div class="row text-center">
                <div class="col-md-4 mb-2">
                  <div class="border rounded p-3 bg-success bg-opacity-10">
                    <h3 class="fw-bold text-success mb-1">{{ $statistikVerifikasiUnit['disetujui'] }}</h3>
                    <p class="mb-0 small text-muted">Disetujui</p>
                    <p class="mb-0 small text-success fw-medium">Rp
                      {{ number_format($statistikVerifikasiUnit['anggaran_disetujui'], 0, ',', '.') }}</p>
                  </div>
                </div>
                <div class="col-md-4 mb-2">
                  <div class="border rounded p-3 bg-warning bg-opacity-10">
                    <h3 class="fw-bold text-warning mb-1">{{ $statistikVerifikasiUnit['direvisi'] }}</h3>
                    <p class="mb-0 small text-muted">Direvisi</p>
                    <p class="mb-0 small text-warning fw-medium">Rp
                      {{ number_format($statistikVerifikasiUnit['anggaran_direvisi'], 0, ',', '.') }}</p>
                  </div>
                </div>
                <div class="col-md-4 mb-2">
                  <div class="border rounded p-3 bg-secondary bg-opacity-10">
                    <h3 class="fw-bold text-secondary mb-1">{{ $statistikVerifikasiUnit['belum'] }}</h3>
                    <p class="mb-0 small text-muted">Belum Diverifikasi</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Chart Jenis Kegiatan
      const jenisKegiatanCtx = document.getElementById('jenisKegiatanChart').getContext('2d');
      const jenisKegiatanChart = new Chart(jenisKegiatanCtx, {
        type: 'doughnut',
        data: {
          labels: @json(array_keys($statistikVerifikasiUnit['rencana_per_jenis']->toArray())),
          datasets: [{
            data: @json(array_column($statistikVerifikasiUnit['rencana_per_jenis']->toArray(), 'jam_pelajaran')),
            backgroundColor: [
              'rgba(54, 162, 235, 0.7)',
              'rgba(255, 99, 132, 0.7)'
            ],
            borderColor: [
              'rgba(54, 162, 235, 1)',
              'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom'
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  const total = context.dataset.data.reduce((a, b) => a + b, 0);
                  const percentage = ((context.raw / total) * 100).toFixed(1);
                  return context.label + ': ' + context.raw + ' jam (' + percentage + '%)';
                }
              }
            }
          }
        }
      });

      // Chart Distribusi per Kelompok
      const kelompokCtx = document.getElementById('kelompokChart').getContext('2d');
      const kelompokChart = new Chart(kelompokCtx, {
        type: 'bar',
        data: {
          labels: @json(array_keys($statistikVerifikasiUnit['rencana_per_kelompok']->toArray())),
          datasets: [{
              label: 'Disetujui',
              data: @json(array_column($statistikVerifikasiUnit['rencana_per_kelompok']->toArray(), 'disetujui')),
              backgroundColor: 'rgba(40, 167, 69, 0.7)',
              borderColor: 'rgba(40, 167, 69, 1)',
              borderWidth: 1
            },
            {
              label: 'Direvisi',
              data: @json(array_column($statistikVerifikasiUnit['rencana_per_kelompok']->toArray(), 'direvisi')),
              backgroundColor: 'rgba(253, 126, 20, 0.7)',
              borderColor: 'rgba(253, 126, 20, 1)',
              borderWidth: 1
            },
            {
              label: 'Belum',
              data: @json(array_column($statistikVerifikasiUnit['rencana_per_kelompok']->toArray(), 'belum')),
              backgroundColor: 'rgba(108, 117, 125, 0.7)',
              borderColor: 'rgba(108, 117, 125, 1)',
              borderWidth: 1
            }
          ]
        },
        options: {
          responsive: true,
          scales: {
            x: {
              stacked: true,
            },
            y: {
              stacked: true,
              beginAtZero: true
            }
          }
        }
      });
    });
  </script>
@endif
