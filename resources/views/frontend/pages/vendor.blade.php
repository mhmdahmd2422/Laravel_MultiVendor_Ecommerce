@extends('frontend.layouts.master')

@section('title')
    {{$settings->site_name}} || Vendors
@endsection

@section('content')
<!--============================
  VENDORS START
==============================-->
<section id="wsus__product_page" class="wsus__vendors">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="row">
                    @foreach($vendors as $vendor)
                        <div class="col-xl-6 col-md-6">
                            <div class="wsus__vendor_single">
                                <img src="{{asset($vendor->banner)}}" alt="vendor" class="img-fluid w-100">
                                <div class="wsus__vendor_text">
                                    <div class="wsus__vendor_text_center">
                                        <h4>{{$vendor->name}}</h4>
                                        @php
                                        $reviews = array();
                                        foreach ($vendor->products as $product){

                                            foreach ($product->reviews as $review){
                                                $reviews[] = $review->rate;
                                            }
                                        }
                                        if(count($reviews)) {
                                            $avg_rate = array_sum($reviews)/count($reviews);
                                        }
                                         @endphp
                                        <p class="wsus__vendor_rating">
                                            @if(isset($avg_rate))
                                                @for($i = 0; $i<$avg_rate; $i++)
                                                    <i class="fas fa-star"></i>
                                                @endfor
                                                @for($j = $i; $j<5; $j++)
                                                    <i class="far fa-star"></i>
                                                @endfor
                                            @else
                                                @for($i = 0; $i<5; $i++)
                                                    <i class="far fa-star"></i>
                                                @endfor
                                            @endif
                                        </p>
                                        <a href="callto:{{$vendor->phone}}"><i class="far fa-phone-alt"></i>
                                            {{$vendor->phone}}</a>
                                        <a href="mailto:{{$vendor->email}}"><i class="fal fa-envelope"></i>
                                            {{$vendor->email}}</a>
                                        <a href="{{route('products.index', ['vendor' => $vendor->id])}}" class="common_btn">visit store</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-12">
                <section id="pagination">
                    @if($vendors->hasPages())
                        <div class="mt-5">
                            {{$vendors->links()}}
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </div>
</section>
<!--============================
   VENDORS END
==============================-->
@endsection

