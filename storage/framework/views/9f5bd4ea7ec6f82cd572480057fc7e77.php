<?php $__env->startSection('main'); ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Site Statistics</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStatModal">
                        <i class="fas fa-plus"></i> Add New Stat
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

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home-stats">Home Page Stats</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#about-stats">About Page Stats</a>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Home Stats -->
                <div id="home-stats" class="tab-pane active">
                    <div class="card mt-3">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">Order</th>
                                        <th>Key</th>
                                        <th>Label</th>
                                        <th>Value</th>
                                        <th>Icon</th>
                                        <th>Status</th>
                                        <th style="width: 150px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $homeStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($stat->sort_order); ?></td>
                                        <td><?php echo e($stat->key); ?></td>
                                        <td><?php echo e($stat->label); ?></td>
                                        <td><strong><?php echo e($stat->value); ?></strong></td>
                                        <td><i class="fas <?php echo e($stat->icon); ?>"></i></td>
                                        <td>
                                            <?php if($stat->is_active): ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editStatModal<?php echo e($stat->id); ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="<?php echo e(route('admin.page-content.stats.destroy', $stat->id)); ?>" method="POST" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this stat?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editStatModal<?php echo e($stat->id); ?>" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Stat</h5>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <form action="<?php echo e(route('admin.page-content.stats.update', $stat->id)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PUT'); ?>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Key (unique identifier)</label>
                                                            <input type="text" name="key" class="form-control" value="<?php echo e($stat->key); ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Label</label>
                                                            <input type="text" name="label" class="form-control" value="<?php echo e($stat->label); ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Value (e.g., 50K+, 24/7)</label>
                                                            <input type="text" name="value" class="form-control" value="<?php echo e($stat->value); ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Icon (Font Awesome class)</label>
                                                            <input type="text" name="icon" class="form-control" value="<?php echo e($stat->icon); ?>" placeholder="e.g., fa-users">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Description</label>
                                                            <textarea name="description" class="form-control"><?php echo e($stat->description); ?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Page</label>
                                                            <select name="page" class="form-control">
                                                                <option value="home" <?php echo e($stat->page == 'home' ? 'selected' : ''); ?>>Home Page</option>
                                                                <option value="about" <?php echo e($stat->page == 'about' ? 'selected' : ''); ?>>About Page</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Sort Order</label>
                                                            <input type="number" name="sort_order" class="form-control" value="<?php echo e($stat->sort_order); ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                <input type="checkbox" name="is_active" value="1" <?php echo e($stat->is_active ? 'checked' : ''); ?>>
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
                                        <td colspan="7" class="text-center">No home page stats found.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- About Stats -->
                <div id="about-stats" class="tab-pane fade">
                    <div class="card mt-3">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">Order</th>
                                        <th>Key</th>
                                        <th>Label</th>
                                        <th>Value</th>
                                        <th>Icon</th>
                                        <th>Status</th>
                                        <th style="width: 150px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $aboutStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($stat->sort_order); ?></td>
                                        <td><?php echo e($stat->key); ?></td>
                                        <td><?php echo e($stat->label); ?></td>
                                        <td><strong><?php echo e($stat->value); ?></strong></td>
                                        <td><i class="fas <?php echo e($stat->icon); ?>"></i></td>
                                        <td>
                                            <?php if($stat->is_active): ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editAboutStatModal<?php echo e($stat->id); ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="<?php echo e(route('admin.page-content.stats.destroy', $stat->id)); ?>" method="POST" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this stat?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editAboutStatModal<?php echo e($stat->id); ?>" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Stat</h5>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <form action="<?php echo e(route('admin.page-content.stats.update', $stat->id)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PUT'); ?>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Key (unique identifier)</label>
                                                            <input type="text" name="key" class="form-control" value="<?php echo e($stat->key); ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Label</label>
                                                            <input type="text" name="label" class="form-control" value="<?php echo e($stat->label); ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Value (e.g., 50K+, 24/7)</label>
                                                            <input type="text" name="value" class="form-control" value="<?php echo e($stat->value); ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Icon (Font Awesome class)</label>
                                                            <input type="text" name="icon" class="form-control" value="<?php echo e($stat->icon); ?>" placeholder="e.g., fa-users">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Description</label>
                                                            <textarea name="description" class="form-control"><?php echo e($stat->description); ?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Page</label>
                                                            <select name="page" class="form-control">
                                                                <option value="home" <?php echo e($stat->page == 'home' ? 'selected' : ''); ?>>Home Page</option>
                                                                <option value="about" <?php echo e($stat->page == 'about' ? 'selected' : ''); ?>>About Page</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Sort Order</label>
                                                            <input type="number" name="sort_order" class="form-control" value="<?php echo e($stat->sort_order); ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                <input type="checkbox" name="is_active" value="1" <?php echo e($stat->is_active ? 'checked' : ''); ?>>
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
                                        <td colspan="7" class="text-center">No about page stats found.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addStatModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Stat</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="<?php echo e(route('admin.page-content.stats.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Key (unique identifier)</label>
                        <input type="text" name="key" class="form-control" placeholder="e.g., prayer_partners" required>
                    </div>
                    <div class="form-group">
                        <label>Label</label>
                        <input type="text" name="label" class="form-control" placeholder="e.g., Prayer Partners" required>
                    </div>
                    <div class="form-group">
                        <label>Value (e.g., 50K+, 24/7)</label>
                        <input type="text" name="value" class="form-control" placeholder="e.g., 50K+" required>
                    </div>
                    <div class="form-group">
                        <label>Icon (Font Awesome class)</label>
                        <input type="text" name="icon" class="form-control" placeholder="e.g., fa-users">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" placeholder="Brief description"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Page</label>
                        <select name="page" class="form-control">
                            <option value="home">Home Page</option>
                            <option value="about">About Page</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
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
                    <button type="submit" class="btn btn-primary">Create Stat</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/page-content/stats.blade.php ENDPATH**/ ?>