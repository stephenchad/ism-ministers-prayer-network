@extends('front.layouts.app')

@section('main')
<section class="breadcrumbs-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-content">
                    <h2>My Books</h2>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('books.index') }}">Books</a></li>
                        <li>My Books</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="my-books-section section-padding">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(isset($error))
            <div class="alert alert-danger">{{ $error }}</div>
        @endif

        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3>Your Purchased Books</h3>
                    <a href="{{ route('books.index') }}" class="btn btn-primary">Browse More Books</a>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse($orders as $order)
                <div class="col-lg-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    @if(isset($order['book']['cover_image']))
                                        <img src="{{ $order['book']['cover_image'] }}" class="img-fluid" alt="{{ $order['book']['title'] }}">
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h5>{{ $order['book']['title'] ?? 'Book' }}</h5>
                                    @if(isset($order['book']['author']))
                                        <p class="text-muted">by {{ $order['book']['author'] }}</p>
                                    @endif
                                    <p><small class="text-muted">Purchased: {{ \Carbon\Carbon::parse($order['purchased_at'])->format('M d, Y') }}</small></p>
                                </div>
                                <div class="col-md-4 text-right">
                                    <a href="{{ route('commerce.download', ['orderId' => $order['order_id']]) }}" 
                                       class="btn btn-success btn-lg download-btn"
                                       data-order-id="{{ $order['order_id'] }}">
                                        <i class="fa fa-download"></i> Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-lg-12">
                    <div class="alert alert-info text-center">
                        <p class="mb-3">You haven't purchased any books yet.</p>
                        <a href="{{ route('books.index') }}" class="btn btn-primary">Browse Books</a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection

@push('scripts')
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
@endpush
