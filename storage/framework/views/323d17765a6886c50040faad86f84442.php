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
                Events Balance Summary
            </h2>
            <div class="flex space-x-2">
                <a href="<?php echo e(route('reports.index')); ?>" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">Back to Reports</a>
                <a href="<?php echo e(route('reports.events-balance.pdf', request()->query())); ?>" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Download PDF</a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <!-- Filters -->
                <div class="p-6 border-b border-gray-200">
                    <form method="GET" action="<?php echo e(route('reports.events-balance')); ?>" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">From Date</label>
                            <input type="date" name="from_date" value="<?php echo e($fromDate); ?>" class="mt-1 block w-full rounded-md border-gray-300" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">To Date</label>
                            <input type="date" name="to_date" value="<?php echo e($toDate); ?>" class="mt-1 block w-full rounded-md border-gray-300" required>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Generate</button>
                        </div>
                    </form>

                    <!-- Search Box -->
                    <div class="mt-4">
                        <form method="GET" action="<?php echo e(route('reports.events-balance')); ?>" class="flex gap-2">
                            <input type="hidden" name="from_date" value="<?php echo e($fromDate); ?>">
                            <input type="hidden" name="to_date" value="<?php echo e($toDate); ?>">
                            <input type="hidden" name="sort" value="<?php echo e(request('sort', 'event_start_at')); ?>">
                            <input type="hidden" name="direction" value="<?php echo e(request('direction', 'desc')); ?>">
                            <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                                   placeholder="Search by customer name or event type" 
                                   class="w-full md:w-96 rounded-md border-gray-300 shadow-sm py-2">
                            <button type="submit" class="px-4 py-2 bg-gray-100 border rounded-md hover:bg-gray-200">Search</button>
                            <a href="<?php echo e(route('reports.events-balance', ['from_date' => $fromDate, 'to_date' => $toDate])); ?>" 
                               class="px-4 py-2 border rounded-md hover:bg-gray-50">Reset</a>
                        </form>
                    </div>
                </div>

                <!-- Summary -->
                <div class="p-6 border-b border-gray-200">
                    <!-- Column Order: Invoice Subtotal → Discount Total → Invoice Amount → Advance/Full-Payment → Closing Amount -->
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div class="bg-purple-50 p-4 rounded">
                            <div class="text-sm text-purple-600">Total Invoice Subtotal</div>
                            <div class="text-xl font-bold text-purple-900"><?php echo e(number_format($totalSubtotal, 2)); ?> PKR</div>
                        </div>
                        <div class="bg-orange-50 p-4 rounded">
                            <div class="text-sm text-orange-600">Total Discount</div>
                            <div class="text-xl font-bold text-orange-900"><?php echo e(number_format($totalDiscount, 2)); ?> PKR</div>
                        </div>
                        <div class="bg-blue-50 p-4 rounded">
                            <div class="text-sm text-blue-600">Total Invoice Amount</div>
                            <div class="text-xl font-bold text-blue-900"><?php echo e(number_format($totalRevenue, 2)); ?> PKR</div>
                        </div>
                        <div class="bg-green-50 p-4 rounded">
                            <div class="text-sm text-green-600">Total Advance/Full-Payment</div>
                            <div class="text-xl font-bold text-green-900"><?php echo e(number_format($totalPaid, 2)); ?> PKR</div>
                        </div>
                        <div class="bg-red-50 p-4 rounded">
                            <div class="text-sm text-red-600">Total Closing Amount</div>
                            <div class="text-xl font-bold text-red-900"><?php echo e(number_format($totalClosingAmount, 2)); ?> PKR</div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="<?php echo e(route('reports.events-balance', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => request('sort')==='created_at' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" 
                                       class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Invoice Date
                                        <?php if(request('sort')==='created_at'): ?>
                                            <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                        <?php else: ?>
                                            <span class="text-gray-300">↕</span>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="<?php echo e(route('reports.events-balance', array_merge(request()->query(), ['sort' => 'event_start_at', 'direction' => request('sort')==='event_start_at' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" 
                                       class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Event Date
                                        <?php if(request('sort')==='event_start_at'): ?>
                                            <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                        <?php else: ?>
                                            <span class="text-gray-300">↕</span>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="<?php echo e(route('reports.events-balance', array_merge(request()->query(), ['sort' => 'customer_name', 'direction' => request('sort')==='customer_name' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" 
                                       class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Customer
                                        <?php if(request('sort')==='customer_name'): ?>
                                            <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                        <?php else: ?>
                                            <span class="text-gray-300">↕</span>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="<?php echo e(route('reports.events-balance', array_merge(request()->query(), ['sort' => 'items_subtotal', 'direction' => request('sort')==='items_subtotal' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" 
                                       class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Invoice Subtotal
                                        <?php if(request('sort')==='items_subtotal'): ?>
                                            <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                        <?php else: ?>
                                            <span class="text-gray-300">↕</span>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="<?php echo e(route('reports.events-balance', array_merge(request()->query(), ['sort' => 'items_discount_amount', 'direction' => request('sort')==='items_discount_amount' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" 
                                       class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Discount Total
                                        <?php if(request('sort')==='items_discount_amount'): ?>
                                            <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                        <?php else: ?>
                                            <span class="text-gray-300">↕</span>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="<?php echo e(route('reports.events-balance', array_merge(request()->query(), ['sort' => 'invoice_net_amount', 'direction' => request('sort')==='invoice_net_amount' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" 
                                       class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Invoice Amount
                                        <?php if(request('sort')==='invoice_net_amount'): ?>
                                            <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                        <?php else: ?>
                                            <span class="text-gray-300">↕</span>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Advance/Full-Payment</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Closing Amount</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $advanceFullPayment = $booking->advance_amount ?? 0;
                                    $closingAmount = ($booking->invoice_net_amount ?? 0) - $advanceFullPayment; // Fixed: Invoice Amount - Advance Payment
                                ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e(optional($booking->created_at)->format('M d, Y')); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e(optional($booking->event_start_at)->format('M d, Y')); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($booking->customer_name); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e(number_format($booking->items_subtotal ?? 0, 2)); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e(number_format($booking->items_discount_amount ?? 0, 2)); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e(number_format($booking->invoice_net_amount, 2)); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e(number_format($advanceFullPayment, 2)); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e(number_format($closingAmount, 2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination & Per-page Controls -->
                <div class="px-6 py-4 border-t border-gray-200 mt-4 flex items-center justify-between gap-4">
                    <form method="GET" action="<?php echo e(route('reports.events-balance')); ?>" class="flex items-center gap-2 text-sm">
                        <span class="text-gray-600">Show</span>
                        <select name="per_page" class="rounded-md border-gray-300" onchange="this.form.submit()">
                            <?php $__currentLoopData = [10,25,50,100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($n); ?>" <?php echo e((int)request('per_page', 10) === $n ? 'selected' : ''); ?>><?php echo e($n); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <span class="text-gray-600">entries</span>
                        <input type="hidden" name="from_date" value="<?php echo e($fromDate); ?>" />
                        <input type="hidden" name="to_date" value="<?php echo e($toDate); ?>" />
                        <input type="hidden" name="search" value="<?php echo e(request('search')); ?>" />
                        <input type="hidden" name="sort" value="<?php echo e(request('sort', 'event_start_at')); ?>" />
                        <input type="hidden" name="direction" value="<?php echo e(request('direction', 'desc')); ?>" />
                    </form>

                    <div class="text-sm text-gray-600">
                        <?php if($bookings->total() > 0): ?>
                            Showing <?php echo e($bookings->firstItem()); ?> to <?php echo e($bookings->lastItem()); ?> of <?php echo e($bookings->total()); ?> entries
                        <?php else: ?>
                            Showing 0 entries
                        <?php endif; ?>
                    </div>

                    <div><?php echo e($bookings->links()); ?></div>
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


<?php /**PATH C:\Users\Shahjahan\Desktop\the_venue\resources\views/reports/events-balance.blade.php ENDPATH**/ ?>