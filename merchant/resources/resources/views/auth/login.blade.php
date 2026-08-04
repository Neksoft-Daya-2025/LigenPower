@extends('layouts.app')

@section('title', 'Admin Login - Ligen Dealer Locator')

@section('content')
<!-- Admin Login Hero Section -->
<div class="admin-login-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h1 class="display-5 fw-bold mb-3">Admin Access</h1>
                <p class="lead mb-4">Secure access to the dealer management system</p>
            </div>
        </div>
    </div>
</div>

<!-- Login Form Section -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="admin-login-card">
                <div class="login-header">
                    <div class="login-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="login-title">Admin Login</h3>
                    <p class="login-subtitle">Enter your credentials to access the admin panel</p>
                </div>
                
                <form action="{{ route('admin.login.post') }}" method="POST" class="login-form">
                    @csrf
                    
                    @if ($errors->any())
                        <div class="alert alert-danger login-alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="form-group mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="Enter your email address" required autofocus>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-key input-icon"></i>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Remember me for 30 days
                            </label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                        </button>
                    </div>
                </form>
                
                <div class="login-footer">
                    <div class="security-info">
                        <i class="fas fa-shield-alt me-2"></i>
                        <span>Secure admin access with encryption</span>
                    </div>
                    <a href="{{ route('home') }}" class="back-link">
                        <i class="fas fa-arrow-left me-2"></i>Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
