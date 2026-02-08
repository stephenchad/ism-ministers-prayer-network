@extends('admin.layouts.app')

@section('main')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Translations</h1>
        <a href="{{ route('admin.translations.create') }}" class="btn btn-primary">Add New Translation</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by key..." value="{{ is_string(request('search')) ? request('search') : '' }}">
                </div>
                <div class="col-md-4">
                    <select name="group" class="form-control">
                        <option value="">All Groups</option>
                        @foreach($groups as $group)
                            <option value="{{ $group }}" {{ request('group') == $group ? 'selected' : '' }}>{{ $group }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-secondary">Filter</button>
                    <a href="{{ route('admin.translations.index') }}" class="btn btn-outline-secondary">Clear</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Group</th>
                            <th>Key</th>
                            <th>English</th>
                            <th>Spanish</th>
                            <th>French</th>
                            <th>Portuguese</th>
                            <th>German</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($translations as $translation)
                        <tr>
                            <td><span class="badge bg-info">{{ $translation->group }}</span></td>
                            <td><code>{{ $translation->key }}</code></td>
                            <td>{{ Str::limit(is_array($translation->text) ? ($translation->text['en'] ?? '') : '', 30) }}</td>
                            <td>{{ Str::limit(is_array($translation->text) ? ($translation->text['es'] ?? '') : '', 30) }}</td>
                            <td>{{ Str::limit(is_array($translation->text) ? ($translation->text['fr'] ?? '') : '', 30) }}</td>
                            <td>{{ Str::limit(is_array($translation->text) ? ($translation->text['pt'] ?? '') : '', 30) }}</td>
                            <td>{{ Str::limit(is_array($translation->text) ? ($translation->text['de'] ?? '') : '', 30) }}</td>
                            <td>
                                <a href="{{ route('admin.translations.edit', $translation->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.translations.destroy', $translation->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this translation?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No translations found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $translations->links() }}
        </div>
    </div>
</div>
@endsection
