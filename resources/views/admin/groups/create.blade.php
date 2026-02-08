@extends('admin.layouts.app')

@section('main')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Validation Errors:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px 30px; border: none;">
                    <h4 class="mb-0" style="font-weight: 600;">Create Prayer Group</h4>
                </div>
                <div class="card-body" style="padding: 40px;">
                    <form action="{{ route('admin.groups.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Group Name</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" style="border-radius: 15px; padding: 15px;" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Country</label>
                                    <select name="country_id" id="country_id" class="form-control @error('country_id') is-invalid @enderror" style="border-radius: 15px; padding: 15px;" required>
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">City</label>
                                    <select name="city_id" id="city_id" class="form-control @error('city_id') is-invalid @enderror" style="border-radius: 15px; padding: 15px;" required>
                                        <option value="">Select City</option>
                                    </select>
                                    @error('city_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Address</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" style="border-radius: 15px; padding: 15px;" value="{{ old('address') }}">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" style="border-radius: 15px; padding: 15px;" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Group Leader</label>
                                    <select name="user_id" class="form-control" style="border-radius: 15px; padding: 15px;" required>
                                        <option value="">Select Leader</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Max Members</label>
                                    <input type="number" name="max_members" class="form-control" style="border-radius: 15px; padding: 15px;" min="2" max="1000" value="50" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Category</label>
                                    <input type="text" name="category_name" class="form-control" style="border-radius: 15px; padding: 15px;" placeholder="Enter Category" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Group Type</label>
                                    <input type="text" name="group_type_name" class="form-control" style="border-radius: 15px; padding: 15px;" placeholder="Enter Group Type" required>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden field for current_members -->
                        <input type="hidden" name="current_members" id="current_members" value="1">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.groups') }}" class="btn btn-secondary" style="border-radius: 25px; padding: 12px 30px;">Cancel</a>
                            <button type="submit" class="btn btn-primary" style="border-radius: 25px; padding: 12px 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">Create Group</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for dynamic city loading -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#country_id').on('change', function() {
            const countryId = $(this).val();
            const citySelect = $('#city_id');
            
            if (countryId) {
                citySelect.html('<option value="">Loading cities...</option>').prop('disabled', true);
                
                const url = '{{ route("admin.groups.getCities") }}';
                console.log('Fetching cities from:', url + '?country_id=' + countryId);
                
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: { country_id: countryId },
                    dataType: 'json',
                    success: function(data) {
                        console.log('Cities loaded successfully:', data);
                        citySelect.html('<option value="">Select City</option>').prop('disabled', false);
                        
                        if (data.length > 0) {
                            $.each(data, function(index, city) {
                                citySelect.append($('<option>', {
                                    value: city.id,
                                    text: city.name
                                }));
                            });
                        } else {
                            citySelect.html('<option value="">No cities available</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading cities:', error);
                        console.error('Status:', status);
                        console.error('Response:', xhr.responseText);
                        citySelect.html('<option value="">Error loading cities</option>').prop('disabled', false);
                        alert('Error loading cities!\n\nStatus: ' + status + '\nError: ' + error + '\n\nCheck browser console (F12) for more details.');
                    }
                });
            } else {
                citySelect.html('<option value="">Select City</option>').prop('disabled', false);
            }
        });
    });
</script>
@endsection
