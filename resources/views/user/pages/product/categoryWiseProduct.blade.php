@extends('user.app')
@section('content')

    <section class="alternator-intro py-5 bg-light">
        <div class="container">
            <!-- Intro Heading -->
            <h2 class="fw-bold text-center mb-3">
                Alternators for All Makes and Models – <span class="text-success">Dyno Electrics</span>
            </h2>

            <!-- Subtitle -->
            <p class="lead text-center text-muted mb-4">
                At Dyno Electrics, we understand how critical your car’s alternator is to keeping everything running smoothly.
            </p>

            <!-- Intro Content -->
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center text-md-start">
                    <p class="mb-4">
                        Your alternator charges the battery and powers the starter motor, ignition, and essential electronics while driving.
                        Without a functioning alternator, your car’s electrical system could fail, leaving you stranded.
                        That’s why we stock a wide range of alternators for all makes and models, ensuring you’ll find the perfect fit for your vehicle.
                    </p>

                    <h5 class="fw-semibold">Why Choose Dyno Electrics?</h5>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-2">✅ <strong>Wide Selection:</strong> Thousands of alternators in stock, both new and reconditioned, fitting any budget.</li>
                        <li class="mb-2">✅ <strong>Fast Delivery:</strong> Order by 5pm and enjoy next-day delivery across most UK destinations.</li>
                        <li class="mb-2">✅ <strong>Quality & Reliability:</strong> High-quality products at competitive prices, real value for money.</li>
                        <li class="mb-2">✅ <strong>Expert Support:</strong> Unsure which alternator you need? Our team helps you get the right part for your vehicle.</li>
                    </ul>

                    <p class="mb-0">
                        <strong>How Long Does an Alternator Last?</strong>
                        Most alternators last around <strong>80,000 to 150,000 miles</strong>, depending on your vehicle’s make and model.
                        Regular checks prevent unexpected breakdowns and keep your alternator working at its best.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Section -->
    <section class="new_arrival_product_wrap product_page_wrap py-5">
        <div class="container">
            <!-- Section Title -->
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h3 class="fw-bold">Select Your Alternator</h3>
                    <p class="text-muted">Browse our top-quality alternators, starters, and dynamos</p>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="row g-3">
                @foreach($products as $product)
                    @php
                        $images = json_decode($product->image, true);
                        $firstImage = $images ? $images[0] : 'default.png';
                        $user = Auth::user();
                    @endphp

                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product-card position-relative p-3 text-center border rounded shadow-sm h-100">

                            {{-- Discount Badge --}}
                            @if($product->sale_price && $product->price > 0)
                                @php $discountPercent = round((($product->price - $product->sale_price) / $product->price) * 100); @endphp
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                -{{ $discountPercent }}%
                            </span>
                            @endif

                            {{-- Wishlist --}}
                            <div class="wishlist_icon position-absolute top-0 end-0 m-2">
                                @if($user)
                                    <a href="#" class="wishlist-toggle text-danger" data-product-id="{{ $product->id }}">
                                        <i class="bi bi-heart{{ in_array($product->id, $userWishlist) ? '-fill' : '' }} fs-5"></i>
                                    </a>
                                @else
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" class="text-secondary">
                                        <i class="bi bi-heart fs-5"></i>
                                    </a>
                                @endif
                            </div>

                            {{-- Product Image --}}
                            <a href="{{ route('frontend.product.details', $product->id) }}">
                                <img src="{{ asset('images/product/' . $firstImage) }}"
                                     alt="{{ $product->name }}"
                                     class="img-fluid rounded"
                                     style="height: 180px; object-fit: cover;">
                            </a>

                            {{-- Product Name --}}
                            <p class="mt-3 fw-semibold text-truncate" title="{{ $product->name }}">
                                {{ $product->name }}
                            </p>

                            {{-- Price --}}
                            @if($product->sale_price)
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <span class="fw-bold text-danger">{{ $product->sale_price }} $</span>
                                    <span class="text-muted text-decoration-line-through">{{ $product->price }} $</span>
                                </div>
                            @else
                                <div class="fw-bold text-dark">{{ $product->price }} $</div>
                            @endif

                            {{-- Add to Cart --}}
                            @if($product->sale_price || $product->price)
                                <a href="{{ route('frontend.product.details', $product->id) }}" class="btn btn-sm btn-success mt-2">
                                    <i class="bi bi-cart-plus"></i> Add to Cart
                                </a>
                            @else
                                <a href="tel:0123456789" class="btn btn-warning btn-sm mt-2">
                                    📞 Call for Price
                                </a>
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="row mt-4">
                <div class="col-md-8 col-sm-12">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
                <div class="col-md-4 text-end">
                    <p>Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} ({{ $products->lastPage() }} Pages)</p>
                </div>
            </div>
        </div>
        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">User Login</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('user.login.post') }}"> @csrf

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" required name="email" placeholder="Enter your email*" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" required name="password" placeholder="Enter your password*" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn_style w-100"> Login </button>
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <p> Don't have an account? <a href="{{ route('user.register') }}" class="text-decoration-underline">Register</a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfTokenMeta.getAttribute('content');

            document.querySelectorAll('.wishlist-toggle').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const productId = this.getAttribute('data-product-id');

                    fetch('/wishlist/toggle', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ product_id: productId })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.redirect) {
                                window.location.href = data.redirect; // Redirect to login page
                            } else {
                                // Handle toggling heart icon
                                if (data.status === 'added') {
                                    this.querySelector('i').classList.add('bi-heart-fill');
                                    this.querySelector('i').classList.remove('bi-heart');
                                } else if (data.status === 'removed') {
                                    this.querySelector('i').classList.remove('bi-heart-fill');
                                    this.querySelector('i').classList.add('bi-heart');
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error.message);

                        });
                });
            });
        });
    </script>
@endsection
