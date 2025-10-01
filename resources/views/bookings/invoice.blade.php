<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $booking->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        .container { width: 100%; padding: 16px; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; }
        .title { font-size: 20px; font-weight: bold; }
        .meta { text-align: right; }
        .section { margin-top: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; }
        th { background: #f3f3f3; text-align: left; }
        .totals { width: 40%; margin-left: auto; }
        .right { text-align: right; }
        .muted { color: #666; }
    </style>
    @php
        $formatMoney = fn($v) => number_format((float)$v, 2);
    @endphp
</head>
<body>
    <div class="container">
        <div style="text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 12px;">
            <div style="font-size: 22px; font-weight: bold; margin-bottom: 4px;">THE VENUE BANQUET</div>
            <div style="font-size: 11px; margin-bottom: 2px;">Contact: 0335-999 9357 - 0304-888 1100 | 021-34635544 - 021-34635533</div>
            <div style="font-size: 11px;">Address: Askari 4, Main Rashid Minhas Road Karachi</div>
        </div>

        <div class="header">
            <div>
                <div class="title">Invoice</div>
            </div>
            <div class="meta">
                <div><strong>Invoice #:</strong> {{ $booking->id }}</div>
                <div><strong>Date:</strong> {{ optional($booking->invoice_date)->format('d/m/Y') }}</div>
            </div>
        </div>

        <div class="section">
            <table>
                <tr>
                    <th style="width: 50%">Customer Details</th>
                    <th>Event Details</th>
                </tr>
                <tr>
                    <td>
                        <div><strong>Customer:</strong> {{ $booking->customer_name }}</div>
                        @if($booking->customer)
                            <div class="muted"><strong>Contact:</strong> {{ $booking->customer->phone }}</div>
                            <div class="muted"><strong>Address:</strong> {{ $booking->customer->address }}</div>
                        @endif
                    </td>
                    <td>
                        <div><strong>Type:</strong> {{ $booking->event_type }}</div>
                        <div><strong>Status:</strong> {{ $booking->event_status }}</div>
                        <div><strong>Guests:</strong> {{ $booking->total_guests }}</div>
                        <div><strong>From:</strong> {{ optional($booking->event_start_at)->format('d/m/Y H:i') }}</div>
                        <div><strong>To:</strong> {{ optional($booking->event_end_at)->format('d/m/Y H:i') }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="section">
            <table>
                <thead>
                    <tr>
                        <th style="width: 40px">Sr</th>
                        <th>Description</th>
                        <th class="right" style="width: 80px">Qty</th>
                        <th class="right" style="width: 90px">Rate</th>
                        <th class="right" style="width: 90px">Discount</th>
                        <th class="right" style="width: 110px">Net Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($booking->items as $it)
                        <tr>
                            <td>{{ $it->sr_no }}</td>
                            <td>{{ $it->item_description }}</td>
                            <td class="right">{{ $formatMoney($it->quantity) }}</td>
                            <td class="right">{{ $formatMoney($it->rate) }}</td>
                            <td class="right">
                                @if($it->discount_type === 'percent')
                                    {{ $formatMoney($it->discount_value) }}%
                                @else
                                    {{ $formatMoney($it->discount_value) }}
                                @endif
                            </td>
                            <td class="right">{{ $formatMoney($it->net_amount) }}</td>
                        </tr>
                    @endforeach
                    @if($booking->items->isEmpty())
                        <tr>
                            <td colspan="6" class="muted">No items</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="section">
            <table class="totals">
                <tr>
                    <td>Subtotal</td>
                    <td class="right">{{ $formatMoney($booking->items_subtotal) }}</td>
                </tr>
                <tr>
                    <td>Discount Total</td>
                    <td class="right">{{ $formatMoney($booking->items_discount_amount) }}</td>
                </tr>
                <tr>
                    <td><strong>Invoice Total</strong></td>
                    <td class="right"><strong>{{ $formatMoney($booking->invoice_net_amount) }}</strong></td>
                </tr>
                <tr>
                    <td>Paid</td>
                    <td class="right">{{ $formatMoney($booking->invoice_total_paid) }}</td>
                </tr>
                <tr>
                    <td><strong>Closing Amount</strong></td>
                    <td class="right"><strong>{{ $formatMoney($booking->invoice_closing_amount) }}</strong></td>
                </tr>
            </table>
            @if($booking->amount_in_words)
                <div class="muted" style="margin-top: 8px">
                    Amount in words: <em>{{ $booking->amount_in_words }}</em>
                </div>
            @endif
        </div>

        <div class="section">
            <div class="muted">Payment: {{ $booking->payment_status }} @if($booking->payment_option) ({{ ucfirst($booking->payment_option) }}) @endif</div>
            @if($booking->remarks)
                <div style="margin-top: 6px"><strong>Remarks:</strong> {{ $booking->remarks }}</div>
            @endif
        </div>

        <div class="section" style="margin-top: 24px">
            <div class="muted">Thank you for choosing The Venue.</div>
        </div>
    </div>
</body>
</html>

