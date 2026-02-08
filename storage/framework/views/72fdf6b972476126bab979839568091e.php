<?php $__env->startSection('main'); ?>
<div style="padding: 100px 0; background: #f8f9fa;">
    <div class="container">
        <div class="text-center mb-5">
            <h1 style="font-size: 3rem; font-weight: 700; color: #333; margin-bottom: 1rem;">Prayer Coordinators</h1>
            <p style="color: #6c757d; font-size: 1.2rem;">Meet our dedicated prayer coordinators who are here to support you in your spiritual journey</p>
        </div>

        <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $coordinators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coordinator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div style="background: white; border-radius: 20px; padding: 40px 30px; text-align: center; box-shadow: 0 15px 35px rgba(0,0,0,0.1); height: 100%; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                    <?php if($coordinator->image): ?>
                        <img src="<?php echo e(asset($coordinator->image)); ?>" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin: 0 auto 25px; display: block;" alt="<?php echo e($coordinator->name); ?>">
                    <?php else: ?>
                        <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; color: white; font-size: 2.5rem; font-weight: 700;">
                            <?php echo e(strtoupper(substr($coordinator->name, 0, 2))); ?>

                        </div>
                    <?php endif; ?>
                    <h4 style="color: #333; margin-bottom: 15px; font-weight: 600;"><?php echo e($coordinator->name); ?></h4>
                    <p style="color: #667eea; font-weight: 600; margin-bottom: 15px;"><?php echo e($coordinator->title); ?></p>
                    <p style="color: #6c757d; margin-bottom: 25px; line-height: 1.6;"><?php echo e($coordinator->description); ?></p>
                    
                    <div style="background: #f8f9fa; padding: 20px; border-radius: 15px; margin-bottom: 20px;">
                        <div style="display: flex; align-items: center; margin-bottom: 10px;">
                            <i class="fas fa-phone" style="color: #667eea; margin-right: 10px; width: 20px;"></i>
                            <a href="tel:<?php echo e($coordinator->phone); ?>" style="color: #333; text-decoration: none;"><?php echo e($coordinator->phone); ?></a>
                        </div>
                        <div style="display: flex; align-items: center; margin-bottom: 10px;">
                            <i class="fas fa-envelope" style="color: #667eea; margin-right: 10px; width: 20px;"></i>
                            <a href="mailto:<?php echo e($coordinator->email); ?>" style="color: #333; text-decoration: none;"><?php echo e($coordinator->email); ?></a>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-clock" style="color: #667eea; margin-right: 10px; width: 20px;"></i>
                            <span style="color: #333;"><?php echo e($coordinator->availability); ?></span>
                        </div>
                    </div>
                    
                    <a href="mailto:<?php echo e($coordinator->email); ?>?subject=Prayer%20Support%20Request&body=Dear%20<?php echo e($coordinator->name); ?>,%0D%0A%0D%0AI%20would%20like%20to%20request%20prayer%20support%20for:%0D%0A%0D%0A[Please%20describe%20your%20prayer%20need%20here]%0D%0A%0D%0AThank%20you%20for%20your%20ministry.%0D%0A%0D%0ABlessings," style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 25px; border-radius: 25px; text-decoration: none; font-weight: 600; display: inline-block;">Contact <?php echo e($coordinator->name); ?></a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <h4 style="color: #6c757d;">No coordinators available at the moment</h4>
                    <p style="color: #adb5bd;">Please check back later or contact us directly</p>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="text-center mt-5">
            <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
                <h3 style="color: #333; margin-bottom: 20px; font-weight: 600;">Need Prayer Support?</h3>
                <p style="color: #6c757d; margin-bottom: 30px; line-height: 1.6;">Our coordinators are here to pray with you, provide spiritual guidance, and connect you with the right prayer groups. Don't hesitate to reach out!</p>
                <div class="row justify-content-center">
                    <div class="col-md-4 mb-3">
                        <a href="<?php echo e(route('prayers')); ?>" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; border-radius: 25px; text-decoration: none; font-weight: 600; display: block;">Submit Prayer Request</a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="<?php echo e(route('groups.index')); ?>" style="background: white; color: #667eea; padding: 15px 30px; border-radius: 25px; text-decoration: none; font-weight: 600; display: block; border: 2px solid #667eea;">Join Prayer Group</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/coordinators.blade.php ENDPATH**/ ?>