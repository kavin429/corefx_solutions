@extends('layouts.dashboard')

<!-- Link your CSS -->
<link rel="stylesheet" href="{{ asset('css/transaction.css') }}">

@section('content')
<!-- <div class="container-fluid"> -->
    <h3 class="mb-4">My Transactions</h3> 

    <!-- Summary Cards -->
    <div class="summary-row mb-4">
        <div class="summary-box credit-box">
            <p>Total Deposit</p>
            <h4>$ {{ number_format($totalDeposit, 2) }}</h4>
        </div>
        <div class="summary-box debit-box">
            <p>Total Withdraw</p>
            <h4>$ {{ number_format($totalWithdraw, 2) }}</h4>
        </div>
    </div>
<!-- Search & Filter -->
<form method="GET" class="transaction-filter-form d-flex flex-wrap align-items-center gap-2">
    <input type="text" name="search" placeholder="Search transactions..." 
           class="form-control flex-grow-1" value="{{ request('search') }}">

    <select name="account" class="form-control flex-grow-1">
        <option value="">All Accounts</option>
        @foreach($accounts as $account)
            <option value="{{ $account->id }}" {{ request('account') == $account->id ? 'selected' : '' }}>
                {{ $account->live_id }}
            </option>
        @endforeach
    </select>

    <div class="date-wrapper d-flex gap-2 flex-grow-1">
        <input type="date" name="start_date" class="form-control">
        <input type="date" name="end_date" class="form-control">
    </div>

    <div class="d-flex gap-2 flex-grow-1">
        <button type="submit" class="btn btn-primary flex-grow-1">Filter</button>
        <button type="submit" formaction="{{ route('dashboard.transactions.pdf') }}" class="btn btn-success flex-grow-1">
            Download PDF
        </button>
    </div>
</form>



    @if($transactions->count())
        <div class="transaction-list mt-3">
            @foreach($transactions as $transaction)
                @php
                    $isDeposit = strtolower($transaction->type) === 'deposit';
                @endphp

                <div class="txn-card">
                    <!-- Left Circle with Arrow + Status -->
                    <div class="txn-left">
                        <div class="txn-circle {{ $isDeposit ? 'credit' : 'debit' }} {{ $transaction->status }}">
                            <!-- Arrow -->
                            @if($isDeposit)
                                <i class="bi bi-arrow-up"></i>
                            @else
                                <i class="bi bi-arrow-down"></i>
                            @endif

                            <!-- Status Dot / Cross -->
                            @if($transaction->status === 'completed' || $transaction->status === 'pending')
                                <span class="status-dot"></span>
                            @endif
                        </div>
                    </div>

                    <!-- Middle Info -->
                    <div class="txn-middle">
                        <p class="txn-type">{{ $isDeposit ? 'Deposit' : 'Withdraw' }}</p>

                        <!-- Show account number only if All Accounts is selected -->
                        @if(request('account') === null)
                            <p class="txn-account">Account: {{ $transaction->account?->live_id ?? '-' }}</p>
                        @endif

                        <p class="txn-amount {{ $isDeposit ? 'amount-credit' : 'amount-debit' }}">
                            $ {{ number_format($transaction->amount, 2) }}
                        </p>

                        <!-- Status label
                        <p class="txn-status">
                            @if($transaction->status === 'pending')
                                <span class="status-pending">Pending</span>
                            @elseif($transaction->status === 'completed')
                                <span class="status-completed">Completed</span>
                            @elseif($transaction->status === 'failed')
                                <span class="status-failed">Failed</span>
                            @else
                                <span class="status-other">{{ ucfirst($transaction->status) }}</span>
                            @endif
                        </p>  -->
                    </div>

                    <!-- Right Info -->
                    <div class="txn-right">
                        <p class="txn-balance">Avl Blnc: $ {{ number_format($transaction->account?->balance ?? 0, 2) }}</p>
                        <p class="txn-date">{{ $transaction->created_at->format('d/m/y H:i:s') }}</p>
                        <p class="txn-method">Method: {{ $transaction->method ?? '-' }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination-wrapper mt-3">
            {!! $transactions->links() !!}
        </div>
    @else
        <div class="text-center mt-4">
            <p>No transactions found.</p>
        </div>
    @endif
</div>
@endsection
