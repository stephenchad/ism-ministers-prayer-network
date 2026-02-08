<?php $__env->startSection('main'); ?>
<style>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 4rem 0;
    color: white;
}
.card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
}
.card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.15);
}
.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 12px;
    padding: 12px 24px;
    font-weight: 600;
}
.btn-outline {
    border: 2px solid #667eea;
    color: #667eea;
    background: transparent;
    border-radius: 12px;
    padding: 8px 16px;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-outline:hover {
    background: #667eea;
    color: white;
}
.badge-custom {
    background: rgba(79, 70, 229, 0.1);
    color: #4f46e5;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}
.card-img-top-container {
    height: 180px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
    overflow: hidden;
    position: relative;
}
.card-img-top {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>

<div class="hero-section">
    <div class="container">
        <div class="text-center">    
            <h1 class="display-4 fw-bold mb-2">My Prayer Groups</h1>
            <p class="lead mb-0 opacity-90">Welcome back, <?php echo e(Auth::user()->name); ?>! Here are the communities you are a part of.</p>
        </div>
    </div>
</div>

<div class="py-5" style="background: #f8f9fa;">
    <div class="container">
        <?php echo $__env->make('front.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h3 fw-bold text-dark mb-1">Your Groups</h2>
                <p class="text-muted mb-0">Manage your prayer communities or start a new one.</p>
            </div>
            <a href="<?php echo e(route('account.createGroup')); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Create Group
            </a>
        </div>

        <?php if($groups->isNotEmpty()): ?>
            <div class="row g-4">
                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card d-flex flex-column">
                        <div class="card-img-top-container">
                            <?php if($group->image): ?>
                                <img src="<?php echo e(asset('storage/'.$group->image)); ?>" alt="<?php echo e($group->title); ?>" class="card-img-top">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center h-100 text-white">
                                    <span class="display-3 fw-bold"><?php echo e(strtoupper(substr($group->title, 0, 2))); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body p-4 d-flex flex-column flex-grow-1">
                            <?php if($group->category): ?>
                            <span class="badge-custom align-self-start mb-2">
                                <i class="fas fa-tag me-1"></i>
                                <?php echo e($group->category->name); ?>

                            </span>
                            <?php endif; ?>
                            <h5 class="card-title fw-bold mb-2"><?php echo e(Str::limit($group->title, 35)); ?></h5>
                            <p class="card-text text-muted mb-4 flex-grow-1"><?php echo e(Str::limit($group->description ?? 'Join this prayer group to connect with fellow believers.', 80)); ?></p>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted small">Members</span>
                                    <span class="fw-bold small"><?php echo e($group->current_members); ?> / <?php echo e($group->max_members); ?></span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo e(($group->current_members / $group->max_members) * 100); ?>%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" aria-valuenow="<?php echo e($group->current_members); ?>" aria-valuemin="0" aria-valuemax="<?php echo e($group->max_members); ?>"></div>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2 flex-wrap mt-auto">
                                <a href="<?php echo e(route('account.group.show', $group->id)); ?>" class="btn-outline text-decoration-none flex-grow-1 text-center">
                                    <i class="fas fa-eye me-1"></i>View
                                </a>
                                <a href="<?php echo e(route('account.group.chat', $group->id)); ?>" class="btn-outline text-decoration-none flex-grow-1 text-center">
                                    <i class="fas fa-comments me-1"></i>Chat
                                </a>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manageMembers', $group)): ?>
                                <a href="<?php echo e(route('account.group.manageMembers', $group->id)); ?>" class="btn-outline text-decoration-none flex-grow-1 text-center" style="border-color: #17a2b8; color: #17a2b8;"><i class="fas fa-users-cog me-1"></i>Manage</a>
                                <?php endif; ?>
                                <button class="btn-outline flex-grow-1 text-center" data-bs-toggle="modal" data-bs-target="#meetingModal" 
                                        data-stream-url="<?php echo e($group->stream_url ?? 'https://d2zihajmogu5jn.cloudfront.net/bipbop-advanced/bipbop_16x9_variant.m3u8'); ?>">
                                    <i class="fas fa-video me-1"></i>Live
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <div class="d-flex justify-content-center mt-5">
                <?php echo e($groups->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-5 bg-white rounded-3 shadow-sm">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                    <i class="fas fa-users fa-2x text-primary"></i>
                </div>
                <h3 class="fw-bold mb-3">No Prayer Groups Yet</h3>
                <p class="text-muted mb-4">You have not joined or created any groups. <br>Start building your faith community today!</p>
                <a href="<?php echo e(route('account.createGroup')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create Your First Group
                </a>
            </div>    
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="meetingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Live Prayer Meeting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <video id="liveVideo" controls class="w-100" style="height: 400px; border-radius: 8px;">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/account/group/my-groups.blade.php ENDPATH**/ ?>