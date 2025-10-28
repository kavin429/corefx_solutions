@extends('layouts.dashboard')

<!-- Link your profile CSS -->
<link rel="stylesheet" href="{{ asset('css/index.css') }}">

@section('content')
{{-- Forced Blocking Popup Modal --}}
@if(!$user->is_active)
    <style>
        body { overflow: hidden; }
        #dashboardContent { filter: blur(6px); pointer-events: none; user-select: none; }
        #inactiveOverlay { position: fixed; inset: 0; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; z-index: 9999; }
        #inactiveOverlay .modal-box { background: linear-gradient(135deg, #fee0e0ff, #fec7c7ff); padding: 2rem; border-radius: 1rem; max-width: 400px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.25); }
        #inactiveOverlay h2 { font-size: 1.5rem; font-weight: bold; color: #471275ff; }
        #inactiveOverlay p { margin-top: 1rem; color: #374151; font-size: 1rem; }
        body.dark-mode #inactiveOverlay .modal-box { background: linear-gradient(135deg, #3f2626ff, #330202ff); color: #f5f5f5; }
    </style>

    <div id="inactiveOverlay">
        <div class="modal-box">
            <h2>Account Inactive</h2>
            <p>Your account has been inactivated.<br>Please contact the Infinity Trade Solutions LTD's Support.</p>
        </div>
    </div>
@endif

<div id="dashboardContent">

<div class="liveid-dropdown"> 
  <!--<label for="liveIdSelect" class="form-label">Select Live ID:</label> -->
  <select id="liveIdSelect" class="form-select"> 
    <option value="">-- Choose Live ID --</option> 
    @foreach($accounts as $account) 
    <option value="{{ $account->id }}" class= "option">{{ $account->live_id }}</option> 
    @endforeach 
  </select> 
</div> 

<div class="cards">
    <!-- Balance Card -->
    <div class="card">
        <div class="icon-circle balance-icon">
            <i class="bi bi-wallet2"></i>
        </div>
        <h5>Total Balance</h5>
        <h3>$<span id="cardBalance">{{ number_format($totalBalance, 2) }}</span></h3>
    </div>

    <!-- Income Card -->
    <div class="card">
        <div class="icon-circle income-icon">
            <i class="bi bi-graph-up-arrow"></i>
        </div>
        <h5>Total Deposit</h5>
        <h3>$<span id="cardDeposit">{{ number_format($totalIncome, 2) }}</span></h3>
    </div>

    <!-- PNL Card -->
    <div class="card">
        <div class="icon-circle pnl-icon">
            <i class="bi bi-bar-chart-line"></i>
        </div>
        <h5>Total PNL</h5>
        <h3>$<span id="cardPNL">{{ number_format($totalPNL, 2) }}</span></h3>
    </div>

    <!-- Outcome Card -->
    <div class="card">
        <div class="icon-circle outcome-icon">
            <i class="bi bi-graph-down-arrow"></i>
        </div>
        <h5>Total Withdraw</h5>
        <h3>$<span id="cardWithdraw">{{ number_format($totalOutcome, 2) }}</span></h3>
    </div>
</div>


