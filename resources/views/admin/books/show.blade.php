@extends('admin.layouts.app')

@section('title', $book['title'] ?? 'Book Details')

@section('main')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-white">Book Details</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.books.edit', $book['id']) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Books
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card bg-white rounded-lg shadow-sm">
                <div class="card-body">
                    @if(isset($book['cover_image']))
                        <img src="{{ $book['cover_image'] }}" alt="{{ $book['title'] }}" 
                             class="img-fluid rounded shadow-sm mb-3">
                    @else
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center mb-3" 
                             style="height: 300px;">
                            <i class="fas fa-book fa-5x text-white"></i>
                        </div>
                    @endif
                    
                    <div class="text-center">
                        @if(isset($book['price']))
                            <h3 class="text-primary mb-3">${{ number_format($book['price'], 2) }}</h3>
                        @endif
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.books.edit', $book['id']) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Book
                            </a>
                            <form action="{{ route('admin.books.destroy', $book['id']) }}" 
                                  method="POST" class="d-grid"
                                  onsubmit="return confirm('Are you sure you want to delete this book?');">
                                @csrf
                                @method('DELETE')
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
                    <h2 class="card-title mb-3">{{ $book['title'] }}</h2>
                    <p class="text-muted mb-4">
                        <i class="fas fa-user"></i> By {{ $book['author'] }}
                    </p>

                    <div class="mb-4">
                        <h5 class="mb-2">Description</h5>
                        <p class="card-text">{{ $book['description'] }}</p>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Book Details</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Category:</span>
                                <span class="fw-bold">
                                    @if(isset($book['details']['category']))
                                        {{ ucfirst($book['details']['category']) }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Language:</span>
                                <span class="fw-bold">
                                    {{ $book['details']['language'] ?? 'English' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Format:</span>
                                <span class="fw-bold">
                                    @if(isset($book['details']['format']))
                                        {{ $book['details']['format'] }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Pages:</span>
                                <span class="fw-bold">
                                    @if(isset($book['details']['pages']) && $book['details']['pages'] > 0)
                                        {{ number_format($book['details']['pages']) }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    @if(isset($book['created_at']))
                        <div class="mt-4 pt-3 border-top">
                            <small class="text-muted">
                                <i class="fas fa-calendar"></i> Created: {{ \Carbon\Carbon::parse($book['created_at'])->format('F j, Y g:i A') }}
                                @if(isset($book['updated_at']) && $book['updated_at'] !== $book['created_at'])
                                    <br>
                                    <i class="fas fa-edit"></i> Last Updated: {{ \Carbon\Carbon::parse($book['updated_at'])->format('F j, Y g:i A') }}
                                @endif
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
