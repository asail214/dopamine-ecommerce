<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dopamine Store') }} - @yield('title', 'E-commerce Platform')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary-blue: #1e40af;
            --secondary-blue: #3b82f6;
            --light-blue: #60a5fa;
            --white: #ffffff;
            --gray-light: #f8fafc;
            --gray-medium: #64748b;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--gray-light);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-blue) !important;
            font-size: 1.5rem;
        }
        
        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-blue);
            border-color: var(--secondary-blue);
        }
        
        .text-primary {
            color: var(--primary-blue) !important;
        }
        
        .bg-primary {
            background-color: var(--primary-blue) !important;
        }

        /* Add some hover animation to the hero logo */
        .logo-hero-container img {
            transition: transform 0.3s ease-in-out;
        }

        .logo-hero-container:hover img {
            transform: scale(1.05);
        }

        /* Responsive logo sizing */
        @media (max-width: 768px) {
            .logo-hero-container img {
                width: 200px !important;
            }
        }
    </style>
</head>

<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm border-bottom border-primary border-opacity-25">
        <div class="container">
            <!-- Logo with your actual image -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/dopamine-logo.png') }}" alt="Dopamine Store" 
                     style="height: 50px; width: auto; margin-right: 10px;">
                <span class="fw-bold text-primary d-none d-md-inline">Dopamine Store</span>
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Categories
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Electronics</a></li>
                            <li><a class="dropdown-item" href="#">Fashion</a></li>
                            <li><a class="dropdown-item" href="#">Home & Garden</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>

                <!-- Search Bar -->
                <form class="d-flex me-3" style="width: 300px;">
                    <input class="form-control" type="search" placeholder="Search products..." aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">
                        <span class="material-icons">search</span>
                    </button>
                </form>

                <!-- User Menu -->
                <ul class="navbar-nav">
                    <!-- Cart -->
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="#">
                            <span class="material-icons">shopping_cart</span>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                3
                            </span>
                        </a>
                    </li>

                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <span class="material-icons me-1">account_circle</span>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                @if(auth()->user()->hasRole('admin'))
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="/admin">Admin Panel</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-primary text-white mt-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="mb-3">Dopamine Store</h5>
                    <p class="mb-3">Your trusted e-commerce platform for quality products and exceptional service.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white"><span class="material-icons">facebook</span></a>
                        <a href="#" class="text-white"><span class="material-icons">alternate_email</span></a>
                        <a href="#" class="text-white"><span class="material-icons">phone</span></a>
                    </div>
                </div>
                <div class="col-md-2">
                    <h6 class="mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-white-50">Home</a></li>
                        <li><a href="{{ route('about') }}" class="text-white-50">About</a></li>
                        <li><a href="{{ route('contact') }}" class="text-white-50">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6 class="mb-3">Categories</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50">Electronics</a></li>
                        <li><a href="#" class="text-white-50">Fashion</a></li>
                        <li><a href="#" class="text-white-50">Home & Garden</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6 class="mb-3">Support</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50">Help Center</a></li>
                        <li><a href="#" class="text-white-50">Shipping</a></li>
                        <li><a href="#" class="text-white-50">Returns</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6 class="mb-3">Account</h6>
                    <ul class="list-unstyled">
                        @guest
                            <li><a href="{{ route('login') }}" class="text-white-50">Login</a></li>
                            <li><a href="{{ route('register') }}" class="text-white-50">Register</a></li>
                        @else
                            <li><a href="{{ route('dashboard') }}" class="text-white-50">My Account</a></li>
                            <li><a href="#" class="text-white-50">Orders</a></li>
                        @endguest
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2025 Dopamine Store. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-white-50">Built with Laravel & Bootstrap</small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>