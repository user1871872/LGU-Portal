@extends('layouts.admin')

@section('content')
<div class="container-fluid vh-100 d-flex p-0">
    <!-- Main Content -->
    <main class="flex-grow-1 px-4 py-4">
        <h2 class="mb-4">Business Applications</h2>

        <!-- Search Bar -->
        <div class="d-flex justify-content-between mb-3">
            <input type="text" class="form-control w-25" placeholder="Search by Business Name..." id="search">
        </div>

        <!-- Applications Table -->
        <div class="table-responsive">
            <table class="table table-bordered shadow-sm">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Date of Application</th>
                        <th>Business Name</th>
                        <th>Attachments</th>
                        <th>Status</th>
                        <th>Comments</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $index => $application)
                        <tr data-id="{{ $application->id }}">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $application->created_at->format('Y-m-d') }}</td>
                            <td>{{ $application->business_name }}</td>
                            <td>
                                @if($application->sanitary_permit)
                                    <a href="{{ asset($application->sanitary_permit) }}" class="text-primary" target="_blank">Sanitary Permit</a>
                                @endif
                                @if($application->barangay_permit)
                                    <a href="{{ asset($application->sanitary_permit) }}" class="text-primary ms-2" target="_blank">Barangay Permit</a>
                                @endif
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
                            <td colspan="7" class="text-center py-3">No applications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $applications->links() }}
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
            // alert('An error occurred.');
            console.error('Error:', error);
        });
    });
});

</script>
@endsection
