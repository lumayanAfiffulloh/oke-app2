<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title tw-text-[20px] fw-bold" id="staticBackdropLabel{{ $item->id }}">
        Detail Pelatihan <span class="text-primary fw-bolder">{{ ucwords($item->nama_pelatihan)
          }}</span>
      </h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body border border-2 mx-3 rounded-2">
      <ol class="list-group">
        <li class="list-group-item">
          <h2 class="fs-5 d-inline">
            <div class="row">
              <div class="col-md-4 d-flex justify-content-between">
                <span style="display:inline-block;">Kode</span>
                <p class="fw-bold">:</p>
              </div>
              <div class="col-md-8">
                <span class="tw-text-sky-500 fw-bold">{{ ucwords($item->kode) }} </span>
              </div>
            </div>
          </h2>
        </li>
        <li class="list-group-item">
          <h2 class="fs-5 d-inline">
            <div class="row">
              <div class="col-md-4 d-flex justify-content-between">
                <span style="display:inline-block;">Rumpun</span>
                <p class="fw-bold">:</p>
              </div>
              <div class="col-md-8">
                <span class="tw-text-sky-500 fw-bold">{{ ucwords($item->rumpun) }} </span>
              </div>
            </div>
          </h2>
        </li>
        <li class="list-group-item">
          <h2 class="fs-5 d-inline">
            <div class="row">
              <div class="col-md-4 d-flex justify-content-between">
                <span style="display:inline-block;">Nama Pelatihan</span>
                <p class="fw-bold">:</p>
              </div>
              <div class="col-md-8">
                <span class="tw-text-sky-500 fw-bold">{{ ucwords($item->nama_pelatihan) }} </span>
              </div>
            </div>
          </h2>
        </li>
        <li class="list-group-item">
          <h2 class="fs-5 d-inline">
            <div class="row">
              <div class="col-md-4 d-flex justify-content-between">
                <span style="display:inline-block;">Deskripsi Pelatihan</span>
                <p class="fw-bold">:</p>
              </div>
              <div class="col-md-8">
                <span class="tw-text-sky-500 fw-bold lh-base">{{ ucwords($item->deskripsi) }} </span>
              </div>
            </div>
          </h2>
        </li>
        <li class="list-group-item">
          <h2 class="fs-5 d-inline">
            <div class="row">
              <div class="col-md-4 d-flex justify-content-between">
                <span style="display:inline-block;">Jam Pelajaran (JP)</span>
                <p class="fw-bold">:</p>
              </div>
              <div class="col-md-8">
                <span class="tw-text-sky-500 fw-bold">{{ $item->jp }} Jam</span>
              </div>
            </div>
          </h2>
        </li>
        <li class="list-group-item">
          <h2 class="fs-5 d-inline">
            <div class="row">
              <div class="col-md-4 d-flex justify-content-between">
                <span style="display:inline-block;">Materi Pelatihan</span>
                <p class="fw-bold">:</p>
              </div>
              <div class="col-md-8">
                <span class="tw-text-sky-500 fw-bold lh-base">{{ ucwords($item->materi) }} </span>
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
            @if($item->estimasiHarga->count() > 0)
            <table class="table table-bordered">
              <thead>
                <tr class="fs-4">
                  <th>Region</th>
                  <th>Kategori</th>
                  <th>Anggaran Min</th>
                  <th>Anggaran Maks</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($item->estimasiHarga as $estimasi)
                <tr class="fs-4">
                  <td>{{ ucwords($estimasi->region) }}</td>
                  <td>{{ ucwords($estimasi->kategori) }}</td>
                  <td>{{ 'Rp' . number_format($estimasi->anggaran_min, 0, ',', '.') }}</td>
                  <td>{{ 'Rp' . number_format($estimasi->anggaran_maks, 0, ',', '.') }}</td>
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
      <a href="/data_pelatihan/{{ $item->id }}/edit" class="btn btn-warning" style="font-size: 0.8rem">Edit</a>
    </div>
  </div>
</div>