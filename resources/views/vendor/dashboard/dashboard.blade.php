@extends('vendor.layouts.master')

@section('content')
    <!--=============================
  DASHBOARD START
==============================-->
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include('vendor.layouts.sidebar')
            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <h2 class="mb-4">Vendor Dashboard</h2>
                    <div class="dashboard_content">
                        <div class="wsus__dashboard">
                            <div class="row">
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item blue" href="{{route('vendor.orders')}}">
                                        <i class="fas fa-shopping-cart"></i>
                                        <p>orders</p>
                                        <p>Today: {{$todayTotalOrders}}</p>
                                        <p>all: {{$totalOrders}}</p>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item red" href="{{route('vendor.orders')}}">
                                        <i class="fas fa-spinner"></i>
                                        <p>pending orders</p>
                                        <p>Today: {{$todayPendingOrders}}</p>
                                        <p>all: {{$totalPendingOrders}}</p>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item green" href="{{route('vendor.orders')}}">
                                        <i class="fas fa-check-circle"></i>
                                        <p>done orders</p>
                                        <p>Today: {{$todayDoneOrders}}</p>
                                        <p>all: {{$totalDoneOrders}}</p>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item orange" href="{{route('vendor.orders')}}">
                                        <i class="fas fa-money-check-alt"></i>
                                        <p>Earnings</p>
                                        <p>Month: {{$settings->currency_icon}}{{$totalMonthEarnings}}</p>
                                        <p>all: {{$settings->currency_icon}}{{$totalEarnings}}</p>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item sky" href="{{route('vendor.reviews.index')}}">
                                        <i class="fas fa-star"></i>
                                        <p>reviews</p>
                                        <p>all: {{$totalReviews}}</p>
                                        <p>avg rate: {{round($totalReviewsAvg, 2)}}/5</p>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item purple" href="{{route('vendor.products.index')}}">
                                        <i class="fas fa-list-ul"></i>
                                        <p>products</p>
                                        <p>Active: {{$totalActiveProducts}}</p>
                                        <p>InActive: {{$totalInactiveProducts}}</p>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
      DASHBOARD START
    ==============================-->
@endsection
