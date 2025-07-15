@extends('user.app')
@section('content')



    <!-- Featured Products Products -->
    <section class="new_arrival_product_wrap">
        <div class="container">
            <div class="row">
                <div class="review_section_title common_style">
                    <h2>Featured Products</h2>
                </div>
            </div>
            <div class="row">
                @foreach($product as  $productData)
                <div class="col-12 col-md-4 col-lg-3">
                    @php
                        $images = json_decode($productData->image, true);
                        $firstImage = $images ? $images[0] : 'default.png';
                    @endphp
                    <a class="product_item" href="{{route('frontend.product.details',$productData->id)}}">
                        <div class="product_img">
                            <img
                                src="{{ asset('images/product/' . $firstImage) }}"
                                draggable="false"
                                class="img-fluid"
                                alt=""
                                style="height: 200px;width: 200px;"
                            />
                            <br> <br> <br> <br>
                            <div class="product_content">
                                <p>Call For Price</p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Kit Partner -->
    <section class="kit_partner_wrapper">
        <div class="container">
            <div class="kit_partner">
                <h2>Compatible with Top Auto Manufacturers</h2>
                <div class="partner_logo_wrap">
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="assets/images/pertner/01.png"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="assets/images/pertner/02.png"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="assets/images/pertner/03.png"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="assets/images/pertner/04.png"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="assets/images/pertner/05.png"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="assets/images/pertner/06.png"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="assets/images/pertner/07.png"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="assets/images/pertner/08.png"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="assets/images/pertner/09.png"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="assets/images/pertner/10.png"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="assets/images/pertner/11.png"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="assets/images/pertner/12.png"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="assets/images/pertner/13.png"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="assets/images/pertner/14.png"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="assets/images/pertner/15.png"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                    <div class="logo_item">
                        <img
                            draggable="false"
                            src="assets/images/pertner/16.png"
                            class="img-fluid"
                            alt=""
                        />
                    </div>
                </div>
            </div>
        </div>
    </section>



@endsection
