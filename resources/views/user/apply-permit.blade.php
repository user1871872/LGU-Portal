@extends('layouts.user')

@section('content')

<div class="container py-5">
    

    <h2 class="text-center fw-bold mb-4">Apply for Business Permit</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <form action="{{ route('apply-permit.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf

        <!-- Proprietor's Information -->
        <div class="card shadow-sm p-4 mb-4">
            <h4 class="mb-3">Proprietor's Information</h4>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ auth()->user()->first_name }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Middle Name</label>
                    <input type="text" name="middle_name" class="form-control" placeholder="Middle Name">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{ auth()->user()->last_name }}" required>

                </div>
            </div>
        </div>

        <!-- Business Information -->
        <div class="card shadow-sm p-4 mb-4">
            <h4 class="mb-3">Business Information</h4>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Business Name</label>
                    <input type="text" name="business_name" class="form-control" placeholder="Business Name" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Line of Business</label>
                    <input type="text" name="line_of_business" class="form-control" placeholder="Type of Business" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Business Address</label>
                    <input type="text" name="business_address" class="form-control" placeholder="Business Address" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Official Receipt (OR) Number</label>
                    <input type="text" name="or_number" class="form-control" placeholder="OR Number" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Amount Paid</label>
                    <input type="number" name="amount_paid" class="form-control" placeholder="Amount Paid" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Contact Number</label>
                    <input type="text" name="contact_number" class="form-control" placeholder="e.g. 912-345-6789" required>
                </div>
            </div>
        </div>

        <!-- Upload Required Documents -->
        <div class="card shadow-sm p-4 mb-4">
            <h4 class="mb-3">Upload Required Documents</h4>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Sanitary Permit</label>
                    <input type="file" name="sanitary_permit" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Barangay Permit</label>
                    <input type="file" name="barangay_permit" class="form-control">
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary px-4 py-2">Submit Application</button>
        </div>
    </form>

</div>

@endsection
