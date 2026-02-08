<?php $__env->startSection('title', $book['title'] ?? 'Book Details'); ?>

<?php $__env->startSection('main'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-white">Book Details</h1>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.books.edit', $book['id'])); ?>" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="<?php echo e(route('admin.books.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Books
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card bg-white rounded-lg shadow-sm">
                <div class="card-body">
                    <?php if(isset($book['cover_image'])): ?>
                        <img src="<?php echo e($book['cover_image']); ?>" alt="<?php echo e($book['title']); ?>" 
                             class="img-fluid rounded shadow-sm mb-3">
                    <?php else: ?>
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center mb-3" 
                             style="height: 300px;">
                            <i class="fas fa-book fa-5x text-white"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="text-center">
                        <?php if(isset($book['price'])): ?>
                            <h3 class="text-primary mb-3">$<?php echo e(number_format($book['price'], 2)); ?></h3>
                        <?php endif; ?>
                        
                        <div class="d-grid gap-2">
                            <a href="<?php echo e(route('admin.books.edit', $book['id'])); ?>" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Book
                            </a>
                            <form action="<?php echo e(route('admin.books.destroy', $book['id'])); ?>" 
                                  method="POST" class="d-grid"
                                  onsubmit="return confirm('Are you sure you want to delete this book?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Delete Book
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card bg-white rounded-lg shadow-sm">
                <div class="card-body">
                    <h2 class="card-title mb-3"><?php echo e($book['title']); ?></h2>
                    <p class="text-muted mb-4">
                        <i class="fas fa-user"></i> By <?php echo e($book['author']); ?>

                    </p>

                    <div class="mb-4">
                        <h5 class="mb-2">Description</h5>
                        <p class="card-text"><?php echo e($book['description']); ?></p>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Book Details</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Category:</span>
                                <span class="fw-bold">
                                    <?php if(isset($book['details']['category'])): ?>
                                        <?php echo e(ucfirst($book['details']['category'])); ?>

                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Language:</span>
                                <span class="fw-bold">
                                    <?php echo e($book['details']['language'] ?? 'English'); ?>

                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Format:</span>
                                <span class="fw-bold">
                                    <?php if(isset($book['details']['format'])): ?>
                                        <?php echo e($book['details']['format']); ?>

                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Pages:</span>
                                <span class="fw-bold">
                                    <?php if(isset($book['details']['pages']) && $book['details']['pages'] > 0): ?>
                                        <?php echo e(number_format($book['details']['pages'])); ?>

                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <?php if(isset($book['created_at'])): ?>
                        <div class="mt-4 pt-3 border-top">
                            <small class="text-muted">
                                <i class="fas fa-calendar"></i> Created: <?php echo e(\Carbon\Carbon::parse($book['created_at'])->format('F j, Y g:i A')); ?>

                                <?php if(isset($book['updated_at']) && $book['updated_at'] !== $book['created_at']): ?>
                                    <br>
                                    <i class="fas fa-edit"></i> Last Updated: <?php echo e(\Carbon\Carbon::parse($book['updated_at'])->format('F j, Y g:i A')); ?>

                                <?php endif; ?>
                            </small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/books/show.blade.php ENDPATH**/ ?>