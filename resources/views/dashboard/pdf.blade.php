<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Infinity Trade Solutions LTD</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }

        header {
            border-bottom: 2px solid #8a34dbff;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        header h1 {
            margin: 0;
            color: #7f34dbff;
        }

        .company-info, .customer-info {
            margin-top: 10px;
            font-size: 12px;
        }

        .customer-info {
            float: right;
            text-align: right;
        }

        h2 {
            text-align: center;
            margin: 20px 0;
            color: #3a2c50ff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background-color: #8734dbff;
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
        }

        .total-row {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<header>
    <h1>Infinity Trade Solutions LTD</h1>
    <div class="company-info">
        <p>Infinity Trade Solutions LTD.</p>
        <p>Email: info@itsltd.com | Phone: +1234567890</p>
        <p>Website: www.itsltd.com</p>
    </div>
</header>

<h2>Transaction Invoice</h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Type</th>
            <th>Amount ($)</th>
            <th>Status</th>
            <th>Account</th>
            <th>Balance ($)</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @php $counter = 1; @endphp
        @foreach($transactions as $txn)
            @php $isDeposit = strtolower($txn->type) === 'deposit'; @endphp
            <tr>
                <td>{{ $counter++ }}</td>
                <td class="{{ $isDeposit ? 'deposit' : 'withdraw' }}">{{ ucfirst($txn->type) }}</td>
                <td class="{{ $isDeposit ? 'deposit' : 'withdraw' }}">{{ number_format($txn->amount, 2) }}</td>
                <td class="center
                    {{ $txn->status === 'completed' ? 'status-completed' : '' }}
                    {{ $txn->status === 'pending' ? 'status-pending' : '' }}
                    {{ $txn->status === 'failed' ? 'status-failed' : '' }}">
                    {{ ucfirst($txn->status) }}
                </td>
                <td>{{ $txn->account?->live_id ?? '-' }}</td>
                <td>{{ number_format($txn->account?->balance ?? 0, 2) }}</td>
                <td>{{ $txn->created_at->format('d/m/Y H:i:s') }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="total-row">
            <td colspan="2">Total Deposits</td>
            <td colspan="5">
                ${{ number_format($transactions->where('type', 'deposit')->sum('amount'), 2) }}
            </td>
        </tr>
        <tr class="total-row">
            <td colspan="2">Total Withdrawals</td>
            <td colspan="5">
                ${{ number_format($transactions->where('type', 'withdraw')->sum('amount'), 2) }}
            </td>
        </tr>
    </tfoot>
</table>

<p style="margin-top:20px; font-size: 11px;">This is a system-generated invoice from Infinity Trade Solutions LTD.</p>

</body>
</html>
