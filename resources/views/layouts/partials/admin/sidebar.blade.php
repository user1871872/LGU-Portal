<!-- Sidebar -->
<nav class="col-md-2 bg-dark sidebar vh-100 d-flex flex-column">
    <div class="sidebar-sticky py-3 text-center">
        <img src="{{ asset('images/logo.jpg') }}" alt="LGU Anda" class="mb-3 rounded-circle" width="80">
    </div>
    <ul class="nav flex-column mt-4">
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active bg-primary' : '' }}"
                href="{{ route('admin.dashboard') }}">
                <i class="bi bi-house-door"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('admin.applications') ? 'active bg-primary' : '' }}"
                href="{{ route('admin.applications') }}">
                <i class="bi bi-folder"></i> Applications
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('pk-certificates.index') ? 'active bg-primary' : '' }}"
                href="{{ route('pk-certificates.index') }}">
                <i class="bi bi-file-earmark"></i> Business Permit
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('admin.business-types') ? 'active bg-primary' : '' }}"
                href="{{ route('admin.business-types') }}">
                <i class="bi bi-file-earmark-text"></i> Business Type
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('reports.index') ? 'active bg-primary' : '' }}"
                href="{{ route('reports.index') }}">
                <i class="bi bi-bar-chart"></i> Reports
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('admin.archive') ? 'active bg-primary' : '' }}"
                href="{{ route('admin.archive') }}">
                <i class="bi bi-archive"></i> Directory
            </a>
        </li>
    </ul>
</nav>
