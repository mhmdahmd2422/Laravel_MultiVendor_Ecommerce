@extends('frontend.layouts.master')

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
                        <a class="wsus__pro_link" href="product_details.html">
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
                            <a class="wsus__pro_name" href="#">{{$item->product->name}}</a>
                            @if(checkDiscount($item->product))
                                <p class="wsus__price">${{$item->product->offer_price}}
                                    <del>${{$item->product->price}}</del>
                                </p>
                            @else
                                <p class="wsus__price">${{$item->product->price}}
                                </p>
                            @endif
                            <a class="add_cart" href="#">add to cart</a>
                        </div>
                    </div>
                    <div class="wsus__offer_progress">
                        <p><span>Remaining {{$item->product->quantity}}</span></p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 65%;" aria-valuenow="65"
                                 aria-valuemin="0" aria-valuemax="100">65%</div>
                        </div>
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
                enableUtc: true
            });
        })
    </script>
@endpush
