<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customer Statement</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 15px; border-bottom: 2px solid #4F46E5; padding-bottom: 10px; }
        .customer-info { margin-bottom: 15px; padding: 10px; background: #F9FAFB; border: 1px solid #E5E7EB; }
        .summary { margin-bottom: 15px; }
        .summary-box { display: inline-block; width: 23%; padding: 8px; margin-right: 1%; background: #F3F4F6; border: 1px solid #D1D5DB; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        th { background: #F3F4F6; color: #374151; padding: 6px; text-align: left; border: 1px solid #D1D5DB; font-size: 9px; font-weight: bold; }
        td { padding: 5px; border: 1px solid #D1D5DB; font-size: 9px; }
        .text-right { text-align: right; }
        .opening-row { background: #DBEAFE; font-weight: bold; }
        .closing-row { background: #FEE2E2; font-weight: bold; }
        .footer { text-align: center; font-size: 9px; color: #666; border-top: 1px solid #E5E7EB; padding-top: 8px; margin-top: 16px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Customer Statement</h1>
        <p>The Venue - Banquet Management System</p>
    </div>

    <div class="customer-info">
        <strong>Customer:</strong> <?php echo e($selectedCustomer->full_name ?? 'Unknown'); ?><br>
        <strong>Phone:</strong> <?php echo e($selectedCustomer->phone ?? 'N/A'); ?><br>
        <strong>CNIC:</strong> <?php echo e($selectedCustomer->cnic ?? 'N/A'); ?><br>
        <strong>Period:</strong> <?php echo e(\Carbon\Carbon::parse($fromDate)->format('M d, Y')); ?> to <?php echo e(\Carbon\Carbon::parse($toDate)->format('M d, Y')); ?>

    </div>

    <?php
        // Calculate opening balance
        $openingBookings = \App\Models\Booking::where('customer_id', $selectedCustomer->id)
            ->where('event_start_at', '<', $fromDate)
            ->sum('invoice_net_amount');
        
        $openingAdvance = \App\Models\Booking::where('customer_id', $selectedCustomer->id)
            ->where('event_start_at', '<', $fromDate)
            ->sum('advance_amount');
        
        $openingDebits = \App\Models\Payment::where('customer_id', $selectedCustomer->id)
            ->where('receipt_date', '<', $fromDate)
            ->where('payment_method', 'Debit')
            ->sum('add_amount');
        
        $openingCredits = \App\Models\Payment::where('customer_id', $selectedCustomer->id)
            ->where('receipt_date', '<', $fromDate)
            ->where('payment_method', 'Credit')
            ->sum('add_amount');
        
        $openingBalance = $openingBookings + $openingDebits - ($openingAdvance + $openingCredits);
        
        // Calculate totals
        $totalBookings = $bookings->sum('invoice_net_amount');
        $totalAdvance = $bookings->sum('advance_amount');
        $totalCredits = $payments->where('payment_method', 'Credit')->sum('add_amount');
        $totalDebits = $payments->where('payment_method', 'Debit')->sum('add_amount');
        $closingBalance = $openingBalance + $totalBookings + $totalDebits - ($totalAdvance + $totalCredits);
        
        // Combine transactions
        $transactions = collect();
        foreach($bookings as $booking) {
            // Add booking invoice
            $transactions->push([
                'date' => $booking->event_start_at,
                'type' => 'Booking',
                'description' => $booking->event_type . ' Event',
                'debit' => $booking->invoice_net_amount,
                'credit' => 0,
                'reference' => 'Invoice #' . $booking->id
            ]);
            
            // Add advance payment if exists
            if($booking->advance_amount > 0) {
                $transactions->push([
                    'date' => $booking->event_start_at,
                    'type' => 'Advance Payment',
                    'description' => 'Advance Payment for ' . $booking->event_type,
                    'debit' => 0,
                    'credit' => $booking->advance_amount,
                    'reference' => 'Advance #' . $booking->id
                ]);
            }
        }
        foreach($payments as $payment) {
            $transactions->push([
                'date' => $payment->receipt_date,
                'type' => 'Payment',
                'description' => $payment->payment_status . ' Payment',
                'debit' => $payment->payment_method === 'Debit' ? $payment->add_amount : 0,
                'credit' => $payment->payment_method === 'Credit' ? $payment->add_amount : 0,
                'reference' => 'Receipt #' . $payment->id
            ]);
        }
        $transactions = $transactions->sortBy('date');
    ?>

    <div class="summary">
        <div class="summary-box">
            <div style="font-size: 8px; color: #666;">Opening Balance</div>
            <div style="font-size: 12px; font-weight: bold;"><?php echo e(number_format($openingBalance, 2)); ?></div>
        </div>
        <div class="summary-box">
            <div style="font-size: 8px; color: #666;">Total Invoiced</div>
            <div style="font-size: 12px; font-weight: bold;"><?php echo e(number_format($totalBookings, 2)); ?></div>
        </div>
        <div class="summary-box">
            <div style="font-size: 8px; color: #666;">Total Paid</div>
            <div style="font-size: 12px; font-weight: bold;"><?php echo e(number_format($totalAdvance + $totalCredits, 2)); ?></div>
        </div>
        <div class="summary-box">
            <div style="font-size: 8px; color: #666;">Closing Balance</div>
            <div style="font-size: 12px; font-weight: bold;"><?php echo e(number_format($closingBalance, 2)); ?></div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Description</th>
                <th>Reference</th>
                <th class="text-right">Debit</th>
                <th class="text-right">Credit</th>
                <th class="text-right">Balance</th>
            </tr>
        </thead>
        <tbody>
            <tr class="opening-row">
                <td><?php echo e(\Carbon\Carbon::parse($fromDate)->format('M d, Y')); ?></td>
                <td>Opening</td>
                <td>Opening Balance</td>
                <td>—</td>
                <td class="text-right">—</td>
                <td class="text-right">—</td>
                <td class="text-right"><?php echo e(number_format($openingBalance, 2)); ?></td>
            </tr>

            <?php $runningBalance = $openingBalance; ?>
            <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $runningBalance += $transaction['debit'] - $transaction['credit']; ?>
                <tr>
                    <td><?php echo e(\Carbon\Carbon::parse($transaction['date'])->format('M d, Y')); ?></td>
                    <td><?php echo e($transaction['type']); ?></td>
                    <td><?php echo e($transaction['description']); ?></td>
                    <td><?php echo e($transaction['reference']); ?></td>
                    <td class="text-right"><?php echo e($transaction['debit'] > 0 ? number_format($transaction['debit'], 2) : '—'); ?></td>
                    <td class="text-right"><?php echo e($transaction['credit'] > 0 ? number_format($transaction['credit'], 2) : '—'); ?></td>
                    <td class="text-right"><?php echo e(number_format($runningBalance, 2)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <tr class="closing-row">
                <td><?php echo e(\Carbon\Carbon::parse($toDate)->format('M d, Y')); ?></td>
                <td>Closing</td>
                <td>Closing Balance</td>
                <td>—</td>
                <td class="text-right"><?php echo e(number_format($totalBookings + $totalDebits, 2)); ?></td>
                <td class="text-right"><?php echo e(number_format($totalAdvance + $totalCredits, 2)); ?></td>
                <td class="text-right"><?php echo e(number_format($closingBalance, 2)); ?></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Generated on <?php echo e(now()->format('M d, Y h:i A')); ?>

    </div>
</body>
</html>


<?php /**PATH C:\Users\Shahjahan\Desktop\the_venue\resources\views/reports/customer-statements-pdf.blade.php ENDPATH**/ ?>