@extends('front.layouts.app')

@section('main')
<section class="breadcrumbs-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-content">
                    <h2>{{ $book['title'] }}</h2>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('books.browse') }}">Books</a></li>
                        <li>{{ $book['title'] }}</li>
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
                @if(isset($book['cover_image']))
                    <img src="{{ $book['cover_image'] }}" class="img-fluid" alt="{{ $book['title'] }}">
                @endif
            </div>
            <div class="col-lg-7">
                <h2>{{ $book['title'] }}</h2>
                @if(isset($book['author']))
                    <p class="text-muted">by {{ $book['author'] }}</p>
                @endif
                
                <div class="book-description mt-4">
                    <p>{{ $book['description'] ?? '' }}</p>
                </div>

                @if(isset($book['details']))
                    <div class="book-details mt-4">
                        @if(isset($book['details']['pages']))
                            <p><strong>Pages:</strong> {{ $book['details']['pages'] }}</p>
                        @endif
                        @if(isset($book['details']['format']))
                            <p><strong>Format:</strong> {{ $book['details']['format'] }}</p>
                        @endif
                        @if(isset($book['details']['language']))
                            <p><strong>Language:</strong> {{ $book['details']['language'] }}</p>
                        @endif
                    </div>
                @endif

                <div class="book-purchase mt-5">
                    <h3 class="mb-3">${{ number_format($book['price'], 2) }}</h3>
                    
                    @if(auth()->check())
                        @if($alreadyOwned)
                            <div class="alert alert-success">
                                <i class="fa fa-check-circle"></i> You already own this book
                            </div>
                            <a href="{{ route('books.my-books') }}" class="btn btn-primary btn-lg">View My Books</a>
                        @else
                            <button type="button" class="btn btn-success btn-lg" id="buyNowBtn" data-book-id="{{ $book['id'] }}" onclick="console.log('Buy Now clicked'); initiateCheckout('{{ $book['id'] }}');">
                                <i class="fa fa-shopping-cart"></i> Buy Now
                            </button>
                        @endif
                    @else
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> Please log in to purchase this book
                        </div>
                        <a href="{{ route('account.login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="btn btn-primary btn-lg">
                            <i class="fa fa-sign-in"></i> Login to Purchase
                        </a>
                    @endif
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

@endsection

@section('customJS')
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

    fetch('{{ route("commerce.checkout.create") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
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

    fetch('{{ route("commerce.checkout.status") }}?order_id=' + window.orderId, {
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.status === 'completed') {
            clearInterval(window.statusCheckInterval);
            const checkoutModalEl = document.getElementById('checkoutModal');
            const checkoutModal = new bootstrap.Modal(checkoutModalEl);
            checkoutModal.hide();
            window.location.href = '{{ route("books.my-books") }}';
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
@endsection
