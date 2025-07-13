<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dyno Electrics</title>
    <link rel="icon" href="{{ asset('frontend/images/favicon.ico') }}" type="image/x-icon"/>
    <link rel="stylesheet" href="{{ asset('frontend/plugin/bootstrap/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('frontend/plugin/aos/aos.css') }}"/>
    <link rel="stylesheet" href="{{ asset('frontend/plugin/swiper/swiper-bundle.min.css') }}"/>
    <link rel="stylesheet" href="{{asset('frontend/plugin/bootstrap-icons/bootstrap-icons.css')}}"/>
    <link rel="stylesheet" href="{{ asset('frontend/plugin/easyzoom/easyzoom.css') }}"/>
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" />
    <link rel="stylesheet" href="https://pritesh-ecom.golamsoroar.com/css/style.css">
</head>
<body>
@php
    $siteSetting = App\Models\SiteSetting::first();
@endphp
<div class="topbar-marquee py-1">
    <div class="marquee-wrapper">
        <div class="marquee-content">
            <span>Sign up and get 10% off</span>
            <span>Enjoy fast next-day delivery on all UK Mainland</span>
            <span>New arrivals in stock – shop now!</span>
            <span>Welcome to Dyno Electrics</span>
            <span>Sign up and get 10% off</span>
            <span>Enjoy fast next-day delivery on all UK Mainland</span>
            <span>New arrivals in stock – shop now!</span>
            <span>Welcome to Dyno Electrics</span>
        </div>
    </div>
</div>
<nav class="navbar navbar-expand-lg bg-white border-bottom py-3">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="/">
            <img src="{{URL::to($siteSetting->logo ? $siteSetting->logo:'')}}" alt="DYNO ELECTRICS" style="height: 50px;">
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <!-- Search -->
            <form action="{{ route('frontend.all.product') }}" class="d-flex mx-auto w-50" role="search">
                <input class="form-control rounded-pill px-3" type="search"  name="search" placeholder="Search for products..." aria-label="Search">
            </form>
            @php
                $cart=0;
                $cart = Session::get('cart', []);
            @endphp
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-4">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Shop</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Alternators</a></li>
                        <li><a class="dropdown-item" href="#">Starter Motors</a></li>
                        <li><a class="dropdown-item" href="#">Dynamos</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
            </ul>


            <div class="header_action">
                <ul>
                    @php
                        $wishlists = App\Models\Wishlist::where('user_id', Auth::id())->count();
                    @endphp
                    <li>
                        <a href="{{route('wishlist')}}">
                            <i class="bi bi-heart"></i>
                            <span>{{$wishlists}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cart.show') }}">
                            <i class="bi bi-cart"></i>
                            <span>{{ count($cart) }}</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown profile_image">
                        @if(Auth::check())
                            <a
                                href="#"
                                class="d-block link-dark text-decoration-none dropdown-toggle"
                                id="dropdownUser1"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                @php
                                    $user = Auth::user();
                                @endphp
                                @if($user->profile!=null)
                                    <img
                                        draggable="false"
                                        src="{{URL::to('images/profile/'.$user->profile)}}"
                                        alt="mdo"
                                        class="rounded-circle"
                                    />
                                @else
                                    <img
                                        draggable="false"
                                        src="{{URL::to('images/default/pro.jpg')}}"
                                        alt="mdo"
                                        class="rounded-circle"
                                    />
                                @endif
                            </a>
                            <div
                                class="dropdown-menu"
                                aria-labelledby="profileDropdown"
                            >
                                <a
                                    class="dropdown-item"
                                    href="{{ url('/') }}"
                                >Home</a
                                >
                                <a
                                    class="dropdown-item"
                                    href="{{ route('user.my.profile') }}"
                                >My Profile</a
                                >
                                <a
                                    class="dropdown-item border-0"
                                    href="{{ route('user.logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                >
                                    Logout
                                </a>
                                <form
                                    id="logout-form"
                                    action="{{ route('user.logout') }}"
                                    method="POST"
                                    style="display: none"
                                >
                                    @csrf
                                </form>
                            </div>
                        @else
                            <div class="account_warp">
                                <i class="bi bi-person-fill"></i>
                                <div class="">
                                    <a
                                        class="heading_style"
                                        href="{{ route('user.login') }}"
                                    >
                                        Account
                                    </a>
                                    <p>
                                        <a href="{{ route('user.login') }}"
                                        >Login</a
                                        >
                                    </p>
                                </div>
                            </div>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<main>
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-light text-dark mt-5 pt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <img src="{{URL::to($siteSetting->logo ? $siteSetting->logo:'')}}" alt="DYNO ELECTRICS" height="40">
                <p class="mt-2 small">
                    Dyno Electrics specializes in high quality automotive electrical parts...
                </p>
            </div>
            <div class="col-md-3">
                <h6>Quick link</h6>
                <ul class="list-unstyled">
                    <li><a href="#">Home Page</a></li>
                    <li><a href="#">Visit Shop</a></li>
                    <li><a href="#">Blog & News</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6>Help & Support</h6>
                <ul class="list-unstyled">
                    <li><a href="#">My account</a></li>
                    <li><a href="#">Delivery Info</a></li>
                    <li><a href="#">Returns & Refunds</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6>Contact Information</h6>
                <p>Email: <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="a6cfc8c0c9e6c2dfc8c9c3cac3c5d2d4cfc5d588c5c9cb">[email&#160;protected]</a></p>
                <p>Phone: +44 7947 242444</p>
                <p>Address: 2, Norbreck Parade, London, NW10 7HR</p>
            </div>
        </div>
        <div class="text-center py-3 small">Copyright © 2025 Dynoelectrics.com</div>
    </div>
</footer>


<a href="#" class="scroll-top d-flex align-items-center justify-content-center active">
    <i class="bi bi-arrow-up-short"></i>
</a>
<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=66aa01ff566923001d52f0f0&product=inline-share-buttons&source=platform" async="async"></script>
<script src="{{asset('frontend/plugin/jquery/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset('frontend/plugin/bootstrap/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('frontend/plugin/aos/aos.js') }}"></script>
<script src="{{asset('frontend/plugin/swiper/swiper-bundle.min.js')}}"></script>
<script src="{{asset('frontend/plugin/easyzoom/easyzoom.js') }}"></script>
<script src="{{ asset('frontend/js/main.js') }}"></script>
</body>
</html>
