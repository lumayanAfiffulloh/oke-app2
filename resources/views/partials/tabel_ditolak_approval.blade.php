<div class="table-responsive">
  <table class="table table-hover table-bordered mb-3 px-0 datatables" style="font-size: 0.7rem">
    <thead>
      <tr>
        <th class="align-middle">No.</th>
        <th class="align-middle">Nama</th>
        <th class="align-middle">Tahun <br> Kode</th>
        <th class="align-middle">Bentuk</th>
        <th class="align-middle">Kegiatan</th>
        <th class="align-middle">Rencana</th>
        <th class="align-middle">Keterangan</th>
        <th class="align-middle">Catatan</th>
        <th class="align-middle">AKSI</th>
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

          {{-- RENCANA --}}
          <td class="px-2">
            <span class="fw-semibold">Region: </span>{{ ucwords($rencanaPembelajaran->region->region) ?? '-' }} <br>
            <span class="fw-semibold">JP: </span>{{ $rencanaPembelajaran->jam_pelajaran }} JP <br>
            <span class="fw-semibold">Anggaran:
            </span>Rp{{ number_format($rencanaPembelajaran->anggaran_rencana, 0, ',', '.') }}
          </td>

          {{-- KETERANGAN --}}
          <td class="px-1 text-center">
            @if ($rencanaPembelajaran->prioritas == 'rendah')
              <span class="badge rounded-pill text-bg-success" style="font-size: 0.7rem">Rendah</span>
            @elseif ($rencanaPembelajaran->prioritas == 'sedang')
              <span class="badge rounded-pill text-bg-warning" style="font-size: 0.7rem">Sedang</span>
            @elseif ($rencanaPembelajaran->prioritas == 'tinggi')
              <span class="badge rounded-pill text-bg-danger" style="font-size: 0.7rem">Tinggi</span>
            @endif
            {{-- Ketua Kelompok --}}
            <div class="text-start mt-2">
              <span class="fw-semibold">Ketua:</span>
              {{ optional($rencanaPembelajaran->dataPegawai->kelompok->ketua)->nama ?? '-' }}
            </div>
          </td>

          {{-- CATATAN --}}
          <td class="px-2">
            <strong>Catatan :</strong>
            @if (
                $rencanaPembelajaran->unitKerjaCanVerifying &&
                    $rencanaPembelajaran->unitKerjaCanVerifying->catatanVerifikasi->isNotEmpty())
              <ul class="m-0 p-0">
                @foreach ($rencanaPembelajaran->unitKerjaCanVerifying->catatanVerifikasi as $index => $catatan)
                  <li><span>{{ $index + 1 }}.</span> {{ $catatan->catatan }}</li>
                @endforeach
              </ul>
            @else
              <span class="text-muted">Tidak ada catatan</span>
            @endif
          </td>

          {{-- AKSI --}}
          <td class="px-2 text-center">
            @php $approval = optional($rencanaPembelajaran->universitasCanApproving); @endphp

            @if ($approval->id)
              <form action="{{ route('approval.destroy', $approval->id) }}" method="POST"
                id="batalTolakForm-{{ $rencanaPembelajaran->id }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm batalTolakAlert" title="Batalkan Penolakan"
                  data-form-id="batalTolakForm-{{ $rencanaPembelajaran->id }}">
                  <span class="ti ti-arrow-back fs-3"></span>
                </button>
              </form>
            @else
              <span class="text-muted">Tidak ada action</span>
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

{{-- Modal Setujui --}}
<div class="modal fade" id="setujuiModal-{{ $rencanaPembelajaran->id }}" tabindex="-1"
  aria-labelledby="setujuiModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-semibold">Setujui Rencana</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body border border-2 mx-3 rounded-2">
        <form action="{{ route('verifikasi.setujui-dari-revisi', $rencanaPembelajaran->id) }}" method="POST"
          id="setujuiDirevisiForm-{{ $rencanaPembelajaran->id }}">
          @csrf
          <div class="form-group">
            <div class="mb-2">
              <label for="setujui_catatan" class="form-label fw-semibold">Catatan: (opsional)</label>
              <textarea class="form-control" name="catatan" rows="3"></textarea>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success setujuiDirevisiAlert"
          data-form-id="setujuiDirevisiForm-{{ $rencanaPembelajaran->id }}">Setujui</button>
      </div>
      </form>
    </div>
  </div>
</div>
