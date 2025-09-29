<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customer Statement</title>
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
        <h1>Customer Statement</h1>
        <p>Customer: {{ $selectedCustomer->full_name ?? 'Unknown' }}</p>
        <p>{{ \Carbon\Carbon::parse($fromDate)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($toDate)->format('M d, Y') }}</p>
    </div>

    <h3>Bookings</h3>
    <table>
        <thead>
            <tr>
                <th>Event Date</th>
                <th>Event Type</th>
                <th>Invoice Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>{{ optional($booking->event_start_at)->format('M d, Y') }}</td>
                <td>{{ $booking->event_type }}</td>
                <td>{{ number_format($booking->invoice_net_amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Payments</h3>
    <table>
        <thead>
            <tr>
                <th>Receipt Date</th>
                <th>Method</th>
                <th>Status</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{ optional($payment->receipt_date)->format('M d, Y') }}</td>
                <td>{{ $payment->payment_method }}</td>
                <td>{{ $payment->payment_status }}</td>
                <td>{{ number_format($payment->add_amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generated on {{ now()->format('M d, Y h:i A') }}
    </div>
</body>
</html>


