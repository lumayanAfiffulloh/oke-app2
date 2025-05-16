@extends('layouts.main_layout', ['title' => 'Notifikasi'])

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Semua Notifikasi</h5>
          <form action="{{ route('notifications.read-all') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-primary">
              Tandai semua terbaca
            </button>
          </form>
        </div>
        <div class="card-body">
          <div class="list-group">
            @forelse($notifications as $notification)
            <a href="{{ $notification->data['link'] ?? '#' }}"
              class="list-group-item list-group-item-action {{ is_null($notification->read_at) ? 'list-group-item-light' : '' }}">
              <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1">{{ $notification->data['message'] }}</h6>
                <small>{{ $notification->created_at->diffForHumans() }}</small>
              </div>
              <small class="text-muted">
                {{ $notification->created_at->format('d F Y H:i') }}
              </small>
              <form action="{{ route('notifications.read', $notification->id) }}" method="POST"
                class="d-none mark-as-read">
                @csrf
              </form>
            </a>
            @empty
            <div class="text-center py-4">Tidak ada notifikasi</div>
            @endforelse
          </div>

          {{ $notifications->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // Untuk menangani mark as read ketika notifikasi diklik
    document.querySelectorAll('.list-group-item').forEach(item => {
        item.addEventListener('click', function() {
            const form = this.querySelector('.mark-as-read');
            if (form) {
                form.submit();
            }
        });
    });
</script>
@endpush