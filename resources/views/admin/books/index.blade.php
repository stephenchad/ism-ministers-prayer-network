@extends('admin.layouts.app')

@section('title', 'Books Management')

@section('main')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-white">Books Management</h1>
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Book
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(isset($error))
        <div class="alert alert-warning" role="alert">
            {{ $error }}
        </div>
    @endif

    <div class="card bg-white rounded-lg shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.books.index') }}" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search by title or author..." 
                               value="{{ $filters['search'] ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            <option value="prayer" {{ ($filters['category'] ?? '') === 'prayer' ? 'selected' : '' }}>Prayer</option>
                            <option value="worship" {{ ($filters['category'] ?? '') === 'worship' ? 'selected' : '' }}>Worship</option>
                            <option value="devotional" {{ ($filters['category'] ?? '') === 'devotional' ? 'selected' : '' }}>Devotional</option>
                            <option value="theology" {{ ($filters['category'] ?? '') === 'theology' ? 'selected' : '' }}>Theology</option>
                            <option value="life" {{ ($filters['category'] ?? '') === 'life' ? 'selected' : '' }}>Life</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-sync"></i> Reset
                        </a>
                    </div>
                </div>
            </form>

            @if(count($books) > 0)
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
                            @foreach($books as $book)
                                <tr>
                                    <td>{{ $book['id'] ?? 'N/A' }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if(isset($book['cover_image']))
                                                <img src="{{ $book['cover_image'] }}" alt="{{ $book['title'] }}" 
                                                     class="rounded me-3" style="width: 50px; height: 70px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 70px;">
                                                    <i class="fas fa-book text-white"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <strong>{{ $book['title'] }}</strong>
                                                @if(isset($book['details']['format']))
                                                    <br><small class="text-muted">{{ $book['details']['format'] }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $book['author'] }}</td>
                                    <td>
                                        @if(isset($book['details']['category']))
                                            <span class="badge bg-info">{{ ucfirst($book['details']['category']) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($book['price']))
                                            <strong>${{ number_format($book['price'], 2) }}</strong>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $book['details']['language'] ?? 'English' }}
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.books.show', $book['id']) }}" 
                                               class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.books.edit', $book['id']) }}" 
                                               class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.books.destroy', $book['id']) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this book?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if(isset($pagination))
                    <nav aria-label="Books pagination" class="mt-4">
                        <ul class="pagination justify-content-center mb-0">
                            @if($pagination['current_page'] > 1)
                                <li class="page-item">
                                    <a class="page-link" href="{{ route('admin.books.index', ['page' => $pagination['current_page'] - 1] + $filters) }}">
                                        Previous
                                    </a>
                                </li>
                            @endif
                            
                            @for($i = 1; $i <= $pagination['total_pages']; $i++)
                                <li class="page-item {{ $i === $pagination['current_page'] ? 'active' : '' }}">
                                    <a class="page-link" href="{{ route('admin.books.index', ['page' => $i] + $filters) }}">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endfor

                            @if($pagination['current_page'] < $pagination['total_pages'])
                                <li class="page-item">
                                    <a class="page-link" href="{{ route('admin.books.index', ['page' => $pagination['current_page'] + 1] + $filters) }}">
                                        Next
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-book fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No books found.</p>
                    <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Your First Book
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
