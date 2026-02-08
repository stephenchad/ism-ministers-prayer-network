@extends('admin.layouts.app')

@section('main')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Homepage Sliders</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <button type="button" class="btn btn-primary" id="addSliderBtn">
                        <i class="fas fa-plus"></i> Add New Slider
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

            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 50px;">Order</th>
                                <th>Title</th>
                                <th>Subtitle</th>
                                <th>Button</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th style="width: 200px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sliders as $slider)
                            <tr>
                                <td>{{ $slider->sort_order }}</td>
                                <td>{{ $slider->title }}</td>
                                <td>{{ $slider->subtitle ?? '-' }}</td>
                                <td>
                                    @if($slider->button_text)
                                        <span class="badge badge-info">{{ $slider->button_text }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($slider->desktop_image)
                                        <img src="{{ asset($slider->desktop_image) }}" alt="" style="width: 100px; height: 50px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">No image</span>
                                    @endif
                                </td>
                                <td>
                                    @if($slider->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning edit-slider-btn" data-slider-id="{{ $slider->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.page-content.sliders.destroy', $slider->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this slider?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No sliders found. Add your first slider!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Slider Modal -->
<div class="custom-modal" id="addSliderModal">
    <div class="custom-modal-backdrop" id="addSliderBackdrop"></div>
    <div class="custom-modal-dialog">
        <div class="custom-modal-content">
            <div class="custom-modal-header">
                <h5 class="custom-modal-title">Add New Slider</h5>
                <button type="button" class="custom-modal-close" id="closeAddSliderModal">&times;</button>
            </div>
            <form action="{{ route('admin.page-content.sliders.store') }}" method="POST">
                @csrf
                <input type="hidden" name="page" value="{{ $page }}">
                <div class="custom-modal-body">
                    <div class="form-group">
                        <label>Title *</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter slider title" required>
                    </div>
                    <div class="form-group">
                        <label>Subtitle</label>
                        <input type="text" name="subtitle" class="form-control" placeholder="Enter slider subtitle">
                    </div>
                    <div class="form-group">
                        <label>Button Text</label>
                        <input type="text" name="button_text" class="form-control" placeholder="e.g., Join Now">
                    </div>
                    <div class="form-group">
                        <label>Button URL</label>
                        <input type="text" name="button_url" class="form-control" placeholder="e.g., /register">
                    </div>
                    <div class="form-group">
                        <label>Desktop Image Path</label>
                        <input type="text" name="desktop_image" class="form-control" placeholder="e.g., assets/images/slider/image.jpg">
                        <small class="text-muted">Enter the path relative to public folder</small>
                    </div>
                    <div class="form-group">
                        <label>Mobile Image Path</label>
                        <input type="text" name="mobile_image" class="form-control" placeholder="e.g., assets/images/slider/mobile.jpg">
                        <small class="text-muted">Enter the path relative to public folder</small>
                    </div>
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
                    </div>
                    <div class="form-group">
                        <label class="d-flex align-items-center">
                            <input type="checkbox" name="is_active" value="1" checked style="margin-right: 8px;">
                            Active
                        </label>
                    </div>
                </div>
                <div class="custom-modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelAddSliderBtn">Close</button>
                    <button type="submit" class="btn btn-primary">Create Slider</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Slider Modals -->
@forelse($sliders as $slider)
<div class="custom-modal" id="editSliderModal{{ $slider->id }}">
    <div class="custom-modal-backdrop" id="editSliderBackdrop{{ $slider->id }}"></div>
    <div class="custom-modal-dialog">
        <div class="custom-modal-content">
            <div class="custom-modal-header">
                <h5 class="custom-modal-title">Edit Slider</h5>
                <button type="button" class="custom-modal-close" data-slider-id="{{ $slider->id }}">&times;</button>
            </div>
            <form action="{{ route('admin.page-content.sliders.update', $slider->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="custom-modal-body">
                    <div class="form-group">
                        <label>Title *</label>
                        <input type="text" name="title" class="form-control" value="{{ $slider->title }}" required>
                    </div>
                    <div class="form-group">
                        <label>Subtitle</label>
                        <input type="text" name="subtitle" class="form-control" value="{{ $slider->subtitle }}">
                    </div>
                    <div class="form-group">
                        <label>Button Text</label>
                        <input type="text" name="button_text" class="form-control" value="{{ $slider->button_text }}">
                    </div>
                    <div class="form-group">
                        <label>Button URL</label>
                        <input type="text" name="button_url" class="form-control" value="{{ $slider->button_url }}">
                    </div>
                    <div class="form-group">
                        <label>Desktop Image Path</label>
                        <input type="text" name="desktop_image" class="form-control" value="{{ $slider->desktop_image }}">
                        <small class="text-muted">Enter the path relative to public folder</small>
                    </div>
                    <div class="form-group">
                        <label>Mobile Image Path</label>
                        <input type="text" name="mobile_image" class="form-control" value="{{ $slider->mobile_image }}">
                        <small class="text-muted">Enter the path relative to public folder</small>
                    </div>
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ $slider->sort_order }}">
                    </div>
                    <div class="form-group">
                        <label class="d-flex align-items-center">
                            <input type="checkbox" name="is_active" value="1" {{ $slider->is_active ? 'checked' : '' }} style="margin-right: 8px;">
                            Active
                        </label>
                    </div>
                </div>
                <div class="custom-modal-footer">
                    <button type="button" class="btn btn-secondary" data-slider-id="{{ $slider->id }}">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@empty
@endforelse

<style>
/* Custom Modal Styles */
.custom-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    align-items: center;
    justify-content: center;
}

.custom-modal.show {
    display: flex;
}

.custom-modal-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
}

