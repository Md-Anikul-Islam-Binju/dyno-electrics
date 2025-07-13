@extends('user.app')
@section('content')
    <style>
        .connect_whatsapp a {
            background-color: var(--color-primary);
            display: block;
            text-align: center;
            color: #fff;
            font-size: 20px;
            text-transform: capitalize;
            font-weight: 700;
            padding: 10px 0px;
            margin-bottom: 20px;
            border-radius: 10px;
        }
        .connect_whatsapp a:hover {
            background-color: #157347;
            border-color: #146c43;
        }
        .connect_whatsapp_size input {
            height: 40px;
        }
    </style>
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
                                            href="{{ URL::to('images/productCustom/' . $image) }}"
                                        >
                                            <img
                                                src="{{ URL::to('images/productCustom/' . $image) }}"
                                                class="img-fluid"
                                                draggable="false"
                                                alt=""
                                            />
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div
                            thumbsSlider=""
                            class="swiper productImage"
                        >
                            <div class="swiper-wrapper">
                                @foreach(json_decode($product->image) as $image)
                                    <div class="swiper-slide">
                                        <img src="{{ URL::to('images/productCustom/' . $image) }}" class="img-fluid" draggable="false" alt="">
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
                        <!-- title -->
                        <h1>{{ $product->name }}</h1>
                        <!-- add to cart -->
                        <div class="connect_whatsapp w-full">
                            <a
                                href="https://wa.me/message/3RAWRY6KRWS3A1?src=rq"
                                target="_blank"
                            >
                                <i class="bi bi-whatsapp"></i>
                                Get Custom Order
                            </a>
                        </div>
                        <!-- available size -->
                        <div
                            class="available_size connect_whatsapp_size"
                        >
                        </div>
                        <div class="product_specification">
                            <h2>Product Specification:</h2>

                            {!!$product->details!!}
                        </div>
                        <div class="our_size_chart">
                            <h2>Our Size Chart: <span>in inches</span></h2>
                            <div class="size_chart_wrapper">
                                <div class="size_chart_head">
                                    <div>Size</div>
                                    <div>Chest</div>
                                    <div>Length</div>
                                </div>
                                <div class="size_chart_body">
                                    @foreach(json_decode($product->size_id) as $sizeId)
                                        @php
                                            $size = \App\Models\Size::find($sizeId);
                                        @endphp
                                        @if ($size)
                                            <div class="size_chart_row">
                                                <div>{{ $size->size }}</div>
                                                <div>{{ $size->chest }}</div>
                                                <div>{{ $size->length }}</div>
                                            </div>
                                        @endif
                                    @endforeach
                                        <br>
                                        <div class="sharethis-inline-share-buttons"></div>
                                    <br>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Happy Customer -->
    <section class="happy_customer_wrapper">
        <div class="container">
            <div class="row">
                <div class="review_section_title common_style">
                    <h2>Happy Customer</h2>
                </div>
            </div>
            <div class="swiper customerReview">
                <div class="swiper-wrapper">
                    @foreach($productReviews as $productReviewsData)
                        <div class="swiper-slide">
                            <div class="review_item">
                                <div class="review_img">
                                    @if($productReviewsData->user->profile!=null)
                                        <img
                                            src="{{asset('images/profile/'.$productReviewsData->user->profile)}}"
                                            draggable="false"
                                            class="img-fluid"
                                            alt=""
                                        />
                                    @else
                                        <img
                                            src="{{URL::to('images/default/pro.jpg')}}"
                                            draggable="false"
                                            class="img-fluid"
                                            alt=""
                                        />
                                    @endif
                                </div>
                                <h2>{{$productReviewsData->user->name}}</h2>
                                <ul>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <li>
                                            <i class="bi {{ $i <= $productReviewsData->ratting ? 'bi-star-fill' : 'bi-star' }}"></i>
                                        </li>
                                    @endfor
                                </ul>
                                <p>
                                    {{$productReviewsData->details}}
                                </p>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>
    <section class="new_arrival_product_wrap related_product">
        <div class="container">
            <div class="row">
                <div class="review_section_title common_style">
                    <h2>Related Products</h2>
                </div>
            </div>
            <div class="row">
                @foreach($relatedProducts as $relatedProductsData)
                    <div class="col-12 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100}}">
                        @php
                            $images = json_decode($relatedProductsData->image, true);
                            $firstImage = $images ? $images[0] : 'default.png';
                        @endphp
                        <div class="product_item">
                            <div class="product_img">
                                @php
                                    $user = Auth::user();
                                @endphp
                                @if($user)
                                    <div class="wishlist_icon">
                                        <a href="#" class="wishlist-toggle " data-product-id="{{ $relatedProductsData->id }}">
                                            <i class="bi bi-heart{{ in_array($relatedProductsData->id, $userWishlist) ? '-fill' : '' }}"></i>
                                        </a>
                                    </div>
                                @else
                                    <div class="wishlist_icon">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" >
                                            <i class="bi bi-heart"></i>
                                        </a>
                                    </div>
                                @endif


                                <a href="{{route('frontend.product.details',$relatedProductsData->id)}}">
                                    <img
                                        src="{{ asset('images/product/' . $firstImage) }}"
                                        draggable="false"
                                        class="img-fluid"
                                        alt=""
                                    />

                                    @if($relatedProductsData->discount_amount!=null)
                                        <div class="product_content">
                                            <div class="discount_price">
                                                {{$relatedProductsData->discount_amount}}
                                                TK.
                                            </div>
                                            <p class="line_through">
                                                {{$relatedProductsData->amount}} TK.
                                            </p>
                                        </div>
                                    @else
                                        <div class="product_content">
                                            <div class="discount_price">
                                                {{$relatedProductsData->amount}}
                                                TK.
                                            </div>
                                        </div>
                                    @endif


                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
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
        </div>
    </section>
    @if(!empty($siteSetting))
        <section class="get_our_customize_wrapper" style="margin-bottom: 50px;">
            <div class="container">
                <a href="{{$siteSetting->customize_link	 ? $siteSetting->customize_link	:''}}">
                    <div class="get_our_customize" data-aos="fade-up">
                        <img
                            src="{{asset($siteSetting? $siteSetting->customize_logo:'' )}}"
                            class="img-fluid"
                            draggable="false"
                            alt=""
                        />
                    </div>
                </a>
                <!-- Bulk Order -->
                <a href="{{route('frontend.bulk.product')}}">
                    <div class="bulk_order_jersey" data-aos="fade-up">
                        <img
                            src="{{asset($siteSetting? $siteSetting->bulk_order_logo:'' )}}"
                            class="img-fluid"
                            draggable="false"
                            alt=""
                        />
                    </div>
                </a>
            </div>
        </section>
    @endif
@endsection

