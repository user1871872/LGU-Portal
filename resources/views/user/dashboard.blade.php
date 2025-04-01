@extends('layouts.user')

@section('content')

<div class="container py-5">
    <div class="mb-4 text-center">
    <h2 class="fw-bold">
    Welcome back, 
    <strong>
        {{ Auth::user()->first_name ?? '' }}
        {{ Auth::user()->middle_name ?? '' }}
        {{ Auth::user()->last_name ?? 'Guest' }}
    </strong>!
</h2>

        <p class="text-muted">Here's a summary of your recent applications.</p>
    </div>

    <!-- Application Statistics -->
    <div class="row justify-content-center g-4">
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-4">
                <h4><i class="bi bi-folder"></i> Total Applications</h4>
                <h2>{{ $totalApplications ?? 0 }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-4">
                <h4><i class="bi bi-check-circle text-success"></i> Approved</h4>
                <h2>{{ $approvedApplications ?? 0 }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-4">
                <h4><i class="bi bi-hourglass-split text-warning"></i> Pending</h4>
                <h2>{{ $pendingApplications ?? 0 }}</h2>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-center mt-4 gap-3">
        <a href="{{ route('apply-permit') }}" class="btn btn-dark px-4">Apply for a Permit</a>
        <a href="{{ route('user.transactions') }}" class="btn btn-outline-dark px-4">View Transactions</a>
    </div>
</div>

@endsection
