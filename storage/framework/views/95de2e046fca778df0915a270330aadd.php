<div class="dropdown">
    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-bell"></i>
        <?php if($unreadCount > 0): ?>
            <span class="badge bg-danger"><?php echo e($unreadCount); ?></span>
        <?php endif; ?>
    </button>
    <ul class="dropdown-menu" aria-labelledby="notificationDropdown">
        <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <li><a class="dropdown-item" href="#"><?php echo e($notification->data['message'] ?? 'New notification'); ?></a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <li><a class="dropdown-item disabled" href="#">No new notifications</a></li>
        <?php endif; ?>
    </ul>
</div>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/components/notifications-dropdown.blade.php ENDPATH**/ ?>