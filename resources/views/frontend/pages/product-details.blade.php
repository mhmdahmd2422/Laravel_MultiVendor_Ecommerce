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
                    <div class="col-xl-4 col-md-5 col-lg-5" style="z-index: 9999 !important;">
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
                    <div class="col-xl-5 col-md-7 col-lg-7">
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
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>20 review</span>
                            </p>
                            <p class="description">{{$product->short_description}}</p>

                            @if(checkDiscount($product))
                                <div class="wsus_pro_hot_deals">
                                    <h5>offer ending In : </h5>
                                    <div class="simply-countdown simply-countdown-one"></div>
                                </div>
                            @endif
{{--                            <div class="wsus_pro_det_color">--}}
{{--                                <h5>color :</h5>--}}
{{--                                <ul>--}}
{{--                                    <li><a class="blue" href="#"><i class="far fa-check"></i></a></li>--}}
{{--                                    <li><a class="orange" href="#"><i class="far fa-check"></i></a></li>--}}
{{--                                    <li><a class="yellow" href="#"><i class="far fa-check"></i></a></li>--}}
{{--                                    <li><a class="black" href="#"><i class="far fa-check"></i></a></li>--}}
{{--                                    <li><a class="red" href="#"><i class="far fa-check"></i></a></li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                            <div class="wsus_pro__det_size">--}}
{{--                                <h5>size :</h5>--}}
{{--                                <ul>--}}
{{--                                    <li><a href="#">S</a></li>--}}
{{--                                    <li><a href="#">M</a></li>--}}
{{--                                    <li><a href="#">L</a></li>--}}
{{--                                    <li><a href="#">XL</a></li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
                            @foreach($variants as $variant)
                                <div class="wsus__selectbox">
                                    <div class="row">
                                        <div class="col-xl-6 col-sm-6">
                                            <h5 class="mb-2">select {{$variant->name}}:</h5>
                                            <select class="select_2" name="state">
                                                @foreach($variant->variantItems as $item)
                                                    <option {{$item->is_default == 1 ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}} ({{$settings->currency_icon}}{{$item->price}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="wsus__quentity">
                                <h5>quantity :</h5>
                                <form class="select_number">
                                    <input class="number_area" type="text" min="1" max="{{$product->quantity}}" value="1" />
                                </form>
                                <h3 id="result">$50.00</h3>
                            </div>
                            <ul class="wsus__button_area">
                                <li><a class="add_cart" href="#">add to cart</a></li>
                                <li><a class="buy_now" href="#">buy now</a></li>
                                <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                <li><a href="#"><i class="far fa-random"></i></a></li>
                            </ul>
                            <p class="brand_model"><span>model :</span> {{$product->sku}}</p>
                            <p class="brand_model"><span>brand :</span> {{$product->brand->name}}</p>
                            <div class="wsus__pro_det_share">
                                <h5>share :</h5>
                                <ul class="d-flex">
                                    <li><a class="facebook" href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a class="twitter" href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a class="whatsapp" href="#"><i class="fab fa-whatsapp"></i></a></li>
                                    <li><a class="instagram" href="#"><i class="fab fa-instagram"></i></a></li>
                                </ul>
                            </div>
                            <a class="wsus__pro_report" href="#" data-bs-toggle="modal"
                               data-bs-target="#exampleModal"><i class="fal fa-comment-alt-smile"></i> Report incorrect
                                product information.</a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-12 mt-md-5 mt-lg-0">
                        <div class="wsus_pro_det_sidebar" id="sticky_sidebar">
                            <ul>
                                <li>
                                    <span><i class="fal fa-truck"></i></span>
                                    <div class="text">
                                        <h4>Return Available</h4>
                                        <!-- <p>Lorem Ipsum is simply dummy text of the printing</p> -->
                                    </div>
                                </li>
                                <li>
                                    <span><i class="far fa-shield-check"></i></span>
                                    <div class="text">
                                        <h4>Secure Payment</h4>
                                        <!-- <p>Lorem Ipsum is simply dummy text of the printing</p> -->
                                    </div>
                                </li>
                                <li>
                                    <span><i class="fal fa-envelope-open-dollar"></i></span>
                                    <div class="text">
                                        <h4>Warranty Available</h4>
                                        <!-- <p>Lorem Ipsum is simply dummy text of the printing</p> -->
                                    </div>
                                </li>
                            </ul>
                            <div class="wsus__det_sidebar_banner">
                                <img src="images/blog_1.jpg" alt="banner" class="img-fluid w-100">
                                <div class="wsus__det_sidebar_banner_text_overlay">
                                    <div class="wsus__det_sidebar_banner_text">
                                        <p>Black Friday Sale</p>
                                        <h4>Up To 70% Off</h4>
                                        <a href="#" class="common_btn">shope now</a>
                                    </div>
                                </div>
                            </div>
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
                                    <button class="nav-link active" id="pills-home-tab7" data-bs-toggle="pill"
                                            data-bs-target="#pills-home22" type="button" role="tab"
                                            aria-controls="pills-home" aria-selected="true">Description</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-contact" type="button" role="tab"
                                            aria-controls="pills-contact" aria-selected="false">Vendor Info</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab2" data-bs-toggle="pill"
                                            data-bs-target="#pills-contact2" type="button" role="tab"
                                            aria-controls="pills-contact2" aria-selected="false">Reviews</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab239" data-bs-toggle="pill"
                                            data-bs-target="#pills-contact239" type="button" role="tab"
                                            aria-controls="pills-contact239" aria-selected="false">faqs</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent4">
                                <div class="tab-pane fade  show active " id="pills-home22" role="tabpanel"
                                     aria-labelledby="pills-home-tab7">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="wsus__description_area">

                                                <p>{{$product->long_description}}</p>
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
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel"
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
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <span>(41 review)</span>
                                                    </p>
                                                    <p><span>Store Name:</span>{{$product->vendor->name}}</p>
                                                    <p><span>Address:</span>{{$product->vendor->address}}</p>
                                                    <p><span>Phone:</span> {{$product->vendor->phone}}</p>
                                                    <p><span>mail:</span> {{$product->vendor->email}}</p>
                                                    <a href="vendor_details.html" class="see_btn">visit store</a>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="wsus__vendor_details">
                                                    <p>{!!$product->vendor->description!!}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-contact2" role="tabpanel"
                                     aria-labelledby="pills-contact-tab2">
                                    <div class="wsus__pro_det_review">
                                        <div class="wsus__pro_det_review_single">
                                            <div class="row">
                                                <div class="col-xl-8 col-lg-7">
                                                    <div class="wsus__comment_area">
                                                        <h4>Reviews <span>02</span></h4>
                                                        <div class="wsus__main_comment">
                                                            <div class="wsus__comment_img">
                                                                <img src="images/client_img_3.jpg" alt="user"
                                                                     class="img-fluid w-100">
                                                            </div>
                                                            <div class="wsus__comment_text reply">
                                                                <h6>Shopnil mahadi <span>4 <i
                                                                            class="fas fa-star"></i></span></h6>
                                                                <span>09 Jul 2021</span>
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing
                                                                    elit.
                                                                    Cupiditate sint molestiae eos? Officia, fuga eaque.
                                                                </p>
                                                                <ul class="">
                                                                    <li><img src="images/headphone_1.jpg" alt="product"
                                                                             class="img-fluid w-100"></li>
                                                                    <li><img src="images/headphone_2.jpg" alt="product"
                                                                             class="img-fluid w-100"></li>
                                                                    <li><img src="images/kids_1.jpg" alt="product"
                                                                             class="img-fluid w-100"></li>
                                                                </ul>
                                                                <a href="#" data-bs-toggle="collapse"
                                                                   data-bs-target="#flush-collapsetwo">reply</a>
                                                                <div class="accordion accordion-flush"
                                                                     id="accordionFlushExample2">
                                                                    <div class="accordion-item">
                                                                        <div id="flush-collapsetwo"
                                                                             class="accordion-collapse collapse"
                                                                             aria-labelledby="flush-collapsetwo"
                                                                             data-bs-parent="#accordionFlushExample">
                                                                            <div class="accordion-body">
                                                                                <form>
                                                                                    <div
                                                                                        class="wsus__riv_edit_single text_area">
                                                                                        <i class="far fa-edit"></i>
                                                                                        <textarea cols="3" rows="1"
                                                                                                  placeholder="Your Text"></textarea>
                                                                                    </div>
                                                                                    <button type="submit"
                                                                                            class="common_btn">submit</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="wsus__main_comment">
                                                            <div class="wsus__comment_img">
                                                                <img src="images/client_img_1.jpg" alt="user"
                                                                     class="img-fluid w-100">
                                                            </div>
                                                            <div class="wsus__comment_text reply">
                                                                <h6>Smith jhon <span>5 <i
                                                                            class="fas fa-star"></i></span>
                                                                </h6>
                                                                <span>09 Jul 2021</span>
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing
                                                                    elit.
                                                                    Cupiditate sint molestiae eos? Officia, fuga eaque.
                                                                </p>
                                                                <a href="#" data-bs-toggle="collapse"
                                                                   data-bs-target="#flush-collapsetwo2">reply</a>
                                                                <div class="accordion accordion-flush"
                                                                     id="accordionFlushExample2">
                                                                    <div class="accordion-item">
                                                                        <div id="flush-collapsetwo2"
                                                                             class="accordion-collapse collapse"
                                                                             aria-labelledby="flush-collapsetwo"
                                                                             data-bs-parent="#accordionFlushExample">
                                                                            <div class="accordion-body">
                                                                                <form>
                                                                                    <div
                                                                                        class="wsus__riv_edit_single text_area">
                                                                                        <i class="far fa-edit"></i>
                                                                                        <textarea cols="3" rows="1"
                                                                                                  placeholder="Your Text"></textarea>
                                                                                    </div>
                                                                                    <button type="submit"
                                                                                            class="common_btn">submit</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="pagination">
                                                            <nav aria-label="Page navigation example">
                                                                <ul class="pagination">
                                                                    <li class="page-item">
                                                                        <a class="page-link" href="#"
                                                                           aria-label="Previous">
                                                                            <i class="fas fa-chevron-left"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li class="page-item"><a
                                                                            class="page-link page_active" href="#">1</a>
                                                                    </li>
                                                                    <li class="page-item"><a class="page-link"
                                                                                             href="#">2</a></li>
                                                                    <li class="page-item"><a class="page-link"
                                                                                             href="#">3</a></li>
                                                                    <li class="page-item"><a class="page-link"
                                                                                             href="#">4</a></li>
                                                                    <li class="page-item">
                                                                        <a class="page-link" href="#" aria-label="Next">
                                                                            <i class="fas fa-chevron-right"></i>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </nav>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-5 mt-4 mt-lg-0">
                                                    <div class="wsus__post_comment rev_mar" id="sticky_sidebar3">
                                                        <h4>write a Review</h4>
                                                        <form action="#">
                                                            <p class="rating">
                                                                <span>select your rating : </span>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                            </p>
                                                            <div class="row">
                                                                <div class="col-xl-12">
                                                                    <div class="wsus__single_com">
                                                                        <input type="text" placeholder="Name">
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-12">
                                                                    <div class="wsus__single_com">
                                                                        <input type="email" placeholder="Email">
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-12">
                                                                    <div class="col-xl-12">
                                                                        <div class="wsus__single_com">
                                                                            <textarea cols="3" rows="3"
                                                                                      placeholder="Write your review"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="img_upload">
                                                                <div class="gallery">
                                                                    <a class="cam" href="javascript:void(0)"><span><i
                                                                                class="fas fa-image"></i></span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <button class="common_btn" type="submit">submit
                                                                review</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-contact239" role="tabpanel"
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
{{--    <script>--}}
{{--        $(document).ready(function (){--}}
{{--            $('body').on('change', '.spinner', function (e){--}}
{{--                let quantity = $(this).val();--}}
{{--                let pricePerItem = {{checkDiscount($product) ? $product->offer_price : $product->price}};--}}
{{--                let result = document.getElementById("result");--}}
{{--                let totalPrice = pricePerItem * quantity;--}}
{{--                console.log(result);--}}
{{--                result.innerText = "Total Price: $" + totalPrice;--}}
{{--            })--}}
{{--        })--}}
{{--    </script>--}}
@endpush
