<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Events Balance Report</title>
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
        <h1>Events Balance Report</h1>
        <p>{{ \Carbon\Carbon::parse($fromDate)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($toDate)->format('M d, Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Sr#</th>
                <th>Event Date</th>
                <th>Customer</th>
                <th>Event Type</th>
                <th>Invoice Amount</th>
                <th>Paid (Credit)</th>
                <th>Outstanding</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $index => $booking)
                @php
                    $paid = $booking->payments->where('payment_method', 'Credit')->sum('add_amount');
                    $outstanding = ($booking->invoice_net_amount ?? 0) - $paid;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ optional($booking->event_start_at)->format('M d, Y') }}</td>
                    <td>{{ $booking->customer_name }}</td>
                    <td>{{ $booking->event_type }}</td>
                    <td>{{ number_format($booking->invoice_net_amount, 2) }}</td>
                    <td>{{ number_format($paid, 2) }}</td>
                    <td>{{ number_format($outstanding, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table>
        <tr>
            <th>Total Revenue</th>
            <td>{{ number_format($totalRevenue, 2) }}</td>
            <th>Total Paid</th>
            <td>{{ number_format($totalPaid, 2) }}</td>
            <th>Total Outstanding</th>
            <td>{{ number_format($totalOutstanding, 2) }}</td>
        </tr>
    </table>

    <div class="footer">
        Generated on {{ now()->format('M d, Y h:i A') }}
    </div>
</body>
</html>


