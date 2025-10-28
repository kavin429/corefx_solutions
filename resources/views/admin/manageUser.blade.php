@extends('admin.layouts.admin')

<!-- CSS -->
<link rel="stylesheet" href="{{ asset('css/manage-users.css') }}">

<!-- JS -->
<script src="{{ asset('js/manage-users.js') }}" defer></script>

@section('content')
<div class="main1">
    <h2>Manage Users</h2>
    <!-- Search Form -->
     <form action="{{ route('users.index') }}" method="GET" class="search-form">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search by id, name, email, or phone">
        <button type="submit" class="btn1 btn-primary btn-sm">Search</button>
    </form>

    <!-- Success & Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-3">
        @forelse($users as $user)
            <div class="col-12">
                <div class="card1 p-3 shadow-sm d-flex flex-md-row align-items-center gap-3">
                    <!-- Avatar -->
                    <img src="{{ $user->profile->avatar_path ? Storage::url($user->profile->avatar_path) : asset('pics/client2.png') }}" 
                         class="profile-avatar mb-2 mb-md-0" alt="Avatar">

                    <!-- User Info -->
                    <div class="flex-fill text-md-start text-center">
                        <h5>Client ID: {{ $user->id }}</h5>
                        <p class="text-muted mb-1">{{ $user->name }}</p>
                        <p class="text-muted mb-1">{{ $user->email }}</p>
                        
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                        <!-- View -->
                        <button class="btn1 btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewUserModal{{ $user->id }}">
                            View
                        </button>

                        <!-- Edit  -->
                        <button class="btn1 btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                            Edit
                        </button>

                        <!-- Assign / Update Live ID -->
                        @if($user->accounts->where('live_id', null)->count() > 0)
                        <button class="btn1 btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#liveIdModal{{ $user->id }}">
                            Assign Live ID
                        </button>
                        @endif

                        <!-- Reset Password -->
                        <form action="{{ route('admin.password.send', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn1 btn-sm btn-info">Reset Password</button>
                        </form>

                        <!-- Toggle Status 
                        <form id="toggle-form-{{ $user->id }}" action="{{ route('users.toggleStatus', $user->id) }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-success' : 'btn-secondary' }}">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form> -->

                        <!-- Delete -->
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn1 btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- ===== View User Modal ===== -->
            <div class="modal fade" id="viewUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">User Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-start">
                            <p><strong>Profile Picture:</strong></p>
                            <img src="{{ $user->profile->avatar_path ? Storage::url($user->profile->avatar_path) : asset('pics/client2.png') }}" 
                                 class="profile-avatar mb-3" alt="Avatar">
                            <p><strong>ID:</strong> {{ $user->id }}</p>                                 
                            <p><strong>Name:</strong> {{ $user->name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Phone:</strong> {{ $user->profile->phone_code ?? '' }} {{ $user->profile->phone_number ?? '-' }}</p>
                            <p><strong>Country:</strong> {{ $user->profile->country ?? 'N/A' }}</p>
                            <p><strong>Birth Date:</strong> {{ $user->profile->birth_date ? $user->profile->birth_date->format('d-m-Y') : 'N/A' }}</p>
                            <p><strong>Promo Code:</strong> {{ $user->promo_code ?? 'N/A' }}</p>
                            <p><strong>Live ID Accounts:</strong></p>
                            <ul>
                                @forelse($user->accounts as $account)
                                    <li>{{ $account->live_id ?? 'Not Assigned' }} ({{ ucfirst($account->type) }})</li>
                                @empty
                                    <li>No accounts</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn1 btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== Edit User Modal ===== -->
            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-start">
                                <div class="mb-2">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                </div>
                                <div class="mb-2">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                </div>
                                <div class="mb-2">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control" value="{{ $user->profile->phone_number ?? '' }}">
                                </div>
                                <div class="mb-2">
                                    <label>Country</label>
                                    <input type="text" name="country" class="form-control" value="{{ $user->profile->country ?? '' }}">
                                </div>
                                <div class="mb-2">
                                    <label>Birth Date</label>
                                    <input type="date" name="birth_date" class="form-control"
                                        value="{{ $user->profile && $user->profile->birth_date ? \Carbon\Carbon::parse($user->profile->birth_date)->format('Y-m-d') : '' }}">
                                </div>
                                <div class="mb-2">
                                    <label>Promo Code</label>
                                    <input type="text" name="promo_code" class="form-control" value="{{ $user->promo_code ?? '' }}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 

            <!-- ===== Assign / Update Live ID Modal ===== -->
            <div class="modal fade" id="liveIdModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog"> 
                    <div class="modal-content">
                        <form action="{{ route('users.assignLiveId', $user->id) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Assign / Update Live ID</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-start">
                                <div class="mb-3">
                                    <label for="account_id_{{ $user->id }}" class="form-label">Select Account</label>
                                    <select name="account_id" id="account_id_{{ $user->id }}" class="form-select" required>
                                        @foreach($user->accounts->where('live_id', null) as $account)
                                            <option value="{{ $account->id }}">{{ ucfirst($account->type) }} - {{ $account->id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="live_id_{{ $user->id }}" class="form-label">Live ID</label>
                                    <input type="text" name="live_id" id="live_id_{{ $user->id }}" class="form-control" placeholder="Enter Live ID" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn1 btn-success btn-sm">Save Live ID</button>
                                <button type="button" class="btn1 btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @empty
            <p class="text-center">No users found.</p>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="mt-3">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection


