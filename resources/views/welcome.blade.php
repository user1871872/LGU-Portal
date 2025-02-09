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
        padding: 20px;
    }
    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6); 
    }
    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 800px;
    }
    .hero-content h1 {
        font-size: 2.5rem;
        font-weight: bold;
    }
    .hero-content p {
        font-size: 1.2rem;
    }

    /* Features Section */
    .features-section {
        padding: 60px 20px;
        background: #f8f9fa;
    }
    .features-section .feature-box {
        padding: 20px;
        border-radius: 8px;
        background: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }
    .features-section .feature-box:hover {
        transform: translateY(-5px);
    }
</style>

<!-- Hero Section -->
<div class="hero-section">
    <div class="overlay"></div>
    <div class="container hero-content">
        <h1>Welcome to LGU-ANDA Business Permit Portal</h1>
        <p>Apply for permits easily and manage your transactions online.</p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Get Started</a>
    </div>
</div>

<!-- Features Section -->
<div class="container text-center features-section">
    <div class="row">
        <div class="col-md-4">
            <div class="feature-box">
                <h3>Easy Online Application</h3>
                <p>Apply for permits anytime, anywhere.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <h3>Track Your Applications</h3>
                <p>Stay updated on the status of your permits.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <h3>Secure and Reliable</h3>
                <p>Your data is safe with us.</p>
            </div>
        </div>
    </div>
    <a href="{{ route('register') }}" class="btn btn-warning mt-4">Sign Up Now</a>
</div>
@endsection
