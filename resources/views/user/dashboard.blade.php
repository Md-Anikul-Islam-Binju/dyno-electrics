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
                                <a href='{{ route('frontend.all.product', array_merge(['category' => $cat->id], request()->except('category'))) }}'>
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
                @foreach($product as  $productData)
                    @php
                        $images = json_decode($productData->image, true);
                        $firstImage = $images ? $images[0] : 'default.png';
                    @endphp
                    <div class="col-md-3">
                        <div class="product-card">
                            <img src="{{ asset('images/product/' . $firstImage) }}" alt="{{ $productData->name }}">
                            <p class="mt-2">{{ $productData->name }}</p>
                            <a href="{{route('frontend.product.details',$productData->id)}}" class="call-btn">Call for Price</a>
                        </div>
                    </div>
                @endforeach
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


@endsection
