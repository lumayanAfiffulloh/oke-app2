@if ($rencana->unitKerjaCanVerifying->status == 'disetujui')
  <div class="fw-bold">*Rencana yang sudah disetujui Unit Kerja tidak bisa dihapus atau diedit</div>
@elseif ($rencana->unitKerjaCanVerifying->status == 'direvisi')
  @if ($rencana->unitKerjaCanVerifying->status_revisi != 'sudah_direvisi')
    <div class="btn-group mb-2" role="group">
      <a href="/rencana_pembelajaran/{{ $rencana->id }}/edit" class="btn btn-warning btn-sm" style="font-size: 0.8rem"
        title="Revisi">
        <span class="ti ti-scissors"></span>
      </a>
      <form action="{{ route('rencana_pembelajaran.kirim_revisi', $rencana->id) }}" method="POST"
        id="kirimRevisiUnitKerjaForm-{{ $rencana->id }}">
        @csrf
        <button type="submit" class="btn btn-success btn-sm rounded-end-1 kirimRevisiAlert"
          data-form-id="kirimRevisiUnitKerjaForm-{{ $rencana->id }}" style="font-size: 0.8rem; border-radius: 0"
          title="Kirim Revisi Unit Kerja">
          <span class="ti ti-script"></span>
        </button>
      </form>
    </div>
  @else
    <div class="fw-bold mb-2">*Revisi Unit Kerja sudah dikirim, tidak bisa diedit lagi.</div>
  @endif
  <div>
    @include('partials.rencana_aksi.badge_status', [
        'label' => 'Status Revisi Unit Kerja',
        'status' => $rencana->unitKerjaCanVerifying->status_revisi,
    ])
  </div>
@else
  <div class="fw-bold">*Rencana dalam proses verifikasi Unit Kerja</div>
@endif
