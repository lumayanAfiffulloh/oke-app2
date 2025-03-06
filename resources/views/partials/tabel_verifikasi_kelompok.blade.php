<div class="table-responsive">
  <table class="table table-hover table-bordered mb-3 datatables" style="font-size: 0.7rem">
    <thead>
      <tr>
        <th class="align-middle" rowspan="2">No.</th>
        <th class="align-middle" rowspan="2">Nama</th>
        <th class="align-middle" rowspan="2">Tahun <br> Kode</th>
        <th class="align-middle" rowspan="2">Bentuk</th>
        <th class="align-middle" rowspan="2">Kegiatan</th>
        <th class="align-middle" colspan="2">Verifikasi & Validasi</th>
        <th class="align-middle" rowspan="2">Rencana</th>
        <th class="align-middle" rowspan="2">Prioritas</th>
        @if($status === 'ditolak')
        <th class="align-middle" rowspan="2">Catatan</th>
        <th class="align-middle" rowspan="2">Status Revisi</th>
        @endif
        <th rowspan="2" class="align-middle">AKSI</th>
      </tr>
      <tr>
        <th class="align-middle">Pimpinan Unit Kerja</th>
        <th class="align-middle">Universitas</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($rencana as $rencanaPembelajaran)
      <tr>
        <td class="text-center px-2">{{ $loop->iteration }}</td>
        <td class="px-2">{{ $rencanaPembelajaran->dataPegawai->nama }}</td>
        <td class="text-center px-2">{{ $rencanaPembelajaran->tahun }}
          @if ($rencanaPembelajaran->klasifikasi == 'pelatihan')
          <br><span class="fw-semibold">{{ $rencanaPembelajaran->dataPelatihan->kode }}</span>
          @endif
        </td>
        <td class="px-2">
          @if ($rencanaPembelajaran->klasifikasi == 'pelatihan')
          @if ($rencanaPembelajaran->bentukJalur->kategori->kategori == "klasikal")
          <span class="badge text-bg-secondary" style="font-size: 0.7rem">
            {{ ucwords($rencanaPembelajaran->bentukJalur->kategori->kategori) ?? '-' }}
          </span>
          @else
          <span class="badge text-bg-warning" style="font-size: 0.7rem">
            {{ ucwords($rencanaPembelajaran->bentukJalur->kategori->kategori) ?? '-' }}
          </span>
          @endif
          <br>
          <span class="fw-semibold">Bentuk Jalur: </span>{{ $rencanaPembelajaran->bentukJalur->bentuk_jalur ?? '' }}
          <br>
          <span class="fw-semibold">Rumpun:</span> {{ $rencanaPembelajaran->dataPelatihan->rumpun->rumpun ?? '' }}
          @elseif($rencanaPembelajaran->klasifikasi == 'pendidikan')
          <span class="badge text-bg-primary" style="font-size: 0.7rem">
            {{ ucwords($rencanaPembelajaran->klasifikasi) ?? '-' }}
          </span><br>
          <span class="fw-semibold">Jenjang:</span>
          {{ $rencanaPembelajaran->jenjang->jenjang ?? '' }}
          <br><span class="fw-semibold">Jenis Pendidikan: </span>
          {{ strtoupper($rencanaPembelajaran->jenisPendidikan->jenis_pendidikan) ?? '' }}
          @endif
        </td>
        <td class="px-2">
          @if($rencanaPembelajaran->klasifikasi == 'pelatihan')
          <span class="fw-semibold">Nama Pelatihan: </span><br>
          {{ $rencanaPembelajaran->dataPelatihan->nama_pelatihan ?? '-' }}
          @else
          <span class="fw-semibold">Jurusan: </span><br>
          {{ $rencanaPembelajaran->dataPendidikan->jurusan ?? '-' }}
          @endif
        </td>
        {{-- Verifikasi SATKER --}}
        <td class="px-2"></td>
        {{-- Verifikasi DSDM --}}
        <td class="px-2"></td>
        <td class="px-2">
          <span class="fw-semibold">Region: </span>{{ ucwords($rencanaPembelajaran->region->region) ?? '-' }} <br>
          <span class="fw-semibold">JP: </span>{{ $rencanaPembelajaran->jam_pelajaran }} JP <br>
          <span class="fw-semibold">Anggaran: </span>Rp{{ number_format($rencanaPembelajaran->anggaran_rencana, 0, ',',
          '.') }}
        </td>
        <td class="px-2 text-center">
          @if ($rencanaPembelajaran->prioritas == 'rendah')
          <span class="badge rounded-pill text-bg-success" style="font-size: 0.7rem">Rendah</span>
          @elseif ($rencanaPembelajaran->prioritas == 'sedang')
          <span class="badge rounded-pill text-bg-warning" style="font-size: 0.7rem">Sedang</span>
          @elseif ($rencanaPembelajaran->prioritas == 'tinggi')
          <span class="badge rounded-pill text-bg-danger" style="font-size: 0.7rem">Tinggi</span>
          @endif
        </td>

        @if($status === 'ditolak')
        <td class="px-2">
          {{-- Tampilkan catatan di sini --}}
          @if(isset($catatan[$rencanaPembelajaran->id]))
          <span class="fw-semibold">Catatan:</span> {{ $catatan[$rencanaPembelajaran->id] }}
          @endif
        </td>

        <td class="px-2">
          <span class="fw-semibold">Status Revisi:</span>
          <span class="badge {{ 
              $rencanaPembelajaran->verifikasiKelompok->status_revisi == 'belum_direvisi' ? 'text-bg-danger' : 
              ($rencanaPembelajaran->verifikasiKelompok->status_revisi == 'sedang_direvisi' ? 'text-bg-warning' : 'text-bg-success') 
            }} fs-1">
            {{ ucwords(str_replace("_", " ", $rencanaPembelajaran->verifikasiKelompok->status_revisi ?? '-'))}}
          </span>
        </td>
        @endif

        {{-- AKSI --}}
        <td class="px-2">
          <div class="d-flex align-items-center gap-1">
            @if($status === 'belumdiverifikasi')
            <a href="#" class="btn btn-success btn-sm" title="Setujui" data-bs-toggle="modal"
              data-bs-target="#setujuiModal" data-rencana-pembelajaran="{{ $rencanaPembelajaran->id }}"
              data-status="disetujui">
              <span class="ti ti-circle-check"></span>
            </a>
            <!-- Modal Setujui -->
            <div class="modal fade" id="setujuiModal" tabindex="-1" aria-labelledby="setujuiModalLabel"
              aria-hidden="true">
              @include('components.modal.setuju_verifikasi_kelompok_modal')
            </div>

            <a href="#" class="btn btn-danger btn-sm" title="Tolak" data-bs-toggle="modal" data-bs-target="#tolakModal"
              data-rencana-pembelajaran="{{ $rencanaPembelajaran->id }}" data-status="ditolak">
              <span class="ti ti-circle-x"></span>
            </a>
            <!-- Modal Tolak -->
            <div class="modal fade" id="tolakModal" tabindex="-1" aria-labelledby="tolakModalLabel" aria-hidden="true">
              @include('components.modal.tolak_verifikasi_kelompok_modal')
            </div>

            @elseif($status === 'disetujui')
            <form action="{{ route('verifikasi_kelompok.destroy', $rencanaPembelajaran->verifikasiKelompok->id) }}"
              method="post" id="batalSetujuiForm">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm" title="Batalkan Persetujuan" id="batalSetujui">
                <span class="ti ti-player-track-prev"></span>
              </button>
            </form>

            @elseif($status === 'ditolak' )
            <a href="#" class="btn btn-success btn-sm" title="Setujui" data-bs-toggle="modal"
              data-bs-target="#setujuiModal" data-rencana-pembelajaran="{{ $rencanaPembelajaran->id }}"
              data-status="disetujui">
              <span class="ti ti-circle-check"></span>
            </a>
            <!-- Modal Setujui -->
            <div class="modal fade" id="setujuiModal" tabindex="-1" aria-labelledby="setujuiModalLabel"
              aria-hidden="true">
              @include('components.modal.setuju_verifikasi_kelompok_modal')
            </div>
            @endif
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@push('alert-setujui-tolak')
<script>
  document.getElementById('batalSetujui').onclick = function(event){
    event.preventDefault();
    Swal.fire({
      title: "Konfirmasi Pembatalan",
      text: "Pastikan anda membatalkan persetujuan dengan alasan yang benar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#ff695e",
      confirmButtonText: "Batalkan Persetujuan",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed){
        // Submit form atau aksi lain setelah konfirmasi
        document.getElementById('batalSetujuiForm').submit(); // Sesuaikan ID form
      }
    });
  }
</script>

<script>
  document.getElementById('batalTolak').onclick = function(event){
    event.preventDefault();
    Swal.fire({
      title: "Konfirmasi Pembatalan",
      text: "Pastikan anda membatalkan penolakan dan mengecek revisi RPP dengan benar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#13DEB9",
      confirmButtonText: "Batalkan Penolakan",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed){
        // Submit form atau aksi lain setelah konfirmasi
        document.getElementById('batalTolakForm').submit(); // Sesuaikan ID form
      }
    });
  }
</script>
@endpush