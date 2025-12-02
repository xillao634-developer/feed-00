@extends('layouts.user')

@section('title', 'My Profile')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">My Profile</h1>
    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
    </a>
</div>

<div class="row">
    <!-- Left Column: Profile Info -->
    <div class="col-lg-4">
        <!-- Profile Card -->
        <div class="card mb-4">
            <div class="card-body text-center">
                <!-- Profile Picture -->
                <div class="mb-3">
                    <div class="profile-picture position-relative mx-auto" style="width: 150px; height: 150px;">
                        <div class="avatar-circle bg-primary text-white w-100 h-100 rounded-circle d-flex align-items-center justify-content-center" 
                             style="font-size: 4rem;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <button class="btn btn-sm btn-light rounded-circle position-absolute bottom-0 end-0" 
                                style="width: 40px; height: 40px;" 
                                data-bs-toggle="modal" data-bs-target="#changeAvatarModal">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                </div>

                <h4 class="card-title">{{ Auth::user()->name }}</h4>
                <p class="text-muted mb-1">
                    <i class="fas fa-envelope me-2"></i>{{ Auth::user()->email }}
                </p>
                <p class="text-muted">
                    <i class="fas fa-user-tag me-2"></i>
                    <span class="text-capitalize">{{ str_replace('_', ' ', Auth::user()->role) }}</span>
                </p>
                
                @if(Auth::user()->department)
                    <p class="text-muted">
                        <i class="fas fa-building me-2"></i>
                        {{ Auth::user()->department->name }}
                    </p>
                @endif

                <div class="mt-3">
                    <span class="badge bg-success">
                        <i class="fas fa-circle me-1"></i> Active
                    </span>
                    <span class="badge bg-info ms-2">
                        Member since {{ Auth::user()->created_at->format('M Y') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">Your Activity</h6>
            </div>
            <div class="card-body">
                <div class="activity-stats">
                    <div class="stat-item d-flex justify-content-between mb-3">
                        <div>
                            <i class="fas fa-comments text-primary me-2"></i>
                            <span>Total Feedback</span>
                        </div>
                        <strong>{{ $totalFeedback ?? 0 }}</strong>
                    </div>
                    <div class="stat-item d-flex justify-content-between mb-3">
                        <div>
                            <i class="fas fa-clock text-warning me-2"></i>
                            <span>Pending</span>
                        </div>
                        <strong>{{ $pendingFeedback ?? 0 }}</strong>
                    </div>
                    <div class="stat-item d-flex justify-content-between mb-3">
                        <div>
                            <i class="fas fa-spinner text-info me-2"></i>
                            <span>In Progress</span>
                        </div>
                        <strong>{{ $inProgressFeedback ?? 0 }}</strong>
                    </div>
                    <div class="stat-item d-flex justify-content-between">
                        <div>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Resolved</span>
                        </div>
                        <strong>{{ $resolvedFeedback ?? 0 }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Status -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Account Status</h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Email Verified
                        </div>
                        @if(Auth::user()->email_verified_at)
                            <span class="badge bg-success">Verified</span>
                        @else
                            <button class="btn btn-sm btn-outline-warning">Verify</button>
                        @endif
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <i class="fas fa-shield-alt text-primary me-2"></i>
                            2FA Status
                        </div>
                        <span class="badge bg-secondary">Disabled</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <i class="fas fa-bell text-info me-2"></i>
                            Notifications
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" checked>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Edit Forms -->
    <div class="col-lg-8">
        <!-- Profile Update Form -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-edit me-2"></i>Edit Profile Information
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('user.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number (Optional)</label>
                        <input type="tel" class="form-control" id="phone" name="phone" 
                               value="{{ old('phone', Auth::user()->phone) }}" 
                               placeholder="+1234567890">
                    </div>

                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio (Optional)</label>
                        <textarea class="form-control" id="bio" name="bio" rows="3" 
                                  placeholder="Tell us about yourself...">{{ old('bio', Auth::user()->bio) }}</textarea>
                        <small class="text-muted">Maximum 200 characters</small>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Profile information is used to personalize your experience and communicate with you.
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password Form -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-key me-2"></i>Change Password
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('user.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password *</label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password" required>
                            <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password *</label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="password-strength mt-2">
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar" id="passwordStrength" style="width: 0%;"></div>
                            </div>
                            <small class="text-muted" id="passwordHint">
                                Password strength: Very Weak
                            </small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password *</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_confirmation" 
                                   name="password_confirmation" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="mt-2" id="passwordMatch"></div>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Important:</strong> Use a strong password with at least 8 characters, including uppercase, lowercase, numbers, and symbols.
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning" id="updatePasswordBtn" disabled>
                            <i class="fas fa-key me-2"></i> Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Notification Preferences -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bell me-2"></i>Notification Preferences
                </h5>
            </div>
            <div class="card-body">
                <form id="notificationForm">
                    <div class="mb-3">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                            <label class="form-check-label" for="emailNotifications">
                                Email Notifications
                            </label>
                            <small class="d-block text-muted">
                                Receive email updates about your feedback status
                            </small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="smsNotifications">
                            <label class="form-check-label" for="smsNotifications">
                                SMS Notifications
                            </label>
                            <small class="d-block text-muted">
                                Receive SMS updates (requires verified phone number)
                            </small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="newsletter" checked>
                            <label class="form-check-label" for="newsletter">
                                Newsletter & Updates
                            </label>
                            <small class="d-block text-muted">
                                Receive monthly newsletter and system updates
                            </small>
                        </div>
                    </div>

                    <div class="alert alert-success d-none" id="notificationSuccess">
                        <i class="fas fa-check-circle me-2"></i>
                        Notification preferences updated successfully!
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-primary" id="saveNotifications">
                            <i class="fas fa-save me-2"></i> Save Preferences
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Change Avatar Modal -->
<div class="modal fade" id="changeAvatarModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="avatar-circle bg-primary text-white mx-auto mb-3" 
                         style="width: 100px; height: 100px; font-size: 3rem;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <p class="text-muted">Upload a new profile picture or choose an avatar</p>
                </div>

                <form id="avatarForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Upload Image</label>
                        <input type="file" class="form-control" id="avatar" name="avatar" 
                               accept="image/jpeg,image/png,image/gif">
                        <small class="text-muted">Max size: 2MB. Formats: JPG, PNG, GIF</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Or choose an avatar color</label>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-primary rounded-circle avatar-color" 
                                    data-color="primary" style="width: 40px; height: 40px;"></button>
                            <button type="button" class="btn btn-success rounded-circle avatar-color" 
                                    data-color="success" style="width: 40px; height: 40px;"></button>
                            <button type="button" class="btn btn-info rounded-circle avatar-color" 
                                    data-color="info" style="width: 40px; height: 40px;"></button>
                            <button type="button" class="btn btn-warning rounded-circle avatar-color" 
                                    data-color="warning" style="width: 40px; height: 40px;"></button>
                            <button type="button" class="btn btn-danger rounded-circle avatar-color" 
                                    data-color="danger" style="width: 40px; height: 40px;"></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveAvatar">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Danger Zone -->
<div class="card border-danger mt-4">
    <div class="card-header bg-danger text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-exclamation-triangle me-2"></i>Danger Zone
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6>Deactivate Account</h6>
                <p class="text-muted small">
                    Temporarily deactivate your account. You can reactivate it later by logging in.
                </p>
                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deactivateModal">
                    <i class="fas fa-user-slash me-2"></i> Deactivate Account
                </button>
            </div>
            <div class="col-md-6 border-start">
                <h6>Delete Account</h6>
                <p class="text-muted small">
                    Permanently delete your account and all associated data. This action cannot be undone.
                </p>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                    <i class="fas fa-trash-alt me-2"></i> Delete Account
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Deactivate Account Modal -->
<div class="modal fade" id="deactivateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>Deactivate Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <h6>What happens when you deactivate your account?</h6>
                    <ul class="mb-0">
                        <li>Your profile will be hidden from the system</li>
                        <li>You will not receive any notifications</li>
                        <li>Your feedback will remain in the system</li>
                        <li>You can reactivate by logging in again</li>
                    </ul>
                </div>
                <p>Are you sure you want to deactivate your account?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning">Deactivate Account</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Delete Account Permanently
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h6>This action cannot be undone!</h6>
                    <p class="mb-0">All your data will be permanently deleted including:</p>
                    <ul class="mb-0">
                        <li>Your profile information</li>
                        <li>All feedback submissions</li>
                        <li>Comments and activity history</li>
                        <li>Notification preferences</li>
                    </ul>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">
                        Type "DELETE" to confirm:
                    </label>
                    <input type="text" class="form-control" id="deleteConfirm" 
                           placeholder="Type DELETE here">
                </div>
                
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="confirmDelete">
                    <label class="form-check-label" for="confirmDelete">
                        I understand this action is permanent and cannot be reversed
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn" disabled>
                    <i class="fas fa-trash-alt me-2"></i> Delete Account Permanently
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .profile-picture {
        width: 150px;
        height: 150px;
    }
    
    .avatar-circle {
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    
    .stat-item {
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }
    
    .stat-item:last-child {
        border-bottom: none;
    }
    
    .password-strength .progress-bar {
        transition: width 0.3s;
    }
    
    #passwordMatch {
        font-size: 0.875rem;
    }
    
    .avatar-color {
        border: 3px solid transparent;
    }
    
    .avatar-color:hover, .avatar-color.active {
        border-color: #000;
        transform: scale(1.1);
    }
</style>
@endpush

@push('scripts')
<script>
    // Toggle password visibility
    document.getElementById('toggleCurrentPassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('current_password');
        const icon = this.querySelector('i');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
        const passwordInput = document.getElementById('password_confirmation');
        const icon = this.querySelector('i');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    // Password strength checker
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const strengthBar = document.getElementById('passwordStrength');
        const strengthHint = document.getElementById('passwordHint');
        const updateBtn = document.getElementById('updatePasswordBtn');
        
        let strength = 0;
        let hint = 'Very Weak';
        let color = '#dc3545'; // Red
        let width = 0;

        // Check password length
        if (password.length >= 8) strength++;
        if (password.length >= 12) strength++;

        // Check for mixed case
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;

        // Check for numbers
        if (/\d/.test(password)) strength++;

        // Check for special characters
        if (/[^A-Za-z0-9]/.test(password)) strength++;

        // Update progress bar and hint
        switch(strength) {
            case 0:
                width = 0; hint = 'Very Weak'; color = '#dc3545';
                break;
            case 1:
                width = 25; hint = 'Weak'; color = '#dc3545';
                break;
            case 2:
                width = 50; hint = 'Fair'; color = '#fd7e14';
                break;
            case 3:
                width = 75; hint = 'Good'; color = '#ffc107';
                break;
            case 4:
            case 5:
                width = 100; hint = 'Strong'; color = '#28a745';
                break;
        }

        strengthBar.style.width = width + '%';
        strengthBar.style.backgroundColor = color;
        strengthHint.textContent = 'Password strength: ' + hint;
        
        // Check if passwords match
        const confirmPassword = document.getElementById('password_confirmation').value;
        const matchElement = document.getElementById('passwordMatch');
        
        if (confirmPassword) {
            if (password === confirmPassword) {
                matchElement.innerHTML = '<span class="text-success"><i class="fas fa-check-circle me-1"></i>Passwords match</span>';
                updateBtn.disabled = false;
            } else {
                matchElement.innerHTML = '<span class="text-danger"><i class="fas fa-times-circle me-1"></i>Passwords do not match</span>';
                updateBtn.disabled = true;
            }
        }
    });

    // Check password confirmation
    document.getElementById('password_confirmation').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmPassword = this.value;
        const matchElement = document.getElementById('passwordMatch');
        const updateBtn = document.getElementById('updatePasswordBtn');
        
        if (confirmPassword) {
            if (password === confirmPassword) {
                matchElement.innerHTML = '<span class="text-success"><i class="fas fa-check-circle me-1"></i>Passwords match</span>';
                updateBtn.disabled = false;
            } else {
                matchElement.innerHTML = '<span class="text-danger"><i class="fas fa-times-circle me-1"></i>Passwords do not match</span>';
                updateBtn.disabled = true;
            }
        } else {
            matchElement.innerHTML = '';
            updateBtn.disabled = true;
        }
    });

    // Avatar color selection
    document.querySelectorAll('.avatar-color').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.avatar-color').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
        });
    });

    // Save notification preferences
    document.getElementById('saveNotifications').addEventListener('click', function() {
        const successElement = document.getElementById('notificationSuccess');
        
        // Simulate API call
        setTimeout(() => {
            successElement.classList.remove('d-none');
            setTimeout(() => {
                successElement.classList.add('d-none');
            }, 3000);
        }, 500);
    });

    // Delete account confirmation
    document.getElementById('deleteConfirm').addEventListener('input', function() {
        const confirmCheckbox = document.getElementById('confirmDelete');
        const deleteBtn = document.getElementById('confirmDeleteBtn');
        
        if (this.value.toUpperCase() === 'DELETE' && confirmCheckbox.checked) {
            deleteBtn.disabled = false;
        } else {
            deleteBtn.disabled = true;
        }
    });

    document.getElementById('confirmDelete').addEventListener('change', function() {
        const confirmInput = document.getElementById('deleteConfirm');
        const deleteBtn = document.getElementById('confirmDeleteBtn');
        
        if (confirmInput.value.toUpperCase() === 'DELETE' && this.checked) {
            deleteBtn.disabled = false;
        } else {
            deleteBtn.disabled = true;
        }
    });

    // Save avatar
    document.getElementById('saveAvatar').addEventListener('click', function() {
        // Implement avatar upload logic here
        alert('Avatar update functionality would be implemented here');
        $('#changeAvatarModal').modal('hide');
    });

    // Character counter for bio
    document.getElementById('bio').addEventListener('input', function() {
        const charCount = this.value.length;
        const counter = document.getElementById('bioCounter') || 
                       (() => {
                           const div = document.createElement('div');
                           div.id = 'bioCounter';
                           div.className = 'form-text';
                           this.parentNode.appendChild(div);
                           return div;
                       })();
        
        counter.textContent = `${charCount}/200 characters`;
        
        if (charCount > 200) {
            counter.classList.add('text-danger');
            counter.classList.remove('text-success');
            this.value = this.value.substring(0, 200);
        } else if (charCount > 150) {
            counter.classList.add('text-warning');
            counter.classList.remove('text-success');
        } else {
            counter.classList.add('text-success');
            counter.classList.remove('text-danger', 'text-warning');
        }
    });
</script>
@endpush
@endsection