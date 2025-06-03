<!-- Tab Belum Diverifikasi -->
<div class="tab-pane fade show active" id="belumdiverifikasi-{{ $kelompokData['kelompok']->id }}">
  @if ($totalRencana === 0)
    <div class="alert alert-warning mb-2">
      <i class="fas fa-info-circle me-2"></i>
      Belum ada rencana pembelajaran yang diajukan
    </div>
  @elseif ($kelompokData['rencanaBelumDiverifikasi']->isNotEmpty())
    <div class="table-responsive">
      <table class="table table-hover datatables">
        <thead class="table-light">
          <tr>
            <th>Nama Pegawai</th>
            <th>Jenis Pembelajaran</th>
            <th>Judul</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($kelompokData['rencanaBelumDiverifikasi'] as $rencana)
            <tr>
              <td>{{ $rencana->dataPegawai->nama ?? '-' }}</td>
              <td>{{ $rencana->nama ?? '-' }}</td>
              <td>{{ Str::limit($rencana->judul ?? '-', 50) }}</td>
              <td>{{ $rencana->created_at->format('d/m/Y') }}</td>
              <td>
                <button class="btn btn-sm btn-primary">
                  <i class="ti ti-circle-check"></i> Verifikasi
                </button>
                <button class="btn btn-sm btn-outline-secondary">
                  <i class="ti ti-eye"></i>
                </button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @else
    <div class="alert alert-success mb-0">
      <i class="fas fa-check-circle me-2"></i>
      Semua rencana pembelajaran telah diverifikasi
    </div>
  @endif
</div>
