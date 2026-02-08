<?php $__env->startSection('main'); ?>
<style>
.modern-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 80px 0 60px;
    color: white;
    text-align: center;
}
.management-container {
    background: white;
    border-radius: 25px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    padding: 40px;
    margin-top: -50px;
    position: relative;
    z-index: 10;
}
.member-row {
    display: flex;
    align-items: center;
    padding: 15px;
    border-bottom: 1px solid #e9ecef;
    transition: background-color 0.2s ease;
}
.member-row:last-child {
    border-bottom: none;
}
.member-row:hover {
    background-color: #f8f9fa;
}
.member-info {
    flex-grow: 1;
    display: flex;
    align-items: center;
}
.member-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 15px;
    object-fit: cover;
}
.member-name {
    font-weight: 600;
    color: #333;
}
.member-role {
    font-size: 0.9rem;
    color: #6c757d;
}
.owner-badge, .leader-badge {
    font-size: 0.8rem;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 20px;
    color: white;
}
.owner-badge {
    background: #ffc107;
}
.leader-badge {
    background: #17a2b8;
}
.btn-action {
    border-radius: 20px;
    font-size: 0.8rem;
    padding: 5px 15px;
    font-weight: 600;
}
</style>

<div class="modern-hero">
    <div class="container">
        <h1 style="font-size: 3rem; font-weight: 700; margin: 0;">Manage Members</h1>
        <p style="font-size: 1.1rem; opacity: 0.9; margin: 0;"><?php echo e($group->title); ?></p>
    </div>
</div>

<div class="container">
    <div class="management-container">
        <?php echo $__env->make('front.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Member List (<?php echo e($group->members()->count()); ?>)</h4>
            <a href="<?php echo e(route('account.group.show', $group->id)); ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back to Group</a>
        </div>

        <form method="GET" action="<?php echo e(route('account.group.manageMembers', $group->id)); ?>" class="mb-4">
            <input type="text" name="search" value="<?php echo e($search ?? ''); ?>" placeholder="Search members by name..." class="form-control" />
        </form>

        <div>
            <?php $__currentLoopData = $sortedMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="member-row">
                    <div class="member-info">
                        <img src="<?php echo e($member->image ? asset('storage/profile_pic/thumb/'.$member->image) : 'https://via.placeholder.com/50'); ?>" alt="<?php echo e($member->name); ?>" class="member-avatar">
                        <div>
                            <div class="member-name"><?php echo e($member->name); ?></div>
                            <div class="member-role"><?php echo e($member->email); ?></div>
                        </div>
                    </div>
                    <div class="member-status mx-4">
                        <?php if($group->user_id == $member->id): ?>
                            <span class="owner-badge"><i class="fas fa-crown me-1"></i>Coordinator</span>
                        <?php elseif($group->leaders->contains($member->id)): ?>
                            <span class="leader-badge"><i class="fas fa-shield-alt me-1"></i>Leader</span>
                        <?php endif; ?>
                    </div>
                    <div class="member-actions">
                        <?php
                            $isOwner = $group->user_id == Auth::id();
                            $isLeader = $group->leaders->contains(Auth::id());
                        ?>
                        <?php if($isOwner && $group->user_id != $member->id): ?>
                            <?php if($group->leaders->contains($member->id)): ?>
                                <form action="<?php echo e(route('account.group.demoteLeader')); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="group_id" value="<?php echo e($group->id); ?>">
                                    <input type="hidden" name="user_id" value="<?php echo e($member->id); ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary btn-action">Demote</button>
                                </form>
                            <?php else: ?>
                                <form action="<?php echo e(route('account.group.promoteLeader')); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="group_id" value="<?php echo e($group->id); ?>">
                                    <input type="hidden" name="user_id" value="<?php echo e($member->id); ?>">
                                    <button type="submit" class="btn btn-sm btn-info btn-action">Promote to Leader</button>
                                </form>
                            <?php endif; ?>
                            <form action="<?php echo e(route('account.group.removeMember')); ?>" method="POST" class="d-inline ms-2">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="group_id" value="<?php echo e($group->id); ?>">
                                <input type="hidden" name="user_id" value="<?php echo e($member->id); ?>">
                                <button type="submit" class="btn btn-sm btn-danger btn-action" onclick="return confirm('Are you sure you want to remove this member?')">Remove</button>
                            </form>
                        <?php elseif($isLeader && $group->user_id != $member->id && !$group->leaders->contains($member->id)): ?>
                            
                            <form action="<?php echo e(route('account.group.removeMember')); ?>" method="POST" class="d-inline ms-2">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="group_id" value="<?php echo e($group->id); ?>">
                                <input type="hidden" name="user_id" value="<?php echo e($member->id); ?>">
                                <button type="submit" class="btn btn-sm btn-danger btn-action" onclick="return confirm('Are you sure you want to remove this member?')">Remove</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/account/group/manage-members.blade.php ENDPATH**/ ?>