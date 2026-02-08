<div class="profile-sidebar card shadow-sm border-0 rounded-3 p-4 mb-4">
    <div class="text-center mb-4 position-relative">

        @if (Auth::user()->image != '')
            <img id="profile-image" src="{{ asset('profile_pic/thumb/'.Auth::user()->image) }}" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;" alt="avatar">
        @else
            <img id="profile-image" src="{{ asset('assets/images/profile/1.jpg') }}" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;" alt="avatar">
        @endif

        <div class="position-absolute bottom-0 start-50 translate-middle-x">
            <button type="button" class="btn btn-sm btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#profileImageModal">
                <i class="fas fa-camera me-1"></i> Update
            </button>
        </div>
    </div>

    <h5 class="text-center mb-3">{{ Auth::user()->name }}</h5>
    <p class="text-muted text-center mb-4">{{ Auth::user()->designation ?? 'No designation specified' }}</p>

    <div class="sidebar-menu mx-auto">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active d-flex align-items-center" href="#profile-section">
                    <i class="fas fa-user-circle me-2"></i> Profile
                </a>
            </li>
          
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center" href="#">
                    <i class="fas fa-cog me-2"></i> Settings
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Profile Image Update Modal -->
<div class="modal fade" id="profileImageModal" tabindex="-1" aria-labelledby="profileImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileImageModalLabel">Update Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="profilePicForm" name="profilePicForm" action="" method="post">
                    @csrf
                    <div class="text-center mb-4">
                        <div class="image-preview-container mb-3">
                            <img id="image-preview" src="{{ asset('assets/images/profile/1.jpg') }}" 
                                 class="img-fluid rounded-circle" 
                                 style="width: 200px; height: 200px; object-fit: cover; border: 2px dashed #ddd;">
                        </div>
                        <div class="d-flex justify-content-center">
                            <label for="image-upload" class="btn btn-primary btn-sm rounded-pill cursor-pointer">
                                <i class="fas fa-cloud-upload-alt me-1"></i> Choose Image
                            </label>

                            {{--  <input type="file" name="image" id="image" accept="image/*" class="d-none">  --}}
                            <input type="file" id="image-upload" name="image" accept="image/*" class="d-none" onchange="previewImage(this)">


                            <p class="text-danger" id="image-error"></p>
                        </div>
                        <small class="text-muted d-block mt-2">JPG, PNG or GIF (Max 2MB)</small>
                    </div>
                    <!-- Progress Bar -->
                    <div class="progress" style="display: none;">
                        <div id="upload-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            0%
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" id="save-image-btn" class="btn btn-primary" onclick="uploadProfileImage()">Save Changes</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Handle profile picture form submission
        $("#profilePicForm").submit(function(e) {
            e.preventDefault();
            uploadProfileImage();
        });
    
        // Preview image when file is selected
        $("#image-upload").change(function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(event) {
                    $("#image-preview").attr('src', event.target.result)
                        .css('border-color', '#0d6efd');
                    $("#save-image-btn").prop('disabled', false);
                    
                    // Clear any previous errors
                    $("#image-error").text('');
                }
                
                reader.readAsDataURL(file);
            }
        });
    
        // Save button click handler
        $("#save-image-btn").click(function() {
            uploadProfileImage();
        });
    });
    
    function uploadProfileImage() {
        const form = document.getElementById('profilePicForm');
        const formData = new FormData(form);
        
        // Show loading state
        $("#save-image-btn").prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploading...'
        );

        // Show progress bar
        $('.progress').show();
        $('#upload-progress-bar').width('0%').attr('aria-valuenow', 0).text('0%');
    
        $.ajax({
            url: '{{ route("account.updateProfilePic") }}',
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                        $('#upload-progress-bar').width(percentComplete + '%').attr('aria-valuenow', percentComplete).text(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                if (response.status) {
                    // Update profile image in the sidebar
                    $("#profile-image").attr('src', response.image_url);
                    
                    // Show success message
                    showAlert('success', 'Profile image updated successfully!');
                    
                    // Close the modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('profileImageModal'));
                    modal.hide();
                    
                    // Reset the form
                    $("#image-upload").val('');
                    $("#save-image-btn").prop('disabled', true);
                } else {
                    showAlert('danger', 'Failed to update profile image: ' + response.message);
                }
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred during upload';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    if (errors.image) {
                        $("#image-error").html(errors.image);
                    }
                    errorMessage = Object.values(errors).join('<br>');
                }
                showAlert('danger', errorMessage);
            },
            complete: function() {
                // Reset button state
                $("#save-image-btn").prop('disabled', false).html('Save Changes');
                // Hide progress bar after a short delay
                setTimeout(function() {
                    $('.progress').hide();
                }, 1000);
            }
        });
    }
    
    // Helper function to show alerts
    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        // Prepend alert to the modal body
        $("#profileImageModal .modal-body").prepend(alertHtml);
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            $(".alert").alert('close');
        }, 5000);
    }
    {{--  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });  --}}
    {{--  $("#profilePicForm").submit(function(e){

        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: '{{ route("account.updateProfilePic") }}',
            type: 'post',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response){

                if (response.status == false){

                    var errors = response.errors;

                    if (errors.image) {

                        $("#image-error").html(errors.image)

                    }
                } else {
                    window.location.href = '{{ url()->current() }}';
                }
            }
        })

    })  --}}
</script>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageUpload = document.getElementById('image-upload');
        const imagePreview = document.getElementById('image-preview');
        const saveImageBtn = document.getElementById('save-image-btn');
        const profileImage = document.getElementById('profile-image');
        
        // Preview image when file is selected
        imageUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(event) {
                    imagePreview.src = event.target.result;
                    imagePreview.style.borderColor = '#0d6efd';
                    saveImageBtn.disabled = false;
                }
                
                reader.readAsDataURL(file);
            }
        });
        
        // Save image (simulated - in a real app you would upload to server)
        saveImageBtn.addEventListener('click', function() {
            if (imageUpload.files.length > 0) {
              
                // For this demo, we'll just update the preview
                profileImage.src = imagePreview.src;
                
                // Show success message
                alert('Profile image updated successfully!');
                
                // Close the modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('profileImageModal'));
                modal.hide();
                
                // Reset the form
                saveImageBtn.disabled = true;
            }
        });
    });
</script>

{{--  <script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const file = input.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.borderColor = '#0d6efd';
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    }

    function uploadImage() {
        const form = document.getElementById('profilePicForm');
        const formData = new FormData(form);
        
        // You can use AJAX to submit the form
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Update the profile image in the sidebar
                document.getElementById('profile-image').src = data.image_url;
                // Close the modal
                bootstrap.Modal.getInstance(document.getElementById('profileImageModal')).hide();
                // Show success message
                alert('Profile image updated successfully!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>  --}}
