<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header bg-primary bg-opacity-10">
        <h5 class="card-title mb-0 fw-bold text-primary">
          <i class="ti ti-chart-bar me-2"></i>Statistik Rencana Pembelajaran Anda
        </h5>
      </div>
      <div class="card-body">
        @if ($rencanaPembelajaran && $rencanaPembelajaran->count() > 0)
          {{-- Ringkasan Statistik --}}
          <div class="row mb-4">
            <div class="col-md-3 col-sm-6">
              <div class="bg-light border rounded p-3 text-center">
                <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-flex mb-2">
                  <i class="ti ti-calendar-event text-primary fs-3"></i>
                </div>
                <h4 class="fw-bold mb-0">{{ $rencanaPembelajaran->count() }}</h4>
                <p class="text-muted mb-0">Tahun Perencanaan</p>
              </div>
            </div>
            <div class="col-md-3 col-sm-6">
              <div class="bg-light border rounded p-3 text-center">
                <div class="bg-success bg-opacity-10 rounded-circle p-3 d-inline-flex mb-2">
                  <i class="ti ti-clock text-success fs-3"></i>
                </div>
                <h4 class="fw-bold mb-0">{{ $rencanaPembelajaran->sum('total_jam_pelajaran') }}</h4>
                <p class="text-muted mb-0">Total Jam Pelajaran</p>
              </div>
            </div>
            <div class="col-md-3 col-sm-6">
              <div class="bg-light border rounded p-3 text-center">
                <div class="bg-info bg-opacity-10 rounded-circle p-3 d-inline-flex mb-2">
                  <i class="ti ti-school text-info fs-3"></i>
                </div>
                <h4 class="fw-bold mb-0">{{ $dataPegawai->rencanaPembelajaran->count() }}</h4>
                <p class="text-muted mb-0">Total Program</p>
              </div>
            </div>
            <div class="col-md-3 col-sm-6">
              <div class="bg-light border rounded p-3 text-center">
                <div class="bg-warning bg-opacity-10 rounded-circle p-3 d-inline-flex mb-2">
                  <i class="ti ti-cash text-warning fs-3"></i>
                </div>
                <h4 class="fw-bold mb-0">Rp
                  {{ number_format($dataPegawai->rencanaPembelajaran->sum('anggaran_rencana'), 0, ',', '.') }}</h4>
                <p class="text-muted mb-0">Total Anggaran</p>
              </div>
            </div>
          </div>

          {{-- Grafik Perkembangan per Tahun --}}
          <div class="row d-flex align-items-stretch mb-4">
            <div class="col-md-8">
              <div class="card border shadow-none mb-0">
                <div class="card-header bg-warning bg-opacity-10">
                  <h6 class="card-title mb-0 fw-bold text-warning">
                    <i class="ti ti-chart-bar me-1"></i>Perkembangan Rencana Pembelajaran per Tahun
                  </h6>
                </div>
                <div class="card-body">
                  <canvas id="rencanaChart" height="250"></canvas>
                </div>
              </div>
            </div>

            {{-- Distribusi klasifikasi --}}
            <div class="col-md-4">
              <div class="card h-100 border shadow-none mb-0">
                <div class="card-header bg-info bg-opacity-10">
                  <h6 class="card-title mb-0 fw-bold text-info">
                    <i class="ti ti-chart-pie me-1"></i>Distribusi Klasifikasi
                  </h6>
                </div>
                <div class="card-body">
                  <canvas id="classificationChart" height="250"></canvas>

                  <!-- Tambahan konten untuk melengkapi card -->
                  <div class="mt-4">
                    <h6 class="fw-semibold mb-3">Rincian Klasifikasi</h6>

                    @php
                      // Hitung total jam per klasifikasi
                      $totalPelatihan = $dataPegawai->rencanaPembelajaran
                          ->where('klasifikasi', 'pelatihan')
                          ->sum('jam_pelajaran');
                      $totalPendidikan = $dataPegawai->rencanaPembelajaran
                          ->where('klasifikasi', 'pendidikan')
                          ->sum('jam_pelajaran');
                      $totalJam = $totalPelatihan + $totalPendidikan;
                    @endphp

                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <div class="d-flex align-items-center">
                        <span class="badge rounded-circle p-2 me-2"
                          style="background-color: rgba(54, 162, 235, 0.7); width: 12px; height: 12px;"></span>
                        <span class="small">Pelatihan</span>
                      </div>
                      <div>
                        <span class="fw-medium">{{ $totalPelatihan }} jam</span>
                        <span class="text-muted ms-1 small">
                          ({{ $totalJam > 0 ? number_format(($totalPelatihan / $totalJam) * 100, 1) : 0 }}%)
                        </span>
                      </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <div class="d-flex align-items-center">
                        <span class="badge rounded-circle p-2 me-2"
                          style="background-color: rgba(255, 99, 132, 0.7); width: 12px; height: 12px;"></span>
                        <span class="small">Pendidikan</span>
                      </div>
                      <div>
                        <span class="fw-medium">{{ $totalPendidikan }} jam</span>
                        <span class="text-muted ms-1 small">
                          ({{ $totalJam > 0 ? number_format(($totalPendidikan / $totalJam) * 100, 1) : 0 }}%)
                        </span>
                      </div>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-center">
                      <span class="fw-semibold">Total</span>
                      <span class="fw-bold text-primary">
                        {{ $totalJam }} jam
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Tabel Rincian per Tahun --}}
          <div class="card mb-1 shadow-none border">
            <div class="card-header bg-success bg-opacity-10">
              <h6 class="card-title mb-0 fw-bold text-success">
                <i class="ti ti-table me-1"></i>Rincian Rencana Pembelajaran Tahun
              </h6>
            </div>
            <div class="card-body p-2">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="fs-3">
                    <tr>
                      <th>Tahun</th>
                      <th>Jumlah Program</th>
                      <th>Total Jam Pelajaran</th>
                      <th>Total Anggaran</th>
                      <th>Rata-rata per Program</th>
                    </tr>
                  </thead>
                  <tbody class="fs-3">
                    @foreach ($rencanaPembelajaran as $rp)
                      @php
                        $programs = $dataPegawai->rencanaPembelajaran->where('tahun', $rp->tahun);
                        $totalAnggaran = $programs->sum('anggaran_rencana');
                        $jumlahProgram = $programs->count();
                        $rataAnggaran = $jumlahProgram > 0 ? $totalAnggaran / $jumlahProgram : 0;
                      @endphp
                      <tr>
                        <td class="fw-bold">{{ $rp->tahun }}</td>
                        <td>{{ $jumlahProgram }} Program</td>
                        <td>{{ $rp->total_jam_pelajaran }} Jam</td>
                        <td>Rp {{ number_format($totalAnggaran, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($rataAnggaran, 0, ',', '.') }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot class="fs-3">
                    <tr class="fw-bold">
                      <td>Total</td>
                      <td>{{ $dataPegawai->rencanaPembelajaran->count() }} Program</td>
                      <td>{{ $rencanaPembelajaran->sum('total_jam_pelajaran') }} Jam</td>
                      <td>Rp
                        {{ number_format($dataPegawai->rencanaPembelajaran->sum('anggaran_rencana'), 0, ',', '.') }}
                      </td>
                      <td>Rp
                        {{ number_format($dataPegawai->rencanaPembelajaran->avg('anggaran_rencana'), 0, ',', '.') }}
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        @else
          <div class="text-center py-5">
            <div class="bg-light rounded-circle p-4 d-inline-flex mb-3">
              <i class="ti ti-school text-muted" style="font-size: 40px;"></i>
            </div>
            <h5 class="text-muted">Belum ada rencana pembelajaran</h5>
            <p class="text-muted">Anda belum membuat rencana pembelajaran untuk tahun mana pun.</p>
            <a href="{{ route('rencana-pembelajaran.create') }}" class="btn btn-primary">
              <i class="ti ti-plus me-1"></i>Buat Rencana Pembelajaran
            </a>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

{{-- CHART ROW 2 --}}
@if ($rencanaPembelajaran && $rencanaPembelajaran->count() > 0)
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Data untuk chart
      const tahunData = @json($rencanaPembelajaran->pluck('tahun'));
      const jamData = @json($rencanaPembelajaran->pluck('total_jam_pelajaran'));

      // Hitung total jam untuk chart distribusi
      const totalJam = jamData.reduce((acc, curr) => acc + curr, 0);
      const distributionData = jamData.map(jam => (jam / totalJam * 100).toFixed(1));

      // Warna untuk chart
      const backgroundColors = [
        'rgba(54, 162, 235, 0.7)',
        'rgba(75, 192, 192, 0.7)',
        'rgba(153, 102, 255, 0.7)',
        'rgba(255, 159, 64, 0.7)',
        'rgba(255, 99, 132, 0.7)',
        'rgba(255, 205, 86, 0.7)',
      ];

      // Chart Perkembangan
      const rencanaCtx = document.getElementById('rencanaChart').getContext('2d');
      const rencanaChart = new Chart(rencanaCtx, {
        type: 'bar',
        data: {
          labels: tahunData,
          datasets: [{
            label: 'Jam Pelajaran per Tahun',
            data: jamData,
            backgroundColor: backgroundColors,
            borderColor: backgroundColors.map(color => color.replace('0.7', '1')),
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Jam Pelajaran'
              }
            },
            x: {
              title: {
                display: true,
                text: 'Tahun'
              }
            }
          }
        }
      });

      // Chart Distribusi Klasifikasi
      const classificationCtx = document.getElementById('classificationChart').getContext('2d');
      const classificationChart = new Chart(classificationCtx, {
        type: 'doughnut',
        data: {
          labels: ['Pelatihan', 'Pendidikan'],
          datasets: [{
            data: [{{ $totalPelatihan }}, {{ $totalPendidikan }}],
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
    });
  </script>
@endif
