<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 20px;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .logo img {
            height: 80px;
        }

        .client-info p {
            margin: 2px 0;
            text-align: right;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            color: #000;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

.badge {
    display: inline-block;
    padding: 2px 5px;
    border-radius: 3px;
    font-size: 10px;
    font-weight: bold;
    text-align: center;
    color: #000;
    border: none;          /* <-- remove outline */
    background: transparent;
}


        .text-right { text-align: right; }

        .total-row {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .footer-note {
            text-align: center;
            margin-top: 20px;
            font-size: 11px;
            color: #000;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="logo">
            <!--<img src="{{ public_path('pics/Corefx1.png') }}" alt="Logo"> -->
        </div>

        <div class="client-info">
            <p><strong>CORE FINANCE LIMITED</strong></p>
        <p>+61 861 865 931</p>
        <p>1 Balloon Street, Manchester, M4 4BE, United Kingdom</p>
        <p><strong>support@corefinanceltd.com</strong></p>
        </div>
    </div>

    <h2>Transaction History</h2>

    <table>
        <thead>
            <tr>
                <th style="text-align:center;">#</th>
                <th style="text-align:center;">Date</th>
                <th style="text-align:center;">Live ID</th>
                <th style="text-align:center;">Client</th>
                <th style="text-align:center;">Credited (USD)</th>
                <th style="text-align:center;">Debited (USD)</th>
                <th style="text-align:center;">Method</th>
                <th style="text-align:center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $t)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $t->created_at->format('d M Y, h:i A') }}</td>
                <td>{{ $t->account->live_id ?? '-' }}</td>
                <td>{{ $t->user->name ?? 'N/A' }}</td>
                <td class="text-right">
                    @if($t->type !== 'withdraw')
                        {{ number_format($t->amount, 2) }}
                    @else
                        -
                    @endif
                </td>
                <td class="text-right">
                    @if($t->type === 'withdraw')
                        {{ number_format($t->amount, 2) }}
                    @else
                        -
                    @endif
                </td>
                <td class="text-capitalize">{{ $t->method ?? '-' }}</td>
<td>
    @if($t->status === 'completed')
        <span class="badge badge-no-border">Success</span>
    @elseif($t->status === 'failed')
        <span class="badge badge-no-border">Unsuccess</span>
    @else
        <span class="badge badge-no-border">Pending</span>
    @endif
</td>

            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;">No transactions found.</td>
            </tr>
            @endforelse
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
    <p class="footer-note">
        If you have any questions about this statement, please contact 
        <strong>accounts@corefxsolutions.com</strong>
    </p>
    <br>
    <p class="footer-note">
        This is a system-generated statement from CORE FINANCE LIMITED.
    </p>

<script type="text/php">
if (isset($pdf)) {
    $pdf->page_script('
        $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
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
