<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LGU-ANDA Portal</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        /* Fix sidebar height */
        .sidebar {
            height: 100vh;
            position: fixed;
            left: 0;
            top: 56px; /* Adjusted for navbar */
            width: 250px;
            background: #343a40;
            color: white;
            padding-top: 20px;
        }

        /* Main content should start after sidebar */
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        /* Center content */
        .dashboard-center {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            height: calc(100vh - 56px);
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">LGU-ANDA Business Portal</a>
        <div>
            @guest
                <!-- Show Login and Register if the user is NOT logged in -->
                <a href="{{ route('login') }}" class="btn btn-outline-light">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
            @else
                <!-- Show User Profile and Logout if Logged In -->
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

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-center">LGU-ANDA</h4>
    <ul class="nav flex-column mt-4">
        <li class="nav-item">
            <a class="nav-link text-white active" href="#"><i class="bi bi-house-door"></i> Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('apply-permit') }}"><i class="bi bi-file-earmark"></i> Apply Permit</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('user.transactions') }}"><i class="bi bi-receipt"></i> Transactions</a>
        </li>
    </ul>
    <div class="text-center text-white mt-auto p-3">
        <small>Logged in as: <strong>{{ Auth::user()->name ?? 'Guest' }}</strong></small>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="dashboard-center">
        <!-- Welcome Section -->
        <div>
            <h2>Welcome back, <strong>{{ Auth::user()->name ?? 'Guest' }}</strong>!</h2>
            <p>We hope you're having a great day. Here's a summary of your recent activity.</p>
            <div class="alert alert-info" role="alert">
                <strong>Heads up!</strong> Your most recent application is still under review. Stay tuned for updates.
            </div>
        </div>

        <!-- Dashboard Stats -->
        <div class="row mt-3 w-100">
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h4><i class="bi bi-folder"></i> Total Applications</h4>
                    <h2>5</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h4><i class="bi bi-check-circle"></i> Approved Applications</h4>
                    <h2 class="text-success">3</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h4><i class="bi bi-hourglass-split"></i> Pending Applications</h4>
                    <h2 class="text-warning">2</h2>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="mt-4">
            <a href="#apply-permit" class="btn btn-dark">Apply for a Permit</a>
            <a href="#" class="btn btn-outline-dark">View Transactions</a>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 fixed-bottom">
    &copy; 2024 LGU-ANDA. All rights reserved.
</footer>

</body>
</html>
