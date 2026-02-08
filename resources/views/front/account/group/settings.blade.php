@extends('front.layouts.app')

@section('main')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-3">
            @include('front.account.sidebar')
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Group Settings: {{ $group->title }}</h4>
                </div>
                <div class="card-body">
                    @include('front.message')

                    {{-- Rules --}}
                    <div class="mb-5">
                        <h5>Rules and Regulations</h5>                        
                        @can('manageSettings', $group)
                            <form action="{{ route('group.settings.rule.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="group_id" value="{{ $group->id }}">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="rule" placeholder="Add a new rule" required>
                                    <button class="btn btn-primary" type="submit">Add Rule</button>
                                </div>
                            </form>
                        @endcan
                        <ul class="list-group">
                            @forelse ($group->rules as $rule)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $rule->rule }}
                                    <div class="d-flex">
                                        @can('manageSettings', $group)
                                            <button class="btn btn-info btn-sm me-2 edit-rule-btn" data-bs-toggle="modal" data-bs-target="#editRuleModal" data-rule-id="{{ $rule->id }}" data-rule-text="{{ $rule->rule }}"><i class="fas fa-edit"></i></button>
                                            <form action="{{ route('group.settings.rule.destroy', $rule->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this rule?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                            </form>
                                        @endcan
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item">No rules have been set for this group.</li>
                            @endforelse
                        </ul>
                    </div>

                    {{-- Events --}}
                    <div class="mb-5">
                        <h5>Upcoming Events</h5>                        
                        @can('manageSettings', $group)
                            <form action="{{ route('group.settings.event.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="group_id" value="{{ $group->id }}">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="event_title" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="event_title" name="title" value="{{ old('title') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="event_location" class="form-label">Location</label>
                                        <input type="text" class="form-control" id="event_location" name="location" value="{{ old('location') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="event_date" class="form-label">Event Date</label>
                                        <input type="datetime-local" class="form-control" id="event_date" name="event_date" value="{{ old('event_date') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="event_end_time" class="form-label">End Time</label>
                                        <input type="datetime-local" class="form-control" id="event_end_time" name="end_time">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="event_description" class="form-label">Description</label>
                                        <textarea class="form-control" id="event_description" name="description" rows="3">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Event</button>
                            </form>
                        @endcan

                        <div class="mt-3">
                            @forelse ($group->events as $event)
                                <div class="list-group-item d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <strong>{{ $event->title }}</strong> ({{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y, h:i A') }})
                                        <p class="mb-0 text-muted">{{ $event->location }}</p>
                                    </div>
                                    <div class="d-flex">
                                        @can('manageSettings', $group)
                                            <button class="btn btn-info btn-sm me-2 edit-event-btn" data-bs-toggle="modal" data-bs-target="#editEventModal" data-event-id="{{ $event->id }}" data-event-title="{{ $event->title }}" data-event-location="{{ $event->location }}" data-event-date="{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d\TH:i') }}" data-event-description="{{ $event->description }}"><i class="fas fa-edit"></i></button>
                                            <form action="{{ route('group.settings.event.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">No events scheduled.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Photos --}}
                    <div class="mb-5">
                        <h5>Photo Gallery</h5>                        
                        @can('managePhotos', $group)
                            <form action="{{ route('group.settings.photo.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="group_id" value="{{ $group->id }}" id="photo-group-id">
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Upload Photo</label>
                                    <input class="form-control" type="file" id="photo" name="photo" required accept="image/*">
                                    <!-- Image Preview Container -->
                                    <div class="mt-3 text-center" id="album-image-preview-container" style="display:none;">
                                        <img id="album-image-preview" src="#" alt="Image Preview" class="img-fluid rounded" style="max-height: 200px; border: 2px dashed #ddd; padding: 5px;">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="caption" class="form-label">Caption</label>
                                    <input type="text" class="form-control" id="caption" name="caption">
                                </div>
                                <button type="submit" class="btn btn-primary">Upload Photo</button>
                            </form>
                        @endcan
                    </div>

                    {{-- Resources --}}
                    <div>
                        <h5>Resource Links</h5>                        
                        @can('manageSettings', $group)
                            <form action="{{ route('group.settings.resource.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="group_id" value="{{ $group->id }}">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="resource_title" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="resource_title" name="title" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="resource_link" class="form-label">Link</label>
                                        <input type="url" class="form-control" id="resource_link" name="link" required>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="resource_description" class="form-label">Description</label>
                                        <textarea class="form-control" id="resource_description" name="description" rows="2"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Resource</button>
                            </form>
                        @endcan
                        <ul class="list-group mt-3">
                            @forelse ($group->resources as $resource)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ $resource->link }}" target="_blank">{{ $resource->title }}</a>
                                    <div class="d-flex">
                                        @can('manageSettings', $group)
                                            <button class="btn btn-info btn-sm me-2 edit-resource-btn" data-bs-toggle="modal" data-bs-target="#editResourceModal" data-resource-id="{{ $resource->id }}" data-resource-title="{{ $resource->title }}" data-resource-link="{{ $resource->link }}"><i class="fas fa-edit"></i></button>
                                            <form action="{{ route('group.settings.resource.destroy', $resource->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this resource?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                            </form>
                                        @endcan
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item">No resources have been added.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Rule Modal -->
<div class="modal fade" id="editRuleModal" tabindex="-1" aria-labelledby="editRuleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRuleModalLabel">Edit Rule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editRuleForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="text" class="form-control" name="rule" id="editRuleText" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Event Modal -->
<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEventModalLabel">Edit Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editEventForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_event_title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="edit_event_title" name="title" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_event_location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="edit_event_location" name="location">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_event_start_time" class="form-label">Start Time</label>
                            <input type="datetime-local" class="form-control" id="edit_event_start_time" name="start_time" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_event_end_time" class="form-label">End Time</label>
                            <input type="datetime-local" class="form-control" id="edit_event_end_time" name="end_time">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="edit_event_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_event_description" name="description" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Resource Modal -->
