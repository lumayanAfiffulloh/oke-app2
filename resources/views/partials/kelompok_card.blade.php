<div class="card mb-4">
  <div class="card-header bg-light d-flex justify-content-between">
    <h5 class="mb-0">{{ $kelompok }}</h5>
    <span
      class="badge bg-{{ $status === 'disetujui' ? 'success' : ($status === 'direvisi' ? 'warning' : 'secondary') }}">
      {{ count($rencanas) }} Pegawai
    </span>
  </div>

  <div class="card-body p-0">
    <table class="table table-hover mb-0">
      <thead class="table-light">
        <tr>
          <th width="5%">No</th>
          <th>Nama Pegawai</th>
          <th>Rencana Pelatihan</th>
          <th>Status Sebelumnya</th>
          @if ($status === 'pending')
            <th width="15%">Aksi</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @foreach ($rencanas as $index => $rencana)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $rencana->dataPegawai->nama }}</td>
            <td>
              <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                data-bs-target="#detailModal-{{ $rencana->id }}">
                Lihat Detail
              </button>
            </td>
            <td>
              <span class="badge bg-success">Disetujui Ketua Kelompok</span>
            </td>

            @if ($status === 'pending' && $isWithinDeadline)
              <td>
                <div class="btn-group btn-group-sm">
                  <button class="btn btn-success approve-btn" data-id="{{ $rencana->id }}">
                    <i class="fas fa-check"></i>
                  </button>
                  <button class="btn btn-warning revisi-btn" data-id="{{ $rencana->id }}">
                    <i class="fas fa-edit"></i>
                  </button>
                </div>
              </td>
            @endif
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Detail -->
@foreach ($rencanas as $rencana)
  <div class="modal fade" id="detailModal-{{ $rencana->id }}">
    <!-- Isi modal detail rencana -->
  </div>
@endforeach
