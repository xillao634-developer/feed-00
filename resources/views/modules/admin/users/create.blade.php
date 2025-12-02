@extends('layouts.admin')

@section('title', 'Add New User')
@section('admin-content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">
                    <i class="fas fa-user-plus me-2"></i>Add New User
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    
                    <!-- Personal Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-user me-2"></i>Personal Information
                            </h6>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Account Settings -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-cog me-2"></i>Account Settings
                            </h6>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Minimum 8 characters with letters and numbers.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select @error('role') is-invalid @enderror" 
                                    id="role" name="role" required>
                                <option value="">Select Role</option>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                <option value="department_head" {{ old('role') == 'department_head' ? 'selected' : '' }}>Department Head</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="department_id" class="form-label">Department</label>
                            <select class="form-select @error('department_id') is-invalid @enderror" 
                                    id="department_id" name="department_id">
                                <option value="">No Department</option>
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
                                Required for Department Head role.
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-info-circle me-2"></i>Additional Information
                            </h6>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Account Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" 
                                       id="is_active" name="is_active" value="1" checked>
                                <label class="form-check-label" for="is_active">
                                    Active Account
                                </label>
                            </div>
                            <div class="form-text">
                                Inactive users cannot log in to the system.
                            </div>
                        </div>
                    </div>

                    <!-- Email Notification -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                   id="send_welcome_email" name="send_welcome_email" value="1" checked>
                            <label class="form-check-label" for="send_welcome_email">
                                Send welcome email with login credentials
                            </label>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Users
                        </a>
                        <div class="btn-group">
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="fas fa-redo me-1"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Create User
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Role Information Card -->
        <div class="card shadow mt-4">
            <div class="card-header bg-light py-3">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Role Information
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="border-start border-primary border-4 ps-3">
                            <h6 class="text-primary mb-1">User</h6>
                            <p class="small text-muted mb-0">
                                Can submit feedback and view their own submissions.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="border-start border-warning border-4 ps-3">
                            <h6 class="text-warning mb-1">Department Head</h6>
                            <p class="small text-muted mb-0">
                                Can manage feedback assigned to their department.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="border-start border-danger border-4 ps-3">
                            <h6 class="text-danger mb-1">Administrator</h6>
                            <p class="small text-muted mb-0">
                                Full access to all system features and user management.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Dynamic department requirement based on role
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const departmentSelect = document.getElementById('department_id');
        const departmentHelp = departmentSelect.nextElementSibling;

        function updateDepartmentRequirement() {
            if (roleSelect.value === 'department_head') {
                departmentSelect.required = true;
                departmentHelp.textContent = 'Department Head must be assigned to a department.';
                departmentHelp.classList.remove('text-muted');
                departmentHelp.classList.add('text-warning');
            } else {
                departmentSelect.required = false;
                departmentHelp.textContent = 'Optional for User and Admin roles.';
                departmentHelp.classList.remove('text-warning');
                departmentHelp.classList.add('text-muted');
            }
        }

        roleSelect.addEventListener('change', updateDepartmentRequirement);
        updateDepartmentRequirement(); // Initial check

        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const passwordHelp = document.createElement('div');
        passwordHelp.className = 'form-text';
        passwordInput.parentNode.appendChild(passwordHelp);

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 'Weak';
            let color = 'text-danger';

            if (password.length >= 8) {
                if (/[A-Z]/.test(password) && /[0-9]/.test(password) && /[^A-Za-z0-9]/.test(password)) {
                    strength = 'Strong';
                    color = 'text-success';
                } else if (/[A-Z]/.test(password) || /[0-9]/.test(password)) {
                    strength = 'Medium';
                    color = 'text-warning';
                }
            }

            passwordHelp.innerHTML = `Password strength: <span class="${color}">${strength}</span>`;
        });
    });
</script>
@endpush
@endsection