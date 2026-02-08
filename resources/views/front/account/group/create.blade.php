@extends('front.layouts.app')

@section('main')
<style>
.modern-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 80px 0 60px;
    color: white;
    text-align: center;
}
.form-container {
    background: white;
    border-radius: 25px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    padding: 40px;
    margin-bottom: 30px;
}
.form-section {
    background: #f8f9fa;
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    border-left: 5px solid #667eea;
}
.form-section h4 {
    color: #333;
    font-weight: 700;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
}
.form-section h4 i {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 15px;
    font-size: 1rem;
}
.modern-input {
    border: 2px solid #e9ecef;
    border-radius: 15px;
    padding: 12px 20px;
    font-size: 1rem;
    transition: all 0.3s ease;
}
.modern-input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}
.btn-create {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 25px;
    padding: 15px 40px;
    color: white;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}
.btn-create:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(102, 126, 234, 0.3);
    color: white;
}
.btn-cancel {
    border: 2px solid #6c757d;
    color: #6c757d;
    border-radius: 25px;
    padding: 13px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-cancel:hover {
    background: #6c757d;
    color: white;
}
.form-label {
    color: #333;
    font-weight: 600;
    margin-bottom: 8px;
}
.required {
    color: #dc3545;
}
</style>

<div class="modern-hero">
    <div class="container">
        <div class="d-flex align-items-center justify-content-center mb-3">
            <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 20px;">
                <i class="fas fa-plus" style="font-size: 1.5rem;"></i>
            </div>
            <div>
                <h1 style="font-size: 3rem; font-weight: 700; margin: 0;">Create Prayer Group</h1>
                <p style="font-size: 1.1rem; opacity: 0.9; margin: 0;">Start building your faith community</p>
            </div>
        </div>
    </div>
</div>

<div style="padding: 60px 0; background: #f8f9fa;">
    <div class="container">
        @include('front.message')
        <div class="row">
            <div class="col-lg-4">
                <div class="p-4 rounded-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; height: 100%;">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-info-circle fa-2x me-3"></i>
                        <h4 class="mb-0 fw-bold">Group Creation Guide</h4>
                    </div>
                    <p class="opacity-90">Follow these steps to create a vibrant and engaging prayer group for your community.</p>
                    <hr class="border-light opacity-50">
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <strong class="d-block">1. Choose a Clear Title</strong>
                            <small class="opacity-75">A great title helps others understand your group's focus.</small>
                        </li>
                        <li class="mb-3">
                            <strong class="d-block">2. Write a Compelling Description</strong>
                            <small class="opacity-75">Explain the purpose of your group and what members can expect.</small>
                        </li>
                        <li class="mb-3">
                            <strong class="d-block">3. Set Your Group's Details</strong>
                            <small class="opacity-75">Define the group type, member limit, and location.</small>
                        </li>
                        <li>
                            <strong class="d-block">4. Add a Group Image</strong>
                            <small class="opacity-75">A visual banner makes your group stand out.</small>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="form-container">
                <form id="groupForm" name="groupForm" method="POST" action="" enctype="multipart/form-data" novalidate>
                    @csrf
                    
                    <!-- Basic Information -->
                    <div class="form-section">
                        <h4><i class="fas fa-info-circle"></i>Basic Information</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">Group Title <span class="required">*</span></label>
                                <input type="text" name="title" id="title" class="form-control modern-input" placeholder="E.g., Morning Prayer Warriors" required>
                                <p></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category <span class="required">*</span></label>
                                <select name="category" id="category" class="form-select modern-input" required>
                                    <option value="">Select Category</option>
                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p></p>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="description" class="form-label">Description <span class="required">*</span></label>
                                <textarea name="description" id="description" class="form-control modern-input" rows="4" placeholder="Describe your group's purpose, activities, and what members can expect" required></textarea>
                                <p></p>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="image" class="form-label">Group Image (Optional)</label>
                                <input type="file" name="image" id="image" class="form-control modern-input" accept="image/*">
                                <!-- Image Preview Container -->
                                <div class="mt-3 text-center" id="image-preview-container" style="display:none;">
                                    <img id="image-preview" src="#" alt="Image Preview" class="img-fluid rounded" style="max-height: 200px; border: 2px dashed #ddd; padding: 5px;">
                                </div>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Group Settings -->
                    <div class="form-section">
                        <h4><i class="fas fa-cog"></i>Group Settings</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="group_type" class="form-label">Group Type <span class="required">*</span></label>
                                <select name="group_type" id="group_type" class="form-select modern-input" required>
                                    <option value="">Select Group Type</option>
                                    @if ($groupTypes->isNotEmpty())
                                        @foreach ($groupTypes as $groupType)
                                            <option value="{{ $groupType->id }}">{{ $groupType->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="max_members" class="form-label">Maximum Members <span class="required">*</span></label>
                                <input type="number" name="max_members" id="max_members" min="2" class="form-control modern-input" placeholder="E.g., 50" required>
                                <p></p>
                            </div>
                            <!-- Hidden field for current_members -->
                            <input type="hidden" name="current_members" id="current_members" value="1">
                        </div>
                    </div>
                    
                    <!-- Location Information -->
                    <div class="form-section">
                        <h4><i class="fas fa-map-marker-alt"></i>Location Information</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="country_id" class="form-label">Country <span class="required">*</span></label>
                                <select name="country_id" id="country_id" class="form-select modern-input" required>
                                    <option value="">Select Country</option>
                                    @if ($countries->isNotEmpty())
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="city_id" class="form-label">City <span class="required">*</span></label>
                                <select name="city_id" id="city_id" class="form-select modern-input" required>
                                    <option value="">Select City</option>
                                </select>
                                <p></p>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" id="address" class="form-control modern-input" placeholder="Enter full address (optional)">
                                <p></p>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="progress mt-3" style="display: none; height: 20px;">
                        <div id="group-upload-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            0%
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <button type="submit" name="submit" class="btn btn-create me-3">
                            <i class="fas fa-plus" style="margin-right: 10px;"></i>Create Prayer Group
                        </button>
                        <a href="{{ route('account.myGroups') }}" class="btn btn-cancel">
                            <i class="fas fa-times" style="margin-right: 8px;"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJS')
<script>
    // Image preview for group creation
    $("#image").change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $("#image-preview").attr('src', e.target.result);
                $("#image-preview-container").show();
            }
            reader.readAsDataURL(file);
        } else {
            $("#image-preview-container").hide();
        }
    });

    // Load cities when country is selected
    $("#country_id").change(function() {
        var countryId = $(this).val();
        var citySelect = $("#city_id");
        
        if (countryId) {
            // Show loading state
            citySelect.html('<option value="">Loading cities...</option>').prop('disabled', true);
            
            $.ajax({
                url: '{{ route("account.getCities") }}',
                type: 'GET',
                data: { country_id: countryId },
                success: function(data) {
                    citySelect.html('<option value="">Select City</option>').prop('disabled', false);
                    
                    if (data.length > 0) {
                        $.each(data, function(key, city) {
                            citySelect.append('<option value="' + city.id + '">' + city.name + '</option>');
                        });
                    } else {
                        citySelect.html('<option value="">No cities available</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX Error:', xhr.responseText, status, error);
                    citySelect.html('<option value="">Error loading cities</option>').prop('disabled', false);
                    alert('Failed to load cities. Please try again.');
                }
            });
        } else {
            citySelect.html('<option value="">Select City</option>').prop('disabled', false);
        }
    });

    $("#groupForm").submit(function(e){
  
      e.preventDefault();
      var form = $(this);
      var formData = new FormData(this);

      form.find("button[type='submit']").prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creating...'
      );

      // Show progress bar if an image is selected
      if ($('#image').get(0).files.length > 0) {
        $('.progress').show();
        $('#group-upload-progress-bar').width('0%').attr('aria-valuenow', 0).text('0%');
      }
      
      $.ajax({
            url: '{{ route("account.saveGroup") }}',
            type: 'POST',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            processData: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                        $('#group-upload-progress-bar').width(percentComplete + '%').attr('aria-valuenow', percentComplete).text(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(response){
                if(response.status == false){

                    var errors = response.errors;

                    if(errors.title){
                        $("#title").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.title)
                    }else{
                        $("#title").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')
                    }

                    if(errors.category){
                        $("#category").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.category)
                    }else{
                        $("#category").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')
                    }

                    if(errors.group_type){
                        $("#group_type").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.group_type)
                    }else{
                        $("#group_type").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')
                    }

                    if(errors.country_id){
                        $("#country_id").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.country_id)
                    }else{
                        $("#country_id").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')
                    }

                    if(errors.city_id){
                        $("#city_id").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.city_id)
                    }else{
                        $("#city_id").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')
                    }

                    if(errors.address){
                        $("#address").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.address)
                    }else{
                        $("#address").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')
                    }


                    if(errors.description){
                        $("#description").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.description)
                    }else{
                        $("#description").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')
                    }


                    if(errors.max_members){
                        $("#max_members").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.max_members)
                    }else{
                        $("#max_members").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')
                    }


                    if(errors.current_members){
                        $("#current_members").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.current_members)
                    }else{
                        $("#current_members").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')
                    }

                    if(errors.image){
                        $("#image").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.image)
                    }else{
                        $("#image").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')
                    }

                    // Show database errors if any
                    if(errors.database){
                        alert('Database Error: ' + errors.database);
                    }
                } else {
                    $("#title").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('');

                    $("#category").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('');

                    $("#group_type").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                    $("#country_id").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                    $("#city_id").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                    $("#address").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                    $("#description").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                    $("#max_members").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                    $("#current_members").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                    $("#image").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                    window.location.href = "{{ route('account.myGroups') }}";

                }
            }
            ,
            error: function() {
                alert('An error occurred. Please try again.');
            },
            complete: function() {
                form.find("button[type='submit']").prop('disabled', false).html('<i class="fas fa-plus" style="margin-right: 10px;"></i>Create Prayer Group');
            }
      });
    })

</script>
@endsection

@section('styles')
<style>
.form-label {
    margin-bottom: 0.5rem;
}
.invalid-feedback {
    display: block;
    color: #dc3545;
}
.form-text {
    font-size: 0.875rem;
    color: #6c757d;
}
</style>
@endsection