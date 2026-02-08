<!DOCTYPE html>
<html>
<head>
    <title>New Contact Message</title>
</head>
<body>
    <h2>New Contact Message from ISM Prayer Network Website</h2>
    
    <p><strong>Name:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Subject:</strong> {{ $data['subject'] }}</p>
    
    <h3>Message:</h3>
    <p>{{ $data['message'] }}</p>
    
    <hr>
    <p><em>This message was sent from the ISM Prayer Network contact form.</em></p>
</body>
</html>