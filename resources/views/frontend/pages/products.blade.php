@extends('frontend.layouts.master')
@section('title')
    {{$settings->site_name}} || Products
@endsection
@section('content')
<!--============================
    PRODUCT PAGE START
==============================-->
<section id="wsus__product_page">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="wsus__sidebar_filter ">
                    <p>filter</p>
                    <span class="wsus__filter_icon">
                        <i class="far fa-minus" id="minus"></i>
                        <i class="far fa-plus" id="plus"></i>
                    </span>
                </div>
                <div class="wsus__product_sidebar" id="sticky_sidebar">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    All Categories
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                 aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul>
                                        @foreach($categories as $category)
                                            <li><a href="{{route('products.index', ['category' => $category->slug])}}">{{$category->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Price
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse show"
                                 aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="price_ranger">
                                        <form action="{{url()->current()}}">
                                            @foreach(request()->query() as $key => $value)
                                                @if($key != 'price_slider')
                                                    <input name="{{$key}}" value="{{$value}}" type="hidden"/>
                                                @endif
                                            @endforeach
                                            <input name="price_slider" type="hidden" id="slider_range" class="flat-slider" />
                                            <button type="submit" class="common_btn">filter</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree3">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree3" aria-expanded="false"
                                        aria-controls="collapseThree">
                                    brands
                                </button>
                            </h2>
                            <div id="collapseThree3" class="accordion-collapse collapse show"
                                 aria-labelledby="headingThree3" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul>
                                        @foreach($brands as $brand)
                                            <li><a href="{{route('products.index', ['brand' => $brand->slug])}}">{{$brand->slug}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="row">
                    <div class="col-xl-12 d-none d-md-block mt-md-4 mt-lg-0">
                        <div class="wsus__product_topbar">
                            <div class="wsus__product_topbar_left">
                                <div class="nav nav-pills" id="v-pills-tab" role="tablist"
                                     aria-orientation="vertical">
                                    <button class="nav-link list-view {{session()->has('product_view_style') && session()->get('product_view_style') === 'grid'? 'active': ''}} {{!session()->has('product_view_style')? 'active': ''}}" data-id="grid" id="v-pills-home-tab" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-home" type="button" role="tab"
                                            aria-controls="v-pills-home" aria-selected="true">
                                        <i class="fas fa-th"></i>
                                    </button>
                                    <button class="nav-link list-view {{session()->has('product_view_style') && session()->get('product_view_style') === 'list'? 'active': ''}}" data-id="list" id="v-pills-profile-tab" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-profile" type="button" role="tab"
                                            aria-controls="v-pills-profile" aria-selected="false">
                                        <i class="fas fa-list-ul"></i>
                                    </button>
                                </div>
{{--                                <div class="wsus__topbar_select">--}}
{{--                                    <select class="select_2" name="state">--}}
{{--                                        <option>default sorting</option>--}}
{{--                                        <option>sort by rating</option>--}}
{{--                                        <option>sort by latest</option>--}}
{{--                                        <option>low to high </option>--}}
{{--                                        <option>high to low</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
                            </div>
{{--                            <div class="wsus__topbar_select">--}}
{{--                                <select class="select_2" name="state">--}}
{{--                                    <option>show 12</option>--}}
{{--                                    <option>show 15</option>--}}
{{--                                    <option>show 18</option>--}}
{{--                                    <option>show 21</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade {{session()->has('product_view_style') && session()->get('product_view_style') === 'grid'? 'show active': ''}}{{!session()->has('product_view_style')? 'show active': ''}}" id="v-pills-home" role="tabpanel"
                             aria-labelledby="v-pills-home-tab">
                            <div class="row">
                                @foreach($products as $product)
                                    <div class="col-xl-4  col-sm-6">
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
                                                <a class="wsus__pro_name" href="{{route('product-detail.index', $product->slug)}}">{{limitText($product->name, 55)}}</a>
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
                                @if($products->isEmpty())
                                    <div class="col-xl-12 text-center mt-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>Product Not Found!</h4>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade {{session()->has('product_view_style') && session()->get('product_view_style') === 'list'? 'show active': ''}}" id="v-pills-profile" role="tabpanel"
                             aria-labelledby="v-pills-profile-tab">
                            <div class="row">
                                @foreach($products as $product)
                                    <div class="col-xl-12">
                                        <div class="wsus__product_item wsus__list_view">
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
                                            <div class="wsus__product_details">
                                                <a class="wsus__category" href="#">{{$product->category->name}}</a>
                                                <p class="wsus__pro_rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                    <span>(17 review)</span>
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
                                                <p class="list_description">{{$product->short_description}} </p>
                                                <ul class="wsus__single_pro_icon">
                                                    <form class="shopping-cart-form">
                                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                                        <input name="quantity" type="hidden" min="1" max="100" value="1" />
                                                        <button class="add_cart_list_view" href="#" type="submit">Add To Cart</button>
                                                    </form>
                                                    <li><a href="#"><i class="far fa-heart"></i></a></li>
                                                    <li><a href="#"><i class="far fa-random"></i></a>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                    @if($products->isEmpty())
                                        <div class="col-xl-12 text-center mt-2">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4>Product Not Found!</h4>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <section id="pagination">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            @if($products->hasPages())
                                <div class="mt-5">
                                    {{$products->appends(request()->input())->links()}}
                                </div>
                            @endif
                        </ul>
                    </nav>
                </section>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="wsus__pro_page_bammer">
                @if($products_banner_one->status ==1)
                    <a href="{{$products_banner_one->banner_url}}">
                        <img class="img-fluid" src="{{asset($products_banner_one->banner_image)}}" alt="Banner">
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
<!--============================
    PRODUCT PAGE END
==============================-->
@foreach($products as $product)
    <section class="product_popup_modal">
        <div class="modal fade" id="exampleModal-{{$product->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                class="far fa-times"></i></button>
                        <div class="row">
                            <div class="col-xl-6 col-12 col-sm-10 col-md-8 col-lg-6 m-auto display">
                                <div class="wsus__quick_view_img">
                                    @if($product->video_link)
                                        <a class="venobox wsus__pro_det_video" data-autoplay="true" data-vbtype="video"
                                           href="{{$product->video_link}}">
                                            <i class="fas fa-play"></i>
                                        </a>
                                    @endif
                                    <div class="row modal_slider">
                                        <div class="col-xl-12">
                                            <div class="modal_slider_img">
                                                <img src="{{url(asset($product->thumb_image))}}" alt="product" class="img-fluid w-100">
                                            </div>
                                        </div>
                                        @if($product->gallery->isNotEmpty())
                                            @foreach($product->gallery as $image)
                                                <div class="col-xl-12">
                                                    <div class="modal_slider_img">
                                                        <img src="{{url(asset($image->image))}}" alt="product" class="img-fluid w-100">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-xl-12">
                                                <div class="modal_slider_img">
                                                    <img src="{{url(asset($product->thumb_image))}}" alt="product" class="img-fluid w-100">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-12 col-sm-12 col-md-12 col-lg-6">
                                <div class="wsus__pro_details_text">
                                    <a class="title" href="#">{{$product->name}}</a>
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
                                    <p class="description" style="font-style: italic; font-size: large">“ {{$product->short_description}} ”</p>
                                    <p class="brand_model"><span style="font-weight: bold">model :</span> {{$product->sku?? 'Not Provided'}} </p>
                                    <p class="brand_model mb-4"><span style="font-weight: bold">brand :</span> {{$product->brand->name}}</p>
                                    @if(checkDiscount($product))
                                        <div class="wsus_pro_hot_deals">
                                            <h5>offer ending In : </h5>
                                            <div class="simply-countdown simply-countdown-one"></div>
                                        </div>
                                    @endif
                                    <form class="shopping-cart-form">
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                        @foreach($product->variants as $variant)
                                            <div class="wsus__selectbox">
                                                <div class="row">
                                                    <div class="col-xl-6 col-sm-6">
                                                        <h5 class="mb-2">select {{$variant->name}}:</h5>
                                                        <select class="select_2" name="variant_items[]">
                                                            @foreach($variant->ActiveVariantItems as $variantItem)
                                                                <option {{$variantItem->is_default == 1 ? 'selected' : ''}} value="{{$variantItem->id}}">{{$variantItem->name}} ({{$settings->currency_icon}}{{$variantItem->price}})</option>
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
                                            <h3>$50.00</h3>
                                        </div>
                                        <ul class="wsus__button_area">
                                            <li><button type="submit" class="add_cart" href="#">add to cart</button></li>
                                            <li><a class="buy_now" href="#">buy now</a></li>
                                            <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                            <li><a href="#"><i class="far fa-random"></i></a></li>
                                        </ul>
                                    </form>
                                    <div class="wsus__pro_det_share">
                                        <h5>share :</h5>
                                        <ul class="d-flex">
                                            <li><a class="facebook" href="#"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a class="twitter" href="#"><i class="fab fa-twitter"></i></a></li>
                                            <li><a class="whatsapp" href="#"><i class="fab fa-whatsapp"></i></a></li>
                                            <li><a class="instagram" href="#"><i class="fab fa-instagram"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endforeach
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('.list-view').on('click', function (event) {
                let style = $(this).data('id');
                $.ajax({
                    method: 'GET',
                    url: '{{route('change-product-view')}}',
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
            //*==========PRICE SLIDER=========
            @php
                if(request()->price_slider){
                    $range = explode(';', request()->price_slider);
                    $from = $range[0]? : 0;
                    $to = $range[1]? : 10000;
                }
                else{
                    $from = 0;
                    $to = 10000;
                }
            @endphp
            jQuery(function () {
                jQuery("#slider_range").flatslider({
                    min: 0, max: 10000,
                    step: 100,
                    values: [{{$from}}, {{$to}}],
                    range: true,
                    einheit: '{{$settings->currency_icon}}'
                });
            });
        })
    </script>
@endpush
