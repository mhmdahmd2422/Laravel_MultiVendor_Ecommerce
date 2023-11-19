@extends('frontend.layouts.master')

@section('title')
    {{$settings->site_name}} || About Us
@endsection
@section('content')
    <!--============================
        ABOUT US START
    ==============================-->
    <section id="wsus__about_us">
        <div class="container">
            <div class="wsus__about_accordian">
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <h4>We Provide Best Service for Customers</h4>
                        <div>{!! @$about->content !!}</div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <img src="{{asset(@$about->image)}}" alt="img" class="img-fluid w-100">
                    </div>
                </div>
            </div>
        </div>
        <div class="wsus__about_counter_area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-md-6 col-lg-4">
                        <div class="wsus__about_counter_single">
                            <span class="counter">{{\App\Models\Product::activeApproved()->count()}}</span>
                            <h2>products for sell</h2>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-lg-4">
                        <div class="wsus__about_counter_single">
                            <span class="counter">{{\App\Models\Vendor::activeApproved()->count()}}</span>
                            <h2>Active Vendors</h2>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-lg-4">
                        <div class="wsus__about_counter_single">
                            <span class="counter">{{\App\Models\Order::where('order_status', 'delivered')->count()}}</span>
                            <h2>Delivered Orders</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wsus__why_shop">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <h3>Why Shop With Us?</h3>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-lg-3">
                        <div class="wsus__why_shop_single">
                            <i class="fal fa-box-full"></i>
                            <p>Complete buyer supply store</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-lg-3">
                        <div class="wsus__why_shop_single">
                            <i class="fal fa-box-usd"></i>
                            <p>Same day dispatch on all orders</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-lg-3">
                        <div class="wsus__why_shop_single">
                            <i class="fal fa-truck"></i>
                            <p>Free delivery on all orders</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-lg-3">
                        <div class="wsus__why_shop_single">
                            <i class="fas fa-user-headset"></i>
                            <p>Professional advice and great support </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        ABOUT US END
    ==============================-->

@endsection
