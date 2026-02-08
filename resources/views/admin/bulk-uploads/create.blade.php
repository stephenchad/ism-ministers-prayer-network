<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Upload CSV - Bulk Uploads - ISM Prayer Network</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5">
        <h2>Upload CSV File for Bulk Upload</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.bulk-uploads.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="model_type" class="form-label">Select Model</label>
                <select name="model_type" id="model_type" class="form-select" required>
                    <option value="" disabled selected>Select a model</option>
                    @foreach ($models as $key => $label)
                        <option value="{{ $key }}" {{ old('model_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="csv_file" class="form-label">CSV File</label>
                <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv,text/csv" required />
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-upload me-2"></i>Upload</button>
            <a href="{{ route('admin.bulk-uploads.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
