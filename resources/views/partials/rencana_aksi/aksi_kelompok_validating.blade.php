{{-- Kalau kelompok belum disetujui --}}
@if ($rencana->kelompokCanValidating->status_revisi != 'sudah_direvisi')
  <div class="btn-group mb-2" role="group">
    <a href="/rencana_pembelajaran/{{ $rencana->id }}/edit" class="btn btn-warning btn-sm" style="font-size: 0.8rem"
      title="Revisi">
      <span class="ti ti-scissors"></span>
    </a>
    <form action="{{ route('rencana_pembelajaran.kirim_revisi', $rencana->id) }}" method="POST"
      id="kirimRevisiForm-{{ $rencana->id }}">
      @csrf
      <button type="submit" class="btn btn-success btn-sm rounded-end-1 kirimRevisiAlert"
        data-form-id="kirimRevisiForm-{{ $rencana->id }}" style="font-size: 0.8rem; border-radius: 0"
        title="Kirim Revisi">
        <span class="ti ti-script"></span>
      </button>
    </form>
  </div>
@else
  <div class="fw-bold mb-2">*Rencana yang revisinya sudah dikirim tidak bisa dihapus atau diedit.</div>
@endif

<div>
  @if ($rencana->kelompokCanValidating->status_revisi)
    @include('partials.rencana_aksi.badge_status', [
        'label' => 'Status Revisi Kelompok',
        'status' => $rencana->kelompokCanValidating->status_revisi,
    ])
  @endif
</div>
