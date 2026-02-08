@extends('admin.layouts.app')

@section('main')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Site Statistics</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStatModal">
                        <i class="fas fa-plus"></i> Add New Stat
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

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home-stats">Home Page Stats</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#about-stats">About Page Stats</a>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Home Stats -->
                <div id="home-stats" class="tab-pane active">
                    <div class="card mt-3">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">Order</th>
                                        <th>Key</th>
                                        <th>Label</th>
                                        <th>Value</th>
                                        <th>Icon</th>
                                        <th>Status</th>
                                        <th style="width: 150px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($homeStats as $stat)
                                    <tr>
                                        <td>{{ $stat->sort_order }}</td>
                                        <td>{{ $stat->key }}</td>
                                        <td>{{ $stat->label }}</td>
                                        <td><strong>{{ $stat->value }}</strong></td>
                                        <td><i class="fas {{ $stat->icon }}"></i></td>
                                        <td>
                                            @if($stat->is_active)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editStatModal{{ $stat->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.page-content.stats.destroy', $stat->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this stat?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editStatModal{{ $stat->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Stat</h5>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <form action="{{ route('admin.page-content.stats.update', $stat->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Key (unique identifier)</label>
                                                            <input type="text" name="key" class="form-control" value="{{ $stat->key }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Label</label>
                                                            <input type="text" name="label" class="form-control" value="{{ $stat->label }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Value (e.g., 50K+, 24/7)</label>
                                                            <input type="text" name="value" class="form-control" value="{{ $stat->value }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Icon (Font Awesome class)</label>
                                                            <input type="text" name="icon" class="form-control" value="{{ $stat->icon }}" placeholder="e.g., fa-users">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Description</label>
                                                            <textarea name="description" class="form-control">{{ $stat->description }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Page</label>
                                                            <select name="page" class="form-control">
                                                                <option value="home" {{ $stat->page == 'home' ? 'selected' : '' }}>Home Page</option>
                                                                <option value="about" {{ $stat->page == 'about' ? 'selected' : '' }}>About Page</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Sort Order</label>
                                                            <input type="number" name="sort_order" class="form-control" value="{{ $stat->sort_order }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                <input type="checkbox" name="is_active" value="1" {{ $stat->is_active ? 'checked' : '' }}>
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
                                        <td colspan="7" class="text-center">No home page stats found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- About Stats -->
                <div id="about-stats" class="tab-pane fade">
                    <div class="card mt-3">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">Order</th>
                                        <th>Key</th>
                                        <th>Label</th>
                                        <th>Value</th>
                                        <th>Icon</th>
                                        <th>Status</th>
                                        <th style="width: 150px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($aboutStats as $stat)
                                    <tr>
                                        <td>{{ $stat->sort_order }}</td>
                                        <td>{{ $stat->key }}</td>
                                        <td>{{ $stat->label }}</td>
                                        <td><strong>{{ $stat->value }}</strong></td>
                                        <td><i class="fas {{ $stat->icon }}"></i></td>
                                        <td>
                                            @if($stat->is_active)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editAboutStatModal{{ $stat->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.page-content.stats.destroy', $stat->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this stat?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editAboutStatModal{{ $stat->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Stat</h5>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <form action="{{ route('admin.page-content.stats.update', $stat->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Key (unique identifier)</label>
                                                            <input type="text" name="key" class="form-control" value="{{ $stat->key }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Label</label>
                                                            <input type="text" name="label" class="form-control" value="{{ $stat->label }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Value (e.g., 50K+, 24/7)</label>
                                                            <input type="text" name="value" class="form-control" value="{{ $stat->value }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Icon (Font Awesome class)</label>
                                                            <input type="text" name="icon" class="form-control" value="{{ $stat->icon }}" placeholder="e.g., fa-users">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Description</label>
                                                            <textarea name="description" class="form-control">{{ $stat->description }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Page</label>
                                                            <select name="page" class="form-control">
                                                                <option value="home" {{ $stat->page == 'home' ? 'selected' : '' }}>Home Page</option>
                                                                <option value="about" {{ $stat->page == 'about' ? 'selected' : '' }}>About Page</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Sort Order</label>
                                                            <input type="number" name="sort_order" class="form-control" value="{{ $stat->sort_order }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                <input type="checkbox" name="is_active" value="1" {{ $stat->is_active ? 'checked' : '' }}>
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
                                        <td colspan="7" class="text-center">No about page stats found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addStatModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Stat</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('admin.page-content.stats.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Key (unique identifier)</label>
                        <input type="text" name="key" class="form-control" placeholder="e.g., prayer_partners" required>
                    </div>
                    <div class="form-group">
                        <label>Label</label>
                        <input type="text" name="label" class="form-control" placeholder="e.g., Prayer Partners" required>
                    </div>
                    <div class="form-group">
                        <label>Value (e.g., 50K+, 24/7)</label>
                        <input type="text" name="value" class="form-control" placeholder="e.g., 50K+" required>
                    </div>
                    <div class="form-group">
                        <label>Icon (Font Awesome class)</label>
                        <input type="text" name="icon" class="form-control" placeholder="e.g., fa-users">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" placeholder="Brief description"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Page</label>
                        <select name="page" class="form-control">
                            <option value="home">Home Page</option>
                            <option value="about">About Page</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
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
                    <button type="submit" class="btn btn-primary">Create Stat</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
