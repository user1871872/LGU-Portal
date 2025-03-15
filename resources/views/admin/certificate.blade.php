@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Business Permits</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Form to generate a business permit -->
    <form action="{{ route('pk-certificates.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col-md-8">
                <label for="permit_id" class="form-label">Select Business Permit</label>
                <select class="form-select" name="permit_id" required>
                    <option value="">-- Select Permit --</option>
                    @foreach($permits as $permit)
                    <option value="{{ $permit->id }}">{{ $permit->business_name }} - {{ $permit->owner_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Generate Permit</button>
            </div>
        </div>
    </form>

    <!-- Business Permits Table -->
    <table class="table">
        <thead>
            <tr>
                <th>Business Name</th>

                <th>Business Location</th>
                <th>Business Type</th>
                <th>Issued Date</th>
                <th>Certificate</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($certificates as $certificate)
            <tr>
                <td>{{ $certificate->permit->business_name }}</td>

                <td>{{ $certificate->permit->business_address }}</td>
                <td>{{ $certificate->permit->business_type }}</td>
                <td>{{ \Carbon\Carbon::parse($certificate->issued_at)->format('F j, Y') }}</td>
                <td>
                    @if($certificate->file_path)
                    <p>
                        <a href="{{ asset($certificate->file_path) }}" target="_blank">View Certificate</a>
                    </p>
                    @endif

                </td>
                <td>
                    <form action="{{ route('pk-certificates.destroy', $certificate->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


    {{ $certificates->links() }}
</div>
@endsection