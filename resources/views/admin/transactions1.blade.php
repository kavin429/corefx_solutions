@extends('admin.layouts.admin')
<link rel="stylesheet" href="{{ asset('css/adminTransactions.css') }}">


@section('title', 'Infinity Trade Solutions LTD')

@section('content')
<div class="container-fluid"> 
    <h2>New Transaction</h2>

    <!-- Success & Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Add / Upload Transaction Form -->
    <div class="card mb-4">

        <div class="card-body">
            <form action="{{ route('admin.transactions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-2">
                
<div class="col-md-3">
    <label>Live ID</label>
    <input type="text" id="live_id" name="live_id" class="form-control" placeholder="Enter Live ID" required>
</div>

<div class="col-md-3">
    <label>Client</label>
    <input type="text" id="user_name" class="form-control" placeholder="Client Name" readonly>
    <input type="hidden" name="user_id" id="user_id">
    <input type="hidden" name="account_id" id="account_id">

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
                        <select name="method" id="method" class="form-select" required>
                            <option value="">Select Method</option>
                            <option value="bank">Bank</option>
                            <option value="binance">Binance</option>
                            <option value="xynder">Xynder</option>
                            <option value="upi">UPI</option>
                        </select>
                    </div>
                </div>

                <!-- Bank Fields 
                <div class="row g-2 mt-2 bank-field" style="display:none;">
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
                </div> -->

                <!-- Binance Fields 
                <div class="row g-2 mt-2 binance-field" style="display:none;">
                    <div class="col-md-3">
                        <label>Wallet Address (BEP 20)</label>
                        <input type="text" name="binance_id" class="form-control">
                    </div>
                </div> -->

                <!-- Xynder Fields
                <div class="row g-2 mt-2 xynder-field" style="display:none;">
                    <div class="col-md-3">
                        <label>Xynder ID</label>
                        <input type="text" name="xynder_id" class="form-control">
                    </div>
                </div>  -->

                <!-- UPI Fields
                <div class="row g-2 mt-2 upi-field" style="display:none;">
                    <div class="col-md-3">
                        <label>UPI ID</label>
                        <input type="text" name="upi_id" class="form-control">
                    </div>
                </div>  -->

                <!-- Screenshot 
                <div class="row g-2 mt-2">
                
                </div> -->

                <!-- Common Fields
                <div class="row g-2 mt-2">
                    <div class="col-md-3">
                        <label>Upload Screenshot</label>
                        <input type="file" name="screenshot" class="form-control" accept="image/*">
                    </div>  -->
                
                    <div class="col-md-14 mt-2">
                        <label>Note</label>
                        <input type="text" name="note" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>
            <button type="submit" class="btn mt-1">Add Transaction</button>
        </form>
    </div>
</div>

<div class="container-fluid"> 
    <h2>Transaction History</h2>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('admin.transactions.history') }}" class="mb-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="form-control">

        <select name="type" class="form-control">
            <option value="">All Types</option>
            <option value="deposit" {{ request('type')=='deposit'?'selected':'' }}>Deposit</option>
            <option value="withdraw" {{ request('type')=='withdraw'?'selected':'' }}>Withdraw</option>
        </select>

        <select name="method" class="form-control">
            <option value="">All Methods</option>
            <option value="bank" {{ request('method')=='bank'?'selected':'' }}>Bank</option>
            <option value="binance" {{ request('method')=='binance'?'selected':'' }}>Binance</option>
            <option value="xynder" {{ request('method')=='xynder'?'selected':'' }}>Xynder</option>
            <option value="upi" {{ request('method')=='upi'?'selected':'' }}>UPI</option>
            <option value="card" {{ request('method')=='card'?'selected':'' }}>Card</option>
            <option value="crypto" {{ request('method')=='crypto'?'selected':'' }}>Crypto</option>
        </select>

        <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
        <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">

        <button type="submit" class="btn1 btn-primary">Search</button>
        <a href="{{ route('admin.transactions.history') }}" class="btn1 btn-secondary">Reset</a>
        <a href="{{ route('admin.transactions.history.pdf', request()->query()) }}" class="btn1 btn-success btn-sm">
            Download PDF
        </a>
    </form>

    <hr>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Live ID</th>
                    <th>Client</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Method</th>

                    <th>Details</th>
                    <th>Screenshot</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                    <tr>
                        <td>{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}</td>
                        <td>
    <span class="user-time" data-utc="{{ $t->created_at->toIso8601String() }}">
        {{ $t->created_at->format('d M Y, h:i A') }}
    </span>
</td>

                        <td>{{ $t->account?->live_id }}</td>

                        <td>{{ $t->user->name ?? 'N/A' }}</td>

                        <td class="text-capitalize">
                             @if($t->type === 'withdraw')
                                <span>Debited</span>
                            @else
                                <span>Credited</span>
                            @endif
                        </td>
                        <td style="text-align: right;">${{ number_format($t->amount, 2) }}</td>
                        <td class="text-capitalize">{{ $t->method ?? '-' }}</td>

