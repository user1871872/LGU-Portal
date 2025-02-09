<!-- Sidebar -->
<nav class="col-md-2 bg-dark sidebar vh-100 d-flex flex-column">
    <div class="sidebar-sticky py-3">
        <h4 class="text-white text-center mt-3">LGU-ANDA</h4>
        <ul class="nav flex-column mt-4">
            <li class="nav-item">
                <a class="nav-link text-white active" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('admin.applications') }}">
                    <i class="bi bi-folder"></i> Applications
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">
                    <i class="bi bi-file-earmark"></i> Business Permit
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">
                    <i class="bi bi-bar-chart"></i> Reports
                </a>
            </li>
        </ul>
    </div>
</nav>