<div class="modal fade" id="editResourceModal" tabindex="-1" aria-labelledby="editResourceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editResourceModalLabel">Edit Resource</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editResourceForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_resource_title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="edit_resource_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_resource_link" class="form-label">Link</label>
                        <input type="url" class="form-control" id="edit_resource_link" name="link" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('customJS')
<script>
    // Image preview for album photo upload
    $("#photo").change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $("#album-image-preview").attr('src', e.target.result);
                $("#album-image-preview-container").show();
            }
            reader.readAsDataURL(file);
        }
    });

    // Handle Edit Rule Modal
    $('.edit-rule-btn').click(function() {
        var ruleId = $(this).data('rule-id');
        var ruleText = $(this).data('rule-text');
        var url = "{{ route('group.settings.rule.update', ':id') }}";
        url = url.replace(':id', ruleId);
        
        $('#editRuleForm').attr('action', url);
        $('#editRuleText').val(ruleText);
    });

    // Handle Edit Event Modal
    $('.edit-event-btn').click(function() {
        var eventId = $(this).data('event-id');
        var url = "{{ route('group.settings.event.update', ['event' => ':id']) }}";
        url = url.replace(':id', eventId);

        $('#editEventForm').attr('action', url);
        $('#edit_event_title').val($(this).data('event-title'));
        $('#edit_event_location').val($(this).data('event-location'));
        $('#edit_event_date').val($(this).data('event-date'));
        $('#edit_event_description').val($(this).data('event-description'));
    });

    // Handle Edit Resource Modal
    $('.edit-resource-btn').click(function() {
        var resourceId = $(this).data('resource-id');
        var url = "{{ route('group.settings.resource.update', ':id') }}";
        url = url.replace(':id', resourceId);

        $('#editResourceForm').attr('action', url);
        $('#edit_resource_title').val($(this).data('resource-title'));
        $('#edit_resource_link').val($(this).data('resource-link'));
        $('#edit_resource_description').val($(this).data('resource-description'));
    });

</script>
@endsection
