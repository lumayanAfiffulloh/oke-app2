<span class="fw-semibold">{{ $label }}:</span>
@php
  $badgeClass =
      [
          'belum_direvisi' => 'text-bg-danger',
          'perlu_revisi_ulang' => 'text-bg-danger',
          'sedang_direvisi' => 'text-bg-warning',
          'sudah_direvisi' => 'text-bg-info',
      ][$status] ?? 'text-bg-success';

  $statusText =
      [
          'sedang_direvisi' => 'Revisi perlu dikirim',
          'sudah_direvisi' => 'Revisi ditinjau',
      ][$status] ?? ucwords(str_replace('_', ' ', $status));
@endphp
<p class="badge {{ $badgeClass }} fs-1 mt-1">{{ $statusText }}</p>
