<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Summary</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #4F46E5; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        th { background: #F3F4F6; color: #374151; padding: 6px; text-align: left; border: 1px solid #D1D5DB; font-size: 10px; }
        td { padding: 6px; border: 1px solid #D1D5DB; font-size: 10px; }
        .footer { text-align: center; font-size: 10px; color: #666; border-top: 1px solid #E5E7EB; padding-top: 8px; margin-top: 16px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Payment Summary</h1>
        <p>{{ \Carbon\Carbon::parse($fromDate)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($toDate)->format('M d, Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Sr#</th>
                <th>Receipt Date</th>
                <th>Customer</th>
                <th>Method</th>
                <th>Status</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $index => $payment)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ optional($payment->receipt_date)->format('M d, Y') }}</td>
                <td>{{ $payment->customer_name }}</td>
                <td>{{ $payment->payment_method }}</td>
                <td>{{ $payment->payment_status }}</td>
                <td>{{ number_format($payment->add_amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table>
        <tr>
            <th>Total Debit</th>
            <td>{{ number_format($totalDebit, 2) }}</td>
            <th>Total Credit</th>
            <td>{{ number_format($totalCredit, 2) }}</td>
            <th>Net Balance</th>
            <td>{{ number_format($netBalance, 2) }}</td>
        </tr>
    </table>

    <div class="footer">
        Generated on {{ now()->format('M d, Y h:i A') }}
    </div>
</body>
</html>


