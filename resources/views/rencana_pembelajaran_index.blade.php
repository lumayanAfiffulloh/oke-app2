@extends('layouts.app_modern', ['title' => 'Rencana Pembelajaran Anda'])
@section('content')
    <div class="card mb-4 bg-white">
        <div class="card-body px-0 pt-0">
            <h2 class="card-header p-3 fs-5 fw-bolder">Rencana Pembelajaran <span class="fw-bolder tw-text-blue-600">{{ Auth::user()->name }}</span></h2>
            <a href="/rencana_pembelajaran/create" class="btn btn-primary mx-3 my-2" style="font-size: 0.9rem">Tambah Rencana Pembelajaran</a>
            <hr class="my-0">
            <table class="table table-striped mb-3" style="font-size: 0.8rem">
                <thead >
                    <th>No.</th>
                    <th>Tahun</th>
                    <th>Klasifikasi</th>
                    <th>Kategori Klasifikasi</th>
                    <th>Kategori</th>
                    <th>Bentuk Jalur</th>
                    <th>Nama Pelatihan</th>
                    <th>Prioritas</th>
                    <th>AKSI</th>
                </thead>
                <tbody>
                    @foreach ($rencana_pembelajaran as $index => $item)
                        <tr>
                            <td> {{ $rencana_pembelajaran->firstItem() + $index }} </td>
                            <td>{{ $item->tahun }}</td>
                            <td>{{ $item->klasifikasi }}</td>
                            <td>{{ $item->kategori_klasifikasi }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>{{ $item->bentuk_jalur }}</td>
                            <td>{{ $item->nama_pelatihan }}</td>
                            <td>{{ $item->prioritas }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="/rencana_pembelajaran/{{ $item->id }}/edit" class="btn btn-warning btn-sm" style="font-size: 0.8rem">Edit</a>
                                    <form action="/rencana_pembelajaran/{{ $item->id }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus data ini?')" style="font-size: 0.8rem; border-radius: 0;">
                                            Hapus
                                        </button>
                                    </form>
                                    <a href="/rencana_pembelajaran/{{ $item->id }}/edit" class="btn btn-primary btn-sm " style="font-size: 0.8rem">Detail</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mx-3">
                {!! $rencana_pembelajaran->links() !!}
            </div>
        </div>
    </div>
@endsection