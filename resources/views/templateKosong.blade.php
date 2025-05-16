@extends('layouts.main_layout', ['title'=>'Edit Data Pegawai'])
@section('content')
<div class="card mb-3 bg-white">
  <div class="card-body p-0 ">
    <div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">
      {{-- BREADCRUMBS --}}
      <span class="me-2">
        <a href="/data_pegawai" class="ti ti-arrow-left fw-bolder ms-2"></a>
      </span>
      <span class="text-dark text-opacity-50">
        <a href="/data_pegawai">Data Pegawai / </a>
      </span>
      {{-- BREADCRUMBS END --}}

      Edit Data Pegawai
    </div>
    {{-- ISI CARD --}}
  </div>
</div>
@endsection