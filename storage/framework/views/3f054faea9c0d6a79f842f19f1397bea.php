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
        <p><?php echo e(\Carbon\Carbon::parse($fromDate)->format('M d, Y')); ?> to <?php echo e(\Carbon\Carbon::parse($toDate)->format('M d, Y')); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Invoice Date</th>
                <th>Event Date</th>
                <th>Customer</th>
                <th>Invoice Subtotal</th>
                <th>Discount Total</th>
                <th>Invoice Amount</th>
                <th>Advance/Full-Payment</th>
                <th>Closing Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $advanceFullPayment = $booking->advance_amount ?? 0;
                    $closingAmount = $booking->invoice_closing_amount ?? 0;
                ?>
                <tr>
                    <td><?php echo e(optional($booking->created_at)->format('M d, Y')); ?></td>
                    <td><?php echo e(optional($booking->event_start_at)->format('M d, Y')); ?></td>
                    <td><?php echo e($booking->customer_name); ?></td>
                    <td><?php echo e(number_format($booking->items_subtotal ?? 0, 2)); ?></td>
                    <td><?php echo e(number_format($booking->items_discount_amount ?? 0, 2)); ?></td>
                    <td><?php echo e(number_format($booking->invoice_net_amount, 2)); ?></td>
                    <td><?php echo e(number_format($advanceFullPayment, 2)); ?></td>
                    <td><?php echo e(number_format($closingAmount, 2)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <table>
        <tr>
            <th>Total Revenue</th>
            <td><?php echo e(number_format($totalRevenue, 2)); ?></td>
            <th>Total Advance/Full-Payment</th>
            <td><?php echo e(number_format($totalPaid, 2)); ?></td>
            <th>Total Closing Amount</th>
            <td><?php echo e(number_format($totalClosingAmount, 2)); ?></td>
        </tr>
    </table>

    <div class="footer">
        Generated on <?php echo e(now()->format('M d, Y h:i A')); ?>

    </div>
</body>
</html>


<?php /**PATH C:\Users\Shahjahan\Desktop\the_venue\resources\views/reports/events-balance-pdf.blade.php ENDPATH**/ ?>