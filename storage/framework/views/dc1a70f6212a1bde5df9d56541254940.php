<?php $__env->startSection('main'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #333; font-weight: 700;">Add New Stream</h2>
        <a href="<?php echo e(route('admin.streams')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Streams
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card" style="border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="card-body" style="padding: 40px;">
                    <form action="<?php echo e(route('admin.streams.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333;">Title *</label>
                            <input type="text" name="title" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('title')); ?>" required style="border-radius: 8px; padding: 12px 15px;">
                            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333;">Description</label>
                            <textarea name="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="3" style="border-radius: 8px; padding: 12px 15px;"><?php echo e(old('description')); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333;">Stream URL *</label>
                            <input type="text" name="stream_url" class="form-control <?php $__errorArgs = ['stream_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('stream_url')); ?>" required style="border-radius: 8px; padding: 12px 15px;">
                            <?php $__errorArgs = ['stream_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="text-muted">Enter the streaming URL or HLS stream path</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333;">Format *</label>
                            <select name="format" class="form-control <?php $__errorArgs = ['format'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required style="border-radius: 8px; padding: 12px 15px;">
                                <option value="url" <?php echo e(old('format') === 'url' ? 'selected' : ''); ?>>Direct Video URL (MP4, etc.)</option>
                                <option value="hls" <?php echo e(old('format') === 'hls' ? 'selected' : ''); ?>>HLS Stream (.m3u8)</option>
                            </select>
                            <?php $__errorArgs = ['format'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="text-muted">Note: For YouTube/Vimeo, use embed links or direct video URLs if available. RTMP is not supported.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #333;">Type *</label>
                                <select name="type" class="form-control <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required style="border-radius: 8px; padding: 12px 15px;">
                                    <option value="live" <?php echo e(old('type') === 'live' ? 'selected' : ''); ?>>Live Stream</option>
                                    <option value="recorded" <?php echo e(old('type') === 'recorded' ? 'selected' : ''); ?>>Recorded</option>
                                </select>
                                <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #333;">Scheduled At</label>
                                <input type="datetime-local" name="scheduled_at" class="form-control <?php $__errorArgs = ['scheduled_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('scheduled_at')); ?>" style="border-radius: 8px; padding: 12px 15px;">
                                <?php $__errorArgs = ['scheduled_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" <?php echo e(old('is_active', true) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_active" style="font-weight: 600; color: #333;">
                                    Active
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <button type="submit" class="btn flex-fill" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600;">
                                <i class="fas fa-save me-2"></i>Create Stream
                            </button>
                            <a href="<?php echo e(route('admin.streams')); ?>" class="btn btn-outline-secondary flex-fill" style="padding: 12px 25px; border-radius: 8px; font-weight: 600;">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/streams/create.blade.php ENDPATH**/ ?>