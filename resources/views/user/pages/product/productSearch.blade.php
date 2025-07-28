@extends('user.app')
@section('content')
    <div class="container py-5">
        <h3 class="mb-4 text-center">Search Products</h3>

        <form method="GET" action="{{ route('product.search') }}" class="row g-3 mb-4">
            <div class="col-md-3">
                <select name="category_id" class="form-control">
                    <option value="">-- Select Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <select name="brand_id" class="form-control">
                    <option value="">-- Select Brand --</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <input type="text" name="model_no" class="form-control" placeholder="Model No" value="{{ request('model_no') }}">
            </div>

            <div class="col-md-3">
                <input type="text" name="volt" class="form-control" placeholder="Volt" value="{{ request('volt') }}">
            </div>

            <div class="col-md-3">
                <input type="text" name="kw" class="form-control" placeholder="KW" value="{{ request('kw') }}">
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-success">Search</button>
            </div>

{{--            <div class="col-12 text-center">--}}
{{--                <button type="submit" class="btn btn-success">Search</button>--}}
{{--            </div>--}}
        </form>

        @if ($products->isEmpty())
            <p class="text-center text-muted">No products found. Use filters above to search.</p>
        @else
            <div class="container py-4">
                <div class="container my-5">
                    <h4>Filtered Products</h4>
                    <p>Explore Your Matched Alternators, Starters, and Dynamos</p>

                    <div class="row g-4">
                        @foreach($products as $productData)
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
                                                <i class="bi bi-heart{{ in_array($productData->id, $userWishlist ?? []) ? '-fill' : '' }} fs-5"></i>
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
                                            <span class="fw-bold text-danger">{{ $productData->sale_price }} $</span>
                                            <span class="text-muted text-decoration-line-through">{{ $productData->price }} $</span>
                                        </div>
                                    @else
                                        <div class="fw-bold text-dark">{{ $productData->price }} $</div>
                                    @endif

                                    @if($productData->sale_price || $productData->price)
                                        <a href="{{ route('frontend.product.details', $productData->id) }}" class="btn btn-sm btn-success mt-2 add-to-cart" data-product-id="{{ $productData->id }}">
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

                {{-- Login Modal --}}
                <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">User Login</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('user.login.post') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" required placeholder="Enter your email*" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" name="password" required placeholder="Enter your password*" />
                                    </div>
                                    <button type="submit" class="btn btn-success w-100">Login</button>
                                    <p class="text-center mt-3">Don't have an account? <a href="{{ route('user.register') }}">Register</a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endif
    </div>
@endsection
