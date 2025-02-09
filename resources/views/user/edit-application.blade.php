@extends('layouts.user')

@section('content')
<div class="container">
    <h2>Edit Application</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('apply-permit.update', $application->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <h4>Proprietor's Information</h4>
        <div class="row">
            <div class="col-md-4">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" value="{{ $application->first_name }}" required>
            </div>
            <div class="col-md-4">
                <label>Middle Name</label>
                <input type="text" name="middle_name" class="form-control" value="{{ $application->middle_name }}">
            </div>
            <div class="col-md-4">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" value="{{ $application->last_name }}" required>
            </div>
        </div>

        <h4 class="mt-3">Business Information</h4>
        <div class="row">
            <div class="col-md-6">
                <label>Business Name</label>
                <input type="text" name="business_name" class="form-control" value="{{ $application->business_name }}" required>
            </div>
            <div class="col-md-6">
                <label>Line of Business</label>
                <input type="text" name="line_of_business" class="form-control" value="{{ $application->line_of_business }}" required>
            </div>
            <div class="col-md-6">
                <label>Business Address</label>
                <input type="text" name="business_address" class="form-control" value="{{ $application->business_address }}" required>
            </div>
            <div class="col-md-6">
                <label>Official Receipt (OR) Number</label>
                <input type="text" name="or_number" class="form-control" value="{{ $application->or_number }}" required>
            </div>
            <div class="col-md-6">
                <label>Amount Paid</label>
                <input type="number" name="amount_paid" class="form-control" value="{{ $application->amount_paid }}" required>
            </div>
            <div class="col-md-6">
                <label>Contact Number</label>
                <input type="text" name="contact_number" class="form-control" value="{{ $application->contact_number }}" required>
            </div>
        </div>

        <h4 class="mt-3">Upload Required Documents</h4>
        <div class="row">
            <div class="col-md-6">
                <label>Sanitary Permit</label>
                <input type="file" name="sanitary_permit" class="form-control">
                @if($application->sanitary_permit)
                    <p>Current File: <a href="{{ asset('storage/' . $application->sanitary_permit) }}" target="_blank">View File</a></p>
                @endif
            </div>
            <div class="col-md-6">
                <label>Barangay Permit</label>
                <input type="file" name="barangay_permit" class="form-control">
                @if($application->barangay_permit)
                    <p>Current File: <a href="{{ asset('storage/' . $application->barangay_permit) }}" target="_blank">View File</a></p>
                @endif
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-3">Update Application</button>
    </form>
</div>
@endsection
