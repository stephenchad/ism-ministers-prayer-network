<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Bulk Message - ISM Prayer Network</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Create Bulk Message</h2>
    <form action="{{ route('admin.bulk-messages.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="type" class="form-label">Message Type</label>
            <select name="type" id="type" class="form-select" required>
                <option value="">Select Type</option>
                <option value="email" {{ old('type') == 'email' ? 'selected' : '' }}>Email</option>
                <option value="sms" {{ old('type') == 'sms' ? 'selected' : '' }}>SMS</option>
            </select>
            @error('type')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3" id="subject-group">
            <label for="subject" class="form-label">Subject (for Email)</label>
            <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}">
            @error('subject')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message Body</label>
            <div id="quill-editor" style="height: 300px;">{!! old('message') !!}</div>
            <input type="hidden" name="message" value="{{ old('message') }}">
            @error('message')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="send_to_all" class="form-label">
                <input type="checkbox" name="send_to_all" id="send_to_all" value="1" {{ old('send_to_all') ? 'checked' : '' }}>
                Send to all users
            </label>
            @error('send_to_all')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Send Bulk Message</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        function toggleSubject() {
            if ($('#type').val() === 'email') {
                $('#subject-group').show();
                $('#subject').attr('required', true);
            } else {
                $('#subject-group').hide();
                $('#subject').removeAttr('required');
            }
        }
        toggleSubject();
        $('#type').change(toggleSubject);
    });
</script>

<!-- Remove TinyMCE and replace with Quill -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var quill = new Quill('#quill-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ header: [1, 2, false] }],
                    ['bold', 'italic', 'underline'],
                    ['link', 'image'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['clean']
                ]
            }
        });

        // Sync Quill content to hidden input on form submit
        var form = document.querySelector('form');
        form.onsubmit = function() {
            var messageInput = document.querySelector('input[name=message]');
            messageInput.value = quill.root.innerHTML;
        };
    });
</script>

</body>
</html>
