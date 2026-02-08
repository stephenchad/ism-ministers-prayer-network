@extends('admin.layouts.app')

@section('main')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #333; font-weight: 700;">Add New Radio Station</h2>
        <a href="{{ route('admin.radios') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Radio Stations
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card" style="border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="card-body" style="padding: 40px;">
                    <form action="{{ route('admin.radios.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333;">Station Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required style="border-radius: 8px; padding: 12px 15px;">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333;">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" style="border-radius: 8px; padding: 12px 15px;">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333;">Stream URL *</label>
                            <input type="text" name="stream_url" class="form-control @error('stream_url') is-invalid @enderror" value="{{ old('stream_url') }}" required style="border-radius: 8px; padding: 12px 15px;">
                            @error('stream_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Enter the radio stream URL</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #333;">Genre</label>
                                <input type="text" name="genre" class="form-control @error('genre') is-invalid @enderror" value="{{ old('genre') }}" placeholder="e.g., Gospel, Worship, Teaching" style="border-radius: 8px; padding: 12px 15px;">
                                @error('genre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #333;">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', 0) }}" style="border-radius: 8px; padding: 12px 15px;">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active" style="font-weight: 600; color: #333;">
                                    Active
                                </label>
                            </div>
                        </div>

                        <!-- Schedule Section -->
                        <div class="mb-4">
                            <h5 style="color: #333; font-weight: 600; margin-bottom: 20px;">Weekly Schedule</h5>
                            <div id="schedule-container" data-old-schedules="{{ json_encode(old('schedules', [])) }}">
                                <div class="schedule-item border rounded p-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <select name="schedules[0][day_of_week]" class="form-control">
                                                <option value="">Day</option>
                                                <option value="monday">Monday</option>
                                                <option value="tuesday">Tuesday</option>
                                                <option value="wednesday">Wednesday</option>
                                                <option value="thursday">Thursday</option>
                                                <option value="friday">Friday</option>
                                                <option value="saturday">Saturday</option>
                                                <option value="sunday">Sunday</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="time" name="schedules[0][start_time]" class="form-control" placeholder="Start">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="time" name="schedules[0][end_time]" class="form-control" placeholder="End">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="schedules[0][program_name]" class="form-control" placeholder="Program Name">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="schedules[0][host_name]" class="form-control" placeholder="Host">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeSchedule(this)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addSchedule()">
                                <i class="fas fa-plus me-1"></i>Add Schedule
                            </button>
                        </div>

                        <div class="d-flex gap-3">
                            <button type="submit" class="btn flex-fill" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600;">
                                <i class="fas fa-save me-2"></i>Create Station
                            </button>
                            <a href="{{ route('admin.radios') }}" class="btn btn-outline-secondary flex-fill" style="padding: 12px 25px; border-radius: 8px; font-weight: 600;">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let scheduleIndex = 1;

// Repopulate schedules from old input data
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('schedule-container');
    const oldSchedulesData = container.getAttribute('data-old-schedules');
    
    if (oldSchedulesData) {
        try {
            const oldSchedules = JSON.parse(oldSchedulesData);
            
            if (Array.isArray(oldSchedules) && oldSchedules.length > 1) { // More than the initial empty field
                // Remove the initial schedule item
                container.innerHTML = '';
                
                // Repopulate with old data
                oldSchedules.forEach((schedule, index) => {
                    if (schedule && (schedule.day_of_week || schedule.start_time || schedule.end_time)) {
                        addScheduleWithData(index, schedule);
                    }
                });
                
                // Add one empty field at the end
                addSchedule();
            }
        } catch (e) {
            console.error('Error parsing old schedules data:', e);
        }
    }
});

function addScheduleWithData(index, data) {
    const container = document.getElementById('schedule-container');
    const scheduleItem = document.createElement('div');
    scheduleItem.className = 'schedule-item border rounded p-3 mb-3';
    
    // Safely get values, ensuring they're strings
    const dayOfWeek = data.day_of_week && typeof data.day_of_week === 'string' ? data.day_of_week : '';
    const startTime = data.start_time && typeof data.start_time === 'string' ? data.start_time : '';
    const endTime = data.end_time && typeof data.end_time === 'string' ? data.end_time : '';
    const programName = data.program_name && typeof data.program_name === 'string' ? data.program_name : '';
    const hostName = data.host_name && typeof data.host_name === 'string' ? data.host_name : '';
    
    scheduleItem.innerHTML = `
        <div class="row">
            <div class="col-md-2">
                <select name="schedules[${index}][day_of_week]" class="form-control">
                    <option value="">Day</option>
                    <option value="monday" ${dayOfWeek === 'monday' ? 'selected' : ''}>Monday</option>
                    <option value="tuesday" ${dayOfWeek === 'tuesday' ? 'selected' : ''}>Tuesday</option>
                    <option value="wednesday" ${dayOfWeek === 'wednesday' ? 'selected' : ''}>Wednesday</option>
                    <option value="thursday" ${dayOfWeek === 'thursday' ? 'selected' : ''}>Thursday</option>
                    <option value="friday" ${dayOfWeek === 'friday' ? 'selected' : ''}>Friday</option>
                    <option value="saturday" ${dayOfWeek === 'saturday' ? 'selected' : ''}>Saturday</option>
                    <option value="sunday" ${dayOfWeek === 'sunday' ? 'selected' : ''}>Sunday</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="time" name="schedules[${index}][start_time]" class="form-control" placeholder="Start" value="${startTime}">
            </div>
            <div class="col-md-2">
                <input type="time" name="schedules[${index}][end_time]" class="form-control" placeholder="End" value="${endTime}">
            </div>
            <div class="col-md-3">
                <input type="text" name="schedules[${index}][program_name]" class="form-control" placeholder="Program Name" value="${programName}">
            </div>
            <div class="col-md-2">
                <input type="text" name="schedules[${index}][host_name]" class="form-control" placeholder="Host" value="${hostName}">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeSchedule(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(scheduleItem);
    scheduleIndex = Math.max(scheduleIndex, index + 1);
}

function addSchedule() {
    const container = document.getElementById('schedule-container');
    const scheduleItem = document.createElement('div');
    scheduleItem.className = 'schedule-item border rounded p-3 mb-3';
    scheduleItem.innerHTML = `
        <div class="row">
            <div class="col-md-2">
                <select name="schedules[${scheduleIndex}][day_of_week]" class="form-control">
                    <option value="">Day</option>
                    <option value="monday">Monday</option>
                    <option value="tuesday">Tuesday</option>
                    <option value="wednesday">Wednesday</option>
                    <option value="thursday">Thursday</option>
                    <option value="friday">Friday</option>
                    <option value="saturday">Saturday</option>
                    <option value="sunday">Sunday</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="time" name="schedules[${scheduleIndex}][start_time]" class="form-control" placeholder="Start">
            </div>
            <div class="col-md-2">
                <input type="time" name="schedules[${scheduleIndex}][end_time]" class="form-control" placeholder="End">
            </div>
            <div class="col-md-3">
                <input type="text" name="schedules[${scheduleIndex}][program_name]" class="form-control" placeholder="Program Name">
            </div>
            <div class="col-md-2">
                <input type="text" name="schedules[${scheduleIndex}][host_name]" class="form-control" placeholder="Host">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeSchedule(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(scheduleItem);
    scheduleIndex++;
}

function removeSchedule(button) {
    button.closest('.schedule-item').remove();
}
</script>
@endsection