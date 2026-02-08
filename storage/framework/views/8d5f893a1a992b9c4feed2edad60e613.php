<?php $__env->startSection('main'); ?>
<section class="breadcrumbs-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-content">
                    <h2><?php echo e($book['title']); ?></h2>
                    <ul>
                        <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
                        <li><a href="<?php echo e(route('books.browse')); ?>">Books</a></li>
                        <li><?php echo e($book['title']); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="book-detail-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <?php if(isset($book['cover_image'])): ?>
                    <img src="<?php echo e($book['cover_image']); ?>" class="img-fluid" alt="<?php echo e($book['title']); ?>">
                <?php endif; ?>
            </div>
            <div class="col-lg-7">
                <h2><?php echo e($book['title']); ?></h2>
                <?php if(isset($book['author'])): ?>
                    <p class="text-muted">by <?php echo e($book['author']); ?></p>
                <?php endif; ?>
                
                <div class="book-description mt-4">
                    <p><?php echo e($book['description'] ?? ''); ?></p>
                </div>

                <?php if(isset($book['details'])): ?>
                    <div class="book-details mt-4">
                        <?php if(isset($book['details']['pages'])): ?>
                            <p><strong>Pages:</strong> <?php echo e($book['details']['pages']); ?></p>
                        <?php endif; ?>
                        <?php if(isset($book['details']['format'])): ?>
                            <p><strong>Format:</strong> <?php echo e($book['details']['format']); ?></p>
                        <?php endif; ?>
                        <?php if(isset($book['details']['language'])): ?>
                            <p><strong>Language:</strong> <?php echo e($book['details']['language']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="book-purchase mt-5">
                    <h3 class="mb-3">$<?php echo e(number_format($book['price'], 2)); ?></h3>
                    
                    <?php if(auth()->check()): ?>
                        <?php if($alreadyOwned): ?>
                            <div class="alert alert-success">
                                <i class="fa fa-check-circle"></i> You already own this book
                            </div>
                            <a href="<?php echo e(route('books.my-books')); ?>" class="btn btn-primary btn-lg">View My Books</a>
                        <?php else: ?>
                            <button type="button" class="btn btn-success btn-lg" id="buyNowBtn" data-book-id="<?php echo e($book['id']); ?>" onclick="console.log('Buy Now clicked'); initiateCheckout('<?php echo e($book['id']); ?>');">
                                <i class="fa fa-shopping-cart"></i> Buy Now
                            </button>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> Please log in to purchase this book
                        </div>
                        <a href="<?php echo e(route('account.login')); ?>?redirect=<?php echo e(urlencode(request()->fullUrl())); ?>" class="btn btn-primary btn-lg">
                            <i class="fa fa-sign-in"></i> Login to Purchase
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Checkout Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Complete Your Purchase</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="checkoutLoader" class="text-center py-5">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-3">Preparing checkout...</p>
                </div>
                <iframe id="checkoutIframe" style="display:none; width:100%; height:500px; border:none;"></iframe>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('customJS'); ?>
<script>
// Global function to initiate checkout
function initiateCheckout(bookId) {
    console.log('initiateCheckout called with bookId:', bookId);
    
    if (!bookId) {
        console.error('No book ID provided');
        alert('Error: No book ID provided');
        return;
    }
    
    const checkoutModalEl = document.getElementById('checkoutModal');
    if (!checkoutModalEl) {
        console.error('Checkout modal not found!');
        alert('Error: Checkout modal not found');
        return;
    }
    
    // Check if bootstrap is available
    if (typeof bootstrap === 'undefined') {
        console.error('Bootstrap is not loaded!');
        alert('Error: Bootstrap JS is not loaded. Please refresh the page.');
        return;
    }
    
    const checkoutModal = new bootstrap.Modal(checkoutModalEl);
    const checkoutIframe = document.getElementById('checkoutIframe');
    const checkoutLoader = document.getElementById('checkoutLoader');
    
    console.log('Showing checkout modal...');
    checkoutModal.show();
    
    checkoutIframe.style.display = 'none';
    checkoutLoader.style.display = 'block';
    checkoutLoader.querySelector('p').textContent = 'Preparing checkout...';

    fetch('<?php echo e(route("commerce.checkout.create")); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({ book_id: bookId })
    })
    .then(response => {
        console.log('Checkout response status:', response.status);
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Checkout response data:', data);
        if (data.success) {
            window.orderId = data.order_id;
            checkoutIframe.src = data.checkout_url;
            checkoutIframe.style.display = 'block';
            checkoutLoader.style.display = 'none';
            
            // Start polling for order status
            startStatusPolling();
        } else {
            alert('Failed to initiate checkout: ' + (data.message || 'Unknown error'));
            checkoutModal.hide();
        }
    })
    .catch(error => {
        console.error('Checkout error:', error);
        alert('An error occurred. Please try again. Error: ' + error.message);
        checkoutModal.hide();
    });
}

function startStatusPolling() {
    // Poll every 3 seconds
    window.statusCheckInterval = setInterval(checkOrderStatus, 3000);
}

function checkOrderStatus() {
    if (!window.orderId) return;

    fetch('<?php echo e(route("commerce.checkout.status")); ?>?order_id=' + window.orderId, {
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.status === 'completed') {
            clearInterval(window.statusCheckInterval);
            const checkoutModalEl = document.getElementById('checkoutModal');
            const checkoutModal = new bootstrap.Modal(checkoutModalEl);
            checkoutModal.hide();
            window.location.href = '<?php echo e(route("books.my-books")); ?>';
        }
    })
    .catch(error => {
        console.error('Status check error:', error);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded');
    
    const checkoutModalEl = document.getElementById('checkoutModal');
    if (checkoutModalEl) {
        checkoutModalEl.addEventListener('hidden.bs.modal', function() {
            if (window.statusCheckInterval) {
                clearInterval(window.statusCheckInterval);
            }
            const checkoutIframe = document.getElementById('checkoutIframe');
            if (checkoutIframe) checkoutIframe.src = '';
        });
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/books/show.blade.php ENDPATH**/ ?>