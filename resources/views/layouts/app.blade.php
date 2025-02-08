<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LGU-ANDA Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">LGU-ANDA Business Portal</a>
        <div>
            @guest
                <!-- Show Login and Register if the user is NOT logged in -->
                <a href="{{ route('login') }}" class="btn btn-outline-light">Login</a>
                <a href="" class="btn btn-primary">Register</a>
            @else
                <!-- Show User Profile Image and Logout if Logged In -->
                <div class="dropdown">
                    <a class="btn btn-outline-light dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ Auth::user()->profile_image ?? 'https://via.placeholder.com/30' }}" alt="User" class="rounded-circle" width="30" height="30">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="#" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                               Logout
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Hidden Logout Form -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endguest
        </div>
    </div>
</nav>

    
    <main class="py-4">
        @yield('content')
    </main>
    <main class="">
        @yield('dashboard')
    </main>
    <main class="">
        @yield('apply-permit')
    </main>
    <main class="">
        @yield('transaction')
    </main>
    <footer class="bg-dark text-white text-center py-3">
        &copy; 2024 LGU-ANDA. All rights reserved.
    </footer>
</body>
</html>
