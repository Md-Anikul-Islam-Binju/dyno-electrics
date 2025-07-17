@extends('user.app')
@section('content')
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $product->name }}">
    <meta property="og:description" content="{{ strip_tags($product->details) }}">
    <meta property="og:image" content="{{ URL::to('images/product/' . json_decode($product->image)[0]) }}">
    <meta property="og:url" content="{{ Request::url() }}">
    <meta property="og:site_name" content="Wings">

    <section class="product_details_block_wrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product_image_gallery">
                        <div class="swiper productImageThumb">
                            <div class="swiper-wrapper">
                                @foreach(json_decode($product->image) as $image)
                                <div class="swiper-slide easyzoom easyzoom--overlay">
                                    <a
                                        href="{{ URL::to('images/product/' . $image) }}"
                                    >
                                        <img
                                            src="{{ URL::to('images/product/' . $image) }}"
                                            class="img-fluid"
                                            draggable="false"
                                            alt=""
                                        />
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div thumbsSlider="" class="swiper productImage">
                            <div class="swiper-wrapper">
                                @foreach(json_decode($product->image) as $image)
                                <div class="swiper-slide">
                                    <img src="{{ URL::to('images/product/' . $image) }}" class="img-fluid" draggable="false" alt="">
                                </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product_block_content">
                        <h1>{{ $product->name }}</h1>

                        <h6>AS index : {{ $product->name }}</h6>
                        <h6>Model No : {{ $product->model_no }}</h6>
                        <h6>Type : {{ $product->type }}</h6>
                        <h6>EAN : {{ $product->ean_no }}</h6>
                        <h6>Brand : {{ $product->brand->name }}</h6>
                        <h6>Category : {{ $product->category->name }}</h6>
                        <h6>Year : {{ $product->year }}</h6>
                        <h6>Product status : {{ $product->status==1? 'Active':'Inactive' }}</h6>

                        <div class="product_specification">
                            <h2>Product Features:</h2>
                            <div class="our_size_chart">
                                <div class="size_chart_wrapper">
                                    <div class="size_chart_body">
                                        @foreach($product->specifications as $specificationsInfo)
                                        <div class="size_chart_row">
                                            <div>{{$specificationsInfo->title}}</div>
                                            <div>{{$specificationsInfo->value}}</div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="product_specification">
                            <h2>Reference Number:</h2>
                            <div class="our_size_chart">
                                <div class="size_chart_wrapper">
                                    <div class="size_chart_body">
                                        @foreach($product->crossReferences as $crossReferencesInfo)
                                            <div class="size_chart_row">
                                                <div>
                                                    <a href="">
                                                        {{$crossReferencesInfo->part_number}}
                                                    </a>
                                                </div>
                                                <div>
                                                    <a href="">
                                                        {{$crossReferencesInfo->company_name}}
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="price_and_stock">

                            @if($product->sale_price!=null)
                                <p class="price">TK. {{ $product->sale_price }}</p>
                                <p class="line_through details_page_discount">TK. {{ $product->price }}</p>
                            @else
                                <p class="price">TK. {{ $product->price }}</p>
                            @endif


                            @if($product->available_stock > 0)
                                <p class="stock">In Stock</p>
                            @else
                                <p class="stock">Out Of Stock</p>
                            @endif
                        </div>
                        <div class="add_to_cart_and_increment">
                            <div class="increment">
                                <button type="button" id="decrement">-</button>
                                <input type="text" id="quantity" name="quantity" value="1" />
                                <button type="button" id="increment">+</button>
                            </div>
                            <div class="add_to_cart">
                                <form id="addToCartForm" action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="size_id" id="size_id" >
                                    <input type="hidden" name="qty" id="cart_qty" >
                                    <input type="hidden" name="delivery_charge" value="{{ $product->delivery_charge }}">
                                    {{--<input type="hidden" name="price" value="{{ $product->amount }}">--}}
                                    <input type="hidden" name="price" value="{{ $product->discount_amount ?? $product->amount }}">
                                    <button type="submit" class="btn btn-success">Add to Cart</button>
                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>





<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stock = {{ $product->available_stock }};

        // Handle size selection
        const sizeRadios = document.querySelectorAll('input[name="available_size"]');
        sizeRadios.forEach(radio => {
            radio.addEventListener('change', function () {
                document.getElementById('size_id').value = this.value;
            });
        });

        // Handle quantity increment and decrement
        const decrementButton = document.getElementById('decrement');
        const incrementButton = document.getElementById('increment');
        const quantityInput = document.getElementById('quantity');

        const updateButtonsState = () => {
            const currentValue = parseInt(quantityInput.value);
            decrementButton.disabled = currentValue <= 1;
            incrementButton.disabled = currentValue >= stock;
        };

        decrementButton.addEventListener('click', function () {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
                updateButtonsState();
            }
        });

        incrementButton.addEventListener('click', function () {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue < stock) {
                quantityInput.value = currentValue + 1;
                updateButtonsState();
            }
        });

        // Initial state check
        updateButtonsState();

        // Update quantity for cart submission
        const addToCartForm = document.getElementById('addToCartForm');
        addToCartForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            // Get selected size and quantity
            let sizeId = document.querySelector('input[name="available_size"]:checked');
            let qty = parseInt(document.getElementById('quantity').value);

            if (sizeId === null) {
                alert('Please select a size.');
                return;
            }

            // Update form inputs with selected size and quantity
            document.getElementById('size_id').value = sizeId.value;
            document.getElementById('cart_qty').value = qty;

            // Submit the form
            this.submit();
        });
    });
</script>
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

