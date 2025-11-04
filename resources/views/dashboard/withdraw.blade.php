@extends('layouts.dashboard')
<!-- Link your profile CSS -->
<link rel="stylesheet" href="{{ asset('css/withdraw.css') }}">

@section('content')

<h3 class="mb-4">Withdraw Request</h3>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<!--<div class="withdraw-form-container"> -->

    <form action="{{ route('withdraw.store') }}" method="POST" id="withdrawForm">
        @csrf
 
        <!-- Select Account -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Select Account</label>
            <select name="account_id" class="withdraw-input" required>
                <option value="">-- Choose Account --</option>
                @foreach(auth()->user()->accounts as $account)
                    <option value="{{ $account->id }}">
                        Account: {{ $account->live_id ?? $account->id }} - {{ ucfirst($account->type) }} - {{ $account->currency }} (Balance: ${{ number_format($account->balance,2) }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Amount -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Amount to Withdraw (USD)</label>
            <input type="number" name="amount" step="0.01" class="withdraw-input" required>
        </div>

        <!-- Beneficiary Name -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Beneficiary Name</label>
            <input type="text" name="beneficiary_name" class="withdraw-input" required>
        </div>



        <!-- Withdrawal Method -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Select Withdrawal Method</label>
            <select name="method" id="withdrawal_method" class="withdraw-input" required>
                <option value="">-- Select Method --</option>
                <option value="binance">Binance</option>
                <option value="upi">UPI</option>
                <option value="bank">Bank Transfer</option>
                <option value="xynder">Xynder</option>
            </select>
        </div>

        <!-- Dynamic Fields -->
        <div id="binance_fields" class="withdraw-field">
            <label class="block text-gray-700 font-semibold mb-2">Wallet Address (BEP 20)</label>
            <input type="text" name="binance_id" class="withdraw-input">
        </div>

        <div id="upi_fields" class="withdraw-field">
            <label class="block text-gray-700 font-semibold mb-2">UPI ID</label>
            <input type="text" name="upi_id" class="withdraw-input">
        </div>

        <div id="bank_fields" class="withdraw-field">
            <label class="block text-gray-700 font-semibold mb-2">Bank Name</label>
            <input type="text" name="bank_name" class="withdraw-input mb-3">

            <label class="block text-gray-700 font-semibold mb-2">Account Number</label>
            <input type="text" name="bank_account_number" class="withdraw-input mb-3">

            <label class="block text-gray-700 font-semibold mb-2">IFSC / Bank Address</label>
            <input type="text" name="ifsc" class="withdraw-input">
        </div>

        <div id="xynder_fields" class="withdraw-field">
            <label class="block text-gray-700 font-semibold mb-2">Xynder ID</label>
            <input type="text" name="xynder_id" class="withdraw-input">
        </div>

        <button type="submit" class="withdraw-button mt-4">Submit Request</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const withdrawalMethod = document.getElementById('withdrawal_method');
    const fields = {
        binance: document.getElementById('binance_fields'),
        upi: document.getElementById('upi_fields'),
        bank: document.getElementById('bank_fields'),
        xynder: document.getElementById('xynder_fields'),
    };

    function hideAll() {
        Object.values(fields).forEach(f => f.classList.remove('active'));
    }

    withdrawalMethod.addEventListener('change', function() {
        hideAll();
        if (fields[this.value]) fields[this.value].classList.add('active');
    });

    hideAll(); // Hide all on load
});
</script>
@endsection
