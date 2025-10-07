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
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold">Add New Customer</h2>
                        <a href="<?php echo e(route('dashboard')); ?>" class="text-gray-600 hover:text-gray-800 underline">Back to Dashboard</a>
                    </div>

                    <?php if($errors->any()): ?>
                        <div class="mb-4 p-4 rounded bg-red-50 text-red-700">
                            <ul class="list-disc pl-6">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('customers.store')); ?>" class="space-y-4">
                        <?php echo csrf_field(); ?>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">ID</label>
                            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="Auto" disabled>
                            <p class="text-xs text-gray-500 mt-1">ID auto-generate hoga.</p>
                        </div>

                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input id="full_name" name="full_name" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="<?php echo e(old('full_name')); ?>" />
                        </div>

                        <div>
                            <label for="cnic" class="block text-sm font-medium text-gray-700">CNIC</label>
                            <input id="cnic" name="cnic" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="<?php echo e(old('cnic')); ?>" />
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Contact</label>
                            <input id="phone" name="phone" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="<?php echo e(old('phone')); ?>" />
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea id="address" name="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"><?php echo e(old('address')); ?></textarea>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-500">
                                Submit
                            </button>
                            <a href="<?php echo e(route('customers.index')); ?>" class="ml-3 text-gray-600 hover:text-gray-800">Cancel</a>
                        </div>
                    </form>
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


<?php /**PATH C:\Users\Shahjahan\Desktop\the_venue\resources\views/customers/create.blade.php ENDPATH**/ ?>