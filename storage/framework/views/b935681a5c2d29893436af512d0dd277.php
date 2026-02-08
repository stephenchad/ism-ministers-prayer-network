<?php $__env->startSection('main'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Translations</h1>
        <a href="<?php echo e(route('admin.translations.create')); ?>" class="btn btn-primary">Add New Translation</a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by key..." value="<?php echo e(is_string(request('search')) ? request('search') : ''); ?>">
                </div>
                <div class="col-md-4">
                    <select name="group" class="form-control">
                        <option value="">All Groups</option>
                        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($group); ?>" <?php echo e(request('group') == $group ? 'selected' : ''); ?>><?php echo e($group); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-secondary">Filter</button>
                    <a href="<?php echo e(route('admin.translations.index')); ?>" class="btn btn-outline-secondary">Clear</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Group</th>
                            <th>Key</th>
                            <th>English</th>
                            <th>Spanish</th>
                            <th>French</th>
                            <th>Portuguese</th>
                            <th>German</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $translations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $translation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><span class="badge bg-info"><?php echo e($translation->group); ?></span></td>
                            <td><code><?php echo e($translation->key); ?></code></td>
                            <td><?php echo e(Str::limit(is_array($translation->text) ? ($translation->text['en'] ?? '') : '', 30)); ?></td>
                            <td><?php echo e(Str::limit(is_array($translation->text) ? ($translation->text['es'] ?? '') : '', 30)); ?></td>
                            <td><?php echo e(Str::limit(is_array($translation->text) ? ($translation->text['fr'] ?? '') : '', 30)); ?></td>
                            <td><?php echo e(Str::limit(is_array($translation->text) ? ($translation->text['pt'] ?? '') : '', 30)); ?></td>
                            <td><?php echo e(Str::limit(is_array($translation->text) ? ($translation->text['de'] ?? '') : '', 30)); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.translations.edit', $translation->id)); ?>" class="btn btn-sm btn-warning">Edit</a>
                                <form action="<?php echo e(route('admin.translations.destroy', $translation->id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this translation?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center">No translations found</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php echo e($translations->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/translations/index.blade.php ENDPATH**/ ?>