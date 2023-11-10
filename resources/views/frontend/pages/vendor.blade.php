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
{{--                <div class="col-xl-3 col-lg-4">--}}
{{--                    <div class="wsus__sidebar_filter">--}}
{{--                        <p>filter</p>--}}
{{--                        <span class="wsus__filter_icon">--}}
{{--                            <i class="far fa-minus" id="minus"></i>--}}
{{--                            <i class="far fa-plus" id="plus"></i>--}}
{{--                        </span>--}}
{{--                    </div>--}}
{{--                    <div class="wsus__product_sidebar wsus__vendor_sidebar" id="sticky_sidebar">--}}
{{--                        <form>--}}
{{--                            <input type="text" placeholder="Search...">--}}
{{--                            <button class="common_btn" type="submit"><i class="far fa-search"></i></button>--}}
{{--                        </form>--}}
{{--                        <div class="wsus__vendor_sidebar_select">--}}
{{--                            <h4>filter by category</h4>--}}
{{--                            <select class="select_2" name="state">--}}
{{--                                <option>choose category</option>--}}
{{--                                <option>men's</option>--}}
{{--                                <option>wemen's</option>--}}
{{--                                <option>kid's</option>--}}
{{--                                <option>electronics</option>--}}
{{--                                <option>electrick</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="wsus__vendor_sidebar_select">--}}
{{--                            <h4>filter by location</h4>--}}
{{--                            <select class="select_2" name="state">--}}
{{--                                <option>choose location</option>--}}
{{--                                <option>short by rating</option>--}}
{{--                                <option>short by latest</option>--}}
{{--                                <option>low to high </option>--}}
{{--                                <option>high to low</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="wsus__vendor_sidebar_select">--}}
{{--                            <select class="select_2" name="state">--}}
{{--                                <option>choose state</option>--}}
{{--                                <option>korea</option>--}}
{{--                                <option>japan</option>--}}
{{--                                <option>china</option>--}}
{{--                                <option>singapore</option>--}}
{{--                                <option>thailand</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="wsus__vendor_sidebar_select">--}}
{{--                            <select class="select_2" name="state">--}}
{{--                                <option>search by city</option>--}}
{{--                                <option>korea</option>--}}
{{--                                <option>japan</option>--}}
{{--                                <option>china</option>--}}
{{--                                <option>singapore</option>--}}
{{--                                <option>thailand</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col-xl-12 col-lg-12">
                    <div class="row">
{{--                        <div class="col-xl-12 d-none d-lg-block">--}}
{{--                            <div class="wsus__product_topbar">--}}
{{--                                <div class="wsus__topbar_select">--}}
{{--                                    <select class="select_2" name="state">--}}
{{--                                        <option>default shorting</option>--}}
{{--                                        <option>short by rating</option>--}}
{{--                                        <option>short by latest</option>--}}
{{--                                        <option>low to high </option>--}}
{{--                                        <option>high to low</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="wsus__topbar_select wsus__topbar_select2">--}}
{{--                                    <select class="select_2" name="state">--}}
{{--                                        <option>show 12</option>--}}
{{--                                        <option>show 15</option>--}}
{{--                                        <option>show 18</option>--}}
{{--                                        <option>show 21</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
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
@push('scripts')

@endpush
