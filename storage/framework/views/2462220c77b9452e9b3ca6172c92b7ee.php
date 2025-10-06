<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Booking Details - Invoice #<?php echo e($booking->id); ?>

            </h2>
            <div class="flex space-x-2">
                <a href="<?php echo e(route('bookings.invoice', $booking)); ?>" 
                   class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                    Download PDF
                </a>
                <a href="<?php echo e(route('bookings.edit', $booking)); ?>" 
                   class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700">
                    Edit
                </a>
                <a href="<?php echo e(route('bookings.index')); ?>" 
                   class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                    Back to List
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <!-- Invoice Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="text-center">
                        <h1 class="text-3xl font-bold text-gray-900">THE VENUE BANQUET</h1>
                        <p class="text-lg text-gray-600">Contact: 0335-999 9357 - 0304-888 1100 | 021-34635544 - 021-34635533</p>
                        <p class="text-lg text-gray-600">Address: Askari 4, Main Rashid Minhas Road Karachi</p>
                    </div>
                </div>

                <!-- Invoice Details -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Invoice Information</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">Invoice Date:</span> <?php echo e($booking->invoice_date->format('d/m/Y')); ?></p>
                                <p><span class="font-medium">Invoice #:</span> <?php echo e($booking->id); ?></p>
                                <p><span class="font-medium">Event Type:</span> <?php echo e($booking->event_type); ?></p>
                                <p><span class="font-medium">Total Guests:</span> <?php echo e($booking->total_guests); ?></p>
                                <p><span class="font-medium">Event Status:</span> 
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        <?php if($booking->event_status == 'In Progress'): ?> bg-yellow-100 text-yellow-800
                                        <?php elseif($booking->event_status == 'Completed'): ?> bg-green-100 text-green-800
                                        <?php elseif($booking->event_status == 'Cancelled'): ?> bg-red-100 text-red-800
                                        <?php elseif($booking->event_status == 'Postponed'): ?> bg-blue-100 text-blue-800
                                        <?php endif; ?>">
                                        <?php echo e($booking->event_status); ?>

                                    </span>
                                </p>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Event Details</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">Event Start:</span> <?php echo e($booking->event_start_at->format('d/m/Y H:i')); ?></p>
                                <p><span class="font-medium">Event End:</span> <?php echo e($booking->event_end_at->format('d/m/Y H:i')); ?></p>
                                <p><span class="font-medium">Payment Status:</span> <?php echo e($booking->payment_status); ?></p>
                                <p><span class="font-medium">Payment Option:</span> <?php echo e(ucfirst($booking->payment_option ?? 'N/A')); ?></p>
                                <?php if($booking->advance_amount > 0): ?>
                                    <p><span class="font-medium">Advance Amount:</span> <?php echo e(number_format($booking->advance_amount, 2)); ?> PKR</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p><span class="font-medium">Customer Name:</span> <?php echo e($booking->customer_name); ?></p>
                            <?php if($booking->customer): ?>
                                <p><span class="font-medium">Contact:</span> <?php echo e($booking->customer->phone); ?></p>
                                <p><span class="font-medium">Address:</span> <?php echo e($booking->customer->address); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Invoice Items</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 border border-gray-300 text-left">SR</th>
                                        <th class="px-4 py-2 border border-gray-300 text-left">ITEM DESCRIPTION</th>
                                        <th class="px-4 py-2 border border-gray-300 text-right">QUANTITY</th>
                                        <th class="px-4 py-2 border border-gray-300 text-right">RATE</th>
                                        <th class="px-4 py-2 border border-gray-300 text-left">DISCOUNT</th>
                                        <th class="px-4 py-2 border border-gray-300 text-right">NET AMOUNT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $booking->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="px-4 py-2 border border-gray-300"><?php echo e($item->sr_no); ?></td>
                                            <td class="px-4 py-2 border border-gray-300"><?php echo e($item->item_description); ?></td>
                                            <td class="px-4 py-2 border border-gray-300 text-right"><?php echo e(number_format($item->quantity, 2)); ?></td>
                                            <td class="px-4 py-2 border border-gray-300 text-right"><?php echo e(number_format($item->rate, 2)); ?></td>
                                            <td class="px-4 py-2 border border-gray-300">
                                                <?php echo e($item->discount_type == 'percent' ? $item->discount_value . '%' : number_format($item->discount_value, 2)); ?>

                                            </td>
                                            <td class="px-4 py-2 border border-gray-300 text-right"><?php echo e(number_format($item->net_amount, 2)); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Invoice Totals -->
                    <div class="mt-6">
                        <div class="flex justify-end">
                            <div class="w-64">
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="font-medium">Invoice Subtotal:</span>
                                        <span><?php echo e(number_format($booking->items_subtotal, 2)); ?> PKR</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium">Discount Total:</span>
                                        <span><?php echo e(number_format($booking->items_discount_amount, 2)); ?> PKR</span>
                                    </div>
                                    <div class="flex justify-between text-lg font-bold border-t pt-2">
                                        <span>INVOICE TOTAL:</span>
                                        <span><?php echo e(number_format($booking->invoice_net_amount, 2)); ?> PKR</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium">Total Paid:</span>
                                        <span><?php echo e(number_format($booking->invoice_total_paid, 2)); ?> PKR</span>
                                    </div>
                                    <div class="flex justify-between text-lg font-bold border-t pt-2">
                                        <span>Closing Amount:</span>
                                        <span><?php echo e(number_format($booking->invoice_closing_amount, 2)); ?> PKR</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if($booking->amount_in_words): ?>
                        <div class="mt-4">
                            <p><span class="font-medium">Amount in Words:</span> <?php echo e($booking->amount_in_words); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if($booking->remarks): ?>
                        <div class="mt-4">
                            <p><span class="font-medium">Remarks:</span> <?php echo e($booking->remarks); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Shahjahan\Desktop\the_venue\resources\views/bookings/show.blade.php ENDPATH**/ ?>