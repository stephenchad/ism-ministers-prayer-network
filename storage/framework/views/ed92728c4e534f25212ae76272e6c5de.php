<!DOCTYPE html>
<html>
<head>
    <title>New Prayer Request</title>
</head>
<body>
    <h2>New Prayer Request from ISM Prayer Network Website</h2>
    
    <p><strong>Name:</strong> <?php echo e($data['name']); ?></p>
    <?php if($data['email']): ?>
        <p><strong>Email:</strong> <?php echo e($data['email']); ?></p>
    <?php endif; ?>
    <p><strong>Prayer Type:</strong> <?php echo e(ucfirst($data['prayer_type'])); ?></p>
    
    <h3>Prayer Request:</h3>
    <p><?php echo e($data['prayer_request']); ?></p>
    
    <hr>
    <p><em>This prayer request was submitted through the ISM Prayer Network website.</em></p>
</body>
</html><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/emails/prayer-request.blade.php ENDPATH**/ ?>