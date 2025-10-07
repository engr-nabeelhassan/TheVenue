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
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <h2 class="text-xl font-semibold">Booking List</h2>
                            <a href="<?php echo e(route('dashboard')); ?>" class="text-gray-600 hover:text-gray-800 underline">Back to Dashboard</a>
                        </div>
                        <div class="flex gap-2">
                            <a href="<?php echo e(route('bookings.calendar')); ?>" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-500">Calendar View</a>
                            <a href="<?php echo e(route('bookings.create')); ?>" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500">New Booking</a>
                        </div>
                    </div>

                    <form method="GET" action="<?php echo e(route('bookings.index')); ?>" class="mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-2 mb-2">
                            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search by customer name, invoice date, or event type" class="rounded-md border-gray-300 shadow-sm" />
                            <select name="event_status" class="rounded-md border-gray-300 shadow-sm">
                                <option value="">All Status</option>
                                <option value="In Progress" <?php echo e(request('event_status') == 'In Progress' ? 'selected' : ''); ?>>In Progress</option>
                                <option value="Completed" <?php echo e(request('event_status') == 'Completed' ? 'selected' : ''); ?>>Completed</option>
                                <option value="Cancelled" <?php echo e(request('event_status') == 'Cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                                <option value="Postponed" <?php echo e(request('event_status') == 'Postponed' ? 'selected' : ''); ?>>Postponed</option>
                            </select>
                            <input type="date" name="invoice_date_from" value="<?php echo e(request('invoice_date_from')); ?>" placeholder="From Date" class="rounded-md border-gray-300 shadow-sm" />
                            <input type="date" name="invoice_date_to" value="<?php echo e(request('invoice_date_to')); ?>" placeholder="To Date" class="rounded-md border-gray-300 shadow-sm" />
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-gray-100 border rounded-md hover:bg-gray-200">Search</button>
                            <a href="<?php echo e(route('bookings.index')); ?>" class="px-4 py-2 border rounded-md hover:bg-gray-50">Reset</a>
                        </div>
                    </form>

                    <?php if(session('status')): ?>
                        <div class="mb-4 p-3 rounded bg-green-50 text-green-700"><?php echo e(session('status')); ?></div>
                    <?php endif; ?>

                    <?php if(session('print_invoice')): ?>
                        <script>
                            window.open('<?php echo e(route('bookings.invoice', session('print_invoice'))); ?>', '_blank');
                        </script>
                    <?php endif; ?>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="<?php echo e(route('bookings.index', array_merge(request()->query(), ['sort' => 'invoice_date', 'direction' => request('sort')==='invoice_date' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            Invoice Date
                                            <?php if(request('sort')==='invoice_date'): ?>
                                                <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                            <?php else: ?>
                                                <span class="text-gray-300">↕</span>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="<?php echo e(route('bookings.index', array_merge(request()->query(), ['sort' => 'customer_name', 'direction' => request('sort')==='customer_name' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            Customer Name
                                            <?php if(request('sort')==='customer_name'): ?>
                                                <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                            <?php else: ?>
                                                <span class="text-gray-300">↕</span>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="<?php echo e(route('bookings.index', array_merge(request()->query(), ['sort' => 'event_type', 'direction' => request('sort')==='event_type' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            Event Type
                                            <?php if(request('sort')==='event_type'): ?>
                                                <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                            <?php else: ?>
                                                <span class="text-gray-300">↕</span>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="<?php echo e(route('bookings.index', array_merge(request()->query(), ['sort' => 'event_start_at', 'direction' => request('sort')==='event_start_at' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            Event Start
                                            <?php if(request('sort')==='event_start_at'): ?>
                                                <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                            <?php else: ?>
                                                <span class="text-gray-300">↕</span>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="<?php echo e(route('bookings.index', array_merge(request()->query(), ['sort' => 'event_end_at', 'direction' => request('sort')==='event_end_at' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            Event End
                                            <?php if(request('sort')==='event_end_at'): ?>
                                                <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                            <?php else: ?>
                                                <span class="text-gray-300">↕</span>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="<?php echo e(route('bookings.index', array_merge(request()->query(), ['sort' => 'event_status', 'direction' => request('sort')==='event_status' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            Event Status
                                            <?php if(request('sort')==='event_status'): ?>
                                                <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                            <?php else: ?>
                                                <span class="text-gray-300">↕</span>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="px-4 py-2"><?php echo e($booking->invoice_date->format('d/m/Y')); ?></td>
                                        <td class="px-4 py-2"><?php echo e($booking->customer_name); ?></td>
                                        <td class="px-4 py-2"><?php echo e($booking->event_type); ?></td>
                                        <td class="px-4 py-2"><?php echo e($booking->event_start_at->format('d/m/Y H:i')); ?></td>
                                        <td class="px-4 py-2"><?php echo e($booking->event_end_at->format('d/m/Y H:i')); ?></td>
                                        <td class="px-4 py-2">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                <?php if($booking->event_status == 'In Progress'): ?> bg-yellow-100 text-yellow-800
                                                <?php elseif($booking->event_status == 'Completed'): ?> bg-green-100 text-green-800
                                                <?php elseif($booking->event_status == 'Cancelled'): ?> bg-red-100 text-red-800
                                                <?php elseif($booking->event_status == 'Postponed'): ?> bg-blue-100 text-blue-800
                                                <?php endif; ?>">
                                                <?php echo e($booking->event_status); ?>

                                            </span>
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="flex items-center gap-2">
                                                <a href="<?php echo e(route('bookings.show', $booking)); ?>" class="px-3 py-1 text-sm rounded bg-indigo-600 text-white hover:bg-indigo-500">View</a>
                                                <a href="<?php echo e(route('bookings.edit', $booking)); ?>" class="px-3 py-1 text-sm rounded bg-amber-500 text-white hover:bg-amber-400">Edit</a>
                                                <form method="POST" action="<?php echo e(route('bookings.destroy', $booking)); ?>" onsubmit="return confirm('Delete this booking?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="px-3 py-1 text-sm rounded bg-red-600 text-white hover:bg-red-500">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">No bookings found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex items-center justify-between gap-4">
                        <form method="GET" action="<?php echo e(route('bookings.index')); ?>" class="flex items-center gap-2 text-sm">
                            <span class="text-gray-600">Show</span>
                            <select name="per_page" class="rounded-md border-gray-300" onchange="this.form.submit()">
                                <?php $__currentLoopData = [10,25,50,100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($n); ?>" <?php echo e((int)request('per_page', 10) === $n ? 'selected' : ''); ?>><?php echo e($n); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="text-gray-600">entries</span>
                            <input type="hidden" name="search" value="<?php echo e(request('search')); ?>" />
                            <input type="hidden" name="event_status" value="<?php echo e(request('event_status')); ?>" />
                            <input type="hidden" name="invoice_date_from" value="<?php echo e(request('invoice_date_from')); ?>" />
                            <input type="hidden" name="invoice_date_to" value="<?php echo e(request('invoice_date_to')); ?>" />
                            <input type="hidden" name="sort" value="<?php echo e(request('sort', 'invoice_date')); ?>" />
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
<?php endif; ?><?php /**PATH C:\Users\Shahjahan\Desktop\the_venue\resources\views/bookings/index.blade.php ENDPATH**/ ?>