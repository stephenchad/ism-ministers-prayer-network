@extends('admin.layouts.app')

@section('title', 'Edit Book')

@section('main')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-white">Edit Book</h1>
        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Books
        </a>
    </div>

    <div class="card bg-white rounded-lg shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.books.update', $book['id']) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Book Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $book['title']) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">Author <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" 
                                   id="author" name="author" value="{{ old('author', $book['author']) }}" required>
                            @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5" required>{{ old('description', $book['description']) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Provide a detailed description of the book.</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="price" class="form-label">Price ($) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                       id="price" name="price" value="{{ old('price', $book['price']) }}" 
                                       step="0.01" min="0" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category">
                                <option value="">Select Category</option>
                                <option value="prayer" {{ old('category', $book['details']['category'] ?? '') === 'prayer' ? 'selected' : '' }}>Prayer</option>
                                <option value="worship" {{ old('category', $book['details']['category'] ?? '') === 'worship' ? 'selected' : '' }}>Worship</option>
                                <option value="devotional" {{ old('category', $book['details']['category'] ?? '') === 'devotional' ? 'selected' : '' }}>Devotional</option>
                                <option value="theology" {{ old('category', $book['details']['category'] ?? '') === 'theology' ? 'selected' : '' }}>Theology</option>
                                <option value="life" {{ old('category', $book['details']['category'] ?? '') === 'life' ? 'selected' : '' }}>Life</option>
                                <option value="other" {{ old('category', $book['details']['category'] ?? '') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="language" class="form-label">Language</label>
                            <select class="form-select @error('language') is-invalid @enderror" id="language" name="language">
                                <option value="">Select Language</option>
                                <option value="English" {{ old('language', $book['details']['language'] ?? '') === 'English' ? 'selected' : '' }}>English</option>
                                <option value="Spanish" {{ old('language', $book['details']['language'] ?? '') === 'Spanish' ? 'selected' : '' }}>Spanish</option>
                                <option value="French" {{ old('language', $book['details']['language'] ?? '') === 'French' ? 'selected' : '' }}>French</option>
                                <option value="German" {{ old('language', $book['details']['language'] ?? '') === 'German' ? 'selected' : '' }}>German</option>
                                <option value="Portuguese" {{ old('language', $book['details']['language'] ?? '') === 'Portuguese' ? 'selected' : '' }}>Portuguese</option>
                            </select>
                            @error('language')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="format" class="form-label">Format</label>
                            <select class="form-select @error('format') is-invalid @enderror" id="format" name="format">
                                <option value="">Select Format</option>
                                <option value="Paperback" {{ old('format', $book['details']['format'] ?? '') === 'Paperback' ? 'selected' : '' }}>Paperback</option>
                                <option value="Hardcover" {{ old('format', $book['details']['format'] ?? '') === 'Hardcover' ? 'selected' : '' }}>Hardcover</option>
                                <option value="eBook" {{ old('format', $book['details']['format'] ?? '') === 'eBook' ? 'selected' : '' }}>eBook</option>
                                <option value="Audiobook" {{ old('format', $book['details']['format'] ?? '') === 'Audiobook' ? 'selected' : '' }}>Audiobook</option>
                            </select>
                            @error('format')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pages" class="form-label">Number of Pages</label>
                            <input type="number" class="form-control @error('pages') is-invalid @enderror" 
                                   id="pages" name="pages" value="{{ old('pages', $book['details']['pages'] ?? '') }}" min="1">
                            @error('pages')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Book
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
