@extends('layouts.dashboard') 


<!-- Link your profile CSS -->
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">


@section('content')
<h3 class="mb-4">My Profile</h3>
<div class="profile-container">

    {{-- Profile Picture --}}
    <div class="profile-card">
        @if (session('status'))
    <div class="alert alert-success mb-3">
        {{ session('status') }}
    </div>
    @endif

@if (session('success'))
    <div class="alert alert-success mb-3">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger mb-3">
        {{ session('error') }}
    </div>
@endif

        <h2 class="profile-section-title">Profile Picture</h2>
        <img src="{{ $user->profile->avatar_path ? Storage::url($user->profile->avatar_path) : asset('pics/client2.png') }}" 
             alt="Avatar" class="profile-avatar">

        <form action="{{ route('dashboard.profile.avatar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="avatar" required>
            <button type="submit">Upload New Picture</button>
        </form>
    </div>

    {{-- Personal Details --}}
        <!-- Personal details card -->
        <div class="profile-card">
            <h2 class="profile-section-title">Personal Details</h2>
            <div class="profile-info">
                <label>Client ID:</label> <p>{{ $user->id }}</p>
                <label>Name:</label> <p>{{ $user->name }}</p>
                <label>Email:</label> <p>{{ $user->email }}</p>
                <label>Phone:</label> <p>{{ $user->profile->phone_code }} {{ $user->profile->phone_number }}</p>
                <label>Country:</label> <p>{{ $user->profile->country }}</p>
                <label>Birth Date:</label> <p>{{ $user->profile->birth_date ? $user->profile->birth_date->format('d-m-Y') : '-' }}</p>
                <label>Promo Code:</label> <p>{{ $user->promo_code }}</p>
            </div>
        </div>

{{-- Change Password --}}
<div class="profile-card">
        <h2 class="profile-section-title">Change Password</h2>



    <form method="POST" action="{{ route('dashboard.profile.password') }}">
        @csrf
        <div class="form-group">
            <label for="current_password">Current Password</label>
            <div class="password-wrapper">
                <input type="password" id="current_password" name="current_password" required>
                <span class="toggle-password" onclick="togglePassword('current_password', this)">Show</span>
            </div>
        </div>

        <div class="form-group">
            <label for="new_password">New Password</label>
            <div class="password-wrapper">
                <input type="password" id="new_password" name="new_password" required>
                <span class="toggle-password" onclick="togglePassword('new_password', this)">Show</span>
            </div>
        </div>

        <div class="form-group">
            <label for="new_password_confirmation">Confirm New Password</label>
            <div class="password-wrapper">
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
                <span class="toggle-password" onclick="togglePassword('new_password_confirmation', this)">Show</span>
            </div>
        </div>

<div class="form-buttons">
    <button type="submit">Change Password</button>
    <a href="{{ route('forgot-password.show') }}" class="forgot-btn">
        Forgot Password
    </a>
</div>

    </form>
</div>




</div>



<script>
function togglePassword(fieldId, toggleElement) {
    const input = document.getElementById(fieldId);
    if (input.type === "password") {
        input.type = "text";
        toggleElement.textContent = "Hide";
    } else {
        input.type = "password";
        toggleElement.textContent = "Show";
    }
}
</script>
@endsection
