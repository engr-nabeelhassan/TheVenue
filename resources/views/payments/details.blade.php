<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Details</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #4F46E5; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        th { background: #F3F4F6; color: #374151; padding: 6px; text-align: left; border: 1px solid #D1D5DB; font-size: 10px; }
        td { padding: 6px; border: 1px solid #D1D5DB; font-size: 10px; }
        .meta { margin-bottom: 12px; font-size: 11px; }
        .footer { text-align: center; font-size: 10px; color: #666; border-top: 1px solid #E5E7EB; padding-top: 8px; margin-top: 16px; }
    </style>
</head>
<body>
    <?php
        $rangeText = ($fromDate && $toDate)
            ? (\Carbon\Carbon::parse($fromDate)->format('M d, Y') . ' to ' . \Carbon\Carbon::parse($toDate)->format('M d, Y'))
            : 'All Time';
    ?>
    <div class="header">
        <h1>Payment Details</h1>
        <p>{{ $rangeText }}</p>
        @if($customer)
            <p><strong>Customer:</strong> {{ $customer->full_name }} — {{ $customer->phone }}</p>
        @else
            <p><strong>Customer:</strong> All Customers</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Sr#</th>
                <th>Receipt Date</th>
                <th>Customer</th>
                <th>Method</th>
                <th>Status</th>
                <th>Booking</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
                <th>Remarks</th>
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
                <td>
                    @if($payment->booking)
                        {{ number_format($payment->previous_balance, 2) }} #{{ $payment->booking->id }} — {{ \Carbon\Carbon::parse($payment->booking->invoice_date)->format('M d, Y') }}
                    @else
                        —
                    @endif
                </td>
                <td>{{ $payment->payment_method === 'Debit' ? number_format($payment->add_amount, 2) : '0.00' }}</td>
                <td>{{ $payment->payment_method === 'Credit' ? number_format($payment->add_amount, 2) : '0.00' }}</td>
                <td>{{ number_format($payment->remaining_balance, 2) }}</td>
                <td>{{ $payment->remarks ?? '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th colspan="6" style="text-align: right;">TOTAL</th>
                <th>{{ number_format($totalDebit, 2) }}</th>
                <th>{{ number_format($totalCredit, 2) }}</th>
                <th>{{ number_format($totalBalance, 2) }}</th>
                <th></th>
            </tr>
        </thead>
    </table>

    <div class="footer">
        Generated on {{ now()->format('M d, Y h:i A') }}
    </div>
</body>
</html>
