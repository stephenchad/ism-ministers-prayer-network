<?php $__env->startSection('main'); ?>
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
                <i class="fas fa-edit" style="font-size: 1.5rem;"></i>
            </div>
            <div>
                <h1 style="font-size: 3rem; font-weight: 700; margin: 0;">Edit Prayer Group</h1>
                <p style="font-size: 1.1rem; opacity: 0.9; margin: 0;">Update the details for "<?php echo e($group->title); ?>"</p>
            </div>
        </div>
    </div>
</div>

<div style="padding: 60px 0; background: #f8f9fa;">
    <div class="container">
        <?php echo $__env->make('front.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="row">
            <div class="col-lg-4">
                <div class="p-4 rounded-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; height: 100%;">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-info-circle fa-2x me-3"></i>
                        <h4 class="mb-0 fw-bold">Editing Your Group</h4>
                    </div>
                    <p class="opacity-90">Use this form to update your group's information. Your changes will be visible to all members immediately.</p>
                    <hr class="border-light opacity-50">
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <strong class="d-block">Review Details</strong>
                            <small class="opacity-75">Check all fields to ensure the information is accurate and up-to-date.</small>
                        </li>
                        <li class="mb-3">
                            <strong class="d-block">Member Capacity</strong>
                            <small class="opacity-75">You can increase the member limit, but you cannot set it lower than the current number of members.</small>
                        </li>
                        <li>
                            <strong class="d-block">Save Changes</strong>
                            <small class="opacity-75">Click "Update Group" to apply your changes.</small>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="form-container">
                <form id="groupForm" name="groupForm" method="POST" action="<?php echo e(route('account.group.update', $group->id)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <!-- Basic Information -->
                    <div class="form-section">
                        <h4><i class="fas fa-info-circle"></i>Basic Information</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">Group Title <span class="required">*</span></label>
                                <input type="text" name="title" id="title" class="form-control modern-input <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="E.g., Morning Prayer Warriors" value="<?php echo e(old('title', $group->title)); ?>" required>
                                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="invalid-feedback"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label">Category <span class="required">*</span></label>
                                <select name="category_id" id="category_id" class="form-select modern-input <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">Select Category</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id', $group->category_id) == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="invalid-feedback"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="description" class="form-label">Description <span class="required">*</span></label>
                                <textarea name="description" id="description" class="form-control modern-input <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="4" placeholder="Describe your group's purpose..." required><?php echo e(old('description', $group->description)); ?></textarea>
                                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="invalid-feedback"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="image" class="form-label">Group Image (Optional)</label>
                                <input type="file" name="image" id="image" class="form-control modern-input <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="image/*">
                                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="invalid-feedback"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="mt-3">
                                    <?php if($group->image): ?>
                                        <img src="<?php echo e(asset('storage/'.$group->image)); ?>" alt="Current Image" class="img-fluid rounded" style="max-height: 150px; border: 2px solid #ddd; padding: 5px;">
                                        <small class="d-block mt-2 text-muted">Current group image. Uploading a new file will replace it.</small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Group Settings -->
                    <div class="form-section">
                        <h4><i class="fas fa-cog"></i>Group Settings</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="group_type_id" class="form-label">Group Type <span class="required">*</span></label>
                                <select name="group_type_id" id="group_type_id" class="form-select modern-input <?php $__errorArgs = ['group_type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">Select Group Type</option>
                                    <?php $__currentLoopData = $groupTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($groupType->id); ?>" <?php echo e(old('group_type_id', $group->group_type_id) == $groupType->id ? 'selected' : ''); ?>><?php echo e($groupType->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['group_type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="invalid-feedback"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="max_members" class="form-label">Maximum Members <span class="required">*</span></label>
                                <input type="number" name="max_members" id="max_members" min="<?php echo e($group->current_members); ?>" class="form-control modern-input <?php $__errorArgs = ['max_members'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="E.g., 50" value="<?php echo e(old('max_members', $group->max_members)); ?>" required>
                                <?php $__errorArgs = ['max_members'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="invalid-feedback"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Location Information -->
                    <div class="form-section">
                        <h4><i class="fas fa-map-marker-alt"></i>Location Information</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="country_id" class="form-label">Country <span class="required">*</span></label>
                                <select name="country_id" id="country_id" class="form-select modern-input <?php $__errorArgs = ['country_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">Select Country</option>
                                    <?php if($countries->isNotEmpty()): ?>
                                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($country->id); ?>" <?php echo e(old('country_id', $group->country_id) == $country->id ? 'selected' : ''); ?>><?php echo e($country->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                                <?php $__errorArgs = ['country_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="invalid-feedback"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="city_id" class="form-label">City <span class="required">*</span></label>
                                <select name="city_id" id="city_id" class="form-select modern-input <?php $__errorArgs = ['city_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">Select City</option>
                                    <?php if($group->country): ?>
                                        <?php $__currentLoopData = $group->country->cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($city->id); ?>" <?php echo e(old('city_id', $group->city_id) == $city->id ? 'selected' : ''); ?>><?php echo e($city->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                                <?php $__errorArgs = ['city_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="invalid-feedback"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" id="address" class="form-control modern-input <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Enter full address (optional)" value="<?php echo e(old('address', $group->address)); ?>">
                                <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="invalid-feedback"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <button type="submit" name="submit" class="btn btn-create me-3">
                            <i class="fas fa-save" style="margin-right: 10px;"></i>Update Group
                        </button>
                        <a href="<?php echo e(route('account.group.show', $group->id)); ?>" class="btn btn-cancel">
                            <i class="fas fa-times" style="margin-right: 8px;"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('customJS'); ?>
<script>
    // Image preview for group edit
    $("#image").change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Create a new preview image if it doesn't exist
                let preview = $('#image-preview');
                if (preview.length === 0) {
                    $('#image').after('<div class="mt-3 text-center" id="image-preview-container"><img id="image-preview" src="#" alt="Image Preview" class="img-fluid rounded" style="max-height: 200px; border: 2px dashed #ddd; padding: 5px;"></div>');
                    preview = $('#image-preview');
                }
                preview.attr('src', e.target.result).parent().show();
            }
            reader.readAsDataURL(file);
        }
    });

    // Load cities when country is selected
    $("#country_id").change(function() {
        var countryId = $(this).val();
        if (countryId) {
            $.ajax({
                url: '<?php echo e(route("account.getCities")); ?>',
                type: 'GET',
                data: { country_id: countryId },
                success: function(data) {
                    $("#city_id").empty();
                    $("#city_id").append('<option value="">Select City</option>');
                    $.each(data, function(key, city) {
                        $("#city_id").append('<option value="' + city.id + '">' + city.name + '</option>');
                    });
                }
            });
        } else {
            $("#city_id").empty();
            $("#city_id").append('<option value="">Select City</option>');
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/account/group/edit-new.blade.php ENDPATH**/ ?>