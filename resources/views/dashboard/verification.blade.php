@extends('layouts.dashboard')
<link href="{{ asset('css/verification.css') }}" rel="stylesheet">

@section('content')

<h3 class="mb-4">Account Verification</h3>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="verification-card">

    <form action="{{ route('verification.uploadBoth') }}" method="POST" enctype="multipart/form-data" class="verification-form">
        @csrf
        <h4 class="section-title">Identity & Address Verification</h4>

        {{-- ==============================
            IDENTITY DOCUMENT SECTION
        =============================== --}}
        <label class="form-label">Government ID (NIC, Passport, or Driver’s License)</label>

        @if($profile->identity_document_path)
            <div class="document-link">
                <a href="{{ asset('storage/' . $profile->identity_document_path) }}" target="_blank">View Identity Document</a>
            </div>
            @if($profile->identity_status === 'verified')
                <span class="badge verified">Identity Verified</span>
            @elseif($profile->identity_status === 'rejected')
                <span class="badge rejected">Identity Rejected</span>
            @else
                <span class="badge pending">Identity Pending</span>
            @endif
        @endif

        {{-- Show upload only if not verified --}}
        @if($profile->identity_status !== 'verified')
            <input type="file" name="identity_document" class="form-input mt-2" accept="image/*,application/pdf">
        @endif

        <hr>

        {{-- ==============================
            ADDRESS DOCUMENT SECTION
        =============================== --}}
        <label class="form-label">Address Proof (Utility Bill, Bank Statement, etc.)</label>

        @if($profile->address_document_path)
            <div class="document-link">
                <a href="{{ asset('storage/' . $profile->address_document_path) }}" target="_blank">View Address Document</a>
            </div>
            @if($profile->address_status === 'verified')
                <span class="badge verified">Address Verified</span>
            @elseif($profile->address_status === 'rejected')
                <span class="badge rejected">Address Rejected</span>
            @else
                <span class="badge pending">Address Pending</span>
            @endif
        @endif

        {{-- Show upload only if not verified --}}
        @if($profile->address_status !== 'verified')
            <input type="file" name="address_document" class="form-input mt-2" accept="image/*,application/pdf">
        @endif

        {{-- Upload button appears only if any document is NOT verified --}}
        @if($profile->identity_status !== 'verified' || $profile->address_status !== 'verified')
            <button type="submit" class="btn btn-primary mt-3">Upload Documents</button>
        @endif

    </form>

</div>
@endsection
