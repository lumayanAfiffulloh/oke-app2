@extends('layouts.app_modern', ['title' => 'Data Pegawai'])
@section('content')
    <style>
        input::placeholder {
            font-size: 13px;
            /* Atur ukuran font di sini */
        }
    </style>

    <div class="card mb-4 bg-white">
        <div class="card-body px-0 py-0 ">
            <div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">Data Pegawai</div>
            <div class="row mx-1 mt-2 mb-2 justify-content-end align-items-center">
                <button class="col px-0 text-start ms-2">
                    <a href="/data_pegawai/create"
                        class="btn btn-outline-primary my-2"
                        style="font-size: 0.9rem">
                        <span>
                            <i class="ti ti-user-plus me-1"></i>
                        </span>
                        <span>Tambah Pegawai</span>
                    </a>
                </button>

                {{-- IMPORT EXCEL --}}
                <button class="col px-0 text-start ms-2" type="button">
                    <a href="#" class="btn btn-outline-success my-2" style="font-size: 0.9rem" data-bs-toggle="modal" data-bs-target="#excelModal">
                        <span>
                            <i class="ti ti-table-import me-1"></i>
                        </span>
                        <span>Import Excel</span>
                    </a>
                </button>
                {{-- MODAL IMPORT EXCEL --}}
                <div class="modal fade" data-bs-backdrop="static" tabindex="-1" aria-hidden="true" id="excelModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title tw-text-[20px] fw-bold">
                                    Import Data Pegawai dari Excel
                                </h1>
                                <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="data_pegawai/import" method="POST" enctype="multipart/form-data">
                                <div class="modal-body border border-2 mx-3 rounded-2">
                                    @csrf
                                    <div class="form-group">
                                        <label for="importExcel" class="form-label">Unggah File Excel (Sesuai Template)</label>
                                        <input type="file" class="form-control" name="importDataPegawai" id="importExcel">
                                    </div>
                                    <div class="mt-2">
                                        <p class="fw-bolder">Unduh Template Excel : <span>
                                            <a href="https://drive.google.com/uc?export=download&id=1xzdyANHS0m9t_yqTV6SI_1v8Fgrsq4wU" class="btn btn-link px-1 pt-1">Klik di Sini!</a>
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
                
                <div class="col-md-3 p-0">
                    <form action="">
                        <div class="input-group">
                            <input class="form-control" type="text" name="q" placeholder="Cari Nama"
                                value="{{ request('q') }}">
                            <button type="submit"
                                class="btn btn-primary">
                                <i class="ti ti-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-3 mx-2 p-0">
                    <form action="">
                        <div class="input-group">
                            <input class="form-control" type="text" name="w"
                                placeholder="Cari Unit Kerja" value="{{ request('w') }}">
                            <button type="submit"
                                class="btn btn-primary">
                                <i class="ti ti-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-2 ps-0">
                    <form action="">
                        <div class="input-group">
                            <input class="form-control" type="text" name="e" placeholder="Cari NIP"
                                value="{{ request('e') }}">
                            <button type="submit"
                                class="btn btn-primary">
                                <i class="ti ti-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-0">
            <div class="table-responsive">
                {{-- TABEL --}}
                <table class="table table-striped mb-3" style="font-size: 0.8rem">
                    <thead>
                        <th class="px-2 text-center">No.</th>
                        <th class="px-2">Nama</th>
                        <th class="px-2">NIP</th>
                        <th class="px-2" style="width: 10%;">Email</th>
                        <th class="px-2">Status</th>
                        <th class="px-2" style="width: 15%">Unit Kerja</th>
                        <th class="px-2">Jabatan</th>
                        <th class="px-2">Pendidikan</th>
                        <th class="px-2" style="width: 13%">AKSI</th>
                    </thead>
                    <tbody>
                        @foreach ($data_pegawai as $index => $item)
                            <tr>
                                <td class="px-2 text-center"> {{ $data_pegawai->firstItem() + $index }} </td>
                                <td class="px-2">
                                    @if ($item->foto)
                                        <a href="{{ Storage::url($item->foto) }}" target="blank">
                                            <img src="{{ Storage::url($item->foto) }}" class="rounded-circle d-block"
                                                style="object-fit: cover; height: 40px; width: 40px;">
                                        </a>
                                    @endif
                                    <div>
										<span>
											@if ($item->jenis_kelamin === 'laki-laki')
												<i class="ti ti-gender-male text-primary" style="font-size: 15px"></i>
											@else
												<i class="ti ti-gender-female" style="font-size: 15px; color: #ff70e7"></i>
											@endif
										</span>
									{{ $item->nama }} <span>({{ $item->kelompok_id }})</span></div>
                                </td>
                                <td class="px-2">{{ $item->nip }}</td>
                                <td class="px-2">{{ $item->user->email }}</td>
                                <td class="px-2">
                                    @if ($item->status === 'aktif')
                                        <span class="badge rounded-pill bg-success" style="font-size: 0.8rem">Aktif</span>
                                    @else
                                        <span class="badge rounded-pill bg-danger"
                                            style="font-size: 0.8rem">Non-Aktif</span>
                                    @endif
                                </td>
                                <td class="px-2">{{ $item->unit_kerja }}</td>
                                <td class="px-2">{{ $item->jabatan }}</td>
                                <td class="px-2">{{ $item->pendidikan }}</td>
                                <td class="px-2">
                                    <a href="/data_pegawai/{{ $item->id }}/edit"
                                        class="btn btn-warning btn-sm"
                                        style="font-size: 0.8rem">Edit</a>
                                    <form action="/data_pegawai/{{ $item->id }}" method="POST" class="d-inline deleteForm">
                                        @csrf
                                        @method('delete')
                                        <button type="submit"
                                            class="btn btn-danger btn-sm deleteAlert"
                                            style="font-size: 0.8rem"
                                            >
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mx-3 mb-3">
            {!! $data_pegawai->links() !!}
        </div>
    </div>

    <script>

        document.getElementById('search-unit-form').addEventListener('submit', function(event) {
            if (document.getElementById('unit-input').value === '') {
                event.preventDefault();
            }
        });
    </script>

    {{-- SWEET ALERT --}}
    <script>
        document.querySelectorAll('.deleteAlert').forEach(function(button, index) {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah submit langsung

            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Data Akan Dihapus Permanen dari Basis Data!",
                icon: "warning",
                showCancelButton: true,
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Data Berhasil Dihapus",
                        icon: "error"
                    }).then(() => {
                        // Submit form yang terkait dengan tombol ini
                        button.closest('form').submit(); // Submit form terkait
                    });
                }
            });
        });
    });
    </script>
@endsection
