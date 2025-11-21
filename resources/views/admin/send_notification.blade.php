@extends('admin.layouts.admin')

<link rel="stylesheet" href="{{ asset('css/adminNotifications.css') }}">

@section('content')
<div class="container mt-5">
    <h2>Send Notification</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Send Notification Form --}}
    <form action="{{ route('admin.notifications.send') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" id="message" rows="4" class="form-control" required>{{ old('message') }}</textarea>
        </div>

<div class="mb-3">
    <label class="form-label">Select Clients</label>

    <!-- Search Input -->
    <input type="text" id="userSearch" class="form-control mb-3" placeholder="Search by name or email">

    <!-- Select All -->
    <div class="form-check mb-2">
        <input class="form-check-input" type="checkbox" id="selectAll" value="all">
        <label class="form-check-label" for="selectAll">Send to All Clients</label>
    </div>

    <!-- Users List (hidden initially) -->
    <div id="usersList" style="display: none;">
        @foreach($users as $user)
            <div class="form-check user-item">
                <input class="form-check-input user-checkbox" type="checkbox" name="users[]" value="{{ $user->id }}" id="user{{ $user->id }}">
                <label class="form-check-label" for="user{{ $user->id }}">
                    {{ $user->name }} ({{ $user->email }})
                </label>
            </div>
        @endforeach
    </div>
</div>

<script>
const searchInput = document.getElementById('userSearch');
const usersList = document.getElementById('usersList');
const userItems = document.querySelectorAll('.user-item');

// Filter and show list on typing
searchInput.addEventListener('keyup', function() {
    const query = this.value.toLowerCase();
    let hasVisible = false;

    userItems.forEach(item => {
        const label = item.querySelector('label').textContent.toLowerCase();
        if(label.includes(query)) {
            item.style.display = '';
            hasVisible = true;
        } else {
            item.style.display = 'none';
        }
    });

    // Show or hide the container based on matches
    usersList.style.display = hasVisible ? 'block' : 'none';
});

// Select All functionality
const selectAllCheckbox = document.getElementById('selectAll');
selectAllCheckbox.addEventListener('change', function() {
    const checked = this.checked;
    document.querySelectorAll('.user-checkbox').forEach(cb => cb.checked = checked);
});
</script>


        <button type="submit" class="btn1 btn-primary">Send Notification</button>
    </form>

    {{-- ============================================= --}}
    {{-- 🔹 Notification History Section --}}
    {{-- ============================================= --}}
    <hr class="my-5">

    {{-- Filters --}}
    <form action="{{ route('admin.notifications.index') }}" method="GET" class="mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by title/message">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn1 btn-secondary me-2">Filter</button>
                <a href="{{ route('admin.notifications.index') }}" class="btn1 btn-light">Reset</a>
            </div>
        </div>
    </form>

{{-- ============================================= --}}
    {{-- 🔹 Admin Activities --}}
    {{-- ============================================= --}}
    <hr class="my-5">
    <h2 class="container">Admin Activities</h2>

    @if($activities->count())
        <form action="{{ route('admin.activities.bulkDelete') }}" method="POST" id="activityDeleteForm">
            @csrf
            @method('DELETE')

            <div class="d-flex justify-content-between align-items-center mb-2">
                <div></div>
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete selected activities?')">
                    <i class="bi bi-trash"></i> Delete Selected
                </button>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAllActivities"></th>
                            <th>#</th>
                            <th>Sent At</th>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Recipient</th>
                            <th>Status</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activities as $activity)
                            <tr>
                                <td><input type="checkbox" name="selected[]" value="{{ $activity->id }}" class="activity-checkbox"></td>
                                <td>{{ ($activities->currentPage() - 1) * $activities->perPage() + $loop->iteration }}</td>
                                <td>
    <span class="user-time" data-utc="{{ $activity->created_at->toIso8601String() }}">
        {{ $activity->created_at->format('d-m-Y H:i') }}
    </span>
</td>                        
                                <td>{{ $activity->title }}</td>
                                <td class="break-word">{{ $activity->message }}</td>
                                <td>{{ optional($activity->notifiable)->name ?? 'User' }}</td>
                                <td>
                                    @if($activity->is_read)
                                        <span class="badge bg-success">Read</span>
                                    @else
                                        <span class="badge bg-secondary">Unread</span>
                                    @endif
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $activities->links('pagination::bootstrap-5') }}
        </form>
    @else
        <p class="text-muted mt-3">No activities found.</p>
    @endif


{{-- ============================================= --}}
{{-- 🔸 User Notifications (with Bulk Delete) --}}
{{-- ============================================= --}}
<div class="mt-5">
    <h2 class="container">User Notifications</h2>

    @if($notifications->count())
        <form action="{{ route('admin.notifications.bulkDelete') }}" method="POST" id="notificationDeleteForm">
            @csrf
            @method('DELETE')

            <div class="d-flex justify-content-between align-items-center mb-2">
                <div></div>
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete selected notifications?')">
                    <i class="bi bi-trash"></i> Delete Selected
                </button>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAllNotifications"></th>
                            <th>#</th>
                            <th>Received At</th>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Sent By</th>
                            <th>Status</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notifications as $notification)
                            @if($notification->sender_type === 'user')
                                <tr>
                                    <td>
                                        <input type="checkbox" name="selected[]" value="{{ $notification->id }}" class="notification-checkbox">
                                    </td>
                                    <td>{{ ($notifications->currentPage() - 1) * $notifications->perPage() + $loop->iteration }}</td>
                                    <td>
    <span class="user-time" data-utc="{{ $notification->created_at->toIso8601String() }}">
        {{ $notification->created_at->format('d-m-Y H:i') }}
    </span>
</td>
                                    <td>{{ $notification->title }}</td>
                                    <td class="break-word">{{ $notification->message }}</td>
                                    <td> Client ID: {{ $notification->sender_id }}</td>


                                    <td> 
                                        @if($notification->is_read)
                                            <span class="badge bg-success">Read</span>
                                        @else
                                            <span class="badge bg-secondary">Unread</span>
                                        @endif
                                    </td>
                                    
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- pagination --}}
            <div class="mt-3">
                {{ $notifications->links('pagination::bootstrap-5') }}
            </div>
        </form>
    @else
        <p class="text-center mt-3 text-muted">No notifications received from users.</p>
    @endif
</div>
</div>

<script>
    // ===== Select All for Users =====
    document.getElementById('selectAll').addEventListener('change', function() {
        document.querySelectorAll('.user-checkbox').forEach(cb => cb.checked = this.checked);
    });

    // ===== Select All for Activities =====
    document.getElementById('selectAllActivities')?.addEventListener('change', function() {
        document.querySelectorAll('.activity-checkbox').forEach(cb => cb.checked = this.checked);
    });

    // ===== Select All for Notifications =====
    document.getElementById('selectAllNotifications')?.addEventListener('change', function() {
        document.querySelectorAll('.notification-checkbox').forEach(cb => cb.checked = this.checked);
    });
</script>


<script src="{{ asset('js/time.js') }}"></script>
@endsection

