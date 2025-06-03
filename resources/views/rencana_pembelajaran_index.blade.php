@extends('layouts.main_layout', ['title' => 'Rencana Pembelajaran Anda'])
@section('content')
  <style>
    .no-column {
      width: 50px;
      /* Sesuaikan lebar sesuai kebutuhan */
      max-width: 50px;
      /* Batasi lebar maksimum */
      text-align: center;
      /* Pusatkan teks */
    }
  </style>

  <div class="container-fluid px-3">
    <!-- Page Header dengan Informasi Penting -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="mb-1">Rencana Pembelajaran</h2>
        <div class="d-flex align-items-center gap-2">
          <span class="badge bg-primary bg-opacity-10 text-primary">
            <i class="ti ti-user me-1"></i> {{ $dataPegawai->nama }}
          </span>
          <span class="badge bg-secondary bg-opacity-10 text-secondary">
            <i class="ti ti-id me-1"></i> {{ $dataPegawai->nppu }}
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
              Admin belum menetapkan periode pengajuan
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
              Periode Pengajuan Akan Dimulai
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
              Batas Pengajuan:
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
              Masa Pengajuan Telah Berakhir
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
      <div class="col-md-4">
        <div class="card mb-1 shadow-none border">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="text-muted mb-2">Total Rencana</h6>
                <h3 class="mb-0">{{ $rencana_pembelajaran->count() }}</h3>
              </div>
              <div class="bg-primary bg-opacity-10 p-3 rounded">
                <i class="ti ti-list text-primary" style="font-size: 1.5rem"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card mb-1 shadow-none border">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="text-muted mb-2">Disetujui</h6>
                <h3 class="mb-0">{{ $notifikasi['disetujui'] }}</h3>
              </div>
              <div class="bg-success bg-opacity-10 p-3 rounded">
                <i class="ti ti-circle-check text-success" style="font-size: 1.5rem"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card mb-1 shadow-none border">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="text-muted mb-2">Perlu Revisi</h6>
                <h3 class="mb-0">{{ $notifikasi['direvisi'] }}</h3>
              </div>
              <div class="bg-warning bg-opacity-10 p-3 rounded">
                <i class="ti ti-alert-triangle text-warning" style="font-size: 1.5rem"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Data Table -->
    <div class="card mb-4 pb-4 bg-white">
      <div class="card-header p-3 bg-white">
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="mb-0 fw-semibold">Daftar Rencana Pembelajaran</h5>
          <!-- Tombol Tambah -->
          @if ($isWithinDeadline && auth()->user()->dataPegawai->kelompok_id)
            <a href="/rencana_pembelajaran/create" class="btn btn-outline-primary btn-sm ms-3">
              <span class="me-1">
                <i class="ti ti-clipboard-plus"></i>
              </span>
              <span>Tambah Rencana Pembelajaran</span>
            </a>
          @else
            <button class="btn btn-outline-dark opacity-25 btn-sm ms-3" disabled>
              <span class="me-1">
                <i class="ti ti-clipboard-plus"></i>
              </span>
              <span>Tambah Rencana Pembelajaran</span>
              @unless (auth()->user()->dataPegawai->kelompok_id)
                <span class="ms-1 small text-dark fw-bolder">(Anda belum memiliki kelompok)</span>
              @endunless
            </button>
          @endif
        </div>
      </div>
      <hr class="mt-0 mb-1 text-body-tertiary">
      <div class="card-body p-0">
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
                  <td class="px-2 text-center no-column">{{ $index + 1 }}</td>

                  {{-- TAHUN DAN KODE --}}
                  <td class="px-2 text-center">{{ $rencana->tahun }}
                    @if ($rencana->klasifikasi == 'pelatihan')
                      <br> <span class="fw-semibold">{{ ucwords($rencana->dataPelatihan->kode) }}</span>
                    @endif
                  </td>

                  {{-- BENTUK --}}
                  <td class="px-2">
                    @if ($rencana->klasifikasi == 'pelatihan')
                      @if ($rencana->bentukJalur->kategori->kategori == 'klasikal')
                        <span class="badge text-bg-secondary" style="font-size: 0.7rem">
                          {{ ucwords($rencana->bentukJalur->kategori->kategori) ?? '-' }}
                        </span>
                      @else
                        <span class="badge text-bg-warning" style="font-size: 0.7rem">
                          {{ ucwords($rencana->bentukJalur->kategori->kategori) ?? '-' }}
                        </span>
                      @endif
                      <br>
                      <span class="fw-semibold">Bentuk Jalur: </span>{{ $rencana->bentukJalur->bentuk_jalur ?? '' }}
                      <br>
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
                    @if ($rencana->klasifikasi == 'pelatihan')
                      <span class="fw-semibold">Nama Pelatihan: </span><br>
                      {{ $rencana->dataPelatihan->nama_pelatihan ?? '-' }}
                    @else
                      <span class="fw-semibold">Jurusan: </span><br>
                      {{ $rencana->dataPendidikan->jurusan ?? '-' }}
                    @endif
                  </td>

                  {{-- VERIFIKASI DAN VALIDASI --}}

                  {{-- Validasi Kelompok --}}
                  <td class="px-2">
                    @if ($rencana->kelompokCanValidating)
                      @if ($rencana->kelompokCanValidating->status == 'disetujui')
                        <span class="badge text-bg-success fs-1">Disetujui</span><br>
                        <span class="fw-semibold">Catatan:</span>
                        @if ($rencana->kelompokCanValidating->catatanValidasiKelompok->count() > 0)
                          <ul>
                            @foreach ($rencana->kelompokCanValidating->catatanValidasiKelompok as $catatan)
                              <li>{{ $catatan->catatan }}</li>
                            @endforeach
                          </ul>
                        @else
                          <div>-</div>
                        @endif
                      @elseif(
                          $rencana->kelompokCanValidating->status == 'direvisi' &&
                              $rencana->kelompokCanValidating->status_revisi == 'belum_direvisi')
                        <span class="badge text-bg-warning fs-1">Perlu Revisi</span>
                      @endif
                      @if ($rencana->kelompokCanValidating->status_revisi == 'sedang_direvisi')
                        <span class="badge text-bg-warning fs-1">Revisi Belum Dikirim</span>
                      @elseif($rencana->kelompokCanValidating->status_revisi == 'sudah_direvisi')
                        <span class="badge text-bg-secondary fs-1">Revisi Ditinjau</span>
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
                    @elseif($rencana->status_pengajuan === 'diajukan')
                      <span class="badge text-bg-primary bg-opacity-75 fs-1">Rencana Ditinjau</span>
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
                    <span class="fw-semibold">Anggaran:
                    </span>Rp{{ number_format($rencana->anggaran_rencana, 0, ',', '.') }}
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
                  @if ($isWithinDeadline)
                    <td class="px-2">
                      @if ($rencana->kelompokCanValidating)
                        @if ($rencana->kelompokCanValidating->status == 'disetujui')
                          <div class="fw-bold">*Rencana yang sudah disetujui tidak bisa dihapus atau diedit</div>
                        @else
                          @if ($rencana->kelompokCanValidating->status_revisi != 'sudah_direvisi')
                            <div class="btn-group" role="group">
                              {{-- Revisi --}}
                              <a href="/rencana_pembelajaran/{{ $rencana->id }}/edit" class="btn btn-warning btn-sm"
                                style="font-size: 0.8rem" title="Revisi"><span class="ti ti-scissors"></span></a>

                              {{-- Kirim Revisi --}}
                              <form action="{{ route('rencana_pembelajaran.kirim_revisi', $rencana->id) }}"
                                method="POST" id="kirimRevisiForm-{{ $rencana->id }}">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm rounded-end-1 kirimRevisiAlert"
                                  data-form-id="kirimRevisiForm-{{ $rencana->id }}"
                                  style="font-size: 0.8rem; border-radius: 0" title="Kirim Revisi">
                                  <span class="ti ti-script"></span>
                                </button>
                              </form>
                            </div>
                          @else
                            <span class="fw-bold">*Rencana yang revisinya sudah dikirim tidak bisa dihapus atau
                              diedit.</span>
                          @endif
                          @if ($rencana->kelompokCanValidating->status_revisi)
                            <br>
                            <span class="fw-semibold">Status Revisi:</span>
                            <span
                              class="badge {{ $rencana->kelompokCanValidating->status_revisi == 'belum_direvisi' ? 'text-bg-danger' : ($rencana->kelompokCanValidating->status_revisi == 'sedang_direvisi' ? 'text-bg-warning' : 'text-bg-success') }} fs-1">
                              {{ $rencana->kelompokCanValidating->status_revisi == 'sedang_direvisi'
                                  ? 'Revisi perlu dikirim'
                                  : ucwords(str_replace('_', ' ', $rencana->kelompokCanValidating->status_revisi)) }}
                            </span>
                          @endif
                        @endif
                      @elseif($rencana->status_pengajuan === 'draft')
                        <div class="btn-group" role="group">
                          {{-- Tombol Edit --}}
                          <a href="/rencana_pembelajaran/{{ $rencana->id }}/edit" class="btn btn-warning btn-sm"
                            style="font-size: 0.8rem" title="Edit"><span class="ti ti-pencil"></span></a>

                          {{-- Tombol Hapus --}}
                          <form action="/rencana_pembelajaran/{{ $rencana->id }}" method="POST"
                            class="d-inline deleteForm">
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
                              <span class="ti ti-send"></span>
                            </button>
                          </form>
                        </div>
                      @else
                        <div class="fw-bold">*Rencana tidak bisa dihapus atau diedit selama divalidasi.</div>
                      @endif
                    </td>
                  @else
                    <td class="px-2">
                      Tidak dapat melakukan edit atau hapus di luar tenggat waktu
                    </td>
                  @endif
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('alert-validasi-kelompok')
  @if ($notifikasi['disetujui'] > 0)
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Yeay.. Ada Rencana Disetujui!',
        text: 'Ada {{ $notifikasi['disetujui'] }} rencana pembelajaran Anda telah disetujui.',
        width: '400px',
      });
    </script>
  @endif
  @if ($notifikasi['direvisi'] > 0)
    <script>
      Swal.fire({
        icon: 'warning',
        title: 'Waduh.. Ada Rencana yang Perlu Revisi!',
        text: 'Ada {{ $notifikasi['direvisi'] }} rencana pembelajaran anda yang mendapat revisi dari ketua kelompok.',
        width: '400px',
      });
    </script>
  @endif

  <script>
    document.querySelectorAll('.ajukanAlert').forEach(button => {
      button.addEventListener('click', event => {
        event.preventDefault();
        let formId = button.getAttribute('data-form-id');
        Swal.fire({
          title: "Konfirmasi Data!",
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
