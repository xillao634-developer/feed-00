<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            <i class="fas fa-comments me-2"></i>Feedback Portal
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                @auth
                    @if(Auth::user()->hasRole('admin'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                            </a>
                        </li>
                    @elseif(Auth::user()->hasRole('department_head'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('department.dashboard') }}">
                                <i class="fas fa-building me-1"></i>Dashboard
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.dashboard') }}">
                                <i class="fas fa-user me-1"></i>Dashboard
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto">
                @auth
                    <!-- Notifications -->
                    <li class="nav-item dropdown">
                        <a class="nav-link position-relative" href="#" id="notificationsDropdown" 
                           role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">Notifications</h6></li>
                            @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                                <li>
                                    <a class="dropdown-item" href="#" onclick="markNotificationAsRead('{{ $notification->id }}')">
                                        <div class="small text-truncate">{{ $notification->data['message'] }}</div>
                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </a>
                                </li>
                            @empty
                                <li><a class="dropdown-item text-muted" href="#">No new notifications</a></li>
                            @endforelse
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-center" href="{{ route('notifications.index') }}">View All</a></li>
                        </ul>
                    </li>

                    <!-- User Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" 
                           role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user me-2"></i>Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>