@extends('layouts.dashboard')
<link rel="stylesheet" href="{{ asset('css/deposit.css') }}">

@section('content')

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success mt-2">
            {{ session('success') }}
        </div>
    @endif  

    {{-- Validation errors --}}
    @if($errors->any())
        <div class="alert alert-danger mt-2">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h3 class="mb-4">Deposit Request</h3>
<!--<div class="container mt-4">  -->

    {{-- Deposit Methods --}}
   <!-- <div class="card mb-4"> -->
        <div class="card-body">
            <h6>Crypto Payment Methods</h6>
            <div class="accordion" id="depositAccordion">
                @foreach($depositMethods as $method)
                    @php $uniqueId = 'method-' . $method->id; @endphp
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <button type="button" onclick="toggleAccordion('{{ $uniqueId }}')">
                                {{ $method->name }}
                            </button>
                            <i class="fa-regular fa-clipboard"
                               onclick="copyText('{{ $uniqueId }}-copy','{{ $uniqueId }}-tooltip')"></i>
                        </div>
                        <div class="accordion-body" id="collapse{{ $uniqueId }}">
                            <p id="{{ $uniqueId }}-tooltip">
                                <span id="{{ $uniqueId }}-copy">{{ $method->address }}</span>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <hr style="margin:1.5rem 0;">

<div class="deposit-form">
            {{-- Deposit Form --}}
            <h6>Submit Deposit Request</h6>
            <form action="{{ route('deposit.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <label>Select Account</label>
                <select name="account_id" class="form-control" required>
                    <option value="">-- Choose Account --</option>
                    @foreach(auth()->user()->accounts as $account)
                        <option value="{{ $account->id }}">
                            Account #{{ $account->live_id ?? $account->id }} - 
                            {{ ucfirst($account->type) }} - 
                            {{ $account->currency }} 
                            (Balance: ${{ number_format($account->balance, 2) }})
                        </option>
                    @endforeach
                </select>

                <label>Deposited Amount (USD)</label>
                <input type="number" name="amount" placeholder="Enter deposited amount" required>

                <label>Select Deposit Method</label>
                <select name="method" required>
                    <option value="">-- Choose Method --</option>
                    <option value="binance">Binance</option>
                    <option value="crypto">Crypto</option>
                    <option value="xynder">Xynder</option>
                    <option value="bank">Bank Transfer</option>
                    <option value="card">Card Payment</option>
                    <option value="upi">UPI</option>
                </select>

                <label>Upload Deposit Screenshot</label>
                <input type="file" name="screenshot" accept="image/*" onchange="previewScreenshot(this)">
                <img id="screenshot-preview" src="#" alt="Screenshot Preview" style="display:none; max-width:200px; margin-top:10px;">

                <div class="deposit-btn-wrapper mt-3">
                    <button type="submit" class="deposit-btn">
                        <i class="fa-solid fa-paper-plane"></i> Send Deposit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    // Copy to Clipboard
    window.copyText = function(copyId, tooltipId) {
        const text = document.getElementById(copyId).innerText;
        navigator.clipboard.writeText(text).then(() => {
            showTooltip(tooltipId, "Copied!");
        });
    }

    function showTooltip(tooltipId, text) {
        let tooltip = document.createElement("span");
        tooltip.className = "custom-tooltip";
        tooltip.innerText = text;
        document.body.appendChild(tooltip);

        const target = document.getElementById(tooltipId);
        const rect = target.getBoundingClientRect();
        tooltip.style.left = rect.left + window.scrollX + "px";
        tooltip.style.top = rect.top + window.scrollY - 30 + "px";

        tooltip.classList.add("show");
        setTimeout(() => tooltip.remove(), 1500);
    }

    // Screenshot preview
    window.previewScreenshot = function(input) {
        const preview = document.getElementById('screenshot-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => { 
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }

    // Accordion toggle
    window.toggleAccordion = function(network) {
        const body = document.getElementById("collapse" + network);
        const btn = body.previousElementSibling.querySelector("button");

        document.querySelectorAll(".accordion-body").forEach(b => {
            if (b !== body) {
                b.style.maxHeight = "0";
                b.previousElementSibling.querySelector("button").classList.remove("active");
            }
        });

        if (body.style.maxHeight && body.style.maxHeight !== "0px") {
            body.style.maxHeight = "0";
            btn.classList.remove("active");
        } else {
            body.style.maxHeight = body.scrollHeight + "px";
            btn.classList.add("active");
        }
    }
});
</script>
@endsection
