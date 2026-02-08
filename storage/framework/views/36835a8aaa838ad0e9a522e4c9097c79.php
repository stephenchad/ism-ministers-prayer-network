<?php $__env->startSection('title', 'Page Content Management'); ?>

<?php $__env->startSection('main'); ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Page Content Management</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="<?php echo e(route('admin.page-content.create', ['page' => $page])); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Content
                    </a>
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
                <div class="card-header">
                    <h5 class="mb-0">Select Page</h5>
                </div>
                <div class="card-body">
                    <div class="page-selector">
                        <?php $__currentLoopData = ['home', 'about', 'contact', 'prayer-room', 'stream', 'radio', 'testimonies', 'groups', 'news', 'events']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pageName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('admin.page-content.index', ['page' => $pageName])); ?>"
                               class="page-btn <?php echo e($page === $pageName ? 'active' : ''); ?>">
                                <?php echo e(ucfirst(str_replace('-', ' ', $pageName))); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <?php if($contents->isEmpty()): ?>
            <div class="card">
                <div class="card-body text-center py-5">
                    <div style="font-size: 4rem; color: #dee2e6; margin-bottom: 20px;">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h4 class="text-muted">No content found for this page</h4>
                    <p class="text-muted">Add content using the "Add New Content" button above.</p>
                    <a href="<?php echo e(route('admin.page-content.create', ['page' => $page])); ?>" class="btn btn-primary mt-3">
                        <i class="fas fa-plus"></i> Add New Content
                    </a>
                </div>
            </div>
            <?php else: ?>
                <?php $__currentLoopData = $contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><?php echo e(ucfirst($section ?: 'General')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 150px;">Key</th>
                                        <th>Title</th>
                                        <th>Subtitle</th>
                                        <th>Content Preview</th>
                                        <th style="width: 100px;">Status</th>
                                        <th style="width: 150px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><code><?php echo e($item->key); ?></code></td>
                                            <td><?php echo e($item->title ?: '-'); ?></td>
                                            <td><?php echo e($item->subtitle ?: '-'); ?></td>
                                            <td><?php echo e(Str::limit(strip_tags($item->content ?: ''), 50)); ?></td>
                                            <td>
                                                <?php if($item->is_active): ?>
                                                    <span class="badge badge-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo e(route('admin.page-content.edit', $item->id)); ?>"
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="<?php echo e(route('admin.page-content.destroy', $item->id)); ?>"
                                                      method="POST"
                                                      style="display: inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this content?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.page-selector {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.page-btn {
    padding: 8px 16px;
    border: 1px solid var(--admin-border-color);
    border-radius: var(--admin-border-radius-sm);
    background: var(--admin-bg-light);
    color: var(--admin-text-primary);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all var(--transition-fast);
}

.page-btn:hover {
    background: var(--admin-border-color);
    color: var(--admin-text-primary);
}

.page-btn.active {
    background: linear-gradient(135deg, var(--admin-primary), var(--admin-secondary));
    color: white;
    border-color: transparent;
}

.badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
}

.badge-success {
    background: #28a745;
    color: white;
}

.badge-secondary {
    background: #6c757d;
    color: white;
}

.btn {
    padding: 8px 16px;
    border-radius: var(--admin-border-radius-sm);
    font-weight: 500;
    cursor: pointer;
    border: none;
    transition: all var(--transition-fast);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, var(--admin-primary), var(--admin-secondary));
    color: white;
}

.btn-primary:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

.btn-warning {
    background: #ffc107;
    color: #212529;
}

.btn-danger {
    background: #dc3545;
    color: white;
}

.btn-sm {
    padding: 6px 12px;
    font-size: 12px;
}

.card {
    background: var(--admin-bg-card);
    border: 1px solid var(--admin-border-color);
    border-radius: var(--admin-border-radius);
    margin-bottom: 16px;
}

.card-header {
    padding: 16px 20px;
    border-bottom: 1px solid var(--admin-border-color);
    background: var(--admin-bg-light);
}

.card-header:first-child {
    border-radius: var(--admin-border-radius) var(--admin-border-radius) 0 0;
}

.card-body {
    padding: 20px;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid var(--admin-border-color);
}

.table th {
    background: var(--admin-bg-light);
    font-weight: 600;
}

.table-hover tbody tr:hover {
    background: var(--admin-bg-light);
}

.table-responsive {
    overflow-x: auto;
}

.text-center {
    text-align: center;
}

.text-right {
    text-align: right;
}

.text-muted {
    color: var(--admin-text-muted);
}

.mb-0 {
    margin-bottom: 0;
}

.mb-4 {
    margin-bottom: 24px;
}

.mt-3 {
    margin-top: 16px;
}

code {
    background: var(--admin-bg-light);
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 12px;
}

.alert {
    padding: 16px 20px;
    border-radius: var(--admin-border-radius-sm);
    margin-bottom: 16px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/page-content/index.blade.php ENDPATH**/ ?>