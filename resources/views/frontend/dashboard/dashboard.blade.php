@extends('frontend.dashboard.layouts.master')

@section('title')
    {{$settings->site_name}} || Dashboard
@endsection

@section('content')
<!--=============================
  DASHBOARD START
==============================-->
<section id="wsus__dashboard">
    <div class="container-fluid">
        @include('frontend.dashboard.layouts.sidebar')
        <div class="row">
            <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                <h2 class="mb-4">User Dashboard</h2>
                <div class="dashboard_content">
                    <div class="wsus__dashboard">
                        <div class="row">
                            <div class="col-xl-2 col-6 col-md-4">
                                <a class="wsus__dashboard_item red" href="{{route('user.orders')}}">
                                    <i class="fas fa-shopping-cart"></i>
                                    <p>orders</p>
                                    <h5 class="text-white">{{$totalOrdersCount}}</h5>
                                </a>
                            </div>
                            <div class="col-xl-2 col-6 col-md-4">
                                <a class="wsus__dashboard_item sky" href="{{route('user.review.index')}}">
                                    <i class="fas fa-star"></i>
                                    <p>reviews</p>
                                    <h5 class="text-white">{{$totalReviewsCount}}</h5>
                                </a>
                            </div>
                            <div class="col-xl-2 col-6 col-md-4">
                                <a class="wsus__dashboard_item blue" href="{{route('user.wishlist.index')}}">
                                    <i class="far fa-heart"></i>
                                    <p>wishlist</p>
                                    <h5 class="text-white">{{$totalWishlistCount}}</h5>
                                </a>
                            </div>
                            <div class="col-xl-2 col-6 col-md-4">
                                <a class="wsus__dashboard_item purple" href="{{route('user.address.index')}}">
                                    <i class="fal fa-map-marker-alt"></i>
                                    <p>addresses</p>
                                    <h5 class="text-white">{{$totalAddressesCount}}</h5>
                                </a>
                            </div>
                            <div class="col-xl-2 col-6 col-md-4">
                                <a class="wsus__dashboard_item orange" href="{{route('user.profile')}}">
                                    <i class="fas fa-user-shield"></i>
                                    <p class="pb-4">profile</p>
                                </a>
                            </div>
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
