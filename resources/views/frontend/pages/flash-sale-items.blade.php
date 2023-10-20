@extends('frontend.layouts.master')

@section('title')
    {{$settings->site_name}} || Flash Sale
@endsection

@section('content')

<!--============================
        DAILY DEALS START
    ==============================-->
<section id="wsus__daily_deals">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="wsus__section_header rounded-0">
                    <h3>flash sale</h3>
                    <div class="wsus__offer_countdown">
                        <span class="end_text">ends time :</span>
                        <div class="simply-countdown simply-countdown-one"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($flash_sale_items as $item)
            <div class="col-xl-3">
                <div class="wsus__offer_det_single">
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
                        <div class="wsus__product_details">
                            <a class="wsus__category" href="#">{{$item->product->category->name}}</a>
                            <p class="wsus__pro_rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(120 review)</span>
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
                                            @foreach($variant->ActiveVariantItems as $VariantItem)
                                                <option {{$VariantItem->is_default == 1 ? 'selected' : ''}} value="{{$VariantItem->id}}">{{$VariantItem->name}} ({{$settings->currency_icon}}{{$VariantItem->price}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach
                                <input name="quantity" type="hidden" min="1" max="100" value="1" />
                                <button class="add_cart" href="#" type="submit">add to cart</button>
                            </form>
                        </div>
                    </div>
                    <div class="wsus__offer_progress">
                        <p><span>{{$item->product->quantity}} items left!</span></p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if($flash_sale_items->hasPages())
            <div class="mt-5">
                {{$flash_sale_items->links()}}
            </div>
        @endif
    </div>
</section>
<!--============================
    DAILY DEALS END
==============================-->

@endsection
@push('scripts')
    <script>
        var d = new Date(),
            countUpDate = new Date();
        d.setDate(d.getDate() + 90);
        console.log({{date('d', strtotime($flash_sale_date->end_date))}});
        $(document).ready(function (){
            simplyCountdown('.simply-countdown-one', {
                year: {{date('Y', strtotime($flash_sale_date->end_date))}},
                month: {{date('m', strtotime($flash_sale_date->end_date))}},
                day: {{date('d', strtotime($flash_sale_date->end_date))}},
            });
        })
    </script>
@endpush
