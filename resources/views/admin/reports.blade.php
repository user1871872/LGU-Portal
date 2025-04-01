@extends('layouts.admin')

@section('content')
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    .report-wrapper {
        margin-top: 2%;
        display: flex;
        gap: 50px;
        align-items: flex-start;
    }
    .report-box {
        flex: 1;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background: white;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }
    .form-group select, 
    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
        background: white;
    }
    .date-group {
        display: flex;
        gap: 20px;
    }
    .date-group .form-group {
        flex: 1;
    }
    .btn-generate, .btn-print {
        width: 100%;
        padding: 12px;
        background: black;
        color: white;
        font-size: 16px;
        font-weight: bold;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s;
        margin-top: 10px;
    }
    .btn-generate:hover, .btn-print:hover {
        background: #333;
    }
    .report-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    .report-table th, .report-table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }
    .report-table th {
        background: #f5f5f5;
        font-weight: bold;
    }
    .print-section {
        display: none;
    }
    @media print {
    body {
        width: 100%;
        font-size: 12px;
    }
    .container {
        width: 100%;
    }
}
</style>

<div class="container">
    @if(session('error'))
        <div style="color: red; font-weight: bold;">{{ session('error') }}</div>
    @endif

    <div class="report-wrapper">
        <!-- Left Section: Report Information -->
        <div class="report-box">
            <h3 class="report-title">Report Information</h3>
            <p>Generate detailed reports for permits. Select a date range to filter results.</p>
            <hr>

            <h4 class="report-title">Select Report Type</h4>
            <form method="POST" action="{{ route('reports.generate') }}">
                @csrf
                <div class="form-group">
                    <label>Report Type</label>
                    <select name="report_type" required>
                        <option value="">Select a report type</option>
                        <option value="issued_permits" {{ old('report_type') == 'issued_permits' ? 'selected' : '' }}>Issued Permits</option>
                    </select>
                </div>

                <div class="date-group">
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}" required>
                    </div>
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}" required>
                    </div>
                </div>

                <button type="submit" class="btn-generate">Generate Report</button>
            </form>
        </div>

        <!-- Right Section: Generated Report -->
        <div class="report-box">
            <h3 class="report-title">Generated Report</h3>
            @if(isset($certificates) && count($certificates) > 0)
                <div id="reportContent">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>Business Name</th>
                                <th>Issued Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($certificates as $certificate)
                                <tr>
                                    <td>{{ $certificate->permit->business_name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($certificate->issued_at)->format('F d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button class="btn-print" onclick="printReport()">Print Report</button>
            @else
                <p class="generated-placeholder">No report generated yet. Please select a date range.</p>
            @endif
        </div>
    </div>
</div>

<script>
    function printReport() {
        var printContent = document.getElementById("reportContent").innerHTML;
        var originalContent = document.body.innerHTML;
        
        var printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write(`
            <html>
            <head>
                <title>Print Report</title>
                <style>
                    @media print {
                        body {
                            font-size: 14px;
                            text-align: center;
                            margin: 0;
                            padding: 20px;
                        }
                        .report-header {
                            font-size: 16px;
                            font-weight: bold;
                            text-align: center;
                            margin-bottom: 20px;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-top: 20px;
                        }
                        th, td {
                            padding: 10px;
                            border: 1px solid black;
                            text-align: left;
                        }
                        th {
                            background: #ddd;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="report-header">
                    <p>Republic of the Philippines</p>
                    <p>Province of Bohol</p>
                    <p><strong>MUNICIPALITY OF ANDA</strong></p>
                    <p>BUSINESS PERMITS AND LICENSING OFFICE</p>
                    <hr>
                </div>
                <div>${printContent}</div>
            </body>
            </html>
        `);
        
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    }
</script>


@endsection
