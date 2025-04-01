@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <div class="card p-4 shadow-lg">
        <h2 class="mb-4 text-center text-primary fw-bold">Edit Permit Application</h2>

        <!-- ✅ Session Messages -->
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <form action="{{ route('apply-permit.update', $application->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- 🔹 Personal Information -->
            <h4 class="mb-3 text-secondary">Personal Information</h4>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $application->first_name) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Middle Name</label>
                    <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name', $application->middle_name) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $application->last_name) }}" required>
                </div>
            </div>

            <!-- 🔹 Business Information -->
            <h4 class="mt-4 mb-3 text-secondary">Business Information</h4>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Business Name</label>
                    <input type="text" name="business_name" class="form-control" value="{{ old('business_name', $application->business_name) }}" required>
                </div>
                <!-- <div class="col-md-6">
                    <label class="form-label fw-bold">Line of Business</label>
                    <input type="text" name="line_of_business" class="form-control" value="{{ old('line_of_business', $application->line_of_business) }}" required>
                </div> -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">Contact Number</label>
                    <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $application->contact_number) }}" required>
                </div>
            </div>

            <!-- 🔹 Address Information -->
            <h4 class="mt-4 mb-3 text-secondary">Address Information</h4>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Province</label>
                    <select name="province" id="province" class="form-select">
                        <option value="" disabled>📍 Select Province</option>
                        @foreach ($provinces as $province)
                        <option value="{{ $province['name'] }}" data-code="{{ $province['code'] }}"
                            {{ old('province', optional($application->address)->province_id) == $province['name'] ? 'selected' : '' }}>
                            {{ $province['name'] }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Town / City</label>
                    <select name="town" id="town" class="form-select">
                        <option value="" disabled selected>🏙️ Select Town</option>
                        @foreach ($towns as $town)
                        <option value="{{ $town->name }}" {{ old('town', $application->town) == $town->name ? 'selected' : '' }}>
                            {{ $town->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Barangay</label>
                    <select name="barangay" id="barangay" class="form-select">
                        <option value="" disabled selected>🏡 Select Barangay</option>
                        @foreach ($barangays as $barangay)
                        <option value="{{ $barangay->name }}" {{ old('barangay', $application->barangay) == $barangay->name ? 'selected' : '' }}>
                            {{ $barangay->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Street</label>
                    <input type="text" name="street" class="form-control" value="{{ old('street', optional($application->address)->street) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Postal Code</label>
                    <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', optional($application->address)->postal_code) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Country</label>
                    <input type="text" name="country" class="form-control" value="{{ old('country', optional($application->address)->country ?? 'Philippines') }}">
                </div>
            </div>

            <!-- 🔹 File Uploads -->
            <h4 class="mt-4 mb-3 text-secondary">Upload Documents</h4>
            <div class="row g-3">
                @php
                $documents = ['sanitary_permit', 'barangay_permit', 'dti_certificate', 'official_receipt', 'police_clearance', 'tourism_compliance_certificate'];
                @endphp

                @foreach ($documents as $doc)
                <div class="col-md-6">
                    <label class="form-label fw-bold">{{ ucwords(str_replace('_', ' ', $doc)) }}</label>
                    @if($application->documents->isNotEmpty() && $application->documents->first()->$doc)
                    <p>Current File: <a href="{{ asset($application->documents->first()->$doc) }}" target="_blank">View</a></p>
                    @endif
                    <input type="file" name="{{ $doc }}" class="form-control">
                </div>
                @endforeach
            </div>

            <!-- 🔹 Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg mt-4 w-50">Update Application</button>
            </div>
        </form>
    </div>
</div>

<!-- ✅ jQuery & AJAX for dynamic location selection -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $("#province").change(function() {
            let provinceCode = $(this).find(':selected').data('code');
            $("#town").html('<option value="">Loading...</option>');
            $("#barangay").html('<option value="">Select Barangay</option>');

            $.get(`/get-municipalities?province_code=${provinceCode}`, function(data) {
                $("#town").html('<option value="" disabled selected>🏙️ Select Town</option>');
                $.each(data, function(index, town) {
                    $("#town").append(`<option value="${town.name}" data-code="${town.code}">${town.name}</option>`);
                });
            }).fail(function() {
                $("#town").html('<option value="" disabled selected>Error loading towns</option>');
            });
        });

        $("#town").change(function() {
            let townCode = $(this).find(':selected').data('code');
            $("#barangay").html('<option value="">Loading...</option>');

            $.get(`/get-barangays?municipality_code=${townCode}`, function(data) {
                $("#barangay").html('<option value="" disabled selected>🏡 Select Barangay</option>');
                $.each(data, function(index, barangay) {
                    $("#barangay").append(`<option value="${barangay.name}">${barangay.name}</option>`);
                });
            }).fail(function() {
                $("#barangay").html('<option value="" disabled selected>Error loading barangays</option>');
            });
        });
    });
</script>
@endsection