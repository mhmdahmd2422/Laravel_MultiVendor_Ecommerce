<!--============================
    FLASH SELL START
==============================-->
<section id="wsus__flash_sell" class="wsus__flash_sell_2">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="offer_time" style="background-image: url({{asset('frontend/images/flash_sell_bg.jpg')}})">
                    <div class="wsus__flash_coundown">
                        <span class=" end_text">flash Sale</span>
                        <div class="simply-countdown simply-countdown-one"></div>
                        <a class="common_btn" href="{{route('flash-sale.details')}}">see more <i class="fas fa-caret-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row flash_sell_slider">
            @foreach($flash_sale_items as $item)
                @if($item->product)
                <div class="col-xl-3 col-sm-6 col-lg-4">
                    <div class="wsus__product_item">
                        @if(productListing($item->product))
                            <span class="wsus__new">{{productListing($item->product)}}</span>
                        @endif
                        @if(checkDiscount($item->product))
                            <span class="wsus__minus">-{{discountPercent($item->product->price, $item->product->offer_price)}}%</span>
                        @endif
                        <a class="wsus__pro_link" href="{{route('product-detail.index', $item->product->slug)}}">
                            <img src="{{asset($item->product->thumb_image)}}" alt="product" class="img-fluid w-100 img_1" />
                            @if(isset($item->product->gallery[1]))
                                <img src="{{asset($item->product->gallery->last()->image)}}" alt="product" class="img-fluid w-100 img_2" />
                            @else
                                <img src="{{asset($item->product->thumb_image)}}" alt="product" class="img-fluid w-100 img_2" />
                            @endif
                        </a>
                        <ul class="wsus__single_pro_icon">
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$item->product->id}}"><i
                                        class="far fa-eye"></i></a></li>
                            <li><a href="#" class="add-to-wishlist" data-id="{{$item->product->id}}"><i class="far fa-heart"></i></a></li>
{{--                            <li><a href="#"><i class="far fa-random"></i></a>--}}
                        </ul>
                        <div class="wsus__product_details">
                            <a class="wsus__category" href="#">{{$item->product->category->name}}</a>
                            <p class="wsus__pro_rating">
                                @php
                                $avg_rate = $item->product->reviews()->avg('rate');
                                 @endphp
                                @for($i = 0; $i<$avg_rate; $i++)
                                <i class="fas fa-star"></i>
                                @endfor
                                @for($j = $i; $j<5; $j++)
                                    <i class="far fa-star"></i>
                                @endfor
                                <span>({{$item->product->reviews->count()}} review)</span>
                            </p>
                            <a class="wsus__pro_name" href="{{route('product-detail.index', $item->product->slug)}}">{{$item->product->name}}</a>
                            @if(checkDiscount($item->product))
                                <p class="wsus__price">{{$settings->currency_icon}}{{$item->product->offer_price}}
                                    <del>{{$settings->currency_icon}}{{$item->product->price}}</del>
                                </p>
                            @else
                                <p class="wsus__price">{{$settings->currency_icon}}{{$item->product->price}}
                                </p>
                            @endif
                            <form class="shopping-cart-form">
                                <input type="hidden" name="product_id" value="{{$item->product->id}}">
                                @foreach($item->product->variants as $variant)
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
                @endif
            @endforeach

        </div>
    </div>
</section>

<!--==========================
  PRODUCT MODAL VIEW START
