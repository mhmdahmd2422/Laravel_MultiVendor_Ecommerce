@extends('vendor.layouts.master')

@section('title')
    {{$settings->site_name}} || Store Profile
@endsection

@section('content')
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include('vendor.layouts.sidebar')
            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="far fa-user"></i>store profile</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <form action="{{route('vendor.shop-profile.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-xl-2 col-sm-6 col-md-6 mb-4">
                                        <div class="wsus__dash_pro_img">
                                            <img src="{{asset($vendor->banner)}}"  alt="img" class="img-fluid w-100">
                                            <input name="banner" type="file" class="form-control">
                                        </div>
                                    </div>
                                    <div class="wsus__dash_pro_single">
                                        <i class="fas fa-user-tie" aria-hidden="true"></i>
                                        <input name="name" type="text" class="form-control" value="{{$vendor->name}}">
                                    </div>
                                    <div class="wsus__dash_pro_single">
                                        <i class="far fa-phone-alt" aria-hidden="true"></i>
                                        <input name="phone" type="text" class="form-control phone-number" value="{{$vendor->phone}}">
                                    </div>
                                    <div class="form-group">
                                        <div class="wsus__dash_pro_single">
                                            <i class="fal fa-envelope-open" aria-hidden="true"></i>
                                            <input name="email" type="email" class="form-control" value="{{$vendor->email}}">
                                        </div>
                                        <div class="wsus__dash_pro_single">
                                            <i class="fas fa-map-marked-alt" aria-hidden="true"></i>
                                            <input name="address" type="text" class="form-control" value="{{$vendor->address}}">
                                        </div>
                                        <div class="wsus__dash_pro_single">
                                            <i class="fas fa-quote-left" aria-hidden="true"></i>
                                            <textarea name="description" class="summernote">{{$vendor->description}}</textarea>
                                        </div>
                                        <div class="wsus__dash_pro_single">
                                            <i class="fab fa-facebook-square" aria-hidden="true"></i>
                                            <input name="fb_url" type="text" class="form-control" value="{{$vendor->fb_link? : 'None'}}">
                                        </div>
                                        <div class="wsus__dash_pro_single">
                                            <i class="fab fa-twitter-square" aria-hidden="true"></i>
                                            <input name="tw_url" type="text" class="form-control" value="{{$vendor->tw_link? : 'None'}}">
                                        </div>
                                        <div class="wsus__dash_pro_single">
                                            <i class="fab fa-instagram" aria-hidden="true"></i>
                                            <input name="insta_url" type="text" class="form-control" value="{{$vendor->insta_link ? : 'None'}}">
                                        </div>
                                        <div class="wsus__dash_pro_single">
                                            <i class="fas fa-toggle-on" aria-hidden="true"></i>
                                            <select name="status" id="inputState" class="form-control">
                                                <option value="">Select</option>
                                                <option {{$vendor->status == 1 ? 'selected': ''}} value="1">Active</option>
                                                <option {{$vendor->status == 0 ? 'selected': ''}} value="0">Inactive</option>
                                            </select>                                        </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
