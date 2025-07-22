@extends('user.app')
@section('content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; }
        .top-bar { background: #000; color: #fff; font-size: 14px; }
        .top-bar a { color: #fff; text-decoration: none; margin: 0 10px; }
        .logo img { max-height: 50px; }
        .hero-banner { background: #f6fff6; padding: 20px; border-radius: 10px; }
        .category-sidebar { background: #fff; border: 1px solid #ddd; border-radius: 10px; padding: 15px; }
        .category-sidebar ul { list-style: none; padding: 0; }
        .category-sidebar li { padding: 8px 0; }
        .info-strip { background: #f8f9fa; padding: 15px; text-align: center; }
        .info-strip i { font-size: 24px; color: #28a745; }
        .product-banner { border-radius: 10px; padding: 20px; color: #fff; text-align: center; }
        .product-card { border: 1px solid #ddd; border-radius: 10px; padding: 15px; text-align: center; }
        .discount-badge { position: absolute; top: 10px; left: 10px; background: #28a745; color: #fff; padding: 5px 8px; font-size: 12px; border-radius: 5px; }
        .brand-logos img { max-height: 40px; margin: 10px; opacity: 0.8; }
        footer { background: #f8f9fa; padding: 40px 0; }
    </style>

    <!-- Hero Section -->
    <section class="container my-4">
        <div class="row h-100">
            <div class="col-md-3 h-100">
                <div class="category-sidebar">
                    <h5>Categories</h5>
                    <ul>
                        @foreach($categories as $category)
                            <li>
                                <a class="text-decoration-none text-dark" href="{{ route('frontend.all.product', array_merge(['category' => $category->id], request()->except('category'))) }}" class="parent_category">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-md-9">
                <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($sliders as $key => $slider)
                            <div class="carousel-item @if($key == 0) active @endif">
                                <img src="{{ URL::to('images/slider/' . $slider->image) }}" class="d-block w-100 rounded" alt="{{ $slider->title ?? 'Slider Image' }}">

                                @if(!empty($slider->title) || !empty($slider->description))
                                    <div class="carousel-caption d-none d-md-block text-start">
                                        @if(!empty($slider->title))
                                            <h5 class="text-dark">{{ $slider->title }}</h5>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>

                    <!-- Indicators -->
                    <div class="carousel-indicators">
                        @foreach($sliders as $key => $slider)
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $key }}"
                                    @if($key == 0) class="active" aria-current="true" @endif></button>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Info Strip -->
   <div class="container">
       <div class="info-strip d-flex justify-content-around">
           <div><i class="fa fa-truck"></i><p>Fast Delivery</p></div>
           <div><i class="fa fa-clock"></i><p>Order Before 2:30 PM</p></div>
           <div><i class="fa fa-tag"></i><p>Low Price Guarantee</p></div>
           <div><i class="fa fa-shield"></i><p>Satisfaction Guarantee</p></div>
       </div>
   </div>

    <!-- Product Highlight Banners -->
    <section class="container my-4">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="product-banner" style="background:#ffc107;">New Arrivals - Wide Range<br><a href="#" class="text-white">Shop Now</a></div>
            </div>
            <div class="col-md-4">
                <div class="product-banner" style="background:#28a745;">Latest Collection - Perfect Starter<br><a href="#" class="text-white">Shop Now</a></div>
            </div>
            <div class="col-md-4">
                <div class="product-banner" style="background:#17a2b8;">Best Quality - New Arrival<br><a href="#" class="text-white">Shop Now</a></div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="container my-5">
        <h3 class="text-center mb-4">Featured Products</h3>
        <div class="row g-4">
            @foreach($product as  $productData)
            <div class="col-md-3">
                @php
                    $images = json_decode($productData->image, true);
                    $firstImage = $images ? $images[0] : 'default.png';
                @endphp
                <div class="product-card position-relative">
{{--                    <div class="discount-badge">15% OFF</div>--}}
                    <img src="{{ asset('images/product/' . $firstImage) }}" class="img-fluid" alt="Product">
                    <h6 class="mt-2">{{$productData->name}}</h6>
                    {{--<p><del>£78.87</del> £66.32</p>--}}
                    <a href="{{route('frontend.product.details',$productData->id)}}" class="btn btn-success btn-sm">Call For Price</a>
                </div>
            </div>
            @endforeach
            <!-- Repeat more product cards -->
        </div>
    </section>

    <!-- Auto Brands -->
    <section class="container text-center my-5">
        <h4>Compatible with Top Auto Manufacturers</h4>
        <div class="brand-logos d-flex flex-wrap justify-content-center mt-3">
            <img src="{{URL::to('frontend/images/mitsubishi-logo-768x502.webp')}}">
            <img src="{{URL::to('frontend/images/LADA-logo-768x502.webp')}}">
            <img src="{{URL::to('frontend/images/Mazda-Logo-768x502.webp')}}">
            <img src="{{URL::to('frontend/images/BMW-logo-768x502.webp')}}">
            <img src="{{URL::to('frontend/images/Bentley-logo-768x502.webp')}}">
        </div>
    </section>

{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>--}}

@endsection
