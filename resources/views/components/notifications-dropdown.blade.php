<div class="dropdown">
    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-bell"></i>
        @if($unreadCount > 0)
            <span class="badge bg-danger">{{ $unreadCount }}</span>
        @endif
    </button>
    <ul class="dropdown-menu" aria-labelledby="notificationDropdown">
        @forelse($notifications as $notification)
            <li><a class="dropdown-item" href="#">{{ $notification->data['message'] ?? 'New notification' }}</a></li>
        @empty
            <li><a class="dropdown-item disabled" href="#">No new notifications</a></li>
        @endforelse
    </ul>
</div>
