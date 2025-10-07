<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cancelled Bookings Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #DC2626;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #DC2626;
            font-size: 24px;
            margin: 0;
        }
        .header p {
            color: #666;
            margin: 5px 0 0 0;
        }
        .report-info {
            margin-bottom: 20px;
            font-size: 10px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #FEE2E2;
            color: #991B1B;
            font-weight: bold;
            padding: 8px;
            text-align: left;
            border: 1px solid #FECACA;
            font-size: 10px;
        }
        td {
            padding: 8px;
            border: 1px solid #D1D5DB;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #F9FAFB;
        }
        .status-badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
            background-color: #FEE2E2;
            color: #991B1B;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #E5E7EB;
            padding-top: 10px;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Cancelled Bookings Report</h1>
        <p>The Venue - Banquet Management System</p>
        <p>{{ \Carbon\Carbon::parse($fromDate)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($toDate)->format('M d, Y') }}</p>
    </div>

    <div class="report-info">
        <strong>Generated on:</strong> {{ now()->format('F d, Y \a\t H:i') }}<br>
        <strong>Total Cancelled Bookings:</strong> {{ $bookings->count() }}
    </div>

    @if($bookings->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">Sr#</th>
                    <th style="width: 25%;">Customer Name</th>
                    <th style="width: 15%;">Event Type</th>
                    <th style="width: 15%;">Event Date</th>
                    <th style="width: 15%;">Invoice Amount</th>
                    <th style="width: 15%;">Contact</th>
                    <th style="width: 10%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $index => $booking)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $booking->customer_name }}</strong></td>
                        <td>{{ $booking->event_type }}</td>
                        <td>{{ $booking->event_start_at ? $booking->event_start_at->format('M d, Y') : 'N/A' }}</td>
                        <td>{{ number_format($booking->invoice_net_amount, 2) }} PKR</td>
                        <td>{{ $booking->customer->phone ?? $booking->contact ?? 'N/A' }}</td>
                        <td>
                            <span class="status-badge">
                                {{ $booking->event_status }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <h3>No Cancelled Bookings Found</h3>
            <p>There are no cancelled bookings to display in this report.</p>
        </div>
    @endif

    <div class="footer">
        <p>This report was generated automatically by The Venue Banquet Management System</p>
        <p>For any queries, please contact the management</p>
    </div>
</body>
</html>
