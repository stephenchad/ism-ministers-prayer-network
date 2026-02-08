<?php $__env->startSection('main'); ?>
<section class="breadcrumbs-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-content">
                    <h2>Digital Books</h2>
                    <ul>
                        <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
                        <li>Books</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="books-section section-padding">
    <div class="container">
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?php echo e($error); ?></div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3>Available Books</h3>
                    <a href="<?php echo e(route('books.my-books')); ?>" class="btn btn-primary">My Books</a>
                </div>
            </div>
        </div>

        <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <?php if(isset($book['cover_image'])): ?>
                            <img src="<?php echo e($book['cover_image']); ?>" class="card-img-top" alt="<?php echo e($book['title']); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($book['title']); ?></h5>
                            <p class="card-text"><?php echo e(Str::limit($book['description'] ?? '', 100)); ?></p>
                            <?php if(isset($book['author'])): ?>
                                <p class="text-muted"><small>by <?php echo e($book['author']); ?></small></p>
                            <?php endif; ?>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0">$<?php echo e(number_format($book['price'], 2)); ?></span>
                                <a href="<?php echo e(route('books.show', $book['id'])); ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-lg-12">
                    <p class="text-center">No books available at this time.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/books/index.blade.php ENDPATH**/ ?>