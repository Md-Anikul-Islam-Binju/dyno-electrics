@extends('user.app')
@section('content')

    <section class="py-5">
        <div class="container">
            <!-- Section Title -->
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h3 class="fw-bold">Select Your Alternator</h3>
                    <p class="text-muted">Browse our top-quality alternators, starters, and dynamos</p>
                </div>
            </div>

            <div class="row">
                <!-- Product List -->
                <div class="col-lg-9">
                    @foreach($products as $product)
                        @php
                            $images = json_decode($product->image, true);
                            $firstImage = $images ? $images[0] : 'default.png';
                        @endphp
                        <div class="d-flex border rounded shadow-sm mb-3 p-3 align-items-center">
                            <!-- Image -->
                            <div class="flex-shrink-0 me-3">
                                <img src="{{ asset('images/product/' . $firstImage) }}" alt="{{ $product->name }}"
                                     class="img-fluid" style="width: 120px; height: 120px; object-fit: contain;">
                            </div>

                            <!-- Details -->
                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ $product->name }}</h5>
                                <p class="mb-1 text-muted">{{ $product->short_description ?? 'Product short description here.' }}</p>

                                <p class="mb-1">
                                    <strong>Category:</strong> {{ $product->category->name ?? 'N/A' }} |
                                    <strong>Brand:</strong> {{ $product->brand->name ?? 'N/A' }}<br>
                                   @foreach($product->specifications as $info)
                                        <strong>{{ $info->title }}:</strong> {{ $info->value }}
                                    @endforeach
                                </p>

                                <!-- Price -->
                                @if($product->sale_price)
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="fw-bold text-danger">{{ $product->sale_price }} $</span>
                                        <span class="text-muted text-decoration-line-through">{{ $product->price }} $</span>
                                    </div>
                                @else
                                    <span class="fw-bold text-dark">{{ $product->price }} $</span>
                                @endif

                                <!-- Action -->
                                <div class="mt-2">
                                    <a href="{{ route('frontend.product.details', $product->id) }}" class="btn btn-sm btn-outline-success">
                                        View Details
                                    </a>
                                </div>
                            </div>

                            <!-- Stock level -->
                            <div class="ms-3 text-center">
                                <p class="fw-bold mb-1">Stock</p>
                                <div class="d-flex flex-column gap-1">
                                    <span class="badge bg-success">🇩🇪 {{ $product->stock ?? 0 }}</span>
                                    <span class="badge bg-danger">🇮🇹 {{ $product->stock ?? 0 }}</span>
                                    <span class="badge bg-warning">🇪🇸 {{ $product->stock ?? 0 }}</span>
                                    <span class="badge bg-secondary">🇬🇧 {{ $product->stock ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $products->links('pagination::bootstrap-4') }}
                    </div>
                </div>

                <!-- Filter Sidebar -->
{{--                <div class="col-lg-3">--}}
{{--                    <div class="border p-3 rounded shadow-sm">--}}
{{--                        <h5 class="mb-3">Alternators</h5>--}}

{{--                        <!-- Voltage -->--}}
{{--                        <div class="mb-3">--}}
{{--                            <label class="form-label fw-bold">Voltage [V]</label>--}}
{{--                            <div>--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" name="voltage[]" value="12" id="volt12">--}}
{{--                                    <label class="form-check-label" for="volt12">12 V</label>--}}
{{--                                </div>--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" name="voltage[]" value="24" id="volt24">--}}
{{--                                    <label class="form-check-label" for="volt24">24 V</label>--}}
{{--                                </div>--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" name="voltage[]" value="48" id="volt48">--}}
{{--                                    <label class="form-check-label" for="volt48">48 V</label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}


{{--                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="col-lg-3">
                    <form method="GET" action="{{ route('category.wise.product', $slug) }}">
                        <div class="border p-3 rounded shadow-sm">
                            <h5 class="mb-3">Alternators</h5>

                            <!-- Voltage -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Voltage [V]</label>
                                @php
                                    $selectedVoltages = request()->get('voltage', []);
                                @endphp
                                <div>
                                    @foreach(['12', '24', '48'] as $volt)
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   name="voltage[]"
                                                   value="{{ $volt }}"
                                                   id="volt{{ $volt }}"
                                                {{ in_array($volt, $selectedVoltages) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="volt{{ $volt }}">{{ $volt }} V</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>




@endsection
