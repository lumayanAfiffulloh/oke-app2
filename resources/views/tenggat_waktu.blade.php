@extends('layouts.app_modern', ['title'=>'Tenggat Waktu'])
@section('content')
<div class="card mb-4 bg-white">
  <div class="card-body p-0 ">
    <div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">
      Atur Tenggat Waktu
    </div>
    {{-- ISI CARD --}}
    <div class="p-4">
      <form action="" method="POST">
        @csrf

        <div class="mb-3">
          <label class="fw-semibold">Tenggat Waktu Pengisian Rencana Pembelajaran</label>
          <div class="d-flex gap-2">
            <input type="datetime-local" class="form-control" name="tgl_pengisian_mulai" required>
            <span class="mx-2">s/d</span>
            <input type="datetime-local" class="form-control" name="tgl_pengisian_selesai" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="fw-semibold">Tenggat Waktu Validasi Kelompok</label>
          <div class="d-flex gap-2">
            <input type="datetime-local" class="form-control" name="tgl_validasi_kelompok_mulai" required>
            <span class="mx-2">s/d</span>
            <input type="datetime-local" class="form-control" name="tgl_validasi_kelompok_selesai" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="fw-semibold">Tenggat Waktu Verifikasi Unit Kerja</label>
          <div class="d-flex gap-2">
            <input type="datetime-local" class="form-control" name="tgl_verifikasi_unit_mulai" required>
            <span class="mx-2">s/d</span>
            <input type="datetime-local" class="form-control" name="tgl_verifikasi_unit_selesai" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="fw-semibold">Tenggat Waktu Approval Universitas</label>
          <div class="d-flex gap-2">
            <input type="datetime-local" class="form-control" name="tgl_approval_universitas_mulai" required>
            <span class="mx-2">s/d</span>
            <input type="datetime-local" class="form-control" name="tgl_approval_universitas_selesai" required>
          </div>
        </div>

        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection