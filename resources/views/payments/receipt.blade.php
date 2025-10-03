<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Receipt #{{ $payment->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }
        .container {
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #4F46E5;
            padding-bottom: 15px;
        }
        .header h1 {
            font-size: 26px;
            color: #4F46E5;
            margin-bottom: 5px;
        }
        .header .contact-info {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }
        .receipt-title {
            text-align: center;
            background: #4F46E5;
            color: white;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0;
        }
        .info-grid {
            width: 100%;
            margin: 20px 0;
        }
        .info-grid table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-grid td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .info-grid .label {
            background: #f3f4f6;
            font-weight: bold;
            width: 35%;
        }
        .info-grid .value {
            width: 65%;
        }
        .amount-section {
            margin: 30px 0;
            border: 2px solid #4F46E5;
            background: #EEF2FF;
        }
        .amount-section table {
            width: 100%;
            border-collapse: collapse;
        }
        .amount-section td {
            padding: 10px 15px;
            border-bottom: 1px solid #C7D2FE;
        }
        .amount-section .label {
            font-weight: bold;
            width: 60%;
        }
        .amount-section .value {
            text-align: right;
            font-weight: bold;
            width: 40%;
        }
        .amount-section .total-row {
            background: #4F46E5;
            color: white;
            font-size: 14px;
        }
        .amount-section .total-row td {
            border-bottom: none;
        }
        .remarks-section {
            margin: 20px 0;
            padding: 15px;
            background: #FEF3C7;
            border-left: 4px solid #F59E0B;
        }
        .remarks-section .title {
            font-weight: bold;
            margin-bottom: 5px;
            color: #92400E;
        }
        .signature-section {
            margin-top: 50px;
            width: 100%;
        }
        .signature-section table {
            width: 100%;
        }
        .signature-section td {
            width: 50%;
            text-align: center;
            padding: 0 20px;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 50px;
            padding-top: 5px;
            font-size: 10px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 9px;
            color: #6B7280;
            border-top: 1px solid #E5E7EB;
            padding-top: 15px;
        }
        .footer p {
            margin: 3px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>THE VENUE BANQUET</h1>
            <div class="contact-info">
                <div>Contact: 0335-999 9357 - 0304-888 1100 | 021-34635544 - 021-34635533</div>
                <div>Address: Askari 4, Main Rashid Minhas Road Karachi</div>
            </div>
        </div>

        <!-- Receipt Title -->
        <div class="receipt-title">PAYMENT RECEIPT</div>

        <!-- Receipt Information -->
        <div class="info-grid">
            <table>
                <tr>
                    <td class="label">Receipt No:</td>
                    <td class="value">#{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <td class="label">Receipt Date:</td>
                    <td class="value">{{ $payment->receipt_date->format('d F, Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Customer Name:</td>
                    <td class="value">{{ $payment->customer_name }}</td>
                </tr>
                <tr>
                    <td class="label">Contact Number:</td>
                    <td class="value">{{ $payment->contact }}</td>
                </tr>
                @if($payment->booking)
                <tr>
                    <td class="label">Related Booking ID:</td>
                    <td class="value">#{{ str_pad($payment->booking->id, 5, '0', STR_PAD_LEFT) }}</td>
                </tr>
                @endif
                <tr>
                    <td class="label">Payment Method:</td>
                    <td class="value">{{ $payment->payment_method }}</td>
                </tr>
                <tr>
                    <td class="label">Payment Status:</td>
                    <td class="value">{{ $payment->payment_status }}</td>
                </tr>
            </table>
        </div>

        <!-- Amount Details -->
        <div class="amount-section">
            <table>
                <tr>
                    <td class="label">Previous Balance:</td>
                    <td class="value">PKR {{ number_format($payment->previous_balance, 2) }}</td>
                </tr>
                <tr>
                    <td class="label">{{ $payment->payment_method === 'Debit' ? 'Amount Added (+):' : 'Amount Paid (-):' }}</td>
                    <td class="value">PKR {{ number_format($payment->add_amount, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td class="label">Remaining Balance:</td>
                    <td class="value">PKR {{ number_format($payment->remaining_balance, 2) }}</td>
                </tr>
            </table>
        </div>

        <!-- Remarks -->
        @if($payment->remarks)
        <div class="remarks-section">
            <div class="title">Remarks:</div>
            <div>{{ $payment->remarks }}</div>
        </div>
        @endif

        <!-- Signature Section -->
        <div class="signature-section">
            <table>
                <tr>
                    <td>
                        <div class="signature-line">Customer Signature</div>
                    </td>
                    <td>
                        <div class="signature-line">Authorized Signature</div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>This is a computer-generated receipt.</strong></p>
            <p>Generated on: {{ now()->format('d F, Y - h:i A') }}</p>
            <p>Thank you for your business with THE VENUE BANQUET!</p>
        </div>
    </div>
</body>
</html>
