@extends('layouts.app_modern', ['title' => 'Data Pegawai'])
@section('content')
    <div class="card mb-4 bg-white">
        <div class="card-body px-0 pt-0">
            <div class="card-header p-3 fs-5 fw-bolder">Data Pegawai</div>
            <a href="/pegawai/create" class="btn btn-primary mx-3 my-2 tw-transition tw-ease-in-out tw-delay-10 hover:tw-translate-y-0 hover:tw-scale-110 hover:tw-bg-indigo-500 tw-duration-200" style="font-size: 0.9rem">Tambah Pegawai</a>
            <hr class="my-0">
            <table class="table table-striped mb-3" style="font-size: 0.8rem">
                <thead >
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th style="width: 10%">Tanggal Lahir</th>
                    <th>Jabatan</th>
                    <th>Departemen</th>
                    <th>Pendidikan</th>
                    <th>Jenis Kelamin</th>
                    <th>Role</th>
                    <th style="width: 13%">AKSI</th>
                </thead>
                <tbody>
                    @foreach ($pegawai as $index => $item)
                        <tr>
                            <td> {{ $pegawai->firstItem() + $index }} </td>
                            <td>
                                @if ($item->foto)
                                <a href="{{ Storage::url($item->foto) }}" target="blank">
                                    <img src="{{ Storage::url($item->foto) }}" class="rounded-circle d-block" style="object-fit: cover; height: 40px; width: 40px;">
                                </a>
                                @endif
                                <div>{{ $item->nama }}</div>
                            </td>
                            <span for="status" class="badge rounded-pill text-bg-primary"></span>
                            <td id="status">{{ $item->status }}</td>
                            <td>{{ $item->tanggal_lahir }}</td>
                            <td>{{ $item->jabatan }}</td>
                            <td>{{ $item->departemen }}</td>
                            <td>{{ $item->pendidikan }}</td>
                            <td>{{ $item->jenis_kelamin }}</td>
                            <td>{{ $item->role }}</td>
                            <td>
                                <a href="/pegawai/{{ $item->id }}/edit" class="btn btn-warning btn-sm tw-transition tw-ease-in-out tw-delay-100 hover:tw--translate-y-0 hover:tw-scale-110 hover:tw-bg-amber-500 tw-duration-01" style="font-size: 0.8rem">Edit</a>
                                <form action="/pegawai/{{ $item->id }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus data ini?')" style="font-size: 0.8rem">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mx-3">
                {!! $pegawai->links() !!}
            </div>
        </div>
        
    </div>
@endsection