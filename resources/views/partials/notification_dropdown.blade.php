<li class="nav-item dropdown position-relative">
  <a class="nav-link position-relative nav-icon-hover" href="#" id="notifDropdown" role="button"
    data-bs-toggle="dropdown" aria-expanded="false">
    <i class="ti ti-bell-ringing fs-5"></i>
    @if($unreadCount > 0)
    <span class="notification bg-danger rounded-circle position-absolute p-1 border border-white">
      {{ $unreadCount > 9 ? '9+' : $unreadCount }}
    </span>
    @endif
  </a>
  <div class="dropdown-menu dropdown-menu-start dropdown-menu-animate-up py-0" aria-labelledby="notifDropdown">
    <div class="dropdown-content">
      <div class="d-flex align-items-center justify-content-between py-3 px-4 border-bottom">
        <h5 class="mb-0">Notifikasi</h5>
        <form action="{{ route('notifications.read-all') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-sm btn-outline-secondary">
            Tandai semua terbaca
          </button>
        </form>
      </div>
      <div class="notification-scroll position-relative" style="max-height: 300px; overflow-y: auto;">
        @forelse($notifications as $notification)
        <div class="notification-item {{ is_null($notification->read_at) ? 'bg-light' : '' }}">
          <a href="{{ $notification->data['link'] ?? '#' }}" class="d-flex align-items-center py-3 px-4">
            <div class="flex-shrink-0">
              <i class="ti ti-{{ $this->getNotificationIcon($notification->data['type']) }} fs-5"></i>
            </div>
            <div class="flex-grow-1 ms-3">
              <p class="mb-0">{{ $notification->data['message'] }}</p>
              <small class="text-muted">
                {{ $notification->created_at->diffForHumans() }}
              </small>
            </div>
            @if(is_null($notification->read_at))
            <span class="badge bg-danger rounded-circle ms-auto p-1"></span>
            @endif
          </a>
          <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="d-none mark-as-read">
            @csrf
          </form>
        </div>
        @empty
        <div class="text-center py-4">Tidak ada notifikasi</div>
        @endforelse
      </div>
      <div class="py-2 px-4 border-top">
        <a href="{{ route('notifications.index') }}" class="text-primary d-block text-center">
          Lihat semua notifikasi
        </a>
      </div>
    </div>
  </div>
</li>

@push('scripts')
<script>
  // Hanya untuk menangani mark as read ketika notifikasi diklik
  document.querySelectorAll('.notification-item').forEach(item => {
      item.addEventListener('click', function() {
          const form = this.querySelector('.mark-as-read');
          if (form) {
              form.submit();
          }
      });
  });
</script>
@endpush