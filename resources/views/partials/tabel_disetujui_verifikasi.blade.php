<!-- Tab Disetujui -->
<div class="tab-pane fade" id="disetujui-{{ $kelompokData['kelompok']->id }}">
  @if ($kelompokData['rencanaDisetujui']->isNotEmpty())
    <div class="table-responsive">
      <table class="table table-hover">
        <thead class="table-light">
          <tr>
            <th>Nama Pegawai</th>
            <th>Jenis Pembelajaran</th>
            <th>Judul</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($kelompokData['rencanaDisetujui'] as $rencana)
            <tr>
              <td>{{ $rencana->dataPegawai->nama ?? '-' }}</td>
              <td>{{ $rencana->nama ?? '-' }}</td>
              <td>{{ Str::limit($rencana->judul ?? '-', 60) }}</td>
              <td>
                <button class="btn btn-sm btn-outline-secondary">
                  <i class="fas fa-eye"></i> Detail
                </button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @else
    <div class="alert alert-info mb-0">Tidak ada rencana yang disetujui</div>
  @endif
</div>
