@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Business Permit Archive</h2>

    <!-- 🔍 Search Form -->
    <form action="{{ route('admin.archive') }}" method="GET" class="mb-3">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" name="business_name" class="form-control" 
                        placeholder="Search Business Name..." value="{{ request('business_name') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- 📜 Permits Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Business Name</th>
                    <th>Owner</th>
                    <th>Status</th>
                    <th>Issued Date</th>
                    <th>Documents</th> <!-- ✅ Added Documents Column -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($paginatedPermits as $permit)
                    <tr>
                        <td>{{ $permit->id }}</td>
                        <td>{{ $permit->business_name ?? 'N/A' }}</td>
                        <td>{{ $permit->first_name ?? 'N/A' }} {{ $permit->last_name ?? '' }}</td>
                        <td>
                            @if ($permit instanceof App\Models\PkCertificate)
                                <span class="badge bg-success">Issued</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                        <td>{{ $permit->issued_at ?? 'Not Issued' }}</td>

                        <!-- ✅ Documents Column -->
                        <td class="text-start">
    @php
        $documents = [
            'sanitary_permit',
            'barangay_permit',
            'dti_certificate',
            'official_receipt',
            'police_clearance',
            'tourism_compliance_certificate'
        ];
    @endphp

    @foreach ($documents as $doc)
        @php
            $documentFile = optional(optional($permit->documents)->first())->$doc;
        @endphp

        @if ($documentFile)
            <p class="mb-1">
                <strong>{{ ucfirst(str_replace('_', ' ', $doc)) }}:</strong> 
                <a href="{{ asset($documentFile) }}" target="_blank" class="text-decoration-none">View</a>
            </p>
        @else
            <p class="mb-1">
                <strong>{{ ucfirst(str_replace('_', ' ', $doc)) }}:</strong> Not Available
            </p>
        @endif
    @endforeach
</td>


                        <!-- ✅ Actions Column -->
                        <td>
                            @if ($permit instanceof App\Models\PkCertificate)
                                <a href="{{ asset($permit->file_path) }}" target="_blank" class="btn btn-primary btn-sm">
                                    <i class="bi bi-file-earmark-text"></i> View Certificate
                                </a>
                            @else
                                <span class="text-muted">No Certificate</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ✅ Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {!! $paginatedPermits->appends(request()->query())->links('pagination::bootstrap-5') !!}
    </div>
</div>
@endsection
