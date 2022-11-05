<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Čištění interiéru Kondrac</title>

    <!--====== Favicon Icon ======-->
    <link
        rel="shortcut icon"
        href="<?php echo e(asset('images/logo/logo-2.png')); ?>"
    />

    <!-- ===== All CSS files ===== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link rel="stylesheet" href="<?php echo e(asset('css/ud-styles.css')); ?>" />

    <style>
        * {
            scroll-behavior: smooth;
        }
    </style>

</head>

    <?php echo $__env->make('sections.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\Users\Admin\Desktop\GitHub\interior-cleaning-laravel\resources\views/layout.blade.php ENDPATH**/ ?>