@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Business Permit Applications</h2>

    <!-- Search Bar -->
    <input type="text" id="search" class="form-control mb-3" placeholder="Search by Business Name...">

    <!-- Transactions Table -->
    <div class="table-responsive">
        <table class="table table-bordered text-center">
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
                        <td>{{ $app->business_address }}</td>
                        <td>{{ $app->line_of_business }}</td>
                        <td>
                            <button class="btn btn-sm btn-info">View Comments</button>
                        </td>
                        <td>
                            <span class="badge bg-warning text-dark">{{ ucfirst($app->status) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('apply-permit.edit', $app->id) }}" class="btn btn-warning btn-sm">Edit Application</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $applications->links() }}
    </div>
</div>

<script>
document.getElementById('search').addEventListener('input', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#transactionsTable tr");

    rows.forEach(row => {
        let businessName = row.cells[2].textContent.toLowerCase();
        row.style.display = businessName.includes(filter) ? "" : "none";
    });
});
</script>
@endsection
