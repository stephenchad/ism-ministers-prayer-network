<?php $__env->startSection('main'); ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Page Sections</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSectionModal">
                        <i class="fas fa-plus"></i> Add New Section
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 50px;">Order</th>
                                <th>Key</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Page</th>
                                <th>Status</th>
                                <th style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($section->sort_order); ?></td>
                                <td><?php echo e($section->key); ?></td>
                                <td><?php echo e($section->title); ?></td>
                                <td><span class="badge badge-info"><?php echo e($section->section_type); ?></span></td>
                                <td><?php echo e($section->page); ?></td>
                                <td>
                                    <?php if($section->is_active): ?>
                                        <span class="badge badge-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editSectionModal<?php echo e($section->id); ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="<?php echo e(route('admin.page-content.sections.destroy', $section->id)); ?>" method="POST" style="display: inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this section?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editSectionModal<?php echo e($section->id); ?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Section</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <form action="<?php echo e(route('admin.page-content.sections.update', $section->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Key (unique identifier)</label>
                                                            <input type="text" name="key" class="form-control" value="<?php echo e($section->key); ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Title</label>
                                                            <input type="text" name="title" class="form-control" value="<?php echo e($section->title); ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Subtitle</label>
                                                    <textarea name="subtitle" class="form-control" rows="2"><?php echo e($section->subtitle); ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Content</label>
                                                    <textarea name="content" class="form-control" rows="4"><?php echo e($section->content); ?></textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Page</label>
                                                            <select name="page" class="form-control">
                                                                <option value="home" <?php echo e($section->page == 'home' ? 'selected' : ''); ?>>Home</option>
                                                                <option value="about" <?php echo e($section->page == 'about' ? 'selected' : ''); ?>>About</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Section Type</label>
                                                            <select name="section_type" class="form-control">
                                                                <option value="default" <?php echo e($section->section_type == 'default' ? 'selected' : ''); ?>>Default</option>
                                                                <option value="features" <?php echo e($section->section_type == 'features' ? 'selected' : ''); ?>>Features</option>
                                                                <option value="cta" <?php echo e($section->section_type == 'cta' ? 'selected' : ''); ?>>Call to Action</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Sort Order</label>
                                                            <input type="number" name="sort_order" class="form-control" value="<?php echo e($section->sort_order); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        <input type="checkbox" name="is_active" value="1" <?php echo e($section->is_active ? 'checked' : ''); ?>>
                                                        Active
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center">No sections found. Add your first section!</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addSectionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Section</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="<?php echo e(route('admin.page-content.sections.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Key (unique identifier)</label>
                                <input type="text" name="key" class="form-control" placeholder="e.g., how_we_serve" required>
                                <small class="text-muted">Use underscores, no spaces</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Section title" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Subtitle</label>
                        <textarea name="subtitle" class="form-control" rows="2" placeholder="Optional subtitle"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <textarea name="content" class="form-control" rows="4" placeholder="Main content"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Page</label>
                                <select name="page" class="form-control">
                                    <option value="home">Home</option>
                                    <option value="about">About</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Section Type</label>
                                <select name="section_type" class="form-control">
                                    <option value="default">Default</option>
                                    <option value="features">Features</option>
                                    <option value="cta">Call to Action</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="is_active" value="1" checked>
                            Active
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Section</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/page-content/sections.blade.php ENDPATH**/ ?>