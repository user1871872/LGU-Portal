@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card p-4 shadow-lg" style="width: 400px;">
    <div class="text-center my-3">
    <img src="{{ asset('images/logo.jpg') }}" alt="User" class="profile-image mx-auto d-block" style="width: 100px; height: 100px;">
</div>

        <!-- Error Alert -->
        @if ($errors->any())
            <div class="alert alert-danger text-center" id="errorMessage">
                <strong>{{ $errors->first() }}</strong>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" required>
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                        <i class="fa fa-eye"></i> <!-- FontAwesome eye icon -->
                    </button>
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label for="remember" class="form-check-label">Remember Me</label>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>

            <div class="mt-3 text-center">
                <!-- <a href="#">Don't have an account? Sign Up</a> -->
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('togglePassword').addEventListener('click', function () {
    let passwordInput = document.getElementById('password');
    let icon = this.querySelector('i');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

// Automatically hide error message after 5 seconds
setTimeout(() => {
    let errorMessage = document.getElementById('errorMessage');
    if (errorMessage) {
        errorMessage.style.display = 'none';
    }
}, 5000);
</script>
@endsection
