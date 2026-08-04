@extends('layouts.app')

@section('title', 'Home - Ligen Dealer Locator')

@section('content')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Find Dealers & Distributors Near You</h1>
                <p class="lead mb-4">Connect with authorized Ligen dealers and distributors across India. Search by pincode to find the nearest service provider.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('search.index') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-search me-2"></i>Search Now
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-map-marked-alt" style="font-size: 8rem; opacity: 0.8;"></i>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row">
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-8 mx-auto text-center">
            <h2 class="mb-4">Why Choose Ligen?</h2>
            <p class="lead">We provide a comprehensive platform for dealers and distributors to connect with customers across India. Our system ensures easy registration, efficient search, and seamless management.</p>
        </div>
    </div>
</div>
@endsection
