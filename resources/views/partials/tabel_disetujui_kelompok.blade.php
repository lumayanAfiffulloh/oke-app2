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
        <th rowspan="2" class="align-middle">AKSI</th>
      </tr>
      <tr>
        <th class="align-middle">Unit Kerja</th>
        <th class="align-middle">Universitas</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($rencana as $rencanaPembelajaran)
        <tr>
          {{-- NOMOR --}}
          <td class="text-center px-2">{{ $loop->iteration }}</td>

          {{-- NAMA PEGAWAI --}}
          <td class="px-2">{{ $rencanaPembelajaran->dataPegawai->nama }}</td>

          {{-- TAHUN DAN KODE --}}
          <td class="text-center px-2">{{ $rencanaPembelajaran->tahun }}
            @if ($rencanaPembelajaran->klasifikasi == 'pelatihan')
              <br><span class="fw-semibold">{{ $rencanaPembelajaran->dataPelatihan->kode }}</span>
            @endif
          </td>

          {{-- BENTUK --}}
          <td class="px-2">
            @if ($rencanaPembelajaran->klasifikasi == 'pelatihan')
              @if ($rencanaPembelajaran->bentukJalur->kategori->kategori == 'klasikal')
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

          {{-- KEGIATAN --}}
          <td class="px-2">
            @if ($rencanaPembelajaran->klasifikasi == 'pelatihan')
              <span class="fw-semibold">Nama Pelatihan: </span><br>
              {{ $rencanaPembelajaran->dataPelatihan->nama_pelatihan ?? '-' }}
            @else
              <span class="fw-semibold">Jurusan: </span><br>
              {{ $rencanaPembelajaran->dataPendidikan->jurusan ?? '-' }}
            @endif
          </td>

          {{-- validasi UNIT KERJA --}}
          <td class="px-2">-</td>

          {{-- validasi DSDM --}}
          <td class="px-2">-</td>

          {{-- RENCANA --}}
          <td class="px-2">
            <span class="fw-semibold">Region: </span>{{ ucwords($rencanaPembelajaran->region->region) ?? '-' }} <br>
            <span class="fw-semibold">JP: </span>{{ $rencanaPembelajaran->jam_pelajaran }} JP <br>
            <span class="fw-semibold">Anggaran:
            </span>Rp{{ number_format($rencanaPembelajaran->anggaran_rencana, 0, ',', '.') }} <br>
            <strong>Catatan :</strong>
            @if (
                $rencanaPembelajaran->kelompokCanValidating &&
                    $rencanaPembelajaran->kelompokCanValidating->catatanValidasiKelompok->isNotEmpty())
              <ul class="m-0 p-0">
                @foreach ($rencanaPembelajaran->kelompokCanValidating->catatanValidasiKelompok as $catatan)
                  <li>{{ $catatan->catatan }}</li>
                @endforeach
              </ul>
            @else
              <span class="text-muted">-</span>
            @endif
          </td>

          {{-- PRIORITAS --}}
          <td class="px-1 text-center">
            @if ($rencanaPembelajaran->prioritas == 'rendah')
              <span class="badge rounded-pill text-bg-success" style="font-size: 0.7rem">Rendah</span>
            @elseif ($rencanaPembelajaran->prioritas == 'sedang')
              <span class="badge rounded-pill text-bg-warning" style="font-size: 0.7rem">Sedang</span>
            @elseif ($rencanaPembelajaran->prioritas == 'tinggi')
              <span class="badge rounded-pill text-bg-danger" style="font-size: 0.7rem">Tinggi</span>
            @endif
          </td>

          {{-- AKSI --}}
          <td class="px-2 text-center">
            {{-- BATAL SETUJUI RENCANA --}}
            <form action="{{ route('validasi_kelompok.destroy', $rencanaPembelajaran->kelompokCanValidating->id) }}"
              method="post" id="batalSetujuiForm-{{ $rencanaPembelajaran->id }}">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm batalSetujuiAlert" title="Batalkan Persetujuan"
                data-form-id="batalSetujuiForm-{{ $rencanaPembelajaran->id }}">
                <span class="ti ti-arrow-back fs-3"></span>
              </button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

@push('alert-setujui-tolak')
  <script>
    document.querySelectorAll('.batalSetujui').forEach(button => {
      button.addEventListener('click', event => {
        event.preventDefault();
        let formId = button.getAttribute('data-form-id');
        Swal.fire({
          title: "Konfirmasi Pembatalan",
          text: "Pastikan anda membatalkan persetujuan dengan alasan yang benar!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#ff695e",
          confirmButtonText: "Batalkan Persetujuan",
          cancelButtonText: "Batal"
        }).then(result => {
          if (result.isConfirmed) {
            document.getElementById(formId).submit();
          }
        });
      });
    });
  </script>
@endpush
