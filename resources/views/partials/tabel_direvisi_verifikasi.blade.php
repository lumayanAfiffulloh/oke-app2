<div class="tab-pane fade" id="direvisi-{{ $kelompokData['kelompok']->id }}">
  @if ($kelompokData['rencanaDirevisi']->isNotEmpty())
    <div class="table-responsive">
      <table class="table table-hover">
        <thead class="table-light">
          <tr>
            <th>Nama Pegawai</th>
            <th>Jenis Pembelajaran</th>
            <th>Judul</th>
            <th>Catatan Revisi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($kelompokData['rencanaDirevisi'] as $rencana)
            <tr>
              <td>{{ $rencana->dataPegawai->nama ?? '-' }}</td>
              <td>{{ $rencana->nama ?? '-' }}</td>
              <td>{{ Str::limit($rencana->judul ?? '-', 40) }}</td>
              <td>{{ Str::limit(optional($rencana->pegawaiCanVerifying)->catatan ?? '-', 50) }}</td>
              <td>
                <button class="btn btn-sm btn-warning">
                  <i class="fas fa-edit"></i> Periksa
                </button>
                <button class="btn btn-sm btn-outline-secondary">
                  <i class="fas fa-eye"></i>
                </button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @else
    <div class="alert alert-info mb-0">Tidak ada rencana yang direvisi</div>
  @endif
</div>
