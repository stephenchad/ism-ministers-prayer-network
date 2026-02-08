<?php $__env->startSection('title', 'Books Management'); ?>

<?php $__env->startSection('main'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-white">Books Management</h1>
        <a href="<?php echo e(route('admin.books.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Book
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(isset($error)): ?>
        <div class="alert alert-warning" role="alert">
            <?php echo e($error); ?>

        </div>
    <?php endif; ?>

    <div class="card bg-white rounded-lg shadow-sm">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.books.index')); ?>" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search by title or author..." 
                               value="<?php echo e($filters['search'] ?? ''); ?>">
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            <option value="prayer" <?php echo e(($filters['category'] ?? '') === 'prayer' ? 'selected' : ''); ?>>Prayer</option>
                            <option value="worship" <?php echo e(($filters['category'] ?? '') === 'worship' ? 'selected' : ''); ?>>Worship</option>
                            <option value="devotional" <?php echo e(($filters['category'] ?? '') === 'devotional' ? 'selected' : ''); ?>>Devotional</option>
                            <option value="theology" <?php echo e(($filters['category'] ?? '') === 'theology' ? 'selected' : ''); ?>>Theology</option>
                            <option value="life" <?php echo e(($filters['category'] ?? '') === 'life' ? 'selected' : ''); ?>>Life</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="<?php echo e(route('admin.books.index')); ?>" class="btn btn-secondary w-100">
                            <i class="fas fa-sync"></i> Reset
                        </a>
                    </div>
                </div>
            </form>

            <?php if(count($books) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Language</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($book['id'] ?? 'N/A'); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if(isset($book['cover_image'])): ?>
                                                <img src="<?php echo e($book['cover_image']); ?>" alt="<?php echo e($book['title']); ?>" 
                                                     class="rounded me-3" style="width: 50px; height: 70px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 70px;">
                                                    <i class="fas fa-book text-white"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <strong><?php echo e($book['title']); ?></strong>
                                                <?php if(isset($book['details']['format'])): ?>
                                                    <br><small class="text-muted"><?php echo e($book['details']['format']); ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo e($book['author']); ?></td>
                                    <td>
                                        <?php if(isset($book['details']['category'])): ?>
                                            <span class="badge bg-info"><?php echo e(ucfirst($book['details']['category'])); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(isset($book['price'])): ?>
                                            <strong>$<?php echo e(number_format($book['price'], 2)); ?></strong>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo e($book['details']['language'] ?? 'English'); ?>

                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?php echo e(route('admin.books.show', $book['id'])); ?>" 
                                               class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.books.edit', $book['id'])); ?>" 
                                               class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.books.destroy', $book['id'])); ?>" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this book?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <?php if(isset($pagination)): ?>
                    <nav aria-label="Books pagination" class="mt-4">
                        <ul class="pagination justify-content-center mb-0">
                            <?php if($pagination['current_page'] > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo e(route('admin.books.index', ['page' => $pagination['current_page'] - 1] + $filters)); ?>">
                                        Previous
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                                <li class="page-item <?php echo e($i === $pagination['current_page'] ? 'active' : ''); ?>">
                                    <a class="page-link" href="<?php echo e(route('admin.books.index', ['page' => $i] + $filters)); ?>">
                                        <?php echo e($i); ?>

                                    </a>
                                </li>
                            <?php endfor; ?>

                            <?php if($pagination['current_page'] < $pagination['total_pages']): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo e(route('admin.books.index', ['page' => $pagination['current_page'] + 1] + $filters)); ?>">
                                        Next
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-book fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No books found.</p>
                    <a href="<?php echo e(route('admin.books.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Your First Book
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/books/index.blade.php ENDPATH**/ ?>