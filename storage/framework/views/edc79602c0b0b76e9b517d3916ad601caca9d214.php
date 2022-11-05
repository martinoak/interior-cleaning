<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="utf-8">
    <title><?php echo e($details['title']); ?></title>
</head>

<body>
<h1><?php echo e($details['title']); ?></h1>
<p>Jmeno: <?php echo e($details['name']); ?></p>
<p>Email: <?php echo e($details['email']); ?></p>
<p>Telefon: <?php echo e($details['phone']); ?></p>
<hr>
<p><?php echo e($details['message']); ?></p>

<img src="<?php echo e(asset('images/logo/logo-2.png')); ?>" alt="Čistění interiéru Kondrac">
<?php /**PATH C:\Users\Admin\Desktop\GitHub\interior-laravel-tailwind\resources\views/emails/content.blade.php ENDPATH**/ ?>