<!-- TradingView Widgets in Grid -->
<div class="tradingview-grid mt-4">
    <div class="tradingview-widget-wrapper">
        <div class="tradingview-widget-container">
          <div class="tradingview-widget-container__widget"></div>
          <div class="tradingview-widget-copyright">
            <a href="https://www.tradingview.com/" rel="noopener nofollow" target="_blank"></a>
          </div>
          <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-overview.js" async>
          {
            "colorTheme": "light",
            "dateRange": "12M",
            "locale": "en",
            "largeChartUrl": "",
            "isTransparent": false,
            "showFloatingTooltip": false,
            "plotLineColorGrowing": "rgba(41, 98, 255, 1)",
            "plotLineColorFalling": "rgba(41, 98, 255, 1)",
            "gridLineColor": "rgba(240, 243, 250, 0)",
            "scaleFontColor": "#0F0F0F",
            "belowLineFillColorGrowing": "rgba(41, 98, 255, 0.12)",
            "belowLineFillColorFalling": "rgba(41, 98, 255, 0.12)",
            "belowLineFillColorGrowingBottom": "rgba(41, 98, 255, 0)",
            "belowLineFillColorFallingBottom": "rgba(41, 98, 255, 0)",
            "symbolActiveColor": "rgba(41, 98, 255, 0.12)",
            "tabs": [
              {
                "title": "Indices",
                "symbols": [
                  {"s": "FOREXCOM:SPXUSD", "d": "S&P 500 Index"},
                  {"s": "FOREXCOM:NSXUSD", "d": "US 100 Cash CFD"},
                  {"s": "FOREXCOM:DJI", "d": "Dow Jones Industrial Average Index"},
                  {"s": "INDEX:NKY", "d": "Japan 225"},
                  {"s": "INDEX:DEU40", "d": "DAX Index"},
                  {"s": "FOREXCOM:UKXGBP", "d": "FTSE 100 Index"},
                  {"s": "BINANCE:BTCUSDT", "d": " Bitcoin / TetherUS"},
                  {"s": "BITSTAMP:ETHUSD", "d": " Ethereum / U.S. dollar"}
                ],
                "originalTitle": "Indices"
              },
              {
                "title": "Metals",
                "symbols": [
                  {"s": "BMFBOVESPA:ISP1!", "d": "S&P 500"},
                  {"s": "BMFBOVESPA:EUR1!", "d": "Euro"},
                  {"s": "CMCMARKETS:GOLD", "d": "Gold"},
                  {"s": "PYTH:WTI3!", "d": "WTI Crude Oil"},
                  {"s": "BMFBOVESPA:CCM1!", "d": "Corn"}
                ],
                "originalTitle": "Futures"
              },
              {
                "title": "Crypto",
                "symbols": [
                  {"s": "EUREX:FGBL1!", "d": "Euro Bund"},
                  {"s": "EUREX:FBTP1!", "d": "Euro BTP"},
                  {"s": "EUREX:FGBM1!", "d": "Euro BOBL"}
                ],
                "originalTitle": "Bonds"
              },
              {
                "title": "Forex",
                "symbols": [
                  {"s": "FX:EURUSD", "d": "EUR to USD"},
                  {"s": "FX:GBPUSD", "d": "GBP to USD"},
                  {"s": "FX:USDJPY", "d": "USD to JPY"},
                  {"s": "FX:USDCHF", "d": "USD to CHF"},
                  {"s": "FX:AUDUSD", "d": "AUD to USD"},
                  {"s": "FX:USDCAD", "d": "USD to CAD"}
                ],
                "originalTitle": "Forex"
              }
            ],
            "support_host": "https://www.tradingview.com",
            "width": "100%",
            "height": 550,
            "showSymbolLogo": true,
            "showChart": true
          }
          </script>
        </div>
    </div>

    <div class="tradingview-widget-wrapper">
        <div class="tradingview-widget-container">
          <div class="tradingview-widget-container__widget"></div>
          <div class="tradingview-widget-copyright">
            <a href="https://www.tradingview.com/" rel="noopener nofollow" target="_blank"></a>
          </div>
          <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-quotes.js" async>
          {
            "colorTheme": "light",
            "locale": "en",
            "largeChartUrl": "",
            "isTransparent": false,
            "showSymbolLogo": true,
            "backgroundColor": "#ffffff",
            "support_host": "https://www.tradingview.com",
            "width": "100%",
            "height": 550,
            "symbolsGroups": [
              {"name": "Indices","symbols":[
                {"name": "FOREXCOM:SPXUSD","displayName": "S&P 500 Index"},
                {"name": "FOREXCOM:NSXUSD","displayName": "US 100 Cash CFD"},
                {"name": "FOREXCOM:DJI","displayName": "Dow Jones Industrial Average Index"},
                {"name": "INDEX:NKY","displayName": "Japan 225"},
                {"name": "INDEX:DEU40","displayName": "DAX Index"},
                {"name": "FOREXCOM:UKXGBP","displayName": "FTSE 100 Index"}
              ]},
              {"name": "Futures","symbols":[
                {"name": "BMFBOVESPA:ISP1!","displayName": "S&P 500"},
                {"name": "BMFBOVESPA:EUR1!","displayName": "Euro"},
                {"name": "CMCMARKETS:GOLD","displayName": "Gold"},
                {"name": "PYTH:WTI3!","displayName": "WTI Crude Oil"},
                {"name": "BMFBOVESPA:CCM1!","displayName": "Corn"}
              ]},
              {"name": "Bonds","symbols":[
                {"name": "EUREX:FGBL1!","displayName": "Euro Bund"},
                {"name": "EUREX:FBTP1!","displayName": "Euro BTP"},
                {"name": "EUREX:FGBM1!","displayName": "Euro BOBL"}
              ]},
              {"name": "Forex","symbols":[
                {"name": "FX:EURUSD","displayName": "EUR to USD"},
                {"name": "FX:GBPUSD","displayName": "GBP to USD"},
                {"name": "FX:USDJPY","displayName": "USD to JPY"},
                {"name": "FX:USDCHF","displayName": "USD to CHF"},
                {"name": "FX:AUDUSD","displayName": "AUD to USD"},
                {"name": "FX:USDCAD","displayName": "USD to CAD"}
              ]}
            ]
          }
          </script>
        </div>
    </div>
</div>



<!-- Grid CSS -->
<style>
.tradingview-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1rem;
}
.tradingview-widget-wrapper {
    background: linear-gradient(135deg, #e0f2fe, #e3c7fe);
    border-radius: 10px;
    padding: 1rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}

/* Dark Mode */
body.dark-mode .tradingview-widget-wrapper {
    background: linear-gradient(135deg, #1e1e2f, #2a143d); /* darker gradient */
    box-shadow: 0 4px 10px rgba(0,0,0,0.4);
    color: #f1f5f9; /* light text for dark mode */
}
</style>

<script>
  document.getElementById('liveIdSelect').addEventListener('change', function() {
    let accountId = this.value;

    if(!accountId) {
        // Reset to default totals
        document.getElementById('cardBalance').innerText = "{{ number_format($totalBalance, 2) }}";
        document.getElementById('cardDeposit').innerText = "{{ number_format($totalIncome, 2) }}";
        document.getElementById('cardWithdraw').innerText = "{{ number_format($totalOutcome, 2) }}";
        document.getElementById('cardPNL').innerText = "{{ number_format($totalPNL, 2) }}";
        return;
    }

    fetch(`/dashboard/account/${accountId}/details`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('cardBalance').innerText = parseFloat(data.totalBalance).toFixed(2);
            document.getElementById('cardDeposit').innerText = parseFloat(data.totalDeposit).toFixed(2);
            document.getElementById('cardWithdraw').innerText = parseFloat(data.totalWithdraw).toFixed(2);
            document.getElementById('cardPNL').innerText = parseFloat(data.totalPNL).toFixed(2);
        })
        .catch(err => console.error(err));
});

</script>

@endsection
