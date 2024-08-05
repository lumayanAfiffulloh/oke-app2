@extends('mylayout', ['title' => 'Data Pegawai'])
@section('content')
    <div class="card">
        <div class="card-body">
            <h3>Data Pegawai</h3>
            <a href="/pegawai/create" class="btn btn-primary">Tambah Pegawai</a>
            <table class="table table-striped">
                <thead>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Tanggal Lahir</th>
                    <th>Jabatan</th>
                    <th>Departemen</th>
                    <th>Pendidikan</th>
                    <th>Jenis Kelamin</th>
                    <th>Role</th>
                    <th>AKSI</th>
                </thead>
                <tbody>
                    @foreach ($pegawai as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if ($item->foto)
                                <a href="{{ Storage::url($item->foto) }}" target="blank">
                                    <img src="{{ Storage::url($item->foto) }}" width="60" class="rounded">
                                </a>
                                @endif
                                {{ $item->nama }}
                            </td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->tanggal_lahir }}</td>
                            <td>{{ $item->jabatan }}</td>
                            <td>{{ $item->departemen }}</td>
                            <td>{{ $item->pendidikan }}</td>
                            <td>{{ $item->jenis_kelamin }}</td>
                            <td>{{ $item->role }}</td>
                            <td>
                                <a href="/pegawai/{{ $item->id }}/edit" class="btn btn-warning btn-sm ">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $pegawai->links() !!}
            
        </div>
        
    </div>
@endsection