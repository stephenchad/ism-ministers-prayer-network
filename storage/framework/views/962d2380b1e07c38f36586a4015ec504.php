<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

    <head>
        <!--================= Meta tag =================-->
        <meta charset="utf-8">
        <title><?php echo $__env->yieldContent('title', 'Authentication'); ?> | ISM MINISTERS PRAYER NETWORK</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('assets/images/fav.png')); ?>">
        
        <!--================= Bootstrap V5 css =================-->
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>">
        <!--================= Elegant icon css  =================-->
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/fonts/elegant-icon.css')); ?>">
        <!--================= style css =================-->
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('style.css')); ?>">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

        <?php echo $__env->yieldContent('customCSS'); ?>
    </head>

    <body style="margin: 0; padding: 0;">
        <main style="min-height: 100vh;">
            <?php echo $__env->yieldContent('main'); ?>
        </main>

        <!--================= Jquery latest version =================-->
        <script src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>
        
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        
        <?php echo $__env->yieldContent('customJS'); ?>
    </body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/layouts/auth.blade.php ENDPATH**/ ?>