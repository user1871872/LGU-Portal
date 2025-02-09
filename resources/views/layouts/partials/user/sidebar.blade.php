
<div class="sidebar">
    <h4 class="text-center">LGU-ANDA</h4>
    <ul class="nav flex-column mt-4">
        <li class="nav-item">
            <a class="nav-link text-white active" href="{{ route('user.dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a>
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
