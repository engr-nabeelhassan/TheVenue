<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customers Summary Report</title>
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
        .summary-cards {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
            background-color: #F9FAFB;
            padding: 15px;
            border-radius: 8px;
        }
        .summary-card {
            text-align: center;
        }
        .summary-card h3 {
            font-size: 24px;
            margin: 0;
            color: #1F2937;
        }
        .summary-card p {
            font-size: 12px;
            margin: 5px 0 0 0;
            color: #6B7280;
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
        .status-active {
            background-color: #DCFCE7;
            color: #166534;
        }
        .status-inactive {
            background-color: #F3F4F6;
            color: #374151;
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
        <h1>Customers Summary Report</h1>
        <p>The Venue - Banquet Management System</p>
    </div>

    <div class="report-info">
        <strong>Generated on:</strong> {{ now()->format('F d, Y \a\t h:i A') }}<br>
        <strong>Date Range:</strong> {{ \Carbon\Carbon::parse($fromDate)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($toDate)->format('M d, Y') }}<br>
        <strong>Total Customers:</strong> {{ $totalCustomers }}
    </div>

    <div class="summary-cards">
        <div class="summary-card">
            <h3>{{ $totalCustomers }}</h3>
            <p>Total Customers</p>
        </div>
        <div class="summary-card">
            <h3>{{ $activeCustomers }}</h3>
            <p>Active Customers</p>
        </div>
        <div class="summary-card">
            <h3>{{ $totalCustomers - $activeCustomers }}</h3>
            <p>Inactive Customers</p>
        </div>
        <div class="summary-card">
            <h3>{{ number_format($totalCurrentBalance, 2) }} PKR</h3>
            <p>Total Current Balance</p>
        </div>
    </div>

    @if($customers->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">Sr#</th>
                    <th style="width: 25%;">Customer Name</th>
                    <th style="width: 15%;">Contact</th>
                    <th style="width: 12%;">CNIC</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 10%;">Total Bookings</th>
                    <th style="width: 23%;">Current Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $index => $customer)
                    @php
                        $totalBookings = $customer->bookings->count();
                        $totalAmount = $customer->bookings->sum('invoice_net_amount');
                        $totalAdvanceAmount = $customer->bookings->sum('advance_amount');
                        $totalDebits = $customer->payments->where('payment_method', 'Debit')->sum('add_amount');
                        $totalCredits = $customer->payments->where('payment_method', 'Credit')->sum('add_amount');
                        $currentBalance = $totalAmount + $totalDebits - ($totalAdvanceAmount + $totalCredits);
                        $isActive = $totalBookings > 0;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $customer->full_name }}</strong></td>
                        <td>{{ $customer->phone ?? 'N/A' }}</td>
                        <td>{{ $customer->cnic ?? 'N/A' }}</td>
                        <td>
                            <span class="status-badge {{ $isActive ? 'status-active' : 'status-inactive' }}">
                                {{ $isActive ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge status-active">
                                {{ $totalBookings }}
                            </span>
                        </td>
                        <td>
                            <strong style="color: {{ $currentBalance > 0 ? '#DC2626' : ($currentBalance < 0 ? '#059669' : '#374151') }};">
                                {{ number_format($currentBalance, 2) }} PKR
                            </strong>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <h3>No Customers Found</h3>
            <p>No customers found for the selected date range.</p>
        </div>
    @endif

    <div class="footer">
        <p>This report was generated automatically by The Venue Banquet Management System</p>
        <p>For any queries, please contact the management</p>
    </div>
</body>
</html>
