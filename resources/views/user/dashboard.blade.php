@extends('user.app')
@section('content')

    <div class="container my-4">
        <div class="row g-3 align-items-stretch">
            <!-- Sidebar Categories -->
            <div class="col-md-3">
                <div class="category-sidebar">

                        @foreach($categories as $key => $cat)
                            <div class="category-item mb-3">
                                <!--<a href='{{url($cat->slug)}}'>-->
                                <span class="category-icon bg-yellow">
                                  <img src="{{ asset('images/category/' . $cat->image) }}" alt="Alternator">
                                </span>
                                <a href='{{ url($cat->slug) }}'>
                                    <span class="category-label">{{$cat->name}}</span>
                                </a>
                            </div>
                            <hr class="divider">
                        @endforeach


                </div>
            </div>

            <!-- Banner with Background Image and Styled Classes -->
            <div class="col-md-9">
                <div class="promo-banner">
                    <div class="promo-content">
                        <p class="promo-subtitle">Built for Reliability and Performance</p>
                        <h2 class="promo-title">Power Up with <br>Premium Parts!</h2>
                        <p class="promo-discount">Discount 10% OFF this week</p>
                        <a href="{{ url('/all-product') }}" class="btn btn-success btn-sm promo-btn">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-4 feature-section">
        <div class="row justify-content-between">
            <div class="col-lg-3 col-md-6 d-flex align-items-center mb-3 feature-item">
                <img src="{{URL::to('frontend/images/delivery.webp')}}" alt="Fast Delivery" class="feature-icon me-3">
                <div>
                    <h6 class="feature-title">Fast Delivery</h6>
                    <p class="feature-desc">Enjoy fast delivery</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 d-flex align-items-center mb-3 feature-item">
                <img src="{{URL::to('frontend/images/wall-clock.webp')}}" alt="Next Day Delivery" class="feature-icon me-3">
                <div>
                    <h6 class="feature-title">Next Day Delivery</h6>
                    <p class="feature-desc">UK 48 hr delivery</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 d-flex align-items-center mb-3 feature-item">
                <img src="{{URL::to('frontend/images/coin.webp')}}" alt="Low Price Guarantee" class="feature-icon me-3">
                <div>
                    <h6 class="feature-title">Low Price Guarantee</h6>
                    <p class="feature-desc">We offer competitive Price</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 d-flex align-items-center mb-3 feature-item">
                <img src="{{URL::to('frontend/images/like.webp')}}" alt="Satisfaction Guarantee" class="feature-icon me-3">
                <div>
                    <h6 class="feature-title">Satisfaction Guarantee</h6>
                    <p class="feature-desc">We Guarantee Our Product</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-4">
        <div class="row g-4">

            <div class="col-md-4">
                <div class="highlight-box" style="background-image: url('{{URL::to('frontend/images/Alternator.webp')}}');">
                    <div class="highlight-cont">
                        <p class="highlight-subtitle">New Arrivals</p>
                        <h4 class="highlight-title">Wide Range</h4>
                        <p class="highlight-desc">Enjoy One Year Warranty on all alternators</p>
                        <a href="https://dynoelectrics.com/product-category/alternator/" class="highlight-link">Shop Now</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="highlight-box" style="background-image: url('{{URL::to('frontend/images/Starter-Motor.webp')}}');">
                    <div class="highlight-cont">
                        <p class="highlight-subtitle">Latest Collection</p>
                        <h4 class="highlight-title">Perfect Starter</h4>
                        <p class="highlight-desc">Get one Year Warranty on every starter motor</p>
                        <a href="https://dynoelectrics.com/product-category/starter-motor/" class="highlight-link">Shop Now</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="highlight-box" style="background-image: url('{{URL::to('frontend//images/Dynamo.webp')}}');">
                    <div class="highlight-cont">
                        <p class="highlight-subtitle">New Arrival</p>
                        <h4 class="highlight-title">Best Quality</h4>
                        <p class="highlight-desc">Enjoy ONE Year Warranty on all dynamos</p>
                        <a href="https://dynoelectrics.com/product-category/dynamo/" class="highlight-link">Shop Now</a>
                    </div>
                </div>
            </div>

        </div>
    </div>







    <div class="container py-4">
        <div class="container my-5">
            <h4>Featured Products</h4>
            <p>Explore Our Best-Selling Alternators, Starters, and Dynamos</p>

            <div class="row g-4">
                @foreach($product as $productData)
                    @php
                        $images = json_decode($productData->image, true);
                        $firstImage = $images ? $images[0] : 'default.png';
                        $user = Auth::user();
                    @endphp

                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product-card position-relative p-3 text-center border rounded shadow-sm">


                            @if($productData->sale_price && $productData->price > 0)
                                @php
                                    $discountPercent = round((($productData->price - $productData->sale_price) / $productData->price) * 100);
                                @endphp
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                                -{{ $discountPercent }}%
                                            </span>
                            @endif

                            <div class="wishlist_icon position-absolute top-0 end-0 m-2">
                                @if($user)
                                    <a href="#" class="wishlist-toggle text-danger" data-product-id="{{ $productData->id }}">
                                        <i class="bi bi-heart{{ in_array($productData->id, $userWishlist) ? '-fill' : '' }} fs-5"></i>
                                    </a>
                                @else
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" class="text-secondary">
                                        <i class="bi bi-heart fs-5"></i>
                                    </a>
                                @endif
                            </div>


                            <a href="{{ route('frontend.product.details', $productData->id) }}">
                                <img src="{{ asset('images/product/' . $firstImage) }}"
                                     alt="{{ $productData->name }}"
                                     class="img-fluid rounded"
                                     style="height: 180px; object-fit: cover;">
                            </a>


                            <p class="mt-3 fw-semibold text-truncate" title="{{ $productData->name }}">
                                {{ $productData->name }}
                            </p>

                            @if($productData->sale_price)
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <span class="fw-bold text-danger">{{ $productData->sale_price }} TK</span>
                                    <span class="text-muted text-decoration-line-through">{{ $productData->price }} TK</span>
                                </div>
                            @else
                                <div class="fw-bold text-dark">{{ $productData->price }} TK</div>
                            @endif


                            @if($productData->sale_price || $productData->price)
                                <a href="{{route('frontend.product.details',$productData->id)}}" class="btn btn-sm btn-success mt-2 add-to-cart" data-product-id="{{ $productData->id }}">
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
    </div>




    <!-- Kit Partner -->
    <section class="kit_partner_wrapper">
        <div class="container">
            <div class="kit_partner">
                <h2>Compatible with Top Auto Manufacturers</h2>
                <div class="partner_logo_wrap">
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="{{URL::to('frontend/images/mitsubishi-logo-768x502.webp')}}"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="{{URL::to('frontend/images/LADA-logo-768x502.webp')}}"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="{{URL::to('frontend/images/Mazda-Logo-768x502.webp')}}"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="{{URL::to('frontend/images/Nissan-logo-768x502.webp')}}"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="{{URL::to('frontend/images/BMW-logo-768x502.webp')}}"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="{{URL::to('frontend/images/vauxhall-logo-768x502.webp')}}"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="{{URL::to('frontend/images/Bentley-logo-768x502.webp')}}"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="{{URL::to('frontend/images/porsche-logo-768x502.webp')}}"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <!--                        <img
                        draggable="false"
                        src="{{URL::to('frontend/images/volvo-logo-768x502.webp')}}"
                        class="img-fluid"
                        alt=""
                    />-->
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
