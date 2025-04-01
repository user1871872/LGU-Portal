@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0 d-flex">

    <main class="flex-grow-1 px-4 d-flex flex-column vh-100 overflow-auto">

        <div class="row mt-3 g-3">
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5>Total Applications</h5>
                        <h3>{{ $totalApplications }}</h3>
                        <p>As of {{ now()->format('F Y') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5>Pending</h5>
                        <h3 class="text-warning">{{ $pending }}</h3>
                        <p>{{ $pending }} awaiting documentation</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5>Approved</h5>
                        <h3 class="text-success">{{ $approved }}</h3>
                        <p>Last updated {{ now()->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5>Revenue</h5>
                        <h3 class="text-primary">₱{{ number_format($revenue, 2) }}</h3>
                        <p>Jan {{ now()->year }} - {{ now()->format('M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Applications -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">Recent Applications</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentApplications as $application)
                                <tr>
                                    <td>{{ $application->id }}</td>
                                    <td>{{ $application->first_name ?? 'N/A' }} {{ $application->last_name ?? 'N/A' }}</td>
                                    <td>
                                        @if($application->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($application->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>{{ $application->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Chart -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">Application Status Overview</div>
                    <div class="card-body">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Inject PHP variables correctly into JavaScript
        var approved = {{ json_encode($approved ?? 0) }};
        var pending = {{ json_encode($pending ?? 0) }};
        var rejected = {{ json_encode($rejected ?? 0) }};

        var ctx = document.getElementById('statusChart').getContext('2d');

        var statusChart = new Chart(ctx, {
            type: 'line', // Line chart
            data: {
                labels: ['Sep 1', 'Sep 5', 'Sep 10', 'Sep 15', 'Sep 20', 'Sep 25', 'Sep 30', 'Oct 5'],
                datasets: [
                    {
                        label: 'Approved',
                        borderColor: 'green',
                        backgroundColor: 'rgba(0, 128, 0, 0.2)',
                        data: [approved, approved, approved, approved, approved, approved, approved, approved],
                        fill: true,
                        tension: 0.4, // Smooth curve
                        pointRadius: 5, // Larger points
                        pointBackgroundColor: 'green',
                        borderWidth: 2
                    },
                    {
                        label: 'Pending',
                        borderColor: 'gold',
                        backgroundColor: 'rgba(255, 215, 0, 0.2)',
                        data: [pending, pending, pending, pending, pending, pending, pending, pending],
                        fill: true,
                        tension: 0.4, // Smooth curve
                        pointRadius: 5, // Larger points
                        pointBackgroundColor: 'gold',
                        borderWidth: 2
                    },
                    {
                        label: 'Rejected',
                        borderColor: 'red',
                        backgroundColor: 'rgba(255, 0, 0, 0.2)',
                        data: [rejected, rejected, rejected, rejected, rejected, rejected, rejected, rejected],
                        fill: true,
                        tension: 0.4, // Smooth curve
                        pointRadius: 5, // Larger points
                        pointBackgroundColor: 'red',
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top' // Position legend at the top
                    }
                },
                scales: {
                    x: {
                        grid: {
                            drawBorder: false,
                            color: 'rgba(0, 0, 0, 0.1)', // Slanted grid lines
                            borderDash: [5, 5] // Dotted grid lines
                        },
                        ticks: {
                            maxRotation: 45, // Rotate the x-axis labels to make them slanted
                            minRotation: 45 // Minimum angle of the labels
                        }
                    },
                    y: {
                        grid: {
                            drawBorder: false,
                            color: 'rgba(0, 0, 0, 0.1)', // Slanted grid lines
                            borderDash: [5, 5] // Dotted grid lines
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>




@endsection
