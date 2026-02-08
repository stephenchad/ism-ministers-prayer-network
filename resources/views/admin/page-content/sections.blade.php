@extends('admin.layouts.app')

@section('main')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Page Sections</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSectionModal">
                        <i class="fas fa-plus"></i> Add New Section
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 50px;">Order</th>
                                <th>Key</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Page</th>
                                <th>Status</th>
                                <th style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sections as $section)
                            <tr>
                                <td>{{ $section->sort_order }}</td>
                                <td>{{ $section->key }}</td>
                                <td>{{ $section->title }}</td>
                                <td><span class="badge badge-info">{{ $section->section_type }}</span></td>
                                <td>{{ $section->page }}</td>
                                <td>
                                    @if($section->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editSectionModal{{ $section->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.page-content.sections.destroy', $section->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this section?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editSectionModal{{ $section->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Section</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <form action="{{ route('admin.page-content.sections.update', $section->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Key (unique identifier)</label>
                                                            <input type="text" name="key" class="form-control" value="{{ $section->key }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Title</label>
                                                            <input type="text" name="title" class="form-control" value="{{ $section->title }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Subtitle</label>
                                                    <textarea name="subtitle" class="form-control" rows="2">{{ $section->subtitle }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Content</label>
                                                    <textarea name="content" class="form-control" rows="4">{{ $section->content }}</textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Page</label>
                                                            <select name="page" class="form-control">
                                                                <option value="home" {{ $section->page == 'home' ? 'selected' : '' }}>Home</option>
                                                                <option value="about" {{ $section->page == 'about' ? 'selected' : '' }}>About</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Section Type</label>
                                                            <select name="section_type" class="form-control">
                                                                <option value="default" {{ $section->section_type == 'default' ? 'selected' : '' }}>Default</option>
                                                                <option value="features" {{ $section->section_type == 'features' ? 'selected' : '' }}>Features</option>
                                                                <option value="cta" {{ $section->section_type == 'cta' ? 'selected' : '' }}>Call to Action</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Sort Order</label>
                                                            <input type="number" name="sort_order" class="form-control" value="{{ $section->sort_order }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        <input type="checkbox" name="is_active" value="1" {{ $section->is_active ? 'checked' : '' }}>
                                                        Active
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No sections found. Add your first section!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addSectionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Section</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('admin.page-content.sections.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Key (unique identifier)</label>
                                <input type="text" name="key" class="form-control" placeholder="e.g., how_we_serve" required>
                                <small class="text-muted">Use underscores, no spaces</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Section title" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Subtitle</label>
                        <textarea name="subtitle" class="form-control" rows="2" placeholder="Optional subtitle"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <textarea name="content" class="form-control" rows="4" placeholder="Main content"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Page</label>
                                <select name="page" class="form-control">
                                    <option value="home">Home</option>
                                    <option value="about">About</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Section Type</label>
                                <select name="section_type" class="form-control">
                                    <option value="default">Default</option>
                                    <option value="features">Features</option>
                                    <option value="cta">Call to Action</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="is_active" value="1" checked>
                            Active
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Section</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
