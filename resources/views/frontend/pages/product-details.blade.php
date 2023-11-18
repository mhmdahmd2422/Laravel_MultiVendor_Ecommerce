@extends('frontend.layouts.master')
@section('title')
    {{$settings->site_name}} || Product Details
@endsection
@section('content')
    <!--============================
        PRODUCT DETAILS START
    ==============================-->
    <section id="wsus__product_details">
        <div class="container">
            <div class="wsus__details_bg">
                <div class="row">
                    <div class="col-xl-4 col-md-5 col-lg-5" style="z-index: 1 !important;">
                        <div id="sticky_pro_zoom">
                            <div class="exzoom hidden" id="exzoom">
                                <div class="exzoom_img_box">
                                    @if($product->video_link)
                                        <a class="venobox wsus__pro_det_video" data-autoplay="true" data-vbtype="video"
                                           href="{{$product->video_link}}">
                                            <i class="fas fa-play"></i>
                                        </a>
                                    @endif
                                    <ul class='exzoom_img_ul'>
                                        <li><img class="zoom ing-fluid w-100" src="{{url(asset($product->thumb_image))}}" alt="product"></li>
                                        @if($product->gallery->isNotEmpty())
                                            @foreach($product->gallery as $image)
                                                <li><img class="zoom ing-fluid w-100" src="{{url(asset($image->image))}}" alt="product"></li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                @if($product->gallery->isNotEmpty())
                                    <div class="exzoom_nav"></div>
                                    <p class="exzoom_btn">
                                        <a href="javascript:void(0);" class="exzoom_prev_btn"> <i
                                                class="far fa-chevron-left"></i> </a>
                                        <a href="javascript:void(0);" class="exzoom_next_btn"> <i
                                                class="far fa-chevron-right"></i> </a>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-md-7 col-lg-7">
                        <div class="wsus__pro_details_text">
                            <a class="title" href="javascript:;">{{$product->name}}</a>
                            <p class="wsus__stock_area">
                                @if(checkStock($product))
                                    <span class="in_stock">in stock</span>
                                @else
                                    <span class="out_stock">out of stock</span>
                                @endif
                                <span>({{$product->quantity}} item)</span>
                            </p>
                            @if(checkDiscount($product))
                                <h4>{{$settings->currency_icon}}{{$product->offer_price}}.00 <del>{{$settings->currency_icon}}{{$product->price}}.00</del></h4>
                            @else
                                <h4>{{$settings->currency_icon}}{{$product->price}}</h4>
                            @endif
                            <p class="review">
                                @php
                                    $avg_rate = $product->reviews()->avg('rate');
                                @endphp
                                @for($i = 0; $i<$avg_rate; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                                @for($j = $i; $j<5; $j++)
                                    <i class="far fa-star"></i>
                                @endfor
                                <span class="z-0">({{$product->reviews->count()}} review)</span>
                            </p>
                            <p class="description" style="font-style: italic; font-size: large">{!! $product->short_description !!}</p>
                            <p class="brand_model"><span style="font-weight: bold">model :</span> {{$product->sku?? 'Not Provided'}}</p>
                            <p class="brand_model mb-4"><span style="font-weight: bold">brand :</span> {{ucfirst($product->brand->name)}}</p>

                            @if(checkDiscount($product))
                                <div class="wsus_pro_hot_deals">
                                    <h5>offer ending In : </h5>
                                    <div class="simply-countdown simply-countdown-one"></div>
                                </div>
                            @endif
                            <form class="shopping-cart-form">
                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                @foreach($variants as $variant)
                                    <div class="wsus__selectbox">
                                        <div class="row">
                                            <div class="col-xl-6 col-sm-6">
                                                <h5 class="mb-2">select {{$variant->name}}:</h5>
                                                <select class="select_2" name="variant_items[]">
                                                    @foreach($variant->ActiveVariantItems as $item)
                                                        <option {{$item->is_default == 1 ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}} ({{$settings->currency_icon}}{{$item->price}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="wsus__quentity">
                                    <h5>quantity :</h5>
                                    <div class="select_number">
                                        <input name="quantity" class="number_area" type="text" min="1" max="{{$product->quantity}}" value="1" />
                                    </div>
                                </div>

                                <ul class="wsus__button_area">
                                    <li><button type="submit" class="add_cart" href="#">add to cart</button></li>
{{--                                    <li><a class="buy_now" href="#">buy now</a></li>--}}
                                    <li><a href="#" class="add-to-wishlist" data-id="{{$product->id}}"><i class="fal fa-heart"></i></a></li>
{{--                                    <li><a href="#"><i class="far fa-random"></i></a></li>--}}
                                </ul>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__pro_det_description">
                        <div class="wsus__details_bg">
                            <ul class="nav nav-pills mb-3" id="pills-tab3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link info-view {{session()->has('product_info_view_style') && session()->get('product_info_view_style') === 'desc'? 'active show': ''}} {{!session()->has('product_info_view_style')? 'active': ''}}" data-id="desc" id="pills-home-tab7" data-bs-toggle="pill"
                                            data-bs-target="#pills-home22" type="button" role="tab"
                                            aria-controls="pills-home" aria-selected="true">Description</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link info-view {{session()->has('product_info_view_style') && session()->get('product_info_view_style') === 'vendor'? 'active': ''}}" data-id="vendor" id="pills-contact-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-contact" type="button" role="tab"
                                            aria-controls="pills-contact" aria-selected="false">Vendor Info</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link info-view {{session()->has('product_info_view_style') && session()->get('product_info_view_style') === 'reviews'? 'active': ''}}" data-id="reviews" id="pills-contact-tab2" data-bs-toggle="pill"
                                            data-bs-target="#pills-contact2" type="button" role="tab"
                                            aria-controls="pills-contact2" aria-selected="false">Reviews</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link info-view {{session()->has('product_info_view_style') && session()->get('product_info_view_style') === 'faqs'? 'active': ''}}" data-id="faqs" id="pills-contact-tab239" data-bs-toggle="pill"
                                            data-bs-target="#pills-contact239" type="button" role="tab"
                                            aria-controls="pills-contact239" aria-selected="false">faqs</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent4">
                                <div class="tab-pane fade {{session()->has('product_info_view_style') && session()->get('product_info_view_style') === 'desc'? 'show active': ''}}{{!session()->has('product_info_view_style')? 'show active': ''}}" id="pills-home22" role="tabpanel"
                                     aria-labelledby="pills-home-tab7">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="wsus__description_area">

                                                <p>{!! $product->long_description !!}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4 col-md-4">
                                                <div class="description_single">
                                                    <h6><span>1</span> Free Shipping & Return</h6>
                                                    <p>We offer free shipping for products on orders above 50$ and
                                                        offer
                                                        free delivery for all orders in US.</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4">
                                                <div class="description_single">
                                                    <h6><span>2</span> Free and Easy Returns</h6>
                                                    <p>We guarantee our products and you could get back all of your
                                                        money anytime you want in 30 days.</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4">
                                                <div class="description_single">
                                                    <h6><span>3</span> Special Financing </h6>
                                                    <p>Get 20%-50% off items over 50$ for a month or over 250$ for a
                                                        year with our special credit card.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade {{session()->has('product_info_view_style') && session()->get('product_info_view_style') === 'vendor'? 'show active': ''}}" id="pills-contact" role="tabpanel"
                                     aria-labelledby="pills-contact-tab">
                                    <div class="wsus__pro_det_vendor">
                                        <div class="row">
                                            <div class="col-xl-6 col-xxl-5 col-md-6">
                                                <div class="wsus__vebdor_img">
                                                    <img src="{{url(asset($product->vendor->banner))}}" alt="vendor" class="img-fluid w-100">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-xxl-7 col-md-6 mt-4 mt-md-0">
                                                <div class="wsus__pro_det_vendor_text">
                                                    <h4>{{$product->vendor->user->name}}</h4>
                                                    <p class="rating">
                                                        @php
                                                            $avg_rate = $product->reviews()->avg('rate');
                                                        @endphp
                                                        @for($i = 0; $i<$avg_rate; $i++)
                                                            <i class="fas fa-star"></i>
                                                        @endfor
                                                        @for($j = $i; $j<5; $j++)
                                                            <i class="far fa-star"></i>
                                                        @endfor
                                                        <span>({{$product->reviews->count()}} review)</span>
                                                    </p>
                                                    <p>{!!$product->vendor->description!!}</p>
                                                    <p><span>Store Name:</span>{{$product->vendor->name}}</p>
                                                    <p><span>Address:</span>{{$product->vendor->address}}</p>
                                                    <p><span>Phone:</span> {{$product->vendor->phone}}</p>
                                                    <p><span>mail:</span> {{$product->vendor->email}}</p>
                                                    <a href="{{route('products.index', ['vendor' => $product->vendor->id])}}" class="see_btn">visit store</a>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="wsus__vendor_details">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade {{session()->has('product_info_view_style') && session()->get('product_info_view_style') === 'reviews'? 'show active': ''}}" id="pills-contact2" role="tabpanel"
                                     aria-labelledby="pills-contact-tab2">
                                    <div class="wsus__pro_det_review">
                                        <div class="wsus__pro_det_review_single">
                                            <div class="row">
                                                @php
                                                    $isBought = false;
                                                    $orders = \App\Models\Order::where(['user_id' => auth()->id(), 'order_status' => 'delivered'])->get();
                                                    foreach($orders as $order){
                                                        $item = $order->products()->where('product_id', $product->id)->first();
                                                        if($item){
                                                            $isBought = true;
                                                        }
                                                    }
                                                @endphp
                                                <div class="{{$isBought? 'col-xl-8 col-lg-7': 'col-xl-12 col-lg-12'}}">
                                                    <div class="wsus__comment_area">
                                                        <h4>Reviews <span>{{$reviews->count()}}</span></h4>
                                                        @if($reviews->isEmpty())
                                                            <h5 style="margin-top: 1.5rem">No Reviews Yet.</h5>
                                                        @endif
                                                        @foreach($reviews as $review)
                                                            <div class="wsus__main_comment">
                                                                    <div class="wsus__comment_img">
                                                                        <img src="{{asset($review->user->image? : asset('frontend/images/avatar.png'))}}" alt="user"
                                                                             class="img-fluid w-100">
                                                                    </div>
                                                                <div class="wsus__comment_text reply">
                                                                    <h6>{{$review->user->name}} <span>{{$review->rate}} <i
                                                                                class="fas fa-star"></i></span></h6>
                                                                    <span>{{date('d M Y', strtotime($review->created_at))}}</span>
                                                                    <p>{{$review->review}}
                                                                    </p>
                                                                    <ul class="mb-4">
                                                                        @foreach($review->images as $review_image)
                                                                        <li><img src="{{asset($review_image->image)}}" alt="product"
                                                                                 class="img-fluid w-100"></li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        <div class="mt-5">
                                                            @if($reviews->hasPages())
                                                                {{$reviews->links()}}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($isBought)
                                                <div class="col-xl-4 col-lg-5 mt-4 mt-lg-0">
                                                    <div class="wsus__post_comment rev_mar" id="sticky_sidebar3">
                                                        <h4>write a Review</h4>
                                                        <form action="{{route('user.review.create')}}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <p class="rating mb-1">
                                                                <span>select your rating : </span>
                                                            </p>
                                                            <div class="row">
                                                                <div class="col-xl-12 mb-2">
                                                                    <div class="wsus__single_com">
                                                                        <div class="rate">
                                                                            <input type="radio" id="star5" name="rate" value="5" />
                                                                            <label for="star5" title="text">5 stars</label>
                                                                            <input type="radio" id="star4" name="rate" value="4" />
                                                                            <label for="star4" title="text">4 stars</label>
                                                                            <input type="radio" id="star3" name="rate" value="3" />
                                                                            <label for="star3" title="text">3 stars</label>
                                                                            <input type="radio" id="star2" name="rate" value="2" />
                                                                            <label for="star2" title="text">2 stars</label>
                                                                            <input type="radio" id="star1" name="rate" value="1" />
                                                                            <label for="star1" title="text">1 star</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-12">
                                                                    <div class="col-xl-12">
                                                                        <div class="wsus__single_com">
                                                                            <textarea name="review" cols="3" rows="3" placeholder="Write your review"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="custom__image-container mb-4">
                                                                <label id="add-img-label" for="add-single-img">+</label>
                                                                <input name="image" type="file" id="add-single-img" accept="image/jpeg" hidden />
                                                            </div>
                                                            <input name="product_id" type="hidden" value="{{$product->id}}">
                                                            <input name="vendor_id" type="hidden" value="{{$product->vendor_id}}">
                                                            <button class="common_btn" type="submit">submit
                                                                review</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade {{session()->has('product_info_view_style') && session()->get('product_info_view_style') === 'faqs'? 'show active': ''}}" id="pills-contact239" role="tabpanel"
                                     aria-labelledby="pills-contact-tab239">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="wsus__contact_question">
                                                <h5>People usually ask these</h5>
                                                <div class="accordion" id="accordionExample">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingOne">
                                                            <button class="accordion-button" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                                    aria-expanded="true" aria-controls="collapseOne">
                                                                How can I cancel my order?
                                                            </button>
                                                        </h2>
                                                        <div id="collapseOne" class="accordion-collapse collapse show"
                                                             aria-labelledby="headingOne"
                                                             data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing
                                                                    elit.
                                                                    Voluptatum voluptas ea hic excepturi sit, sapiente
                                                                    optio
                                                                    deleniti pariatur. Dolorum in quos magni?
                                                                    Necessitatibus
                                                                    recusandae cupiditate iste expedita amet voluptatem
                                                                    laudantium.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingTwo">
                                                            <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                                    aria-expanded="false" aria-controls="collapseTwo">
                                                                Why is my registration delayed?
                                                            </button>
                                                        </h2>
                                                        <div id="collapseTwo" class="accordion-collapse collapse"
                                                             aria-labelledby="headingTwo"
                                                             data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing
                                                                    elit.
                                                                    Voluptatum voluptas ea hic excepturi sit, sapiente
                                                                    optio
                                                                    deleniti pariatur. Dolorum in quos magni?
                                                                    Necessitatibus
                                                                    recusandae cupiditate iste expedita amet voluptatem
                                                                    laudantium.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingThree">
                                                            <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapseThree" aria-expanded="false"
                                                                    aria-controls="collapseThree">
                                                                What do I need to buy products?
                                                            </button>
                                                        </h2>
                                                        <div id="collapseThree" class="accordion-collapse collapse"
                                                             aria-labelledby="headingThree"
                                                             data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing
                                                                    elit.
                                                                    Voluptatum voluptas ea hic excepturi sit, sapiente
                                                                    optio
                                                                    deleniti pariatur. Dolorum in quos magni?
                                                                    Necessitatibus
                                                                    recusandae cupiditate iste expedita amet voluptatem
                                                                    laudantium.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingThreet1">
                                                            <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapseThreet1" aria-expanded="false"
                                                                    aria-controls="collapseThreet1">
                                                                How can I track an order?
                                                            </button>
                                                        </h2>
                                                        <div id="collapseThreet1" class="accordion-collapse collapse"
                                                             aria-labelledby="headingThreet1"
                                                             data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing
                                                                    elit.
                                                                    Voluptatum voluptas ea hic excepturi sit, sapiente
                                                                    optio
                                                                    deleniti pariatur. Dolorum in quos magni?
                                                                    Necessitatibus
                                                                    recusandae cupiditate iste expedita amet voluptatem
                                                                    laudantium.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingThreet2">
                                                            <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapseThreet2" aria-expanded="false"
                                                                    aria-controls="collapseThreet2">
                                                                How can I get money back?
                                                            </button>
                                                        </h2>
                                                        <div id="collapseThreet2" class="accordion-collapse collapse"
                                                             aria-labelledby="headingThreet2"
                                                             data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing
                                                                    elit.
                                                                    Voluptatum voluptas ea hic excepturi sit, sapiente
                                                                    optio
                                                                    deleniti pariatur. Dolorum in quos magni?
                                                                    Necessitatibus
                                                                    recusandae cupiditate iste expedita amet voluptatem
                                                                    laudantium.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        PRODUCT DETAILS END
    ==============================-->
@endsection

@push('scripts')
    @include('frontend.layouts.scripts')
    <script>
        var d = new Date(),
            countUpDate = new Date();
        d.setDate(d.getDate() + 90);
        console.log({{date('d', strtotime($product->offer_end_date))}});
        $(document).ready(function (){
            simplyCountdown('.simply-countdown-one', {
                year: {{date('Y', strtotime($product->offer_end_date))}},
                month: {{date('m', strtotime($product->offer_end_date))}},
                day: {{date('d', strtotime($product->offer_end_date))}},
                enableUtc: true
            });
        })
    </script>
    <script>
        $(document).ready(function(){
            $('.info-view').on('click', function (event) {
                let style = $(this).data('id');
                $.ajax({
                    method: 'GET',
                    url: '{{route('change-product-info-view')}}',
                    data: {
                        style: style
                    },
                    success: function (data) {

                    },
                    error: function (data) {
                        console.log(data)
                    }
                })
            })
        })
    </script>
    //add image to review
    <script>
        $(function(){
            $("input[type='submit']").click(function(){
                var $fileUpload = $("input[type='file']");
                if (parseInt($fileUpload.get(0).files.length)>2){
                    alert("You can only upload a maximum of 2 files");
                }
            });
        });
        const imgInputHelper = document.getElementById("add-single-img");
        const imgInputHelperLabel = document.getElementById("add-img-label");
        const imgContainer = document.querySelector(".custom__image-container");
        const imgFiles = [];
        const addImgHandler = () => {
            const file = imgInputHelper.files[0];
            if (!file) return;
            // Generate img preview
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                const newImg = document.createElement("img");
                newImg.src = reader.result;
                imgContainer.appendChild(newImg);
            };
            return;
        };
        imgInputHelper.addEventListener("change", function (){
            addImgHandler();
            imgInputHelperLabel.remove();
        });
    </script>
@endpush
