<?php $__env->startSection('main'); ?>
<section class="breadcrumbs-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-content">
                    <h2>My Books</h2>
                    <ul>
                        <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
                        <li><a href="<?php echo e(route('books.index')); ?>">Books</a></li>
                        <li>My Books</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="my-books-section section-padding">
    <div class="container">
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?php echo e($error); ?></div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3>Your Purchased Books</h3>
                    <a href="<?php echo e(route('books.index')); ?>" class="btn btn-primary">Browse More Books</a>
                </div>
            </div>
        </div>

        <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-lg-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <?php if(isset($order['book']['cover_image'])): ?>
                                        <img src="<?php echo e($order['book']['cover_image']); ?>" class="img-fluid" alt="<?php echo e($order['book']['title']); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <h5><?php echo e($order['book']['title'] ?? 'Book'); ?></h5>
                                    <?php if(isset($order['book']['author'])): ?>
                                        <p class="text-muted">by <?php echo e($order['book']['author']); ?></p>
                                    <?php endif; ?>
                                    <p><small class="text-muted">Purchased: <?php echo e(\Carbon\Carbon::parse($order['purchased_at'])->format('M d, Y')); ?></small></p>
                                </div>
                                <div class="col-md-4 text-right">
                                    <a href="<?php echo e(route('commerce.download', ['orderId' => $order['order_id']])); ?>" 
                                       class="btn btn-success btn-lg download-btn"
                                       data-order-id="<?php echo e($order['order_id']); ?>">
                                        <i class="fa fa-download"></i> Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-lg-12">
                    <div class="alert alert-info text-center">
                        <p class="mb-3">You haven't purchased any books yet.</p>
                        <a href="<?php echo e(route('books.index')); ?>" class="btn btn-primary">Browse Books</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const downloadButtons = document.querySelectorAll('.download-btn');
    
    downloadButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Optional: Track download analytics
            const orderId = this.dataset.orderId;
            console.log('Downloading order:', orderId);
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/books/my-books.blade.php ENDPATH**/ ?>