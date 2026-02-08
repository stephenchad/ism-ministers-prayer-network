<!DOCTYPE html>
<html>
<head>
    <title>New Prayer Request</title>
</head>
<body>
    <h2>New Prayer Request from ISM Prayer Network Website</h2>
    
    <p><strong>Name:</strong> {{ $data['name'] }}</p>
    @if($data['email'])
        <p><strong>Email:</strong> {{ $data['email'] }}</p>
    @endif
    <p><strong>Prayer Type:</strong> {{ ucfirst($data['prayer_type']) }}</p>
    
    <h3>Prayer Request:</h3>
    <p>{{ $data['prayer_request'] }}</p>
    
    <hr>
    <p><em>This prayer request was submitted through the ISM Prayer Network website.</em></p>
</body>
</html>