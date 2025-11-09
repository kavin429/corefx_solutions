@extends('admin.layouts.admin')

<link rel="stylesheet" href="{{ asset('css/adminDeposit.css') }}">

@section('content')
    <div class="container-fluid">
        <h2>Deposit Requests</h2> 

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Submitted At</th>
                        <th>Client</th>
                        <th>Live ID</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Screenshot</th>
                        <th>Status</th>   
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($deposits as $deposit)
                    <tr>
                        <td>{{ ($deposits->currentPage() - 1) * $deposits->perPage() + $loop->iteration }}</td>
                        <td>
    <span class="user-time" data-utc="{{ $deposit->created_at->toIso8601String() }}">
        {{ $deposit->created_at->format('d M Y, h:i A') }}
    </span>
</td>

                        <td>{{ $deposit->user->name ?? 'N/A' }}</td>
                        <td>{{ $deposit->account->live_id ?? 'N/A' }}</td>
                        <td style="text-align: right;">${{ number_format($deposit->amount, 2) }}</td>
                        <td>{{ ucfirst($deposit->method) }}</td>
                        <td>
                            @if($deposit->screenshot_path)
                                <a href="{{ asset('storage/'.$deposit->screenshot_path) }}" target="_blank">
                                    <img src="{{ asset('storage/'.$deposit->screenshot_path) }}" 
                                         alt="screenshot" class="img-thumbnail" width="100">
                                </a>
                            @else
                                <span class="text-muted">No screenshot</span>
                            @endif
                        </td>
                        <td>
                            @if($deposit->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($deposit->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($deposit->status == 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($deposit->status) }}</span>
                            @endif
                        </td>
                        
                        <td>
                            @if($deposit->status == 'pending')
                                {{-- Approve with adjustable amount --}}
                                <form action="{{ route('admin.deposits.approve', $deposit->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <div class="input-group input-group-sm mb-1">
                                        <input type="number" step="0.01" name="amount" value="{{ $deposit->amount }}" class="form-control" required>
                                        <button type="submit" class="btn btn-success">Approve</button>
                                    </div>
                                </form>

                                {{-- Reject --}}
                                <form action="{{ route('admin.deposits.reject', $deposit->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                </form>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">No deposit requests yet</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper mt-3">
            {!! $deposits->links('pagination::bootstrap-5') !!}
        </div>
    
    </div>
    <script src="{{ asset('js/time.js') }}"></script>
@endsection
