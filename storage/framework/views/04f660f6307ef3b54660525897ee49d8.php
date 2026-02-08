

<?php $__env->startSection('main'); ?>
<style>
.modern-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 120px 0 80px;
    color: white;
    text-align: center;
}
.modern-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    padding: 40px;
    margin-bottom: 30px;
    transition: transform 0.3s ease;
}
.modern-card:hover {
    transform: translateY(-5px);
}
.prayer-point-item {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 20px;
    border-left: 4px solid #667eea;
}
.form-floating {
    margin-bottom: 20px;
}
.form-floating input, .form-floating textarea {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 20px 15px;
}
.form-floating input:focus, .form-floating textarea:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}
.btn-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 50px;
    padding: 15px 40px;
    color: white;
    font-weight: 600;
}
</style>

<div class="modern-hero">
    <div class="container">
        <h1 style="font-size: 3.5rem; font-weight: 700; margin-bottom: 1rem;">Prayer Points</h1>
        <p style="font-size: 1.2rem; opacity: 0.9;">Inspiring prayer points shared by our community</p>
    </div>
</div>

<div style="padding: 80px 0; background: #f8f9fa;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="modern-card">
                    <h3 class="text-center mb-4" style="color: #667eea;">Shared Prayer Points</h3>
                    <?php $__empty_1 = true; $__currentLoopData = $prayerPoints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="prayer-point-item">
                            <?php
                                $displayTitle = $point->title;
                                $displayContent = $point->content;
                                $originalLang = strtoupper($point->language ?? 'EN');
                                if ($point->language === 'es') {
                                    $displayTitle = $point->title_es ?: $point->title;
                                    $displayContent = $point->content_es ?: $point->content;
                                } elseif ($point->language === 'fr') {
                                    $displayTitle = $point->title_fr ?: $point->title;
                                    $displayContent = $point->content_fr ?: $point->content;
                                } elseif ($point->language === 'zh') {
                                    $displayTitle = $point->title_zh ?: $point->title;
                                    $displayContent = $point->content_zh ?: $point->content;
                                } elseif ($point->language === 'ar') {
                                    $displayTitle = $point->title_ar ?: $point->title;
                                    $displayContent = $point->content_ar ?: $point->content;
                                }
                                $languages = [$originalLang];
                                if($point->title_es || $point->content_es) $languages[] = 'ES';
                                if($point->title_fr || $point->content_fr) $languages[] = 'FR';
                                if($point->title_zh || $point->content_zh) $languages[] = 'ZH';
                                if($point->title_ar || $point->content_ar) $languages[] = 'AR';
                                $languages = array_unique($languages);
                            ?>
                            <h5><a href="<?php echo e(route('prayer-points.show', $point->id)); ?>" style="color: inherit; text-decoration: none;"><?php echo e($displayTitle); ?></a></h5>
                            <p><?php echo e(Str::limit($displayContent, 200)); ?></p>
                            <small class="text-muted">
                                <?php echo e($point->created_at->diffForHumans()); ?>

                                <?php if($point->user): ?> • by <?php echo e($point->user->name); ?> <?php endif; ?>
                            </small>
                            <?php if(!empty($languages)): ?>
                                <small class="text-info">Available in: <?php echo e(implode(', ', $languages)); ?></small>
                            <?php endif; ?>
                            <a href="<?php echo e(route('prayer-points.show', $point->id)); ?>" class="btn btn-sm btn-outline-primary mt-2">Read More</a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-4">
                            <p class="text-muted">No prayer points yet. Be the first to share one!</p>
                        </div>
                    <?php endif; ?>
                    <?php echo e($prayerPoints->links()); ?>

                </div>
            </div>
            <div class="col-lg-4">
                <div class="modern-card">
                    <h4 class="text-center mb-4" style="color: #667eea;">Share a Prayer Point</h4>
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    <form action="<?php echo e(route('prayer-points.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-floating">
                            <select name="language" class="form-control" id="language" required>
                                <option value="">Select Language</option>
                                <option value="en">English</option>
                                <option value="es">Spanish</option>
                                <option value="fr">French</option>
                                <option value="zh">Chinese</option>
                                <option value="ar">Arabic</option>
                            </select>
                            <label for="language">Language</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" name="title" class="form-control" id="title" placeholder="Prayer Point Title" required>
                            <label for="title">Title</label>
                        </div>
                        <div class="form-floating">
                            <textarea name="content" class="form-control" id="content" style="height: 150px" placeholder="Share your prayer point..." required></textarea>
                            <label for="content">Prayer Point</label>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn-modern">Share Prayer Point</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/prayer-points.blade.php ENDPATH**/ ?>