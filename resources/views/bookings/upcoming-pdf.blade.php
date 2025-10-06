<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Upcoming Events Report</title>
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
            border-bottom: 2px solid #4F46E5;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #4F46E5;
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
            background-color: #F3F4F6;
            color: #374151;
            font-weight: bold;
            padding: 8px;
            text-align: left;
            border: 1px solid #D1D5DB;
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
        }
        .status-upcoming {
            background-color: #DCFCE7;
            color: #166534;
        }
        .status-confirmed {
            background-color: #DBEAFE;
            color: #1E40AF;
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
        <h1>Upcoming Events Report</h1>
        <p>The Venue - Banquet Management System</p>
    </div>

    <div class="report-info">
        <strong>Generated on:</strong> {{ now()->format('F d, Y \a\t h:i A') }}<br>
        <strong>Total Events:</strong> {{ $bookings->count() }}
    </div>

    @if($bookings->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">Sr#</th>
                    <th style="width: 15%;">Event Date & Time</th>
                    <th style="width: 20%;">Customer Name</th>
                    <th style="width: 12%;">Contact</th>
                    <th style="width: 10%;">Total Guests</th>
                    <th style="width: 12%;">From Date</th>
                    <th style="width: 12%;">To Date</th>
                    <th style="width: 14%;">Event Type</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $index => $booking)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $booking->event_start_at ? $booking->event_start_at->format('M d, Y') : 'N/A' }}</strong><br>
                            <small>{{ $booking->event_start_at ? $booking->event_start_at->format('h:i A') : 'N/A' }}</small>
                        </td>
                        <td><strong>{{ $booking->customer_name }}</strong></td>
                        <td>{{ $booking->customer->phone ?? $booking->contact ?? 'N/A' }}</td>
                        <td>
                            <span class="status-badge status-upcoming">
                                {{ $booking->total_guests ?? 'N/A' }}
                            </span>
                        </td>
                        <td>{{ $booking->event_start_at ? $booking->event_start_at->format('M d, Y') : 'N/A' }}</td>
                        <td>{{ $booking->event_end_at ? $booking->event_end_at->format('M d, Y') : 'N/A' }}</td>
                        <td>
                            <span class="status-badge status-confirmed">
                                {{ $booking->event_type }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <h3>No Upcoming Events Found</h3>
            <p>There are no upcoming events to display in this report.</p>
        </div>
    @endif

    <div class="footer">
        <p>This report was generated automatically by The Venue Banquet Management System</p>
        <p>For any queries, please contact the management</p>
    </div>
</body>
</html>
