<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-indigo-50 via-white to-purple-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center p-6">
            <div class="text-center">
                <a href="/" class="inline-flex items-center gap-2">
                    <span class="text-3xl font-extrabold tracking-tight"><span class="text-indigo-600">THE </span><span class="text-gray-900">VENUE</span></span>
                </a>
                <p class="text-sm text-gray-500 mt-1">Elegant events & banquet management</p>
            </div>

            <div class="w-full sm:max-w-md mt-8">
                <div class="relative">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-indigo-200 to-purple-200 blur opacity-60"></div>
                    <div class="relative rounded-2xl bg-white/90 backdrop-blur shadow-xl ring-1 ring-gray-100 p-6 sm:p-7">
                        <?php echo e($slot); ?>

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php /**PATH C:\Users\Shahjahan\Desktop\the_venue\resources\views/layouts/guest.blade.php ENDPATH**/ ?>