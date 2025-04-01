@extends('layouts.admin')

@section('content')
<div class="container-fluid vh-100 d-flex p-0">
    
    <!-- Main Content -->
    <main class="flex-grow-1 px-4 py-4">
        <h2 class="mb-4">Business Applications</h2>

        <!-- Search Bar -->
        <div class="d-flex justify-content-between mb-3">
            <input type="text" class="form-control w-25" placeholder="Search by Business Name..." id="search" onkeyup="filterTable()">
        </div>

        <!-- Applications Table -->
        <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
            <table class="table table-bordered shadow-sm align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 15%;">Date of Application</th>
                        <th style="width: 20%;">Business Name</th>
                        <th style="width: 15%;">Business Type</th> <!-- Added Business Type Column -->
                        <th style="width: 25%;">Attachments</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 15%;">Comments</th>
                        <th style="width: 10%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $index => $application)
                        <tr data-id="{{ $application->id }}">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $application->created_at->format('Y-m-d') }}</td>
                            <td class="text-start">{{ $application->business_name }}</td>
                            <td>{{ $application->business_type }}</td> <!-- Display Business Type -->
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
                                    @if ($application->documents->isNotEmpty() && $application->documents->first()->$doc)
                                        <p class="mb-1">
                                            <strong>{{ ucfirst(str_replace('_', ' ', $doc)) }}:</strong> 
                                            <a href="{{ asset($application->documents->first()->$doc) }}" target="_blank" class="text-decoration-none">View</a>
                                        </p>
                                    @else
                                        <p class="mb-1"><strong>{{ ucfirst(str_replace('_', ' ', $doc)) }}:</strong> Not Available</p>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <select class="form-select status-select">
                                    <option value="Pending" {{ $application->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Approved" {{ $application->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="Rejected" {{ $application->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </td>
                            <td>
                                <textarea class="form-control comments-input" rows="2" placeholder="Enter comments...">{{ $application->comments }}</textarea>
                            </td>
                            <td>
                                <button class="btn btn-success btn-sm update-status">Update</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-3">No applications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination (Fixed) -->
        <div class="d-flex justify-content-center mt-3">
            {!! $applications->appends(request()->query())->links('pagination::bootstrap-5') !!}
        </div>

    </main>
</div>

<script>
document.querySelectorAll('.update-status').forEach(button => {
    button.addEventListener('click', function () {
        const row = this.closest('tr');
        const applicationId = row.dataset.id;
        const status = row.querySelector('.status-select').value;
        const comments = row.querySelector('.comments-input').value;

        fetch(`/admin/applications/${applicationId}/update-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ status: status, comments: comments }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Status and comments updated successfully.');
            } else {
                alert('Update failed. Check console for errors.');
                console.error(data);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});

// Search Filter
function filterTable() {
    let input = document.getElementById("search").value.toLowerCase();
    let rows = document.querySelectorAll("tbody tr");

    rows.forEach(row => {
        let businessName = row.cells[2].innerText.toLowerCase(); 
        row.style.display = businessName.includes(input) ? "" : "none";
    });
}
</script>

<style>
/* Fix Pagination Alignment */
.pagination {
    margin-top: 15px !important;
    margin-bottom: 15px !important;
}
</style>

@endsection
