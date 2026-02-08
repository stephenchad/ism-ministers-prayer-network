<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bulk Upload Details - ISM Prayer Network</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5">
        <h2>Bulk Upload Details</h2>
        <div class="mb-3">
            <strong>File Name:</strong> <?php echo e($upload->file_name); ?>

        </div>
        <div class="mb-3">
            <strong>Model Type:</strong> <?php echo e($upload->model_type); ?>

        </div>
        <div class="mb-3">
            <strong>Status:</strong>
            <?php if($upload->status === 'completed'): ?>
                <span class="badge bg-success"><?php echo e(ucfirst($upload->status)); ?></span>
            <?php elseif($upload->status === 'failed'): ?>
                <span class="badge bg-danger"><?php echo e(ucfirst($upload->status)); ?></span>
            <?php else: ?>
                <span class="badge bg-warning"><?php echo e(ucfirst($upload->status)); ?></span>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <strong>Uploaded By:</strong> <?php echo e($upload->uploader->name ?? 'Unknown'); ?>

        </div>
        <div class="mb-3">
            <strong>Uploaded At:</strong> <?php echo e($upload->created_at->format('M d, Y H:i')); ?>

        </div>
        <?php if($upload->error_log && count($upload->error_log) > 0): ?>
            <div class="mb-3">
                <strong>Error Log:</strong>
                <ul>
                    <?php $__currentLoopData = $upload->error_log; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        <a href="<?php echo e(route('admin.bulk-uploads.index')); ?>" class="btn btn-secondary">Back to Uploads</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/bulk-uploads/show.blade.php ENDPATH**/ ?>