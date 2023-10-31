<!--============================
    HOT DEALS START
==============================-->
<section id="wsus__hot_deals" class="wsus__hot_deals_2">
    <div class="container">
{{--        <section id="wsus__single_banner" class="home_2_single_banner">--}}
{{--            <div class="container">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-xl-6 col-lg-6">--}}
{{--                        <div class="wsus__single_banner_content banner_1">--}}
{{--                            <div class="wsus__single_banner_img">--}}
{{--                                <img src="images/single_banner_44.jpg" alt="banner" class="img-fluid w-100">--}}
{{--                            </div>--}}
{{--                            <div class="wsus__single_banner_text">--}}
{{--                                <h6>sell on <span>35% off</span></h6>--}}
{{--                                <h3>smart watch</h3>--}}
{{--                                <a class="shop_btn" href="#">shop now</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-xl-6 col-lg-6">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-12">--}}
{{--                                <div class="wsus__single_banner_content single_banner_2">--}}
{{--                                    <div class="wsus__single_banner_img">--}}
{{--                                        <img src="images/single_banner_55.jpg" alt="banner" class="img-fluid w-100">--}}
{{--                                    </div>--}}
{{--                                    <div class="wsus__single_banner_text">--}}
{{--                                        <h6>New Collection</h6>--}}
{{--                                        <h3>kid's fashion</h3>--}}
{{--                                        <a class="shop_btn" href="#">shop now</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-12 mt-lg-4">--}}
{{--                                <div class="wsus__single_banner_content">--}}
{{--                                    <div class="wsus__single_banner_img">--}}
{{--                                        <img src="images/single_banner_66.jpg" alt="banner" class="img-fluid w-100">--}}
{{--                                    </div>--}}
{{--                                    <div class="wsus__single_banner_text">--}}
{{--                                        <h6>sell on <span>42% off</span></h6>--}}
{{--                                        <h3>winter collection</h3>--}}
{{--                                        <a class="shop_btn" href="#">shop now</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </section>--}}
        <div class="wsus__hot_large_item">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__section_header justify-content-start">
                        <div class="monthly_top_filter2 mb-1">
                            @foreach($type_base_products as $key => $value)
                                <button class="{{$loop->index === 0? 'ms-0 active auto_click': ''}}" data-filter=".{{$key}}">{{str_replace('_', ' ', $key)}}</button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row grid2">
                @foreach($type_base_products as $typeKey => $type)
                    @foreach($type as $key => $product)
                        <div class="col-xl-3 col-sm-6 col-md-4 col-lg-4 {{$typeKey}}">
                            <div class="wsus__product_item">
                                @if(productListing($product))
                                    <span class="wsus__new">{{productListing($product)}}</span>
                                @endif
                                @if(checkDiscount($product))
                                    <span class="wsus__minus">-{{discountPercent($product->price, $product->offer_price)}}%</span>
                                @endif
                                <a class="wsus__pro_link" href="{{route('product-detail.index', $product->slug)}}">
                                    <img src="{{asset($product->thumb_image)}}" alt="product" class="img-fluid w-100 img_1" />
                                    @if(isset($product->gallery[1]))
                                        <img src="{{asset($product->gallery->last()->image)}}" alt="product" class="img-fluid w-100 img_2" />
                                    @else
                                        <img src="{{asset($product->thumb_image)}}" alt="product" class="img-fluid w-100 img_2" />
                                    @endif
                                </a>
                                <ul class="wsus__single_pro_icon">
                                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$product->id}}"><i
                                                class="far fa-eye"></i></a></li>
                                    <li><a href="#"><i class="far fa-heart"></i></a></li>
                                    <li><a href="#"><i class="far fa-random"></i></a>
                                </ul>
                                <div class="wsus__product_details">
                                    <a class="wsus__category" href="#">{{$product->category->name}}</a>
                                    <p class="wsus__pro_rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <span>(133 review)</span>
                                    </p>
                                    <a class="wsus__pro_name" href="{{route('product-detail.index', $product->slug)}}">{{$product->name}}</a>
                                    @if(checkDiscount($product))
                                        <p class="wsus__price">{{$settings->currency_icon}}{{$product->offer_price}}
                                            <del>{{$settings->currency_icon}}{{$product->price}}</del>
                                        </p>
                                    @else
                                        <p class="wsus__price">{{$settings->currency_icon}}{{$product->price}}
                                        </p>
                                    @endif
                                    <form class="shopping-cart-form">
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                        @foreach($product->variants as $variant)
                                            <div class="d-none">
                                                <select class="select_2" name="variant_items[]">
                                                    @foreach($variant->ActiveVariantItems as $item)
                                                        <option {{$item->is_default == 1 ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}} ({{$settings->currency_icon}}{{$item->price}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endforeach
                                        <input name="quantity" type="hidden" min="1" max="100" value="1" />
                                        <button class="add_cart" href="#" type="submit">add to cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
                <div class="col-xl-3 col-sm-6 col-md-4 col-lg-4 clotha spka wata">
                    <div class="wsus__product_item">
                        <span class="wsus__minus">-20%</span>
                        <a class="wsus__pro_link" href="product_details.html">
                            <img src="images/charger_2.jpg" alt="product" class="img-fluid w-100 img_1" />
                            <img src="images/charger_1.jpg" alt="product" class="img-fluid w-100 img_2" />
                        </a>
                        <ul class="wsus__single_pro_icon">
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                                        class="far fa-eye"></i></a></li>
                            <li><a href="#"><i class="far fa-heart"></i></a></li>
                            <li><a href="#"><i class="far fa-random"></i></a>
                        </ul>
                        <div class="wsus__product_details">
                            <a class="wsus__category" href="#">Electronics </a>
                            <p class="wsus__pro_rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(74 review)</span>
                            </p>
                            <a class="wsus__pro_name" href="#">8.5 VA first charger</a>
                            <p class="wsus__price">$160</p>
                            <a class="add_cart" href="#">add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============================
    HOT DEALS END
==============================-->
