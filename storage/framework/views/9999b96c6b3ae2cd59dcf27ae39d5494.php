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
                Postponed Bookings
            </h2>
            <div class="flex space-x-2">
                <a href="<?php echo e(route('bookings.index')); ?>" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                    Back to All Bookings
                </a>
                <a href="<?php echo e(route('bookings.postponed.pdf', request()->query())); ?>" class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Print PDF
                </a>
                <a href="<?php echo e(route('bookings.create')); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    New Booking
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <!-- Filters Section -->
                <div class="p-6 border-b border-gray-200">
                    <form method="GET" action="<?php echo e(route('bookings.postponed')); ?>" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">From Date</label>
                                <input type="date" name="from_date" value="<?php echo e($fromDate); ?>" 
                                       class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">To Date</label>
                                <input type="date" name="to_date" value="<?php echo e($toDate); ?>" 
                                       class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700">
                                    Generate
                                </button>
                            </div>
                        </div>
                        
                        <!-- Search Box -->
                        <div class="flex gap-2">
                            <input type="hidden" name="from_date" value="<?php echo e($fromDate); ?>">
                            <input type="hidden" name="to_date" value="<?php echo e($toDate); ?>">
                            <input type="hidden" name="sort" value="<?php echo e(request('sort', 'event_start_at')); ?>">
                            <input type="hidden" name="direction" value="<?php echo e(request('direction', 'desc')); ?>">
                            <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                                   placeholder="Search by customer name or event type" 
                                   class="w-full md:w-96 rounded-md border-gray-300 shadow-sm py-2">
                            <button type="submit" class="px-4 py-2 bg-gray-100 border rounded-md hover:bg-gray-200">Search</button>
                            <a href="<?php echo e(route('bookings.postponed', ['from_date' => $fromDate, 'to_date' => $toDate])); ?>" 
                               class="px-4 py-2 border rounded-md hover:bg-gray-50">Reset</a>
                        </div>
                    </form>
                </div>

                <!-- Bookings Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-yellow-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sr#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="<?php echo e(route('bookings.postponed', array_merge(request()->query(), ['sort' => 'customer_name', 'direction' => request('sort')==='customer_name' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" 
                                       class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Customer Name
                                        <?php if(request('sort')==='customer_name'): ?>
                                            <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                        <?php else: ?>
                                            <span class="text-gray-300">↕</span>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="<?php echo e(route('bookings.postponed', array_merge(request()->query(), ['sort' => 'event_type', 'direction' => request('sort')==='event_type' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" 
                                       class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Event Type
                                        <?php if(request('sort')==='event_type'): ?>
                                            <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                        <?php else: ?>
                                            <span class="text-gray-300">↕</span>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="<?php echo e(route('bookings.postponed', array_merge(request()->query(), ['sort' => 'event_start_at', 'direction' => request('sort')==='event_start_at' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" 
                                       class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Original Date
                                        <?php if(request('sort')==='event_start_at'): ?>
                                            <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                        <?php else: ?>
                                            <span class="text-gray-300">↕</span>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo e($bookings->firstItem() + $index); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-yellow-600">
                                                        <?php echo e(substr($booking->customer_name, 0, 2)); ?>

                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900"><?php echo e($booking->customer_name); ?></div>
                                                <div class="text-sm text-gray-500"><?php echo e($booking->customer->phone ?? 'N/A'); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo e($booking->event_type); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo e($booking->event_start_at ? $booking->event_start_at->format('M d, Y') : 'N/A'); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo e(number_format($booking->invoice_net_amount, 2)); ?> PKR
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            <?php echo e($booking->event_status); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="<?php echo e(route('bookings.show', $booking)); ?>" 
                                               class="text-indigo-600 hover:text-indigo-900">View</a>
                                            <a href="<?php echo e(route('bookings.edit', $booking)); ?>" 
                                               class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                            <a href="<?php echo e(route('bookings.invoice', $booking)); ?>" 
                                               class="text-green-600 hover:text-green-900">Invoice</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        <div class="flex flex-col items-center justify-center py-8">
                                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p class="text-lg font-medium text-gray-900">No postponed bookings found</p>
                                            <p class="text-sm text-gray-500">All your bookings are currently active</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination & Per-page Controls -->
                <div class="px-6 py-4 border-t border-gray-200 mt-4 flex items-center justify-between gap-4">
                    <form method="GET" action="<?php echo e(route('bookings.postponed')); ?>" class="flex items-center gap-2 text-sm">
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
<?php /**PATH C:\Users\Shahjahan\Desktop\the_venue\resources\views/bookings/postponed.blade.php ENDPATH**/ ?>