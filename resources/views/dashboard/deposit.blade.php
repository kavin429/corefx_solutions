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

<!-- {{-- Deposit Methods --}}
<div class="deposit-methods">
    <h6>Crypto Payment Methods</h6>
    @foreach($depositMethods as $method)
        @php $uniqueId = 'method-' . $method->id; @endphp
        <div class="deposit-method">
            <span>{{ $method->name }}: <br><span id="{{ $uniqueId }}-copy">{{ $method->address }}</span></span>
            <i class="fa-regular fa-clipboard"
               onclick="copyText('{{ $uniqueId }}-copy','{{ $uniqueId }}-tooltip')"></i>
            <span class="copy-tooltip" id="{{ $uniqueId }}-tooltip">Copied!</span>
        </div>
    @endforeach
</div> -->

{{-- Deposit Methods --}}
<div class="deposit-methods">
    <h6>Crypto Payment Methods</h6>

    <div class="deposit-method">
        <span>Crypto (BEP 20): <br>
            <span id="method-1-copy">0xbf32ea52f44a47fc21a456f903df1d6fd513aa0d</span>
        </span>
        <i class="fa-regular fa-clipboard"
           onclick="copyText('method-1-copy','method-1-tooltip')"></i>
        <span class="copy-tooltip" id="method-1-tooltip">Copied!</span>
    </div>

    <div class="deposit-method">
        <span>Crypto (ERC 20): <br>
            <span id="method-2-copy">0xbf32ea52f44a47fc21a456f903df1d6fd513aa0d</span>
        </span>
        <i class="fa-regular fa-clipboard"
           onclick="copyText('method-2-copy','method-2-tooltip')"></i>
        <span class="copy-tooltip" id="method-2-tooltip">Copied!</span>
    </div>

    <div class="deposit-method">
        <span>Crypto (TRC 20): <br>
            <span id="method-3-copy">TYPmJVwMkrdSonKkhsqkJaKGTLZshB75cE</span>
        </span>
        <i class="fa-regular fa-clipboard"
           onclick="copyText('method-3-copy','method-3-tooltip')"></i>
        <span class="copy-tooltip" id="method-3-tooltip">Copied!</span>
    </div>

    <div class="deposit-method">
        <span>Xynder: <br>
            <span id="method-4-copy">597671</span>
        </span>
        <i class="fa-regular fa-clipboard"
           onclick="copyText('method-4-copy','method-4-tooltip')"></i>
        <span class="copy-tooltip" id="method-4-tooltip">Copied!</span>
    </div>

    <div class="deposit-method">
        <span>Others: <br>
            <span id="method-5-copy">0x5ED5C7248EB00A478918eaE5c5b574354607a7E6</span>
        </span>
        <i class="fa-regular fa-clipboard"
           onclick="copyText('method-5-copy','method-5-tooltip')"></i>
        <span class="copy-tooltip" id="method-5-tooltip">Copied!</span>
    </div>

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
                            Account: {{ $account->live_id ?? $account->id }} - 
                            {{ ucfirst($account->type) }} - 
                            {{ $account->currency }} 
                            (Balance: ${{ number_format($account->balance, 2) }})
                        </option>
                    @endforeach
                </select>

                <label>Deposited Amount (USD)</label>
<input type="number" 
       name="amount" 
       placeholder="Enter deposited amount (e.g., 100.25)" 
       step="0.01" 
       min="0" 
       required>


                <label>Select Deposit Method</label>
                <select name="method" required>
                    <option value="">-- Choose Method --</option>
                    <option value="binance">Binance</option>
                    <!--<option value="crypto">Crypto</option>-->
                    <option value="xynder">Xynder</option>
                    <option value="bank">Bank Transfer</option>
                    <!--<option value="card">Card Payment</option>-->
                    <option value="upi">UPI</option>
                </select>

                <label>Upload Deposit Screenshot</label>
                <input type="file" name="screenshot" accept="image/*" onchange="previewScreenshot(this)" required>
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

    window.copyText = function(copyId, tooltipId) {
    const text = document.getElementById(copyId).innerText;
    navigator.clipboard.writeText(text).then(() => {

        const tooltip = document.getElementById(tooltipId);
        const icon = tooltip.previousElementSibling; // the clipboard icon

        // Position tooltip below the icon
        const rect = icon.getBoundingClientRect();
        tooltip.style.top = rect.bottom + 6 + window.scrollY + "px"; // 6px gap below
        tooltip.style.left = rect.left + window.scrollX + (rect.width / 2) - (tooltip.offsetWidth / 2) + "px";


        // Show tooltip
        tooltip.classList.add('show');

        // Hide after 1.5s
        setTimeout(() => {
            tooltip.classList.remove('show');
        }, 1500);
    });
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