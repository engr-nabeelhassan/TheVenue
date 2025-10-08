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
            <div class="flex items-center gap-3">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Payment List
                </h2>
                <a href="<?php echo e(route('dashboard')); ?>" class="text-gray-600 hover:text-gray-800 underline">Back to Dashboard</a>
            </div>
            <a href="<?php echo e(route('payments.create')); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                Collect Payment
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            <?php if(session('success')): ?>
                <div class="mb-4 p-4 rounded-lg bg-green-50 text-green-700 border border-green-200">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <!-- Error Message -->
            <?php if(session('error')): ?>
                <div class="mb-4 p-4 rounded-lg bg-red-50 text-red-700 border border-red-200">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <!-- Validation Errors -->
            <?php if($errors->any()): ?>
                <div class="mb-4 p-4 rounded-lg bg-red-50 text-red-700 border border-red-200">
                    <ul class="list-disc list-inside">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="bg-white shadow-sm sm:rounded-lg">

                <!-- Payment List Filters -->
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment List Filters</h3>
                    <form method="GET" action="<?php echo e(route('payments.index')); ?>" id="filterForm" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Search</label>
                                <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                                       placeholder="Customer name or contact" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">From Date</label>
                                <input type="date" name="from_date" value="<?php echo e(request('from_date')); ?>" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">To Date</label>
                                <input type="date" name="to_date" value="<?php echo e(request('to_date')); ?>" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                                <select name="payment_method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">All Methods</option>
                                    <option value="Debit" <?php echo e(request('payment_method') == 'Debit' ? 'selected' : ''); ?>>Debit</option>
                                    <option value="Credit" <?php echo e(request('payment_method') == 'Credit' ? 'selected' : ''); ?>>Credit</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Customer (for PDF)</label>
                                <select name="customer_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">All Customers</option>
                                    <?php $__currentLoopData = \App\Models\Customer::orderBy('full_name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($customer->id); ?>" <?php echo e(request('customer_id') == $customer->id ? 'selected' : ''); ?>>
                                            <?php echo e($customer->full_name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Apply Filters</button>
                            <a href="<?php echo e(route('payments.index')); ?>" class="px-4 py-2 border rounded-md hover:bg-gray-50">Reset</a>
                            <button type="submit" formaction="<?php echo e(route('payments.details')); ?>" class="ml-auto px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="<?php echo e(route('payments.index', array_merge(request()->query(), ['sort' => 'receipt_date', 'direction' => request('sort')==='receipt_date' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Receipt Date
                                        <?php if(request('sort')==='receipt_date'): ?>
                                            <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                        <?php else: ?>
                                            <span class="text-gray-300">↕</span>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="<?php echo e(route('payments.index', array_merge(request()->query(), ['sort' => 'customer_name', 'direction' => request('sort')==='customer_name' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Customer Name
                                        <?php if(request('sort')==='customer_name'): ?>
                                            <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                        <?php else: ?>
                                            <span class="text-gray-300">↕</span>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="<?php echo e(route('payments.index', array_merge(request()->query(), ['sort' => 'debit', 'direction' => request('sort')==='debit' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Debit
                                        <?php if(request('sort')==='debit'): ?>
                                            <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                        <?php else: ?>
                                            <span class="text-gray-300">↕</span>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="<?php echo e(route('payments.index', array_merge(request()->query(), ['sort' => 'credit', 'direction' => request('sort')==='credit' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Credit
                                        <?php if(request('sort')==='credit'): ?>
                                            <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                        <?php else: ?>
                                            <span class="text-gray-300">↕</span>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="<?php echo e(route('payments.index', array_merge(request()->query(), ['sort' => 'balance', 'direction' => request('sort')==='balance' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Balance
                                        <?php if(request('sort')==='balance'): ?>
                                            <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                        <?php else: ?>
                                            <span class="text-gray-300">↕</span>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo e(optional($payment->receipt_date)->format('M d, Y')); ?>

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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            <button onclick="showPaymentDetails(<?php echo e($payment->id); ?>)" class="px-3 py-1 text-sm rounded bg-indigo-600 text-white hover:bg-indigo-500">Details</button>
                                            <a href="<?php echo e(route('payments.edit', $payment)); ?>" class="px-3 py-1 text-sm rounded bg-amber-500 text-white hover:bg-amber-400">Edit</a>
                                            <a href="<?php echo e(route('payments.receipt.print', $payment)); ?>" target="_blank" class="px-3 py-1 text-sm rounded bg-green-600 text-white hover:bg-green-500">Print</a>
                                            <form action="<?php echo e(route('payments.destroy', $payment)); ?>" method="POST" onsubmit="return confirm('Delete this payment?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="px-3 py-1 text-sm rounded bg-red-600 text-white hover:bg-red-500">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
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
                                <td colspan="1"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Pagination & Per-page Controls (match Booking List style) -->
                <div class="px-6 py-4 border-t border-gray-200 mt-4 flex items-center justify-between gap-4">
                    <form method="GET" action="<?php echo e(route('payments.index')); ?>" class="flex items-center gap-2 text-sm">
                        <span class="text-gray-600">Show</span>
                        <select name="per_page" class="rounded-md border-gray-300" onchange="this.form.submit()">
                            <?php $__currentLoopData = [10,25,50,100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($n); ?>" <?php echo e((int)request('per_page', 10) === $n ? 'selected' : ''); ?>><?php echo e($n); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <span class="text-gray-600">entries</span>
                        <input type="hidden" name="search" value="<?php echo e(request('search')); ?>" />
                        <input type="hidden" name="from_date" value="<?php echo e(request('from_date')); ?>" />
                        <input type="hidden" name="to_date" value="<?php echo e(request('to_date')); ?>" />
                        <input type="hidden" name="payment_method" value="<?php echo e(request('payment_method')); ?>" />
                        <input type="hidden" name="sort" value="<?php echo e(request('sort', 'receipt_date')); ?>" />
                        <input type="hidden" name="direction" value="<?php echo e(request('direction', 'desc')); ?>" />
                    </form>

                    <div class="text-sm text-gray-600">
                        <?php if($payments->total() > 0): ?>
                            Showing <?php echo e($payments->firstItem()); ?> to <?php echo e($payments->lastItem()); ?> of <?php echo e($payments->total()); ?> entries
                        <?php else: ?>
                            Showing 0 entries
                        <?php endif; ?>
                    </div>

                    <div><?php echo e($payments->links()); ?></div>
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