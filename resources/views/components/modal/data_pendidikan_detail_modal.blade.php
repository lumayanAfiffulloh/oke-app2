<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title tw-text-[20px] fw-bold" id="staticBackdropLabel{{ $item->id }}">
        Detail Pendidikan
      </h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body border border-2 mx-3 rounded-2">
      <ol class="list-group">
        <li class="list-group-item">
          <h2 class="fs-5 d-inline">
            <div class="row">
              <div class="col-md-4 d-flex justify-content-between">
                <span style="display:inline-block;">Jenjang</span>
                <p class="fw-bold">:</p>
              </div>
              <div class="col-md-8">
                <span class="tw-text-sky-500 fw-bold">{{ ucwords($item->jenjang->jenjang) }} </span>
              </div>
            </div>
          </h2>
        </li>
        <li class="list-group-item">
          <h2 class="fs-5 d-inline">
            <div class="row">
              <div class="col-md-4 d-flex justify-content-between">
                <span style="display:inline-block;">Jurusan</span>
                <p class="fw-bold">:</p>
              </div>
              <div class="col-md-8">
                <span class="tw-text-sky-500 fw-bold">{{ ucwords($item->jurusan->jurusan) }} </span>
              </div>
            </div>
          </h2>
        </li>

        <li class="list-group-item">
          <h2 class="fs-5">
            <div class="row">
              <div class="col-md-4 d-flex justify-content-between mb-3">
                <span>Estimasi Harga</span>
                <span>:</span>
              </div>
            </div>
            @if($item->estimasiPendidikans->count() > 0)
            <table class="table table-bordered">
              <thead>
                <tr class="fs-4">
                  <th>Region</th>
                  <th>Anggaran Minimal</th>
                  <th>Anggaran Maksimal</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($item->estimasiPendidikans as $estimasi)
                <tr class="fs-4">
                  <td>{{ ucfirst($estimasi->region) }}</td>
                  <td>Rp {{ number_format($estimasi->anggaran_min, 0, ',', '.') }}</td>
                  <td>Rp {{ number_format($estimasi->anggaran_maks, 0, ',', '.') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @else
            <span class="text-muted">Estimasi harga tidak tersedia.</span>
            @endif
          </h2>
        </li>

      </ol>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      <a href="/data_pendidikan/{{ $item->id }}/edit" class="btn btn-warning" style="font-size: 0.8rem">Edit</a>
    </div>
  </div>
</div>