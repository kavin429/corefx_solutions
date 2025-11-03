@extends('admin.layouts.admin')

<!-- CSS -->
<link rel="stylesheet" href="{{ asset('css/pending_registrations.css') }}">

@section('content')
<div class="main1">
    <h2>Pending Registrations</h2>

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

    @if($registrations->count())
        <div class="row g-3">
            @foreach($registrations as $reg)
                <div class="col-12">
                    <div class="card1 p-3 shadow-sm d-flex flex-md-row align-items-center justify-content-between gap-3">
                        <div class="flex-fill">
                            <h5>#{{ $loop->iteration }} — {{ $reg->first_name }} {{ $reg->last_name }}</h5>
                            <p class="text-muted mb-1"><strong>Email:</strong> {{ $reg->email }}</p>
                        </div>

                        <div>
                            <!-- View -->
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewRegModal{{ $reg->id }}">
                                View
                            </button>

                            <!-- Delete -->
                            <form action="{{ route('pending.destroy', $reg->id) }}" method="POST" onsubmit="return confirm('Are you sure to delete this record?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- ===== View Modal ===== -->
                <div class="modal fade" id="viewRegModal{{ $reg->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pending Registration #{{ $reg->id }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-start">
                                <table class="table table-bordered table-sm">
                                    <tr><th>First Name</th><td>{{ $reg->first_name }}</td></tr>
                                    <tr><th>Last Name</th><td>{{ $reg->last_name }}</td></tr>
                                    <tr><th>Email</th><td>{{ $reg->email }}</td></tr>
                                    <tr><th>Birth Date</th><td>{{ $reg->birth_date }}</td></tr>
                                    <tr><th>Country</th><td>{{ $reg->country }}</td></tr>
                                    <tr><th>Phone</th><td>{{ $reg->phone }}</td></tr>
                                    <tr><th>Promo Code</th><td>{{ $reg->promo_code ?? '—' }}</td></tr>
                                    <tr><th>Biometrics</th><td>{{ $reg->wants_biometrics ? 'Yes' : 'No' }}</td></tr>
                                    <tr><th>OTP Expires At</th><td>{{ $reg->otp_expires_at }}</td></tr>
                                    <tr><th>OTP Attempts</th><td>{{ $reg->otp_attempts }}</td></tr>
                                    <tr><th>Created At</th><td>{{ $reg->created_at->format('Y-m-d H:i') }}</td></tr>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-warning1">No pending registrations found.</div>
    @endif
</div>
@endsection
