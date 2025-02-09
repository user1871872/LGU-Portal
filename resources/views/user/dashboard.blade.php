@extends('layouts.user')

@section('content')

<div class="container py-5">
    
    <!-- Welcome Message -->
    <div class="mb-4 text-center">
        <h2 class="fw-bold">Welcome back, <strong>{{ Auth::user()->name ?? 'Guest' }}</strong>!</h2>
        <p class="text-muted">We hope you're having a great day. Here's a summary of your recent activity.</p>
        <div class="alert alert-info">
            <strong>Heads up!</strong> Your most recent application is still under review. Stay tuned for updates.
        </div>
    </div>

    <!-- Dashboard Stats -->
    <div class="row justify-content-center g-4">
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-4">
                <h4><i class="bi bi-folder"></i> Total Applications</h4>
                <h2>5</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-4">
                <h4><i class="bi bi-check-circle text-success"></i> Approved Applications</h4>
                <h2 class="text-success">3</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-4">
                <h4><i class="bi bi-hourglass-split text-warning"></i> Pending Applications</h4>
                <h2 class="text-warning">2</h2>
            </div>
        </div>
    </div>

    <!-- Buttons -->
    <div class="d-flex justify-content-center mt-4 gap-3">
        <a href="{{ route('apply-permit') }}" class="btn btn-dark px-4">Apply for a Permit</a>
        <a href="{{ route('user.transactions') }}"" class="btn btn-outline-dark px-4">View Transactions</a>
    </div>

</div>

@endsection
