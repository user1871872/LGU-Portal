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
</style>

<nav class="navbar navbar-dark bg-dark fixed-top shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand fw-bold" href="/">LGU-ANDA Business Portal</a>
        <div>
            @guest
                
                <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
            @else
                
                <div class="dropdown">
                    <a class="btn btn-outline-light dropdown-toggle d-flex align-items-center" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ Auth::user()->profile_image ?? 'https://via.placeholder.com/30' }}" alt="User" class="rounded-circle me-2" width="30" height="30">
                        <span class="fw-bold">{{ strtok(Auth::user()->name, ' ') }}</span> <!-- Display only the first name -->
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <!-- Dashboard Link (Based on Role) -->
                        <li>
                            <a class="dropdown-item" href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <!-- Logout -->
                        <li>
                            <a class="dropdown-item text-danger" href="#" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                               Logout
                            </a>
                        </li>
                    </ul>
                </div>

                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endguest
        </div>
    </div>
</nav>

