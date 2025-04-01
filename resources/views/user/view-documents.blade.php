@extends('layouts.user')

@section('content')
<div class="container">
    <h2>View Uploaded Documents</h2>

    @if($documents)
        <div class="row">
            <div class="col-md-6">
                <label>Sanitary Permit</label>
                @if($documents->sanitary_permit)
                    <p><a href="{{ asset($documents->sanitary_permit) }}" target="_blank">View File</a></p>
                @else
                    <p>No file uploaded</p>
                @endif
            </div>

            <div class="col-md-6">
                <label>Barangay Permit</label>
                @if($documents->barangay_permit)
                    <p><a href="{{ asset($documents->barangay_permit) }}" target="_blank">View File</a></p>
                @else
                    <p>No file uploaded</p>
                @endif
            </div>

            <div class="col-md-6">
                <label>DTI Certificate</label>
                @if($documents->dti_certificate)
                    <p><a href="{{ asset($documents->dti_certificate) }}" target="_blank">View File</a></p>
                @else
                    <p>No file uploaded</p>
                @endif
            </div>

            <div class="col-md-6">
                <label>Official Receipt</label>
                @if($documents->official_receipt)
                    <p><a href="{{ asset($documents->official_receipt) }}" target="_blank">View File</a></p>
                @else
                    <p>No file uploaded</p>
                @endif
            </div>

            <div class="col-md-6">
                <label>Police Clearance</label>
                @if($documents->police_clearance)
                    <p><a href="{{ asset($documents->police_clearance) }}" target="_blank">View File</a></p>
                @else
                    <p>No file uploaded</p>
                @endif
            </div>

            <div class="col-md-6">
                <label>Tourism Compliance Certificate</label>
                @if($documents->tourism_compliance_certificate)
                    <p><a href="{{ asset($documents->tourism_compliance_certificate) }}" target="_blank">View File</a></p>
                @else
                    <p>No file uploaded</p>
                @endif
            </div>
        </div>
    @else
        <p>No documents uploaded.</p>
    @endif
</div>
@endsection
