<style>
    body {
        padding-top: 60px;
    }

    .navbar {
        z-index: 1030;
    }

    .dropdown-toggle::after {
        display: none;
    }

    .notification-badge {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: red;
        color: white;
        font-size: 12px;
        padding: 2px 6px;
        border-radius: 50%;
    }

    /* Sidebar Styling */
    .sidebar {
        position: fixed;
        left: 0;
        top: 60px;
        width: 250px;
        height: calc(100vh - 60px);
        background: #212529;
        padding-top: 10px;
        overflow-y: auto;
    }

    .sidebar .nav-link {
        color: white;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 16px;
    }

    .sidebar .nav-link:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    /* Profile Image Styling */
    .profile-image {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        object-fit: cover;
    }

    /* Responsive Design */
    @media (max-width: 991px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
            top: 0;
            padding-top: 10px;
        }
    }
</style>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark fixed-top shadow-sm navbar-expand-lg">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand fw-bold" href="/">LGU-ANDA Business Portal</a>

        <!-- Toggle Button for Mobile Navbar -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content (Collapsible in Mobile) -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                @guest
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                </li>
                @else
                <!-- Visible only on Mobile -->
                <li class="nav-item dropdown d-lg-none">
                    <a class="nav-link dropdown-toggle" href="#" id="mobileUserDropdown" data-bs-toggle="dropdown">
                        <img src="{{ asset('images/profile.png') }}" alt="User" class="profile-image">
                        <span class="fw-bold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="d-none d-lg-block">
                            <a class="dropdown-item" href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}">
                                Dashboard
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Notifications (Visible only on Mobile) -->
                <li class="nav-item dropdown d-lg-none">
                    <a class="nav-link dropdown-toggle" href="#" id="mobileNotificationDropdown" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="notification-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu">
                        @foreach(auth()->user()->notifications as $notification)
                        <li>
                            <a class="dropdown-item {{ $notification->read_at ? 'text-muted' : '' }}"
                                href="{{ route('notifications.markAsRead', $notification->id) }}">
                                {{ $notification->data['message'] }}
                            </a>
                        </li>
                        @endforeach
                        @if(auth()->user()->notifications->isEmpty())
                        <li><a class="dropdown-item text-muted">No notifications</a></li>
                        @endif
                    </ul>
                </li>

                <!-- Sidebar Menu -->
                <li class="nav-item d-lg-none">
                    <hr class="dropdown-divider">
                </li>
                <li class="nav-item d-lg-none">
                    <a class="nav-link" href="{{ route('user.dashboard') }}">
                        <i class="bi bi-house-door"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item d-lg-none">
                    <a class="nav-link" href="{{ route('apply-permit') }}">
                        <i class="bi bi-file-earmark"></i> Apply Permit
                    </a>
                </li>
                <li class="nav-item d-lg-none">
                    <a class="nav-link" href="{{ route('user.transactions') }}">
                        <i class="bi bi-receipt"></i> Transactions
                    </a>
                </li>

                <!-- Desktop Profile & Notifications -->
                <li class="nav-item dropdown d-none d-lg-block">
                    <a class="btn btn-outline-light position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="notification-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach(auth()->user()->notifications as $notification)
                        <li>
                            <a class="dropdown-item {{ $notification->read_at ? 'text-muted' : '' }}"
                                href="{{ route('notifications.markAsRead', $notification->id) }}">
                                {{ $notification->data['message'] }}
                            </a>
                        </li>
                        @endforeach
                        @if(auth()->user()->notifications->isEmpty())
                        <li><a class="dropdown-item text-muted">No notifications</a></li>
                        @endif
                    </ul>
                </li>

                <li class="nav-item dropdown d-none d-lg-block">
                    <a class="btn btn-outline-light dropdown-toggle d-flex align-items-center" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown">
                        <img src="{{ asset('images/profile.png') }}" alt="User" class="profile-image me-2">
                        <span class="fw-bold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>