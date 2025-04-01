@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Manage Business Types</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.add-business-type') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">New Business Type:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Business Type</button>
    </form>

    <h3 class="mt-4">Existing Business Types</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($businessTypes as $type)
            <tr>
                <td>{{ $type->id }}</td>
                <td>{{ $type->name }}</td>
                <td>
                    <form action="{{ route('admin.delete-business-type', $type->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
