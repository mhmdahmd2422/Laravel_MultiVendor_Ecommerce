@extends('frontend.dashboard.layouts.master')

@section('content')
    <section id="wsus__dashboard">
        <div class="container-fluid">
    @include('frontend.dashboard.layouts.sidebar')
            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="fal fa-gift-card"></i>create address</h3>
                        <div class="wsus__dashboard_add wsus__add_address">
                            <form action="{{route('user.address.store')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-6 col-md-6">
                                        <div class="wsus__add_address_single">
                                            <label>address name</label>
                                            <input name="name" type="text" value="{{old('name')}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="wsus__add_address_single">
                                            <label>phone <b>*</b></label>
                                            <input name="phone" type="text" value="{{old('phone')}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="wsus__add_address_single">
                                            <label>country <b>*</b></label>
                                            <div class="wsus__topbar_select">
                                                <select class="select_2" name="country">
                                                    <option value="">Select</option>
                                                    @foreach($countries as $country_code => $country)
                                                        <option value="{{$country}}">{{$country}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="wsus__add_address_single">
                                            <label>City <b>*</b></label>
                                            <input name="city" type="text" value="{{old('city')}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="wsus__add_address_single">
                                            <label>zip code</label>
                                            <input name="zip_code" type="text" value="{{old('zip_code')}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="wsus__add_address_single">
                                            <label>address type <b>*</b></label>
                                            <div class="wsus__topbar_select">
                                                <select name="type" class="select_2">
                                                    <option value="">Select</option>
                                                    <option value="office">Office</option>
                                                    <option value="home">Home</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-md-12">
                                        <div class="wsus__add_address_single">
                                            <label>address <b>*</b></label>
                                            <input name="address" type="text" value="{{old('address')}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__add_address_single">
                                            <label>comment</label>
                                            <textarea name="comment" cols="3" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <button type="submit" class="common_btn">create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
