@extends('layouts.dashboard')

<!-- Link your profile CSS -->
<link rel="stylesheet" href="{{ asset('css/accounts.css') }}">

@section('content')
<div class="container-fluid"> 
    <h3 class="mb-4">My Accounts</h3>

    <!-- Success message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Search -->
    <form method="GET" action="{{ route('accounts.index') }}" class="mb-3 d-flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" 
               placeholder="Search by Live ID or Name" class="form-control">
        <button type="submit" class="btn btn-primary">Search</button>
        <a href="{{ route('accounts.index') }}" class="btn btn-secondary">Reset</a>
    </form>

    <!-- Accounts Table --> 
    <div class="table-responsive">
        <table class="table1">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Live ID</th>
                    <th>Account Name</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($accounts as $account)
                    <tr>
                        <td data-label="ID">{{ $loop->iteration }}</td>
                        <td data-label="Live ID">{{ $account->live_id }}</td>
                        <td data-label="Account Name">{{ $account->account_name }}</td>
                        <td data-label="Balance">${{ number_format($account->balance, 2) }}</td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="5" class="text-center">No accounts found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-3">
        {{ $accounts->links() }}
    </div>

    <!-- Create Account Form -->
    <div class="card1 mt-4">
        <div class="card-header">Create New Account</div>
        <div class="card-body">
            <form method="POST" action="{{ route('accounts.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="type" class="form-label">Account Type</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="live">Live</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="currency" class="form-label">Currency</label>
                    <input type="text" name="currency" id="currency" 
                           class="form-control" value="USD" required>
                </div>

                <button type="submit" class="btn2 btn-success">Create Account</button>
            </form>
        </div>
    </div>
</div>
@endsection
