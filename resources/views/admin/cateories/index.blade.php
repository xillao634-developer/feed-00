@extends('layouts.admin')

@section('title', 'Categories Management')
@section('admin-content')
<div class="card shadow">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-tags me-2"></i>Feedback Categories
        </h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
            <i class="fas fa-plus me-1"></i> Add Category
        </button>
    </div>
    
    <div class="card-body">
        <!-- Categories Stats -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ $categories->count() }}</h4>
                                <small>Total Categories</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-tags fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ $stats['active_categories'] }}</h4>
                                <small>Active Categories</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ $stats['total_feedback'] }}</h4>
                                <small>Total Feedback</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-comments fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ $stats['most_used_category'] ?? 'N/A' }}</h4>
                                <small>Most Used Category</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-chart-line fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th>Feedback Count</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="category-color me-3" 
                                         style="width: 20px; height: 20px; background-color: {{ $category->color }}; border-radius: 4px;">
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $category->name }}</div>
                                        @if($category->department)
                                            <small class="text-muted">
                                                Department: {{ $category->department->name }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted">
                                    {{ $category->description ? Str::limit($category->description, 80) : 'No description' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-primary rounded-pill">
                                    {{ $category->feedbacks_count }} feedback
                                </span>
                            </td>
                            <td>
                                @if($category->is_active)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Active
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times me-1"></i>Inactive
                                    </span>
                                @endif
                            </td>
                            <td>{{ $category->created_at->format('M j, Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editCategoryModal{{ $category->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-info" 
                                            onclick="showCategoryDetails({{ $category->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if($category->feedbacks_count == 0)
                                        <button type="button" class="btn btn-outline-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteCategoryModal{{ $category->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-outline-danger" 
                                                disabled title="Cannot delete category with feedback">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>

                                <!-- Edit Category Modal -->
                                <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Category</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="name{{ $category->id }}" class="form-label">Category Name</label>
                                                        <input type="text" class="form-control" 
                                                               id="name{{ $category->id }}" name="name" 
                                                               value="{{ $category->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="description{{ $category->id }}" class="form-label">Description</label>
                                                        <textarea class="form-control" id="description{{ $category->id }}" 
                                                                  name="description" rows="3">{{ $category->description }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="color{{ $category->id }}" class="form-label">Color</label>
                                                        <input type="color" class="form-control form-control-color" 
                                                               id="color{{ $category->id }}" name="color" 
                                                               value="{{ $category->color }}" title="Choose color">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="department_id{{ $category->id }}" class="form-label">Department</label>
                                                        <select class="form-select" id="department_id{{ $category->id }}" name="department_id">
                                                            <option value="">General Category</option>
                                                            @foreach($departments as $department)
                                                                <option value="{{ $department->id }}" 
                                                                    {{ $category->department_id == $department->id ? 'selected' : '' }}>
                                                                    {{ $department->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" 
                                                               id="is_active{{ $category->id }}" name="is_active" value="1"
                                                               {{ $category->is_active ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="is_active{{ $category->id }}">
                                                            Active Category
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Update Category</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Category Modal -->
                                <div class="modal fade" id="deleteCategoryModal{{ $category->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirm Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete the category 
                                                <strong>"{{ $category->name }}"</strong>? This action cannot be undone.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete Category</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No categories found</h5>
                                    <p class="text-muted">Get started by creating your first feedback category.</p>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                                        <i class="fas fa-plus me-1"></i> Create First Category
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Color <span class="text-danger">*</span></label>
                        <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror" 
                               id="color" name="color" value="{{ old('color', '#6c757d') }}" title="Choose color" required>
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="department_id" class="form-label">Department</label>
                        <select class="form-select @error('department_id') is-invalid @enderror" 
                                id="department_id" name="department_id">
                            <option value="">General Category</option>
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
                            Assign to a department to make it department-specific.
                        </div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" 
                               id="is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">
                            Active Category
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showCategoryDetails(categoryId) {
        // Implement category details view
        window.location.href = `/admin/categories/${categoryId}`;
    }

    // Initialize color pickers
    document.addEventListener('DOMContentLoaded', function() {
        const colorPickers = document.querySelectorAll('input[type="color"]');
        colorPickers.forEach(picker => {
            picker.addEventListener('change', function() {
                this.style.backgroundColor = this.value;
            });
        });
    });
</script>
@endpush
@endsection