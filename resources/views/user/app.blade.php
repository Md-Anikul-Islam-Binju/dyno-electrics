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



</head>
<style>
    #searchDropdown {
        max-height: 400px;
        overflow-y: auto;
        width: 100%;
        margin-top: 5px;
        box-shadow: 0 6px 12px rgba(0,0,0,0.175);
    }

    .search-product-item {
        padding: 10px;
        border-bottom: 1px solid #eee;
    }

    .part-numbers-container {
        margin-top: 5px;
        padding-left: 10px;
        border-left: 2px solid #eee;
    }

    .search-part-number-item {
        padding: 5px;
        margin: 2px 0;
        border-radius: 4px;
    }

    .search-part-number-item:hover {
        background-color: #f8f9fa;
    }

    .fw-bold.text-primary {
        color: #0d6efd !important;
    }
</style>
<body>
@php
    $siteSetting = App\Models\SiteSetting::first();
@endphp
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
{{--            <form action="{{ route('frontend.all.product') }}" class="d-flex mx-auto w-50" role="search">--}}
{{--                <input class="form-control rounded-pill px-3" type="search"  name="search" placeholder="Search for products..." aria-label="Search">--}}
{{--            </form>--}}

            <form action="{{ route('frontend.all.product') }}" method="GET" class="d-flex mx-auto w-50 position-relative" role="search" id="searchForm">
                <input class="form-control rounded-pill px-3"
                       type="search"
                       name="search"
                       id="searchInput"
                       placeholder="Search for products or part numbers..."
                       aria-label="Search"
                       autocomplete="off">

                <!-- Dropdown suggestion -->
                <div class="dropdown-menu w-100" id="searchDropdown" style="display: none; position: absolute; top: 100%; left: 0; z-index: 1000;">
                    <div class="list-group" id="searchResults">
                        <!-- AJAX results will appear here -->
                    </div>
                </div>
            </form>

            @php
                $cart=0;
                $cart = Session::get('cart', []);
                $categories = DB::table('categories')->where('status', 1)->get();
            @endphp
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-4">
                <li class="nav-item">
                    <a class="nav-link active" href="/">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Shop</a>
                    <ul class="dropdown-menu">
                        @foreach($categories as $category)
                            <li>
                                <a class="text-decoration-none text-dark dropdown-item" href="{{ route('frontend.all.product', array_merge(['category' => $category->id], request()->except('category'))) }}" class="parent_category">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('user.about.us')}}">About</a>
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
                    <li><a class="text-decoration-none text-dark" href="/">Home Page</a></li>
                    <li><a class="text-decoration-none text-dark" href="/all-product">Visit Shop</a></li>
                    <li><a class="text-decoration-none text-dark" href="/contact-us">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6>Help & Support</h6>
                <ul class="list-unstyled">
                    <li><a class="text-decoration-none text-dark" href="/user/login">Delivery Info</a></li>
                    <li><a class="text-decoration-none text-dark" href="{{route('user.privacy.policy')}}">Privacy Policy</a></li>
                    <li><a class="text-decoration-none text-dark" href="{{route('user.return.policy')}}">Returns & Refunds</a></li>
                    <li><a class="text-decoration-none text-dark" href="{{route('user.terms.condition')}}">Terms & Condition</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6>Contact Information</h6>
                <p>Email: info@dynoelectrics.com</p>
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


<script>
    $(document).ready(function() {
        const searchInput = $('#searchInput');
        const searchDropdown = $('#searchDropdown');
        const searchResults = $('#searchResults');

        searchInput.on('input', function() {
            const term = $(this).val().trim();

            if (term.length < 2) {
                searchDropdown.hide();
                return;
            }

            $.ajax({
                url: '/search-suggestions',
                data: { term: term },
                success: function(data) {
                    if (data.results && data.results.length > 0) {
                        searchResults.empty();

                        data.results.forEach(function(item) {
                            if (item.part_numbers) {
                                let html = `
                                <div class="list-group-item search-product-item" data-id="${item.id}">
                                    <div class="fw-bold mb-1">${item.text}</div>
                                    <div class="d-flex justify-content-between small py-1 px-2 rounded">
                                        <span class="fw-bold text-primary">${item.part_numbers[0]}</span>
                                        <span class="text-muted">${item.company_names[0]}</span>
                                    </div>
                                </div>`;
                                searchResults.append(html);
                            } else {
                                searchResults.append(`
                                <div class="list-group-item search-item" data-id="${item.id}">
                                    ${item.text}
                                </div>`);
                            }
                        });

                        searchDropdown.show();
                    } else {
                        searchDropdown.hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Search error:', error);
                    searchDropdown.hide();
                }
            });
        });
        $(document).on('click', '.search-product-item, .search-item', function() {
            const productId = $(this).data('id');
            if (productId) {
                window.location.href = `/product-details/${productId}`;
            }
        });
    });

</script>
</body>
</html>
