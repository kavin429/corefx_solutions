@extends('layouts.dashboard')
<link href="{{ asset('css/verification.css') }}" rel="stylesheet">

@section('content')

<div class="verification-container">

    <h3 class="mb-4">Account Verification</h3>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="verification-card">

        {{-- Identity Verification --}}
        <form action="{{ route('verification.uploadIdentity') }}" method="POST" enctype="multipart/form-data" class="verification-form">
            @csrf
            <h4 class="section-title">Identity Verification</h4>

            @if(!$profile->identity_document_path || $profile->identity_status !== 'verified')
                <label class="form-label">Upload Government ID (NIC, Passport, or Driver’s License.)</label>
                <input type="file" name="identity_document" class="form-input" accept="image/*,application/pdf" required>
                <button type="submit" class="btn btn-primary">Upload Identity Proof</button>
            @endif

            @if($profile->identity_document_path)
                <div class="document-link">
                    <a href="{{ $profile->identity_document_url }}" target="_blank">View Uploaded Document</a>
                </div>

                @if($profile->identity_status === 'verified')
                    <span class="badge verified">Verified</span>
                @elseif($profile->identity_status === 'rejected')
                    <span class="badge rejected">Rejected</span>
                @else
                    <span class="badge pending">Pending</span>
                @endif
            @endif
        </form>

        {{-- Address Verification --}}
        <form action="{{ route('verification.uploadAddress') }}" method="POST" enctype="multipart/form-data" class="verification-form">
            @csrf
            <h4 class="section-title">Address Verification</h4>

            @if(!$profile->address_document_path || $profile->address_status !== 'verified')
                <label class="form-label">Upload Address Proof</label>
                <input type="file" name="address_document" class="form-input" accept="image/*,application/pdf" required>
                <button type="submit" class="btn btn-success">Upload Address Proof</button>
            @endif

            @if($profile->address_document_path)
                <div class="document-link">
                    <a href="{{ $profile->address_document_url }}" target="_blank">View Uploaded Document</a>
                </div>

                @if($profile->address_status === 'verified')
                    <span class="badge verified">Verified</span>
                @elseif($profile->address_status === 'rejected')
                    <span class="badge rejected">Rejected</span>
                @else
                    <span class="badge pending">Pending</span>
                @endif
            @endif
        </form>

    </div>
</div>
@endsection