===========================-->
@foreach($flash_sale_items as $item)
    @if($item->product)
    <section class="product_popup_modal">
        <div class="modal fade" id="exampleModal-{{$item->product->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                class="far fa-times"></i></button>
                        <div class="row">
                            <div class="col-xl-6 col-12 col-sm-10 col-md-8 col-lg-6 m-auto display">
                                <div class="wsus__quick_view_img">
                                    @if($item->product->video_link)
                                        <a class="venobox wsus__pro_det_video" data-autoplay="true" data-vbtype="video"
                                           href="{{$item->product->video_link}}">
                                            <i class="fas fa-play"></i>
                                        </a>
                                    @endif
                                    <div class="row modal_slider">
                                        <div class="col-xl-12">
                                            <div class="modal_slider_img">
                                                <img src="{{url(asset($item->product->thumb_image))}}" alt="product" class="img-fluid w-100">
                                            </div>
                                        </div>
                                        @if($item->product->gallery->isNotEmpty())
                                            @foreach($item->product->gallery as $image)
                                                <div class="col-xl-12">
                                                    <div class="modal_slider_img">
                                                        <img src="{{url(asset($image->image))}}" alt="product" class="img-fluid w-100">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-xl-12">
                                                <div class="modal_slider_img">
                                                    <img src="{{url(asset($item->product->thumb_image))}}" alt="product" class="img-fluid w-100">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-12 col-sm-12 col-md-12 col-lg-6">
                                <div class="wsus__pro_details_text">
                                    <a class="title" href="#">{{$item->product->name}}</a>
                                    <p class="wsus__stock_area">
                                        @if(checkStock($item->product))
                                            <span class="in_stock">in stock</span>
                                        @else
                                            <span class="out_stock">out of stock</span>
                                        @endif
                                        <span>({{$item->product->quantity}} item)</span>
                                    </p>
                                    @if(checkDiscount($item->product))
                                        <h4>{{$settings->currency_icon}}{{$item->product->offer_price}}.00 <del>{{$settings->currency_icon}}{{$item->product->price}}.00</del></h4>
                                    @else
                                        <h4>{{$settings->currency_icon}}{{$item->product->price}}</h4>
                                    @endif
                                    <p class="review">
                                        <@php
                                            $avg_rate = $item->product->reviews()->avg('rate');
                                        @endphp
                                        @for($i = 0; $i<$avg_rate; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                        @for($j = $i; $j<5; $j++)
                                            <i class="far fa-star"></i>
                                        @endfor
                                        <span>{{$item->product->reviews->count()}} review</span>
                                    </p>
                                    <p class="description" style="font-style: italic; font-size: large">“ {{$item->product->short_description}} ”</p>
                                    <p class="brand_model"><span style="font-weight: bold">model :</span> {{$item->product->sku?? 'Not Provided'}} </p>
                                    <p class="brand_model mb-4"><span style="font-weight: bold">brand :</span> {{$item->product->brand->name}}</p>
                                    @if(checkDiscount($item->product))
                                        <div class="wsus_pro_hot_deals">
                                            <h5>offer ending In : </h5>
                                            <div class="simply-countdown simply-countdown-one"></div>
                                        </div>
                                    @endif
                                    <form class="shopping-cart-form">
                                        <input type="hidden" name="product_id" value="{{$item->product->id}}">
                                        @foreach($item->product->variants as $variant)
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
                                                <input name="quantity" class="number_area" type="text" min="1" max="{{$item->product->quantity}}" value="1" />
                                            </div>
                                        </div>
                                        <ul class="wsus__button_area">
                                            <li><button type="submit" class="add_cart" href="#">add to cart</button></li>
{{--                                            <li><a class="buy_now" href="#">buy now</a></li>--}}
                                            <li><a href="#" class="add-to-wishlist" data-id="{{$item->product->id}}"><i class="far fa-heart"></i></a></li>
{{--                                            <li><a href="#"><i class="far fa-random"></i></a></li>--}}
                                        </ul>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
@endforeach
<!--==========================
  PRODUCT MODAL VIEW END
===========================-->

@push('scripts')
<script>
    var d = new Date(),
        countUpDate = new Date();
    d.setDate(d.getDate() + 90);
    $(document).ready(function (){
        simplyCountdown('.simply-countdown-one', {
            year: {{date('Y', strtotime($flash_sale_date?->end_date))}},
            month: {{date('m', strtotime($flash_sale_date?->end_date))}},
            day: {{date('d', strtotime($flash_sale_date?->end_date))}},
        });
    })
</script>
@endpush
<!--============================
    FLASH SELL END
==============================-->
