@extends('layouts.admin')

@section('title', 'Create Category')
@section('admin-content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">
                    <i class="fas fa-plus-circle me-2"></i>Create New Category
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    
                    <!-- Category Information -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fas fa-info-circle me-2"></i>Category Information
                        </h6>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="e.g., Academic, Facilities, Technical Support" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3"
                                      placeholder="Brief description of this category...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Category Settings -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fas fa-palette me-2"></i>Category Settings
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="color" class="form-label">Color <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror" 
                                           id="color" name="color" value="{{ old('color', '#6c757d') }}" required>
                                    <input type="text" class="form-control" 
                                           id="color_hex" value="{{ old('color', '#6c757d') }}" 
                                           placeholder="#6c757d" readonly>
                                </div>
                                @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    This color will be used in charts and category badges.
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="department_id" class="form-label">Department</label>
                                <select class="form-select @error('department_id') is-invalid @enderror" 
                                        id="department_id" name="department_id">
                                    <option value="">General Category (All Departments)</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" 
                                            {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Leave empty for general categories available to all departments.
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" 
                                       id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active Category
                                </label>
                            </div>
                            <div class="form-text">
                                Inactive categories won't be available for new feedback submissions.
                            </div>
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fas fa-eye me-2"></i>Preview
                        </h6>
                        <div class="preview-card border rounded p-3 bg-light">
                            <div class="d-flex align-items-center mb-2">
                                <div class="category-color-preview me-2" 
                                     style="width: 16px; height: 16px; background-color: {{ old('color', '#6c757d') }}; border-radius: 3px;">
                                </div>
                                <span class="fw-semibold" id="preview-name">Category Name</span>
                                <span class="badge bg-secondary ms-2" id="preview-department">General</span>
                            </div>
                            <p class="text-muted small mb-0" id="preview-description">Category description will appear here.</p>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Categories
                        </a>
                        <div class="btn-group">
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="fas fa-redo me-1"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Create Category
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tips Card -->
        <div class="card shadow mt-4">
            <div class="card-header bg-light py-3">
                <h6 class="mb-0">
                    <i class="fas fa-lightbulb me-2"></i>Category Best Practices
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <strong>Be specific:</strong> Use clear, descriptive names
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <strong>Use colors wisely:</strong> Different colors help visual identification
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <strong>Department-specific:</strong> Assign categories to relevant departments
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <strong>Keep it organized:</strong> Limit categories to essential types
                    </li>
                    <li class="mb-0">
                        <i class="fas fa-check text-success me-2"></i>
                        <strong>Review regularly:</strong> Archive unused categories
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const descriptionInput = document.getElementById('description');
        const colorInput = document.getElementById('color');
        const colorHexInput = document.getElementById('color_hex');
        const departmentSelect = document.getElementById('department_id');
        
        const previewName = document.getElementById('preview-name');
        const previewDescription = document.getElementById('preview-description');
        const previewColor = document.querySelector('.category-color-preview');
        const previewDepartment = document.getElementById('preview-department');

        // Update preview in real-time
        function updatePreview() {
            previewName.textContent = nameInput.value || 'Category Name';
            previewDescription.textContent = descriptionInput.value || 'Category description will appear here.';
            previewColor.style.backgroundColor = colorInput.value;
            colorHexInput.value = colorInput.value;
            
            const selectedDepartment = departmentSelect.options[departmentSelect.selectedIndex];
            previewDepartment.textContent = selectedDepartment.value ? selectedDepartment.text : 'General';
        }

        // Add event listeners
        nameInput.addEventListener('input', updatePreview);
        descriptionInput.addEventListener('input', updatePreview);
        colorInput.addEventListener('input', updatePreview);
        departmentSelect.addEventListener('change', updatePreview);

        // Sync color inputs
        colorInput.addEventListener('input', function() {
            colorHexInput.value = this.value;
        });

        colorHexInput.addEventListener('input', function() {
            if (this.value.match(/^#[0-9A-F]{6}$/i)) {
                colorInput.value = this.value;
                updatePreview();
            }
        });

        // Initial preview update
        updatePreview();
    });
</script>

<style>
    .form-control-color {
        height: 45px;
        padding: 0.375rem;
    }
    
    .preview-card {
        transition: all 0.3s ease;
    }
    
    .category-color-preview {
        transition: background-color 0.3s ease;
    }
</style>
@endpush
@endsection