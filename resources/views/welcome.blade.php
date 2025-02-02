@extends('layouts.app')

@section('content')
<style>
    .hero-section {
        background: url('/images/background.jpg') no-repeat center center;
        background-size: cover;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        position: relative;
    }
    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6); /* Dark overlay */
    }
    .hero-content {
        position: relative;
        z-index: 1;
    }
</style>

<div class="hero-section">
    <div class="overlay"></div>
    <div class="container hero-content">
        <h1 class="display-4">Welcome to LGU-ANDA Business Permit Portal</h1>
        <p class="lead">Apply for permits easily and manage your transactions online.</p>
        <a href="" class="btn btn-primary btn-lg">Get Started</a>
    </div>
</div>

<div class="container text-center mt-5">
    <div class="row">
        <div class="col-md-4">
            <h3>Easy Online Application</h3>
            <p>Apply for permits anytime, anywhere.</p>
        </div>
        <div class="col-md-4">
            <h3>Track Your Applications</h3>
            <p>Stay updated on the status of your permits.</p>
        </div>
        <div class="col-md-4">
            <h3>Secure and Reliable</h3>
            <p>Your data is safe with us.</p>
        </div>
    </div>
    <a href="" class="btn btn-warning mt-4">Sign Up Now</a>
</div>
@endsection
