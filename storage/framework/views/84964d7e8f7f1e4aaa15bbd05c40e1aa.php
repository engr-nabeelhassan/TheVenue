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
                    Customers List
                </h2>
                <a href="<?php echo e(route('dashboard')); ?>" class="text-gray-600 hover:text-gray-800 underline">Back to Dashboard</a>
            </div>
            <a href="<?php echo e(route('customers.create')); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Add New Customer</a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="p-6 text-gray-900">

                    <!-- Customer List Filters -->
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer List Filters</h3>
                        <form method="GET" action="<?php echo e(route('customers.index')); ?>" class="space-y-4">
                            <div class="flex gap-2">
                                <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Search by customer name" class="flex-1 rounded-md border-gray-300 shadow-sm" />
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Search</button>
                                <a href="<?php echo e(route('customers.index')); ?>" class="px-4 py-2 border rounded-md hover:bg-gray-50">Reset</a>
                            </div>
                        </form>
                    </div>

                    <?php if(session('success')): ?>
                        <div class="mb-4 p-4 rounded-lg bg-green-50 text-green-700 border border-green-200"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="mb-4 p-4 rounded-lg bg-red-50 text-red-700 border border-red-200"><?php echo e(session('error')); ?></div>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                        <div class="mb-4 p-4 rounded-lg bg-red-50 text-red-700 border border-red-200">
                            <ul class="list-disc list-inside">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="<?php echo e(route('customers.index', array_merge(request()->query(), ['sort' => 'id', 'direction' => request('sort')==='id' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            ID
                                            <?php if(request('sort')==='id'): ?>
                                                <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                            <?php else: ?>
                                                <span class="text-gray-300">↕</span>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="<?php echo e(route('customers.index', array_merge(request()->query(), ['sort' => 'full_name', 'direction' => request('sort')==='full_name' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            Full Name
                                            <?php if(request('sort')==='full_name'): ?>
                                                <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                            <?php else: ?>
                                                <span class="text-gray-300">↕</span>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="<?php echo e(route('customers.index', array_merge(request()->query(), ['sort' => 'cnic', 'direction' => request('sort')==='cnic' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            CNIC
                                            <?php if(request('sort')==='cnic'): ?>
                                                <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                            <?php else: ?>
                                                <span class="text-gray-300">↕</span>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="<?php echo e(route('customers.index', array_merge(request()->query(), ['sort' => 'phone', 'direction' => request('sort')==='phone' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            Phone
                                            <?php if(request('sort')==='phone'): ?>
                                                <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                            <?php else: ?>
                                                <span class="text-gray-300">↕</span>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="<?php echo e(route('customers.index', array_merge(request()->query(), ['sort' => 'address', 'direction' => request('sort')==='address' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            Address
                                            <?php if(request('sort')==='address'): ?>
                                                <span class="text-gray-400"><?php echo e(request('direction')==='asc' ? '▲' : '▼'); ?></span>
                                            <?php else: ?>
                                                <span class="text-gray-300">↕</span>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="<?php echo e(route('customers.index', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => request('sort')==='created_at' && request('direction')==='asc' ? 'desc' : 'asc']))); ?>" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            Created
                                            <?php if(request('sort')==='created_at'): ?>
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
                                <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="px-4 py-2"><?php echo e($customer->id); ?></td>
                                        <td class="px-4 py-2"><?php echo e($customer->full_name); ?></td>
                                        <td class="px-4 py-2"><?php echo e($customer->cnic); ?></td>
                                        <td class="px-4 py-2"><?php echo e($customer->phone); ?></td>
                                        <td class="px-4 py-2"><?php echo e($customer->address ?: '-'); ?></td>
                                        <td class="px-4 py-2 text-sm text-gray-500"><?php echo e($customer->created_at->format('Y-m-d')); ?></td>
                                        <td class="px-4 py-2">
                                            <div class="flex items-center gap-2">
                                                <a href="<?php echo e(route('customers.edit', $customer)); ?>" class="px-3 py-1 text-sm rounded bg-amber-500 text-white hover:bg-amber-400">Edit</a>
                                                <form method="POST" action="<?php echo e(route('customers.destroy', $customer)); ?>" onsubmit="return confirm('Delete this customer?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="px-3 py-1 text-sm rounded bg-red-600 text-white hover:bg-red-500">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">No customers found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex items-center justify-between gap-4">
                        <form method="GET" action="<?php echo e(route('customers.index')); ?>" class="flex items-center gap-2 text-sm">
                            <span class="text-gray-600">Show</span>
                            <select name="per_page" class="rounded-md border-gray-300" onchange="this.form.submit()">
                                <?php $__currentLoopData = [10,25,50,100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($n); ?>" <?php echo e((int)request('per_page', 10) === $n ? 'selected' : ''); ?>><?php echo e($n); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="text-gray-600">entries</span>
                            <input type="hidden" name="q" value="<?php echo e(request('q')); ?>" />
                            <input type="hidden" name="sort" value="<?php echo e(request('sort', 'created_at')); ?>" />
                            <input type="hidden" name="direction" value="<?php echo e(request('direction', 'desc')); ?>" />
                        </form>

                        <div class="text-sm text-gray-600">
                            <?php if($customers->total() > 0): ?>
                                Showing <?php echo e($customers->firstItem()); ?> to <?php echo e($customers->lastItem()); ?> of <?php echo e($customers->total()); ?> entries
                            <?php else: ?>
                                Showing 0 entries
                            <?php endif; ?>
                        </div>

                        <div><?php echo e($customers->links()); ?></div>
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
<?php endif; ?>


<?php /**PATH C:\Users\Shahjahan\Desktop\the_venue\resources\views/customers/index.blade.php ENDPATH**/ ?>