<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Venue Events Summary</title>
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
        <h1>Venue Events Summary</h1>
        <p><?php echo e(\Carbon\Carbon::parse($fromDate)->format('M d, Y')); ?> to <?php echo e(\Carbon\Carbon::parse($toDate)->format('M d, Y')); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Event Type</th>
                <th>Events Count</th>
                <th>Total Revenue</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($type); ?></td>
                <td><?php echo e($list->count()); ?></td>
                <td><?php echo e(number_format($list->sum('invoice_net_amount'), 2)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <table>
        <tr>
            <th>Total Events</th>
            <td><?php echo e($totalEvents); ?></td>
            <th>Total Revenue</th>
            <td><?php echo e(number_format($totalRevenue, 2)); ?></td>
        </tr>
    </table>

    <div class="footer">
        Generated on <?php echo e(now()->format('M d, Y h:i A')); ?>

    </div>
</body>
</html>


<?php /**PATH C:\Users\Shahjahan\Desktop\the_venue\resources\views/reports/venue-events-pdf.blade.php ENDPATH**/ ?>