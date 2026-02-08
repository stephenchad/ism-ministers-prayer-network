<?php $__env->startSection('main'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Add Prayer Resource</h1>
        <a href="<?php echo e(route('admin.prayer-resources')); ?>" class="btn btn-secondary">Back to Resources</a>
    </div>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('admin.prayer-resources.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Resource Type</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="resource_type" id="type_file" value="file" checked>
                            <label class="form-check-label" for="type_file">File Download</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="resource_type" id="type_video" value="video">
                            <label class="form-check-label" for="type_video">Video Resource</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="resource_type" id="type_guide" value="guide">
                            <label class="form-check-label" for="type_guide">Prayer Guide</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3" id="file_section">
                    <label for="file" class="form-label">File</label>
                    <input type="file" name="file" id="file" class="form-control" accept=".pdf,.doc,.docx">
                    <small class="text-muted">Accepted formats: PDF, DOC, DOCX (Max: 10MB)</small>
                </div>

                <div id="video_section" style="display: none;">
                    <div class="mb-3">
                        <label for="video_url" class="form-label">Video URL (Optional)</label>
                        <input type="url" name="video_url" id="video_url" class="form-control" placeholder="https://youtube.com/watch?v=...">
                        <small class="text-muted">YouTube, Vimeo, or any video URL</small>
                    </div>
                    <div class="mb-3">
                        <label for="video_file" class="form-label">Or Upload Video File</label>
                        <input type="file" name="video_file" id="video_file" class="form-control" accept=".mp4,.avi,.mov,.wmv">
                        <small class="text-muted">Accepted formats: MP4, AVI, MOV, WMV (Max: 100MB)</small>
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="form-label">Duration</label>
                        <input type="text" name="duration" id="duration" class="form-control" placeholder="e.g., 15 min">
                    </div>
                </div>

                <div id="guide_section" style="display: none;">
                    <div class="mb-3">
                        <label for="guide_content" class="form-label">Guide Content</label>
                        <textarea name="guide_content" id="guide_content" class="form-control" rows="10" placeholder="Enter the prayer guide content..."></textarea>
                        <small class="text-muted">Use the formatting toolbar to style your content</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="reading_time" class="form-label">Reading Time</label>
                                <input type="text" name="reading_time" id="reading_time" class="form-control" placeholder="e.g., 5 min">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="icon" class="form-label">Icon (FontAwesome)</label>
                                <input type="text" name="icon" id="icon" class="form-control" placeholder="e.g., fa-heart">
                                <small class="text-muted">FontAwesome icon class without 'fas'</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Create Resource</button>
            </form>
        </div>
    </div>
</div>

<!-- Summernote CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileRadio = document.getElementById('type_file');
    const videoRadio = document.getElementById('type_video');
    const guideRadio = document.getElementById('type_guide');
    const fileSection = document.getElementById('file_section');
    const videoSection = document.getElementById('video_section');
    const guideSection = document.getElementById('guide_section');

    function toggleSections() {
        fileSection.style.display = 'none';
        videoSection.style.display = 'none';
        guideSection.style.display = 'none';
        
        if (fileRadio.checked) {
            fileSection.style.display = 'block';
        } else if (videoRadio.checked) {
            videoSection.style.display = 'block';
        } else if (guideRadio.checked) {
            guideSection.style.display = 'block';
            // Initialize Summernote when guide section is shown
            if (!$('#guide_content').hasClass('summernote-initialized')) {
                $('#guide_content').summernote({
                    height: 400,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ],
                    callbacks: {
                        onInit: function() {
                            $('#guide_content').addClass('summernote-initialized');
                        }
                    }
                });
            }
        }
    }

    fileRadio.addEventListener('change', toggleSections);
    videoRadio.addEventListener('change', toggleSections);
    guideRadio.addEventListener('change', toggleSections);
    
    toggleSections(); // Initialize
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/prayer-resources/create.blade.php ENDPATH**/ ?>