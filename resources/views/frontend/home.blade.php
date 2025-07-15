@extends('frontend.layouts.app')

@section('title', 'Welcome to Dopamine Store')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-5" style="background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Welcome to Dopamine Store</h1>
                <p class="lead mb-4">Discover amazing products that bring joy to your life. Shop with confidence and experience the dopamine rush of finding exactly what you need.</p>
                <div class="d-flex gap-3">
                    <a href="#products" class="btn btn-light btn-lg">Shop Now</a>
                    <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg">Learn More</a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="position-relative">
                    <span class="material-icons" style="font-size: 200px; opacity: 0.3;">shopping_bag</span>
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <span class="material-icons text-warning" style="font-size: 60px;">star</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <span class="material-icons text-primary mb-3" style="font-size: 48px;">local_shipping</span>
                        <h5 class="card-title">Free Shipping</h5>
                        <p class="card-text">Free shipping on orders over $50. Fast and reliable delivery to your doorstep.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <span class="material-icons text-primary mb-3" style="font-size: 48px;">security</span>
                        <h5 class="card-title">Secure Payment</h5>
                        <p class="card-text">Your payment information is protected with bank-level security.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <span class="material-icons text-primary mb-3" style="font-size: 48px;">support_agent</span>
                        <h5 class="card-title">24/7 Support</h5>
                        <p class="card-text">Our customer support team is here to help you anytime, anywhere.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="display-5 fw-bold text-primary mb-3">Shop by Category</h2>
                <p class="lead text-muted">Explore our wide range of product categories</p>
            </div>
        </div>
        <div class="row">
            @forelse($categories as $category)
                <div class="col-lg-2 col-md-4 col-6 mb-4">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body p-3">
                            <span class="material-icons text-primary mb-2" style="font-size: 36px;">category</span>
                            <h6 class="card-title mb-0">{{ $category->name }}</h6>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No categories available. Please add some categories in the admin panel.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section id="products" class="py-5 bg-white">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="display-5 fw-bold text-primary mb-3">Featured Products</h2>
                <p class="lead text-muted">Discover our handpicked selection of amazing products</p>
            </div>
        </div>
        <div class="row">
            @forelse($featuredProducts as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <span class="material-icons text-primary" style="font-size: 64px;">inventory</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($product->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 text-primary mb-0">${{ number_format($product->price, 2) }}</span>
                                <button class="btn btn-outline-primary btn-sm">
                                    <span class="material-icons">add_shopping_cart</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <div class="bg-light rounded p-5">
                        <span class="material-icons text-muted mb-3" style="font-size: 64px;">inventory_2</span>
                        <h4 class="text-muted mb-3">No products available</h4>
                        <p class="text-muted">Start adding products in the admin panel to see them here.</p>
                        @auth
                            @if(auth()->user()->hasRole('admin'))
                                <a href="/admin/products" class="btn btn-primary">Add Products</a>
                            @endif
                        @endauth
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h3 class="fw-bold mb-3">Stay Updated</h3>
                <p class="mb-4">Subscribe to our newsletter and get the latest deals and updates.</p>
                <form class="d-flex gap-2">
                    <input type="email" class="form-control" placeholder="Enter your email" required>
                    <button type="submit" class="btn btn-light">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection