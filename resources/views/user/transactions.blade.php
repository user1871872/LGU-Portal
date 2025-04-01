@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Business Permit Applications</h2>

    <!-- Search Bar -->
    <div class="mb-3">
        <input type="text" id="search" class="form-control text-center" placeholder="Search by Business Name...">
    </div>

    <!-- Transactions Table -->
    <div class="table-responsive d-flex justify-content-center">
        <table class="table table-bordered text-center w-100">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Date of Application</th>
                    <th>Business Name</th>
                    <th>Business Address</th>
                    <th>Business Type</th>
                    <th>Comments/Feedback</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="transactionsTable">
                @foreach($applications as $index => $app)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $app->created_at->format('Y-m-d') }}</td>
                        <td>{{ $app->business_name }}</td>
                        <td>{{ $app->province }} {{ $app->town }} {{ $app->barangay }}</td>
                        <td>{{ $app->businessType->name ?? 'N/A' }}</td>
                        <td>
                            <button class="btn btn-sm btn-info view-comments" data-comments="{{ $app->comments }}" data-bs-toggle="modal" data-bs-target="#commentsModal">
                                View
                            </button>
                        </td>
                        <td>
                            <span class="badge bg-warning text-dark">{{ ucfirst($app->status) }}</span>
                        </td>
                        <td>
                            @if(strtolower(trim($app->status)) !== 'approved')
                                <a href="{{ route('apply-permit.edit', $app->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $applications->links('pagination::bootstrap-4') }}
    </div>
</div>

<!-- Comments Modal -->
<div class="modal fade" id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentsModalLabel">Comments/Feedback</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="commentsText">No comments available.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.view-comments').forEach(button => {
    button.addEventListener('click', function () {
        let comments = this.getAttribute('data-comments') || 'No comments available.';
        document.getElementById('commentsText').textContent = comments;
    });
});

document.getElementById('search').addEventListener('input', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#transactionsTable tr");

    rows.forEach(row => {
        let businessName = row.cells[2].textContent.toLowerCase();
        row.style.display = businessName.includes(filter) ? "" : "none";
    });
});
</script>

<style>
/* Table Styling */
@media (max-width: 768px) {
    .table-responsive {
        display: flex;
        justify-content: center; /* Ensures table is centered */
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    table {
        font-size: 14px;
        max-width: 100%;
    }

    th, td {
        white-space: nowrap; /* Prevents text from wrapping */
    }
}
</style>

@endsection
