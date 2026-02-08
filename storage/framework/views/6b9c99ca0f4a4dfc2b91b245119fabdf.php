<!DOCTYPE html>
<html>
<head>
    <title>New Contact Message</title>
</head>
<body>
    <h2>New Contact Message from ISM Prayer Network Website</h2>
    
    <p><strong>Name:</strong> <?php echo e($data['name']); ?></p>
    <p><strong>Email:</strong> <?php echo e($data['email']); ?></p>
    <p><strong>Subject:</strong> <?php echo e($data['subject']); ?></p>
    
    <h3>Message:</h3>
    <p><?php echo e($data['message']); ?></p>
    
    <hr>
    <p><em>This message was sent from the ISM Prayer Network contact form.</em></p>
</body>
</html><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/emails/contact-message.blade.php ENDPATH**/ ?>