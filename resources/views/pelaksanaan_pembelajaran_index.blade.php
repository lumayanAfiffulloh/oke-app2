@extends('layouts.app_modern', ['title' => 'Data Pelaksanaan Pembelajan'])
@section('content')
    <div class="card mb-4 bg-white">
        <div class="card-body px-0 pt-0">
            <h2 class="p-3 card-header">Pelaksanaan Pembelajaran</h2>
            <hr class="my-0">
            <table class="table table-striped mb-3" style="font-size: 0.8rem">
                <thead class="text-center">
                    <th class="border-start">No.</th>
                    <th class="border-start">Foto Pegawai</th>
                    <th class="border-start">Nama Pegawai</th>
                    <th class="border-start">Nama Pelatihan</th>
                    <th class="border-start">Tanggal Pelaksanaan</th>
                    <th class="border-start">Klasifikasi</th>
                </thead>
                <tbody>
                    @foreach ($pelaksanaan_pembelajaran as $index => $item)
                        <tr>
                            <td class="text-center"> {{ $pelaksanaan_pembelajaran->firstItem() + $index }} </td>
                            {{-- FOTO PEGAWAI --}}
                            <td class="border-start">
                                @if ($item->pegawai->foto)
                                <a href="{{ Storage::url($item->pegawai->foto) }}" target="blank">
                                    <img src="{{ Storage::url($item->pegawai->foto) }}" class="rounded-circle d-block" style="object-fit: cover; height: 40px; width: 40px;">
                                </a>
                                @endif
                            </td>
                            {{-- NAMA PEGAWAI --}}
                            <td class="border-start">{{ $item->pegawai->nama }}</td>
                            {{-- NAMA PELATIHAN --}}
                            <td class="border-start">{{ $item->rencana_pembelajaran->nama_pelatihan }}</td>
                            {{-- TANGGAL PELAKSANAAN --}}
                            <td class="border-start">{{ $item->tanggal_pelaksanaan }}</td>
                            {{-- KLASIFIKASI --}}
                            <td class="border-start">{{ $item->rencana_pembelajaran->klasifikasi }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mx-3">
                {!! $pelaksanaan_pembelajaran->links() !!}
            </div>
            
        </div>
        
    </div>
@endsection