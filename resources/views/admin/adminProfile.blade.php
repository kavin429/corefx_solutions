@extends('admin.layouts.admin')

<link rel="stylesheet" href="{{ asset('css/adminProfile.css') }}">

@section('content')

    <div class="profile-wrapper">

        <!-- Edit Profile Card -->
        <div class="profile-card">
            <h4>Edit Profile</h4>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3 text-center">
                    <img src="{{ $admin->profile_picture_url }}" 
                    alt="Admin Avatar" 
                    class="profile-pic">
                </div>

                <div class="mb-3">
                    <label>Profile Picture</label>
                    <input type="file" name="profile_picture" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ Auth::guard('admin')->user()->name }}">
                </div>
            
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ Auth::guard('admin')->user()->email }}">
                </div>

                <button class="btn1 btn-primary w-100" type="submit">Update Profile</button>
            </form>
        </div>

        <!-- Change Password Card -->

        <div class="profile-card">
            <h4>Change Password</h4>
            <form action="{{ route('admin.profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Current Password</label>
                    <input type="password" name="current_password" class="form-control">
                </div>

                <div class="mb-3">
                    <label>New Password</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <button class="btn1 btn-warning w-100" type="submit">Change Password</button>
            </form>
        </div>

    </div>
@endsection
