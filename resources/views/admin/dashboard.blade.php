@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0 d-flex">

    <main class="flex-grow-1 px-4 d-flex flex-column vh-100 overflow-auto">

        <div class="row mt-3 g-3">
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5>Total Applications</h5>
                        <h3>120</h3>
                        <p>As of October 2024</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5>Pending</h5>
                        <h3 class="text-warning">30</h3>
                        <p>20 awaiting documentation</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5>Approved</h5>
                        <h3 class="text-success">90</h3>
                        <p>Last updated Oct 4, 2024</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5>Revenue</h5>
                        <h3 class="text-primary">$10,000</h3>
                        <p>Jan 2024 - Sep 2024</p>
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
                                <tr>
                                    <td>AP-004</td>
                                    <td>Alice Williams</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td>Oct 1</td>
                                </tr>
                                <tr>
                                    <td>AP-005</td>
                                    <td>David Brown</td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                    <td>Oct 2</td>
                                </tr>
                                <tr>
                                    <td>AP-006</td>
                                    <td>Susan Johnson</td>
                                    <td><span class="badge bg-danger">Rejected</span></td>
                                    <td>Oct 3</td>
                                </tr>
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
    var ctx = document.getElementById('statusChart').getContext('2d');
    var statusChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Sep 1', 'Sep 5', 'Sep 10', 'Sep 15', 'Sep 20', 'Sep 25', 'Sep 30', 'Oct 5'],
            datasets: [
                {
                    label: 'Approved',
                    borderColor: 'green',
                    backgroundColor: 'rgba(0, 128, 0, 0.2)',
                    data: [20, 30, 40, 50, 60, 70, 80, 90]
                },
                {
                    label: 'Pending',
                    borderColor: 'gold',
                    backgroundColor: 'rgba(255, 215, 0, 0.2)',
                    data: [50, 45, 40, 35, 30, 25, 20, 15]
                },
                {
                    label: 'Rejected',
                    borderColor: 'red',
                    backgroundColor: 'rgba(255, 0, 0, 0.2)',
                    data: [5, 7, 9, 10, 11, 12, 13, 14]
                }
            ]
        }
    });
</script>
@endsection
