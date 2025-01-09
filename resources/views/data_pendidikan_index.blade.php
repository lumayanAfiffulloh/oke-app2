@extends('layouts.app_modern', ['title' => 'Data Pendidikan'])
@section('content')
<div class="card mb-4 pb-4 bg-white">
  <div class="card-body px-0 py-0">
    <div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">Data Pendidikan</div>
    <div class="row my-3">
      <div class="col-md-12">
        <button class="position-relative ">
          <a href="#" class="btn btn-outline-primary ms-3 " style="font-size: 0.9rem" data-bs-toggle="modal"
            data-bs-target="#createPendidikanModal">
            <span class="me-1">
              <i class="ti ti-clipboard-plus"></i>
            </span>
            <span>Tambah Data Pendidikan</span>
          </a>
        </button>

        {{-- MODAL TAMBAH Data Pendidikan --}}
        <div class="modal fade" data-bs-backdrop="static" tabindex="-1" aria-hidden="true" id="createPendidikanModal">
          @include('components.modal.data_pendidikan_create_modal')
        </div>

        {{-- IMPORT EXCEL --}}
        <button class="px-0 text-start ms-2" type="button">
          <a href="#" class="btn btn-outline-success" style="font-size: 0.9rem" data-bs-toggle="modal"
            data-bs-target="#excelModal">
            <span>
              <i class="ti ti-table-import"></i>
            </span>
            <span>Import Excel</span>
          </a>
        </button>

        {{-- MODAL IMPORT EXCEL DATA Pendidikan --}}
        <div class="modal fade" data-bs-backdrop="static" tabindex="-1" aria-hidden="true" id="excelModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title tw-text-[20px] fw-semibold">
                  Import Data Pendidikan dari Excel
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="data_pendidikan/import" method="POST" enctype="multipart/form-data">
                <div class="modal-body border border-2 mx-3 rounded-2">
                  @csrf
                  <div class="form-group">
                    <label for="importExcel" class="fw-semibold">Unggah File Excel (Sesuai
                      Template)</label>
                    <input type="file" class="form-control @error('importDataPendidikan') is-invalid @enderror"
                      name="importDataPendidikan" id="importExcel">
                    <span class="text-danger">{{ $errors->first('importDataPendidikan') }}</span>
                  </div>
                  <div class="mt-2">
                    <p class="fw-bolder">Unduh Template Excel : <span>
                        <a href="https://drive.google.com/uc?export=download&id=1xzdyANHS0m9t_yqTV6SI_1v8Fgrsq4wU"
                          class="btn btn-link px-1 pt-1">Klik di Sini!</a>
                      </span></p>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-warning">Import</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <hr class="my-0">
    <div class="row">
      <div class="col-md-7">
        <div class="table-responsive">
          <table class="table table-striped mb-3" style="font-size: 0.8rem" id="myTable">
            <thead>
              <th class="text-center">No.</th>
              <th>Jenjang</th>
              <th>Jurusan</th>
              <th>AKSI</th>
            </thead>
            <tbody>
              @foreach ($dataPendidikan as $item)
              <tr>
                <td class="text-center py-3">{{ $loop->iteration }}</td>
                <td class="py-3">{{ ucwords($item->jurusan->jurusan) }}</td>
                <td class="py-3">
                  {{-- Menampilkan jenjang-jenjang yang terkait --}}
                  {{ ucwords($item->jenjangs->pluck('jenjang')->join(', ')) }}
                </td>
                <td class="py-3">
                  <div class="btn-group" role="group">
                    <a href="/data_pendidikan/{{ $item->id }}/edit" class="btn btn-warning btn-sm" title="Edit">
                      <span class="ti ti-pencil"></span>
                    </a>
                    <form action="/data_pendidikan/{{ $item->id }}" method="POST">
                      @csrf
                      @method('delete')
                      <button type="submit" class="btn btn-danger rounded-end-1 btn-sm deleteAlert"
                        style="border-radius: 0;" title="Hapus">
                        <span class="ti ti-trash"></span>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      {{-- ESTIMASI HARGA --}}
      <div class="col-md-5 ms-sm-0 ms-2">
        <div class="fs-5 fw-bolder mt-1 text-primary"> Estimasi Anggaran Pendidikan </div>
        <hr class="border border-1 mb-2 border-primary" style="width: 65%">
        <div class="row me-1">
          @foreach($jenjang as $jenjang)
          @if($jenjang->anggaranPendidikan->count() > 0)
          <div class="col">
            <div class="fs-3 fw-semibold mb-1">{{ ucwords($jenjang->jenjang) }}</div>
            <div class="table-responsive">
              <table class="table table-bordered ">
                <thead class="fs-2">
                  <th>Region</th>
                  <th>Anggaran Min</th>
                  <th>Anggaran Maks</th>
                </thead>
                <tbody class="fs-2">
                  @foreach($jenjang->anggaranPendidikan as $anggaran)
                  <tr>
                    <td>{{ ucwords($anggaran->region) }}</td>
                    <td>Rp{{ number_format($anggaran->anggaran_min, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($anggaran->anggaran_maks, 0, ',', '.') }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            @else
            <h5>{{ $jenjang->jenjang }} (Belum memiliki anggaran)</h5>
            @endif
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- FORMAT RUPIAH RIBUAN --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
        // Seleksi semua input dengan class "format-rupiah"
        const rupiahInputs = document.querySelectorAll('.format-rupiah');

        rupiahInputs.forEach((input) => {
            // Event listener saat input berubah
            input.addEventListener('input', function () {
                formatRupiah(input);
            });
        });
    });

    function formatRupiah(input) {
        // Ambil nilai input dan buang format lama
        let rawValue = input.value.replace(/[^,\d]/g, '');

        // Masukkan ke input hidden terkait
        const hiddenInput = input.nextElementSibling;
        if (hiddenInput && hiddenInput.type === 'hidden') {
            hiddenInput.value = rawValue;
        }

        // Format ulang untuk menampilkan sebagai rupiah
        let formattedValue = '';
        const split = rawValue.split(',');
        const sisa = split[0].length % 3;
        formattedValue += split[0].substr(0, sisa);
        const ribuan = split[0].substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            const separator = sisa ? '.' : '';
            formattedValue += separator + ribuan.join('.');
        }

        input.value = 'Rp ' + formattedValue + (split[1] ? ',' + split[1] : '');
    }
</script>

{{-- PAKSA BUKA MODAL JIKA ADA ERROR --}}
<script>
  @if ($errors->any())
  document.addEventListener('DOMContentLoaded', function () {
    var modalCreate = new bootstrap.Modal(document.getElementById('createPendidikanModal'));
    modalCreate.show();

    // Pastikan format rupiah diterapkan ulang pada input
    const rupiahInputs = document.querySelectorAll('.format-rupiah');
    rupiahInputs.forEach((input) => formatRupiah(input));
  });
  @endif
</script>
@endsection