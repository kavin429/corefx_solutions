@extends('admin.layouts.admin')
<link rel="stylesheet" href="{{ asset('css/adminVerification.css') }}">

@section('content')
<div class="admin-verifications-container">
    <h2>User Verification Requests</h2>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    {{-- Search Form --}}
    <form action="{{ route('admin.verifications') }}" method="GET" class="mb-4">
        <div class="row g-2 align-items-end">
            <div class="col-md-7">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Enter name or email">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.verifications') }}" class="btn btn-secondary w-100">Reset</a>
            </div>
        </div>
    </form>

    <div class="verification-table">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Identity Document</th>
                    <th>Identity Status</th>
                    <th>Address Document</th>
                    <th>Address Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($profiles as $profile)
                    <tr>
                        <td>{{ ($profiles->currentPage() - 1) * $profiles->perPage() + $loop->iteration }}</td>
                        <td>{{ $profile->user->name }}<br>{{ $profile->user->email }}</td>

                        {{-- Identity Document --}}
                        <td>
                            @if($profile->identity_document_path)
                                <a href="{{ asset('storage/' . $profile->identity_document_path) }}" target="_blank">View</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $profile->identity_status }}">
                                {{ ucfirst($profile->identity_status) }}
                            </span>

                            {{-- Show buttons only if pending --}}
                            @if($profile->identity_status === 'pending' && $profile->identity_document_path)
                                <form action="{{ route('admin.verifications.approveIdentity', $profile) }}" method="POST" class="inline-form">
                                    @csrf
                                    <button class="btn approve">Approve</button>
                                </form>
                                <form action="{{ route('admin.verifications.rejectIdentity', $profile) }}" method="POST" class="inline-form">
                                    @csrf
                                    <button class="btn reject">Reject</button>
                                </form>
                            @endif
                        </td>

                        {{-- Address Document --}}
                        <td>
                            @if($profile->address_document_path)
                                <a href="{{ asset('storage/' . $profile->address_document_path) }}" target="_blank">View</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $profile->address_status }}">
                                {{ ucfirst($profile->address_status) }}
                            </span>

                            {{-- Show buttons only if pending --}}
                            @if($profile->address_status === 'pending' && $profile->address_document_path)
                                <form action="{{ route('admin.verifications.approveAddress', $profile) }}" method="POST" class="inline-form">
                                    @csrf
                                    <button class="btn approve">Approve</button>
                                </form>
                                <form action="{{ route('admin.verifications.rejectAddress', $profile) }}" method="POST" class="inline-form">
                                    @csrf
                                    <button class="btn reject">Reject</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No verification requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination Links --}}
    @if($profiles->hasPages())
        <div class="mt-3 d-flex justify-content-center">
            {{ $profiles->links() }}
        </div>
    @endif
</div>
@endsection
