<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ligen Power® Dealer Locator')</title>
    <link rel="icon" type="image/webp" href="{{ asset('cropped-ligen1.png.webp') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #82ac3a;
            --dark-green: #6b8a2e;
            --light-green: #9bc44a;
            --primary-blue: #6c757d;
            --dark-blue: #495057;
            --light-blue: #adb5bd;
            --accent-orange: #fd7e14;
            --black: #212529;
            --white: #ffffff;
            --gray: #f8f9fa;
            --dark-gray: #343a40;
            --text-muted: #6c757d;
            
            /* Override Bootstrap primary color from blue to grey */
            --bs-primary: #6c757d;
            --bs-primary-rgb: 108, 117, 125;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--gray);
        }
        
        /* Top Header Bar */
        .top-header {
            background-color: #343a40;
            color: white;
            padding: 8px 0;
            font-size: 14px;
        }
        
        .top-header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .top-header-left {
            color: white;
            font-weight: 600;
        }
        
        .top-header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .top-header-right .divider {
            width: 1px;
            height: 20px;
            background-color: white;
            opacity: 0.3;
        }
        
        .top-header-right .contact-info {
            display: flex;
            align-items: center;
            gap: 5px;
            color: white;
        }
        
        .social-icons {
            display: flex;
            gap: 10px;
        }
        
        .social-icons a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }
        
        /* Main Navigation */
        .main-navbar {
            background-color: white !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo-image {
            width: 50px;
            height: 50px;
            object-fit: contain;
            margin-right: 10px;
        }
        
        .brand-text {
            color: var(--black);
            font-weight: 700;
            font-size: 1.2rem;
            margin: 0;
        }
        
        .main-navbar .navbar-nav .nav-link {
            color: var(--black) !important;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            padding: 10px 15px;
        }
        
        .main-navbar .navbar-nav .nav-link:hover,
        .main-navbar .navbar-nav .nav-link.active {
            color: var(--primary-green) !important;
        }
        
        .navbar-right-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .contact-section {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .contact-icon {
            width: 30px;
            height: 30px;
            background-color: var(--primary-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
        }
        
        .contact-details {
            display: flex;
            flex-direction: column;
        }
        
        .phone-number {
            color: var(--black);
            font-weight: 600;
            font-size: 14px;
            margin: 0;
        }
        
        .hours {
            color: var(--text-muted);
            font-size: 12px;
            margin: 0;
        }
        
        .search-icon {
            color: var(--black);
            font-size: 18px;
            cursor: pointer;
        }
        
        .enquire-btn {
            background-color: var(--primary-green);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        
        .enquire-btn:hover {
            background-color: var(--dark-green);
            color: white;
        }
        
        .btn-website {
            background: linear-gradient(45deg, var(--primary-green), var(--accent-orange));
            border: none;
            color: white;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        
        .btn-website:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            color: white;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            border: none;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        
        .btn-primary:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
            background: linear-gradient(135deg, var(--dark-blue), var(--primary-blue));
        }
        
        .btn-outline-primary {
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
            font-weight: 600;
        }
        
        .btn-outline-primary:hover {
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            border-color: var(--primary-blue);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        
        .card {
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border-radius: 15px;
            overflow: hidden;
        }
        
        .card:hover {
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            color: var(--white);
            border-radius: 15px 15px 0 0 !important;
            padding: 1.5rem;
            border-bottom: 3px solid var(--primary-green);
        }
        
        .card-header h3 {
            margin: 0;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .footer {
            background-color: var(--dark-gray);
            color: var(--white);
            padding: 3rem 0 2rem 0;
            margin-top: auto;
            border-top: 3px solid var(--primary-blue);
        }
        
        .footer h5 {
            color: var(--primary-green);
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .footer p {
            margin-bottom: 0.5rem;
            opacity: 0.9;
        }
        
        .footer .text-md-end {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        main {
            flex: 1;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            color: var(--white);
            padding: 4rem 0;
        }
        
        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .alert-success {
            background-color: var(--light-green);
            border-color: var(--primary-green);
            color: var(--black);
        }
        
        .table th {
            background-color: var(--primary-green);
            color: var(--white);
            border: none;
        }
        
        .badge {
            background-color: var(--primary-green);
        }
        
        /* Admin Dashboard Specific Styles */
        .text-primary {
            color: var(--primary-blue) !important;
        }
        
        .text-success {
            color: var(--primary-green) !important;
        }
        
        .text-info {
            color: var(--primary-blue) !important;
        }
        
        .text-warning {
            color: var(--accent-orange) !important;
        }
        
        .bg-success {
            background-color: var(--primary-green) !important;
        }
        
        .bg-info {
            background-color: var(--primary-blue) !important;
        }
        
        .btn-outline-primary {
            color: var(--primary-blue);
            border-color: var(--primary-blue);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
            color: white;
        }
        
        .btn-outline-success {
            color: var(--primary-green);
            border-color: var(--primary-green);
        }
        
        .btn-outline-success:hover {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
            color: white;
        }
        
        .btn-outline-warning {
            color: var(--accent-orange);
            border-color: var(--accent-orange);
        }
        
        .btn-outline-warning:hover {
            background-color: var(--accent-orange);
            border-color: var(--accent-orange);
            color: white;
        }
        
        .table th {
            background-color: var(--primary-blue);
            color: white;
            border: none;
        }
        
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(108, 117, 125, 0.05);
        }
        
        /* Pagination Styling */
        .pagination {
            margin-bottom: 0;
        }
        
        .pagination .page-link {
            color: var(--primary-blue);
            border-color: #dee2e6;
            background-color: white;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 0.375rem;
            margin: 0 2px;
        }
        
        .pagination .page-link:hover {
            color: white;
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);

            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .pagination .page-item.active .page-link {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
            color: white;
            font-weight: 600;
        }
        
        .pagination .page-item.disabled .page-link {
            color: #adb5bd;
            background-color: #f8f9fa;
            border-color: #dee2e6;
            cursor: not-allowed;
        }
        
        .pagination .page-link:focus {
            box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.25);
            outline: none;
        }
        
        /* Hide the large graphical arrows completely */
        .pagination .page-item:first-child,
        .pagination .page-item:last-child {
            display: none !important;
        }
        
        /* Hide any large arrow symbols */
        .pagination .page-link::before,
        .pagination .page-link::after {
            display: none !important;
        }
        
        /* Ensure only numbered pages and text navigation show */
        .pagination .page-item:not(:first-child):not(:last-child) {
            display: inline-block;
        }
        
        /* Style the text-based navigation if it exists */
        .pagination .page-item .page-link[aria-label="Previous"],
        .pagination .page-item .page-link[aria-label="Next"] {
            display: inline-block;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
        }
        
        /* Search Page Styles */
        .search-hero-section {
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            color: white;
            padding: 4rem 0 3rem 0;
            margin-bottom: 0;
        }
        
        .search-form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            padding: 3rem;
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .search-form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-green), var(--accent-orange));
        }
        
        .search-form .form-group {
            position: relative;
        }
        
        .search-form .form-label {
            font-weight: 600;
            color: var(--dark-gray);
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }
        
        .search-form .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }
        
        .search-form .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.2rem rgba(130, 172, 58, 0.25);
            background-color: white;
        }
        
        .search-form .form-control:hover {
            border-color: var(--primary-blue);
            background-color: white;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }
        
        .btn-search {
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            border: none;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(130, 172, 58, 0.3);
            transition: all 0.3s ease;
        }
        
        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(130, 172, 58, 0.4);
            background: linear-gradient(135deg, var(--dark-green), var(--primary-green));
        }
        
        .btn-outline-secondary {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.875rem 1.5rem;
            font-weight: 600;
            color: var(--text-muted);
            transition: all 0.3s ease;
        }
        
        .btn-outline-secondary:hover {
            border-color: var(--primary-blue);
            color: var(--primary-blue);
            background-color: rgba(108, 117, 125, 0.05);
        }
        
        /* Search Results Styles */
        .search-results-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        
        .search-results-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            color: white;
            padding: 1.5rem;
            border: none;
        }
        
        .dealer-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .dealer-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .dealer-card .card-body {
            padding: 1.5rem;
        }
        
        .dealer-card .card-title {
            color: var(--dark-gray);
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }
        
        .dealer-info {
            margin-bottom: 0.75rem;
        }
        
        .dealer-info i {
            color: var(--primary-green);
            width: 16px;
            margin-right: 8px;
        }
        
        .dealer-info strong {
            color: var(--dark-gray);
            font-weight: 600;
        }
        
        .badge-type {
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .no-results-section {
            text-align: center;
            padding: 4rem 2rem;
        }
        
        .no-results-section i {
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }
        
        .sidebar-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        }
        
        .sidebar-card .card-header {
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            color: white;
            border: none;
            padding: 1rem 1.5rem;
        }
        
        .results-summary {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
        }
        
        /* Admin Login Styles */
        .admin-login-hero {
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            color: white;
            padding: 4rem 0 3rem 0;
            margin-bottom: 0;
        }
        
        .admin-login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.1);
            padding: 0;
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .admin-login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-blue), var(--primary-green));
        }
        
        .login-header {
            text-align: center;
            padding: 3rem 3rem 2rem 3rem;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        }
        
        .login-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem auto;
            box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
        }
        
        .login-icon i {
            font-size: 2rem;
            color: white;
        }
        
        .login-title {
            color: var(--dark-gray);
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }
        
        .login-subtitle {
            color: var(--text-muted);
            font-size: 1rem;
            margin-bottom: 0;
        }
        
        .login-form {
            padding: 2rem 3rem;
        }
        
        .login-form .form-group {
            position: relative;
        }
        
        .login-form .form-label {
            font-weight: 600;
            color: var(--dark-gray);
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-blue);
            font-size: 1rem;
            z-index: 2;
        }
        
        .login-form .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.875rem 1rem 0.875rem 3rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }
        
        .login-form .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.25);
            background-color: white;
        }
        
        .login-form .form-control:hover {
            border-color: var(--primary-green);
            background-color: white;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }
        
        .form-check-label {
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        
        .form-actions {
            margin-top: 2rem;
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            border: none;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            width: 100%;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
            background: linear-gradient(135deg, var(--dark-blue), var(--primary-blue));
            color: white;
        }
        
        .login-footer {
            padding: 2rem 3rem;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .security-info {
            display: flex;
            align-items: center;
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        
        .security-info i {
            color: var(--primary-green);
        }
        
        .back-link {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .back-link:hover {
            color: var(--dark-blue);
            text-decoration: none;
        }
        
        .login-alert {
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
            margin-bottom: 1.5rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .search-form-card {
                padding: 2rem 1.5rem;
                margin: 0 1rem;
            }
            
            .form-actions {
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .btn-search, .btn-outline-secondary {
                width: 100%;
            }
            
            .dealer-card {
                margin-bottom: 1rem;
            }
            
            .admin-login-card {
                margin: 0 1rem;
            }
            
            .login-header, .login-form, .login-footer {
                padding-left: 2rem;
                padding-right: 2rem;
            }
            
            .login-footer {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Top Header Bar -->
    <div class="top-header">
        <div class="container">
            <div class="top-header-left">
                Ligen Power®, Powering The World Efficiently
            </div>
            <div class="top-header-right">
                <div class="contact-info">
                    <i class="fas fa-envelope"></i>
                    <span>Make a call : +91-9031086082</span>
                </div>
                <div class="divider"></div>
                <div class="contact-info">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Bihar</span>
                </div>
                <div class="divider"></div>
                <div class="social-icons">
                    <a href="https://www.facebook.com/ligenpower/" target="_blank" title="Follow us on Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/ligen-power/" target="_blank" title="Connect with us on LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://www.instagram.com/ligenpower/" target="_blank" title="Follow us on Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg main-navbar">
        <div class="container">
            <a class="navbar-brand" href="https://ligenpower.com/">
                <img src="{{ asset('cropped-ligen1.png.webp') }}" alt="Ligen Power®" class="logo-image">
                <div class="brand-text">Ligen Power®</div>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('search.*') ? 'active' : '' }}" href="{{ route('search.index') }}">Search</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('register*') ? 'active' : '' }}" href="{{ route('register') }}">Register as Merchant</a>
                    </li>
                </ul>
                
                <div class="navbar-right-section">
                    <div class="contact-section">
                        <div class="contact-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="contact-details">
                            <p class="phone-number">+91-9031086082</p>
                            <p class="hours">Mon - Sat: 9:30 am to 6:00 pm</p>
                        </div>
                    </div>
                    
                    <a href="https://ligenpower.com/" class="enquire-btn">
                        <span>Go to Main Website</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5><i class="fas fa-store me-2"></i>Ligen Power® Dealer Locator</h5>
                    <p class="mb-0">Find dealers and distributors near you across India.</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <p class="mb-0">&copy; {{ date('Y') }} Ligen Power® Dealer Locator. All rights reserved. | Powered by <a href="https://neksoftconsultancy.com/" target="_blank" style="color: var(--primary-green); text-decoration: none;">Neksoft Consultancy Services</a></p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