<td>
    @if($t->type === 'withdraw')
        @if($t->method === 'bank')
            Name: {{ $t->beneficiary_name }}<br>
            Bank: {{ $t->bank_name }}<br>
            Account: {{ $t->account_number }}<br>
            IFSC: {{ $t->ifsc }}<br>
            Address: {{ $t->bank_address }}
        @elseif($t->method === 'xynder')
            Name: {{ $t->beneficiary_name }}<br>
            Xynder ID: {{ $t->xynder_id }}
        @elseif($t->method === 'binance')
            Name: {{ $t->beneficiary_name }}<br>
            Binance ID: {{ $t->binance_id }}
        @elseif($t->method === 'upi')
            Name: {{ $t->beneficiary_name }}<br>
            UPI ID: {{ $t->upi_id }}
        @else
            Name: {{ $t->beneficiary_name ?? '-' }}
        @endif
    @else
        {{-- If not withdraw, show blank or something else --}}
        -
    @endif
</td>

                        

                        <td>
                            @if($t->screenshot_path)
                                <a href="{{ asset('storage/'.$t->screenshot_path) }}" target="_blank">
                                    <img src="{{ asset('storage/'.$t->screenshot_path) }}" alt="screenshot" width="50" height="50" class="rounded">
                                </a>
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if($t->status === 'completed')
                                <span class="badge bg-success">Success</span>
                            @elseif($t->status === 'failed')
                                <span class="badge bg-danger">Unsuccess</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        
                        <td>
                            <!-- Edit button 
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editTxn{{ $t->id }}">
                                Edit
                            </button> -->

                            <!-- Delete button -->
    <form action="{{ route('admin.transactions.destroy', $t->id) }}" method="POST" class="d-inline"
          onsubmit="return confirm('Are you sure you want to delete this transaction?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger">
            Delete
        </button>
    </form>
                            
                        </td>
                    </tr>

                    <!-- Edit Modal 
                    <div class="modal fade" id="editTxn{{ $t->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Transaction #{{ $t->id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('admin.transactions.update', $t->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-2">
                                            <label>Beneficiary Name</label>
                                            <input type="text" name="beneficiary_name" class="form-control" value="{{ $t->beneficiary_name }}">
                                        </div>
                                        <div class="mb-2">
                                            <label>Bank Name</label>
                                            <input type="text" name="bank_name" class="form-control" value="{{ $t->bank_name }}">
                                        </div>
                                        <div class="mb-2">
                                            <label>Account Number</label>
                                            <input type="text" name="account_number" class="form-control" value="{{ $t->account_number }}">
                                        </div>
                                        <div class="mb-2">
                                            <label>IFSC</label>
                                            <input type="text" name="ifsc" class="form-control" value="{{ $t->ifsc }}">
                                        </div>
                                        <div class="mb-2">
                                            <label>Bank Address</label>
                                            <input type="text" name="bank_address" class="form-control" value="{{ $t->bank_address }}">
                                        </div>
                                        <div class="mb-2">
                                            <label>Xynder ID</label>
                                            <input type="text" name="xynder_id" class="form-control" value="{{ $t->xynder_id }}">
                                        </div>
                                        <div class="mb-2">
                                            <label>Binance ID</label>
                                            <input type="text" name="binance_id" class="form-control" value="{{ $t->binance_id }}">
                                        </div>

                                        <div class="mb-2">
                                            <label>Upload Screenshot</label><br>
                                            @if($t->screenshot_path)
                                                <img src="{{ asset('storage/'.$t->screenshot_path) }}" width="80" class="mb-2 rounded">
                                            @endif
                                            <input type="file" name="screenshot" class="form-control">
                                        </div>

                                        <div class="mt-3">
                                            <button type="submit" class="btn ">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> -->
                @empty
                    <tr>
                        <td colspan="11" class="text-center">No completed or failed transactions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper mt-3">
        {!! $transactions->links() !!}
    </div>
</div>
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
    showGroup('');

    methodSelect.addEventListener('change', function() {
        showGroup(this.value);
    });
});
</script>

<!-- JS for auto-fill user and toggle method fields -->
<script>


// Toggle fields based on selected method
document.getElementById('method').addEventListener('change', function() {
    var method = this.value;
    document.querySelector('.bank-field').style.display = method === 'bank' ? 'flex' : 'none';
    document.querySelector('.binance-field').style.display = method === 'binance' ? 'flex' : 'none';
    document.querySelector('.xynder-field').style.display = method === 'xynder' ? 'flex' : 'none';
    document.querySelector('.upi-field').style.display = method === 'upi' ? 'flex' : 'none';
});
</script>

<script>
document.getElementById('live_id').addEventListener('input', function() {
    const liveId = this.value;

    if(liveId.length > 0){
        fetch('/admin/get-user-by-live-id/' + liveId)
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    document.getElementById('user_name').value = data.user.name;
                    document.getElementById('user_id').value = data.user.id;
                    document.getElementById('account_id').value = data.user.account_id; // add this
                } else {
                    document.getElementById('user_name').value = '';
                    document.getElementById('user_id').value = '';
                    document.getElementById('account_id').value = '';
                }
            });
    } else {
        document.getElementById('user_name').value = '';
        document.getElementById('user_id').value = '';
        document.getElementById('account_id').value = '';
    }
});

</script>



<script src="{{ asset('js/time.js') }}"></script>
@endsection
