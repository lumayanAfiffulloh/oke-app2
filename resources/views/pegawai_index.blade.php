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
                <button class="col ps-0 text-start ms-2">
                    <a href="/data_pegawai/create"
                        class="btn btn-outline-primary my-2"
                        style="font-size: 0.9rem">
                        <span>
                            <i class="ti ti-user-plus me-1"></i>
                        </span>
                        <span>Tambah Pegawai</span>
                    </a>
                </button>
                <div class="col-md-3 p-0">
                    <form action="">
                        <div class="input-group">
                            <input class="form-control" type="text" name="q" placeholder="Cari berdasarkan Nama"
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
                                placeholder="Cari berdasarkan Unit Kerja" value="{{ request('w') }}">
                            <button type="submit"
                                class="btn btn-primary">
                                <i class="ti ti-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-3 ps-0">
                    <form action="">
                        <div class="input-group">
                            <input class="form-control" type="text" name="e" placeholder="Cari berdasarkan NIP"
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
									{{ $item->nama }}</div>
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
                                    <form action="/data_pegawai/{{ $item->id }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            style="font-size: 0.8rem"
                                            onclick="return confirm('Anda yakin ingin menghapus data ini?')"
                                            style="font-size: 0.8rem">
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
