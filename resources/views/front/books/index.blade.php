@extends('front.layouts.app')

@section('main')
<section class="breadcrumbs-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-content">
                    <h2>Digital Books</h2>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>Books</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="books-section section-padding">
    <div class="container">
        @if(isset($error))
            <div class="alert alert-danger">{{ $error }}</div>
        @endif

        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3>Available Books</h3>
                    <a href="{{ route('books.my-books') }}" class="btn btn-primary">My Books</a>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse($books as $book)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        @if(isset($book['cover_image']))
                            <img src="{{ $book['cover_image'] }}" class="card-img-top" alt="{{ $book['title'] }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $book['title'] }}</h5>
                            <p class="card-text">{{ Str::limit($book['description'] ?? '', 100) }}</p>
                            @if(isset($book['author']))
                                <p class="text-muted"><small>by {{ $book['author'] }}</small></p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0">${{ number_format($book['price'], 2) }}</span>
                                <a href="{{ route('books.show', $book['id']) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-lg-12">
                    <p class="text-center">No books available at this time.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