.custom-modal-dialog {
    position: relative;
    width: 90%;
    max-width: 500px;
    background: var(--admin-bg-card);
    border-radius: var(--admin-border-radius);
    box-shadow: var(--shadow-xl);
    border: 1px solid var(--admin-border-color);
    z-index: 10000;
    max-height: 90vh;
    overflow-y: auto;
}

.custom-modal-content {
    border: none;
}

.custom-modal-header {
    padding: 20px;
    border-bottom: 1px solid var(--admin-border-color);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.custom-modal-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--admin-text-primary);
    margin: 0;
}

.custom-modal-close {
    background: transparent;
    border: none;
    font-size: 28px;
    line-height: 1;
    color: var(--admin-text-muted);
    cursor: pointer;
    padding: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--admin-border-radius-sm);
    transition: all var(--transition-fast);
}

.custom-modal-close:hover {
    background: var(--admin-bg-light);
    color: var(--admin-text-primary);
}

.custom-modal-body {
    padding: 20px;
}

.custom-modal-footer {
    padding: 16px 20px;
    border-top: 1px solid var(--admin-border-color);
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.form-group {
    margin-bottom: 16px;
}

.form-group label {
    display: block;
    margin-bottom: 6px;
    font-weight: 500;
    color: var(--admin-text-primary);
}

.form-group .form-control {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid var(--admin-border-color);
    border-radius: var(--admin-border-radius-sm);
    background: var(--admin-bg-light);
    color: var(--admin-text-primary);
    font-size: 14px;
    transition: all var(--transition-fast);
}

.form-group .form-control:focus {
    outline: none;
    border-color: var(--admin-primary);
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-group small {
    display: block;
    margin-top: 4px;
    font-size: 12px;
}

.badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
}

.badge-info {
    background: #17a2b8;
    color: white;
}

.badge-success {
    background: #28a745;
    color: white;
}

.badge-secondary {
    background: #6c757d;
    color: white;
}

.btn {
    padding: 8px 16px;
    border-radius: var(--admin-border-radius-sm);
    font-weight: 500;
    cursor: pointer;
    border: none;
    transition: all var(--transition-fast);
}

.btn-primary {
    background: linear-gradient(135deg, var(--admin-primary), var(--admin-secondary));
    color: white;
}

.btn-primary:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

.btn-secondary {
    background: var(--admin-bg-light);
    color: var(--admin-text-primary);
    border: 1px solid var(--admin-border-color);
}

.btn-secondary:hover {
    background: var(--admin-border-color);
}

.btn-sm {
    padding: 6px 12px;
    font-size: 12px;
}

.btn-warning {
    background: #ffc107;
    color: #212529;
}

.btn-danger {
    background: #dc3545;
    color: white;
}

.text-right {
    text-align: right;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add Slider Modal
    const addSliderBtn = document.getElementById('addSliderBtn');
    const addSliderModal = document.getElementById('addSliderModal');
    const closeAddSliderModal = document.getElementById('closeAddSliderModal');
    const cancelAddSliderBtn = document.getElementById('cancelAddSliderBtn');
    const addSliderBackdrop = document.getElementById('addSliderBackdrop');

    if (addSliderBtn) {
        addSliderBtn.addEventListener('click', function() {
            addSliderModal.classList.add('show');
            document.body.style.overflow = 'hidden';
        });
    }

    function closeAddModal() {
        addSliderModal.classList.remove('show');
        document.body.style.overflow = '';
    }

    if (closeAddSliderModal) {
        closeAddSliderModal.addEventListener('click', closeAddModal);
    }

    if (cancelAddSliderBtn) {
        cancelAddSliderBtn.addEventListener('click', closeAddModal);
    }

    if (addSliderBackdrop) {
        addSliderBackdrop.addEventListener('click', closeAddModal);
    }

    // Edit Slider Modals
    const editSliderBtns = document.querySelectorAll('.edit-slider-btn');
    
    editSliderBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const sliderId = this.getAttribute('data-slider-id');
            const modal = document.getElementById('editSliderModal' + sliderId);
            if (modal) {
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
        });
    });

    // Close edit modals
    document.querySelectorAll('.custom-modal-close[data-slider-id]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const sliderId = this.getAttribute('data-slider-id');
            const modal = document.getElementById('editSliderModal' + sliderId);
            if (modal) {
                modal.classList.remove('show');
                document.body.style.overflow = '';
            }
        });
    });

    document.querySelectorAll('.custom-modal-footer .btn-secondary[data-slider-id]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const sliderId = this.getAttribute('data-slider-id');
            const modal = document.getElementById('editSliderModal' + sliderId);
            if (modal) {
                modal.classList.remove('show');
                document.body.style.overflow = '';
            }
        });
    });

    document.querySelectorAll('.custom-modal-backdrop[id^="editSliderBackdrop"]').forEach(function(backdrop) {
        backdrop.addEventListener('click', function() {
            const id = this.id.replace('editSliderBackdrop', '');
            const modal = document.getElementById('editSliderModal' + id);
            if (modal) {
                modal.classList.remove('show');
                document.body.style.overflow = '';
            }
        });
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.custom-modal.show').forEach(function(modal) {
                modal.classList.remove('show');
            });
            document.body.style.overflow = '';
        }
    });
});
</script>
@endsection
