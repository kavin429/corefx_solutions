<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #3b2a5a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #888;
        }

        th, td {
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #9b59b6;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-align: center;
            color: white;
        }

        .badge-success { background-color: #28a745; }
        .badge-danger { background-color: #dc3545; }
        .badge-warning { background-color: #ffc107; color: #212529; }
    </style>
</head>
<body>
    <h2>Transaction History</h2>

    <table>
        <thead>
            <tr>
                <th>Live ID</th>
                <th>User</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
                <th>Beneficiary / Details</th>
                <th>Note</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $t)
            <tr>
                <td>{{ $t->account->live_id ?? '-' }}</td>
                <td>{{ $t->user->name ?? '-' }}</td>
                <td>{{ ucfirst($t->type) }}</td>
                <td>${{ number_format($t->amount, 2) }}</td>
                <td>{{ ucfirst($t->method ?? '-') }}</td>
                <td>
                    @if($t->status === 'completed')
                        <span class="badge badge-success">Completed</span>
                    @elseif($t->status === 'failed')
                        <span class="badge badge-danger">Failed</span>
                    @else
                        <span class="badge badge-warning">Pending</span>
                    @endif
                </td>
                <td>
                    @if($t->method === 'bank')
                        {{ $t->beneficiary_name }}<br>
                        {{ $t->bank_name }}<br>
                        {{ $t->account_number }}<br>
                        {{ $t->ifsc }}<br>
                        {{ $t->bank_address }}
                    @elseif($t->method === 'xynder')
                        {{ $t->beneficiary_name }}<br>
                        Xynder ID: {{ $t->xynder_id }}
                    @elseif($t->method === 'binance')
                        {{ $t->beneficiary_name }}<br>
                        Binance ID: {{ $t->binance_id }}<br>
                        Network: {{ $t->network_id }}
                    @else
                        {{ $t->beneficiary_name ?? '-' }}
                    @endif
                </td>
                <td>{{ $t->note ?? '-' }}</td>
                <td>{{ $t->created_at->format('d M Y, h:i A') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center;">No transactions found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
