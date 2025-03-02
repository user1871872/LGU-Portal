@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Generate Business Permit</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('pk-certificates.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label for="permit_id" class="form-label">Select Business Permit</label>
            <select class="form-select" name="permit_id" required>
                <option value="">-- Select Permit --</option>
                @foreach($permits as $permit)
                    <option value="{{ $permit->id }}">{{ $permit->business_name }} - {{ $permit->owner_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="issued_at" class="form-label">Issue Date</label>
            <input type="date" class="form-control" name="issued_at" required>
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">Upload Certificate (PDF)</label>
            <input type="file" class="form-control" name="file" accept=".pdf" required>
        </div>

        <button type="submit" class="btn btn-primary">Generate Permit</button>
    </form>
</div>
@endsection
