@extends('frontend.dashboard.layouts.master')

@section('title')
    {{$settings->site_name}} || Vendor Request
@endsection

@section('content')
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include('frontend.dashboard.layouts.sidebar')
            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="fal fa-gift-card"></i>Become a Vendor Now!</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                            </div>
                        </div>
                        <br>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <form action="{{route('user.vendor-request.create')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="wsus__dash_pro_single">
                                        <label>Shop Banner*</label>
                                        <i class="fas fa-image"></i>
                                        <input name="banner" type="file">
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="wsus__dash_pro_single">
                                                <i class="fas fa-signature"></i>
                                                <input name="name" type="text" placeholder="Shop Name*">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="wsus__dash_pro_single">
                                                <i class="far fa-phone-alt"></i>
                                                <input name="phone" type="text" placeholder="Shop Phone*">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="wsus__dash_pro_single">
                                                <i class="fas fa-at"></i>
                                                <input name="email" type="email" placeholder="Shop Email*">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="wsus__dash_pro_single">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <input name="address" type="text" placeholder="Shop Address*">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wsus__dash_pro_single">
                                        <i class="fas fa-info-circle"></i>
                                        <textarea name="description" type="text" placeholder="Shop Description*"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="wsus__dash_pro_single">
                                                <i class="fab fa-facebook"></i>
                                                <input name="fb_link" type="text" placeholder="Facebook Link">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="wsus__dash_pro_single">
                                                <i class="fab fa-twitter"></i>
                                                <input name="tw_link" type="text" placeholder="Twitter Link">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="wsus__dash_pro_single">
                                                <i class="fab fa-instagram"></i>
                                                <input name="insta_link" type="text" placeholder="Instagram Link">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="common_btn">Submit Request</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush

