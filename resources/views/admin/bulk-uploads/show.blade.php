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
            <strong>File Name:</strong> {{ $upload->file_name }}
        </div>
        <div class="mb-3">
            <strong>Model Type:</strong> {{ $upload->model_type }}
        </div>
        <div class="mb-3">
            <strong>Status:</strong>
            @if($upload->status === 'completed')
                <span class="badge bg-success">{{ ucfirst($upload->status) }}</span>
            @elseif($upload->status === 'failed')
                <span class="badge bg-danger">{{ ucfirst($upload->status) }}</span>
            @else
                <span class="badge bg-warning">{{ ucfirst($upload->status) }}</span>
            @endif
        </div>
        <div class="mb-3">
            <strong>Uploaded By:</strong> {{ $upload->uploader->name ?? 'Unknown' }}
        </div>
        <div class="mb-3">
            <strong>Uploaded At:</strong> {{ $upload->created_at->format('M d, Y H:i') }}
        </div>
        @if($upload->error_log && count($upload->error_log) > 0)
            <div class="mb-3">
                <strong>Error Log:</strong>
                <ul>
                    @foreach($upload->error_log as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <a href="{{ route('admin.bulk-uploads.index') }}" class="btn btn-secondary">Back to Uploads</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
