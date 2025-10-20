@extends('layouts.main_layout', ['title' => 'Data Pendidikan'])
@section('content')
  <div class="card mb-4 pb-4 bg-white">
    <div class="card-body px-0 py-0">
      <div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">Data Pendidikan</div>
      <div class="row my-3">
        <div class="col-md-12">
          <a href="#" class="btn btn-outline-primary ms-3 " style="font-size: 0.9rem" data-bs-toggle="modal"
            data-bs-target="#createPendidikanModal">
            <span class="me-1">
              <i class="ti ti-clipboard-plus"></i>
            </span>
            <span>Tambah Data Pendidikan</span>
          </a>

          {{-- MODAL TAMBAH Data Pendidikan --}}
          <div class="modal fade" data-bs-backdrop="static" tabindex="-1" aria-hidden="true" id="createPendidikanModal">
            @include('components.modal.data_pendidikan_create_modal')
          </div>

          {{-- IMPORT EXCEL --}}
          <a href="#" class="btn btn-outline-success ms-2" style="font-size: 0.9rem" data-bs-toggle="modal"
            data-bs-target="#excelModal">
            <span>
              <i class="ti ti-table-import"></i>
            </span>
            <span>Import Excel</span>
          </a>

          {{-- MODAL IMPORT EXCEL DATA Pendidikan --}}
          <div class="modal fade" data-bs-backdrop="static" tabindex="-1" aria-hidden="true" id="excelModal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5 fw-semibold">
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
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success importAlert">Import</button>
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
                <th>Jurusan</th>
                <th>Jenjang</th>
                <th class="text-center">AKSI</th>
              </thead>
              <tbody>
                @foreach ($dataPendidikan as $item)
                  <tr>
                    <td class="text-center py-3">{{ $loop->iteration }}</td>
                    <td class="py-3">{{ ucwords($item->jurusan) }}</td>
                    <td class="py-3">
                      {{-- Menampilkan jenjang-jenjang yang terkait --}}
                      {{ ucwords($item->jenjangs->pluck('jenjang')->join(', ')) }}
                    </td>
                    <td class="py-3">
                      <div class="btn-group" role="group">
                        <a href="#" class="btn btn-warning btn-sm editButton" data-id="{{ $item->id }}"
                          data-jenjang="{{ $item->jenjangs->pluck('jenjang') }}" data-jurusan="{{ $item->jurusan }}"
                          data-bs-toggle="modal" data-bs-target="#editPendidikanModal" title="Edit">
                          <span class="ti ti-pencil"></span>
                        </a>

                        {{-- MODAL EDIT BENTUK JALUR --}}
                        <div class="modal fade" id="editPendidikanModal" tabindex="-1" aria-hidden="true">
                          @include('components.modal.data_pendidikan_edit_modal')
                        </div>

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
            @foreach ($jenjangs as $jenjang)
              @if ($jenjang->anggaranPendidikan->count() > 0)
                <div class="col">
                  <div class="fs-3 fw-semibold mb-1">{{ ucwords($jenjang->jenjang) }}</div>
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead class="fs-2">
                        <tr>
                          <th>Region</th>
                          <th>Anggaran Min</th>
                          <th>Anggaran Maks</th>
                        </tr>
                      </thead>
                      <tbody class="fs-2">
                        @foreach ($jenjang->anggaranPendidikan as $anggaran)
                          <tr>
                            <td>{{ ucwords($anggaran->region->region) }}</td> {{-- Menggunakan relasi region --}}
                            <td>Rp{{ number_format($anggaran->anggaran_min, 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($anggaran->anggaran_maks, 0, ',', '.') }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              @else
                <div class="col">
                  <h5>{{ ucwords($jenjang->jenjang) }} (Belum memiliki anggaran)</h5>
                </div>
              @endif
            @endforeach

          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const editButtons = document.querySelectorAll('.editButton');
      const modal = document.querySelector('#editPendidikanModal');
      const editFormID = modal.querySelector('#editFormID');
      const jenjangContainer = modal.querySelector('#jenjangContainer');
      const jurusanInput = modal.querySelector('#jurusan');
      const jurusanName = document.querySelector('#jurusanName'); // Menampilkan nama jurusan di title modal

      editButtons.forEach(button => {
        button.addEventListener('click', () => {
          // Ambil data dari tombol
          const id = button.getAttribute('data-id');
          const jenjang = JSON.parse(button.getAttribute('data-jenjang'));
          const jurusan = button.getAttribute('data-jurusan');

          // Isi action form
          editFormID.setAttribute('action', `/data_pendidikan/${id}`);

          // Isi jenjang checkbox
          // Isi jenjang checkbox
          jenjangContainer.innerHTML = '';
          const jenjangList = ['D1', 'D2', 'D3', 'S1', 'S2', 'S3'];
          jenjangList.forEach(jenjangItem => {
            const checked = jenjang.includes(jenjangItem) ? 'checked' : '';
            jenjangContainer.innerHTML += `
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="jenjang[]" id="${jenjangItem}" value="${jenjangItem}" ${checked}>
              <label class="form-check-label" for="${jenjangItem}">${jenjangItem}</label>
            </div>
          `;
          });

          // Isi jurusan
          jurusanInput.value = jurusan;

          // Menampilkan nama jurusan di title modal
          jurusanName.textContent = jurusan;
        });
      });
    });

    // Script tambahan untuk menampilkan nama jurusan
    document.addEventListener('DOMContentLoaded', function() {
      const editButtons = document.querySelectorAll('.editButton');
      const jurusanName = document.querySelector('#jurusanName');

      editButtons.forEach(button => {
        button.addEventListener('click', function() {
          const jurusan = this.getAttribute('data-jurusan');
          jurusanName.textContent = jurusan; // Menampilkan nama jurusan di span
        });
      });
    });
  </script>

  {{-- PAKSA BUKA MODAL JIKA ADA ERROR --}}
  <script>
    @if ($errors->any())
      document.addEventListener('DOMContentLoaded', function() {
        var modalCreate = new bootstrap.Modal(document.getElementById('createPendidikanModal'));
        modalCreate.show();

        // Pastikan format rupiah diterapkan ulang pada input
        const rupiahInputs = document.querySelectorAll('.format-rupiah');
        rupiahInputs.forEach((input) => formatRupiah(input));
      });
    @endif
  </script>
@endsection
