@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Manage Transactions</h2>

    <!-- Add / Upload Transaction Form -->
    <div class="card mb-4">
        <div class="card-header">Add New Transaction</div>
        <div class="card-body">
            <form action="{{ route('admin.transactions.store') }}" method="POST">
                @csrf
                <div class="row g-2"> 
                    <div class="col-md-3">
                        <label>User</label>
                        <select name="user_id" class="form-select" required>
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Account</label>
                        <select name="account_id" class="form-select">
                            <option value="">Select Account</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->live_id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Type</label>
                        <select name="type" class="form-select" required>
                            <option value="deposit">Deposit</option>
                            <option value="withdraw">Withdraw</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Amount</label>
                        <input type="number" step="0.01" name="amount" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label>Method</label>
                        <select name="method" class="form-select" required>
                            <option value="">Select Method</option>
                            <option value="bank">Bank</option>
                            <option value="binance">Binance</option>
                            <option value="xynder">Xynder</option>
                            <option value="upi">UPI</option>
                        </select>
                    </div>
                </div>

                <!-- Bank Fields -->
                <div class="row g-2 mt-2 bank-field">
                    <div class="col-md-3">
                        <label>Bank Name</label>
                        <input type="text" name="bank_name" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Account Number</label>
                        <input type="text" name="account_number" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>IFSC / SWIFT</label>
                        <input type="text" name="ifsc" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Bank Address</label>
                        <input type="text" name="bank_address" class="form-control">
                    </div>
                </div>

                <!-- Binance Fields -->
                <div class="row g-2 mt-2 binance-field">
                    <div class="col-md-3">
                        <label>Wallet Address (BEP 20)</label>
                        <input type="text" name="binance_id" class="form-control">
                    </div>
                </div>

                <!-- Xynder Fields -->
                <div class="row g-2 mt-2 xynder-field">
                    <div class="col-md-3">
                        <label>Xynder ID</label>
                        <input type="text" name="xynder_id" class="form-control">
                    </div>
                </div>

                <!-- UPI Fields -->
                <div class="row g-2 mt-2 upi-field">
                    <div class="col-md-3">
                        <label>UPI ID</label>
                        <input type="text" name="upi_id" class="form-control">
                    </div>
                </div>

                <!-- Common Fields -->
                <div class="row g-2 mt-2">
                    <div class="col-md-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Note</label>
                        <input type="text" name="note" class="form-control">
                    </div>
                </div>

                <button type="submit" class="btn btn-success mt-3">Add Transaction</button>
            </form>
        </div>
    </div>

    <!-- Search Form -->
    <form action="{{ route('admin.transactions.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search transactions" value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <!-- Transactions Table -->
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Account</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
                <th>Beneficiary</th>
                
                <th>Note</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
            <tr>
                <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <select name="user_id" class="form-select form-select-sm">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $transaction->user_id==$user->id?'selected':'' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="account_id" class="form-select form-select-sm">
                            <option value="">Select Account</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}" {{ $transaction->account_id==$account->id?'selected':'' }}>
                                    {{ $account->live_id }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="type" class="form-select form-select-sm">
                            <option value="deposit" {{ $transaction->type=='deposit'?'selected':'' }}>Deposit</option>
                            <option value="withdraw" {{ $transaction->type=='withdraw'?'selected':'' }}>Withdraw</option>
                        </select>
                    </td>
                    <td><input type="number" step="0.01" name="amount" value="{{ $transaction->amount }}" class="form-control form-control-sm"></td>
                    <td>
                        <select name="method" class="form-select form-select-sm">
                            <option value="bank" {{ $transaction->method=='bank'?'selected':'' }}>Bank</option>
                            <option value="binance" {{ $transaction->method=='binance'?'selected':'' }}>Binance</option>
                            <option value="xynder" {{ $transaction->method=='xynder'?'selected':'' }}>Xynder</option>
                            <option value="upi" {{ $transaction->method=='upi'?'selected':'' }}>UPI</option>
                        </select>
                    </td>
                    <td>
                        <select name="status" class="form-select form-select-sm">
                            <option value="pending" {{ $transaction->status=='pending'?'selected':'' }}>Pending</option>
                            <option value="completed" {{ $transaction->status=='completed'?'selected':'' }}>Completed</option>
                            <option value="failed" {{ $transaction->status=='failed'?'selected':'' }}>Failed</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="beneficiary_name" value="{{ $transaction->beneficiary_name }}" class="form-control form-control-sm mb-1" placeholder="Beneficiary Name">
                    </td>
                    <td><input type="text" name="note" value="{{ $transaction->note }}" class="form-control form-control-sm"></td>
                    <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                    <td>
                        <button type="submit" class="btn btn-success btn-sm">Save</button>
                </form>
                <form action="{{ route('admin.transactions.destroy', $transaction->id) }}" method="POST" style="display:inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
                    </td>
            </tr>
            @empty
            <tr><td colspan="12" class="text-center">No transactions found.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $transactions->links() }}
</div>

<!-- JavaScript for Dynamic Fields -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const methodSelect = document.querySelector('select[name="method"]');

    const fields = {
        bank: document.querySelectorAll('.bank-field'),
        binance: document.querySelectorAll('.binance-field'),
        xynder: document.querySelectorAll('.xynder-field'),
        upi: document.querySelectorAll('.upi-field')
    };

    function hideAll() {
        Object.values(fields).forEach(group => {
            group.forEach(el => el.style.display = 'none');
        });
    }

    function showGroup(method) {
        hideAll();
        if(fields[method]) {
            fields[method].forEach(el => el.style.display = 'flex');
        }
    }

    // Initial display
    showGroup('bank');

    methodSelect.addEventListener('change', function() {
        showGroup(this.value);
    });
});
</script>
@endsection
