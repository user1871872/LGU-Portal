@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card p-4 shadow-lg" style="width: 400px;">
        <h3 class="text-center">Create an Account</h3>
        <p class="text-muted text-center">Join LGU-ANDA</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password-confirm" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password-confirm" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Sign Up</button>

            <div class="mt-3 text-center">
                <a href="{{ route('login') }}">Already have an account? Login</a>
            </div>
        </form>
    </div>
</div>
@endsection
