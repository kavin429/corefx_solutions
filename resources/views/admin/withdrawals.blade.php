@extends('admin.layouts.admin')

<link rel="stylesheet" href="{{ asset('css/adminWithdrawals.css') }}">

@section('content')
<div class="container">
    <h2>Withdraw Requests</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-container">
        <table class="withdraw-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Submitted At</th>
                    <th>Live ID</th>
                    <th>Client</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Beneficiary</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($withdrawals as $withdraw)
                <tr>
                    <td>{{ ($withdrawals->currentPage() - 1) * $withdrawals->perPage() + $loop->iteration }}</td>
                    <td>
    <span class="user-time" data-utc="{{ $withdraw->created_at->toIso8601String() }}">
        {{ $withdraw->created_at->format('d M Y, h:i A') }}
    </span>
</td>

                    <td>{{ $withdraw->account->live_id ?? 'N/A' }}</td>
                    <td>{{ $withdraw->user->name ?? '-' }}</td>
                    <td style="text-align: right;">${{ number_format($withdraw->amount, 2) }}</td>
                    <td class="capitalize">{{ $withdraw->method }}</td>
                    <td>
                        @if($withdraw->method === 'bank')
                            {{ $withdraw->beneficiary_name }}<br>
                            Bank: {{ $withdraw->bank_name }}<br>
                            Account #: {{ $withdraw->account_number }}<br>
                            IFSC / Address: {{ $withdraw->ifsc ?? $withdraw->bank_address }}
                        @elseif($withdraw->method === 'binance')
                            {{ $withdraw->beneficiary_name }}<br>
                            Binance ID: {{ $withdraw->binance_id }}<br>
                        @elseif($withdraw->method === 'xynder')
                            {{ $withdraw->beneficiary_name }}<br>
                            Xynder ID: {{ $withdraw->xynder_id }}
                        @elseif($withdraw->method === 'upi')
                            {{ $withdraw->beneficiary_name }}<br>
                            UPI ID: {{ $withdraw->upi_id }}
                        @else
                            {{ $withdraw->beneficiary_name ?? '-' }}
                        @endif
                    </td>
                    <td>
                        @if($withdraw->status === 'pending')
                            <span class="status-pending">Pending</span>
                        @elseif($withdraw->status === 'completed')
                            <span class="status-approved">Approved</span>
                        @else
                            <span class="status-rejected">Rejected</span>
                        @endif
                    </td>
                    <td>
                        @if($withdraw->status === 'pending')
                            <form action="{{ route('admin.withdrawals.update', $withdraw->id) }}" method="POST" class="flex space-x-2">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="btn1 btn-accept">Accept</button>
                            </form>

                            <form action="{{ route('admin.withdrawals.update', $withdraw->id) }}" method="POST" class="flex space-x-2 mt-1">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="btn1 btn-reject">Reject</button>
                            </form>
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-gray-500">No withdrawals found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="pagination-wrapper mt-3">
        {{ $withdrawals->links() }}
    </div>
</div>

<script src="{{ asset('js/time.js') }}"></script>
@endsection
