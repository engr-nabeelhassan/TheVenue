<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['disabled' => false, 'toggle' => true, 'bind' => null]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['disabled' => false, 'toggle' => true, 'bind' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $isPassword = $attributes->get('type') === 'password';
?>

<?php if($isPassword): ?>
    <?php
        $bindVar = $bind ? trim($bind) : 'show';
        $hasExternal = $bind !== null;
    ?>
    <div <?php if(!$hasExternal): ?> x-data="{ show: false }" <?php endif; ?> class="relative">
        <input x-bind:type="<?php echo e($bindVar); ?> ? 'text' : 'password'"
               <?php if($disabled): echo 'disabled'; endif; ?>
               <?php echo e($attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm pr-10'])->except('type')); ?>>

        <?php if($toggle): ?>
        <button type="button"
                class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none"
                x-on:click="<?php echo e($bindVar); ?> = !<?php echo e($bindVar); ?>"
                aria-label="Toggle password visibility">
            <svg x-show="!(<?php echo e($bindVar); ?>)" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
            <svg x-show="<?php echo e($bindVar); ?>" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a21.86 21.86 0 0 1-4.87 6.82M1 1l22 22"/>
            </svg>
        </button>
        <?php endif; ?>
    </div>
<?php else: ?>
    <input <?php if($disabled): echo 'disabled'; endif; ?> <?php echo e($attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'])); ?>>
<?php endif; ?>
<?php /**PATH C:\Users\Shahjahan\Desktop\the_venue\resources\views/components/text-input.blade.php ENDPATH**/ ?>