@extends('admin.layouts.app')

@section('main')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Testimony</h1>
        <a href="{{ route('admin.testimonies') }}" class="btn btn-secondary">Back to Testimonies</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.testimonies.update', $testimony->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $testimony->name }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $testimony->email }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" name="location" id="location" class="form-control" value="{{ $testimony->location }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" id="category" class="form-control" required>
                                <option value="">Select Category</option>
                                <option value="Healing" {{ $testimony->category == 'Healing' ? 'selected' : '' }}>Healing</option>
                                <option value="Financial Breakthrough" {{ $testimony->category == 'Financial Breakthrough' ? 'selected' : '' }}>Financial Breakthrough</option>
                                <option value="Salvation" {{ $testimony->category == 'Salvation' ? 'selected' : '' }}>Salvation</option>
                                <option value="Deliverance" {{ $testimony->category == 'Deliverance' ? 'selected' : '' }}>Deliverance</option>
                                <option value="Answered Prayer" {{ $testimony->category == 'Answered Prayer' ? 'selected' : '' }}>Answered Prayer</option>
                                <option value="Other" {{ $testimony->category == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ $testimony->title }}" required>
                </div>

                <div class="mb-3">
                    <label for="testimony" class="form-label">Testimony</label>
                    <textarea name="testimony" id="testimony" class="form-control" rows="8" required>{{ $testimony->testimony }}</textarea>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="allow_publish" id="allow_publish" value="1" {{ $testimony->allow_publish ? 'checked' : '' }}>
                        <label class="form-check-label" for="allow_publish">Allow to publish</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Testimony</button>
            </form>
        </div>
    </div>
</div>
@endsection