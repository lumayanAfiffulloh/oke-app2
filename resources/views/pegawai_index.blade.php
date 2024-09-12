@extends('layouts.app_modern', ['title' => 'Data Pegawai'])
@section('content')
    <style>
        input::placeholder {
            font-size: 13px; /* Atur ukuran font di sini */
        }
    </style>

    <div class="card mb-4 bg-white">
        <div class="card-body px-0 py-0 ">
            <div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">Data Pegawai</div>
            <div class="row mx-1 mt-2 mb-2 justify-content-end align-items-center">
                <button class="col ps-0 text-start ms-2">
                    <a href="/data_pegawai/create" class="btn btn-primary  my-2 tw-transition tw-ease-in-out tw-delay-10 hover:tw-translate-y-0 hover:tw-scale-110 hover:tw-bg-blue-500 tw-duration-200" style="font-size: 0.9rem">
                        <span>
                            <i class="ti ti-user-plus me-1"></i> 
                        </span>
                        <span>Tambah Pegawai</span>
                    </a>
                </button>
                <div class="col-md-3 p-0">
                    <form action="">
                        <div class="input-group">
                            <input class="form-control" type="text" name="q" placeholder="Cari berdasarkan Nama" value="{{ request('q') }}">
                            <button type="submit" class="btn btn-secondary tw-transition tw-ease-in-out tw-delay-10 hover:tw-translate-y-0 hover:tw-scale-105 hover:tw-bg-blue-500 tw-duration-200">
                                <i class="ti ti-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-3 mx-2 p-0">
                    <form action="">
                        <div class="input-group">
                            <input class="form-control" type="text" name="w" placeholder="Cari berdasarkan Unit Kerja" value="{{ request('w') }}">
                            <button type="submit" class="btn btn-secondary tw-transition tw-ease-in-out tw-delay-10 hover:tw-translate-y-0 hover:tw-scale-105 hover:tw-bg-blue-500 tw-duration-200">
                                <i class="ti ti-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-3 ps-0">
                    <form action="">
                        <div class="input-group">
                            <input class="form-control" type="text" name="e" placeholder="Cari berdasarkan NIP" value="{{ request('e') }}">
                            <button type="submit" class="btn btn-secondary tw-transition tw-ease-in-out tw-delay-10 hover:tw-translate-y-0 hover:tw-scale-105 hover:tw-bg-blue-500 tw-duration-200">
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
                        <th class="px-3">No.</th>
                        <th class="px-3">Nama</th>
                        <th class="px-3">NIP</th>
                        <th class="px-3" style="width: 10%;">Email</th>
                        <th class="px-3">Status</th>
                        <th class="px-3">Unit Kerja</th>
                        <th class="px-3">Jabatan</th>
                        <th class="px-3">Jenis Kelamin</th>
                        <th class="px-3" style="width: 20%">AKSI</th>
                    </thead>
                    <tbody>
                        @foreach ($data_pegawai as $index => $item)
                            <tr>
                                <td> {{ $data_pegawai->firstItem() + $index }} </td>
                                <td>
                                    @if ($item->foto)
                                    <a href="{{ Storage::url($item->foto) }}" target="blank">
                                        <img src="{{ Storage::url($item->foto) }}" class="rounded-circle d-block" style="object-fit: cover; height: 40px; width: 40px;">
                                    </a>
                                    @endif
                                    <div>{{ $item->nama }}</div>
                                </td>
                                <td>{{ $item->nip }}</td>
                                <td>{{ $item->user->email }}</td>
                                <td>
                                    @if ($item->status === 'aktif')
                                        <span class="badge rounded-pill bg-success" style="font-size: 0.8rem">Aktif</span>
                                    @else
                                        <span class="badge rounded-pill bg-danger" style="font-size: 0.8rem">Non-Aktif</span>
                                    @endif
                                </td>
                                <td>{{ $item->unit_kerja }}</td>
                                <td>{{ $item->jabatan }}</td>
                                <td>{{ $item->jenis_kelamin }}</td>
                                <td>
                                    <a href="/data_pegawai/{{ $item->id }}/edit" class="btn btn-warning btn-sm tw-transition tw-ease-in-out tw-delay-10 hover:tw--translate-y-0 hover:tw-scale-110 hover:tw-bg-orange-400 tw-duration-200" style="font-size: 0.8rem">Edit</a>
                                    <form action="/data_pegawai/{{ $item->id }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm tw-transition tw-ease-in-out tw-delay-10 hover:tw--translate-y-0 hover:tw-scale-110 hover:tw-bg-red-500 tw-duration-200" style="font-size: 0.8rem" onclick="return confirm('Anda yakin ingin menghapus data ini?')" style="font-size: 0.8rem">
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
        document.getElementById('search-nama-form').addEventListener('submit', function(event) {
            if (document.getElementById('nama-input').value === '') {
                event.preventDefault();
            }
        });
    
        document.getElementById('search-unit-form').addEventListener('submit', function(event) {
            if (document.getElementById('unit-input').value === '') {
                event.preventDefault();
            }
        });
    </script>
@endsection

