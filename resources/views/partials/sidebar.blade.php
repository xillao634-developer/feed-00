@auth
<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="position-sticky pt-3">
        @if(Auth::user()->hasRole('admin'))
            <!-- Admin Sidebar -->
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                       href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}" 
                       href="{{ route('admin.feedback.index') }}">
                        <i class="fas fa-comments me-2"></i>All Feedback
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                       href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users me-2"></i>User Management
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
                       href="{{ route('admin.categories.index') }}">
                        <i class="fas fa-tags me-2"></i>Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" 
                       href="{{ route('admin.reports.analytics') }}">
                        <i class="fas fa-chart-bar me-2"></i>Analytics & Reports
                    </a>
                </li>
            </ul>

        @elseif(Auth::user()->hasRole('department_head'))
            <!-- Department Head Sidebar -->
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('department.dashboard') ? 'active' : '' }}" 
                       href="{{ route('department.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('department.feedback.*') ? 'active' : '' }}" 
                       href="{{ route('department.feedback.index') }}">
                        <i class="fas fa-comments me-2"></i>Assigned Feedback
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('department.reports') ? 'active' : '' }}" 
                       href="{{ route('department.reports') }}">
                        <i class="fas fa-chart-bar me-2"></i>Department Reports
                    </a>
                </li>
            </ul>

        @else
            <!-- User Sidebar -->
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" 
                       href="{{ route('user.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('user.feedback.create') ? 'active' : '' }}" 
                       href="{{ route('user.feedback.create') }}">
                        <i class="fas fa-plus-circle me-2"></i>Submit Feedback
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('user.feedback.my') ? 'active' : '' }}" 
                       href="{{ route('user.feedback.my') }}">
                        <i class="fas fa-history me-2"></i>My Feedback
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('user.profile.edit') ? 'active' : '' }}" 
                       href="{{ route('user.profile.edit') }}">
                        <i class="fas fa-user me-2"></i>Profile
                    </a>
                </li>
            </ul>
        @endif
    </div>
</nav>
@endauth