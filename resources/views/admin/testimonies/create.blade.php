@extends('admin.layouts.app')

@section('main')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Add Testimony</h1>
        <a href="{{ route('admin.testimonies') }}" class="btn btn-secondary">Back to Testimonies</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.testimonies.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" name="location" id="location" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" id="category" class="form-control" required>
                                <option value="">Select Category</option>
                                <option value="Healing">Healing</option>
                                <option value="Financial Breakthrough">Financial Breakthrough</option>
                                <option value="Salvation">Salvation</option>
                                <option value="Deliverance">Deliverance</option>
                                <option value="Answered Prayer">Answered Prayer</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="testimony" class="form-label">Testimony</label>
                    <textarea name="testimony" id="testimony" class="form-control" rows="8" required></textarea>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="allow_publish" id="allow_publish" value="1" checked>
                        <label class="form-check-label" for="allow_publish">Allow to publish</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Create Testimony</button>
            </form>
        </div>
    </div>
</div>
@endsection