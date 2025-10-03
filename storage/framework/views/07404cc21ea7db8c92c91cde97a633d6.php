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
                Payment List
            </h2>
            <a href="<?php echo e(route('payments.create')); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                Collect Payment
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <!-- Search Section -->
                <div class="p-6 border-b border-gray-200">
                    <form method="GET" action="<?php echo e(route('payments.index')); ?>" class="space-y-4">
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">Search</label>
                                <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                                       class="mt-1 block w-full rounded-md border-gray-300" 
                                       placeholder="Search by customer name or contact">
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                                    Search
                                </button>
                                <a href="<?php echo e(route('payments.index')); ?>" class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                                    Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Payment Details Form -->
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Details Report</h3>
                    <form method="GET" action="<?php echo e(route('payments.details')); ?>" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">From Date</label>
                                <input type="date" name="from_date" value="<?php echo e(request('from_date')); ?>" 
                                       class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">To Date</label>
                                <input type="date" name="to_date" value="<?php echo e(request('to_date')); ?>" 
                                       class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Customer (Optional)</label>
                                <select name="customer_id" class="mt-1 block w-full rounded-md border-gray-300">
                                    <option value="">All Customers</option>
                                    <?php $__currentLoopData = \App\Models\Customer::orderBy('full_name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($customer->id); ?>" <?php echo e(request('customer_id') == $customer->id ? 'selected' : ''); ?>>
                                            <?php echo e($customer->full_name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                Generate PDF Report
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Payments Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sr#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Debit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Credit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo e($payments->firstItem() + $index); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo e($payment->customer_name); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo e($payment->contact); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo e($payment->payment_method === 'Debit' ? number_format($payment->add_amount, 2) : '0.00'); ?> PKR
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo e($payment->payment_method === 'Credit' ? number_format($payment->add_amount, 2) : '0.00'); ?> PKR
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo e(number_format($payment->remaining_balance, 2)); ?> PKR
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo e($payment->remarks ?? 'N/A'); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button onclick="showPaymentDetails(<?php echo e($payment->id); ?>)" 
                                                class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            Details
                                        </button>
                                        <a href="<?php echo e(route('payments.receipt', $payment)); ?>" 
                                           class="text-green-600 hover:text-green-900" target="_blank">
                                            Print Receipt
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        No payments found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr class="font-bold">
                                <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">TOTAL</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e(number_format($totalDebit, 2)); ?> PKR</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e(number_format($totalCredit, 2)); ?> PKR</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e(number_format($totalBalance, 2)); ?> PKR</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <?php echo e($payments->links()); ?>

                </div>
            </div>
        </div>
    </div>

    <!-- Payment Details Modal -->
    <div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Payment Details</h3>
                    <button onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="paymentDetails"></div>
            </div>
        </div>
    </div>

    <script>
        function showPaymentDetails(paymentId) {
            // Show loading state
            document.getElementById('paymentDetails').innerHTML = '<div class="text-center"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div><p class="mt-2">Loading...</p></div>';
            document.getElementById('paymentModal').classList.remove('hidden');
            
            // Fetch payment details via AJAX
            fetch(`/payments/${paymentId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('paymentDetails').innerHTML = `
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Customer Name</label>
                                    <p class="text-sm text-gray-900">${data.customer_name}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Contact</label>
                                    <p class="text-sm text-gray-900">${data.contact}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Receipt Date</label>
                                    <p class="text-sm text-gray-900">${data.receipt_date}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                                    <p class="text-sm text-gray-900">${data.payment_method}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Payment Status</label>
                                    <p class="text-sm text-gray-900">${data.payment_status}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Add Amount</label>
                                    <p class="text-sm text-gray-900">${data.add_amount} PKR</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Previous Balance</label>
                                    <p class="text-sm text-gray-900">${data.previous_balance} PKR</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Remaining Balance</label>
                                    <p class="text-sm text-gray-900">${data.remaining_balance} PKR</p>
                                </div>
                            </div>
                            ${data.remarks ? `
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Remarks</label>
                                <p class="text-sm text-gray-900">${data.remarks}</p>
                            </div>
                            ` : ''}
                            ${data.booking ? `
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Related Booking</label>
                                <p class="text-sm text-gray-900">Booking #${data.booking.id} - ${data.booking.invoice_date} (${data.booking.invoice_net_amount} PKR)</p>
                            </div>
                            ` : ''}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Created At</label>
                                <p class="text-sm text-gray-900">${data.created_at}</p>
                            </div>
                        </div>
                    `;
                })
                .catch(error => {
                    document.getElementById('paymentDetails').innerHTML = '<p class="text-red-600">Error loading payment details.</p>';
                    console.error('Error:', error);
                });
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\Shahjahan\Desktop\the_venue\resources\views/payments/index.blade.php ENDPATH**/ ?>