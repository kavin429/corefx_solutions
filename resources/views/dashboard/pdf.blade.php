<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CORE FINANCE LIMITED - Transaction Invoice</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000; /* ✅ all text black */
            margin: 20px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
        }

        .logo img {
            height: 100px;
        }

        .company-info {
            text-align: right;
            font-size: 12px;
        }

        .company-info p {
            margin: 2px 0;
        }

        .client-info {
            text-align: left;
            font-size: 12px;
            margin-bottom: 20px;
        }

        .client-info p {
            margin: 2px 0;
        }

        h2 {
            text-align: center;
            margin: 20px 0;
            color: #3a2c50ff; /* ✅ heading color */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            color: #000; /* ensure table text is black */
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px 10px;
            text-align: left;
            color: #000; /* ✅ table text black */
        }

        th {
            background-color: #333333ff;
            color: #fff;
            font-weight: bold;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .deposit {
            color: green;
            font-weight: bold;
        }

        .withdraw {
            color: red;
            font-weight: bold;
        }

        .status-completed {
            color: green;
            font-weight: bold;
        }

        .status-pending {
            color: orange;
            font-weight: bold;
        }

        .status-failed {
            color: red;
            font-weight: bold;
        }

        td.center {
            text-align: center;
        }

        tfoot td {
            font-weight: bold;
            color: #000; /* ✅ ensure footer totals are black */
        }

        .total-row {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .footer-note {
            text-align: center; /* ✅ center the footer text */
            margin-top: 20px;
            font-size: 11px;
            color: #000; /* black */
        }
td.deposit,
td.withdraw,
td.center {
    color: #000 !important; /* force black */
}

    </style>
</head>
<body>

<header>
    <div class="logo">
    <!--<img src="{{ public_path('pics/Corefx1.png') }}"> -->

</div>

    
    <div class="company-info">
            <p><strong>CORE FINANCE LIMITED</strong></p>
        <p>+61 861 865 931</p>
        <p>1 Balloon Street, Manchester, M4 4BE, United Kingdom</p>
        <p><strong>support@corefinanceltd.com</strong></p>
    </div>
</header>

<div class="client-info">
    <p><strong>Client Name:</strong> {{ $user->name ?? 'N/A' }}</p>
    <p><strong>Email:</strong> {{ $user->email ?? 'N/A' }}</p>
    <p><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
    <p><strong>Country:</strong> {{ $user->country ?? '-' }}</p>
</div>

<hr>

<h2>Transaction Statement</h2>

<table>
<thead>
    <tr>
        <th style="text-align:center;">#</th>
        <th style="text-align:center;">Date</th>
        <th style="text-align:center;">Live ID</th>
        <th style="text-align:center;">Client</th>
        <th style="text-align:center;">Credited (USD)</th>
        <th style="text-align:center;">Debited (USD)</th>
        <th style="text-align:center;">Transaction Type</th>
        <th style="text-align:center;">Status</th>
    </tr>
</thead>

    <tbody>
        @php $counter = 1; @endphp
        @foreach($transactions as $txn)
            <tr>
                <td>{{ $counter++ }}</td>
                <td>{{ $txn->created_at->format('d/m/Y H:i:s') }}</td>
                <td>{{ $txn->account?->live_id ?? '-' }}</td>
                <td>{{ $txn->user->name ?? 'N/A' }}</td>
                <td class="text-right deposit">
                    @if(strtolower($txn->type) !== 'withdraw')
                        {{ number_format($txn->amount, 2) }}
                    @else
                        -
                    @endif
                </td>
                <td class="text-right withdraw">
                    @if(strtolower($txn->type) === 'withdraw')
                        {{ number_format($txn->amount, 2) }}
                    @else
                        -
                    @endif
                </td>
                <td class="text-capitalize">{{ $txn->method ?? '-' }}</td>
                <td class="center
                    {{ $txn->status === 'completed' ? 'status-completed' : '' }}
                    {{ $txn->status === 'pending' ? 'status-pending' : '' }}
                    {{ $txn->status === 'failed' ? 'status-failed' : '' }}">
                    @if($txn->status === 'completed')
                        Success
                    @elseif($txn->status === 'failed')
                        Unsuccess
                    @else
                        Pending
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="total-row">
            <td colspan="7" class="text-right">Total Credited</td>
            <td class="text-right">
                ${{ number_format($transactions->where('type', 'deposit')->sum('amount'), 2) }}
            </td>
        </tr>
        <tr class="total-row">
            <td colspan="7" class="text-right">Total Debited</td>
            <td class="text-right">
                ${{ number_format($transactions->where('type', 'withdraw')->sum('amount'), 2) }}
            </td>
        </tr>
    </tfoot>
</table>
<br>
<p class="footer-note">If you have any questions about this statement, please contact <strong>accounts@corefxsolutions.com </strong></p>
<br>
<p class="footer-note">This is a system-generated statement from CORE FINANCE LIMITED.</p>

<script type="text/php">
if (isset($pdf)) {
    $pdf->page_script('
        $font = $fontMetrics->get_font("DejaVu Sans", "normal");
        $size = 10;
        $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
        $y = 810; 
        $x = 520; 
        $pdf->text($x, $y, $pageText, $font, $size);
    ');
}
</script>

</body>
</html>
