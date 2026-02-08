<?php $__env->startSection('main'); ?>
<style>
.hero-section {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    padding: 4rem 0;
    color: white;
}
.resource-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
    overflow: hidden;
}
.resource-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.15);
}
.resource-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    margin-bottom: 1rem;
}
.btn-primary {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    border: none;
    border-radius: 12px;
    padding: 12px 24px;
    font-weight: 600;
}
/* Guide content styling */
.modal-body {
    font-size: 16px;
    line-height: 1.6;
    color: #333;
    padding: 20px;
}
.modal-body h1, .modal-body h2, .modal-body h3, .modal-body h4, .modal-body h5, .modal-body h6 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    font-weight: 600;
    line-height: 1.3;
    color: #1a202c;
}
.modal-body h1 { font-size: 2rem; }
.modal-body h2 { font-size: 1.75rem; }
.modal-body h3 { font-size: 1.5rem; }
.modal-body h4 { font-size: 1.25rem; }
.modal-body h5 { font-size: 1.125rem; }
.modal-body h6 { font-size: 1rem; }
.modal-body p {
    margin-bottom: 1rem;
}
.modal-body ul, .modal-body ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}
.modal-body li {
    margin-bottom: 0.5rem;
}
.modal-body blockquote {
    border-left: 4px solid #7c3aed;
    padding-left: 1rem;
    margin-left: 0;
    margin-right: 0;
    font-style: italic;
    color: #4a5568;
}
.modal-body a {
    color: #4f46e5;
    text-decoration: underline;
}
.modal-body img {
    max-width: 100%;
    height: auto;
    margin: 1rem 0;
    border-radius: 8px;
}
.modal-body hr {
    margin: 2rem 0;
    border-color: #e2e8f0;
}
</style>

<div class="hero-section">
    <div class="container">
        <div class="text-center">
            <h1 class="display-4 fw-bold mb-3">Prayer Resources</h1>
            <p class="lead mb-0">Discover guides, videos, and tools to enrich your prayer life</p>
        </div>
    </div>
</div>

<div class="py-5 bg-light" style="min-height: 60vh;">
    <div class="container">
        <!-- Prayer Guides Section -->
        <?php if($guides->isNotEmpty()): ?>
        <div class="mb-5">
            <h2 class="h3 fw-bold text-center mb-4">Prayer Guides</h2>
            <div class="row g-4">
                <?php $__currentLoopData = $guides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $guide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6">
                    <div class="resource-card">
                        <div class="p-4">
                            <div class="resource-icon">
                                <i class="fas <?php echo e($guide->icon ?: 'fa-book'); ?>"></i>
                            </div>
                            <h5 class="fw-bold mb-3"><?php echo e($guide->title); ?></h5>
                            <p class="text-muted mb-3"><?php echo e($guide->description); ?></p>
                            <div class="mb-3">
                                <small class="text-primary fw-semibold">📖 Reading <?php if($guide->reading_time): ?> • <?php echo e($guide->reading_time); ?> <?php endif; ?></small>
                            </div>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#guideModal<?php echo e($guide->id); ?>">Read Guide</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Video Resources Section -->
        <?php if($videos->isNotEmpty()): ?>
        <div class="mb-5">
            <h2 class="h3 fw-bold text-center mb-4">Video Resources</h2>
            <div class="row g-4">
                <?php $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-6">
                    <div class="resource-card">
                        <div class="p-4">
                            <div class="resource-icon">
                                <i class="fas fa-play"></i>
                            </div>
                            <h5 class="fw-bold mb-3"><?php echo e($video->title); ?></h5>
                            <p class="text-muted mb-3"><?php echo e($video->description); ?></p>
                            <div class="mb-3">
                                <small class="text-primary fw-semibold">🎥 Video <?php if($video->duration): ?> • <?php echo e($video->duration); ?> <?php endif; ?></small>
                            </div>
                            <?php if($video->video_type === 'file'): ?>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#videoModal<?php echo e($video->id); ?>">
                                    <i class="fas fa-play me-1"></i>Watch Video
                                </button>
                            <?php else: ?>
                                <a href="<?php echo e($video->video_url); ?>" target="_blank" class="btn btn-primary btn-sm">
                                    <i class="fas fa-play me-1"></i>Watch Video
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Downloadable Resources Section -->
        <?php if($resources->isNotEmpty()): ?>
        <div class="mb-5">
            <h2 class="h3 fw-bold text-center mb-4">Downloadable Resources</h2>
            <div class="row g-4">
                <?php $__currentLoopData = $resources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6">
                    <div class="resource-card">
                        <div class="p-4">
                            <div class="resource-icon">
                                <i class="fas fa-file-<?php echo e($resource->file_type == 'pdf' ? 'pdf' : 'alt'); ?>"></i>
                            </div>
                            <h5 class="fw-bold mb-3"><?php echo e($resource->title); ?></h5>
                            <p class="text-muted mb-3"><?php echo e($resource->description); ?></p>
                            <div class="mb-3">
                                <small class="text-primary fw-semibold">📄 <?php echo e(strtoupper($resource->file_type)); ?> • <?php echo e($resource->file_size); ?></small>
                            </div>
                            <a href="<?php echo e(route('prayer.download', $resource->id)); ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-download me-1"></i>Download <?php echo e(strtoupper($resource->file_type)); ?>

                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- No Resources Message -->
        <?php if($guides->isEmpty() && $videos->isEmpty() && $resources->isEmpty()): ?>
        <div class="text-center py-5">
            <div class="resource-icon mx-auto mb-4">
                <i class="fas fa-book-open"></i>
            </div>
            <h3 class="h4 fw-bold mb-3">Prayer Resources Coming Soon</h3>
            <p class="text-muted mb-4">We're preparing inspiring prayer guides, videos, and downloadable resources to enrich your prayer life. Check back soon!</p>
            <a href="<?php echo e(route('prayers')); ?>" class="btn btn-primary">
                <i class="fas fa-pray me-2"></i>Explore Prayer Requests
            </a>
        </div>
        <?php else: ?>
        <!-- Back to Prayer Requests -->
        <div class="text-center">
            <a href="<?php echo e(route('prayers')); ?>" class="btn btn-primary">
                <i class="fas fa-arrow-left me-2"></i>Back to Prayer Requests
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Guide Modals -->
<?php if($guides->isNotEmpty()): ?>
    <?php $__currentLoopData = $guides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $guide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="guideModal<?php echo e($guide->id); ?>" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e($guide->title); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php echo $guide->guide_content; ?>

                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<!-- Video Modals for Uploaded Files -->
<?php if($videos->isNotEmpty()): ?>
    <?php $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($video->video_type === 'file'): ?>
        <div class="modal fade" id="videoModal<?php echo e($video->id); ?>" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo e($video->title); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <video controls class="w-100" style="max-height: 400px;">
                            <source src="<?php echo e(asset($video->video_file)); ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/prayer-resources.blade.php ENDPATH**/ ?>