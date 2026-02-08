<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Referral - ISM Prayer Network</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <h2>Edit Referral for <?php echo e($user->name); ?></h2>
    <form action="<?php echo e(route('admin.referrals.update', $user->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="mb-3">
            <label for="referral_code" class="form-label">Referral Code</label>
            <input type="text" class="form-control" id="referral_code" name="referral_code" value="<?php echo e($user->referral_code); ?>" required>
        </div>
        <div class="mb-3">
            <label for="referred_by" class="form-label">Referred By (User ID)</label>
            <input type="number" class="form-control" id="referred_by" name="referred_by" value="<?php echo e($user->referred_by); ?>">
            <small class="form-text text-muted">Leave blank if no referrer</small>
        </div>
        <button type="submit" class="btn btn-primary">Update Referral</button>
        <a href="<?php echo e(route('admin.referrals')); ?>" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/referrals/edit.blade.php ENDPATH**/ ?>