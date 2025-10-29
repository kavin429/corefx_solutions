@extends('layouts.dashboard')

<link rel="stylesheet" href="{{ asset('css/notification.css') }}">

@section('content')
<!-- <div class="container mt-4"> -->
    <h3 class="mb-4">Notifications & Activities</h3>

    {{-- 🔍 Search & Date Filter --}}
    <form method="GET" action="{{ route('user.notifications') }}" class="mb-3 d-flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
               placeholder="Search notifications or activities...">
        <input type="date" name="date" value="{{ request('date') }}" class="form-control w-auto">
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('user.notifications') }}" class="btn btn-secondary">Reset</a>
    </form>

    <div class="row">
        <!-- ✅ Left side: Notifications -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <strong>Notifications</strong>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($notifications as $note)
                        <li class="list-group-item {{ $note->is_read ? '' : 'fw-bold' }}">
                            <strong>{{ $note->title }}</strong>  
                            <br>
                            {{ $note->message }}
                            <br>
                            <small class="text-muted">{{ $note->created_at->diffForHumans() }}</small>
                        </li>
                    @empty
                        <li class="list-group-item">No notifications found.</li>
                    @endforelse
                </ul>
                <div class="card-footer">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>

        <!-- ✅ Right side: Activities -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <strong>Your Activities</strong>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($activities as $activity)
                        <li class="list-group-item">
                            <strong>{{ $activity->title }}</strong>  
                            <br>
                            {{ $activity->message }}
                            <br>
                            <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                        </li>
                    @empty
                        <li class="list-group-item">No activities found.</li>
                    @endforelse
                </ul>
                <div class="card-footer">
                    {{ $activities->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
